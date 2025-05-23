<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatPengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '0016465e-0efe-4227-b2fa-cfc8ea0e0480',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'sekretariscamat' ,
                'alasan' => '-',
                'pengaduan_id' => 'ew2269a2-c5ed-466b-b9e4-88450032dwez',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now()
            ],
            [
                'id' => '0016465e-0efe-4227-b2fa-cfc8ea0e047',
                'tindakan' => 1,
                'status' => 'diterima',
                'peninjau' => '-' ,
                'alasan' => '-',
                'pengaduan_id' => '0a6269a2-c5ed-466b-b9e4-884500329',
                'user_id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'created_at' => now()
            ],
            [
                'id' => '0016465e-0efe-4227-b2fa-cfc8ea0e021',
                'tindakan' => 1,
                'status' => 'proses',
                'peninjau' => 'kepalaseksi' ,
                'alasan' => '-',
                'pengaduan_id' => '0a6269a2-c5ed-466b-b9e4-88450032d721',
                'user_id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'created_at' => now()
            ],
            [
                'id' => '0016465e-0efe-4227-b2fa-cfc8ea0e213',
                'tindakan' => 1,
                'status' => 'ditolak',
                'peninjau' => '-' ,
                'alasan' => '-',
                'pengaduan_id' => '0a6269a2-c5ed-466b-b9e4-88450032dii',
                'user_id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'created_at' => now()
            ],
            ];
            DB::table('riwayat_pengaduan')->insert($data);
    }
}
