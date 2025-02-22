<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DashboardPromosiEvent;
use App\Models\PromosiModel;
use App\Models\RiwayatPromosiModel;
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

class PromosiController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function dashboard(){
        try {
            if (Auth::check()){
            // Grafik Bulanan
            $currentYear = Carbon::now()->year;
            $defaultMonth = range(1, 12);
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

            return view('after-login.promosi.dashboard')->with([
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
            $promosiQuery = PromosiModel::with(['riwayat']);

            if ($role === 'avp-adm') {
                $promosiQuery->whereHas('riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                });
            }

            if ($role === 'mgr-adm'){
                $promosiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-csr'){
                $promosiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-comrel'){
                $promosiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf4'){
                $promosiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf5'){
                $promosiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf6'){
                $promosiQuery->whereHas('riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                });
            }

            $promosi = $promosiQuery->orderBy('tanggal', 'desc')
                    ->get();

                return view('after-login.promosi.pengajuan')
                    ->with([
                        'promosi' => $promosi
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
                $memoteo->storeAs('public/promosi', $filename);
            }

            $tanggal = now();
            $statusDef = 'proses';
            $promosi = promosiModel::create([
                'memoteo' => $filename,
                'tanggal' => $tanggal,
                'status' => $statusDef,
                'user_id' => auth()->user()->id
            ]);
            $riwayatpromosi = RiwayatPromosiModel::create([
                'status' => $statusDef,
                'promosi_id' => $promosi->id,
                'user_id' => auth()->user()->id,
                'tindakan' => 1,
                'peninjau' => 'am'
            ]);

            $data = [
                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                'jenis' => "Promosi"
            ];
            $email_target = 'riskyahmad0506@gmail.com';
            Mail::to($email_target)->send(new SendEmail($data));
            event(new DashboardPromosiEvent($promosi));
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
            $promosi = PromosiModel::findOrFail($id);
            if ($request->hasFile('edtmemoteo')) {
                $edtmemoteo = $request->file('edtmemoteo');
                $filename = time() . '-' . str_replace(' ', '-', $edtmemoteo->getClientOriginalName());
                $edtmemoteo->storeAs('public/promosi', $filename);
                if ($promosi->memoteo) {
                    Storage::disk('public')->delete('promosi/' . $promosi->memoteo);
                }
                $data['memoteo'] = $filename;
            }


            $promosi->update($data);
            $this->forgetPromosi();
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


        $promosi = PromosiModel::findOrFail($id);
            if (!$promosi) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Delete Berkas',
                    'text' => 'Data tidak ditemukan!'
                ]);
            }

            $imagePath = 'public/promosi/' . $promosi->lampiran;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            event(new DashboardpromosiEvent([
                'deleted_at' => time()
            ]));
            $promosi->delete();
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
            $promosi = PromosiModel::with(['riwayat'])->findOrFail($id);
                if ($promosi !== null) {
                    $riwayat_promosi = RiwayatPromosiModel::with('user')->where('promosi_id', $promosi->id)->orderBy('created_at', 'desc')->get();

                    return view('after-login.promosi.detail')->with([
                        'promosi' => $promosi,
                        'riwayat_promosi' => $riwayat_promosi
                    ]);
                } else {
                    return view('after-login.promosi.detail')->with([
                        'promosi' => $promosi
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
            $promosi = PromosiModel::with(['riwayat'])->first();
            $lastOfRiwayat = $promosi->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'promosi_id' => $promosi->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan
                ];
            $statuspromosi = null;

            if (isMgrAdmSection($lastOfRiwayat)){
                if ($request->verifikasi === 'review'){
                    $dataRiwayat['status'] = 'proses';
                    $statuspromosi = 'proses';
                    $dataRiwayat['peninjau'] = $request->peninjau;
                    $dataRiwayat['tindakan'] = 1;

                    if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Promosi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Promosi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Promosi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Promosi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Promosi"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statuspromosi = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'avp-adm';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!",
                        'jenis' => "Promosi"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isStaffSection($lastOfRiwayat)){
                if ($request->verifikasi === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statuspromosi = $request->verifikasi;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Promosi"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
                else if ($request->verifikasi === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi;
                    $statuspromosi = $request->verifikasi;
                    $dataRiwayat['peninjau'] = 'avp-adm';
                    $dataRiwayat['tindakan'] = 1;
                    $data = [
                        'text' => "Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!",
                        'jenis' => "Promosi"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isAVPAdmSection($lastOfRiwayat)){
                $dataRiwayat['status'] = 'proses';
                $statuspromosi = 'proses';
                $dataRiwayat['peninjau'] = 'mgr-adm';
                $dataRiwayat['tindakan'] = 1;

                $data = [
                    'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                    'jenis' => "Promosi"
                ];
                $email_target = 'riskyahmad0506@gmail.com';
                Mail::to($email_target)->send(new SendEmail($data));
            }


            $promosi->update([
                'status' => $statuspromosi
            ]);
            $riwayat = RiwayatPromosiModel::create($dataRiwayat);

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
