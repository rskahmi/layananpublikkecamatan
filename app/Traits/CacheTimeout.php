<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheTimeout
{
    protected $time = 1200;

    public function forgetAll()
    {
        $this->forgetBerkas();
        $this->forgetNPP();
        $this->forgetSIJ();
        $this->forgetSPDL();
        $this->forgetSPD();
        $this->forgetRD();
        $this->forgetIso();
        $this->forgetLembaga();
        $this->forgetWilayah();
        $this->forgetTjsl();
        $this->forgetProgram();
        $this->forgetPumk();
        $this->forgetMedia();
        $this->forgetUser();
        $this->forgetResume();
        $this->forgetPerusahaan();
    }

    public function forgetUser()
    {
        Cache::forget('user_data');
    }

    public function forgetIso()
    {
        Cache::forget('iso_status_data');
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
        Cache::forget('sekilas');
    }

    public function forgetLembaga()
    {
        Cache::forget('lembaga_data');
    }

    public function forgetWilayah()
    {
        $keys = [
            'wilayah_data',
            'data_tjsl_program_unggulan',
        ];

        $this->forgets($keys);
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

    public function forgetBerkas()
    {
        $keys = [
            'total_anggaran_in_dashboard',
            'status_diajukan_proposal_in_dashboard',
            'status_verifikasi_proposal_in_dashboard',
            'jumlah_proposal_ditolak_in_dashboard',
            'jumlah_proposal_diproses_in_dashboard',
            'batas_konfirmasi_proposal',
            'total_pengajuan_proposal_perwilayah',
            'proposal_jumlahprogramproses_data'
        ];

        $this->forgets($keys);
    }

    public function forgetNPP()
    {
        $keys = [
            'grafik_umd_data',
            'grafik_reim_data',
            'total_umd_in_dashboard',
            'status_terima_umd_in_dashboard',
            'total_reim_in_dashboard',
            'status_terima_reim_in_dashboard',
        ];

        $this->forgets($keys);
    }

    public function forgetRD()
    {
        $keys = [
            // 'total_anggaran_in_dashboard',
            // 'status_diajukan_proposal_in_dashboard',
            // 'status_verifikasi_proposal_in_dashboard',
            // 'jumlah_proposal_ditolak_in_dashboard',
            // 'jumlah_proposal_diproses_in_dashboard',
            // 'batas_konfirmasi_proposal',
            // 'total_pengajuan_proposal_perwilayah',
            // 'proposal_jumlahprogramproses_data'
        ];

        $this->forgets($keys);
    }

    public function forgetSIJ()
    {
        $keys = [
            // 'total_anggaran_in_dashboard',
            // 'status_diajukan_proposal_in_dashboard',
            // 'status_verifikasi_proposal_in_dashboard',
            // 'jumlah_proposal_ditolak_in_dashboard',
            // 'jumlah_proposal_diproses_in_dashboard',
            // 'batas_konfirmasi_proposal',
            // 'total_pengajuan_proposal_perwilayah',
            // 'proposal_jumlahprogramproses_data'
        ];

        $this->forgets($keys);
    }

    public function forgetSPD()
    {
        $keys = [
            // 'total_anggaran_in_dashboard',
            // 'status_diajukan_proposal_in_dashboard',
            // 'status_verifikasi_proposal_in_dashboard',
            // 'jumlah_proposal_ditolak_in_dashboard',
            // 'jumlah_proposal_diproses_in_dashboard',
            // 'batas_konfirmasi_proposal',
            // 'total_pengajuan_proposal_perwilayah',
            // 'proposal_jumlahprogramproses_data'
        ];

        $this->forgets($keys);
    }

    public function forgetRotasi()
    {
        $keys = [
            // 'total_anggaran_in_dashboard',
            // 'status_diajukan_proposal_in_dashboard',
            // 'status_verifikasi_proposal_in_dashboard',
            // 'jumlah_proposal_ditolak_in_dashboard',
            // 'jumlah_proposal_diproses_in_dashboard',
            // 'batas_konfirmasi_proposal',
            // 'total_pengajuan_proposal_perwilayah',
            // 'proposal_jumlahprogramproses_data'
        ];

        $this->forgets($keys);
    }

    public function forgetMutasi()
    {
        $keys = [
            // 'total_anggaran_in_dashboard',
            // 'status_diajukan_proposal_in_dashboard',
            // 'status_verifikasi_proposal_in_dashboard',
            // 'jumlah_proposal_ditolak_in_dashboard',
            // 'jumlah_proposal_diproses_in_dashboard',
            // 'batas_konfirmasi_proposal',
            // 'total_pengajuan_proposal_perwilayah',
            // 'proposal_jumlahprogramproses_data'
        ];

        $this->forgets($keys);
    }

    public function forgetPromosi()
    {
        $keys = [
            // 'total_anggaran_in_dashboard',
            // 'status_diajukan_proposal_in_dashboard',
            // 'status_verifikasi_proposal_in_dashboard',
            // 'jumlah_proposal_ditolak_in_dashboard',
            // 'jumlah_proposal_diproses_in_dashboard',
            // 'batas_konfirmasi_proposal',
            // 'total_pengajuan_proposal_perwilayah',
            // 'proposal_jumlahprogramproses_data'
        ];

        $this->forgets($keys);
    }

    public function forgetSPDL()
    {
        $keys = [
            // 'total_anggaran_in_dashboard',
            // 'status_diajukan_proposal_in_dashboard',
            // 'status_verifikasi_proposal_in_dashboard',
            // 'jumlah_proposal_ditolak_in_dashboard',
            // 'jumlah_proposal_diproses_in_dashboard',
            // 'batas_konfirmasi_proposal',
            // 'total_pengajuan_proposal_perwilayah',
            // 'proposal_jumlahprogramproses_data'
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

    public function forgetPumk()
    {
        $keys = [
            'pumk_data_in_dashboard',
            'total_data_pumk',
            'pumk_data_lancar',
            'pumk_data_tidak_lancar',
            'pumk_data_total_anggaran',
            'pumk_data_program_wilayah',
            'pumk_data_by_stakeholder',
            'pumk_data_in_monitoring',
            'jumlah_stakeholder_pumk_data',
            'total_anggaran_pumk_data',
            'grafik_pumk_data',
            'pumk_data_in_resume',
            'total_lancar_pumk_data',
            'total_tidak_lancar_pumk_data',
        ];

        $this->forgets($keys);
    }

    public function forgetTjsl()
    {
        $keys = [
            'tjsl_data',
            'jumlah_Stakeholder_tjsl_data',
            'total_anggaran_tjsl_data',
            'grafik_tjsl_data',
            'tjsl_by_stakeholder_data',
            'total_terprogram_tjsl_data',
            'total_tidak_terprogram_tjsl_data',
            'jumlah_pembiayaan_tjsl',
            'jumlah_pembiayaan_sponsorship',
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
