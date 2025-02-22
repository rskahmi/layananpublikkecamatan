<?php

namespace App\Http\Controllers;

use App\Events\DashboardBerkasEvent;
use App\Models\NomorSuratModel;
use App\Models\TjslModel;
use App\Traits\CacheTimeout;
use App\Traits\CreatePdfTraits;
use App\Traits\NomorSuratTraits;
use App\Traits\RulesTraits;
use Exception;
use App\Models\BerkasModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\LembagaModel;
use App\Models\WilayahModel;
use Illuminate\Http\Request;
use App\Models\ProposalModel;
use Illuminate\Support\Carbon;
use App\Models\RiwayatProposalModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\BerkasResource;
use App\Http\Resources\ProposalResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RiwayatProposalResource;


class BerkasController extends Controller
{
    use CacheTimeout, CreatePdfTraits, NomorSuratTraits, RulesTraits;

    public function dashboard()
    {
        try {
            if (Auth::check()) {

                $currentYear = Carbon::now()->year;
                $totalBerkasMasuk = Cache::remember('total_berkas_in_dashboard', $this->time, function () use ($currentYear) {
                    return BerkasModel::whereYear('created_at', $currentYear)->count();
                });
                $totalBerkas = Cache::remember('total_proposal_in_dashboard', $this->time, function () use ($currentYear) {
                    return BerkasModel::where('jenis', 'Proposal')->whereYear('created_at', $currentYear)->count();
                });

                $totalSurat = Cache::remember('total_surat_in_dashboard', $this->time, function () use ($currentYear) {
                    return BerkasModel::where('jenis', 'Surat')->whereYear('created_at', $currentYear)->count();
                });

                $totalUndangan = Cache::remember('total_undangan_in_dashboard', $this->time, function () use ($currentYear) {
                    return BerkasModel::where('jenis', 'Undangan')->whereYear('created_at', $currentYear)->count();
                });

                $jumlahStatusVerifikasi = Cache::remember('status_verifikasi_proposal_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatProposalModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                $jumlahStatusTolak = Cache::remember('jumlah_proposal_ditolak_in_dashboard', $this->time, function () use ($currentYear) {
                    return RiwayatProposalModel::where('status', 'ditolak')
                        ->whereYear('created_at', $currentYear)
                        ->count();
                });

                $jumlahStatusProses = Cache::remember('jumlah_proposal_diproses_in_dashboard', $this->time, function () use ($currentYear) {
                    return ProposalModel::whereIn('status', ['proses', 'diajukan'])
                        ->whereYear('created_at', $currentYear)
                        ->with('berkas')
                        ->count();
                });

                $totalAnggaran = Cache::remember('total_anggaran_in_dashboard', $this->time, function () use ($currentYear) {
                    return ProposalModel::where('status', 'diterima')
                        ->whereYear('created_at', $currentYear)
                        ->sum('anggaran');
                });

                $jumlahStakeholder = Cache::remember('jumlah_Stakeholder_data', $this->time, function () {
                    return ProposalModel::distinct('lembaga_id')->count('lembaga_id');
                });

                    $jumlahProgramProses = Cache::remember('batas_konfirmasi_proposal', $this->time, function () {
                        return ProposalModel::whereIn('status', ['proses', 'diajukan'])
                            ->with('berkas')
                            ->get()
                            ->map(function ($proposal) {
                                $batas_konfirmasi = null;
                                if ($proposal->berkas) {
                                    $batas_konfirmasi = Carbon::parse($proposal->berkas->tanggal)->addDays(3)->format('Y-m-d');
                                }

                                return [
                                    'id' => $proposal->berkas_id,
                                    'nama_berkas' => $proposal->berkas ? $proposal->berkas->nama_berkas : 'Berkas Tidak Tersedia',
                                    'tanggal' => $proposal->berkas ? $proposal->berkas->tanggal : null,
                                    'status' => $proposal->status,
                                    'batas_konfirmasi' => $batas_konfirmasi,
                                ];
                            });
                    });

                // total program dan total anggaran di setiap lembaga
                $totalProgramWilayah = Cache::remember('total_pengajuan_proposal_perwilayah', $this->time, function () use ($currentYear) {
                    return ProposalModel::whereYear('created_at', $currentYear)->select('wilayah_id')
                        ->selectRaw('count(*) as total_program')
                        ->groupBy('wilayah_id')
                        ->get()
                        ->map(function ($item) {
                            return [
                                'kelurahan' => $item->wilayah->kelurahan,
                                'total_program' => $item->total_program,
                            ];
                        });
                });

                $labels = $totalProgramWilayah->pluck('kelurahan')->toArray();
                $datax = array_map('intval', $totalProgramWilayah->pluck('total_program')->toArray());

                return view('after-login.berkas.dashboard')->with([
                    'total_berkas' => $totalBerkas,
                    'total_berkas_masuk' => $totalBerkasMasuk,
                    'total_surat' => $totalSurat,
                    'total_undangan' => $totalUndangan,
                    'total_anggaran' => $totalAnggaran,
                    'jumlah_status_verifikasi' => $jumlahStatusVerifikasi,
                    'jumlah_status_tolak' => $jumlahStatusTolak,
                    'jumlah_status_proses' => $jumlahStatusProses,
                    'jumlah_stakeholder' => $jumlahStakeholder,
                    'berkas_proses' => $jumlahProgramProses,
                    'jumlah_program_wilayah' => $totalProgramWilayah,
                    'labels' => $labels,
                    'datax' => $datax
                ]);


            } else {
                return redirect()->route('beranda');
            }
        } catch (Exception $e) {
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

    public function showPengajuan()
    {
        try {
            $role = auth()->user()->role;

            $berkasQuery = BerkasModel::with(['proposal.riwayat', 'proposal.lembaga', 'proposal.wilayah']);

            if ($role === 'admin-csr') {
                $berkasQuery->whereHas('proposal.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-csr')->where('tindakan', 1)
                        ->orderByRaw("FIELD(status, 'diajukan', 'proses', 'diterima', 'ditolak')");
                });
            }

            elseif ($role === 'admin-comrel') {
                $berkasQuery->whereHas('proposal.riwayat', function ($query) {
                    $query->where('peninjau', 'admin-comrel')->where('tindakan', 1)
                        ->orderByRaw("FIELD(status, 'diajukan', 'proses', 'diterima', 'ditolak')");
                });
            }

            $berkas = $berkasQuery->orderBy('tanggal', 'desc')
                ->get();

            $wilayah = Cache::remember('wilayah_data', $this->time, function () {
                return WilayahModel::all();
            });

            $lembaga = Cache::remember('lembaga_data', $this->time, function () {
                return LembagaModel::all();
            });

            foreach ($berkas as $item) {
                $item->batas_konfirmasi = Carbon::parse($item->tanggal)->addDays(7)->format('Y-m-d');
            }

            return view('after-login.berkas.pengajuan')
                ->with([
                    'berkas' => $berkas,
                    'wilayah' => $wilayah,
                    'lembaga' => $lembaga
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

    public function getDetailPengajuan($id)
    {
        try {
            $berkas = BerkasModel::with(['proposal.wilayah', 'proposal.lembaga', 'proposal.riwayat'])->findOrFail($id);

            if ($berkas->proposal !== null) {
                $riwayat_proposal = RiwayatProposalModel::with('user')->where('proposal_id', $berkas->proposal->id)->orderBy('created_at', 'desc')->get();

                return view('after-login.berkas.detail')->with([
                    'berkas' => $berkas,
                    'riwayat_proposal' => $riwayat_proposal
                ]);
            } else {
                return view('after-login.berkas.detail')->with([
                    'berkas' => $berkas
                ]);
            }
        } catch (Exception $e) {
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

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nomor_berkas' => 'required|unique:berkas,nomor_berkas',
                'nama_berkas' => 'required',
                'jenis' => 'required',
                'tanggal' => 'required|date',
                'nama_pemohon' => 'required',
                'contact' => 'required',
                'file_berkas' => 'nullable|mimes:pdf,docx',
            ], [
                    'nomor_berkas.required' => $this->nomorBerkasMessage(),
                    'nama_berkas.required' => $this->namaBerkasMessage(),
                    'jenis.required' => $this->jenisBerkasMessage(),
                    'tanggal.required' => $this->tanggalMessage(),
                    'nama_pemohon.required' => $this->namaPemohonMessage(),
                    'file_berkas.mimes' => $this->fileMessage(['pdf', 'docx']),
                    'contact.required' => $this->contactMessage(),
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

            if ($request->hasFile('file_berkas')) {
                $file_berkas = $request->file('file_berkas');
                $filename = time() . '-' . str_replace(' ', '-', $file_berkas->getClientOriginalName());
                $file_berkas->storeAs('public/file-berkas', $filename);
            }

            $berkas = BerkasModel::create([
                'nomor_berkas' => $request->nomor_berkas,
                'nama_berkas' => $request->nama_berkas,
                'jenis' => $request->jenis,
                'tanggal' => $request->tanggal,
                'nama_pengirim' => $request->nama_pemohon,
                'contact' => $request->contact,
                'file_berkas' => $filename,
                'user_id' => auth()->user()->id
            ]);

            if ($berkas) {
                if (Str::lower($request->jenis) == "proposal") {
                    $lembaga = $request->input('lembaga-select');

                    // cek if lembaga is exists
                    $rsLembaga = LembagaModel::where('id', $lembaga)->count();

                    $idLembaga = '';

                    if ($rsLembaga == 0) {
                        $insertLembaga = LembagaModel::create([
                            'nama_lembaga' => $lembaga
                        ]);

                        $idLembaga = $insertLembaga->id;
                    } else {
                        $idLembaga = $lembaga;
                    }

                    $statusDef = 'diajukan';


                    $total_waktu = Carbon::parse($request->updated_at);
                    $selisihHari = $total_waktu->diffInDays(Carbon::parse($request->created_at));
                    // insert into proposal
                    $proposal = ProposalModel::create([
                        'status' => $statusDef,
                        'total_waktu' => $selisihHari,
                        'jenis' => $request->jenis_kegiatan,
                        'lembaga_id' => $idLembaga,
                        'wilayah_id' => $request->input('wilayah-select'),
                        'berkas_id' => $berkas->id,
                    ]);

                    $riwayatProposal = RiwayatProposalModel::create([
                        'status' => $statusDef,
                        'proposal_id' => $proposal->id,
                        'user_id' => auth()->user()->id,
                        'tindakan' => 1,
                        'peninjau' => 'am'
                    ]);
                }
            }
            event(new DashboardBerkasEvent($berkas));
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

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'edtNomorBerkas' => 'required',
                'edtNamaBerkas' => 'required',
                'edtJenis' => 'required',
                'edtTanggal' => 'required|date',
                'edtNamaPemohon' => 'required',
                'edtContact' => 'required',
            ], [
                    'edtNomorBerkas.required' => $this->nomorBerkasMessage(),
                    'edtNamaBerkas.required' => $this->namaBerkasMessage(),
                    'edtJenis.required' => $this->jenisBerkasMessage(),
                    'edtTanggal.required' => $this->tanggalMessage(),
                    'edtNamaPemohon.required' => $this->namaPemohonMessage(),
                    'edtContact.required' => $this->contactMessage(),
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

            $berkas = BerkasModel::findOrFail($id);
            $data = [
                'nomor_berkas' => $request->edtNomorBerkas,
                'nama_berkas' => $request->edtNamaBerkas,
                'jenis' => $request->edtJenis,
                'tanggal' => $request->edtTanggal,
                'nama_pengirim' => $request->edtNamaPemohon,
                'contact' => $request->edtContact
            ];

            if ($request->has('edtFileBerkas')) {
                $file_berkas = $request->file('edtFileBerkas');
                $filename = time() . '-' . str_replace(' ', '-', $file_berkas->getClientOriginalName());
                $file_berkas->storeAs('public/file-berkas', $filename);

                if ($berkas->file_berkas) {
                    Storage::disk('public')->delete('file-berkas/' . $berkas->file_berkas);
                }

                $data['file_berkas'] = $filename;
            }

            $berkas->update($data);


            if ($data) {
                if (Str::lower($request->edtJenis) == "proposal") {
                    $lembaga = $request->input('edt-lembaga-select');

                    // cek if lembaga is exists
                    $rsLembaga = LembagaModel::where('id', $lembaga)->count();

                    $idLembaga = '';

                    if ($rsLembaga == 0) {
                        $insertLembaga = LembagaModel::create([
                            'nama_lembaga' => $lembaga
                        ]);

                        $idLembaga = $insertLembaga->id;
                    } else {
                        $idLembaga = $lembaga;
                    }

                    // insert into proposal
                    $proposal = ProposalModel::where('berkas_id', $berkas->id);

                    $edtJenis = $request->edtJenis;

                    $proposal->update([
                        'jenis' => $edtJenis,
                        'lembaga_id' => $idLembaga,
                        'wilayah_id' => $request->input('edt-wilayah-select'),
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

    public function verifikasiProposal(Request $request, $id)
    {
        try {
            $proposal = ProposalModel::with(['berkas', 'riwayat'])->where('berkas_id', $id)->first();

            $lastOfRiwayat = $proposal->riwayat->sortBy('created_at')->last();

            $dataRiwayat = [
                'proposal_id' => $proposal->id,
                'user_id' => auth()->user()->id,
                'alasan' => $request->keterangan,
            ];

            $statusProposal = null;


            if (isManagerSection($lastOfRiwayat)) {
                if ($request->verifikasi_berkas === 'ditolak' || $request->verifikasi_berkas === 'diterima') {
                    $dataRiwayat['status'] = $request->verifikasi_berkas;
                    $dataRiwayat['peninjau'] = '-';
                    $dataRiwayat['tindakan'] = 0;

                    $nomorSurat = $this->generate_number($request->verifikasi_berkas);

                    // Insert status
                    $noSurat = NomorSuratModel::create([
                        'nomor_surat' => $nomorSurat
                    ]);

                    $data = [
                        'no_surat' => $noSurat->nomor_surat,
                        'no_surat_proposal' => $proposal->berkas->nomor_berkas,
                        'nama' => $proposal->berkas->nama_berkas,
                        'pemohon' => $proposal->berkas->nama_pengirim,
                        'tanggal_masuk' => format_dfy($proposal->berkas->tanggal),
                        'tanggal_sekarang' => format_dfy(now()),
                    ];

                    if ($request->verifikasi_berkas === 'diterima') {
                        $data['anggaran'] = formatRupiah(removeComma($request->anggaran));
                    }
                    $namaFile = $this->generate($data, $request->verifikasi_berkas);

                    $dataRiwayat['surat_balasan'] = $namaFile;
                    $statusProposal = $request->verifikasi_berkas;
                } else if ($request->verifikasi_berkas === 'review') {
                    $dataRiwayat['status'] = 'proses';
                    $statusProposal = 'proses';
                    $dataRiwayat['peninjau'] = $request->peninjau;
                    $dataRiwayat['tindakan'] = 1;
                }

                if ($request->verifikasi_berkas === 'diterima') {
                    $proposal->update([
                        'anggaran' => removeComma($request->anggaran)
                    ]);

                }

            } else if (isStaffSection($lastOfRiwayat)) {
                $dataRiwayat['status'] = 'proses';
                $statusProposal = 'proses';
                $dataRiwayat['peninjau'] = 'am';
                $dataRiwayat['tindakan'] = 1;
            }

            $proposal->update([
                'status' => $statusProposal
            ]);

            $riwayat = RiwayatProposalModel::create($dataRiwayat);

            if (Str::lower($request->verifikasi_berkas) === 'diterima') {
                $this->saveToProgram($proposal, $proposal->berkas);
            }

            $this->forgetBerkas();

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

    public function destroy(Request $request, $id)
    {
        try {
            $berkas = BerkasModel::findOrFail($id);

            if (!$berkas) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Delete Berkas',
                    'text' => 'Data tidak ditemukan!'
                ]);
            }

            $imagePath = 'public/file-berkas/' . $berkas->file_berkas;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            event(new DashboardBerkasEvent([
                'deleted_at' => time()
            ]));

            $berkas->delete();

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

        } catch (Exception $e) {
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

    public function search(Request $request)
    {
        try {
            $keyword = $request->input('keyword');

            $berkas = BerkasModel::with([
                'proposal' => function ($query) {
                    $query->with([
                        'riwayat' => function ($query) {
                            $query->orderBy('created_at', 'desc');
                        }
                    ]);
                }
            ])
                ->where('jenis', 'Proposal')
                ->where('nomor_berkas', 'like', "%$keyword%")
                ->get();

            $searchResults = [];

            foreach ($berkas as $berkasItem) {
                $searchResults[] = [
                    'berkas' => new BerkasResource($berkasItem),
                    'proposal' => new ProposalResource($berkasItem->proposal),
                    'riwayatproposal' => RiwayatProposalResource::collection($berkasItem->proposal->riwayat)
                ];
            }

            return response()->json([
                'message' => 'Data ditemukan',
                'data' => $searchResults
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    private function saveToProgram($proposal, $berkas)
    {
        if ($proposal->status === 'diterima') {
            TjslModel::create([
                'nama' => $berkas->nama_berkas,
                'jenis' => $proposal->jenis,
                'anggaran' => $proposal->anggaran,
                'pic' => $berkas->nama_pengirim,
                'contact' => $berkas->contact,
                'tanggal' => $berkas->tanggal,
                'lembaga_id' => $proposal->lembaga_id,
                'wilayah_id' => $proposal->wilayah_id,
                'user_id' => auth()->user()->id,
            ]);
        }
    }
}
