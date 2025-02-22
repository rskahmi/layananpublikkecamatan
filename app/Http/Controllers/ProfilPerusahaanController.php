<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfilPerusahaanResource;
use App\Http\Resources\ProfilRuIIResource;
use App\Models\ProfilPerusahaanModel;
use App\Traits\CacheTimeout;
use App\Traits\RulesTraits;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfilPerusahaanController extends Controller
{
    use CacheTimeout, RulesTraits;

    public $path = 'public/images/profil-perusahaan';
    public function show()
    {
        try {
            $profil = Cache::remember('profil_perusahaan', $this->time, function () {
                return ProfilPerusahaanModel::all();
            });

            $visi = $profil->where('jenis', 'visi')->values()->all()[0];
            $misi = $profil->where('jenis', 'misi')->values()->all()[0];
            $email = $profil->where('jenis', 'email')->values()->all()[0];
            $telepon = $profil->where('jenis', 'telepon')->values()->all()[0];
            $sekilas = $profil->where('jenis', 'sekilas')->values()->all()[0];
            $sejarah = $profil->where('jenis', 'sejarah')->values()->all()[0];
            $produk = $profil->where('jenis', 'produk')->values()->all();

            $jabatanTingkat1 = $profil->where('jenis', 'struktur')->where('tingkatan', 1)->values()->all()[0];
            $jabatanTingkat2 = $profil->where('jenis', 'struktur')->where('tingkatan', 2)->values()->all()[0];
            $jabatanTingkat3 = $profil->where('jenis', 'struktur')->where('tingkatan', 3)->values()->all()[0];
            $jabatanTingkat4 = $profil->where('jenis', 'struktur')->where('tingkatan', 4)->values()->all()[0];

            return view('after-login.perusahaan.index')->with(
                [
                    'email' => $email,
                    'telepon' => $telepon,
                    'visi' => $visi,
                    'misi' => $misi,
                    'sekilas' => $sekilas,
                    'sejarah' => $sejarah,
                    'produk' => $produk,
                    'jabatanTingkat1' => $jabatanTingkat1,
                    'jabatanTingkat2' => $jabatanTingkat2,
                    'jabatanTingkat3' => $jabatanTingkat3,
                    'jabatanTingkat4' => $jabatanTingkat4,
                ]
            );

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show Profil RU II',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }
    public function storeProduk(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'gambarProduk' => 'required|mimes:png,jpg,jpeg',
                'kategori' => 'required',
                'nama' => 'required'
            ], [
                'nama.required' => $this->requiredMessage('nama produk'),
                'gambarProduk.required' => $this->requiredMessage('gambar produk'),
                'gambarProduk.mimes' => $this->fileMessage(['jpeg', 'png', 'jpg']),
                'kategori.required' => $this->requiredMessage('kategori')
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Tambah produk gagal!!!',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $gambar = $request->file('gambarProduk');
            $filename = generateFileName($gambar->getClientOriginalName());

            $produk = ProfilPerusahaanModel::create([
                'deskripsi' => $request->nama,
                'gambar' => $filename,
                'kategori' => $request->kategori,
                'jenis' => 'produk',
            ]);

            if($produk) {
                $gambar->storeAs($this->path . '/produk', $filename);
                $this->forgetPerusahaan();
            }


            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Tambah produk',
                        'text' => 'Data berhasil di tambah'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Tambah produk',
                        'text' => 'Data gagal di tambah'
                    ]
                );
        }
    }

    public function updateVisiMisi(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'visi' => 'required|string',
                'misi' => 'required|string'
            ], [
                'visi.required' => $this->requiredMessage('visi'),
                'misi.required' => $this->requiredMessage('misi')
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Update visi misi gagal!!!',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            // Update visi
            $updateVisi = ProfilPerusahaanModel::where('jenis', 'visi')->first();
            $updateVisi->update([
                'deskripsi' => $request->visi
            ]);

            $updateMisi = ProfilPerusahaanModel::where('jenis', 'misi')->first();
            $updateMisi->update([
                'deskripsi' => $request->misi
            ]);

            $this->forgetPerusahaan();

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update visi & misi',
                        'text' => 'Data berhasil di ubah'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update visi & misi',
                        'text' => 'Data gagal di ubah'
                    ]
                );
        }
    }

    public function updateKontak(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'telepon' => 'required',
                'email' => 'required|email'
            ], [
                'telepon.required' => $this->requiredMessage('telepon'),
                'email.required' => $this->requiredMessage('email'),
                'email.email' => $this->formattingMessage('email', 'email')
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Update kontak gagal!!!',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            // Update Telepon
            $updateTelepon = ProfilPerusahaanModel::where('jenis', 'telepon')->first();
            $updateTelepon->update([
                'deskripsi' => $request->telepon
            ]);

            $updateEmail = ProfilPerusahaanModel::where('jenis', 'email')->first();
            $updateEmail->update([
                'deskripsi' => $request->email
            ]);

            $this->forgetPerusahaan();

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update kontak',
                        'text' => 'Data berhasil di ubah'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update kontak',
                        'text' => 'Data gagal di ubah'
                    ]
                );
        }
    }

    public function updateSejarah(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'deskripsiSejarah' => 'required',
            ], [
                'deskripsiSejarah.required' => $this->requiredMessage('deskripsi sejarah'),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Update sejarah gagal!!!',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $sejarah = ProfilPerusahaanModel::where('jenis', 'sejarah')->first();
            $sejarah->deskripsi = $request->deskripsiSejarah;

            if ($request->hasFile('gambarSejarah')) {
                $gambarLama = 'storage/images/profil-perusahaan/sejarah/' . $sejarah->gambar;

                $gambar = $request->file('gambarSejarah');
                $filename = generateFileName($gambar->getClientOriginalName());

                if($sejarah->gambar = $filename) {
                    $gambar->storeAs($this->path . '/sejarah', $filename);

                    if (File::exists($gambarLama)) {
                        File::delete($gambarLama);
                    }
                }
            }

            if($sejarah->save()){
                $this->forgetPerusahaan();
            }

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update sejarah',
                        'text' => 'Data berhasil di ubah'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update sejarah',
                        'text' => 'Data gagal di ubah'
                    ]
                );
        }
    }

    public function updateSekilas(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'deskripsiSekilas' => 'required',
            ], [
                'deskripsiSekilas.required' => $this->requiredMessage('deskripsi sekilas'),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Update sekilas gagal!!!',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $sekilas = ProfilPerusahaanModel::where('jenis', 'sekilas')->first();

            $sekilas->deskripsi = $request->deskripsiSekilas;

            if ($request->hasFile('gambarSekilas')) {
                $gambarLama = 'storage/images/profil-perusahaan/sekilas/' . $sekilas->gambar;

                $gambar = $request->file('gambarSekilas');
                $filename = generateFileName($gambar->getClientOriginalName());

                if($sekilas->gambar = $filename) {
                    $gambar->storeAs($this->path . '/sekilas', $filename);

                    if (File::exists($gambarLama)) {
                        File::delete($gambarLama);
                    }
                }
            }

            if($sekilas->save()){
                $this->forgetPerusahaan();
            }

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update sekilas',
                        'text' => 'Data berhasil di ubah'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update sekilas',
                        'text' => 'Data gagal di ubah'
                    ]
                );
        }
    }

    public function updateStruktur(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'tingkatan' => 'required',
                'namaPejabat' => 'required',
                'jabatan' => 'required',
            ], [
                'tingkatan.required' => $this->requiredMessage('tingkatan posisi'),
                'namaPejabat.required' => $this->requiredMessage('nama terkait'),
                'jabatan.required' => $this->requiredMessage('jabatan terkait'),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Update struktur gagal!!!',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $tingkatan = ProfilPerusahaanModel::where('jenis', 'struktur')->where('tingkatan', $request->tingkatan)->first();

            $tingkatan->deskripsi = $request->namaPejabat;
            $tingkatan->jabatan = $request->jabatan;

            if ($request->hasFile('foto')) {
                $gambarLama = 'storage/images/profil-perusahaan/struktur/' . $tingkatan->gambar;

                $gambar = $request->file('foto');
                $filename = generateFileName($gambar->getClientOriginalName());

                if($tingkatan->gambar = $filename) {
                    $gambar->storeAs($this->path . '/struktur', $filename);
                    if (File::exists($gambarLama)) {
                        File::delete($gambarLama);
                    }
                }
            }

            if($tingkatan->save()){
                $this->forgetPerusahaan();
            }

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update struktur',
                        'text' => 'Data berhasil di ubah'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update struktur',
                        'text' => 'Data gagal di ubah'
                    ]
                );
        }
    }
    public function updateProduk(Request $request, $id)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'edtNama' => 'required',
                'edtKategori' => 'required',
            ], [
                'edtNama.required' => $this->requiredMessage('nama produk'),
                'edtKategori.required' => $this->requiredMessage('kategori produk'),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Update produk gagal!!!',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $produk = ProfilPerusahaanModel::findOrFail($id);

            $produk->deskripsi = $request->edtNama;
            $produk->kategori = $request->edtKategori;

            if ($request->hasFile('edtGambarProduk')) {
                $gambarLama = 'storage/images/profil-perusahaan/produk/' . $produk->gambar;

                $gambar = $request->file('edtGambarProduk');
                $filename = generateFileName($gambar->getClientOriginalName());

                if($produk->gambar = $filename) {
                    $gambar->storeAs($this->path . '/produk', $filename);
                    if (File::exists($gambarLama)) {
                        File::delete($gambarLama);
                    }
                }
            }

            if($produk->save()){
                $this->forgetPerusahaan();
            }

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update produk',
                        'text' => 'Data berhasil di ubah'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update produk',
                        'text' => 'Data gagal di ubah'
                    ]
                );
        }
    }

    public function destroy($id)
    {
        try {
            $profil = ProfilPerusahaanModel::findOrFail($id);

            if (!$profil) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Delete Produk',
                    'text' => 'Data tidak ditemukan!'
                ]);
            }

            if($profil->delete()) {
                $gambarLama = 'storage/images/profil-perusahaan/produk/' . $profil->gambar;
                if (File::exists($gambarLama)) {
                    File::delete($gambarLama);
                }

                $this->forgetPerusahaan();

                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'success',
                            'title' => 'Delete Produk',
                            'text' => 'Data berhasil dihapus!'
                        ]
                    );
            }
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Delete Profil RU II',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }
}
