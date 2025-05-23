<?php

namespace App\Http\Controllers\Test;

use App\Models\TjslModel;
use App\Models\BerkasModel;
use Illuminate\Http\Request;
use App\Traits\NomorSuratTraits;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TestAjah extends Controller
{
    use NomorSuratTraits;
    public function index()
    {
        $status = 'ditolak';
        $data = [];
        if ($status == 'diterima') {
            $data = [
                'no_surat' => '011/KPI45800/2024-S8',
                'no_surat_proposal' => 'PROPS/011/KPI45800/2024-S8',
                'nama' => 'Proposal Nonton Bareng Timnas U23 vs Uzbekistan',
                'tanggal_masuk' => '17 Januari 2024',
                'tanggal_sekarang' => ' 05 Januari 2023',
                'pemohon' => 'Joko Nugroho',
                'anggaran' => 'Rp. 25.000.000',
            ];
        } else {
            $data = [
                'no_surat' => '011/KPI45800/2024-S8',
                'no_surat_proposal' => 'PROPS/011/KPI45800/2024-S8',
                'nama' => 'Proposal Nonton Bareng Timnas U23 vs Uzbekistan',
                'tanggal_masuk' => '17 Januari 2024',
                'tanggal_sekarang' => ' 05 Januari 2023',
                'pemohon' => 'Joko Nugroho',
            ];

        }

        $this->generate($data, $status);
        // return view('after-login.pdf.surat-penolakan', $data);
    }
}
