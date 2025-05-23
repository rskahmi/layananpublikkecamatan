<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Test\TestAjah;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RilisController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProgramUnggulanController;
use App\Http\Controllers\ProfilPerusahaanController;
use App\Http\Controllers\SendEmailController;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengumumanController;

Route::middleware('guest')->group(function () {
    Route::get('/', [BerandaController::class, 'index'])->name('beranda');
    // Route::get('beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::get('kegiatan', [KegiatanController::class, 'program'])->name('kegiatan');
    Route::get('hubungi-kami', [TentangController::class, 'kontak'])->name('kontak');
    Route::get('auth', [AuthenticationController::class, 'index'])->name('auth');
    Route::get('registasi', [AuthenticationController::class, 'registrasi'])->name('registrasi');
    Route::get('developer', function () {
        return view('before-login.developer');
    })->name('developer');
    Route::get('media-&-informasi', [RilisController::class, 'berita'])->name('berita');
    // auth
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('registrasi.store', [AuthenticationController::class, 'store'])->name('registrasi.store');


    // Tentang kami
    Route::prefix('tentang-kami')->group(function () {
        Route::get('', [TentangController::class, 'sejarah'])->name('tentang');
        Route::get('sejarah', [TentangController::class, 'sejarah'])->name('tentang.sejarah');
        Route::get('visimisi', [TentangController::class, 'visimisi'])->name('tentang.visi-misi');
        Route::get('produk-yang-dihasilkan-ru-ii-dumai', [TentangController::class, 'produk'])->name('tentang.produk');
        Route::get('program-unggulan', [TentangController::class, 'program'])->name('tentang.program');
        Route::get('strukturorganisasi', [TentangController::class, 'struktur'])->name('tentang.struktur');
        Route::get('alurpengajuansurat', [TentangController::class, 'alursurat'])->name('tentang.alursurat');
        Route::get('alurpengaduan', [TentangController::class, 'alurpengaduan'])->name('tentang.alurpengaduan');
        Route::get('alurakun', [TentangController::class, 'alurakun'])->name('tentang.alurakun');
    });

    Route::prefix('berkas')->group(function () {
        Route::post('search', [BerkasController::class, 'search'])->name('berkas.search');
    });

    Route::get('tjsl/dokumentasi/{id}', [TjslController::class, 'getDokumentasiById']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('test', [TestAjah::class, 'index'])->name('test');

    Route::prefix('resume')->group(function () {
        Route::get('', [ResumeController::class, 'dashboard'])->name('resume');
    })->middleware('role:masyarakat,petugasadministrasi,kepalaseksi,sekretariscamat,camat');

    Route::prefix('dashboard')->group(function () {
        Route::get('', [DashboardController::class, 'show'])->name('dashboard');
    })->middleware('role:masyarakat,petugasadministrasi,kepalaseksi,sekretariscamat,camat');

    Route::prefix('surat')->group(function () {
        Route::get('', [SuratController::class, 'dashboard'])->name('surat');
        Route::get('pengajuan', [SuratController::class, 'showPengajuan'])->name('surat.pengajuan');
        Route::post('', [SuratController::class, 'store'])->name('surat.store');
        Route::post('{id}/verifikasiBBM', [SuratController::class, 'verifikasiBBM'])->name('surat.verifikasiBBM');
        Route::post('{id}/verifikasiKTP', [SuratController::class, 'verifikasiKTP'])->name('surat.verifikasiKTP');
        Route::post('{id}/verifikasiKK', [SuratController::class, 'verifikasiKK'])->name('surat.verifikasiKK');
        Route::post('{id}/verifikasiSKTM', [SuratController::class, 'verifikasiSKTM'])->name('surat.verifikasiSKTM');
        // // Route::post('{id}/tolak', [BerkasController::class, 'tolakProposal'])->name('berkas.tolak');
        // Route::delete('{id}', [suratController::class, 'destroy'])->name('surat.destroy');
        Route::put('{id}', [SuratController::class, 'update'])->name('surat.update');
        Route::get('pengajuan/{id}', [SuratController::class, 'getDetailPengajuan'])->name('surat.detail');
    })->middleware('role:masyarakat,petugasadministrasi,kepalaseksi,sekretariscamat,camat');

    Route::prefix('pengaduan')->group(function () {
        Route::get('', [PengaduanController::class, 'dashboard'])->name('pengaduan');
        Route::get('pengajuan', [PengaduanController::class, 'showPengajuan'])->name('pengaduan.pengajuan');
        Route::post('', [PengaduanController::class, 'store'])->name('pengaduan.store');
        Route::post('{id}/verifikasi', [PengaduanController::class, 'verifikasi'])->name('pengaduan.verifikasi');
        // // // // Route::post('{id}/tolak', [BerkasController::class, 'tolakProposal'])->name('berkas.tolak');
        // Route::delete('{id}', [pengaduanController::class, 'destroy'])->name('pengaduan.destroy');
        Route::put('{id}', [PengaduanController::class, 'update'])->name('pengaduan.update');
        Route::get('pengajuan/{id}', [PengaduanController::class, 'getDetailPengajuan'])->name('pengaduan.detail');
    })->middleware('role:masyarakat,petugasadministrasi,kepalaseksi,sekretariscamat,camat');

    // media
    Route::prefix('rilis')->group(function () {
        Route::get('', [RilisController::class, 'dashboardMedia'])->name('media');
        Route::get('monitoring', [RilisController::class, 'showMonitoring'])->name('media.monitoring');
        Route::get('{id}', [RilisController::class, 'detail'])->name('media.detail');
        Route::post('', [RilisController::class, 'store'])->name('media.store');
        Route::put('{id}', [RilisController::class, 'update'])->name('media.update');
        Route::delete('{id}', [RilisController::class, 'destroy'])->name('media.destroy');
        Route::get('search/{keyword}', [RilisController::class, 'search'])->name('media.search');
    })->middleware('role:masyarakat,petugasadministrasi,kepalaseksi,sekretariscamat,camat');

    //Berita
    Route::prefix('berita')->group(function () {
        Route::get('', [BeritaController::class, 'showMonitoring'])->name('berita');
        // Route::get('{id}', [RilisController::class, 'detail'])->name('media.detail');
        // Route::post('', [RilisController::class, 'store'])->name('media.store');
        // Route::put('{id}', [RilisController::class, 'update'])->name('media.update');
        // Route::delete('{id}', [RilisController::class, 'destroy'])->name('media.destroy');
        // Route::get('search/{keyword}', [RilisController::class, 'search'])->name('media.search');
    })->middleware('role:masyarakat,petugasadministrasi,kepalaseksi,sekretariscamat,camat');

    //Pengumuman
    Route::prefix('pengumuman')->group(function () {
        Route::get('', [PengumumanController::class, 'showMonitoring'])->name('pengumuman');
        // Route::get('{id}', [RilisController::class, 'detail'])->name('media.detail');
        // Route::post('', [RilisController::class, 'store'])->name('media.store');
        // Route::put('{id}', [RilisController::class, 'update'])->name('media.update');
        // Route::delete('{id}', [RilisController::class, 'destroy'])->name('media.destroy');
        // Route::get('search/{keyword}', [RilisController::class, 'search'])->name('media.search');
    })->middleware('role:masyarakat,petugasadministrasi,kepalaseksi,sekretariscamat,camat');

    Route::prefix('program-unggulan')->group(function () {
        Route::get('', [ProgramUnggulanController::class, 'show'])->name('program-unggulan');
        Route::post('', [ProgramUnggulanController::class, 'store'])->name('program-unggulan.store');
        Route::put('{id}', [ProgramUnggulanController::class, 'update'])->name('program-unggulan.update');
        Route::delete('{id}', [ProgramUnggulanController::class, 'destroy'])->name('program-unggulan.destroy');
    })->middleware('role:masyarakat,petugasadministrasi,kepalaseksi,sekretariscamat,camat');

    Route::prefix('user')->group(function () {
        Route::get('', [UserController::class, 'show'])->name('user');
        Route::post('', [UserController::class, 'store'])->name('user.store');
        Route::put('{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('user/{id}', [UserController::class, 'getDetailPengguna'])->name('user.detail');
        Route::get('search/{keyword}', [UserController::class, 'search'])->name('user.search');
        Route::post('{id}/verifikasi', [UserController::class, 'verifikasiPengguna'])->name('pengguna.verifikasi');
    })->middleware('role:masyarakat,petugasadministrasi,kepalaseksi,sekretariscamat,camat');

    Route::prefix('profilkantor')->group(function () {
        Route::get('', [ProfilPerusahaanController::class, 'show'])->name('profile.kantor');
        Route::put('', [ProfilPerusahaanController::class, 'update'])->name('profile.update');
        Route::put('visi-misi', [ProfilPerusahaanController::class, 'updateVisiMisi'])->name('profile.update.visi-misi');
        Route::put('kontak', [ProfilPerusahaanController::class, 'updateKontak'])->name('profile.update.kontak');
        Route::put('sejarah', [ProfilPerusahaanController::class, 'updateSejarah'])->name('profile.update.sejarah');
        Route::put('alursurat', [ProfilPerusahaanController::class, 'updateAlurSurat'])->name('profile.update.alursurat');
        Route::put('alurpengaduan', [ProfilPerusahaanController::class, 'updateAlurPengaduan'])->name('profile.update.alurpengaduan');
        Route::put('struktur', [ProfilPerusahaanController::class, 'updateStruktur'])->name('profile.update.struktur');
        Route::prefix('produk')->group(function () {
        Route::post('', [ProfilPerusahaanController::class, 'storeProduk'])->name('profile.store.produk');
        Route::put('{id}', [ProfilPerusahaanController::class, 'updateProduk'])->name('profile.update.produk');
        Route::delete('{id}', [ProfilPerusahaanController::class, 'destroy'])->name('profile.delete.produk');
        });
    })->middleware('role:masyarakat,petugasadministrasi,kepalaseksi,sekretariscamat,camat');

    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'show'])->name('profile');
        Route::put('', [ProfileController::class, 'update'])->name('update-profile');
    })->middleware('role:masyarakat,petugasadministrasi,kepalaseksi,sekretariscamat,camat');

    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::get('dev/reset-all', function () {
        Artisan::call('storage:link');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
    });

});

Route::get('404', function () {
    return view('errors.404');
})->name('errors');

Route::fallback(function () {
    return redirect()->route('errors');
});
