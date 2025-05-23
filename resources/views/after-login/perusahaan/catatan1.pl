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
