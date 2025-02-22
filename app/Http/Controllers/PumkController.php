<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\PumkModel;
use App\Models\LembagaModel;
use App\Models\WilayahModel;
use App\Traits\CacheTimeout;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PembayaranModel;
use App\Events\DashboardPumkEvent;
use Illuminate\Support\Facades\DB;
use App\Models\DokumentasiPumkModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\WilayahResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Auth\PumkResources;
use App\Http\Resources\Auth\LembagaResources;

class PumkController extends Controller
{
    use CacheTimeout;

    public function pumkDashboard()
    {
        try {
            if (Auth::check()) {
                $pumk = Cache::remember('pumk_data_in_dashboard', $this->time, function () {
                    return PumkModel::all();
                });

                $currentYear = Carbon::now()->year;
                $total_pumk = Cache::remember('total_data_pumk', $this->time, function () use ($currentYear) {

                    return PumkModel::whereYear('created_at', $currentYear)->count();
                });

                $jumlah_program_lancar = Cache::remember('pumk_data_lancar', $this->time, function () use ($currentYear) {

                    return PumkModel::whereYear('created_at', $currentYear)->where('status', 'lancar')->count();
                });

                $jumlah_program_tidak_lancar = Cache::remember('pumk_data_tidak_lancar', $this->time, function () use ($currentYear) {

                    return PumkModel::whereYear('created_at', $currentYear)->where('status', 'tidak lancar')->count();
                });

                $totalAnggaran = Cache::remember('pumk_data_total_anggaran', $this->time, function () use ($currentYear) {

                    return PumkModel::whereYear('created_at', $currentYear)->sum('anggaran');
                });

                // tampilan data grafik per wilayah
                $jumlahProgramWilayah = Cache::remember('pumk_data_program_wilayah', $this->time, function () use ($currentYear) {

                    return PumkModel::select('wilayah_id')
                        ->selectRaw('count(*) as total_program')
                        ->whereYear('created_at', $currentYear)
                        ->groupBy('wilayah_id')
                        ->get()
                        ->map(function ($item) {
                            return [
                                'kelurahan' => $item->wilayah->kelurahan,
                                'total_program' => $item->total_program,
                            ];
                        });
                });

                $labels = $jumlahProgramWilayah->pluck('kelurahan')->toArray();
                $datax = array_map('intval', $jumlahProgramWilayah->pluck('total_program')->toArray());

                // tampilan data total anggaran per usaha
                $jumlahAnggaranPerProgram = Cache::remember('pumk_data_by_stakeholder', $this->time, function () {

                    return PumkModel::select('nama_usaha', DB::raw('sum(anggaran) as total_anggaran'))->groupBy('nama_usaha')->get();
                });

                $totalAnggaranPerProgram = [];

                foreach ($jumlahAnggaranPerProgram as $item) {
                    $totalAnggaranPerProgram[] = [
                        'pumk_id' => $item->pumk_id,
                        'nama_usaha' => $item->nama_usaha,
                        'total_anggaran' => $item->total_anggaran,
                    ];
                }

                $labels2 = $jumlahAnggaranPerProgram->pluck('nama_usaha')->toArray();
                $datax2 = $jumlahAnggaranPerProgram->pluck('total_anggaran')->toArray();

                // menampilkan data
                return view('after-login.pumk.dashboard')->with([
                    'total_pumk' => $total_pumk,
                    'jumlah_program_tidak_lancar' => $jumlah_program_tidak_lancar,
                    'jumlah_program_lancar' => $jumlah_program_lancar,
                    'total_anggaran' => $totalAnggaran,
                    'jumlah_program_wilayah' => $jumlahProgramWilayah,
                    'labels' => $labels,
                    'datax' => $datax,
                    'labels2' => $labels2,
                    'datax2' => $datax2,
                ]);

            } else {
                $pumk = PumkModel::all();
                return view('before-login.beranda')->with(['pumk' => PumkResources::collection($pumk)]);
            }

        } catch (Exception $e) {
            return redirect()->back()->with(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'Dashboard Pumk',
                    'text' => $e->getMessage()
                ]
            );
        }
    }

    public function showMonitoring()
    {
        try {
            $pumk = Cache::remember('pumk_data_in_monitoring', $this->time, function () {
                return PumkModel::orderByRaw("FIELD(status, 'Lunas', 'Tidak Lunas')")->orderBy('jatuh_tempo')->get();
            });


            $lembaga = Cache::remember('lembaga_data', $this->time, function () {
                return LembagaModel::all();
            });

            $wilayah = Cache::remember('wilayah_data', $this->time, function () {
                return WilayahModel::all();
            });
            return view('after-login.pumk.monitoring')
                ->with([
                    'pumk' => PumkResources::collection($pumk),
                    'lembaga' => LembagaResources::collection($lembaga),
                    'wilayah' => WilayahResource::collection($wilayah)
                ]);

        } catch (Exception $e) {
            return redirect()->back()
                ->with([
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show Monitoring Pumk',
                        'text' => $e->getMessage()
                    ]
                ]);
        }
    }

    public function getDetailPumk($id)
    {
        try {
            $pumk = PumkModel::with('wilayah')->where('id', $id)->first();
            $pembayaran = PembayaranModel::where("pumk_id", $id)->orderBy('created_at', 'desc')->get();
            $dokumentasiPumk = DokumentasiPumkModel::where("pumk_id", $id)->orderBy('created_at', 'desc')->get();

            return view("after-login.pumk.detail")->with([
                'pumk' => $pumk,
                'pembayaran' => $pembayaran,
                'dokumentasiPumk' => $dokumentasiPumk,
            ]);
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Detail Pumk',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'nama_usaha' => 'required|string',
                'nama_pengusaha' => 'required|string',
                'contact' => 'required|string',
                'agunan' => 'required|string',
                'tanggal' => 'required|date',
                'anggaran' => 'required',
                'jatuh_tempo' => 'required|date',
            ]);

            $validatedData = $validator->validate();
            $validatedData["anggaran"] = removeComma($request->anggaran);

            $currentDate = now();
            $jatuhTempo = Carbon::parse($request->jatuh_tempo);
            if ($currentDate->gte($jatuhTempo)) {
                $validatedData["status"] = 'lunas';
            } else {
                $validatedData["status"] = 'Belum lunas';
            }

            $validatedData["lembaga_id"] = $request->lembaga_select;
            $validatedData["wilayah_id"] = $request->wilayah_select;
            $validatedData["user_id"] = auth()->user()->id;

            // dd($validatedData);

            $pumk = PumkModel::create($validatedData);

            event(new DashboardPumkEvent($pumk));
            $this->forgetPumk();

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Insert Pumk',
                'text' => 'Data berhasil ditambahkan!'
            ]);
        } catch (Exception $e) {
            // return redirect()->route('errors');
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Insert Pumk',
                'text' => $e->getMessage()
            ]);
        }
    }

    public function storeDokumentasi(Request $request, $id)
    {
        try {
            $nama_file = $request->file('gambar');
            $filename = time() . '-' . str_replace(' ', '-', $nama_file->getClientOriginalName());

            $dokumentasiPumk = DokumentasiPumkModel::create([
                "nama_kegiatan" => $request->nama_kegiatan,
                "tanggal" => $request->tanggal,
                'nama_file' => $filename,
                "pumk_id" => $id,
                "user_id" => auth()->user()->id
            ]);

            if($dokumentasiPumk) {
                $nama_file->storeAs('public/images/dokumentasi-pumk', $filename);
                Cache::forget('dokumentasi_pumk_data');
            }

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Insert Dokumentasi Pumk',
                        'text' => 'Data berhasil ditambahkan!'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Insert Dokumentasi Pumk',
                        'text' => $e -> getMessage()
                    ]
                );
        }
    }

    public function storePembayaran(Request $request, $id)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'jumlah_pembayaran' => 'required',
                'tanggal' => 'required|date'
            ], [
                'jumlah_pembayaran.required' => $this->requiredMessage('jumlah pembayaran'),
                'tanggal.required' => $this->requiredMessage('tanggal')
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert Pembayaran',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $pumk = PumkModel::findOrFail($id);

            $pembayaran = PembayaranModel::where('pumk_id', $id)->orderBy('created_at', 'asc')->get();

            $data = [
                'jumlah_pembayaran' => $request->jumlah_pembayaran,
                'tanggal' => $request->tanggal,
                'pumk_id' => $id,
                'user_id' => auth()->user()->id
            ];

            if ($pembayaran->isEmpty()) {
                $data['sisa_pembayaran'] = $pumk->anggaran - $request->jumlah_pembayaran;
            } else {
                $getLastRiwayat = $pembayaran->last()->sisa_pembayaran;
                $sisa_pembayaran = $getLastRiwayat - $request->jumlah_pembayaran;
                $data['sisa_pembayaran'] = $sisa_pembayaran;
            }

            if ($data['sisa_pembayaran'] <= 0) {
                $pumk->update(['status' => 'Lunas']);
            }
            $pembayaran = PembayaranModel::create($data);
            Cache::forget('pembayaran_pumk_data');

            return redirect()->back()->with(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Insert Pembayaran',
                    'text' => 'Data berhasil ditambahkan!'
                ]
            );
        } catch (Exception $e) {
            return redirect()->back()->with(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'Insert Pembayaran',
                    'text' => $e->getMessage()
                ]
            );
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pumk = PumkModel::findOrFail($id);

            $oldJatuhTempo = $request->jatuh_tempo;

            $pumk->update([
                'nama_usaha' => $request->edtNama,
                'nama_pengusaha' => $request->edtUsaha,
                'contact' => $request->edtContact,
                'agunan' => $request->edtAgunan,
                'tanggal' => $request->edtTanggal,
                'jatuh_tempo' => $request->edtTempo,
                'anggaran' => removeComma($request->edtAnggaran),
                'lembaga_id' => $request->edt_lembaga_select,
                'wilayah_id' => $request->edt_wilayah_select
            ]);

            if ($pumk->jatuh_tempo != $oldJatuhTempo) {
                $jatuhTempo = Carbon::parse($pumk->jatuh_tempo);
                $currentDate = Carbon::now();

                if ($currentDate->gt($jatuhTempo)) {
                    $pumk->update(['status' => 'Belum Lunas']);
                } else {
                    $pumk->update(['status' => 'Lunas']);
                }
            }

            $this->forgetPumk();
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Update Pumk',
                'text' => 'Data berhasil diubah!'
            ]);

        } catch (Exception $e) {
            return redirect()->back()
                ->with([
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update Pumk',
                        'text' => $e->getMessage()
                    ]
                ]);
        }

    }
    public function destroy($id)
    {
        try {
            $pumk = PumkModel::findOrFail($id);
            // dd($pumk);
            $pumk->delete();

            event(new DashboardPumkEvent([
                'anggaran' => $pumk->anggaran,
                'deleted_at' => time()
            ]));

            $this->forgetPumk();

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Delete Pumk',
                'text' => 'Data berhasil dihapus!'
            ]);

        } catch (Exception $e) {
            return redirect()->back()
                ->with([
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Delete Pumk',
                        'text' => $e->getMessage()
                    ]
                ]);
        }
    }

    public function search(Request $request)
    {
        try {

            $keyword = $request->input('keyword');

            $pumk = PumkModel::where(function ($query) use ($keyword) {
                    $query->where('nama_usaha', 'like', "%$keyword%")
                        ->orWhere('nama_pengusaha', 'like', "%$keyword%")
                        ->orWhere('agunan', 'like', "%$keyword%")
                        ->orWhere('anggaran', 'like', "%$keyword%")
                        ->orWhere('tanggal', 'like', "%$keyword%")
                        ->orWhere('jatuh_tempo', 'like', "%$keyword%")
                        ->orWhere('status', 'like', "%$keyword%")
                        ->orWhere('lembaga_id', 'like', "%$keyword%")
                        ->orWhere('wilayah_id', 'like', "%$keyword%");
                })->get();

            return response()->json([
                'message' => 'Data ditemukan',
                'data' => PumkResources::collection($pumk)
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
