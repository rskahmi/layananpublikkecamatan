<?php

namespace App\Http\Controllers;

use App\Traits\CacheTimeout;
use App\Traits\RulesTraits;
use Exception;
use Illuminate\Http\Request;
use App\Models\ProgramUnggulanModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProgramUnggulanResource;

class ProgramUnggulanController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function show()
    {
        try {
            $program_unggulan = Cache::remember('program_unggulan_data', $this->time, function () {
                return ProgramUnggulanModel::get();
            });

            return view('after-login.program-unggulan.index')->with(
                [
                    'program_unggulan' => ProgramUnggulanResource::collection($program_unggulan),
                ]
            );

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show Program Unggulan',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }
    public function store(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'nama_kegiatan' => 'required|string',
                'nama_kelompok' => 'required|string',
                'mitra' => 'required|string',
                'contact' => 'required|string',
                'pic' => 'required|string',
                'deskripsi' => 'required|string',
                'gambar' => 'required|mimes:jpeg,png,jpg',
            ], [
                'nama_kegiatan.required' => $this->requiredMessage('nama kegiatan'),
                'nama_kelompok.required' => $this->requiredMessage('nama kelompok'),
                'mitra.required' => $this->requiredMessage('mitra binaan'),
                'contact.required' => $this->requiredMessage('kontak'),
                'pic.required' => $this->requiredMessage('nama pic'),
                'deskripsi.required' => $this->requiredMessage('deskripsi'),
                'gambar.required' => $this->requiredMessage('gambar'),
                'gambar.mimes' => $this->fileMessage(['jpeg', 'png', 'jpg']),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert Program Unggulan',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }

            $filename = null;
            $gambar = $request->file('gambar');
            $filename = time() . '-' . str_replace(' ', '-', $gambar->getClientOriginalName());

            $program_unggulan = ProgramUnggulanModel::create([
                "nama_kegiatan" => $request->nama_kegiatan,
                "nama_kelompok" => $request->nama_kelompok,
                "mitra" => $request->mitra,
                "contact" => $request->contact,
                "pic" => $request->pic,
                "deskripsi" => $request->deskripsi,
                "gambar" => $filename,
                "user_id" => auth()->user()->id
            ]);

            if ($program_unggulan) {
                $gambar->storeAs('public/images/program-unggulan', $filename);
                $this->forgetProgram();
            }


            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Insert Program Unggulan',
                        'text' => 'Data berhasil ditambahkan!'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Insert Program Unggulan',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $program_unggulan = ProgramUnggulanModel::findOrFail($id);

            $data = [
                'nama_kegiatan' => $request->edtNamaProgram,
                "nama_kelompok" => $request->edtNamaKelompok,
                "mitra" => $request->edtMitra,
                'contact' => $request->edtContact,
                'pic' => $request->edtPic,
                'deskripsi' => $request->edtDeskripsi,
            ];

            if ($request->has('edtGambar')) {
                $gambar = $request->file('edtGambar');
                $filename = time() . '-' . str_replace(' ', '-', $gambar->getClientOriginalName());
                $gambar->storeAs('public/images/program-unggulan', $filename);

                if ($program_unggulan->gambar) {
                    Storage::disk('public')->delete('images/program-unggulan/' . $program_unggulan->gambar);
                }

                $data['gambar'] = $filename;
            }

            $program_unggulan->update($data);

            $this->forgetProgram();

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update Program Unggulan',
                        'text' => 'Data berhasil diperbarui!'
                    ]
                );

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update Program Unggulan',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function destroy($id)
    {
        try {
            $program_unggulan = ProgramUnggulanModel::findOrFail($id);

            if (!$program_unggulan) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Delete Program Unggulan',
                    'text' => 'Data tidak ditemukan!'
                ]);
            }

            $imagePath = 'public/images/program-unggulan/' . $program_unggulan->gambar;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $program_unggulan->delete();

            $this->forgetProgram();

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Delete Program Unggulan',
                        'text' => 'Data berhasil dihapus!'
                    ]
                );

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Delete Program Unggulan',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function forgetAll()
    {
        Cache::forget('program_unggulan_data');
        Cache::forget('program_unggulan_data_paginate');
    }
}
