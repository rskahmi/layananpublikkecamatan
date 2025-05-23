<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SuratModel;
use App\Models\BBMModel;
use App\Models\RiwayatBBMModel;
use App\Models\KTPModel;
use App\Models\RiwayatKTPModel;
use App\Models\KKModel;
use App\Models\RiwayatKKModel;
use App\Models\SKTMModel;
use App\Models\RiwayatSKTMModel;
use App\Traits\RulesTraits;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Traits\CacheTimeout;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Events\DashboardSuratEvent;

class SuratController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function dashboard(){
        $currentYear = Carbon::now()->year;
        $defaultMonth = range(1, 12);

        $dataBBM = Cache::remember('grafik_bbm_data', $this->time, function() use ($currentYear){
            return BBMModel::selectRaw('MONTH(created_at) month, count(id) as total_bbm')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('MONTH(created_at)')
            ->get()
            ->pluck('total_bbm', 'month')
            ->toArray();
        });
        $dataBBM = array_replace(array_fill_keys($defaultMonth, 0), $dataBBM);
        ksort($dataBBM);
        $grafikBBM = [];
        foreach ($dataBBM as $month => $totalBBM){
            $grafikBBM[] = [
                'month' => $month,
                'total_bbm' => $totalBBM,
            ];
        }

        $dataKTP = Cache::remember('grafik_ktp_data', $this->time, function() use ($currentYear){
            return KTPModel::selectRaw('MONTH(created_at) as month, count(id) as total_ktp')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('MONTH(created_at)')
            ->get()
            ->pluck('total_ktp', 'month')
            ->toArray();
        });
        $dataKTP = array_replace(array_fill_keys($defaultMonth, 0), $dataKTP);
        ksort($dataKTP);
        $grafikKTP = [];
        foreach ($dataKTP as $month => $totalKTP){
            $grafikKTP[] = [
                'month' => $month,
                'total_ktp' => $totalKTP
            ];
        }

        $dataKK = Cache::remember('grafik_kk_data', $this->time, function() use ($currentYear){
            return KKModel::selectRaw('MONTH(created_at) as month, count(id) as total_kk')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('MONTH(created_at)')
            ->get()
            ->pluck('total_kk', 'month')
            ->toArray();
        });
        $dataKK = array_replace(array_fill_keys($defaultMonth, 0), $dataKK);
        ksort($dataKK);
        $grafikKK = [];
        foreach ($dataKK as $month => $totalKK){
            $grafikKK[] = [
                'month' => $month,
                'total_kk' => $totalKK
            ];
        }

        $dataSKTM = Cache::remember('grafik_sktm_data', $this->time, function() use ($currentYear){
            return SKTMModel::selectRaw('MONTH(created_at) as month, count(id) as total_sktm')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('MONTH(created_at)')
            ->get()
            ->pluck('total_sktm', 'month')
            ->toArray();
        });
        $dataSKTM = array_replace(array_fill_keys($defaultMonth, 0), $dataSKTM);
        ksort($dataSKTM);
        $grafikSKTM = [];
        foreach ($dataSKTM as $month => $totalSKTM){
            $grafikSKTM [] = [
                'month' => $month,
                'total_sktm' => $totalSKTM
            ];
        }

       $totalSurat = Cache::remember('total_surat_in_dashboard', $this->time, function() use ($currentYear) {
            $bbmCount = BBMModel::where('status', 'diajukan')
                                ->whereYear('created_at', $currentYear)
                                ->count();

            $ktpCount = KTPModel::where('status', 'diajukan')
                                ->whereYear('created_at', $currentYear)
                                ->count();

            $kkCount = KKModel::where('status', 'diajukan')
                            ->whereYear('created_at', $currentYear)
                            ->count();

            $sktmCount = SKTMModel::where('status', 'diajukan')
                                ->whereYear('created_at', $currentYear)
                                ->count();

            return $bbmCount + $ktpCount + $kkCount + $sktmCount;
        });


        $totalSuratProses = Cache::remember('total_surat_proses_in_dashboard', $this->time, function() use ($currentYear) {
            $bbmCount = BBMModel::where('status', 'proses')
                                ->whereYear('created_at', $currentYear)
                                ->count();

            $ktpCount = KTPModel::where('status', 'proses')
                                ->whereYear('created_at', $currentYear)
                                ->count();

            $kkCount = KKModel::where('status', 'proses')
                            ->whereYear('created_at', $currentYear)
                            ->count();

            $sktmCount = SKTMModel::where('status', 'proses')
                                ->whereYear('created_at', $currentYear)
                                ->count();

            return $bbmCount + $ktpCount + $kkCount + $sktmCount;
        });

        $totalSuratSelesai = Cache::remember('total_surat__selesai_in_dashboard', $this->time, function() use ($currentYear) {
            $bbmCount = BBMModel::where('status', 'diterima')
                                ->whereYear('created_at', $currentYear)
                                ->count();

            $ktpCount = KTPModel::where('status', 'diterima')
                                ->whereYear('created_at', $currentYear)
                                ->count();

            $kkCount = KKModel::where('status', 'diterima')
                            ->whereYear('created_at', $currentYear)
                            ->count();

            $sktmCount = SKTMModel::where('status', 'diterima')
                                ->whereYear('created_at', $currentYear)
                                ->count();

            return $bbmCount + $ktpCount + $kkCount + $sktmCount;
        });

        $totalBBM = Cache::remember('total_bbm_in_dashboard', $this->time, function() use ($currentYear){
            return SuratModel::where('jenis', 'BBM')->whereYear('created_at', $currentYear)->count();
        });

        $jumlahStatusProsesBBM = Cache::remember('jumlah_bbm_diproses_in_dashboard', $this->time, function() use ($currentYear){
            return BBMModel::whereIn('status', ['proses'])
                ->whereYear('created_at', $currentYear)
                ->with('surat')
                ->count();
        });

        $jumlahStatusSelesaiBBM = Cache::remember('status_terima_bbm_in_dashboard', $this->time, function () use ($currentYear){
            return RiwayatBBMModel::where('status','diterima')
            ->whereYear('created_at', $currentYear)
            ->count();
        });

        $totalKTP = Cache::remember('total_ktp_in_dashboard', $this->time, function() use ($currentYear){
            return SuratModel::where('jenis', 'KTP')->whereYear('created_at', $currentYear)->count();
        });

        $jumlahStatusProsesKTP = Cache::remember('jumlah_ktp_diproses_in_dashboard', $this->time, function() use ($currentYear){
            return KTPModel::whereIn('status', ['proses'])
                ->whereYear('created_at', $currentYear)
                ->with('surat')
                ->count();
        });

        $jumlahStatusSelesaiKTP = Cache::remember('status_terima_ktp_in_dashboard', $this->time, function () use ($currentYear){
            return RiwayatKTPModel::where('status','diterima')
            ->whereYear('created_at', $currentYear)
            ->count();
        });

        $totalKK = Cache::remember('total_kk_in_dashboard', $this->time, function() use ($currentYear){
            return SuratModel::where('jenis', 'KK')->whereYear('created_at', $currentYear)->count();
        });

        $jumlahStatusProsesKK = Cache::remember('jumlah_kk_diproses_in_dashboard', $this->time, function() use ($currentYear){
            return KKModel::whereIn('status', ['proses'])
                ->whereYear('created_at', $currentYear)
                ->with('surat')
                ->count();
        });

        $jumlahStatusSelesaiKK = Cache::remember('status_terima_kk_in_dashboard', $this->time, function () use ($currentYear){
            return RiwayatKKModel::where('status','diterima')
            ->whereYear('created_at', $currentYear)
            ->count();
        });

        $totalSKTM = Cache::remember('total_sktm_in_dashboard', $this->time, function() use ($currentYear){
            return SuratModel::where('jenis', 'SKTM')->whereYear('created_at', $currentYear)->count();
        });

        $jumlahStatusProsesSKTM = Cache::remember('jumlah_sktm_diproses_in_dashboard', $this->time, function() use ($currentYear){
            return SKTMModel::whereIn('status', ['proses'])
                ->whereYear('created_at', $currentYear)
                ->with('surat')
                ->count();
        });

        $jumlahStatusSelesaiSKTM = Cache::remember('status_terima_sktm_in_dashboard', $this->time, function () use ($currentYear){
            return RiwayatSKTMModel::where('status','diterima')
            ->whereYear('created_at', $currentYear)
            ->count();
        });

        return view('after-login.surat.dashboard')->with([
            'jumlah_status_proses_bbm' => $jumlahStatusProsesBBM,
            'total_bbm' => $totalBBM,
            'jumlah_status_selesai_bbm' => $jumlahStatusSelesaiBBM,
            'jumlah_status_proses_ktp' => $jumlahStatusProsesKTP,
            'total_ktp' => $totalKTP,
            'jumlah_status_selesai_ktp' => $jumlahStatusSelesaiKTP,
            'jumlah_status_proses_kk' => $jumlahStatusProsesKK,
            'total_kk' => $totalKK,
            'jumlah_status_selesai_kk' => $jumlahStatusSelesaiKK,
            'jumlah_status_proses_sktm' => $jumlahStatusProsesSKTM,
            'total_sktm' => $totalSKTM,
            'jumlah_status_selesai_sktm' => $jumlahStatusSelesaiSKTM,
            'grafik_bbm' => $grafikBBM,
            'grafik_ktp' => $grafikKTP,
            'grafik_kk' => $grafikKK,
            'grafik_sktm' => $grafikSKTM,
            'total_surat' => $totalSurat,
            'total_surat_proses' => $totalSuratProses,
            'total_surat_selesai' => $totalSuratSelesai
        ]);
    }
    public function showPengajuan(){
        try {
            if (!auth()->check()){
                return redirect()->route('login')->with('alert', [
                    'type' => 'warning',
                    'title' => 'Unauthorized',
                    'text' => 'Anda harus login untuk mengakses halaman ini.'
                ]);
            }
            $userId = auth()->user()->id;
            $role = auth()->user()->role;
            $suratQuery = SuratModel::with(['bbm.riwayat','ktp.riwayat','kk.riwayat','sktm.riwayat']);

            if ($role === 'masyarakat') {
                $suratQuery->whereHas('bbm.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                })->orWhereHas('ktp.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                })->orWhereHas('kk.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                })->orWhereHas('sktm.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                });
            }

            if ($role === 'kepalaseksi'){
                $suratQuery->whereHas('bbm.riwayat', function ($query) {
                    $query->where('peninjau', 'kepalaseksi')->where('tindakan', 1);
                })->orWhereHas('ktp.riwayat', function ($query){
                    $query->where('peninjau', 'kepalaseksi')->where('tindakan', 1);
                })->orWhereHas('kk.riwayat', function ($query){
                    $query->where('peninjau', 'kepalaseksi')->where('tindakan', 1);
                })->orWhereHas('sktm.riwayat', function ($query){
                    $query->where('peninjau', 'kepalaseksi')->where('tindakan', 1);
                });
            }

            if ($role === 'sekretariscamat'){
                $suratQuery->whereHas('bbm.riwayat', function ($query) {
                    $query->where('peninjau', 'sekretariscamat')->where('tindakan', 1);
                })->orWhereHas('ktp.riwayat', function ($query){
                    $query->where('peninjau', 'sekretariscamat')->where('tindakan', 1);
                })->orWhereHas('kk.riwayat', function ($query){
                    $query->where('peninjau', 'sekretariscamat')->where('tindakan', 1);
                })->orWhereHas('sktm.riwayat', function ($query){
                    $query->where('peninjau', 'sekretariscamat')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-comrel'){
                $suratQuery->whereHas('bbm.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                })->orWhereHas('ktp.riwayat', function ($query){
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                })->orWhereHas('kk.riwayat', function ($query){
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                })->orWhereHas('sktm.riwayat', function ($query){
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                });
            }

            if ($role === 'camat'){
                $suratQuery->whereHas('bbm.riwayat', function ($query) {
                    $query->where('peninjau', 'camat')->where('tindakan', 1);
                })->orWhereHas('ktp.riwayat', function ($query){
                    $query->where('peninjau', 'camat')->where('tindakan', 1);
                })->orWhereHas('kk.riwayat', function ($query){
                    $query->where('peninjau', 'camat')->where('tindakan', 1);
                })->orWhereHas('sktm.riwayat', function ($query){
                    $query->where('peninjau', 'camat')->where('tindakan', 1);
                });
            }


            $surat = $suratQuery->orderBy('tanggal','desc')
                ->get();
            return view ('after-login.surat.pengajuan') -> with([
                'surat' => $surat
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

    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'jenis' => 'required|in:BBM,KTP,KK,SKTM'
            ], [
                'jenis.required' => 'Kolom jenis wajib diisi'
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

            $tanggal = now();
            $surat = SuratModel::create([
                'jenis' => $request->jenis,
                'tanggal' => $tanggal,
                'user_id' => auth()->user()->id
            ]);

            if($surat){
                if (Str::lower($request->jenis) == "bbm"){
                    $filename = null;
                    if ($request->hasFile('ktp_bbm')){
                        $ktp_bbm = $request->file('ktp_bbm');
                        $filename = time() . '-' . str_replace(' ','-', $ktp_bbm->getClientOriginalName());
                        $ktp_bbm->storeAs('public/surat', $filename);
                    }

                    $filename2 = null;
                    if ($request->hasFile('nimb_bbm')){
                        $nimb_bbm = $request->file('nimb_bbm');
                        $filename2 = time() . '-' . str_replace(' ','-', $nimb_bbm->getClientOriginalName());
                        $nimb_bbm->storeAs('public/surat', $filename2);
                    }

                    $statusDef = 'diajukan';
                    $bbm = BBMModel::create([
                        'status' => $statusDef,
                        'ktp_bbm' => $filename,
                        'nimb_bbm' => $filename2,
                        'surat_id' => $surat->id
                    ]);

                    $riwayatBbm = RiwayatBBMModel::create([
                        'status' => $statusDef,
                        'bbm_id' => $bbm->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'am'
                    ]);
                    $data = [
                        'text' => "Pengajuan Baru Masuk",
                        'jenis' => "Surat",
                    ];
                    $email_target = 'riskyahmi123@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                else if (Str::lower($request->jenis) == "ktp"){
                    $filename3 = null;
                    if ($request->hasFile('kk_ktp')){
                        $kk_ktp = $request->file('kk_ktp');
                        $filename3 = time() . '-' . str_replace(' ','-', $kk_ktp->getClientOriginalName());
                        $kk_ktp->storeAs('public/surat', $filename3);
                    }
                    $filename4 = null;
                    if ($request->hasFile('suratkelurahan_ktp')){
                        $suratkelurahan_ktp = $request->file('suratkelurahan_ktp');
                        $filename4 = time() . '-' . str_replace(' ','-', $suratkelurahan_ktp->getClientOriginalName());
                        $suratkelurahan_ktp->storeAs('public/surat', $filename4);
                    }
                    $statusDef = 'diajukan';
                    $ktp = KTPModel::create([
                        'status' => $statusDef,
                        'kk_ktp' => $filename3,
                        'suratkelurahan_ktp' => $filename4,
                        'surat_id' => $surat->id
                    ]);
                    $riwayatKtp = RiwayatKTPModel::create([
                        'status' => $statusDef,
                        'ktp_id' => $ktp->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'petugasadministrasi'
                    ]);
                }
                else if (Str::lower($request->jenis) == "kk"){
                    $filename5 = null;
                    if ($request->hasFile('ktp_kk')){
                        $ktp_kk = $request->file('ktp_kk');
                        $filename5 = time() . '-' . str_replace(' ','-', $ktp_kk->getClientOriginalName());
                        $ktp_kk->storeAs('public/surat', $filename5);
                    }
                    $filename6 = null;
                    if ($request->hasFile('suratkelurahan_kk')){
                        $suratkelurahan_kk = $request->file('suratkelurahan_kk');
                        $filename6 = time() . '-' . str_replace(' ','-', $suratkelurahan_kk->getClientOriginalName());
                        $suratkelurahan_kk->storeAs('public/surat', $filename6);
                    }
                    $statusDef = 'diajukan';
                    $kk = KKModel::create([
                        'status' => $statusDef,
                        'ktp_kk' => $filename5,
                        'suratkelurahan_kk' => $filename6,
                        'surat_id' => $surat->id
                    ]);
                    $riwayatkk = RiwayatKKModel::create([
                        'status' => $statusDef,
                        'kk_id' => $kk->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'petugasadministrasi'
                    ]);
                }
                else if (Str::lower($request->jenis) == "sktm"){
                    $filename7 = null;
                    if ($request->hasFile('ktm_sktm')){
                        $ktm_sktm = $request->file('ktm_sktm');
                        $filename7 = time() . '-' . str_replace(' ','-', $ktm_sktm->getClientOriginalName());
                        $ktm_sktm->storeAs('public/surat', $filename7);
                    }
                    $filename8 = null;
                    if ($request->hasFile('suratkelurahan_sktm')){
                        $suratkelurahan_sktm = $request->file('suratkelurahan_sktm');
                        $filename8 = time() . '-' . str_replace(' ','-', $suratkelurahan_sktm->getClientOriginalName());
                        $suratkelurahan_sktm->storeAs('public/surat', $filename8);
                    }
                    $statusDef = 'diajukan';
                    $sktm = SKTMModel::create([
                        'status' => $statusDef,
                        'ktm_sktm' => $filename7,
                        'suratkelurahan_sktm' => $filename8,
                        'surat_id' => $surat->id
                    ]);
                    $riwayatSktm = RiwayatSKTMModel::create([
                        'status' => $statusDef,
                        'sktm_id' => $sktm->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'petugasadministrasi'
                    ]);
                }
            }
            event(new DashboardSuratEvent($surat));
            $this->forgetSurat();
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Insert Berkas',
                        'text' => 'Data berhasil Ditambahkan!'
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

    public function update(Request $request, $id){
        try {
            $validator = Validator::make($request->all(), [
                'edtJenis' => 'required',
            ], [
                'edtJenis.required' => $this->jenisNPPMessage()
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
            $surat = SuratModel::findOrFail($id);
            $data = [
                'jenis' => $request->edtJenis
            ];
            $surat->update($data);
            if ($data){
                if(Str::lower($request->edtJenis) == "bbm"){
                    $filename = $surat->bbm->ktp_bbm;
                    if ($request->hasFile('edtktp_bbm')){
                        $edtktp_bbm = $request->file('edtktp_bbm');
                        $filename = time() . '-' . str_replace(' ','-', $edtktp_bbm->getClientOriginalName());
                        $edtktp_bbm->storeAs('public/surat', $filename);
                        if($surat->ktp_bbm){
                            Storage::disk('public')->delete('surat/' . $surat->ktp_bbm);
                        }
                        $data['ktp_bbm'] = $filename;
                    }

                    $filename2 = $surat->bbm->nimb_bbm;
                    if ($request->hasFile('edtnimb_bbm')){
                        $edtnimb_bbm = $request->file('edtnimb_bbm');
                        $filename = time() . '-' . str_replace(' ','-', $edtnimb_bbm->getClientOriginalName());
                        $edtnimb_bbm->storeAs('public/surat', $filename);
                        if($surat->nimb_bbm){
                            Storage::disk('public')->delete('surat/' . $surat->nimb_bbm);
                        }
                        $data['nimb_bbm'] = $filename;
                    }
                    $bbm = BBMModel::where('surat_id', $surat->id);
                    $bbm->update([
                        'ktp_bbm' => $filename,
                        'nimb_bbm' => $filename2
                    ]);
                }
                else if (Str::lower($request->edtJenis) == "ktp"){
                    $filename3 = $surat->ktp->kk_ktp;
                    if ($request->hasFile('edtkk_ktp')){
                        $edtkk_ktp = $request->file('edtkk_ktp');
                        $filename3 = time() . '-' . str_replace(' ','-', $edtkk_ktp->getClientOriginalName());
                        $edtkk_ktp->storeAs('public/surat', $filename3);
                        if($surat->kk_ktp){
                            Storage::disk('public')->delete('surat/' . $surat->kk_ktp);
                        }
                        $data['kk_ktp'] = $filename3;
                    }
                    $filename4 = $surat->ktp->kk_ktp;
                    if ($request->hasFile('edtsuratkelurahan_ktp')){
                        $edtsuratkelurahan_ktp = $request->file('edtsuratkelurahan_ktp');
                        $filename4 = time() . '-' . str_replace(' ','-', $edtsuratkelurahan_ktp->getClientOriginalName());
                        $edtsuratkelurahan_ktp->storeAs('public/surat', $filename4);
                        if($surat->suratkelurahan_ktp){
                            Storage::disk('public')->delete('surat/' . $surat->suratkelurahan_ktp);
                        }
                        $data['suratkelurahan_ktp'] = $filename4;
                    }
                    $ktp = KTPModel::where('surat_id', $surat->id);
                    $ktp->update([
                        'kk_ktp' => $filename3,
                        'suratkelurahan_ktp' => $filename4
                    ]);
                }
                else if(Str::lower($request->edtJenis) == "kk"){
                    $filename5 = $surat->kk->ktp_kk;
                    if ($request->hasFile('edtktp_kk')){
                        $edtktp_kk = $request->file('edtktp_kk');
                        $filename5 = time() . '-' . str_replace(' ','-', $edtktp_kk->getClientOriginalName());
                        $edtktp_kk->storeAs('public/surat', $filename5);
                        if($surat->ktp_kk){
                            Storage::disk('public')->delete('surat/' . $surat->ktp_kk);
                        }
                        $data['ktp_kk'] = $filename5;
                    }
                    $filename6 = $surat->kk->suratkelurahan_kk;
                    if ($request->hasFile('edtsuratkelurahan_kk')){
                        $edtsuratkelurahan_kk = $request->file('edtsuratkelurahan_kk');
                        $filename6 = time() . '-' . str_replace(' ','-', $edtsuratkelurahan_kk->getClientOriginalName());
                        $edtsuratkelurahan_kk->storeAs('public/surat', $filename6);
                        if($surat->suratkelurahan_kk){
                            Storage::disk('public')->delete('surat/' . $surat->suratkelurahan_kk);
                        }
                        $data['suratkelurahan_kk'] = $filename6;
                    }
                    $kk = KKModel::where('surat_id', $surat->id);
                    $kk->update([
                        'ktp_kk' => $filename5,
                        'suratkelurahan_kk' => $filename6
                    ]);

                }
                else if (Str::lower($request->edtJenis) == "sktm"){
                    $filename7 = $surat->sktm->ktm_sktm;
                    if ($request->hasFile('edtktm_sktm')){
                        $edtktm_sktm = $request->file('edtktm_sktm');
                        $filename7 = time() . '-' . str_replace(' ','-', $edtktm_sktm->getClientOriginalName());
                        $edtktm_sktm->storeAs('public/surat', $filename7);
                        if($surat->ktm_sktm){
                            Storage::disk('public')->delete('surat/' . $surat->ktm_sktm);
                        }
                        $data['ktm_sktm'] = $filename7;
                    }
                    $filename8 = $surat->sktm->suratkelurahan_sktm;
                    if ($request->hasFile('edtsuratkelurahan_sktm')){
                        $edtsuratkelurahan_sktm = $request->file('edtsuratkelurahan_sktm');
                        $filename8 = time() . '-' . str_replace(' ','-', $edtsuratkelurahan_sktm->getClientOriginalName());
                        $edtsuratkelurahan_sktm->storeAs('public/surat', $filename8);
                        if($surat->suratkelurahan_sktm){
                            Storage::disk('public')->delete('surat/' . $surat->suratkelurahan_sktm);
                        }
                        $data['suratkelurahan_sktm'] = $filename8;
                    }
                    $sktm = SKTMModel::where('surat_id', $surat->id);
                    $sktm->update([
                        'ktm_sktm' => $filename7,
                        'suratkelurahan_sktm' => $filename8
                    ]);
                }
            }
            $this->forgetBerkas();
                return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update Berkas',
                        'text' => 'Data berhasil diperbarui!'
                    ]
                );
        } catch (Exception $e) {
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
        try {
            $surat = SuratModel::with(['bbm.riwayat'])->findOrFail($id);
            if($surat->bbm !== null){
                $riwayat_bbm = RiwayatBBMModel::with('user')->where('bbm_id', $surat->bbm->id)->orderBy('created_at', 'desc')->get();
                return view('after-login.surat.detail')-> with ([
                    'surat' => $surat,
                    'riwayat_bbm' => $riwayat_bbm
                ]);
            }
            else if ($surat->ktp !== null){
                $riwayat_ktp = RiwayatKTPModel::with('user')->where('ktp_id', $surat->ktp->id)->orderBy('created_at','desc')->get();
                return view('after-login.surat.detail')->with ([
                    'surat' => $surat,
                    'riwayat_ktp' => $riwayat_ktp
                ]);
            }
            else if ($surat->kk !== null){
                $riwayat_kk = RiwayatKKModel::with('user')->where('kk_id', $surat->kk->id)->orderBy('created_at','desc')->get();
                return view('after-login.surat.detail')->with ([
                    'surat' => $surat,
                    'riwayat_kk' => $riwayat_kk
                ]);
            }
            else if ($surat->sktm !== null){
                $riwayat_sktm = RiwayatsktmModel::with('user')->where('sktm_id', $surat->sktm->id)->orderBy('created_at','desc')->get();
                return view('after-login.surat.detail')->with ([
                    'surat' => $surat,
                    'riwayat_sktm' => $riwayat_sktm
                ]);
            }
        } catch (Exception $e) {
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

    public function verifikasiBBM(Request $request, $id){
        try {
            $bbm = BBMModel::with(['surat','riwayat'])->where('surat_id',$id)->first();
            $lastOfRiwayat = $bbm->riwayat->sortBy('created_at')->last();
            $dataRiwayat = [
                'bbm_id' => $bbm->id,
                'user_id' => auth()->user()->id,
                'alasan' => $request->keterangan
            ];
            $statusBBM = null;
            if (isPetugasAdministrasiSection($lastOfRiwayat)){
                if (isset($request->verifikasi_surat) && $request->verifikasi_surat === 'ditolak'){
                    if (isset($lastOfRiwayat->user_id)){
                        $dataRiwayat['status'] = $request->verifikasi_surat;
                        $dataRiwayat['peninjau'] = 'masyarakat';
                        $dataRiwayat['tindakan'] = 1;
                        $statusBBM = $request->verifikasi_surat;
                    } else {
                        throw new Exception('User ID not found for this Riwayat');
                    }
                }
                else if ($request->verifikasi_surat === "diterima"){
                    $dataRiwayat['status'] = 'proses';
                    $statusBBM = 'proses';
                    $dataRiwayat['peninjau'] = 'kepalaseksi';
                    $dataRiwayat['tindakan'] = 1;
                }
            }

            else if (isKepalaSeksiSection($lastOfRiwayat)){
                if($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusBBM = 'proses';
                    $dataRiwayat['peninjau'] = 'sekretariscamat';
                    $dataRiwayat['tindakan'] = 1;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusBBM = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }
            }

            else if (isSekretarisCamatSection($lastOfRiwayat)){
                if($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusBBM = 'proses';
                    $dataRiwayat['peninjau'] = 'admin-comrel';
                    $dataRiwayat['tindakan'] = 1;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusBBM = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }
            }



            else if (isCamatSection($lastOfRiwayat)){
                if ($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusBBM = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verikasi_surat;
                    $statusBBM = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }

            }

            $bbm->update([
                'status' => $statusBBM
            ]);
            $riwayat = RiwayatBBMModel::create($dataRiwayat);
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

    public function verifikasiKTP(Request $request, $id){
        try {
            $ktp = KTPModel::with(['surat','riwayat'])->where('surat_id',$id)->first();
            $lastOfRiwayat = $ktp->riwayat->sortBy('created_at')->last();
            $dataRiwayat = [
                'ktp_id' => $ktp->id,
                'user_id' => auth()->user()->id,
                'alasan' => $request->keterangan
            ];
            $statusKTP = null;
            if (isPetugasAdministrasiSection($lastOfRiwayat)){
                if (isset($request->verifikasi_surat) && $request->verifikasi_surat === 'ditolak'){
                    if (isset($lastOfRiwayat->user_id)){
                        $dataRiwayat['status'] = $request->verifikasi_surat;
                        $dataRiwayat['peninjau'] = 'masyarakat';
                        $dataRiwayat['tindakan'] = 1;
                        $statusKTP = $request->verifikasi_surat;
                    }
                    else {
                        throw new Exception('User ID not found for this Riwayat');
                    }
                }
                else if ($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusKTP = 'proses';
                    $dataRiwayat['peninjau'] = 'kepalaseksi';
                    $dataRiwayat['tindakan'] = 1;
                }
            }
            else if (isKepalaSeksiSection($lastOfRiwayat)){
                if($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusKTP = 'proses';
                    $dataRiwayat['peninjau'] = 'sekretariscamat';
                    $dataRiwayat['tindakan'] = 1;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusKTP = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }
            }
            else if(isSekretarisCamatSection($lastOfRiwayat)){
                if($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $dataRiwayat='proses';
                    $dataRiwayat['peninjau'] = 'admin-comrel';
                    $dataRiwayat['tindakan'] = 1;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusKTP = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }
            }

            else if (isCamatSection($lastOfRiwayat)){
                if ($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusKTP = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verikasi_surat;
                    $statusKTP = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }
            }
            $ktp->update([
                'status' => $statusKTP
            ]);
            $riwayat = RiwayatKTPModel::create($dataRiwayat);
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

    public function verifikasiKK(Request $request, $id){
        try {
            $kk = KKModel::with(['surat','riwayat'])->where('surat_id',$id)->first();
            $lastOfRiwayat = $kk->riwayat->sortBy('created_at')->last();
            $dataRiwayat = [
                'kk_id' => $kk->id,
                'user_id' => auth()->user()->id,
                'alasan' => $request->keterangan
            ];
            $statusKK = null;
            if (isPetugasAdministrasiSection($lastOfRiwayat)){
                if (isset($request->verifikasi_surat) && $request->verifikasi_surat === 'ditolak'){
                    if (isset($lastOfRiwayat->user_id)){
                        $dataRiwayat['status'] = $request->verifikasi_surat;
                        $dataRiwayat['peninjau'] = 'masyarakat';
                        $dataRiwayat['tindakan'] = 1;
                        $statusKK = $request->verifikasi_surat;
                    }
                    else {
                        throw new Exception('User ID not found for this Riwayat');
                    }
                }
                else if ($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusKK = 'proses';
                    $dataRiwayat['peninjau'] = 'kepalaseksi';
                    $dataRiwayat['tindakan'] = 1;
                }
            }

            else if (isKepalaSeksiSection($lastOfRiwayat)){
                if ($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusKK = 'proses';
                    $dataRiwayat['peninjau'] = 'sekretariscamat';
                    $dataRiwayat['tindakan'] = 1;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusKK = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }
            }

            else if (isSekretarisCamatSection($lastOfRiwayat)){
                if ($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusKK = 'proses';
                    $dataRiwayat['peninjau'] = 'admin-comrel';
                    $dataRiwayat['tindakan'] = 1;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusKK = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }
            }


            else if (isCamatSection($lastOfRiwayat)){
                if ($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusKK = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verikasi_surat;
                    $statusKK = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }
            }
            $kk->update([
                'status' => $statusKK
            ]);
            $riwayat = RiwayatKKModel::create($dataRiwayat);
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

    public function verifikasiSKTM(Request $request, $id){
        try {
            $sktm = SKTMModel::with(['surat','riwayat'])->where('surat_id',$id)->first();
            $lastOfRiwayat = $sktm->riwayat->sortBy('created_at')->last();
            $dataRiwayat = [
                'sktm_id' => $sktm->id,
                'user_id' => auth()->user()->id,
                'alasan' => $request->keterangan
            ];
            $statusSKTM = null;
            if (isPetugasAdministrasiSection($lastOfRiwayat)){
                if (isset($request->verifikasi_surat) && $request->verifikasi_surat === 'ditolak'){
                    if (isset($lastOfRiwayat->user_id)){
                        $dataRiwayat['status'] = $request->verifikasi_surat;
                        $dataRiwayat['peninjau'] = 'masyarakat';
                        $dataRiwayat['tindakan'] = 1;
                        $statusSKTM = $request->verifikasi_surat;
                    } else {
                        throw new Exception('User ID not found for this Riwayat');
                    }
                }
                else if ($request->verifikasi_surat === "diterima"){
                    $dataRiwayat['status'] = 'proses';
                    $statusSKTM = 'proses';
                    $dataRiwayat['peninjau'] = 'kepalaseksi';
                    $dataRiwayat['tindakan'] = 1;
                }
            }
            else if (isKepalaSeksiSection($lastOfRiwayat)){
                if($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusSKTM = 'proses';
                    $dataRiwayat['peninjau'] = 'sekretariscamat';
                    $dataRiwayat['tindakan'] = 1;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusSKTM = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }
            }
            else if (isSekretarisCamatSection($lastOfRiwayat)){
                if($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusSKTM = 'proses';
                    $dataRiwayat['peninjau'] = 'admin-comrel';
                    $dataRiwayat['tindakan'] = 1;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusSKTM = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }
            }

            else if (isCamatSection($lastOfRiwayat)){
                if ($request->verifikasi_surat === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi_surat;
                    $statusSKTM = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;
                }
                else if ($request->verifikasi_surat === 'ditolak'){
                    $dataRiwayat['status'] = $request->verikasi_surat;
                    $statusSKTM = $request->verifikasi_surat;
                    $dataRiwayat['peninjau'] = 'masyarakat';
                    $dataRiwayat['tindakan'] = 1;
                }
            }
            $sktm->update([
                'status' => $statusSKTM
            ]);
            $riwayat = RiwayatSKTMModel::create($dataRiwayat);
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

