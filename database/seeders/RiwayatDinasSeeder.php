<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatDinasSeeder extends Seeder
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
                'peninjau' => 'am' ,
                'alasan' => '-',
                'dinas_id' => 'c0f9bc6e-d4bc-11ee-bf39-2f8ac38bbd08',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now()
            ]
            ];
            DB::table('riwayat_dinas')->insert($data);
    }
}
