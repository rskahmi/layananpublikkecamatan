<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DashboardSPDLEvent;
use App\Models\SPDLModel;
use App\Models\RiwayatSPDLModel;
use App\Traits\RulesTraits;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Traits\CacheTimeout;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class SPDLController extends Controller
{
    use CacheTimeout, RulesTraits;


    public function dashboard(){
        try {
            if (Auth::check()){
            // Grafik Bulanan
            $currentYear = Carbon::now()->year;
            $defaultMonth = range(1, 12);
            $dataSPDL = Cache::remember('grafik_spdl_data', $this->time, function () use ($currentYear) {
                return SPDLModel::selectRaw('MONTH(created_at) as month, count(id) as total_spdl')
                    ->whereYear('created_at', $currentYear)
                    ->groupByRaw('MONTH(created_at)')
                    ->get()
                    ->pluck('total_spdl', 'month')
                    ->toArray();
            });
            $dataSPDL = array_replace(array_fill_keys($defaultMonth, 0), $dataSPDL);
            ksort($dataSPDL);
            $grafikSPDL = [];
            foreach ($dataSPDL as $month => $totalSPDL) {
                $grafikSPDL[] = [
                    'month' => $month,
                    'total_spdl' => $totalSPDL,
                ];
            }


            $totalSPDL = Cache::remember('total_spdl_in_dashboard', $this->time, function () use ($currentYear) {
            return SPDLModel::whereYear('created_at', $currentYear)->count();
            });

            $jumlahStatusProsesSPDL = Cache::remember('jumlah_spdl_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                return SPDLModel::whereIn('status', ['proses'])
                    ->whereYear('created_at', $currentYear)
                    ->with('spdl')
                    ->count();
            });
            $jumlahStatusTerimaSPDL = Cache::remember('status_terima_spdl_in_dashboard', $this->time, function () use ($currentYear) {
                return RiwayatSPDLModel::where('status', 'diterima')
                    ->whereYear('created_at', $currentYear)
                    ->count();
            });

            return view('after-login.spdl.dashboard')->with([
                'grafik_spdl' => $grafikSPDL,
                'total_spdl' => $totalSPDL,
                'jumlah_status_proses_spdl' => $jumlahStatusProsesSPDL,
                'jumlah_status_selesai_spdl'=> $jumlahStatusTerimaSPDL
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
        $spdlQuery = SPDLModel::with(['riwayat']);


        if ($role === 'admin') {
            $spdlQuery->whereHas('riwayat', function ($query) use ($userId) {
                $query->where('user_id', $userId)->where('tindakan', 1);
            });
        }

        if ($role === 'am'){
            $spdlQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'am')->where('tindakan', 1);
            });
        }

        if ($role === 'admin-csr'){
            $spdlQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
            });
        }

        if ($role === 'admin-comrel'){
            $spdlQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
            });
        }

        if ($role === 'admin-staf4'){
            $spdlQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
            });
        }

        if ($role === 'admin-staf5'){
            $spdlQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
            });
        }

        if ($role === 'admin-staf6'){
            $spdlQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
            });
        }

        if ($role === 'mgr-adm'){
            $spdlQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
            });
        }

        if ($role === 'avp-adm'){
            $spdlQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'avp-adm')->where('tindakan', 1);
            });
        }

        $spdl = $spdlQuery->orderBy('tanggal', 'desc')
                    ->get();

                return view('after-login.spdl.pengajuan')
                    ->with([
                        'spdl' => $spdl
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
                $lampiran->storeAs('public/spdl', $filename);
            }

            $tanggal = now();
            $statusDef = 'diajukan';

            $spdl = SPDLModel::create([
                'tanggalberangkat' => $request->tanggalberangkat,
                'tanggalpulang' => $request->tanggalpulang,
                'tujuan' => $request->tujuan,
                'lampiran' => $filename,
                'tanggal' => $tanggal,
                'status' => $statusDef,
                'user_id' => auth()->user()->id
            ]);

            $riwayatSPDL = RiwayatSPDLModel::create([
                'status' => $statusDef,
                'spdl_id' => $spdl->id,
                'user_id' => auth()->user()->id,
                'tindakan' => 1,
                'peninjau' => 'am'
            ]);

            $data = [
                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                'jenis' => "SPDL"
            ];
            $email_target = 'riskyahmad0506@gmail.com';
            Mail::to($email_target)->send(new SendEmail($data));

            event(new DashboardSPDLEvent($spdl));
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
            $spdl = SPDLModel::findOrFail($id);

            $data = [
                'tanggalberangkat' => $request->edttanggalberangkat,
                'tanggalpulang' => $request->edttanggalpulang,
                'tujuan' => $request->edttujuan,
            ];

            if ($request->hasFile('edtlampiran')) {
                $edtlampiran = $request->file('edtlampiran');
                $filename = time() . '-' . str_replace(' ', '-', $edtlampiran->getClientOriginalName());
                $edtlampiran->storeAs('public/spdl', $filename);
                if ($spdl->lampiran) {
                    Storage::disk('public')->delete('spdl/' . $spdl->lampiran);
                }
                $data['lampiran'] = $filename;
            }

            $spdl->update($data);
            $this->forgetSPDL();
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update SPDL',
                        'text' => 'Data berhasil diubah!'
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
            $spdl = SPDLModel::findOrFail($id);

                if (!$spdl) {
                    return redirect()->back->with('alert', [
                        'type' => 'error',
                        'title' => 'Delete Berkas',
                        'text' => 'Data tidak ditemukan!'
                    ]);
                }

                $imagePath = 'public/spdl/' . $spdl->lampiran;
                if (File::exists($imagePath)){
                    File::delete($imagePath);
                }

                event(new DashboardSPDLEvent ([
                    'delete_at' => time()
                ]));

                $spdl->delete();

                $this->forgetSPDL();

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
            $spdl = SPDLModel::with(['riwayat'])->findOrFail($id);
            if ($spdl !== null) {
                $riwayat_spdl = RiwayatSPDLModel::with('user')->where('spdl_id', $spdl->id)->orderBy('created_at', 'desc')->get();

                return view('after-login.spdl.detail')->with([
                    'spdl' => $spdl,
                    'riwayat_spdl' => $riwayat_spdl
                ]);
            } else {
                return view('after-login.spdl.detail')->with([
                    'spdl' => $spdl
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
            $spdl = SPDLModel::with(['riwayat'])->first();
            $lastOfRiwayat = $spdl->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'spdl_id' => $spdl->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan
                ];
            $statusSPDL = null;
            if (isManagerSection($lastOfRiwayat)){
                if (isset($request->verifikasi) && $request->verifikasi === 'ditolak') {
                    if (isset($lastOfRiwayat->user_id)) {
                        $dataRiwayat['status'] = $request->verifikasi;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;
                        $statusSPDL = $request->verifikasi;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'SPDL',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    } else {
                        // Tangani kasus jika user_id tidak ditemukan
                        throw new Exception('User ID not found for this Riwayat');
                    }
                }
                else if ($request->verifikasi === 'review'){
                    $dataRiwayat['status'] = 'proses';
                    $statusSPDL = 'proses';
                    $dataRiwayat['peninjau'] = $request->peninjau;
                    $dataRiwayat['tindakan'] = 1;

                    if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "SPDL"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "SPDL"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "SPDL"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "SPDL"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "SPDL"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                }
            }

            else if (isStaffSection($lastOfRiwayat)){
                if ($request->verifikasi === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusSPDL = 'proses';
                    $dataRiwayat['peninjau'] = 'mgr-adm';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "SPDL"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusSPDL = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'admin';
                    $dataRiwayat['tindakan'] = 1;

                    $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'SPDL',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isMgrAdmSection($lastOfRiwayat)){
                if ($request->verifikasi === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusSPDL = 'proses';
                    $dataRiwayat['peninjau'] = 'avp-adm';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "SPDL"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusSPDL = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'admin';
                    $dataRiwayat['tindakan'] = 1;

                    $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'UMD',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isAVPAdmSection($lastOfRiwayat)){
                if ($request->verifikasi === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusSPDL = $request->verifikasi;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "SPDL"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statusSPDL = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'admin';
                    $dataRiwayat['tindakan'] = 1;

                    $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'UMD',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isUserSection($lastOfRiwayat)){
                $dataRiwayat['status'] = 'proses';
                $statusSPDL = 'proses';
                $dataRiwayat['peninjau'] = 'am';
                $dataRiwayat['tindakan'] = 1;

                $data = [
                    'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                    'jenis' => "SPDL"
                ];
                $email_target = 'riskyahmad0506@gmail.com';
                Mail::to($email_target)->send(new SendEmail($data));
            }

            $spdl->update([
                'status' =>$statusSPDL
            ]);
            $riwayat = RiwayatSPDLModel::create($dataRiwayat);

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
