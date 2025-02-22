<?php

namespace App\Http\Controllers;

use App\Traits\CacheTimeout;
use App\Traits\RulesTraits;
use Exception;
use App\Models\IsoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Auth\IsoResources;
use Illuminate\Support\Facades\Validator;

class IsoController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function show()
    {
        try {
            $iso = Cache::remember('iso_status_data', $this->time, function () {
                return IsoModel::orderByRaw("FIELD(status, 'tidak aktif', 'segera berakhir', 'aktif')")->get();
            });

            return view('after-login.iso.index')
                ->with(['iso' => IsoResources::collection($iso)]);

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show ISO',
                        'text' => $e -> getMessage()
                    ]
                );
        }
    }
    public function store(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'nama' => 'required|string',
                'jenis' => 'required|string',
                'masa_berlaku' => 'required',
                'tgl_aktif' => 'required'
            ], [
                'nama.required' => $this->requiredMessage("nama"),
                'jenis.required' => $this->requiredMessage("jenis"),
                'masa_berlaku.required' => $this->requiredMessage("masa berlaku"),
                'tgl_berakhir.required' => $this->requiredMessage("tanggal berakhir"),
                'tgl_aktif.required' => $this->requiredMessage("tanggal aktif"),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert ISO',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $tgl_aktif = Carbon::parse($request->tgl_aktif);

            $masa_berlaku = intval($request->masa_berlaku);
            $tgl_berakhir = $tgl_aktif->copy()->addYears($masa_berlaku);

            $status = 'Aktif';
            $now = Carbon::now();
            if ($now->gte($tgl_berakhir)) {
                $status = 'Berakhir';
            } elseif ($now->diffInDays($tgl_berakhir, false) <= 7) {
                $status = 'Segera Berakhir';
            }

            $iso = IsoModel::create([
                "nama" => $request->nama,
                "jenis" => $request->jenis,
                "tgl_aktif" => $tgl_aktif,
                "masa_berlaku" => $request->masa_berlaku,
                "tgl_berakhir" => $tgl_berakhir,
                "status" => $status,
                "user_id" => auth()->user()->id
            ]);

            $this->forgetIso();
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Insert ISO',
                        'text' => 'Data berhasil ditambahkan!'
                    ]
                );

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Insert ISO',
                        'text' => $e -> getMessage()
                    ]
                );
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'edtNama' => 'required|string',
                'edtJenis' => 'required|string',
                'masa_berlaku' => 'required',
                'edtTglAktif' => 'required'
            ], [
                'edtNama.required' => $this->namaMessage(),
                'edtJenis.required' => $this->jenisMessage(),
                'edtMasaBerlaku.required' => $this->masaBerlakuIso(),
                'edtTglAktif.required' => $this->tanggalBerakhirIso(),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert ISO',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }
            $iso = IsoModel::findOrFail($id);

            if (!$iso) {
                return redirect()->back()
                    ->with(
                        'message',
                        'Data tidak ditemukan',
                    );
            }

            $tgl_aktif = Carbon::parse($request->edtTglAktif);
            $masa_berlaku = intval($request->edtMasaBerlaku);
            $tgl_berakhir = $tgl_aktif->copy()->addYears($masa_berlaku);

            $now = Carbon::now();
            $status = 'aktif';
            if ($now->gte($tgl_berakhir)) {
                $status = 'berakhir';
            } elseif ($now->diffInDays($tgl_berakhir, false) <= 7) {
                $status = 'segera berakhir';
            }

            $iso->nama = $request->edtNama;
            $iso->jenis = $request->edtJenis;
            $iso->tgl_aktif = $tgl_aktif;
            $iso->masa_berlaku = $request->edtMasaBerlaku;
            $iso->tgl_berakhir = $tgl_berakhir;
            $iso->status = $status;

            $iso->save();

            $this->forgetIso();

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update ISO',
                        'text' => 'Data berhasil diperbarui!'
                    ]
                );

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update ISO',
                        'text' => $e -> getMessage()
                    ]
                );
        }
    }

    public function destroy($id)
    {
        try {
            $iso = IsoModel::findOrFail($id);

            if (!$iso) {
                return redirect()->back()
                ->with(
                    'message',
                    'Data tidak ditemukan',
                );
            }

            $iso->delete();
            $this->forgetIso();

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Delete Iso',
                        'text' => 'Data berhasil dihapus!'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Delete Iso',
                        'text' => $e -> getMessage()
                    ]
                );
        }
    }
}
