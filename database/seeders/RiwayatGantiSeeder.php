<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatGantiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
            'id' => '3440a6d0-c1a2-11ef-9206-d64449b24588',
            'tindakan' => 1,
            'status' => 'diajukan',
            'peninjau' => 'am' ,
            'alasan' => '-',
            'ganti_id' => '3440a176-c1a2-11ef-9206-d64449b24588',
            'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
            'created_at' => now()
            ]
        ];
        DB::table('riwayat_ganti')->insert($data);
    }
}
