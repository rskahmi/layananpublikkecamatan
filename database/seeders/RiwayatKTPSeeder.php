<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatKTPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'd9ba1d9e-10f8-11f0-8445-924a24597683',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'petugasadministrasi' ,
                'alasan' => '-',
                'ktp_id' => '9aebda44-10f8-11f0-8445-924a24597683',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now()
            ]
            ];
            DB::table('riwayat_ktp')->insert($data);
    }
}
