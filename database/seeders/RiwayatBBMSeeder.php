<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatBBMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'd82a4a4a-d066-11ee-8bb8-744ca1759434',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'petugasadministrasi' ,
                'alasan' => '-',
                'bbm_id' => 'a18d2e6e-d066-11ee-8bb8-744ca1759434',
                'user_id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'created_at' => now()
            ]
            ];
            DB::table('riwayat_bbm')->insert($data);
    }
}
