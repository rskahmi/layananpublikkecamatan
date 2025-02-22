<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DashboardRDEvent;
use App\Models\RDModel;
use App\Models\BaruModel;
use App\Models\GantiModel;
use App\Models\KembalikanModel;
use App\Models\PenerbitanModel;
use App\Models\RiwayatPenerbitanModel;
use App\Models\RiwayatBaruModel;
use App\Models\RiwayatGantiModel;
use App\Models\RiwayatKembalikanModel;
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

class RDController extends Controller
{
    use CacheTimeout, RulesTraits;

    public function dashboard(){
        try {
            if (Auth::check()){

                // Grafik Bulanan
                $currentYear = Carbon::now()->year;
                $defaultMonth = range(1, 12);

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

                return view('after-login.rd.dashboard')->with([
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
                    'jumlah_status_terima_kembalikan' => $jumlahStatusTerimaKembalikan
                ]);

            } else {
                return redirect()->route('auth');
            }
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
            $rdQuery = RDModel::with(['baru.riwayat', 'ganti.riwayat', 'kembalikan.riwayat']);


            if ($role === 'admin') {
                $rdQuery->whereHas('baru.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                })->orWhereHas('ganti.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                })->orWhereHas('kembalikan.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                });
            }


            if ($role === 'am'){
                $rdQuery->whereHas('baru.riwayat', function ($query) {
                    $query->where('peninjau', 'am')->where('tindakan', 1);
                })->orWhereHas('ganti.riwayat', function ($query){
                    $query->where('peninjau', 'am')->where('tindakan', 1);
                })->orWhereHas('kembalikan.riwayat', function ($query){
                    $query->where('peninjau', 'am')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-csr'){
                $rdQuery->whereHas('baru.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                })->orWhereHas('ganti.riwayat', function ($query){
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                })->orWhereHas('kembalikan.riwayat', function ($query){
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-comrel'){
                $rdQuery->whereHas('baru.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                })->orWhereHas('ganti.riwayat', function ($query){
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                })->orWhereHas('kembalikan.riwayat', function ($query){
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf4'){
                $rdQuery->whereHas('baru.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                })->orWhereHas('ganti.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                })->orWhereHas('kembalikan.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf5'){
                $rdQuery->whereHas('baru.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                })->orWhereHas('ganti.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                })->orWhereHas('kembalikan.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf6'){
                $rdQuery->whereHas('baru.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                })->orWhereHas('ganti.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                })->orWhereHas('kembalikan.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                });
            }

            if ($role === 'sarana'){
                $rdQuery->whereHas('baru.riwayat', function ($query) {
                    $query->where('peninjau', 'sarana')->where('tindakan', 1);
                })->orWhereHas('ganti.riwayat', function ($query){
                    $query->where('peninjau', 'sarana')->where('tindakan', 1);
                })->orWhereHas('kembalikan.riwayat', function ($query){
                    $query->where('peninjau', 'sarana')->where('tindakan', 1);
                });
            }



            if ($role === 'mgr-adm'){
                $rdQuery->whereHas('baru.riwayat', function ($query) {
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                })->orWhereHas('ganti.riwayat', function ($query){
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                })->orWhereHas('kembalikan.riwayat', function ($query){
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                });
            }

            if ($role === 'avp-adm'){
                $rdQuery->whereHas('baru.riwayat', function ($query) {
                    $query->where('peninjau', 'avp-adm')->where('tindakan', 1);
                })->orWhereHas('ganti.riwayat', function ($query){
                    $query->where('peninjau', 'avp-adm')->where('tindakan', 1);
                })->orWhereHas('kembalikan.riwayat', function ($query){
                    $query->where('peninjau', 'avp-adm')->where('tindakan', 1);
                });
            }

            $rd = $rdQuery->orderBy('tanggal', 'desc')
                ->get();

            return view('after-login.rd.pengajuan')
                ->with([
                    'rd' => $rd
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

    public function store (Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'jenis' => 'required'
            ], [
                'jenis.required' => $this->jenisRDMessage()
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
            $rd = RDModel::create([
                'jenis' => $request->jenis,
                'tanggal' => $tanggal,
                'user_id' => auth()->user()->id
            ]);

            if ($rd) {
                if (Str::lower($request->jenis) == "baru"){
                    $filename = null;
                    if ($request->hasFile('suratpermohonanbaru')){
                        $suratpermohonanbaru = $request->file('suratpermohonanbaru');
                        $filename = time() . '-' . str_replace(' ','-', $suratpermohonanbaru->getClientOriginalName());
                        $suratpermohonanbaru->storeAs('public/rd', $filename);
                    }

                    $statusDef = 'diajukan';
                    $baru = BaruModel::create([
                        'status' => $statusDef,
                        'suratpermohonanbaru' => $filename,
                        'rd_id' => $rd->id,
                    ]);

                    $riwayatBaru = RiwayatBaruModel::create([
                        'status' => $statusDef,
                        'baru_id' => $baru->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'am'
                    ]);

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Pengajuan RD Baru"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                else if (Str::lower($request->jenis) === "ganti"){
                    $filename2 = null;
                    if ($request->hasFile('suratpermohonanganti')){
                        $suratpermohonanganti = $request->file('suratpermohonanganti');
                        $filename2 = time() . '-' . str_replace(' ','-', $suratpermohonanganti->getClientOriginalName());
                        $suratpermohonanganti->storeAs('public/npp', $filename2);
                    }

                    $filename3 = null;
                    if ($request->hasFile('simrd')){
                        $simrd = $request->file('simrd');
                        $filename3 = time() . '-' . str_replace(' ','-', $simrd->getClientOriginalName());
                        $simrd->storeAs('public/npp', $filename3);
                    }

                    $statusDef = 'diajukan';
                    $ganti = GantiModel::create([
                        'status' => $statusDef,
                        'suratpermohonanganti' => $filename2,
                        'simrd' => $filename3,
                        'rd_id' => $rd->id,
                    ]);

                    $riwayatGanti = RiwayatGantiModel::create([
                        'status' => $statusDef,
                        'ganti_id' => $ganti->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'am'
                    ]);

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Pengajuan Penggantian RD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                else if (Str::lower($request->jenis) == "kembalikan"){
                    $filename4 = null;
                    if ($request->hasFile('suratpermohonankembalikan')){
                        $suratpermohonankembalikan = $request->file('suratpermohonankembalikan');
                        $filename4 = time() . '-' . str_replace(' ','-', $suratpermohonankembalikan->getClientOriginalName());
                        $suratpermohonankembalikan->storeAs('public/npp', $filename4);
                    }
                    $statusDef = 'diajukan';
                    $kembalikan = KembalikanModel::create([
                        'status' => $statusDef,
                        'suratpermohonankembalikan' => $filename4,
                        'rd_id' => $rd->id,
                    ]);

                    $riwayatKembalikan = RiwayatKembalikanModel::create([
                        'status' => $statusDef,
                        'kembalikan_id' => $kembalikan->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'am'
                    ]);

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Pengajuan Pengembalian RD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            event(new DashboardRDEvent($rd));
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

    public function destroy (Request $request, $id){
        try {
            $rd = RDModel::findOrFail($id);
                if (!$rd) {
                    return redirect()->back->with('alert', [
                        'type' => 'error',
                        'title' => 'Delete Berkas',
                        'text' => 'Data tidak ditemukan!'
                    ]);
                }

                $imagePath = 'public/rd/' . $rd->suratpermohonanbaru;
                if (File::exists($imagePath)){
                    File::delete($imagePath);
                }

                $imagePath = 'public/rd/' . $rd->suratpermohonanganti;
                if (File::exists($imagePath)){
                    File::delete($imagePath);
                }

                $imagePath = 'public/rd/' . $rd->simrd;
                if (File::exists($imagePath)){
                    File::delete($imagePath);
                }

                $imagePath = 'public/rd/' . $rd->suratpermohonankembalikan;
                if (File::exists($imagePath)){
                    File::delete($imagePath);
                }

                event(new DashboardRDEvent ([
                    'delete_at' => time()
                ]));

                $rd->delete();
                $this->forgetRD();

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

    public function update (Request $request, $id){
        try {
            $validator = Validator::make($request->all(),[
                'edtJenis' => 'required',
            ], [
                'edtJenis.required' => $this->jenisRDMessage(),
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

            $rd = RDModel::findOrFail($id);
                $data = [
                    'jenis' => $request->edtJenis
                ];


                if($data){
                    if (Str::lower($request->edtJenis) == "baru"){
                        $filename = null;
                        if ($request->hasFile('edtsuratpermohonanbaru')){
                            $edtsuratpermohonanbaru = $request->file('edtsuratpermohonanbaru');
                            $filename = time() . '-' . str_replace(' ','-', $edtsuratpermohonanbaru->getClientOriginalName());
                            $edtsuratpermohonanbaru->storeAs('public/rd', $filename);
                            if($rd->suratpermohonanbaru){
                                Storage::disk('public')->delete('rd/' . $rd->suratpermohonanbaru);
                            }
                            $data['suratpermohonanbaru'] = $filename;

                            $baru = BaruModel::where('rd_id', $rd->id);
                            $baru->update([
                                'suratpermohonanbaru' => $filename
                            ]);
                        }
                    }

                    else if (Str::lower($request->edtJenis) == "ganti"){
                        $filename2 = $rd->ganti->suratpermohonanganti;
                        if ($request->hasFile('edtsuratpermohonanganti')){
                            $edtsuratpermohonanganti = $request->file('edtsuratpermohonanganti');
                            $filename2 = time() . '-' . str_replace(' ','-', $edtsuratpermohonanganti->getClientOriginalName());
                            $edtsuratpermohonanganti->storeAs('public/rd', $filename2);
                            if($rd->suratpermohonanganti){
                                Storage::disk('public')->delete('rd/' . $rd->suratpermohonanganti);
                            }
                            $data['suratpermohonanganti'] = $filename2;
                        }
                        else {
                            $data['suratpermohonanganti'] = $filename2;
                        }

                        $filename3 = $rd->ganti->simrd;
                        if ($request->hasFile('edtsimrd')){
                            $edtsimrd = $request->file('edtsimrd');
                            $filename3 = time() . '-' . str_replace(' ','-', $edtsimrd->getClientOriginalName());
                            $edtsimrd->storeAs('public/rd', $filename3);
                            if($rd->simrd){
                            Storage::disk('public')->delete('rd/' . $rd->simrd);
                            }
                            $data['simrd'] = $filename3;
                        }
                        else {
                            $data['simrd'] = $filename3;
                        }

                        $ganti = GantiModel::where('rd_id', $rd->id);
                        $ganti->update([
                        'suratpermohonanganti' => $filename2,
                        'simrd' => $filename3,
                        ]);
                    }

                    else if (Str::lower($request->edtJenis) == "kembalikan"){
                        $filename4 = null;
                        if ($request->hasFile('edtsuratpermohonankembalikan')){
                            $edtsuratpermohonankembalikan = $request->file('edtsuratpermohonankembalikan');
                            $filename4 = time() . '-' . str_replace(' ','-', $edtsuratpermohonankembalikan->getClientOriginalName());
                            $edtsuratpermohonankembalikan->storeAs('public/rd', $filename4);
                            if($rd->suratpermohonankembalikan){
                                Storage::disk('public')->delete('rd/' . $rd->suratpermohonankembalikan);
                            }
                            $data['suratpermohonankembalikan'] = $filename4;
                        }

                        $kembalikan = KembalikanModel::where('rd_id', $rd->id);
                        $kembalikan->update([
                        'suratpermohonankembalikan' => $filename4,
                        ]);
                    }
        }

                $rd->update($data);
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

    public function getDetailPengajuan($id){
        try {
            $rd = RDModel::with(['baru.riwayat', 'ganti.riwayat', 'kembalikan.riwayat'])->findOrFail($id);
                if ($rd->baru !== null) {
                    $riwayat_baru = RiwayatBaruModel::with('user')->where('baru_id', $rd->baru->id)->orderBy('created_at', 'desc')->get();
                    return view('after-login.rd.detail')-> with ([
                        'rd' => $rd,
                        'riwayat_baru' => $riwayat_baru
                    ]);
                }
                else if ($rd->ganti !== null) {
                    $riwayat_ganti = RiwayatGantiModel::with('user')->where('ganti_id', $rd->ganti->id)->orderBy('created_at', 'desc')->get();
                    return view('after-login.rd.detail')-> with ([
                        'rd' => $rd,
                        'riwayat_ganti' => $riwayat_ganti
                    ]);
                }

                else if ($rd->kembalikan !== null) {
                    $riwayat_kembalikan = RiwayatKembalikanModel::with('user')->where('kembalikan_id', $rd->kembalikan->id)->orderBy('created_at', 'desc')->get();
                    return view('after-login.rd.detail')-> with ([
                        'rd' => $rd,
                        'riwayat_kembalikan' => $riwayat_kembalikan
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

    public function verifikasiBaru(Request $request, $id){
        try {
            $baru = BaruModel::with(['rd', 'riwayat'])->where('rd_id', $id)->first();

            $filename = null;
            if ($request->hasFile('dokumentasi_sarpras')) {
                $dokumentasi_sarpras = $request->file('dokumentasi_sarpras');
                $filename = time() . '-' . str_replace(' ', '-', $dokumentasi_sarpras->getClientOriginalName());
                $dokumentasi_sarpras->storeAs('public/rd', $filename);
            }
            
            $lastOfRiwayat = $baru->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'baru_id' => $baru->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan,
                    'dokumentasi_sarpras' => $filename
                ];
                $statusBaru = null;

                if (isManagerSection($lastOfRiwayat)){
                    if (isset($request->verifikasi_rd) && $request->verifikasi_rd === 'ditolak') {
                        if (isset($lastOfRiwayat->user_id)) {
                            $dataRiwayat['status'] = $request->verifikasi_rd;
                            $dataRiwayat['peninjau'] = 'admin';
                            $dataRiwayat['tindakan'] = 1;
                            $statusBaru = $request->verifikasi_rd;

                            $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Pengajuan RD Baru',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));

                        } else {
                            throw new Exception('User ID not found for this Riwayat');
                        }
                    }
                    else if ($request->verifikasi_rd === 'review'){
                        $dataRiwayat['status'] = 'proses';
                        $statusBaru = 'proses';
                        $dataRiwayat['peninjau'] = $request->peninjau;
                        $dataRiwayat['tindakan'] = 1;

                        if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Pengajuan RD Baru"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Pengajuan RD Baru"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Pengajuan RD Baru"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Pengajuan RD Baru"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Pengajuan RD Baru"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                    }
                }

                else if (isStaffSection($lastOfRiwayat)){
                    if ($request->verifikasi_rd === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusBaru = 'proses';
                        $dataRiwayat['peninjau'] = 'sarana';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Pengajuan RD Baru"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_rd === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_rd;
                        $statusBaru = $request->verifikasi_rd;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Pengajuan RD Baru',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isSaranaSection($lastOfRiwayat)){
                    $dataRiwayat['status'] = 'proses';
                    $statusBaru = 'proses';
                    $dataRiwayat['peninjau'] = 'mgr-adm';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Pengajuan RD Baru"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                else if (isMgrAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi_rd === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusBaru = 'proses';
                        $dataRiwayat['peninjau'] = 'avp-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Pengajuan RD Baru"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_rd === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_rd;
                        $statusBaru = $request->verifikasi_rd;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Pengajuan RD Baru',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isAVPAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi_rd === 'diterima'){
                        $dataRiwayat['status'] = $request->verifikasi_rd;
                        $statusBaru = $request->verifikasi_rd;
                        $dataRiwayat['peninjau'] = '-';
                        $dataRiwayat['tindakan'] = 0;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Pengajuan RD Baru"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_rd === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_rd;
                        $statusBaru = $request->verifikasi_rd;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Pengajuan RD Baru',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isUserSection($lastOfRiwayat)){
                    $dataRiwayat['status'] = 'proses';
                    $statusBaru = 'proses';
                    $dataRiwayat['peninjau'] = 'am';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan Sudah Diperbarui, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Pengajuan RD Baru"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                $baru->update([
                    'status' => $statusBaru
                ]);
                $riwayat = RiwayatBaruModel::create($dataRiwayat);

                if (Str::lower($request->verifikasi_rd) === 'diterima') {
                    $this->saveToPenerbitanBaru($baru, $baru->rd);
                }

                $this->forgetNPP();
                return redirect()->back()->with('alert', [
                    'type' => 'success',
                    'title' => 'Verifikasi',
                    'text' => 'Berhasil verifikasi berkas'
                ]);
        } catch (Exception $e) {
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

    public function verifikasiGanti(Request $request, $id){
        try {
            $ganti = GantiModel::with(['rd', 'riwayat'])->where('rd_id', $id)->first();
            $lastOfRiwayat = $ganti->riwayat->sortBy('created_at')->last();
            $dataRiwayat = [
                'ganti_id' => $ganti->id,
                'user_id' => auth()->user()->id,
                'alasan' => $request->keterangan
            ];
            $statusGanti = null;

            if (isManagerSection($lastOfRiwayat)){
                if (isset($request->verifikasi_rd) && $request->verifikasi_rd === 'ditolak') {
                    if (isset($lastOfRiwayat->user_id)) {
                        $dataRiwayat['status'] = $request->verifikasi_rd;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;
                        $statusGanti = $request->verifikasi_rd;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Pengajuan Penggantian RD',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    } else {
                        // Tangani kasus jika user_id tidak ditemukan
                        throw new Exception('User ID not found for this Riwayat');
                    }
                }
                else if ($request->verifikasi_rd === 'review'){
                    $dataRiwayat['status'] = 'proses';
                    $statusGanti = 'proses';
                    $dataRiwayat['peninjau'] = $request->peninjau;
                    $dataRiwayat['tindakan'] = 1;

                    if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Pengajuan Penggantian RD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Pengajuan Penggantian RD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Pengajuan Penggantian RD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Pengajuan Penggantian RD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Pengajuan Penggantian RD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                }
            }

            else if (isStaffSection($lastOfRiwayat)){
                if ($request->verifikasi_rd === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusGanti = 'proses';
                    $dataRiwayat['peninjau'] = 'sarana';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Pengajuan Penggantian RD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
                else if ($request->verifikasi_rd === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi_rd;
                    $statusGanti = $request->verifikasi_rd;
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

            else if (isSaranaSection($lastOfRiwayat)){
                $dataRiwayat['status'] = 'proses';
                $statusGanti = 'proses';
                $dataRiwayat['peninjau'] = 'mgr-adm';
                $dataRiwayat['tindakan'] = 1;

                $data = [
                    'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                    'jenis' => "Pengajuan Penggantian RD"
                ];
                $email_target = 'riskyahmad0506@gmail.com';
                Mail::to($email_target)->send(new SendEmail($data));
            }

            else if (isMgrAdmSection($lastOfRiwayat)){
                if ($request->verifikasi_rd === 'diterima'){
                    $dataRiwayat['status'] = 'proses';
                    $statusGanti = 'proses';
                    $dataRiwayat['peninjau'] = 'avp-adm';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Pengajuan Penggantian RD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
                else if ($request->verifikasi_rd === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi_rd;
                    $statusGanti = $request->verifikasi_rd;
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
                if ($request->verifikasi_rd === 'diterima'){
                    $dataRiwayat['status'] = $request->verifikasi_rd;
                    $statusGanti = $request->verifikasi_rd;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Pengajuan Penggantian RD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
                else if ($request->verifikasi_rd === 'ditolak'){
                    $dataRiwayat['status'] = $request->verifikasi_rd;
                    $statusGanti = $request->verifikasi_rd;
                    $dataRiwayat['peninjau'] = 'admin';
                    $dataRiwayat['tindakan'] = 1;

                    $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Pengajuan Penggantian RD',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                }
            }

            else if (isUserSection($lastOfRiwayat)){
                $dataRiwayat['status'] = 'proses';
                $statusGanti = 'proses';
                $dataRiwayat['peninjau'] = 'am';
                $dataRiwayat['tindakan'] = 1;

                $data = [
                    'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                    'jenis' => "UMD"
                ];
                $email_target = 'riskyahmad0506@gmail.com';
                Mail::to($email_target)->send(new SendEmail($data));
            }


            $ganti->update([
                'status' => $statusGanti
            ]);

            $riwayat = RiwayatGantiModel::create($dataRiwayat);

            if (Str::lower($request->verifikasi_rd) === 'diterima') {
                $this->saveToPenerbitanGanti($ganti, $ganti->rd);
            }

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

    public function verifikasiKembalikan(Request $request, $id){
        try {
            $kembalikan = KembalikanModel::with(['rd', 'riwayat'])->where('rd_id', $id)->first();
            $lastOfRiwayat = $kembalikan->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'kembalikan_id' => $kembalikan->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan
                ];
                $statusKembalikan = null;

                if (isManagerSection($lastOfRiwayat)){
                    if (isset($request->verifikasi_rd) && $request->verifikasi_rd === 'ditolak') {
                        if (isset($lastOfRiwayat->user_id)) {
                            $dataRiwayat['status'] = $request->verifikasi_rd;
                            $dataRiwayat['peninjau'] = 'admin';
                            $dataRiwayat['tindakan'] = 1;
                            $statusKembalikan = $request->verifikasi_rd;

                            $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Pengajuan Pengembalian RD',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                        } else {
                            // Tangani kasus jika user_id tidak ditemukan
                            throw new Exception('User ID not found for this Riwayat');
                        }
                    }
                    else if ($request->verifikasi_rd === 'review'){
                        $dataRiwayat['status'] = 'proses';
                        $statusKembalikan = 'proses';
                        $dataRiwayat['peninjau'] = $request->peninjau;
                        $dataRiwayat['tindakan'] = 1;

                        if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Pengajuan Pengembalian RD"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Pengajuan Pengembalian RD"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Pengajuan Pengembalian RD"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Pengajuan Pengembalian RD"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Pengajuan Pengembalian RD"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                    }
                }

                else if (isStaffSection($lastOfRiwayat)){
                    if ($request->verifikasi_rd === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusKembalikan = 'proses';
                        $dataRiwayat['peninjau'] = 'sarana';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Pengajuan Pengembalian RD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_rd === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_rd;
                        $statusKembalikan = $request->verifikasi_rd;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Pengajuan Pengembalian RD',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isSaranaSection($lastOfRiwayat)){
                    $dataRiwayat['status'] = 'proses';
                    $statusKembalikan = 'proses';
                    $dataRiwayat['peninjau'] = 'mgr-adm';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Pengajuan Pengembalian RD"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                else if (isMgrAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi_rd === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusKembalikan = 'proses';
                        $dataRiwayat['peninjau'] = 'avp-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Pengajuan Pengembalian RD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_rd === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_rd;
                        $statusKembalikan = $request->verifikasi_rd;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Pengajuan Pengembalian RD',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isAVPAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi_rd === 'diterima'){
                        $dataRiwayat['status'] = $request->verifikasi_rd;
                        $statusKembalikan = $request->verifikasi_rd;
                        $dataRiwayat['peninjau'] = '-';
                        $dataRiwayat['tindakan'] = 0;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Pengajuan Pengembalian RD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_rd === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_rd;
                        $statusKembalikan = $request->verifikasi_rd;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Pengajuan Pengembalian',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isUserSection($lastOfRiwayat)){
                    $dataRiwayat['status'] = 'proses';
                    $statusKembalikan = 'proses';
                    $dataRiwayat['peninjau'] = 'am';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Pengajuan Pengembalian"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                $kembalikan->update([
                    'status' => $statusKembalikan
                ]);

                $riwayat = RiwayatKembalikanModel::create($dataRiwayat);

                if (Str::lower($request->verifikasi_rd) === 'diterima') {
                    $this->saveToPenerbitanKembalikan($kembalikan, $kembalikan->rd);
                }

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

    private function saveToPenerbitanBaru($baru, $rd){
        if($baru->status === 'diterima'){
            $statusDef = 'diajukan';
            $penerbitan = PenerbitanModel::create([
                'jenis' => $rd->jenis,
                'tanggal' => $rd->tanggal,
                'status' => $statusDef,
                'user_id' => auth()->user()->id
            ]);
            $riwayatPenerbitan = RiwayatPenerbitanModel::create ([
                'penerbitan_id' => $penerbitan->id,
                'status' => $statusDef,
                'user_id' => auth()->user()->id,
                'tindakan' => 1,
                'peninjau' => 'am'
            ]);
        }
    }

    private function saveToPenerbitanGanti($ganti, $rd){
            $statusDef = 'diajukan';
            $penerbitan = PenerbitanModel::create([
                'jenis' => $rd->jenis,
                'tanggal' => $rd->tanggal,
                'status' => $statusDef,
                'user_id' => auth()->user()->id
            ]);
            $riwayatPenerbitan = RiwayatPenerbitanModel::create ([
                'penerbitan_id' => $penerbitan->id,
                'status' => $statusDef,
                'user_id' => auth()->user()->id,
                'tindakan' => 1,
                'peninjau' => 'am'
            ]);
    }

    private function saveToPenerbitanKembalikan($ganti, $rd){
        if($baru->status === 'diterima'){
            $statusDef = 'diajukan';
            $penerbitan = PenerbitanModel::create([
                'jenis' => $rd->jenis,
                'tanggal' => $rd->tanggal,
                'status' => $statusDef,
                'user_id' => auth()->user()->id
            ]);
            $riwayatPenerbitan = RiwayatPenerbitanModel::create ([
                'penerbitan_id' => $penerbitan->id,
                'status' => $statusDef,
                'user_id' => auth()->user()->id,
                'tindakan' => 1,
                'peninjau' => 'am'
            ]);
        }
    }
}
