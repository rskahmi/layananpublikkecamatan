<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatKKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'd82a4a4a-d066-11ee-8bb8-744ca1759455',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'petugasadministrasi' ,
                'alasan' => '-',
                'kk_id' => '9aebda44-10f8-11f0-8445-924a24597621',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now()
            ]
            ];
            DB::table('riwayat_kk')->insert($data);
    }
}
