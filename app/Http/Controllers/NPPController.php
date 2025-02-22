<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NPPModel;
use App\Models\UMDModel;
use App\Models\ReimModel;
use App\Models\RiwayatReimModel;
use App\Models\RiwayatUMDModel;
use App\Traits\RulesTraits;
use Illuminate\Support\Facades\Validator;
use App\Events\DashboardBerkasEvent;
use App\Events\DashboardNPPEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Traits\CacheTimeout;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;






class NPPController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function dashboard(){
        try {
            if (Auth::check()){

                // Grafik Bulanan
                $currentYear = Carbon::now()->year;
                $defaultMonth = range(1, 12);
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
                return view('after-login.npp.dashboard')->with([
                    'total_umd' => $totalUMD,
                    'jumlah_status_proses_umd' => $jumlahStatusProsesUMD,
                    'jumlah_status_terima_umd' => $jumlahStatusTerimaUMD,
                    'total_reim' => $totalReim,
                    'jumlah_status_proses_reim' => $jumlahStatusProsesReim,
                    'jumlah_status_terima_reim' => $jumlahStatusTerimaReim,
                    'grafik_umd' => $grafikUMD,
                    'grafik_reim' => $grafikReim
                ]);
            }
            else {
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


    public function showPengajuan () {
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
            $nppQuery = NPPModel::with(['umd.riwayat', 'reim.riwayat']);


            if ($role === 'admin') {
                $nppQuery->whereHas('umd.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                })->orWhereHas('reim.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                });
            }

            if ($role === 'am'){
                $nppQuery->whereHas('umd.riwayat', function ($query) {
                    $query->where('peninjau', 'am')->where('tindakan', 1);
                })->orWhereHas('reim.riwayat', function ($query){
                    $query->where('peninjau', 'am')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-csr'){
                $nppQuery->whereHas('umd.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                })->orWhereHas('reim.riwayat', function ($query){
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-comrel'){
                $nppQuery->whereHas('umd.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                })->orWhereHas('reim.riwayat', function ($query){
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-comrel'){
                $nppQuery->whereHas('umd.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                })->orWhereHas('reim.riwayat', function ($query){
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf4'){
                $nppQuery->whereHas('umd.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                })->orWhereHas('reim.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf5'){
                $nppQuery->whereHas('umd.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                })->orWhereHas('reim.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf6'){
                $nppQuery->whereHas('umd.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                })->orWhereHas('reim.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                });
            }

            if ($role === 'mgr-adm'){
                $nppQuery->whereHas('umd.riwayat', function ($query) {
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                })->orWhereHas('reim.riwayat', function ($query){
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                });
            }

            if ($role === 'avp-adm'){
                $nppQuery->whereHas('umd.riwayat', function ($query) {
                    $query->where('peninjau', 'avp-adm')->where('tindakan', 1);
                })->orWhereHas('reim.riwayat', function ($query){
                    $query->where('peninjau', 'avp-adm')->where('tindakan', 1);
                });
            }

            if ($role === 'dhak'){
                $nppQuery->whereHas('umd.riwayat', function ($query) {
                    $query->where('peninjau', 'dhak')->where('tindakan', 1);
                })->orWhereHas('reim.riwayat', function ($query){
                    $query->where('peninjau', 'dhak')->where('tindakan', 1);
                });
            }

            $npp = $nppQuery->orderBy('tanggal', 'desc')
                ->get();
            return view('after-login.npp.pengajuan') -> with([
                'npp' => $npp
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
                'jenis' => 'required'
            ], [
                'jenis.required' => $this->jenisNPPMessage()
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
            $npp = NPPModel::create([
                'jenis' => $request->jenis,
                'tanggal' => $tanggal,
                'user_id' => auth()->user()->id
            ]);

            if ($npp) {
                if (Str::lower($request->jenis) == "umd"){
                    $filename = null;
                    if ($request->hasFile('berkasrab')){
                        $berkasrab = $request->file('berkasrab');
                        $filename = time() . '-' . str_replace(' ','-', $berkasrab->getClientOriginalName());
                        $berkasrab->storeAs('public/npp', $filename);
                    }

                    $statusDef = 'diajukan';
                    $umd = UMDModel::create([
                        'status' => $statusDef,
                        'berkasrab' => $filename,
                        'npp_id' => $npp->id,
                    ]);

                    $riwayatUmd = RiwayatUMDModel::create([
                        'status' => $statusDef,
                        'umd_id' => $umd->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'am'
                    ]);

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "UMD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                else if (Str::lower($request->jenis) == "reim"){
                    $filename2 = null;
                    if ($request->hasFile('berkasnpp')){
                        $berkasnpp = $request->file('berkasnpp');
                        $filename2 = time() . '-' . str_replace(' ','-', $berkasnpp->getClientOriginalName());
                        $berkasnpp->storeAs('public/npp', $filename2);
                    }

                    $filename3 = null;
                    if ($request->hasFile('nota')){
                        $nota = $request->file('nota');
                        $filename3 = time() . '-' . str_replace(' ','-', $nota->getClientOriginalName());
                        $nota->storeAs('public/npp', $filename3);
                    }

                    $filename4 = null;
                    if ($request->hasFile('kwitansi')){
                        $kwitansi = $request->file('kwitansi');
                        $filename4 = time() . '-' . str_replace(' ','-', $kwitansi->getClientOriginalName());
                        $kwitansi->storeAs('public/npp', $filename4);
                    }

                    $filename5 = null;
                    if ($request->hasFile('dokumenpersetujuan')){
                        $dokumenpersetujuan = $request->file('dokumenpersetujuan');
                        $filename5 = time() . '-' . str_replace(' ','-', $dokumenpersetujuan->getClientOriginalName());
                        $dokumenpersetujuan->storeAs('public/npp', $filename5);
                    }

                    $statusDef = 'diajukan';
                    $reim = ReimModel::create([
                        'status' => $statusDef,
                        'berkasnpp' => $filename2,
                        'nota' => $filename3,
                        'kwitansi' => $filename4,
                        'dokumenpersetujuan' => $filename5,
                        'npp_id' => $npp->id,
                    ]);

                    $riwayatReim = RiwayatReimModel::create([
                        'status' => $statusDef,
                        'reim_id' => $reim->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'am'
                    ]);

                    $data = [
                        'text' => "Pengajuan Baru Masuk",
                        'jenis' => "Reimburstment",
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
            }


            event(new DashboardNPPEvent($npp));
            $this->forgetNPP();


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

        public function update(Request $request, $id){
            try {
                $validator = Validator::make($request->all(),[
                    'edtJenis' => 'required',
                ], [
                    'edtJenis.required' => $this->jenisNPPMessage(),
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

                $npp = NPPModel::findOrFail($id);
                $data = [
                    'jenis' => $request->edtJenis
                ];

                $npp->update($data);

                if($data){
                    if (Str::lower($request->edtJenis) == "umd"){
                        $filename = null;
                        if ($request->hasFile('edtberkasrab')){
                            $edtberkasrab = $request->file('edtberkasrab');
                            $filename = time() . '-' . str_replace(' ','-', $edtberkasrab->getClientOriginalName());
                            $edtberkasrab->storeAs('public/npp', $filename);
                            if($npp->berkasrab){
                                Storage::disk('public')->delete('npp/' . $npp->berkasrab);
                            }
                            $data['berkasrab'] = $filename;

                            $umd = UMDModel::where('npp_id', $npp->id);
                            $umd->update([
                                'berkasrab' => $filename
                            ]);
                        }
                    }

                    else if (Str::lower($request->edtJenis) == "reim"){
                        $filename2 = $npp->reim->berkasnpp;
                        if ($request->hasFile('edtberkasnpp')){
                            $edtberkasnpp = $request->file('edtberkasnpp');
                            $filename2 = time() . '-' . str_replace(' ','-', $edtberkasnpp->getClientOriginalName());
                            $edtberkasnpp->storeAs('public/npp', $filename2);
                            if($npp->berkasnpp){
                                Storage::disk('public')->delete('npp/' . $npp->berkasnpp);
                            }
                            $data['berkasnpp'] = $filename2;
                        }

                    $filename3 = $npp->reim->nota;
                    if ($request->hasFile('edtnota')){
                        $edtnota = $request->file('edtnota');
                        $filename3 = time() . '-' . str_replace(' ','-', $edtnota->getClientOriginalName());
                        $edtnota->storeAs('public/npp', $filename3);
                        if($npp->nota){
                        Storage::disk('public')->delete('npp/' . $npp->nota);
                        }
                        $data['nota'] = $filename3;
                    }

                    $filename4 = $npp->reim->kwitansi;
                    if ($request->hasFile('edtkwitansi')){
                        $edtkwitansi = $request->file('edtkwitansi');
                        $filename4 = time() . '-' . str_replace(' ','-', $edtkwitansi->getClientOriginalName());
                        $edtkwitansi->storeAs('public/npp', $filename4);
                        if($npp->kwitansi){
                            Storage::disk('public')->delete('npp/' . $npp->kwitansi);
                        }
                        $data['kwitansi'] = $filename4;
                    }

                    $filename5 = $npp->reim->dokumenpersetujuan;
                    if ($request->hasFile('edtdokumenpersetujuan')){
                        $edtdokumenpersetujuan = $request->file('edtdokumenpersetujuan');
                        $filename5 = time() . '-' . str_replace(' ','-', $edtdokumenpersetujuan->getClientOriginalName());
                        $edtdokumenpersetujuan->storeAs('public/npp', $filename5);
                        if($npp->dokumenpersetujuan){
                            Storage::disk('public')->delete('npp/' . $npp->dokumenpersetujuan);
                        }
                        $data['dokumenpersetujuan'] = $filename5;
                    }

                    $reim = ReimModel::where('npp_id', $npp->id);
                    $reim->update([
                    'berkasnpp' => $filename2,
                    'nota' => $filename3,
                    'kwitansi' => $filename4,
                    'dokumenpersetujuan' => $filename5
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

        public function destroy (Request $request, $id){
            try {
                $npp = NPPModel::findOrFail($id);

                if (!$npp) {
                    return redirect()->back->with('alert', [
                        'type' => 'error',
                        'title' => 'Delete Berkas',
                        'text' => 'Data tidak ditemukan!'
                    ]);
                }

                $imagePath = 'public/npp/' . $npp->berkasrab;
                if (File::exists($imagePath)){
                    File::delete($imagePath);
                }

                $imagePath2 = 'public/npp/' . $npp->berkasnpp;
                if (File::exists($imagePath2)){
                    File::delete($imagePath2);
                }

                $imagePath3 = 'public/npp/' . $npp->nota;
                if (File::exists($imagePath3)){
                    File::delete($imagePath3);
                }

                $imagePat4 = 'public/npp/' . $npp->kwitansi;
                if (File::exists($imagePat4)){
                    File::delete($imagePat4);
                }

                $imagePath5 = 'public/npp/' . $npp->dokumenpersetujuan;
                if (File::exists($imagePath5)){
                    File::delete($imagePath5);
                }

                event(new DashboardNPPEvent ([
                    'delete_at' => time()
                ]));

                $npp->delete();
                $this->forgetNPP();

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

        public function getDetailPengajuan($id) {
            try {
                $npp = NPPModel::with(['umd.riwayat', 'reim.riwayat'])->findOrFail($id);
                if ($npp->umd !== null) {
                    $riwayat_umd = RiwayatUMDModel::with('user')->where('umd_id', $npp->umd->id)->orderBy('created_at', 'desc')->get();
                    return view('after-login.npp.detail')-> with ([
                        'npp' => $npp,
                        'riwayat_umd' => $riwayat_umd
                    ]);
                }
                else if ($npp->reim !== null) {
                    $riwayat_reim = RiwayatReimModel::with('user')->where('reim_id', $npp->reim->id)->orderBy('created_at', 'desc')->get();
                    return view('after-login.npp.detail')-> with ([
                        'npp' => $npp,
                        'riwayat_reim' => $riwayat_reim
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

        public function verifikasiUMD(Request $request, $id)
        {
            try {
                $umd = UMDModel::with(['npp', 'riwayat'])->where('npp_id', $id)->first();
                $lastOfRiwayat = $umd->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'umd_id' => $umd->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan
                ];
                $statusUMD = null;

                if (isManagerSection($lastOfRiwayat)){
                    if (isset($request->verifikasi_npp) && $request->verifikasi_npp === 'ditolak') {
                        if (isset($lastOfRiwayat->user_id)) {
                            $dataRiwayat['status'] = $request->verifikasi_npp;
                            $dataRiwayat['peninjau'] = 'admin';
                            $dataRiwayat['tindakan'] = 1;
                            $dataRiwayat['status_verifikasi'] = "Sudah Verifikasi";
                            $statusUMD = $request->verifikasi_npp;

                            $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'UMD',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));

                        } else {
                            // Tangani kasus jika user_id tidak ditemukan
                            throw new Exception('User ID not found for this Riwayat');
                        }
                    }
                    else if ($request->verifikasi_npp === 'review'){
                        $dataRiwayat['status'] = 'proses';
                        $statusUMD = 'proses';
                        $dataRiwayat['peninjau'] = $request->peninjau;
                        $dataRiwayat['tindakan'] = 1;
                        // $dataRiwayat['status_verifikasi'] = "sudah-verifikasi";


                        if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "UMD"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "UMD"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "UMD"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "UMD"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "UMD"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }


                    }

                }

                else if (isStaffSection($lastOfRiwayat)){
                    if ($request->verifikasi_npp === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusUMD = 'proses';
                        $dataRiwayat['peninjau'] = 'mgr-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "UMD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_npp === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_npp;
                        $statusUMD = $request->verifikasi_npp;
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

                else if (isMgrAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi_npp === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusUMD = 'proses';
                        $dataRiwayat['peninjau'] = 'avp-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "UMD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_npp === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_npp;
                        $statusUMD = $request->verifikasi_npp;
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
                    if ($request->verifikasi_npp === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusUMD = 'proses';
                        $dataRiwayat['peninjau'] = 'dhak';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "UMD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_npp === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_npp;
                        $statusUMD = $request->verifikasi_npp;
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

                else if (isDHAKSection($lastOfRiwayat)){
                    if ($request->verifikasi_npp === 'diterima'){
                        $dataRiwayat['status'] = $request->verifikasi_npp;
                        $statusUMD = $request->verifikasi_npp;
                        $dataRiwayat['peninjau'] = '-';
                        $dataRiwayat['tindakan'] = 0;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "UMD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_npp === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_npp;
                        $statusUMD = $request->verifikasi_npp;
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

                else if (isUserSection($lastOfRiwayat)){
                    $dataRiwayat['status'] = 'proses';
                    $statusUMD = 'proses';
                    $dataRiwayat['peninjau'] = 'am';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "UMD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                $umd->update([
                    'status' => $statusUMD
                ]);

                $riwayat = RiwayatUMDModel::create($dataRiwayat);

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

        public function verifikasiReim(Request $request, $id){
            try {
                $reim = ReimModel::with(['npp', 'riwayat'])->where('npp_id', $id)->first();
                $lastOfRiwayat = $reim->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'reim_id' => $reim->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan
                ];
                $statusReim = null;

                if (isManagerSection($lastOfRiwayat)){
                    if (isset($request->verifikasi_npp) && $request->verifikasi_npp === 'ditolak') {
                        if (isset($lastOfRiwayat->user_id)) {
                            // Perbarui data riwayat
                            $dataRiwayat['status'] = $request->verifikasi_npp;
                            $dataRiwayat['peninjau'] = 'admin';
                            $dataRiwayat['tindakan'] = 1;
                            $statusReim = $request->verifikasi_npp;

                            // Ambil email target
                            $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Reimburstment',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                        } else {
                            // Tangani kasus jika user_id tidak ditemukan
                            throw new Exception('User ID not found for this Riwayat');
                        }
                    }

                    else if ($request->verifikasi_npp === 'review'){
                        $dataRiwayat['status'] = 'proses';
                        $statusReim = 'proses';
                        $dataRiwayat['peninjau'] = $request->peninjau;
                        $dataRiwayat['tindakan'] = 1;

                        if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Reimburstment"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Reimburstment"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Reimburstment"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Reimburstment"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Reimburstment"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                    }
                }

                else if (isStaffSection($lastOfRiwayat)){
                    if ($request->verifikasi_npp === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusReim = 'proses';
                        $dataRiwayat['peninjau'] = 'mgr-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Reimburstment"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_npp === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_npp;
                        $statusReim = $request->verifikasi_npp;
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

                else if (isMgrAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi_npp === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusReim = 'proses';
                        $dataRiwayat['peninjau'] = 'avp-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Reimburstment"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_npp === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_npp;
                        $statusReim = $request->verifikasi_npp;
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
                    if ($request->verifikasi_npp === 'diterima'){
                        $dataRiwayat['status'] = $request->verifikasi_npp;
                        $statusReim = $request->verifikasi_npp;
                        $dataRiwayat['peninjau'] = '-';
                        $dataRiwayat['tindakan'] = 0;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Reimburstment"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_npp === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_npp;
                        $statusReim = $request->verifikasi_npp;
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



                else if (isUserSection($lastOfRiwayat)){
                    $dataRiwayat['status'] = 'proses';
                    $statusReim = 'proses';
                    $dataRiwayat['peninjau'] = 'am';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "UMD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }





                $reim->update([
                    'status' => $statusReim
                ]);
                $riwayat = RiwayatReimModel::create($dataRiwayat);
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

