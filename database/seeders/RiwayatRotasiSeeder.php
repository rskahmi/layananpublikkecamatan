<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatRotasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'dfee01cc-c390-11ef-aa9b-3e044da7267f',
                'tindakan' => 1,
                'status' => 'proses',
                'peninjau' => 'mgr-adm' ,
                'alasan' => '-',
                'rotasi_id' => 'dfedf722-c390-11ef-aa9b-3e044da7267f',
                'user_id' => '8f2f4c57-ecd2-11ee-909b-2b68b9c84cfe',
                'created_at' => now()
            ]
            ];
            DB::table('riwayat_rotasi')->insert($data);
    }
}
