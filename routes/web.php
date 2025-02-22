<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IsoController;
use App\Http\Controllers\Test\TestAjah;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PumkController;
use App\Http\Controllers\TjslController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RilisController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\DetailPumkController;
use App\Http\Controllers\DetailTjslController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PemberitaanController;
use App\Http\Controllers\AnggaranTjslController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DetailPengajuanController;
use App\Http\Controllers\DokumentasiPumkController;
use App\Http\Controllers\DokumentasiTjslController;
use App\Http\Controllers\ProgramUnggulanController;
use App\Http\Controllers\RiwayatProposalController;
use App\Http\Controllers\ProfilPerusahaanController;
use App\Http\Controllers\NPPController;
use App\Http\Controllers\RDController;
use App\Http\Controllers\SPDController;
use App\Http\Controllers\SIJController;
use App\Http\Controllers\SPDLController;
use App\Http\Controllers\RotasiController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\PromosiController;
use App\Http\Controllers\SendEmailController;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\PenerbitanController;


// Route::get('/test', function()
// {
// 	$beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
// 	$beautymail->send('emails.sendemail', [], function($message)
// 	{
// 		$message
// 			->from('riskyahmi123@gmail.com')
// 			->to('risky21ti@mahasiswa.pcr.ac.id', 'Risky Ahmi')
// 			->subject('Welcome!');
// 	});

// });

Route::get('/send-email', function () {
    $data = [
        'title' => 'Test Email',
        'message' => 'This is a test email sent from Laravel using Gmail SMTP.'
    ];

    Mail::to('riskyahmad0506@gmail.com')->send(new SendEmail($data));

    return 'Email Sent Successfully!';
});


Route::middleware('guest')->group(function () {
    Route::get('', function () {
        return view('authentication.login');
    })->name('auth');

    Route::get('hubungi-kami', [TentangController::class, 'kontak'])->name('kontak');

    Route::get('auth', [AuthenticationController::class, 'index'])->name('auth');
    Route::get('registasi', [AuthenticationController::class, 'registrasi'])->name('registrasi');

    Route::get('developer', function () {
        return view('before-login.developer');
    })->name('developer');

    // Persebaran program CSR
    Route::get('program-csr', [ResumeController::class, 'summary'])->name('program-csr');

    // auth
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('registrasi.store', [AuthenticationController::class, 'store'])->name('registrasi.store');


    // Tentang kami
    Route::prefix('tentang-kami')->group(function () {
        Route::get('', [TentangController::class, 'sekilas'])->name('tentang');
        Route::get('sejarah-pertamina-ru-ii-dumai', [TentangController::class, 'sejarah'])->name('tentang.sejarah');
        Route::get('visi-dan-misi', [TentangController::class, 'visimisi'])->name('tentang.visi-misi');
        Route::get('produk-yang-dihasilkan-ru-ii-dumai', [TentangController::class, 'produk'])->name('tentang.produk');
        Route::get('program-unggulan', [TentangController::class, 'program'])->name('tentang.program');
        Route::get('struktur-group-commrel-csr', [TentangController::class, 'struktur'])->name('tentang.struktur');
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
        Route::get('detailtjsl/{detail_program}', [ResumeController::class, 'getTjslById'])->name('resume.detailTjsl');
    })->middleware('role:admin,admin-comrel,admin-csr,sarana,am,mgr-adm,avp-adm,dhak');

    Route::prefix('npp')->group(function () {
        Route::get('', [NPPController::class, 'dashboard'])->name('npp');
        Route::get('pengajuan', [NPPController::class, 'showPengajuan'])->name('npp.pengajuan');
        Route::post('', [NPPController::class, 'store'])->name('npp.store');
        Route::post('{id}/verifikasiUMD', [NPPController::class, 'verifikasiUMD'])->name('npp.verifikasiUMD');
        Route::post('{id}/verifikasiReim', [NPPController::class, 'verifikasiReim'])->name('npp.verifikasiReim');

        // Route::post('{id}/tolak', [BerkasController::class, 'tolakProposal'])->name('berkas.tolak');
        Route::delete('{id}', [NPPController::class, 'destroy'])->name('npp.destroy');
        Route::put('{id}', [NPPController::class, 'update'])->name('npp.update');
        Route::get('pengajuan/{id}', [NPPController::class, 'getDetailPengajuan'])->name('npp.detail');
    })->middleware('role:admin,admin-comrel,admin-csr,sarana,am,mgr-adm,avp-adm,dhak');

    Route::prefix('rd')->group(function () {
        Route::get('', [RDController::class, 'dashboard'])->name('rd');
        Route::get('pengajuan', [RDController::class, 'showPengajuan'])->name('rd.pengajuan');
        Route::post('', [RDController::class, 'store'])->name('rd.store');
        Route::post('{id}/verifikasiBaru', [RDController::class, 'verifikasiBaru'])->name('rd.verifikasiBaru');
        Route::post('{id}/verifikasiGanti', [RDController::class, 'verifikasiGanti'])->name('rd.verifikasiGanti');
        Route::post('{id}/verifikasiKembalikan', [RDController::class, 'verifikasiKembalikan'])->name('rd.verifikasiKembalikan');
        Route::delete('{id}', [RDController::class, 'destroy'])->name('rd.destroy');
        Route::put('{id}', [RDController::class, 'update'])->name('rd.update');
        Route::get('pengajuan/{id}', [RDController::class, 'getDetailPengajuan'])->name('rd.detail');
    })->middleware('role:admin,admin-comrel,admin-csr,sarana,am,mgr-adm,avp-adm,dhak');


    Route::prefix('penerbitan')->group(function () {
        // Route::get('', [RDController::class, 'dashboard'])->name('rd');
        Route::get('penerbitan', [PenerbitanController::class, 'showPenerbitan'])->name('penerbitan.penerbitan');
        // Route::post('', [RDController::class, 'store'])->name('rd.store');
        // Route::post('{id}/verifikasiBaru', [RDController::class, 'verifikasiBaru'])->name('rd.verifikasiBaru');
        // Route::post('{id}/verifikasiGanti', [RDController::class, 'verifikasiGanti'])->name('rd.verifikasiGanti');
        // Route::post('{id}/verifikasiKembalikan', [RDController::class, 'verifikasiKembalikan'])->name('rd.verifikasiKembalikan');

        // Route::delete('{id}', [RDController::class, 'destroy'])->name('rd.destroy');
        // Route::put('{id}', [RDController::class, 'update'])->name('rd.update');
        Route::post('{id}/verifikasi', [PenerbitanController::class, 'verifikasi'])->name('penerbitan.verifikasi');
        Route::get('penerbitan/{id}', [PenerbitanController::class, 'getDetailPengajuan'])->name('penerbitan.detail');
    })->middleware('role:admin,admin-comrel,admin-csr,sarana,am,mgr-adm,avp-adm,dhak');

    Route::prefix('spd')->group(function () {
        Route::get('', [SPDController::class, 'dashboard'])->name('spd');
        Route::get('pengajuan', [SPDController::class, 'showPengajuan'])->name('spd.pengajuan');
        Route::post('', [SPDController::class, 'store'])->name('spd.store');
        Route::post('{id}/verifikasi', [SPDController::class, 'verifikasi'])->name('spd.verifikasi');
        // // // Route::post('{id}/tolak', [BerkasController::class, 'tolakProposal'])->name('berkas.tolak');
        Route::delete('{id}', [SPDController::class, 'destroy'])->name('spd.destroy');
        Route::put('{id}', [SPDController::class, 'update'])->name('spd.update');
        Route::get('pengajuan/{id}', [SPDController::class, 'getDetailPengajuan'])->name('spd.detail');
    })->middleware('role:admin,admin-comrel,admin-csr,sarana,am,mgr-adm,avp-adm,dhak');

    Route::prefix('spdl')->group(function () {
        Route::get('', [SPDLController::class, 'dashboard'])->name('spdl');
        Route::get('pengajuan', [SPDLController::class, 'showPengajuan'])->name('spdl.pengajuan');
        Route::post('', [SPDLController::class, 'store'])->name('spdl.store');
        Route::post('{id}/verifikasi', [SPDLController::class, 'verifikasi'])->name('spdl.verifikasi');
        Route::delete('{id}', [SPDLController::class, 'destroy'])->name('spdl.destroy');
        Route::put('{id}', [SPDLController::class, 'update'])->name('spdl.update');
        Route::get('pengajuan/{id}', [SPDLController::class, 'getDetailPengajuan'])->name('spdl.detail');
    })->middleware('role:admin,admin-comrel,admin-csr,sarana,am,mgr-adm,avp-adm,dhak');

    Route::prefix('rotasi')->group(function () {
        Route::get('', [RotasiController::class, 'dashboard'])->name('rotasi');
        Route::get('pengajuan', [RotasiController::class, 'showPengajuan'])->name('rotasi.pengajuan');
        Route::post('', [RotasiController::class, 'store'])->name('rotasi.store');
        Route::post('{id}/verifikasi', [RotasiController::class, 'verifikasi'])->name('rotasi.verifikasi');
        Route::delete('{id}', [RotasiController::class, 'destroy'])->name('rotasi.destroy');
        Route::put('{id}', [RotasiController::class, 'update'])->name('rotasi.update');
        Route::get('pengajuan/{id}', [RotasiController::class, 'getDetailPengajuan'])->name('rotasi.detail');
    })->middleware('role:admin,admin-comrel,admin-csr,sarana,am,mgr-adm,avp-adm,dhak');

    Route::prefix('mutasi')->group(function () {
        Route::get('', [MutasiController::class, 'dashboard'])->name('mutasi');
        Route::get('pengajuan', [MutasiController::class, 'showPengajuan'])->name('mutasi.pengajuan');
        Route::post('', [MutasiController::class, 'store'])->name('mutasi.store');
        Route::post('{id}/verifikasi', [MutasiController::class, 'verifikasi'])->name('mutasi.verifikasi');
        Route::delete('{id}', [MutasiController::class, 'destroy'])->name('mutasi.destroy');
        Route::put('{id}', [MutasiController::class, 'update'])->name('mutasi.update');
        Route::get('pengajuan/{id}', [MutasiController::class, 'getDetailPengajuan'])->name('mutasi.detail');
    })->middleware('role:admin,admin-comrel,admin-csr,sarana,am,mgr-adm,avp-adm,dhak');

    Route::prefix('promosi')->group(function () {
        Route::get('', [PromosiController::class, 'dashboard'])->name('promosi');
        Route::get('pengajuan', [PromosiController::class, 'showPengajuan'])->name('promosi.pengajuan');
        Route::post('', [PromosiController::class, 'store'])->name('promosi.store');
        Route::post('{id}/verifikasi', [PromosiController::class, 'verifikasi'])->name('promosi.verifikasi');
        Route::delete('{id}', [PromosiController::class, 'destroy'])->name('promosi.destroy');
        Route::put('{id}', [PromosiController::class, 'update'])->name('promosi.update');
        Route::get('pengajuan/{id}', [PromosiController::class, 'getDetailPengajuan'])->name('promosi.detail');
    })->middleware('role:admin,admin-comrel,admin-csr,sarana,am,mgr-adm,avp-adm,dhak');

    Route::prefix('sij')->group(function () {
        Route::get('', [SIJController::class, 'dashboard'])->name('sij');
        Route::get('pengajuan', [SIJController::class, 'showPengajuan'])->name('sij.pengajuan');
        Route::post('', [SIJController::class, 'store'])->name('sij.store');
        Route::post('{id}/verifikasiMelayat', [SIJController::class, 'verifikasiMelayat'])->name('sij.verifikasiMelayat');
        Route::post('{id}/verifikasiSakit', [SIJController::class, 'verifikasiSakit'])->name('sij.verifikasiSakit');
        Route::post('{id}/verifikasiDinas', [SIJController::class, 'verifikasiDinas'])->name('sij.verifikasiDinas');
        Route::delete('{id}', [SIJController::class, 'destroy'])->name('sij.destroy');
        Route::put('{id}', [SIJController::class, 'update'])->name('sij.update');
        Route::get('pengajuan/{id}', [SIJController::class, 'getDetailPengajuan'])->name('sij.detail');
    })->middleware('role:admin,admin-comrel,admin-csr,sarana,am,mgr-adm,avp-adm,dhak');

    Route::prefix('berkas')->group(function () {
        Route::get('', [BerkasController::class, 'dashboard'])->name('berkas');
        Route::get('pengajuan', [BerkasController::class, 'showPengajuan'])->name('berkas.pengajuan');
        Route::post('', [BerkasController::class, 'store'])->name('berkas.store');
        Route::post('{id}/verifikasi', [BerkasController::class, 'verifikasiProposal'])->name('berkas.verifikasi');
        Route::post('{id}/tolak', [BerkasController::class, 'tolakProposal'])->name('berkas.tolak');
        Route::delete('{id}', [BerkasController::class, 'destroy'])->name('berkas.destroy');
        Route::put('{id}', [BerkasController::class, 'update'])->name('berkas.update');
        Route::get('pengajuan/{id}', [BerkasController::class, 'getDetailPengajuan'])->name('berkas.detail');
    })->middleware('role:admin,admin-comrel,admin-csr,sarana,am,mgr-adm,avp-adm,dhak');

    // media
    Route::prefix('rilis')->group(function () {
        Route::get('', [RilisController::class, 'dashboardMedia'])->name('media');
        Route::get('monitoring', [RilisController::class, 'showMonitoring'])->name('media.monitoring');


        Route::get('{id}', [RilisController::class, 'detail'])->name('media.detail');
        Route::post('{id}/pemberitaan', [PemberitaanController::class, 'store'])->name('media.pemberitaan.store');
        Route::delete('{id}/pemberitaan', [PemberitaanController::class, 'destroy'])->name('media.pemberitaan.destroy');

        Route::put('{id}/pemberitaan', [PemberitaanController::class, 'update'])->name('media.pemberitaan.update');

        Route::post('', [RilisController::class, 'store'])->name('media.store');
        Route::put('{id}', [RilisController::class, 'update'])->name('media.update');
        Route::delete('{id}', [RilisController::class, 'destroy'])->name('media.destroy');
        Route::get('search/{keyword}', [RilisController::class, 'search'])->name('media.search');
    })->middleware('role:admin,manager');

    // tjsl
    Route::prefix('tjsl')->group(function () {
        Route::get('', [TjslController::class, 'show'])->name('tjsl');
        Route::get('monitoring', [TjslController::class, 'showMonitoring'])->name('tjsl.monitoring');
        Route::post('', [TjslController::class, 'store'])->name('tjsl.store');
        Route::put('{id}', [TjslController::class, 'update'])->name('tjsl.update');
        Route::delete('{id}', [TjslController::class, 'destroy'])->name('tjsl.destroy');
        Route::get('search/{keyword}', [TjslController::class, 'search'])->name('tjsl.search');
        Route::get('detail/{id}', [TjslController::class, 'getDetailTjsl'])->name('tjsl.detail');
        Route::post('dokumentasi/{id}', [TjslController::class, 'storeDokumentasi'])->name('tjsl.dokumentasi');

        Route::get('anggaran', [AnggaranTjslController::class, 'show'])->name('tjsl.anggaran');
        Route::post('anggaran/{id}', [AnggaranTjslController::class, 'store'])->name('anggaran.tjsl.store');
    })->middleware('role:admin,manager');

    // pumk
    Route::prefix('pumk')->group(function () {
        Route::get('', [PumkController::class, 'pumkDashboard'])->name('pumk');
        Route::get('monitoring', [PumkController::class, 'showMonitoring'])->name('pumk.monitoring');
        Route::post('', [PumkController::class, 'store'])->name('pumk.store');
        Route::put('{id}', [PumkController::class, 'update'])->name('pumk.update');
        Route::delete('{id}', [PumkController::class, 'destroy'])->name('pumk.destroy');
        Route::get('search/{keyword}', [PumkController::class, 'search'])->name('pumk.search');
        Route::get('{id}', [PumkController::class, 'getDetailPumk'])->name('pumk.detail');
        Route::post('dokumentasi/{id}', [PumkController::class, 'storeDokumentasi'])->name('pumk.dokumentasi');

        Route::post('{id}', [PumkController::class, 'storePembayaran'])->name('pumk.pembayaran');
    })->middleware('role:admin,manager');

    // iso
    Route::prefix('iso')->group(function () {
        Route::get('', [IsoController::class, 'show'])->name('iso');
        Route::post('', [IsoController::class, 'store'])->name('iso.store');
        Route::put('{id}', [IsoController::class, 'update'])->name('iso.update');
        Route::delete('{id}', [IsoController::class, 'destroy'])->name('iso.destroy');
        Route::get('search/{keyword}', [IsoController::class, 'search'])->name('iso.search');
    })->middleware('role:admin,manager');

    Route::prefix('program-unggulan')->group(function () {
        Route::get('', [ProgramUnggulanController::class, 'show'])->name('program-unggulan');
        Route::post('', [ProgramUnggulanController::class, 'store'])->name('program-unggulan.store');
        Route::put('{id}', [ProgramUnggulanController::class, 'update'])->name('program-unggulan.update');
        Route::delete('{id}', [ProgramUnggulanController::class, 'destroy'])->name('program-unggulan.destroy');
    })->middleware('role:admin,manager');

    Route::prefix('user')->group(function () {
        Route::get('', [UserController::class, 'show'])->name('user');
        Route::post('', [UserController::class, 'store'])->name('user.store');
        Route::put('{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('user/{id}', [UserController::class, 'getDetailPengguna'])->name('user.detail');
        Route::get('search/{keyword}', [UserController::class, 'search'])->name('user.search');
        Route::post('{id}/verifikasi', [UserController::class, 'verifikasiPengguna'])->name('pengguna.verifikasi');

    })->middleware('role:am');

    Route::prefix('lembaga')->group(function () {
        Route::get('', [LembagaController::class, 'show'])->name('lembaga');
        Route::post('', [LembagaController::class, 'store'])->name('add-lembaga');
    })->middleware('role:admin,manager');

    Route::prefix('wilayah')->group(function () {
        Route::post('', [WilayahController::class, 'store'])->name('store-wilayah');
    })->middleware('role:admin,manager');

    Route::prefix('profil-perusahaan')->group(function () {
        Route::get('', [ProfilPerusahaanController::class, 'show'])->name('profile');
        Route::put('', [ProfilPerusahaanController::class, 'update'])->name('profile.update');
        Route::put('visi-misi', [ProfilPerusahaanController::class, 'updateVisiMisi'])->name('profile.update.visi-misi');
        Route::put('kontak', [ProfilPerusahaanController::class, 'updateKontak'])->name('profile.update.kontak');
        Route::put('sejarah', [ProfilPerusahaanController::class, 'updateSejarah'])->name('profile.update.sejarah');
        Route::put('sekilas', [ProfilPerusahaanController::class, 'updateSekilas'])->name('profile.update.sekilas');
        Route::put('struktur', [ProfilPerusahaanController::class, 'updateStruktur'])->name('profile.update.struktur');

        Route::prefix('produk')->group(function () {
            Route::post('', [ProfilPerusahaanController::class, 'storeProduk'])->name('profile.store.produk');
            Route::put('{id}', [ProfilPerusahaanController::class, 'updateProduk'])->name('profile.update.produk');
            Route::delete('{id}', [ProfilPerusahaanController::class, 'destroy'])->name('profile.delete.produk');
        });
    })->middleware('role:admin,manager');

    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'show'])->name('profile');
        Route::put('', [ProfileController::class, 'update'])->name('update-profile');
    })->middleware('role:admin,manager,visitor');

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
