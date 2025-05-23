<?php

namespace App\Http\Controllers;

use App\Traits\CacheTimeout;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

use App\Models\SuratModel;
use App\Models\BBMModel;
use App\Models\RiwayatBBMModel;
use App\Models\KTPModel;
use App\Models\RiwayatKTPModel;
use App\Models\KKModel;
use App\Models\RiwayatKKModel;
use App\Models\SKTMModel;
use App\Models\RiwayatSKTMModel;

use App\Models\PengaduanModel;
use App\Models\RiwayatPengaduanModel;

class ResumeController extends Controller
{
    use CacheTimeout;
    public function show()
    {
        return view('after-login.resume.resume');

    }

    public function dashboard()
    {
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

        return view('after-login.resume.resume')->with([
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
            'total_surat_selesai' => $totalSuratSelesai,
            'grafik_pengaduan' => $grafikPengaduan,
            'total_pengaduan' => $totalPengaduan,
            'jumlah_status_proses_pengaduan' => $jumlahStatusProsesPengaduan,
            'jumlah_status_selesai_pengaduan'=> $jumlahStatusTerimaPengaduan,
            'jumlah_status_tolak_pengaduan'=> $jumlahStatusTolakPengaduan
        ]);
    }
}
