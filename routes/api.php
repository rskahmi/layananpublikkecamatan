<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramUnggulanController;
use App\Http\Controllers\ProposalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IsoController;
use App\Http\Controllers\PumkController;
use App\Http\Controllers\TjslController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\TautanController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\DetailPumkController;
use App\Http\Controllers\DetailTjslController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AnggaranTjslController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DetailPengajuanController;
use App\Http\Controllers\DokumentasiPumkController;
use App\Http\Controllers\DokumentasiTjslController;
use App\Http\Controllers\RiwayatProposalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/login', [AuthenticationController::class, 'login'])->name('login'); //->middleware('role:admin,manager,visitor');

// //Route::middleware(['access.control:admin'])->group(function () {
// // Route::prefix('/user')->group(function () {
// //     Route::get('', [UserController::class, 'show'])->name('get-user');
// //     Route::post('', [UserController::class, 'store'])->name('add-user');
// //     Route::put('{id}', [UserController::class, 'update'])->name('update-user');
// //     Route::delete('{id}', [UserController::class, 'destroy'])->name('delete-user');
// // });

// Route::prefix('resume')->group(function () {
//     // Route::get('', [ResumeController::class, 'tjslResume'])->name('get-resume');
//     // Route::get('', [ResumeController::class, 'pumkResume'])->name('get-resume');
//     Route::get('', [ResumeController::class, 'summary'])->name('get-resume');
//     Route::get('dashboard', [ResumeController::class, 'dashboard'])->name('resume.dashboard');
//     Route::get('detailtjsl/{detail_program}', [ResumeController::class, 'getTjslById'])->name('resume.detailTjsl');
// });

// Route::prefix('media')->group(function () {
//     Route::get('', [MediaController::class, 'show'])->name('get-media');
//     Route::get('monitoring', [MediaController::class, 'showMonitoring'])->name('media.monitoring');
//     Route::post('dashboard', [MediaController::class, 'dashboardMedia'])->name('media.dashboard');
//     Route::post('', [MediaController::class, 'store'])->name('media.store');
//     Route::put('{id}', [MediaController::class, 'update'])->name('media.update');
//     Route::delete('{id}', [MediaController::class, 'destroy'])->name('media.destroy');
// });

// Route::prefix('tjsl')->group(function () {
//     Route::get('', [TjslController::class, 'show'])->name('get-tjsl');
//     Route::get('monitoring', [TjslController::class, 'showMonitoring'])->name('tjsl.monitoring');
//     Route::get('anggaran', [TjslController::class, 'showAnggaran'])->name('tjsl.anggaran');
//     Route::post('dashboard', [TjslController::class, 'dashboardData'])->name('tjsl.dashboard');
//     Route::post('', [TjslController::class, 'store'])->name('tjsl.store');
//     Route::put('{id}', [TjslController::class, 'update'])->name('tjsl.update');
//     Route::delete('{id}', [TjslController::class, 'destroy'])->name('tjsl.destroy');
// })->middleware('role:admin,manager');

// Route::get('/detailTjsl/{id}', [DetailTjslController::class, 'getDetailTjsl'])->middleware('role:admin,manager');
// //Detail Tjsl
// Route::post('/anggaran', [AnggaranTjslController::class, 'store'])->middleware('role:admin,manager');
// Route::post('/dokumentasi-tjsl', [DokumentasiTjslController::class, 'store'])->middleware('role:admin,manager');

// Route::prefix('pumk')->group(function () {
//     Route::get('', [PumkController::class, 'show'])->name('pumk.show');
//     Route::get('/monitoring', [PumkController::class, 'showMonitoring'])->name('pumk.monitoring');
//     Route::post('', [PumkController::class, 'store'])->name('pumk.store');
//     Route::put('{id}', [PumkController::class, 'update'])->name('pumk.update');
//     Route::delete('{id}', [PumkController::class, 'destroy'])->name('pumk.destroy');
// })->middleware('role:admin,manager');
// //detail pumk
// // Route::get('detail-pumk/{id}', [DetailPumkController::class, 'getDetailPumk'])->name('pumk.detail')->middleware('role:admin,manager');

// Route::prefix('iso')->group(function () {
//     Route::get('', [IsoController::class, 'show'])->name('iso.show');
//     Route::post('', [IsoController::class, 'store'])->name('iso.store');
//     Route::put('{id}', [IsoController::class, 'update'])->name('iso.update');
//     Route::delete('{id}', [IsoController::class, 'destroy'])->name('iso.destroy');
// })->middleware('role:admin,manager');

// Route::prefix('program-unggulan')->group(function () {
//     Route::get('', [ProgramUnggulanController::class, 'show'])->name('program-unggulan');
//     Route::post('', [ProgramUnggulanController::class, 'store'])->name('program-unggulan.store');
//     Route::put('{id}', [ProgramUnggulanController::class, 'update'])->name('program-unggulan.update');
//     Route::delete('{id}', [ProgramUnggulanController::class, 'destroy'])->name('program-unggulan.destroy');
// })->middleware('role:admin,manager');

// Route::prefix('lembaga')->group(function () {
//     Route::get('', [LembagaController::class, 'show'])->name('lembaga.show');
//     Route::post('', [LembagaController::class, 'store'])->name('lembaga.store');
// })->middleware('role:admin,manager');

// Route::get('/detail-tjsl/{id}', [DetailTjslController::class, 'getDetailTjsl']);
// Route::post('/anggaran-tjsl', [AnggaranTjslController::class, 'store']);
// Route::post('/dokumentasi-tjsl', [DokumentasiTjslController::class, 'store']);


// Route::prefix('berkas')->group(function () {
//     Route::get('', [BerkasController::class, 'dashboard'])->name('berkas');
//     Route::get('/pengajuan', [BerkasController::class, 'showPengajuan'])->name('berkas.pengajuan');
//     Route::get('pengajuan/{id}', [DetailPengajuanController::class, 'getDetailPengajuan'])->name('berkas.detail');
//     Route::post('', [BerkasController::class, 'store'])->name('berkas.store');
//     Route::delete('{id}', [BerkasController::class, 'destroy'])->name('berkas.destroy');
//     Route::put('{id}', [BerkasController::class, 'update'])->name('berkas.update');
//     Route::post('/search/{keyword}', [BerkasController::class, 'search'])->name('berkas.search');
// });//->middleware('role:admin,manager');

// Route::get('detail-berkas/{id}', [DetailPengajuanController::class, 'getDetailPengajuan'])->name('berkas.detail');

// Route::prefix('tautan')->group(function () {
//     Route::get('', [TautanController::class, 'show'])->name('tautan.show');
//     Route::post('', [TautanController::class, 'store'])->name('tautan.store');
// })->middleware('role:admin,manager');

// Route::prefix('user')->group(function () {
//     Route::get('', [UserController::class, 'show'])->name('user.show')->middleware('auth', 'role:admin');
//     Route::get('dashboard', [UserController::class, 'dashboardData'])->name('user.dashboard');
//     Route::post('', [UserController::class, 'store'])->name('user.store');
//     Route::put('{id}', [UserController::class, 'update'])->name('user.update');
//     Route::delete('{id}', [UserController::class, 'destroy'])->name('user.destroy');
// })->middleware('role:admin,manager');

// Route::prefix('wilayah')->group(function () {
//     Route::get('', [WilayahController::class, 'show'])->name('wilayah.show');
//     Route::post('', [WilayahController::class, 'store'])->name('wilayah.store');
// })->middleware('role:admin,manager');

// Route::prefix('riwayat-proposal')->group(function () {
//     Route::get('', [RiwayatProposalController::class, 'show'])->name('riwayatproposal.show');
//     Route::post('', [RiwayatProposalController::class, 'store'])->name('riwayatproposal.store');
// })->middleware('role:admin,manager');

// Route::prefix('proposal')->group(function () {
//     Route::get('', [ProposalController::class, 'show'])->name('proposal.show');
//     Route::post('', [ProposalController::class, 'store'])->name('proposal.store');
// })->middleware('role:admin,manager');


// Route::prefix('pembayaran')->group(function () {
//     Route::get('', [PembayaranController::class, 'show'])->name('pembayaran.show');
//     Route::post('', [PembayaranController::class, 'store'])->name('pembayaran.store');
// })->middleware('role:admin,manager');

// Route::prefix('dokumentasi-pumk')->group(function () {
//     Route::get('', [DokumentasiPumkController::class, 'show'])->name('dokumentasiPumk.show');
//     Route::post('', [DokumentasiPumkController::class, 'store'])->name('dokumentasiPumk.store');
// })->middleware('role:admin,manager');

// Route::prefix('profile')->group(function () {
//     Route::get('', [ProfileController::class, 'show'])->name('profile');
//     Route::put('{id}', [ProfileController::class, 'update'])->name('profile.update');
// })->middleware('role:admin,manager');
