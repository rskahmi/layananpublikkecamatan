<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DashboardSPDEvent;
use App\Models\SPDModel;
use App\Models\RiwayatSPDModel;
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


class SPDController extends Controller
{
    use CacheTimeout, RulesTraits;

    public function dashboard(){
        try {
            if (Auth::check()){
            // Grafik Bulanan
            $currentYear = Carbon::now()->year;
            $defaultMonth = range(1, 12);
            $dataSPD = Cache::remember('grafik_spd_data', $this->time, function () use ($currentYear) {
                return SPDModel::selectRaw('MONTH(created_at) as month, count(id) as total_spd')
                    ->whereYear('created_at', $currentYear)
                    ->groupByRaw('MONTH(created_at)')
                    ->get()
                    ->pluck('total_spd', 'month')
                    ->toArray();
            });
            $dataSPD = array_replace(array_fill_keys($defaultMonth, 0), $dataSPD);
            ksort($dataSPD);
            $grafikSPD = [];
            foreach ($dataSPD as $month => $totalSPD) {
                $grafikSPD[] = [
                    'month' => $month,
                    'total_spd' => $totalSPD,
                ];
            }


            $totalSPD = Cache::remember('total_spd_in_dashboard', $this->time, function () use ($currentYear) {
            return SPDModel::whereYear('created_at', $currentYear)->count();
            });

            $jumlahStatusProsesSPD = Cache::remember('jumlah_spd_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                return SPDModel::whereIn('status', ['proses'])
                    ->whereYear('created_at', $currentYear)
                    ->with('spd')
                    ->count();
            });
            $jumlahStatusTerimaSPD = Cache::remember('status_terima_spd_in_dashboard', $this->time, function () use ($currentYear) {
                return RiwayatSPDModel::where('status', 'diterima')
                    ->whereYear('created_at', $currentYear)
                    ->count();
            });

            return view('after-login.spd.dashboard')->with([
                'grafik_spd' => $grafikSPD,
                'total_spd' => $totalSPD,
                'jumlah_status_proses_spd' => $jumlahStatusProsesSPD,
                'jumlah_status_selesai_spd'=> $jumlahStatusTerimaSPD
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
            $spdQuery = SPDModel::with(['riwayat']);

            if ($role === 'admin') {
                $spdQuery->whereHas('riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                });
            }

            if ($role === 'am'){
                $spdQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'am')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-csr'){
                $spdQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-comrel'){
                $spdQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf4'){
                $spdQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf5'){
                $spdQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf6'){
                $spdQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                });
            }

            if ($role === 'mgr-adm'){
                $spdQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                });
            }

            if ($role === 'avp-adm'){
                $spdQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'avp-adm')->where('tindakan', 1);
                });
            }

            $spd = $spdQuery->orderBy('tanggal', 'desc')
                    ->get();

                return view('after-login.spd.pengajuan')
                    ->with([
                        'spd' => $spd
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
                'tanggalberangkat' => 'required|date',
                'tanggalpulang' => 'required|date',
                'tujuan' => 'required',
                'lampiran' => 'nullable|mimes:pdf,docx'
            ], [
                'tanggalberangkat.required' => $this->jenisSPDMessage(),
                'tanggalpulang.required' => $this->jenisSPDMessage(),
                'tujuan.required' => $this->jenisSPDMessage(),
                'lampiran.required' => $this->jenisSPDMessage(['pdf','docx'])
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

            if ($request->hasFile('lampiran')) {
                $lampiran = $request->file('lampiran');
                $filename = time() . '-' . str_replace(' ', '-', $lampiran->getClientOriginalName());
                $lampiran->storeAs('public/spd', $filename);
            }

            $tanggal = now();
            $statusDef = 'diajukan';

            $spd = SPDModel::create([
                'tanggalberangkat' => $request->tanggalberangkat,
                'tanggalpulang' => $request->tanggalpulang,
                'tujuan' => $request->tujuan,
                'lampiran' => $filename,
                'tanggal' => $tanggal,
                'status' => $statusDef,
                'user_id' => auth()->user()->id
            ]);

            $riwayatSPD = RiwayatSPDModel::create([
                'status' => $statusDef,
                'spd_id' => $spd->id,
                'user_id' => auth()->user()->id,
                'tindakan' => 1,
                'peninjau' => 'am'
            ]);

            $data = [
                'text' => "Pengajuan Baru Masuk",
                'jenis' => "SPD",
            ];
            $email_target = 'riskyahmad0506@gmail.com';
            Mail::to($email_target)->send(new SendEmail($data));

            event(new DashboardSPDEvent($spd));
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

    public function update(Request $request, $id){
        try {
            $spd = SPDModel::findOrFail($id);

            $data = [
                'tanggalberangkat' => $request->edttanggalberangkat,
                'tanggalpulang' => $request->edttanggalpulang,
                'tujuan' => $request->edttujuan,
            ];

            if ($request->hasFile('edtlampiran')) {
                $edtlampiran = $request->file('edtlampiran');
                $filename = time() . '-' . str_replace(' ', '-', $edtlampiran->getClientOriginalName());
                $edtlampiran->storeAs('public/spd', $filename);
                if ($spd->lampiran) {
                    Storage::disk('public')->delete('spd/' . $spd->lampiran);
                }
                $data['lampiran'] = $filename;
            }
            $spd->update($data);
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
        }catch (Exception $e) {
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
            $spd = SPDModel::findOrFail($id);
            if (!$spd) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Delete Berkas',
                    'text' => 'Data tidak ditemukan!'
                ]);
            }

            $imagePath = 'public/spd/' . $spd->lampiran;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            event(new DashboardSPDEvent([
                'deleted_at' => time()
            ]));

            $spd->delete();

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
            $spd = SPDModel::with(['riwayat'])->findOrFail($id);
            if ($spd !== null) {
                $riwayat_spd = RiwayatSPDModel::with('user')->where('spd_id', $spd->id)->orderBy('created_at', 'desc')->get();

                return view('after-login.spd.detail')->with([
                    'spd' => $spd,
                    'riwayat_spd' => $riwayat_spd
                ]);
            } else {
                return view('after-login.spd.detail')->with([
                    'spd' => $spd
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

    public function verifikasi(Request  $request, $id){
        try {
            $spd = SPDModel::with(['riwayat'])->first();
            $lastOfRiwayat = $spd->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'spd_id' => $spd->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan
                ];
            $statusSPD = null;
            if (isManagerSection($lastOfRiwayat)){
                if (isset($request->verifikasi) && $request->verifikasi === 'ditolak') {
                    if (isset($lastOfRiwayat->user_id)) {
                        $dataRiwayat['status'] = $request->verifikasi;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;
                        $statusSPD = $request->verifikasi;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'SPD',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    } else {
                        // Tangani kasus jika user_id tidak ditemukan
                        throw new Exception('User ID not found for this Riwayat');
                    }
                }
                else if ($request->verifikasi === 'review'){
                    $dataRiwayat['status'] = 'proses';
                    $statusSPD = 'proses';
                    $dataRiwayat['peninjau'] = $request->peninjau;
                    $dataRiwayat['tindakan'] = 1;

                    if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "SPD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "SPD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "SPD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "SPD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "SPD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                }
            }

            else if (isStaffSection($lastOfRiwayat)){
                if ($request->verifikasi === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusSPD = 'proses';
                    $dataRiwayat['peninjau'] = 'mgr-adm';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "SPD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusSPD = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'admin';
                    $dataRiwayat['tindakan'] = 1;

                    $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'SPD',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isMgrAdmSection($lastOfRiwayat)){
                if ($request->verifikasi === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusSPD = 'proses';
                    $dataRiwayat['peninjau'] = 'avp-adm';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "SPD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusSPD = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'admin';
                    $dataRiwayat['tindakan'] = 1;

                    $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Reimburstment',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isAVPAdmSection($lastOfRiwayat)){
                if ($request->verifikasi === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusSPD = $request->verifikasi;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "SPD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusSPD = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'admin';
                    $dataRiwayat['tindakan'] = 1;

                    $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'SPD',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isUserSection($lastOfRiwayat)){
                $dataRiwayat['status'] = 'proses';
                $statusSPD = 'proses';
                $dataRiwayat['peninjau'] = 'am';
                $dataRiwayat['tindakan'] = 1;

                $data = [
                    'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                    'jenis' => "SPD"
                ];
                $email_target = 'riskyahmad0506@gmail.com';
                Mail::to($email_target)->send(new SendEmail($data));
            }

            $spd->update([
                'status' =>$statusSPD
            ]);
            $riwayat = RiwayatSPDModel::create($dataRiwayat);

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
