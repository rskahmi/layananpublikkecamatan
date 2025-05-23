<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengaduanModel;
use App\Models\RiwayatPengaduanModel;
use App\Traits\RulesTraits;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Traits\CacheTimeout;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Exception;
use App\Events\DashboardPengaduanEvent;

class PengaduanController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function dashboard(){
        try {
            if (Auth::check()){
                $currentYear = Carbon::now()->year;
                $defaultMonth = range(1, 12);
                $dataPengaduan = Cache::remember('grafik_pengaduan_data', $this->time, function () use ($currentYear) {
                    return PengaduanModel::selectRaw('MONTH(created_at) as month, count(id) as total_pengaduan')
                        ->whereYear('created_at', $currentYear)
                        ->groupByRaw('MONTH(created_at)')
                        ->get()
                        ->pluck('total_pengaduan', 'month')
                        ->toArray();
                });
                $dataPengaduan = array_replace(array_fill_keys($defaultMonth, 0), $dataPengaduan);
                ksort($dataPengaduan);
                $grafikPengaduan = [];
                foreach ($dataPengaduan as $month => $totalPengaduan) {
                    $grafikPengaduan[] = [
                        'month' => $month,
                        'total_pengaduan' => $totalPengaduan,
                    ];
                }

                $totalPengaduan = Cache::remember('total_pengaduan_in_dashboard', $this->time, function () use ($currentYear) {
                    return PengaduanModel::whereYear('created_at', $currentYear)->count();
                });

                $jumlahStatusProsesPengaduan = Cache::remember('jumlah_pengaduan_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatPengaduanModel::where('status', 'proses')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });
                $jumlahStatusTerimaPengaduan = Cache::remember('status_terima_pengaduan_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatPengaduanModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                $jumlahStatusTolakPengaduan = Cache::remember('jumlah_pengaduan_ditolak_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatPengaduanModel::where('status', 'ditolak')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                return view('after-login.pengaduan.dashboard')->with([
                    'grafik_pengaduan' => $grafikPengaduan,
                    'total_pengaduan' => $totalPengaduan,
                    'jumlah_status_proses_pengaduan' => $jumlahStatusProsesPengaduan,
                    'jumlah_status_selesai_pengaduan'=> $jumlahStatusTerimaPengaduan,
                    'jumlah_status_tolak_pengaduan'=> $jumlahStatusTolakPengaduan
                ]);
            }
        }
        catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Dashboard Pengajuan',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }
    public function showPengajuan(){
        try {
            if (!auth()->check()) {
                return redirect()->route('login')->with('alert', [
                    'type' => 'warning',
                    'title' => 'Unauthorized',
                    'text' => 'Anda harus login untuk mengakses halaman ini.'
                ]);
            }
            $userId = auth()->user()->id;
            $role = auth()->user()->role;

            $pengaduanQuery = PengaduanModel::with(['riwayat']);

            if ($role === 'masyarakat') {
                $pengaduanQuery->whereHas('riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                });
            }
            if ($role === 'sekretariscamat'){
                $pengaduanQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'sekretariscamat')->where('tindakan', 1);
                });
            }
            if ($role === 'kepalaseksi'){
                $pengaduanQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'kepalaseksi')->where('tindakan', 1);
                });
            }

            $pengaduan = $pengaduanQuery->orderBy('tanggal', 'desc')
                ->get();
                return view('after-login.pengaduan.pengajuan')
                    ->with([
                        'pengaduan' => $pengaduan
                    ]);
        }
        catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show Pengajuan',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'deskripsi' => 'required',
                'bukti' => 'required|mimes:jpeg,png,jpg'
            ], [
                'deskripsi.required' => $this->requiredMessage('deskripsi'),
                'bukti.required' => $this->requiredMessage('bukti'),
                'bukti.mimes' => $this->fileMessage(['jpeg', 'png', 'jpg'])
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert Data Pengaduan',
                            'text' => validatorError($validator->errors()->all())
                        ]
                    );
            }
            $bukti = $request->file('bukti');
            $filename = time() . '-' . str_replace(' ', '-', $bukti->getClientOriginalName());

            $tanggal = now();
            $statusDef = 'diajukan';
            $pengaduan = PengaduanModel::create([
                'deskripsi' => $request->deskripsi,
                'bukti' => $filename,
                'tanggal' => $tanggal,
                'status' => $statusDef,
                'user_id' => auth()->user()->id
            ]);
            if ($pengaduan){
                event(new DashboardPengaduanEvent($pengaduan));
                $bukti->storeAs('public/images/pengaduan', $filename);
                $this->forgetMedia();
            }

            $riwayatPengaduan = RiwayatPengaduanModel::create([
                'status' => $statusDef,
                'pengaduan_id' => $pengaduan->id,
                'user_id' => auth()->user()->id,
                'tindakan' => 1,
                'peninjau' => 'sekretariscamat'
            ]);
            event(new DashboardPengaduanEvent($pengaduan));
            $this->forgetPengaduan();


            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Insert Berkas',
                        'text' => 'Data berhasil ditambahkan!'
                    ]
                );
        }
        catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Insert Berkas',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function update(Request $request, $id){
        try{
            $pengaduan = PengaduanModel::findOrFail($id);
            $data = [
                'deskripsi' => $request->edtdeskripsi
            ];
            if ($request->has('edtbukti')){
                $bukti = $request->file('edtbukti');
                $filename = time() . '-' . str_replace(' ', '-', $bukti->getClientOriginalName());
                $bukti->storeAs('public/images/pengaduan', $filename);

                if ($pengaduan->bukti) {
                    Storage::disk('public')->delete('images/pengaduan/' . $pengaduan->bukti);
                }

                $data['bukti'] = $filename;
            }
            $pengaduan->update($data);
            $this->forgetSPD();
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update Berkas',
                        'text' => 'Data berhasil diperbarui!'
                    ]
                );
        }
        Catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update Berkas',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function getDetailPengajuan($id){
        $pengaduan = PengaduanModel::with(['riwayat'])->findOrFail($id);
        if ($pengaduan !== null){
            $riwayat_pengaduan = RiwayatPengaduanModel::with('user')->where('pengaduan_id', $pengaduan->id)->orderBy('created_at', 'desc')->get();
            return view('after-login.pengaduan.detail')->with([
                'pengaduan' => $pengaduan,
                'riwayat_pengaduan' => $riwayat_pengaduan
            ]);
        } else {
            return view('after-login.pengaduan.detail')->with([
                'pengaduan' => $pengaduan
            ]);
        }
    }

    public function verifikasi(Request $request, $id){
        try {
            $pengaduan = PengaduanModel::with(['riwayat'])->first();
            $lastOfRiwayat = $pengaduan->riwayat->sortBy('created_at')->last();
            $dataRiwayat = [
                'pengaduan_id' => $pengaduan->id,
                'user_id' =>auth()->user()->id,
                'alasan' => $request->keterangan
            ];
            $statusPengaduan = null;
            if (isSekretarisCamatSection($lastOfRiwayat)){
                if (isset($request->verifikasi) && $request->verifikasi === 'ditolak'){
                    if (isset($lastOfRiwayat->user_id)){
                        $dataRiwayat['status'] = $request->verifikasi;
                        $dataRiwayat['peninjau'] = 'masyarakat';
                        $dataRiwayat['tindakan'] = 1;
                        $statusPengaduan = $request->verifikasi;
                    } else {
                        throw new Exception('User ID not found for this Riwayat');
                    }
                }
                else if ($request->verifikasi === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusPengaduan = $request->verifikasi;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;
                }
                else if ($request->verifikasi === 'serahkan'){
                    $dataRiwayat['status'] = 'proses';
                    $statusPengaduan = 'proses';
                    $dataRiwayat['peninjau'] = 'kepalaseksi';
                    $dataRiwayat['tindakan'] = 1;
                }
            }

            else if (isKepalaSeksiSection($lastOfRiwayat)){
                if($request->verifikasi === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusPengaduan = $request->verifikasi;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;
                }
            }
            $pengaduan->update([
                'status' => $statusPengaduan
            ]);
            $riwayat = RiwayatPengaduanModel::create($dataRiwayat);
            $this->forgetNPP();
                return redirect()->back()->with('alert', [
                    'type' => 'success',
                    'title' => 'Verifikasi',
                    'text' => 'Berhasil verifikasi berkas'
                ]);
        }
        catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Verifikasi',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }
}
