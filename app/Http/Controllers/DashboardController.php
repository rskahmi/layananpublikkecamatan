<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratModel;
use App\Models\BBMModel;
use App\Models\RiwayatBBMModel;
use App\Models\KTPModel;
use App\Models\RiwayatKTPModel;
use App\Models\PengaduanModel;
use App\Models\RiwayatPengaduanModel;
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
use App\Events\DashboardNPPEvent;

class DashboardController extends Controller
{
    public function show()
    {
        try {
            if(!auth()->check()){
                return redirect()->route('login')->with('alert', [
                    'type' => 'warning',
                    'title' => 'Unauthorized',
                    'text' => 'Anda harus login untuk mengakses halaman ini.'
                ]);
            }
            $currentYear = Carbon::now()->year;
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

            // Pengaduan
            $pengaduanQuery = PengaduanModel::with(['riwayat']);
            if ($role === 'masyarakat') {
                $pengaduanQuery->whereHas('riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                });
            }


            $totalPengaduan = Cache::remember(
                'total_pengaduan_user_' . Auth::id() . '_in_dashboard',
                60, // cache selama 60 menit
                function () use ($currentYear) {
                    return PengaduanModel::whereYear('created_at', $currentYear)
                        ->where('user_id', Auth::id()) // filter berdasarkan user login
                        ->count();
                }
            );

            $totalSurat = Cache::remember(
                'total_surat_user_' . Auth::id() . '_in_dashboard',
                60, // cache selama 60 menit
                function () use ($currentYear) {
                    return SuratModel::whereYear('created_at', $currentYear)
                        ->where('user_id', Auth::id()) // filter berdasarkan user login
                        ->count();
                }
            );

           $totalSuratProses = Cache::remember(
                'total_surat_proses_user_' . Auth::id() . '_in_dashboard',
                60, // cache selama 60 menit
                function () use ($currentYear) {
                    $bbmCount = RiwayatBBMModel::where('status', 'proses')
                        ->whereYear('created_at', $currentYear)
                        ->where('user_id', Auth::id())
                        ->count();

                    $ktpCount = RiwayatKTPModel::where('status', 'proses')
                        ->whereYear('created_at', $currentYear)
                        ->where('user_id', Auth::id())
                        ->count();

                    $kkCount = RiwayatKKModel::where('status', 'proses')
                        ->whereYear('created_at', $currentYear)
                        ->where('user_id', Auth::id())
                        ->count();

                    $sktmCount = RiwayatSKTMModel::where('status', 'proses')
                        ->whereYear('created_at', $currentYear)
                        ->where('user_id', Auth::id())
                        ->count();
                    return $bbmCount + $ktpCount + $kkCount + $sktmCount;
                }
            );




            $surat = $suratQuery->orderBy('tanggal','desc')
                ->get();
            $pengaduan = $pengaduanQuery->orderBy('tanggal', 'desc')
                ->get();
            return view ('after-login.dashboard.dashboard') -> with([
                'surat' => $surat,
                'pengaduan' => $pengaduan,
                'total_pengaduan' => $totalPengaduan,
                'total_surat' => $totalSurat,
                'total_surat_proses' => $totalSuratProses
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
}
