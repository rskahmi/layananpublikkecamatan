<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DashboardSIJEvent;
use App\Traits\CacheTimeout;
use App\Traits\CreatePdfTraits;
use App\Traits\NomorSuratTraits;
use App\Traits\RulesTraits;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\SIJModel;
use App\Models\MelayatModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\SakitModel;
use App\Models\DinasModel;
use App\Models\RiwayatMelayatModel;
use App\Models\RiwayatSakitModel;
use App\Models\RiwayatDinasModel;
use Illuminate\Support\Carbon;
use App\Models\RiwayatProposalModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\BerkasResource;
use App\Http\Resources\ProposalResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RiwayatProposalResource;

class SIJController extends Controller
{
    use CacheTimeout, CreatePdfTraits, NomorSuratTraits, RulesTraits;
    public function dashboard(){
        try {
            if (Auth::check()){
                // Grafik Bulanan
                $currentYear = Carbon::now()->year;
                $defaultMonth = range(1, 12);

                // Pengajuan RD
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

                return view ('after-login.sij.dashboard')->with([
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
            $sijQuery = SIJModel::with(['melayat.riwayat', 'sakit.riwayat', 'dinas.riwayat']);

            if ($role === 'admin') {
                $sijQuery->whereHas('melayat.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                })->orWhereHas('sakit.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                })->orWhereHas('dinas.riwayat', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('tindakan', 1);
                });
            }

            if ($role === 'am'){
                $sijQuery->whereHas('melayat.riwayat', function ($query) {
                    $query->where('peninjau', 'am')->where('tindakan', 1);
                })->orWhereHas('sakit.riwayat', function ($query){
                    $query->where('peninjau', 'am')->where('tindakan', 1);
                })->orWhereHas('dinas.riwayat', function ($query){
                    $query->where('peninjau', 'am')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-csr'){
                $sijQuery->whereHas('melayat.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                })->orWhereHas('sakit.riwayat', function ($query){
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                })->orWhereHas('dinas.riwayat', function ($query){
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-comrel'){
                $sijQuery->whereHas('melayat.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                })->orWhereHas('sakit.riwayat', function ($query){
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                })->orWhereHas('dinas.riwayat', function ($query){
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf4'){
                $sijQuery->whereHas('melayat.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                })->orWhereHas('sakit.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                })->orWhereHas('dinas.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf5'){
                $sijQuery->whereHas('melayat.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                })->orWhereHas('sakit.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                })->orWhereHas('dinas.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
                });
            }

            if ($role === 'admin-staf6'){
                $sijQuery->whereHas('melayat.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                })->orWhereHas('sakit.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                })->orWhereHas('dinas.riwayat', function ($query){
                    $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
                });
            }


            if ($role === 'mgr-adm'){
                $sijQuery->whereHas('melayat.riwayat', function ($query) {
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                })->orWhereHas('sakit.riwayat', function ($query){
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                })->orWhereHas('dinas.riwayat', function ($query){
                    $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
                });
            }

            if ($role === 'avp-adm'){
                $sijQuery->whereHas('melayat.riwayat', function ($query) {
                    $query->where('peninjau', 'avp-adm')->where('tindakan', 1);
                })->orWhereHas('sakit.riwayat', function ($query){
                    $query->where('peninjau', 'avp-adm')->where('tindakan', 1);
                })->orWhereHas('dinas.riwayat', function ($query){
                    $query->where('peninjau', 'avp-adm')->where('tindakan', 1);
                });
            }

            $sij = $sijQuery->orderBy('tanggal', 'desc')
                ->get();

            return view('after-login.sij.pengajuan')
                ->with([
                    'sij' => $sij
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
            $sij = SIJModel::create([
                'jenis' => $request->jenis,
                'tanggal' => $tanggal,
                'user_id' => auth()->user()->id
            ]);

            if ($sij) {
                if (Str::lower($request->jenis) == "melayat"){
                    $filename = null;
                    if ($request->hasFile('emailberitaduka')){
                        $emailberitaduka = $request->file('emailberitaduka');
                        $filename = time() . '-' . str_replace(' ','-', $emailberitaduka->getClientOriginalName());
                        $emailberitaduka->storeAs('public/sij', $filename);
                    }

                    $statusDef = 'diajukan';
                    $melayat = MelayatModel::create([
                        'status' => $statusDef,
                        'emailberitaduka' => $filename,
                        'sij_id' => $sij->id,
                    ]);

                    $riwayatMelayat = RiwayatMelayatModel::create([
                        'status' => $statusDef,
                        'melayat_id' => $melayat->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'am'
                    ]);

                    $data = [
                        'text' => "Pengajuan Baru Masuk",
                        'jenis' => "Melayat",
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                else if (Str::lower($request->jenis) === "sakit"){
                    $filename2 = null;
                    if ($request->hasFile('suratrujukan')){
                        $suratrujukan = $request->file('suratrujukan');
                        $filename2 = time() . '-' . str_replace(' ','-', $suratrujukan->getClientOriginalName());
                        $suratrujukan->storeAs('public/sij', $filename2);
                    }

                    $filename3 = null;
                    if ($request->hasFile('suratpengantar')){
                        $suratpengantar = $request->file('suratpengantar');
                        $filename3 = time() . '-' . str_replace(' ','-', $suratpengantar->getClientOriginalName());
                        $suratpengantar->storeAs('public/sij', $filename3);
                    }

                    $statusDef = 'diajukan';
                    $sakit = SakitModel::create([
                        'status' => $statusDef,
                        'suratrujukan' => $filename2,
                        'suratpengantar' => $filename3,
                        'sij_id' => $sij->id,
                    ]);

                    $riwayatSakit = RiwayatSakitModel::create([
                        'status' => $statusDef,
                        'sakit_id' => $sakit->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'am'
                    ]);

                    $data = [
                        'text' => "Pengajuan Baru Masuk",
                        'jenis' => "Berobat",
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                else if (Str::lower($request->jenis) == "dinas"){
                    $filename4 = null;
                    if ($request->hasFile('lampiran')){
                        $lampiran = $request->file('lampiran');
                        $filename4 = time() . '-' . str_replace(' ','-', $lampiran->getClientOriginalName());
                        $lampiran->storeAs('public/sij', $filename4);
                    }
                    $statusDef = 'diajukan';
                    $dinas = DinasModel::create([
                        'status' => $statusDef,
                        'lampiran' => $filename4,
                        'sij_id' => $sij->id,
                    ]);

                    $riwayatDinas = RiwayatDinasModel::create([
                        'status' => $statusDef,
                        'dinas_id' => $dinas->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'am'
                    ]);

                    $data = [
                        'text' => "Pengajuan Baru Masuk",
                        'jenis' => "Dinas",
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }
        }

        event(new DashboardSIJEvent($sij));
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
    }
    catch (Exception $e) {
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
            $sij = SIJModel::findOrFail($id);
                if (!$sij) {
                    return redirect()->back->with('alert', [
                        'type' => 'error',
                        'title' => 'Delete Berkas',
                        'text' => 'Data tidak ditemukan!'
                    ]);
                }

                $imagePath = 'public/sij/' . $sij->emailberitaduka;
                if (File::exists($imagePath)){
                    File::delete($imagePath);
                }

                $imagePath = 'public/sij/' . $sij->suratpengantar;
                if (File::exists($imagePath)){
                    File::delete($imagePath);
                }

                $imagePath = 'public/sij/' . $sij->suratrujukan;
                if (File::exists($imagePath)){
                    File::delete($imagePath);
                }

                $imagePath = 'public/sij/' . $sij->lampiran;
                if (File::exists($imagePath)){
                    File::delete($imagePath);
                }

                event(new DashboardSIJEvent ([
                    'delete_at' => time()
                ]));

                $sij->delete();
                $this->forgetSIJ();

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
        try{
            $validator = Validator::make($request->all(),[
                'edtJenis' => 'required',
            ], [
                'edtJenis.required' => $this->jenisSIJMessage(),
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
            $sij = SIJModel::findOrFail($id);
                $data = [
                    'jenis' => $request->edtJenis
                ];

                if($data){
                    if (Str::lower($request->edtJenis) == "melayat"){
                        $filename = null;
                        if ($request->hasFile('edtemailberitaduka')){
                            $edtemailberitaduka = $request->file('edtemailberitaduka');
                            $filename = time() . '-' . str_replace(' ','-', $edtemailberitaduka->getClientOriginalName());
                            $edtemailberitaduka->storeAs('public/sij', $filename);
                            if($sij->emailberitaduka){
                                Storage::disk('public')->delete('sij/' . $sij->emailberitaduka);
                            }
                            $data['emailberitaduka'] = $filename;

                            $melayat = MelayatModel::where('sij_id', $sij->id);
                            $melayat->update([
                                'emailberitaduka' => $filename
                            ]);
                        }
                    }

                    else if (Str::lower($request->edtJenis) == "sakit"){
                        $filename2 = $sij->sakit->suratrujukan;
                        if ($request->hasFile('edtsuratrujukan')){
                            $edtsuratrujukan = $request->file('edtsuratrujukan');
                            $filename2 = time() . '-' . str_replace(' ','-', $edtsuratrujukan->getClientOriginalName());
                            $edtsuratrujukan->storeAs('public/sij', $filename2);
                            if($sij->suratrujukan){
                                Storage::disk('public')->delete('sij/' . $sij->suratrujukan);
                            }
                            $data['suratrujukan'] = $filename2;
                        }
                        else {
                            $data['suratrujukan'] = $filename2;
                        }

                        $filename3 = $sij->sakit->suratpengantar;
                        if ($request->hasFile('edtsuratpengantar')){
                            $edtsuratpengantar = $request->file('edtsuratpengantar');
                            $filename3 = time() . '-' . str_replace(' ','-', $edtsuratpengantar->getClientOriginalName());
                            $edtsuratpengantar->storeAs('public/sij', $filename3);
                            if($sij->suratpengantar){
                            Storage::disk('public')->delete('sij/' . $sij->suratpengantar);
                            }
                            $data['suratpengantar'] = $filename3;
                        }
                        else {
                            $data['suratpengantar'] = $filename3;
                        }

                        $sakit = SakitModel::where('sij_id', $sij->id);
                        $sakit->update([
                        'suratrujukan' => $filename2,
                        'suratpengantar' => $filename3,
                        ]);
                    }

                    else if (Str::lower($request->edtJenis) == "dinas"){
                        $filename4 = null;
                        if ($request->hasFile('edtlampiran')){
                            $edtlampiran = $request->file('edtlampiran');
                            $filename4 = time() . '-' . str_replace(' ','-', $edtlampiran->getClientOriginalName());
                            $edtlampiran->storeAs('public/sij', $filename4);
                            if($sij->lampiran){
                                Storage::disk('public')->delete('sij/' . $sij->lampiran);
                            }
                            $data['lampiran'] = $filename4;
                        }

                        $dinas = DinasModel::where('sij_id', $sij->id);
                        $dinas->update([
                        'lampiran' => $filename4,
                        ]);
                    }
        }
        $sij->update($data);
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
            $sij = SIJModel::with(['melayat.riwayat', 'sakit.riwayat', 'dinas.riwayat'])->findOrFail($id);
                if ($sij->melayat !== null) {
                    $riwayat_melayat = RiwayatMelayatModel::with('user')->where('melayat_id', $sij->melayat->id)->orderBy('created_at', 'desc')->get();
                    return view('after-login.sij.detail')-> with ([
                        'sij' => $sij,
                        'riwayat_melayat' => $riwayat_melayat
                    ]);
                }
                else if ($sij->sakit !== null) {
                    $riwayat_sakit = RiwayatSakitModel::with('user')->where('sakit_id', $sij->sakit->id)->orderBy('created_at', 'desc')->get();
                    return view('after-login.sij.detail')-> with ([
                        'sij' => $sij,
                        'riwayat_sakit' => $riwayat_sakit
                    ]);
                }

                else if ($sij->dinas !== null) {
                    $riwayat_dinas = RiwayatDinasModel::with('user')->where('dinas_id', $sij->dinas->id)->orderBy('created_at', 'desc')->get();
                    return view('after-login.sij.detail')-> with ([
                        'sij' => $sij,
                        'riwayat_dinas' => $riwayat_dinas
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


    public function verifikasiMelayat(Request $request, $id){
        try {
            $melayat = MelayatModel::with(['sij', 'riwayat'])->where('sij_id', $id)->first();
            $lastOfRiwayat = $melayat->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'melayat_id' => $melayat->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan,
                ];
                $statusMelayat = null;

                if (isManagerSection($lastOfRiwayat)){
                    if (isset($request->verifikasi_sij) && $request->verifikasi_sij === 'ditolak') {
                        if (isset($lastOfRiwayat->user_id)) {
                            $dataRiwayat['status'] = $request->verifikasi_sij;
                            $dataRiwayat['peninjau'] = 'admin';
                            $dataRiwayat['tindakan'] = 1;
                            $statusMelayat = $request->verifikasi_sij;

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
                            throw new Exception('User ID not found for this Riwayat');
                        }
                    }
                    else if ($request->verifikasi_sij === 'review'){
                        $dataRiwayat['status'] = 'proses';
                        $statusMelayat = 'proses';
                        $dataRiwayat['peninjau'] = $request->peninjau;
                        $dataRiwayat['tindakan'] = 1;

                        if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Melayat"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Melayat"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Melayat"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Melayat"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Melayat"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                    }
                }

                else if (isStaffSection($lastOfRiwayat)){
                    if ($request->verifikasi_sij === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusMelayat = 'proses';
                        $dataRiwayat['peninjau'] = 'mgr-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Melayat"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_sij === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusMelayat = $request->verifikasi_sij;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Melayat',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isMgrAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi_sij === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusMelayat = 'proses';
                        $dataRiwayat['peninjau'] = 'avp-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Melayat"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_sij === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusMelayat = $request->verifikasi_sij;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Melayat',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isAVPAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi_sij === 'diterima'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusMelayat = $request->verifikasi_sij;
                        $dataRiwayat['peninjau'] = '-';
                        $dataRiwayat['tindakan'] = 0;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Melayat"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_sij === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusMelayat = $request->verifikasi_sij;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Melayat',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isUserSection($lastOfRiwayat)){
                    $dataRiwayat['status'] = 'proses';
                    $statusMelayat = 'proses';
                    $dataRiwayat['peninjau'] = 'am';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Melayat"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }


                $melayat->update([
                    'status' => $statusMelayat
                ]);
                $riwayat = RiwayatMelayatModel::create($dataRiwayat);

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

    public function verifikasiSakit(Request $request, $id){
        try {
            $sakit = SakitModel::with(['sij', 'riwayat'])->where('sij_id', $id)->first();
            $lastOfRiwayat = $sakit->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'sakit_id' => $sakit->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan
                ];
                $statusSakit = null;

                if (isManagerSection($lastOfRiwayat)){
                    if (isset($request->verifikasi_sij) && $request->verifikasi_sij === 'ditolak') {
                        if (isset($lastOfRiwayat->user_id)) {
                            $dataRiwayat['status'] = $request->verifikasi_sij;
                            $dataRiwayat['peninjau'] = 'admin';
                            $dataRiwayat['tindakan'] = 1;
                            $statusSakit = $request->verifikasi_sij;

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
                    else if ($request->verifikasi_sij === 'review'){
                        $dataRiwayat['status'] = 'proses';
                        $statusSakit = 'proses';
                        $dataRiwayat['peninjau'] = $request->peninjau;
                        $dataRiwayat['tindakan'] = 1;

                        if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Berobat"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Berobat"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Berobat"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Berobat"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Berobat"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                    }
                }

                else if (isStaffSection($lastOfRiwayat)){
                    if ($request->verifikasi_sij === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusSakit = 'proses';
                        $dataRiwayat['peninjau'] = 'mgr-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Berobat"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_sij === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusSakit = $request->verifikasi_sij;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Berobat',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isMgrAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi_sij === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusSakit = 'proses';
                        $dataRiwayat['peninjau'] = 'avp-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Berobat"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_sij === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusSakit = $request->verifikasi_sij;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Berobat',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isAVPAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi_sij === 'diterima'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusSakit = $request->verifikasi_sij;
                        $dataRiwayat['peninjau'] = '-';
                        $dataRiwayat['tindakan'] = 0;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Berobat"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_sij === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusSakit = $request->verifikasi_sij;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Berobat',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isUserSection($lastOfRiwayat)){
                    $dataRiwayat['status'] = 'proses';
                    $statusSakit = 'proses';
                    $dataRiwayat['peninjau'] = 'am';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Berobat"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                $sakit->update([
                    'status' => $statusSakit
                ]);

                $riwayat = RiwayatSakitModel::create($dataRiwayat);

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

    public function verifikasiDinas(Request $request, $id){
        try  {
            $dinas = DinasModel::with(['sij', 'riwayat'])->where('sij_id', $id)->first();
            $lastOfRiwayat = $dinas->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'dinas_id' => $dinas->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan,
                ];
                $statusDinas = null;

                if (isManagerSection($lastOfRiwayat)){
                    if (isset($request->verifikasi_sij) && $request->verifikasi_sij === 'ditolak') {
                        if (isset($lastOfRiwayat->user_id)) {
                            $dataRiwayat['status'] = $request->verifikasi_sij;
                            $dataRiwayat['peninjau'] = 'admin';
                            $dataRiwayat['tindakan'] = 1;
                            $statusDinas = $request->verifikasi_sij;

                            $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Dinas',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                        } else {
                            throw new Exception('User ID not found for this Riwayat');
                        }
                    }
                    else if ($request->verifikasi_sij === 'review'){
                        $dataRiwayat['status'] = 'proses';
                        $statusDinas = 'proses';
                        $dataRiwayat['peninjau'] = $request->peninjau;
                        $dataRiwayat['tindakan'] = 1;

                        if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Dinas"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Dinas"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Dinas"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Dinas"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                        elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                            $data = [
                                'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                                'jenis' => "Dinas"
                            ];
                            $email_target = 'riskyahmad0506@gmail.com';
                            Mail::to($email_target)->send(new SendEmail($data));
                        }
                    }
                }

                else if (isStaffSection($lastOfRiwayat)){
                    if ($request->verifikasi_sij === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusDinas = 'proses';
                        $dataRiwayat['peninjau'] = 'mgr-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Dinas"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_sij === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusDinas = $request->verifikasi_sij;
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
                    if ($request->verifikasi_sij === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusDinas = 'proses';
                        $dataRiwayat['peninjau'] = 'avp-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Dinas"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_sij === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusDinas = $request->verifikasi_sij;
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
                    if ($request->verifikasi_sij === 'diterima'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusDinas = $request->verifikasi_sij;
                        $dataRiwayat['peninjau'] = '-';
                        $dataRiwayat['tindakan'] = 0;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Dinas"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi_sij === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi_sij;
                        $statusDinas = $request->verifikasi_sij;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Dinas',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isUserSection($lastOfRiwayat)){
                    $dataRiwayat['status'] = 'proses';
                    $statusDinas = 'proses';
                    $dataRiwayat['peninjau'] = 'am';
                    $dataRiwayat['tindakan'] = 1;

                    $data = [
                        'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                        'jenis' => "Dinas"
                    ];
                    $email_target = 'riskyahmad0506@gmail.com';
                    Mail::to($email_target)->send(new SendEmail($data));
                }

                $dinas->update([
                    'status' => $statusDinas
                ]);
                $riwayat = RiwayatDinasModel::create($dataRiwayat);

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
