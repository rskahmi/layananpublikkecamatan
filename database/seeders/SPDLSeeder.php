<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SPDLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '30830428-c31b-11ef-9ecf-fee609209ddf',
                'tanggal' => now(),
                'tanggalberangkat' => now(),
                'tanggalpulang' => now(),
                'tujuan' => 'Tanjung Balai Karimun',
                'status' => 'diajukan',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ]
            ];
            DB::table('spdl')->insert($data);
    }
}
