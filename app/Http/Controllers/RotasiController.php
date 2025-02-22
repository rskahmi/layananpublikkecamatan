<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DashboardRotasiEvent;
use App\Models\RotasiModel;
use App\Models\RiwayatRotasiModel;
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


class RotasiController extends Controller
{
    use CacheTimeout, RulesTraits;

    public function dashboard(){
        try {
            if (Auth::check()){
            // Grafik Bulanan
            $currentYear = Carbon::now()->year;
            $defaultMonth = range(1, 12);
            $dataRotasi = Cache::remember('grafik_rotasi_data', $this->time, function () use ($currentYear) {
                return RotasiModel::selectRaw('MONTH(created_at) as month, count(id) as total_rotasi')
                    ->whereYear('created_at', $currentYear)
                    ->groupByRaw('MONTH(created_at)')
                    ->get()
                    ->pluck('total_rotasi', 'month')
                    ->toArray();
            });
            $dataRotasi = array_replace(array_fill_keys($defaultMonth, 0), $dataRotasi);
            ksort($dataRotasi);
            $grafikRotasi = [];
            foreach ($dataRotasi as $month => $totalRotasi) {
                $grafikRotasi[] = [
                    'month' => $month,
                    'total_rotasi' => $totalRotasi,
                ];
            }


            $totalRotasi = Cache::remember('total_rotasi_in_dashboard', $this->time, function () use ($currentYear) {
            return RotasiModel::whereYear('created_at', $currentYear)->count();
            });

            $jumlahStatusProsesRotasi = Cache::remember('jumlah_rotasi_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                return RotasiModel::whereIn('status', ['proses'])
                    ->whereYear('created_at', $currentYear)
                    ->with('rotasi')
                    ->count();
            });
            $jumlahStatusTerimaRotasi = Cache::remember('status_terima_rotasi_in_dashboard', $this->time, function () use ($currentYear) {
                return RiwayatRotasiModel::where('status', 'diterima')
                    ->whereYear('created_at', $currentYear)
                    ->count();
            });

            return view('after-login.rotasi.dashboard')->with([
                'grafik_rotasi' => $grafikRotasi,
                'total_rotasi' => $totalRotasi,
                'jumlah_status_proses_rotasi' => $jumlahStatusProsesRotasi,
                'jumlah_status_selesai_rotasi'=> $jumlahStatusTerimaRotasi
            ]);
        } else {
            return redirect()->route('auth');
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
            $rotasiQuery = RotasiModel::with(['riwayat']);

            if ($role === 'avp-adm') {
                $rotasiQuery->whereHas('riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                });
            }

            if ($role === 'mgr-adm'){
                $rotasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-csr'){
                $rotasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-comrel'){
                $rotasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf4'){
                $rotasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf5'){
                $rotasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf6'){
                $rotasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                });
            }

            $rotasi = $rotasiQuery->orderBy('tanggal', 'desc')
                    ->get();

                return view('after-login.rotasi.pengajuan')
                    ->with([
                        'rotasi' => $rotasi
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

    public function store (Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'memoteo' => 'nullable|mimes:pdf,docx'
            ], [
                'memoteo.required' => $this->jenisSPDMessage(['pdf','docx'])
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert Berkas',
                            'text' => validatorError($validator->errors()->all())
                        ]
                    );
            }
            $filename = null;
            if ($request->hasFile('memoteo')) {
                $memoteo = $request->file('memoteo');
                $filename = time() . '-' . str_replace(' ', '-', $memoteo->getClientOriginalName());
                $memoteo->storeAs('public/rotasi', $filename);
            }

            $tanggal = now();
            $statusDef = 'proses';

            $rotasi = RotasiModel::create([
                'memoteo' => $filename,
                'tanggal' => $tanggal,
                'status' => $statusDef,
                'user_id' => auth()->user()->id
            ]);

            $riwayatRotasi = RiwayatRotasiModel::create([
                'status' => $statusDef,
                'rotasi_id' => $rotasi->id,
                'user_id' => auth()->user()->id,
                'tindakan' => 1,
                'peninjau' => 'am'
            ]);

            $data = [
                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                'jenis' => "Rotasi"
            ];
            $email_target = 'riskyahmad0506@gmail.com';
            Mail::to($email_target)->send(new SendEmail($data));
            event(new DashboardRotasiEvent($rotasi));
            $this->forgetBerkas();


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

    public function update (Request $request, $id){
        try {
            $rotasi = RotasiModel::findOrFail($id);
            if ($request->hasFile('edtmemoteo')) {
                $edtmemoteo = $request->file('edtmemoteo');
                $filename = time() . '-' . str_replace(' ', '-', $edtmemoteo->getClientOriginalName());
                $edtmemoteo->storeAs('public/rotasi', $filename);
                if ($rotasi->memoteo) {
                    Storage::disk('public')->delete('rotasi/' . $rotasi->memoteo);
                }
                $data['memoteo'] = $filename;
            }


            $rotasi->update($data);
            $this->forgetRotasi();
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
        catch (Exception $e) {
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

    public function destroy (Request $request, $id){
        try {


        $rotasi = RotasiModel::findOrFail($id);
            if (!$rotasi) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Delete Berkas',
                    'text' => 'Data tidak ditemukan!'
                ]);
            }

            $imagePath = 'public/rotasi/' . $rotasi->lampiran;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            event(new DashboardRotasiEvent([
                'deleted_at' => time()
            ]));
            $rotasi->delete();
            $this->forgetBerkas();
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Delete Berkas',
                        'text' => 'Data berhasil dihapus!'
                    ]
                );
    }
    catch (Exception $e) {
        return redirect()->back()
            ->with(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'Delete Berkas',
                    'text' => $e->getMessage()
                ]
            );
    }

}

public function getDetailPengajuan($id){
    try {
        $rotasi = RotasiModel::with(['riwayat'])->findOrFail($id);
            if ($rotasi !== null) {
                $riwayat_rotasi = RiwayatRotasiModel::with('user')->where('rotasi_id', $rotasi->id)->orderBy('created_at', 'desc')->get();

                return view('after-login.rotasi.detail')->with([
                    'rotasi' => $rotasi,
                    'riwayat_rotasi' => $riwayat_rotasi
                ]);
            } else {
                return view('after-login.rotasi.detail')->with([
                    'rotasi' => $rotasi
                ]);
            }
    }
    catch (Exception $e) {
        return redirect()->back()->with(
            'alert',
            [
                'type' => 'error',
                'title' => 'Detail Pengajuan',
                'text' => $e->getMessage()
            ]
        );
    }
}

    public function verifikasi (Request $request, $id){
        try {
            $rotasi = RotasiModel::with(['riwayat'])->first();
            $lastOfRiwayat = $rotasi->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'rotasi_id' => $rotasi->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan
                ];
            $statusRotasi = null;

            if (isMgrAdmSection($lastOfRiwayat)){
                if ($request->verifikasi === 'review'){
                    $dataRiwayat['status'] = 'proses';
                    $statusRotasi = 'proses';
                    $dataRiwayat['peninjau'] = $request->peninjau;
                    $dataRiwayat['tindakan'] = 1;

                    if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Rotasi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Rotasi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Rotasi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Rotasi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Rotasi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusRotasi = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'avp-adm';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!",
                        'jenis' => "Rotasi"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isStaffSection($lastOfRiwayat)){
                if ($request->verifikasi === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusRotasi = $request->verifikasi;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Rotasi"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));

                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusRotasi = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'avp-adm';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!",
                        'jenis' => "Rotasi"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isAVPAdmSection($lastOfRiwayat)){
                $dataRiwayat['status'] = 'proses';
                $statusRotasi = 'proses';
                $dataRiwayat['peninjau'] = 'mgr-adm';
                $dataRiwayat['tindakan'] = 1;

                $data = [
                    'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                    'jenis' => "Rotasi"
                ];
                $email_target = 'riskyahmad0506@gmail.com';
                Mail::to($email_target)->send(new SendEmail($data));
            }


            $rotasi->update([
                'status' => $statusRotasi
            ]);
            $riwayat = RiwayatRotasiModel::create($dataRiwayat);

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
