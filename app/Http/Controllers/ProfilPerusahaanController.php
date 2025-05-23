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
            $sejarah = $profil->where('jenis', 'sejarah')->values()->all()[0];
            $alursurat = $profil->where('jenis', 'alursurat')->values()->all()[0];
            $alurpengaduan = $profil->where('jenis', 'alurpengaduan')->values()->all()[0];
            $produk = $profil->where('jenis', 'produk')->values()->all();

            return view('after-login.perusahaan.index')->with(
                [
                    'email' => $email,
                    'telepon' => $telepon,
                    'visi' => $visi,
                    'misi' => $misi,
                    'sejarah' => $sejarah,
                    'alursurat' => $alursurat,
                    'alurpengaduan' => $alurpengaduan,
                    'produk' => $produk,
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
                'nama' => 'required'
            ], [
                'nama.required' => $this->requiredMessage('nama produk'),
                'gambarProduk.required' => $this->requiredMessage('gambar produk'),
                'gambarProduk.mimes' => $this->fileMessage(['jpeg', 'png', 'jpg']),
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



    public function updateAlurSurat(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'deskripsiAlurSurat' => 'required',
            ], [
                'deskripsiAlurSurat.required' => $this->requiredMessage('deskripsi alur surat'),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Update Alur Pengajuan Surat Gagal!!!',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $alursurat = ProfilPerusahaanModel::where('jenis', 'alursurat')->first();
            $alursurat->deskripsi = $request->deskripsiAlurSurat;

            if ($request->hasFile('gambarAlurSurat')) {
                $gambarLama = 'storage/images/profil-perusahaan/alursurat/' . $alursurat->gambar;

                $gambar = $request->file('gambarAlurSurat');
                $filename = generateFileName($gambar->getClientOriginalName());

                if($alursurat->gambar = $filename) {
                    $gambar->storeAs($this->path . '/alursurat', $filename);

                    if (File::exists($gambarLama)) {
                        File::delete($gambarLama);
                    }
                }
            }

            if($alursurat->save()){
                $this->forgetPerusahaan();
            }

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update alursurat',
                        'text' => 'Data berhasil di ubah'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update alursurat',
                        'text' => 'Data gagal di ubah'
                    ]
                );
        }
    }


    public function updateAlurPengaduan(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'deskripsiAlurPengaduan' => 'required',
            ], [
                'deskripsiAlurPengaduan.required' => $this->requiredMessage('deskripsi alur pengaduan'),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Update Alur Pengajuan Pengaduan Gagal!!!',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $alurpengaduan = ProfilPerusahaanModel::where('jenis', 'alurpengaduan')->first();
            $alurpengaduan->deskripsi = $request->deskripsiAlurPengaduan;

            if ($request->hasFile('gambarAlurPengaduan')) {
                $gambarLama = 'storage/images/profil-perusahaan/alurpengaduan/' . $alurpengaduan->gambar;

                $gambar = $request->file('gambarAlurPengaduan');
                $filename = generateFileName($gambar->getClientOriginalName());

                if($alurpengaduan->gambar = $filename) {
                    $gambar->storeAs($this->path . '/alursurat', $filename);

                    if (File::exists($gambarLama)) {
                        File::delete($gambarLama);
                    }
                }
            }

            if($alurpengaduan->save()){
                $this->forgetPerusahaan();
            }

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update alur pengaduan',
                        'text' => 'Data berhasil di ubah'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update alur pengaduan',
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
            ], [
                'edtNama.required' => $this->requiredMessage('nama produk'),
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
