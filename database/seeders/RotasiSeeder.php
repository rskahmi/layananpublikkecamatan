<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RotasiModel;

class RotasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'dfedf722-c390-11ef-aa9b-3e044da7267f',
                'tanggal' => now(),
                'status' => 'proses',
                'user_id' => '8f2f4c57-ecd2-11ee-909b-2b68b9c84cfe',
                'created_at' => now(),
            ]
        ];
        DB::table('rotasi')->insert($data);

    }
}
