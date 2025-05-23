<?php

namespace App\Http\Controllers;

use App\Traits\RulesTraits;
use Exception;
use Carbon\Carbon;
use App\Models\RilisModel;
use App\Traits\CacheTimeout;
use Illuminate\Http\Request;
use App\Events\DashboardMediaEvent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Auth\RilisResources;


class RilisController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function dashboardMedia()
    {
        try {
            $year = Carbon::now()->year;
            $media = Cache::remember('media_data_in_dashboard', $this->time, function () use ($year) {

                $jumlahRilis = RilisModel::whereYear('created_at', $year)->count('id');


                function getDomainFromUrl($url)
                {
                    $parsedUrl = parse_url($url);
                    return $parsedUrl['host'] ?? null;
                }

                $jumlahMedia = PemberitaanModel::where('jenis', 'media online')
                    ->whereYear('created_at', $year)
                    ->get();
                $domains = [];

                foreach ($jumlahMedia as $item) {
                    $domain = getDomainFromUrl($item->tautan);
                    if ($domain) {
                        if (!isset ($domains)) {
                            $domains = [];
                        }
                        $domains[$domain] = true;
                    }
                }
                $totalMedia = count($domains);

                $jumlahMediaCetak = PemberitaanModel::where('jenis', 'media cetak')->whereYear('created_at', $year)->count('id');

                $jumlahMediaOnline = PemberitaanModel::where('jenis', 'media online')->whereYear('created_at', $year)->count('id');

                $jumlahMediaElektronik = PemberitaanModel::where('jenis', 'media elektronik')->whereYear('created_at', $year)->count('id');

                $jumlahMediaPositif = PemberitaanModel::whereYear('created_at', $year)->where('respon', 'positif')->count();

                $jumlahMediaNegatif = PemberitaanModel::whereYear('created_at', $year)->where('respon', 'negatif')->count();

                $jumlahMediaNetral = PemberitaanModel::whereYear('created_at', $year)->where('respon', 'netral')->count();


                // Hitung jumlah dan persentase respon untuk media online
                $jumlahResponOnline = [
                    'positif' => PemberitaanModel::where('jenis', 'Media Online')->where('respon', 'positif')->whereYear('created_at', $year)->count('id'),
                    'negatif' => PemberitaanModel::where('jenis', 'Media Online')->where('respon', 'negatif')->whereYear('created_at', $year)->count('id'),
                    'netral' => PemberitaanModel::where('jenis', 'Media Online')->where('respon', 'netral')->whereYear('created_at', $year)->count('id')
                ];


                // Hitung jumlah dan persentase respon untuk media cetak
                $jumlahResponCetak = [
                    'positif' => PemberitaanModel::where('jenis', 'Media Cetak')->where('respon', 'positif')->whereYear('created_at', $year)->count('id'),
                    'negatif' => PemberitaanModel::where('jenis', 'Media Cetak')->where('respon', 'negatif')->whereYear('created_at', $year)->count('id'),
                    'netral' => PemberitaanModel::where('jenis', 'Media Cetak')->where('respon', 'netral')->whereYear('created_at', $year)->count('id')
                ];

                // Hitung jumlah dan persentase respon untuk media elektronik
                $jumlahResponElektronik = [
                    'positif' => PemberitaanModel::where('jenis', 'Media Elektronik')->where('respon', 'positif')->whereYear('created_at', $year)->count(),
                    'negatif' => PemberitaanModel::where('jenis', 'Media Elektronik')->where('respon', 'negatif')->whereYear('created_at', $year)->count(),
                    'netral' => PemberitaanModel::where('jenis', 'Media Elektronik')->where('respon', 'netral')->whereYear('created_at', $year)->count()
                ];

                return [
                    'total_rilis' => $jumlahRilis,
                    'total_berita' => $jumlahBerita,
                    'total_media' => $totalMedia,
                    'total_media_online' => $jumlahMediaOnline,
                    'total_media_cetak' => $jumlahMediaCetak,
                    'total_media_elektronik' => $jumlahMediaElektronik,
                    'jumlah_respon_online' => $jumlahResponOnline,
                    'jumlahResponElektronik' => $jumlahResponElektronik,
                    'jumlahResponCetak' => $jumlahResponCetak,
                    'jumlahResponOnline' => $jumlahResponOnline
                ];
            });

            return view('after-login.media.dashboard')
                ->with([
                    'media' => $media
                ]);
        } catch (Exception $e) {
            return redirect()->back()->with(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'Dashboard Media',
                    'text' => $e->getMessage()
                ]
            );
        }
    }

    public function beritaHome(){
        $berita = RilisModel::paginate(8);
            return view('before-login.beranda')
                ->with(['berita' => $berita]);
    }

    public function berita()
    {
        try {

            // $berita = RilisModel::with(['pemberitaan' => function ($query) {
            //     $query->where('jenis', 'media online')->where('respon', '!=', 'negatif');
            // }])->whereHas('pemberitaan', function ($query) {
            //     $query->where('jenis', 'media online');
            // })->paginate(8);

            $berita = RilisModel::paginate(8);
            return view('before-login.berita')
                ->with(['berita' => $berita]);
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show Berita',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function showMonitoring()
    {
        try {
            $media = Cache::remember('media_data_in_monitoring', $this->time, function () {
                return RilisModel::get();
            });

            return view('after-login.media.monitoring')
                ->with(['rilis' => RilisResources::collection($media)]);

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show Monitoring',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function detail($id)
    {
        $year = Carbon::now()->year;
        $rilis = RilisModel::where('id', $id)->first();
        $pemberitaan_online = PemberitaanModel::with('rilis')->where('rilis_id', $id)->where('jenis', 'media online')->get();
        $pemberitaan_cetak = PemberitaanModel::with('rilis')->where('rilis_id', $id)->where('jenis', 'media cetak')->get();
        $pemberitaan_elektronik = PemberitaanModel::with('rilis')->where('rilis_id', $id)->where('jenis', 'media elektronik')->get();

        $jumlahBerita = PemberitaanModel::with('rilis')->where('rilis_id', $id)
            ->whereYear('created_at', $year)
            ->count();

        $jumlahBeritaOnline = PemberitaanModel::where('rilis_id', $id)
            ->where('jenis', 'media online')
            ->whereYear('created_at', $year)
            ->count('id');

        $jumlahBeritaCetak = PemberitaanModel::where('rilis_id', $id)
            ->where('jenis', 'media cetak')
            ->whereYear('created_at', $year)
            ->count('id');

        $jumlahBeritaElektronik = PemberitaanModel::where('rilis_id', $id)
            ->where('jenis', 'media elektronik')
            ->whereYear('created_at', $year)
            ->count('id');


        return view('after-login.media.detail')->with([
            'rilis' => $rilis,
            'pemberitaan_online' => $pemberitaan_online,
            'pemberitaan_cetak' => $pemberitaan_cetak,
            'pemberitaan_elektronik' => $pemberitaan_elektronik,
            'jumlah_berita' => $jumlahBerita,
            'jumlah_berita_online' => $jumlahBeritaOnline,
            'jumlah_berita_cetak' => $jumlahBeritaCetak,
            'jumlah_berita_elektronik' => $jumlahBeritaElektronik,

        ]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'judul' => 'required',
                'deskripsi' => 'required',
                'gambar' => 'required|mimes:jpeg,png,jpg',
            ], [
                'judul.required' => $this->requiredMessage('judul'),
                'deskripsi.required' => $this->requiredMessage('deskripsi'),
                'gambar.required' => $this->requiredMessage('gambar'),
                'gambar.mimes' => $this->fileMessage(['jpeg', 'png', 'jpg']),
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert Data Rilis',
                            'text' => validatorError($validator->errors()->all())
                        ]
                    );
            }

            $gambar = $request->file('gambar');
            $filename = time() . '-' . str_replace(' ', '-', $gambar->getClientOriginalName());

            $media = RilisModel::create([
                "judul" => $request->judul,
                "deskripsi" => $request->deskripsi,
                "gambar" => $filename,
            ]);

            if ($media) {
                event(new DashboardMediaEvent($media));
                $gambar->storeAs('public/images/rilis', $filename);
                $this->forgetMedia();
            }


            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Insert Rilis',
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
        try {
            $media = RilisModel::findOrFail($id);

            $data = [
                'judul' => $request->edtJudul,
                'deskripsi' => $request->edtDeskripsiMedia,
            ];

            if ($request->has('edtGambar')) {
                $gambar = $request->file('edtGambar');
                $filename = time() . '-' . str_replace(' ', '-', $gambar->getClientOriginalName());
                $gambar->storeAs('public/images/media', $filename);

                if ($media->gambar) {
                    Storage::disk('public')->delete('images/media/' . $media->gambar);
                }

                $data['gambar'] = $filename;
            }

            $media->update($data);
            $this->forgetMedia();

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update Media',
                        'text' => 'Data berhasil diubah!'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update Media',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function destroy($id)
    {
        try {
            $media = RilisModel::findOrFail($id);

            if (!$media) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Delete Media',
                    'text' => 'Data tidak ditemukan!'
                ]);
            }

            $imagePath = 'storage/images/media/' . $media->gambar;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            event(new DashboardMediaEvent([
                'deleted_at' => time()
            ]));

            $media->delete();
            $this->forgetMedia();

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Delete Media',
                'text' => 'Data berhasil dihapus!'
            ]);

        } catch (Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Delete Media',
                'text' => $e->getMessage()
            ]);
        }
    }
}
