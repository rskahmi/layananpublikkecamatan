<?php

namespace App\Http\Controllers;

use App\Traits\CacheTimeout;
use App\Models\ProgramUnggulanModel;
use App\Models\ProfilPerusahaanModel;
use Illuminate\Support\Facades\Cache;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class TentangController extends Controller
{
    use CacheTimeout;
    public function index()
    {
        return view('before-login.tentang.index');
    }

    public function sejarah()
    {
        $sejarah = Cache::remember('sejarah', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'sejarah')->first();
        });
        return view('before-login.tentang.sejarah')->with('sejarah', $sejarah);
    }

    public function alursurat()
    {
        $alursurat = Cache::remember('alursurat', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'alursurat')->first();
        });
        return view('before-login.tentang.alursurat')->with('alursurat', $alursurat);
    }

     public function alurpengaduan()
    {
        $alurpengaduan = Cache::remember('alurpengaduan', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'alurpengaduan')->first();
        });
        return view('before-login.tentang.alurpengaduan')->with('alurpengaduan', $alurpengaduan);
    }

    public function alurakun()
    {
        $alurakun = Cache::remember('alurakun', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'alurakun')->first();
        });
        return view('before-login.tentang.alurakun')->with('alurakun', $alurakun);
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

    public function program()
    {
        $program_unggulan = ProgramUnggulanModel::paginate(3);

        return view('before-login.tentang.program-unggulan', compact('program_unggulan'));
    }

    public function struktur()
    {
        $sejarah = Cache::remember('sejarah', $this->time, function () {
            return ProfilPerusahaanModel::where('jenis', 'sejarah')->first();
        });
        return view('before-login.tentang.struktur')->with('sejarah', $sejarah);

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
