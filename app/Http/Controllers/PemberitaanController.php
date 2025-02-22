<?php

namespace App\Http\Controllers;

use App\Traits\RulesTraits;
use Exception;
use App\Models\RilisModel;
use App\Traits\CacheTimeout;
use Illuminate\Http\Request;
use App\Models\PemberitaanModel;
use Illuminate\Support\Facades\Validator;
class PemberitaanController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function show(Request $request)
    {
        try {
            $rilis = RilisModel::first();
            $berita = PemberitaanModel::create($request->all());

            return view('after-login.media.detail')->with([
                'rilis' => $rilis,
                'berita' => $berita,
            ]);
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Detail Rilis',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function store(Request $request, $id)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'jenis' => 'required',
                'respon' => 'required'
            ],  [
                'jenis.required' => $this->jenisMessage(),
                'respon.required' => $this->responMessage(),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert Pemberitaan',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $jenis = $request->jenis;
            $beritaData = [
                'jenis' => $jenis,
                'respon' => $request->respon,
                'rilis_id' => $id
            ];

            if ($jenis === 'media online') {
                $validatedData = Validator::make($request->all(), [
                    'tautan' => 'required|url'
                ]);

                $beritaData['tautan'] = $request->tautan;
            } else if ($jenis === 'media cetak' || $jenis === 'media elektronik') {
                $validatedData = Validator::make($request->all(), [
                    'gambar' => 'required|mimes:jpeg,png,jpg'
                ]);

                $gambar = $request->file('gambar');
                $filename = time() . '-' . str_replace(' ', '-', $gambar->getClientOriginalName());

                $beritaData['gambar'] = $filename;
            }

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert Rilis',
                            'text' => $validatedData->errors()
                        ]
                    );
            }

            $berita = PemberitaanModel::create($beritaData);

            if ($berita) {
                $this->forgetMedia();

                if ($berita->jenis === 'media cetak' || $berita->jenis === 'media elektronik') {
                    $gambar->storeAs('public/images/pemberitaan', $berita->gambar);
                }
            }

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Insert Berita',
                        'text' => 'Data berhasil ditambahkan!'
                    ]
                );

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Insert Media',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $validatedData = Validator::make($request->all(), [
                'edtJenis' => 'required',
                'edtRespon' => 'required'
            ], [
                'edtJenis.required' => $this->jenisMessage(),
                'edtRespon.required' => $this->responMessage(),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Update Pemberitaan',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $pemberitaan = PemberitaanModel::findOrFail($id);

            $data = [
                'jenis' => $request->edtJenis,
                'respon' => $request->edtRespon,
            ];


            $gambarLama = null;

            if($request->edtJenis === 'media online') {
                if ($request->edtJenis !== $pemberitaan->jenis) {
                    $data['gambar'] = null;
                    deleteFile('public/images/pemberitaan/' . $pemberitaan->gambar);
                }

                $data['tautan'] = $request->edtTautan;
            } else if ($request->edtJenis === 'media cetak' || $request->edtJenis === 'media elektronik') {
                if ($pemberitaan->jenis === 'media online' && $request->edtJenis !== $pemberitaan->jenis) {
                    $data['tautan'] = null;
                }

                $gambar = $request->file('edtGambar');
                $filename = time() . '-' . str_replace(' ', '-', $gambar->getClientOriginalName());

                $gambarLama = $pemberitaan->gambar;
                $data['gambar'] = $filename;
            }


            if($pemberitaan->update($data)) {
                if ($data['jenis'] === 'media cetak' || $data['jenis'] === 'media elektronik') {
                    $gambar->storeAs('public/images/pemberitaan', $data['gambar']);

                    deleteFile('public/images/pemberitaan/' . $gambarLama);
                }

                return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Ubah Berita',
                        'text' => 'Data berhasil diubah!'
                    ]
                );
            }
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Insert Media',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function destroy($id)
    {
        try {
            $pemberitaan = PemberitaanModel::findOrFail($id);

            if ($pemberitaan->delete()) {
                if ($pemberitaan->jenis === 'media cetak' || $pemberitaan->jenis === 'media elektronik') {
                    deleteFile('public/images/pemberitaan/' . $pemberitaan->gambar);
                }

                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'success',
                            'title' => 'Hapus Data',
                            'text' => 'Hapus Data Media Berhasil'
                        ]
                    );
            }
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Insert Media',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }
}
