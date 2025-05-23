<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheTimeout
{
    protected $time = 1200;

    public function forgetAll()
    {
        $this->forgetProgram();
        $this->forgetMedia();
        $this->forgetUser();
        $this->forgetResume();
        $this->forgetPerusahaan();
        $this->forgetPengaduan();
        $this->forgetSurat();
    }

    public function forgetUser()
    {
        Cache::forget('user_data');
    }

    public function forgetPerusahaan()
    {
        Cache::forget('profil_perusahaan');
        Cache::forget('visi');
        Cache::forget('misi');
        Cache::forget('telepon');
        Cache::forget('email');
        Cache::forget('produk-bbm');
        Cache::forget('produk-nonbbm');
        Cache::forget('sejarah');
    }

    public function forgetResume()
    {
        $keys = [
            'batas_konfirmasi_proposal',
            'media_data_in_resume',
            'proposal_jumlahprogramproses_data',
            'jumlah_Stakeholder_tjsl_data',
            'jumlah_Stakeholder_sponsorship_data',
            'total_anggaran_tjsl_data',
            'total_anggaran_sponsorship_data',
            'grafik_rilis_data',
            'grafik_pemberitaan_data',
            'grafik_media_data',
            'tjsl_by_stakeholder_data',
            'sponsorship_data_in_resume',
            'total_terprogram_tjsl_data',
            'total_tidak_terprogram_tjsl_data',
            'jumlah_pembiayaan_tjsl',
            'jumlah_pembiayaan_sponsorship'
        ];

        $this->forgets($keys);
    }

    public function forgetSurat()
    {
        $keys = [
            'grafik_bbm',
            'grafik_ktp',
            'grafik_kk',
            'grafik_sktm',
            'total_surat',
            'total_surat_proses',
            'total_surat_selesai',
        ];

        $this->forgets($keys);
    }

    public function forgetPengaduan()
    {
        $keys = [
            'grafik_pengaduan',
            'total_pengaduan',
            'jumlah_status_proses_pengaduan',
            'status_terima_umd_in_dashboard',
            'jumlah_status_selesai_pengaduan',
            'jumlah_status_tolak_pengaduan',
        ];

        $this->forgets($keys);
    }

    public function forgetMedia()
    {
        $keys = [
            'media_data_in_dashboard',
            'media_data_in_monitoring',
            'media_data_in_resume',
            'grafik_media_data',
            'grafik_rilis_data',
            'grafik_pemberitaan_data'
        ];

        $this->forgets($keys);
    }

    public function forgetProgram()
    {
        $keys = [
            'program_unggulan_data',
            'data_tjsl_program_unggulan'
        ];

        $this->forgets($keys);
    }

    public function forgets($keys)
    {
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}
