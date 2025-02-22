<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatSakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '30831030-c31b-11ef-9ecf-fee609209ddf',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'am' ,
                'alasan' => '-',
                'sakit_id' => 'f6e9b734-d4bc-11ee-90d5-fbe70bb0a2ed',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now()
            ]
            ];
            DB::table('riwayat_sakit')->insert($data);
    }
}
