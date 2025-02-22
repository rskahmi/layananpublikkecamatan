<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DashboardMutasiEvent;
use App\Models\MutasiModel;
use App\Models\RiwayatMutasiModel;
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

class MutasiController extends Controller
{
    use CacheTimeout, RulesTraits;

    public function dashboard(){
        try {
            if (Auth::check()){
            // Grafik Bulanan
            $currentYear = Carbon::now()->year;
            $defaultMonth = range(1, 12);
            $dataMutasi = Cache::remember('grafik_mutasi_data', $this->time, function () use ($currentYear) {
                return MutasiModel::selectRaw('MONTH(created_at) as month, count(id) as total_mutasi')
                    ->whereYear('created_at', $currentYear)
                    ->groupByRaw('MONTH(created_at)')
                    ->get()
                    ->pluck('total_mutasi', 'month')
                    ->toArray();
            });
            $dataMutasi = array_replace(array_fill_keys($defaultMonth, 0), $dataMutasi);
            ksort($dataMutasi);
            $grafikMutasi = [];
            foreach ($dataMutasi as $month => $totalMutasi) {
                $grafikMutasi[] = [
                    'month' => $month,
                    'total_mutasi' => $totalMutasi,
                ];
            }


            $totalMutasi = Cache::remember('total_mutasi_in_dashboard', $this->time, function () use ($currentYear) {
            return MutasiModel::whereYear('created_at', $currentYear)->count();
            });

            $jumlahStatusProsesMutasi = Cache::remember('jumlah_mutasi_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                return MutasiModel::whereIn('status', ['proses'])
                    ->whereYear('created_at', $currentYear)
                    ->with('mutasi')
                    ->count();
            });
            $jumlahStatusTerimaMutasi = Cache::remember('status_terima_mutasi_in_dashboard', $this->time, function () use ($currentYear) {
                return RiwayatMutasiModel::where('status', 'diterima')
                    ->whereYear('created_at', $currentYear)
                    ->count();
            });

            return view('after-login.mutasi.dashboard')->with([
                'grafik_mutasi' => $grafikMutasi,
                'total_mutasi' => $totalMutasi,
                'jumlah_status_proses_mutasi' => $jumlahStatusProsesMutasi,
                'jumlah_status_selesai_mutasi'=> $jumlahStatusTerimaMutasi
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
            $mutasiQuery = MutasiModel::with(['riwayat']);

            if ($role === 'avp-adm') {
                $mutasiQuery->whereHas('riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                });
            }

            if ($role === 'mgr-adm'){
                $mutasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-csr'){
                $mutasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf4'){
                $mutasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf5'){
                $mutasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf6'){
                $mutasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-comrel'){
                $mutasiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                });
            }

            $mutasi = $mutasiQuery->orderBy('tanggal', 'desc')
                    ->get();

                return view('after-login.mutasi.pengajuan')
                    ->with([
                        'mutasi' => $mutasi
                    ]);
        } catch (Exception $e) {
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

    public function store (Request $request) {
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
                $memoteo->storeAs('public/mutasi', $filename);
            }

            $tanggal = now();
            $statusDef = 'proses';
            $mutasi = MutasiModel::create([
                'memoteo' => $filename,
                'tanggal' => $tanggal,
                'status' => $statusDef,
                'user_id' => auth()->user()->id
            ]);
            $riwayatMutasi = RiwayatMutasiModel::create([
                'status' => $statusDef,
                'mutasi_id' => $mutasi->id,
                'user_id' => auth()->user()->id,
                'tindakan' => 1,
                'peninjau' => 'am'
            ]);

            $data = [
                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                'jenis' => "Mutasi"
            ];
            $email_target = 'riskyahmad0506@gmail.com';
            Mail::to($email_target)->send(new SendEmail($data));

            event(new DashboardMutasiEvent($mutasi));
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
        } catch (Exception $e) {
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
            $mutasi = MutasiModel::findOrFail($id);
            if ($request->hasFile('edtmemoteo')) {
                $edtmemoteo = $request->file('edtmemoteo');
                $filename = time() . '-' . str_replace(' ', '-', $edtmemoteo->getClientOriginalName());
                $edtmemoteo->storeAs('public/mutasi', $filename);
                if ($mutasi->memoteo) {
                    Storage::disk('public')->delete('mutasi/' . $mutasi->memoteo);
                }
                $data['memoteo'] = $filename;
            }


            $mutasi->update($data);
            $this->forgetMutasi();
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


        $mutasi = MutasiModel::findOrFail($id);
            if (!$mutasi) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Delete Berkas',
                    'text' => 'Data tidak ditemukan!'
                ]);
            }

            $imagePath = 'public/mutasi/' . $mutasi->lampiran;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            event(new DashboardMutasiEvent([
                'deleted_at' => time()
            ]));
            $mutasi->delete();
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
            $mutasi = MutasiModel::with(['riwayat'])->findOrFail($id);
                if ($mutasi !== null) {
                    $riwayat_mutasi = RiwayatMutasiModel::with('user')->where('mutasi_id', $mutasi->id)->orderBy('created_at', 'desc')->get();

                    return view('after-login.mutasi.detail')->with([
                        'mutasi' => $mutasi,
                        'riwayat_mutasi' => $riwayat_mutasi
                    ]);
                } else {
                    return view('after-login.mutasi.detail')->with([
                        'mutasi' => $mutasi
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
            $mutasi = MutasiModel::with(['riwayat'])->first();
            $lastOfRiwayat = $mutasi->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'mutasi_id' => $mutasi->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan
                ];
            $statusmutasi = null;

            if (isMgrAdmSection($lastOfRiwayat)){
                if ($request->verifikasi === 'review'){
                    $dataRiwayat['status'] = 'proses';
                    $statusmutasi = 'proses';
                    $dataRiwayat['peninjau'] = $request->peninjau;
                    $dataRiwayat['tindakan'] = 1;

                    if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Mutasi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Mutasi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Mutasi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Mutasi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Mutasi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusmutasi = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'avp-adm';
                    $dataRiwayat['tindakan'] = 1;
                    $data = [
                        'text' => "Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!",
                        'jenis' => "Mutasi"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isStaffSection($lastOfRiwayat)){
                if ($request->verifikasi === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusmutasi = $request->verifikasi;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;
                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Mutasi"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusmutasi = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'avp-adm';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!",
                        'jenis' => "Mutasi"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isAVPAdmSection($lastOfRiwayat)){
                $dataRiwayat['status'] = 'proses';
                $statusmutasi = 'proses';
                $dataRiwayat['peninjau'] = 'mgr-adm';
                $dataRiwayat['tindakan'] = 1;

                $data = [
                    'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                    'jenis' => "Mutasi"
                ];
                $email_target = 'riskyahmad0506@gmail.com';
                Mail::to($email_target)->send(new SendEmail($data));
            }


            $mutasi->update([
                'status' => $statusmutasi
            ]);
            $riwayat = RiwayatMutasiModel::create($dataRiwayat);

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
