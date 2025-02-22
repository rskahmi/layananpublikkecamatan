<?php

namespace App\Http\Controllers;


use App\Traits\CacheTimeout;
use Exception;
use App\Models\TjslModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\NPPModel;
use App\Models\UMDModel;
use App\Models\ReimModel;
use App\Models\RiwayatReimModel;
use App\Models\RiwayatUMDModel;
use App\Models\RDModel;
use App\Models\BaruModel;
use App\Models\GantiModel;
use App\Models\KembalikanModel;
use App\Models\RiwayatBaruModel;
use App\Models\RiwayatGantiModel;
use App\Models\RiwayatKembalikanModel;
use App\Models\SPDModel;
use App\Models\RiwayatSPDModel;
use App\Models\SIJModel;
use App\Models\MelayatModel;
use App\Models\SakitModel;
use App\Models\DinasModel;
use App\Models\RiwayatMelayatModel;
use App\Models\RiwayatSakitModel;
use App\Models\RiwayatDinasModel;
use App\Models\SPDLModel;
use App\Models\RiwayatSPDLModel;
use App\Models\RotasiModel;
use App\Models\RiwayatRotasiModel;
use App\Models\MutasiModel;
use App\Models\RiwayatMutasiModel;
use App\Models\PromosiModel;
use App\Models\RiwayatPromosiModel;


class ResumeController extends Controller
{
    use CacheTimeout;
    public function show()
    {
        return view('after-login.resume.resume');

    }

    public function dashboard()
    {
        try {

            if (Auth::check()){
                $currentYear = Carbon::now()->year;
                $defaultMonth = range(1, 12);
                // NPP
                // UMD
                $dataUMD = Cache::remember('grafik_umd_data', $this->time, function () use ($currentYear) {
                    return UMDModel::selectRaw('MONTH(created_at) as month, count(id) as total_umd')
                        ->whereYear('created_at', $currentYear)
                        ->groupByRaw('MONTH(created_at)')
                        ->get()
                        ->pluck('total_umd', 'month')
                        ->toArray();
                });
                $dataUMD = array_replace(array_fill_keys($defaultMonth, 0), $dataUMD);
                ksort($dataUMD);
                $grafikUMD = [];
                foreach ($dataUMD as $month => $totalUMD) {
                    $grafikUMD[] = [
                        'month' => $month,
                        'total_umd' => $totalUMD,
                    ];
                }
                // Reimburstment
                $dataReim = Cache::remember('grafik_reim_data', $this->time, function () use ($currentYear) {
                    return ReimModel::selectRaw('MONTH(created_at) as month, count(id) as total_reim')
                        ->whereYear('created_at', $currentYear)
                        ->groupByRaw('MONTH(created_at)')
                        ->get()
                        ->pluck('total_reim', 'month')
                        ->toArray();
                });

                $dataReim = array_replace(array_fill_keys($defaultMonth, 0), $dataReim);
                ksort($dataReim);
                $grafikReim = [];
                foreach ($dataReim as $month => $totalReim) {
                    $grafikReim[] = [
                        'month' => $month,
                        'total_reim' => $totalReim,
                    ];
                }
                $totalUMD = Cache::remember('total_umd_in_dashboard', $this->time, function () use ($currentYear) {
                return NPPModel::where('jenis', 'UMD')->whereYear('created_at', $currentYear)->count();
                });
                $jumlahStatusProsesUMD = Cache::remember('jumlah_umd_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                    return UMDModel::whereIn('status', ['proses'])
                        ->whereYear('created_at', $currentYear)
                        ->with('npp')
                        ->count();
                });
                $jumlahStatusTerimaUMD = Cache::remember('status_terima_umd_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatUMDModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                $totalReim = Cache::remember('total_reim_in_dashboard', $this->time, function () use ($currentYear) {
                    return NPPModel::where('jenis', 'Reim')->whereYear('created_at', $currentYear)->count();
                });
                $jumlahStatusProsesReim = Cache::remember('jumlah_reim_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                    return ReimModel::whereIn('status', ['proses'])
                        ->whereYear('created_at', $currentYear)
                        ->with('npp')
                        ->count();
                });
                $jumlahStatusTerimaReim = Cache::remember('status_terima_reim_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatReimModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });


                // RD
                // Pengajuan RD
                $dataBaru = Cache::remember('grafik_baru_data', $this->time, function () use ($currentYear) {
                    return BaruModel::selectRaw('MONTH(created_at) as month, count(id) as total_baru')
                        ->whereYear('created_at', $currentYear)
                        ->groupByRaw('MONTH(created_at)')
                        ->get()
                        ->pluck('total_baru', 'month')
                        ->toArray();
                });
                $dataBaru = array_replace(array_fill_keys($defaultMonth, 0), $dataBaru);
                ksort($dataBaru);
                $grafikBaru = [];
                foreach ($dataBaru as $month => $totalBaru) {
                    $grafikBaru[] = [
                        'month' => $month,
                        'total_baru' => $totalBaru,
                    ];
                }

                // Penggantian
                $dataGanti = Cache::remember('grafik_ganti_data', $this->time, function () use ($currentYear) {
                    return GantiModel::selectRaw('MONTH(created_at) as month, count(id) as total_ganti')
                        ->whereYear('created_at', $currentYear)
                        ->groupByRaw('MONTH(created_at)')
                        ->get()
                        ->pluck('total_ganti', 'month')
                        ->toArray();
                });

                $dataGanti = array_replace(array_fill_keys($defaultMonth, 0), $dataGanti);
                ksort($dataGanti);
                $grafikGanti = [];
                foreach ($dataGanti as $month => $totalGanti) {
                    $grafikGanti[] = [
                        'month' => $month,
                        'total_ganti' => $totalGanti,
                    ];
                }

                //Pengembalian
                $dataKembalikan = Cache::remember('grafik_kembalikan_data', $this->time, function () use ($currentYear) {
                    return KembalikanModel::selectRaw('MONTH(created_at) as month, count(id) as total_kembalikan')
                        ->whereYear('created_at', $currentYear)
                        ->groupByRaw('MONTH(created_at)')
                        ->get()
                        ->pluck('total_kembalikan', 'month')
                        ->toArray();
                });
                $dataKembalikan = array_replace(array_fill_keys($defaultMonth, 0), $dataKembalikan);
                ksort($dataKembalikan);
                $grafikKembalikan = [];
                foreach ($dataKembalikan as $month => $totalKembalikan) {
                    $grafikKembalikan[] = [
                        'month' => $month,
                        'total_kembalikan' => $totalKembalikan,
                    ];
                }

                //Baru
                $totalBaru = Cache::remember('total_baru_in_dashboard', $this->time, function () use ($currentYear) {
                    return RDModel::where('jenis', 'Baru')->whereYear('created_at', $currentYear)->count();
                    });
                $jumlahStatusProsesBaru = Cache::remember('jumlah_baru_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                    return BaruModel::whereIn('status', ['proses'])
                        ->whereYear('created_at', $currentYear)
                        ->with('rd')
                        ->count();
                });
                $jumlahStatusTerimaBaru = Cache::remember('status_terima_baru_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatBaruModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                //Ganti
                $totalGanti = Cache::remember('total_ganti_in_dashboard', $this->time, function () use ($currentYear) {
                    return RDModel::where('jenis', 'Ganti')->whereYear('created_at', $currentYear)->count();
                });
                $jumlahStatusProsesGanti = Cache::remember('jumlah_ganti_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                    return GantiModel::whereIn('status', ['proses'])
                        ->whereYear('created_at', $currentYear)
                        ->with('rd')
                        ->count();
                });
                $jumlahStatusTerimaGanti = Cache::remember('status_terima_ganti_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatGantiModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                // Kembalikan
                $totalKembalikan = Cache::remember('total_kembalikan_in_dashboard', $this->time, function () use ($currentYear) {
                    return RDModel::where('jenis', 'Kembalikan')->whereYear('created_at', $currentYear)->count();
                });
                $jumlahStatusProsesKembalikan = Cache::remember('jumlah_kembalikan_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                    return KembalikanModel::whereIn('status', ['proses'])
                        ->whereYear('created_at', $currentYear)
                        ->with('rd')
                        ->count();
                });
                $jumlahStatusTerimaKembalikan = Cache::remember('status_terima_kembalikan_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatKembalikanModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                // SPD
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

                // SIJ
                $dataMelayat = Cache::remember('grafik_melayat_data', $this->time, function () use ($currentYear) {
                    return MelayatModel::selectRaw('MONTH(created_at) as month, count(id) as total_melayat')
                        ->whereYear('created_at', $currentYear)
                        ->groupByRaw('MONTH(created_at)')
                        ->get()
                        ->pluck('total_melayat', 'month')
                        ->toArray();
                });
                $dataMelayat = array_replace(array_fill_keys($defaultMonth, 0), $dataMelayat);
                ksort($dataMelayat);
                $grafikMelayat = [];
                foreach ($dataMelayat as $month => $totalMelayat) {
                    $grafikMelayat[] = [
                        'month' => $month,
                        'total_melayat' => $totalMelayat,
                    ];
                }

                // Penggantian
                $dataSakit = Cache::remember('grafik_sakit_data', $this->time, function () use ($currentYear) {
                    return SakitModel::selectRaw('MONTH(created_at) as month, count(id) as total_sakit')
                        ->whereYear('created_at', $currentYear)
                        ->groupByRaw('MONTH(created_at)')
                        ->get()
                        ->pluck('total_sakit', 'month')
                        ->toArray();
                });

                $dataSakit = array_replace(array_fill_keys($defaultMonth, 0), $dataSakit);
                ksort($dataSakit);
                $grafikSakit = [];
                foreach ($dataSakit as $month => $totalSakit) {
                    $grafikSakit[] = [
                        'month' => $month,
                        'total_sakit' => $totalSakit,
                    ];
                }

                //Pengembalian
                $dataDinas = Cache::remember('grafik_dinas_data', $this->time, function () use ($currentYear) {
                    return DinasModel::selectRaw('MONTH(created_at) as month, count(id) as total_dinas')
                        ->whereYear('created_at', $currentYear)
                        ->groupByRaw('MONTH(created_at)')
                        ->get()
                        ->pluck('total_dinas', 'month')
                        ->toArray();
                });
                $dataDinas = array_replace(array_fill_keys($defaultMonth, 0), $dataDinas);
                ksort($dataDinas);
                $grafikDinas = [];
                foreach ($dataDinas as $month => $totalDinas) {
                    $grafikDinas[] = [
                        'month' => $month,
                        'total_dinas' => $totalDinas,
                    ];
                }


                //Baru
                $totalMelayat = Cache::remember('total_melayat_in_dashboard', $this->time, function () use ($currentYear) {
                    return SIJModel::where('jenis', 'Melayat')->whereYear('created_at', $currentYear)->count();
                    });
                $jumlahStatusProsesMelayat = Cache::remember('jumlah_melayat_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                    return MelayatModel::whereIn('status', ['proses'])
                        ->whereYear('created_at', $currentYear)
                        ->with('sij')
                        ->count();
                });
                $jumlahStatusTerimaMelayat = Cache::remember('status_terima_melayat_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatMelayatModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                //Ganti
                $totalSakit = Cache::remember('total_sakit_in_dashboard', $this->time, function () use ($currentYear) {
                    return SIJModel::where('jenis', 'Sakit')->whereYear('created_at', $currentYear)->count();
                });
                $jumlahStatusProsesSakit = Cache::remember('jumlah_sakit_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                    return SakitModel::whereIn('status', ['proses'])
                        ->whereYear('created_at', $currentYear)
                        ->with('sij')
                        ->count();
                });
                $jumlahStatusTerimaSakit = Cache::remember('status_terima_sakit_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatSakitModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                // Kembalikan
                $totalDinas = Cache::remember('total_dinas_in_dashboard', $this->time, function () use ($currentYear) {
                    return SIJModel::where('jenis', 'Dinas')->whereYear('created_at', $currentYear)->count();
                });
                $jumlahStatusProsesDinas = Cache::remember('jumlah_dinas_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                    return DinasModel::whereIn('status', ['proses'])
                        ->whereYear('created_at', $currentYear)
                        ->with('sij')
                        ->count();
                });
                $jumlahStatusTerimaDinas = Cache::remember('status_terima_dinas_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatDinasModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                // SPDL
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


                // Rotasi
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


                // Mutasi
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

                // Promosi
                $dataPromosi = Cache::remember('grafik_promosi_data', $this->time, function () use ($currentYear) {
                    return PromosiModel::selectRaw('MONTH(created_at) as month, count(id) as total_promosi')
                        ->whereYear('created_at', $currentYear)
                        ->groupByRaw('MONTH(created_at)')
                        ->get()
                        ->pluck('total_promosi', 'month')
                        ->toArray();
                });
                $dataPromosi = array_replace(array_fill_keys($defaultMonth, 0), $dataPromosi);
                ksort($dataPromosi);
                $grafikPromosi = [];
                foreach ($dataPromosi as $month => $totalPromosi) {
                    $grafikPromosi[] = [
                        'month' => $month,
                        'total_promosi' => $totalPromosi,
                    ];
                }


                $totalPromosi = Cache::remember('total_promosi_in_dashboard', $this->time, function () use ($currentYear) {
                return PromosiModel::whereYear('created_at', $currentYear)->count();
                });

                $jumlahStatusProsesPromosi = Cache::remember('jumlah_promosi_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                    return PromosiModel::whereIn('status', ['proses'])
                        ->whereYear('created_at', $currentYear)
                        ->with('promosi')
                        ->count();
                });
                $jumlahStatusTerimaPromosi = Cache::remember('status_terima_promosi_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatPromosiModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                return view('after-login.resume.resume')->with([
                    'total_umd' => $totalUMD,
                    'jumlah_status_proses_umd' => $jumlahStatusProsesUMD,
                    'jumlah_status_terima_umd' => $jumlahStatusTerimaUMD,
                    'total_reim' => $totalReim,
                    'jumlah_status_proses_reim' => $jumlahStatusProsesReim,
                    'jumlah_status_terima_reim' => $jumlahStatusTerimaReim,
                    'grafik_umd' => $grafikUMD,
                    'grafik_reim' => $grafikReim,
                    'total_baru' => $totalBaru,
                    'total_ganti' => $totalGanti,
                    'total_kembalikan' => $totalKembalikan,
                    'grafik_baru' => $grafikBaru,
                    'grafik_ganti' => $grafikGanti,
                    'grafik_kembalikan' => $grafikKembalikan,
                    'jumlah_status_proses_baru' => $jumlahStatusProsesBaru,
                    'jumlah_status_terima_baru' => $jumlahStatusTerimaBaru,
                    'jumlah_status_proses_ganti' => $jumlahStatusProsesGanti,
                    'jumlah_status_terima_ganti' => $jumlahStatusTerimaGanti,
                    'jumlah_status_proses_kembalikan' => $jumlahStatusProsesKembalikan,
                    'jumlah_status_terima_kembalikan' => $jumlahStatusTerimaKembalikan,
                    'grafik_spd' => $grafikSPD,
                    'total_spd' => $totalSPD,
                    'jumlah_status_proses_spd' => $jumlahStatusProsesSPD,
                    'jumlah_status_selesai_spd'=> $jumlahStatusTerimaSPD,
                    'grafik_melayat' => $grafikMelayat,
                    'grafik_sakit' => $grafikSakit,
                    'grafik_dinas' => $grafikDinas,
                    'total_melayat' => $totalMelayat,
                    'jumlah_status_proses_melayat' => $jumlahStatusProsesMelayat,
                    'jumlah_status_terima_melayat' => $jumlahStatusTerimaMelayat,
                    'total_sakit' => $totalSakit,
                    'jumlah_status_proses_sakit' => $jumlahStatusProsesSakit,
                    'jumlah_status_terima_sakit' => $jumlahStatusTerimaSakit,
                    'total_dinas' => $totalDinas,
                    'jumlah_status_proses_dinas' => $jumlahStatusProsesDinas,
                    'jumlah_status_terima_dinas' => $jumlahStatusTerimaDinas,
                    'grafik_spdl' => $grafikSPDL,
                    'total_spdl' => $totalSPDL,
                    'jumlah_status_proses_spdl' => $jumlahStatusProsesSPDL,
                    'jumlah_status_selesai_spdl'=> $jumlahStatusTerimaSPDL,
                    'grafik_rotasi' => $grafikRotasi,
                    'total_rotasi' => $totalRotasi,
                    'jumlah_status_proses_rotasi' => $jumlahStatusProsesRotasi,
                    'jumlah_status_selesai_rotasi'=> $jumlahStatusTerimaRotasi,
                    'grafik_mutasi' => $grafikMutasi,
                    'total_mutasi' => $totalMutasi,
                    'jumlah_status_proses_mutasi' => $jumlahStatusProsesMutasi,
                    'jumlah_status_selesai_mutasi'=> $jumlahStatusTerimaMutasi,
                    'grafik_promosi' => $grafikPromosi,
                    'total_promosi' => $totalPromosi,
                    'jumlah_status_proses_promosi' => $jumlahStatusProsesPromosi,
                    'jumlah_status_selesai_promosi'=> $jumlahStatusTerimaPromosi
                ]);

            } else {
                return redirect()->route('auth');
            }

        }
        catch (Exception $e) {
            return redirect()->back()
                ->with([
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show Resume',
                        'text' => $e->getMessage()
                    ]
                ]);
        }
    }
}
