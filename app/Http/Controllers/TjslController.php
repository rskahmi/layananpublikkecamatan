<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\TjslModel;
use App\Traits\RulesTraits;
use App\Models\LembagaModel;
use App\Models\WilayahModel;
use App\Traits\CacheTimeout;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Events\DashboardTjslEvent;
use Illuminate\Support\Facades\DB;
use App\Models\DokumentasiTjslModel;
use App\Models\RiwayatAnggaranModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Auth\TjslResources;

class TjslController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function show()
    {
        try {
            if (Auth::check()) {
                $tjsl = TjslModel::all();

                $year = Carbon::now()->year;

                $totalTerprogram = TjslModel::whereYear('created_at', $year)->where('jenis', 'terprogram')->count();
                $totalTidakTerprogram = TjslModel::whereYear('created_at', $year)->where('jenis', 'tidak terprogram')->count();
                $totalSponsorship = TjslModel::whereYear('created_at', $year)->where('jenis', 'sponsorship')->count();

                $totalAnggaran = TjslModel::whereYear('created_at', $year)->sum('anggaran');

                $latestRiwayatAnggaran = RiwayatAnggaranModel::whereIn('tjsl_id', function ($query) use ($year) {
                    $query->select(DB::raw('MAX(id) as id'))->from('riwayat_anggaran')->whereYear('created_at', $year)->groupBy('tjsl_id');
                })->get();
                $totalSisaAnggaran = $latestRiwayatAnggaran->sum('sisa_anggaran');

                // total program dan total anggaran di setiap wilayah
                $totalProgramWilayah = TjslModel::whereYear('created_at', $year)->select('wilayah_id')
                    ->selectRaw('count(*) as total_program')
                    ->groupBy('wilayah_id')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'kelurahan' => $item->wilayah->kelurahan,
                            'total_program' => $item->total_program,
                        ];
                    });

                $labels = $totalProgramWilayah->pluck('kelurahan')->toArray();
                $datax = array_map('intval', $totalProgramWilayah->pluck('total_program')->toArray());

                $totalAnggaranWilayah = TjslModel::whereYear('created_at', $year)->select('wilayah_id')
                    ->selectRaw('sum(anggaran) as total_anggaran')
                    ->groupBy('wilayah_id')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'kelurahan' => $item->wilayah->kelurahan,
                            'total_anggaran' => $item->total_anggaran,
                        ];
                    });

                $labels2 = $totalAnggaranWilayah->pluck('kelurahan')->toArray();
                $datax2 = $totalAnggaranWilayah->pluck('total_anggaran')->toArray();

                return view('after-login.tjsl.dashboard')->with([
                    'total_terprogram' => $totalTerprogram,
                    'total_tidak_terprogram' => $totalTidakTerprogram,
                    'total_sponsorship' => $totalSponsorship,
                    'total_anggaran_terpakai' => $totalAnggaran,
                    'total_anggaran_bersisa' => $totalSisaAnggaran,
                    'total_program_perwilayah' => $totalProgramWilayah,
                    'total_anggaran_perwilayah' => $totalAnggaranWilayah,
                    'labels' => $labels,
                    'datax' => $datax,
                    'labels2' => $labels2,
                    'datax2' => $datax2,
                ]);


            } else {
                $tjsl = TjslModel::all();
                return view('before-login.berita')->with(['tjsl' => TjslResources::collection($tjsl)]);
            }

        } catch (Exception $e) {
            return redirect()->back()->with(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'Dashboard Tjsl',
                    'text' => $e->getMessage()
                ]
            );
        }
    }

    public function showMonitoring()
    {
        try {
            $tjsl = Cache::remember('tjsl_data', $this->time, function () {
                return TjslModel::with(['wilayah', 'lembaga'])->get();
            });

            $lembaga = Cache::remember('lembaga_data', $this->time, function () {
                return LembagaModel::all();
            });

            $wilayah = Cache::remember('wilayah_data', $this->time, function () {
                return WilayahModel::all();
            });

            return view('after-login.tjsl.monitoring')
                ->with([
                    'tjsl' => $tjsl,
                    'lembaga' => $lembaga,
                    'wilayah' => $wilayah
                ]);
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show Monitoring Tjsl',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function getDetailTjsl($id)
    {
        try {
            $tjsl = TjslModel::with('wilayah')->where('id', $id)->first();

            $anggaranTjsl = RiwayatAnggaranModel::where("tjsl_id", $id)
                ->orderBy('created_at', 'desc')
                ->get();

            $dokumentasiTjsl = DokumentasiTjslModel::where("tjsl_id", $id)->get();

            return view('after-login.tjsl.detail')->with([
                'tjsl' => $tjsl,
                'anggaranTjsl' => $anggaranTjsl,
                'dokumentasTjsl' => $dokumentasiTjsl
            ]);
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Detail Tjsl',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'jenis' => 'required',
                'anggaran' => 'required',
                'pic' => 'required',
                'contact' => 'required',
                'tanggal' => 'required|date',
            ], [
                'nama.required' => $this->requiredMessage('nama'),
                'jenis.required' => $this->requiredMessage('jenis'),
                'anggaran.required' => $this->requiredMessage('anggaran'),
                'pic.required' => $this->requiredMessage('pic'),
                'contact.required' => $this->requiredMessage('kontak'),
                'tanggal.required' => $this->requiredMessage('tanggal'),
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert tjsl',
                            'text' => validatorError($validator->errors()->all())
                        ]
                    );
            }

            $tjsl = TjslModel::create([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'anggaran' => removeComma($request->anggaran),
                'pic' => $request->pic,
                'contact' => $request->contact,
                'tanggal' => $request->tanggal,
                'user_id' => auth()->user()->id,
                'wilayah_id' => $request->input('wilayah_select'),
                'lembaga_id' => $request->input('lembaga_select')
            ]);

            if ($tjsl) {
                $this->forgetAll();
                event(new DashboardTjslEvent([
                    'jenis' => $tjsl->jenis,
                ]));

                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'success',
                            'title' => 'Insert Tjsl',
                            'text' => 'Data berhasil ditambahkan!'
                        ]
                    );
            }

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Insert Tjsl Berhasil',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function storeDokumentasi(Request $request, $id)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'nama_kegiatan' => 'required|string',
                'tanggal' => 'required|date',
                'gambar' => 'required|mimes:jpeg,png,jpg',
            ], [
                'nama_kegiatan.required' => $this->requiredMessage('nama kegiatan'),
                'tanggal.required' => $this->requiredMessage('tanggal'),
                'gambar.required' => $this->requiredMessage('gambar'),
                'gambar.mimes' => $this->fileMessage(['jpeg', 'jpg', 'png'])
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert Dokumentasi',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $nama_file = $request->file('gambar');
            $filename = time() . '-' . str_replace(' ', '-', $nama_file->getClientOriginalName());

            $dokumentasiTjsl = DokumentasiTjslModel::create([
                "nama_kegiatan" => $request->nama_kegiatan,
                "tanggal" => $request->tanggal,
                "nama_file" => $filename,
                "tjsl_id" => $id,
                "user_id" => auth()->user()->id
            ]);

            if ($dokumentasiTjsl) {
                $nama_file->storeAs('public/images/dokumentasi-tjsl', $filename);
            }

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Insert Dokumentasi Tjsl',
                        'text' => 'Data berhasil ditambahkan!'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Insert Dokumentasi Tjsl',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function getDokumentasiById($id)
    {
        try {
            $dokumentasi = DokumentasiTjslModel::where('tjsl_id', $id)->get();

            return response()->json($dokumentasi);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $tjsl = TjslModel::findOrFail($id);

            $tjsl->update([
                'nama' => $request->edtNamaProgram,
                'pic' => $request->edtPic,
                'contact' => $request->edtContact,
                'anggaran' => removeComma($request->edtAnggaran),
                'tanggal' => $request->edtTanggal,
                'jenis' => $request->edtJenis,
                'lembaga_id' => $request->edt_lembaga_select,
                'wilayah_id' => $request->edt_wilayah_select,
            ]);

            $this->forgetAll();
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update Tjsl',
                        'text' => 'Data berhasil diubah!'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update Tjsl',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function destroy($id)
    {
        try {
            $tjsl = TjslModel::findOrFail($id);
            $tjsl->delete();
            $this->forgetAll();

            event(new DashboardTjslEvent([
                'lembaga_id' => $tjsl->lembaga_id,
                'anggaran' => $tjsl->anggaran,
                'deleted_at' => time()
            ]));

            return redirect()->back()->with(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Delete Tjsl',
                    'text' => 'Data berhasil dihapus!'
                ]
            );

        } catch (Exception $e) {
            return redirect()->back()->with(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'Delete Tjsl',
                    'text' => $e->getMessage()
                ]
            );
        }
    }
}
