<?php

namespace App\Http\Controllers;

use App\Traits\CacheTimeout;
use App\Traits\CreatePdfTraits;
use App\Models\ProgramUnggulanModel;
use App\Models\ProfilPerusahaanModel;
use Illuminate\Support\Facades\Cache;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class TentangController extends Controller
{
    use CreatePdfTraits, CacheTimeout;
    public function index()
    {
        return view('before-login.tentang.index');
    }

    public function sekilas()
    {
        $sekilas = Cache::remember('sekilas', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'sekilas')->first();
        });

        return view('before-login.tentang.sekilas')->with('sekilas', $sekilas);
    }

    public function sejarah()
    {
        $sejarah = Cache::remember('sejarah', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'sejarah')->first();
        });
        return view('before-login.tentang.sejarah')->with('sejarah', $sejarah);
    }

    public function visimisi()
    {
        $visi = Cache::remember('visi', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'visi')->first();
        });

        $misi = Cache::remember('misi', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'misi')->first();
        });

        return view('before-login.tentang.visi-dan-misi')->with([
            'visi' => $visi,
            'misi' => $misi,
        ]);
    }

    public function produk()
    {
        $bbm = Cache::remember('produk-bbm', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'produk')->where('kategori', 'BBM')->get();
        });
        $nonbbm = Cache::remember('produk-nonbbm', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'produk')->where('kategori', 'NON BBM')->get();
        });

        return view('before-login.tentang.produk')->with([
            'bbm' => $bbm,
            'nonbbm' => $nonbbm,
        ]);
    }

    public function program()
    {
        $program_unggulan = ProgramUnggulanModel::with('wilayah')->paginate(3);

        return view('before-login.tentang.program-unggulan', compact('program_unggulan'));
    }

    public function struktur()
    {
        $jabatanTingkat1 = ProfilPerusahaanModel::where('jenis', 'struktur')->where('tingkatan', 1)->first();
        $jabatanTingkat2 = ProfilPerusahaanModel::where('jenis', 'struktur')->where('tingkatan', 2)->first();
        $jabatanTingkat3 = ProfilPerusahaanModel::where('jenis', 'struktur')->where('tingkatan', 3)->first();
        $jabatanTingkat4 = ProfilPerusahaanModel::where('jenis', 'struktur')->where('tingkatan', 4)->first();

        return view('before-login.tentang.struktur')->with([
            'jabatanTingkat1' => $jabatanTingkat1,
            'jabatanTingkat2' => $jabatanTingkat2,
            'jabatanTingkat3' => $jabatanTingkat3,
            'jabatanTingkat4' => $jabatanTingkat4,
        ]);
    }
    public function kontak()
    {
        $telepon = Cache::remember('telepon', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'telepon')->first();
        });

        $email = Cache::remember('email', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'email')->first();
        });

        return view('before-login.tentang.kontak')->with([
            'telepon' => $telepon,
            'email' => $email,
        ]);
    }
}
