<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '12525520-cf66-47ce-94ea-600ad6680c6d',
                'tanggal' => now(),
                'status' => 'proses',
                'user_id' => '8f2f4c57-ecd2-11ee-909b-2b68b9c84cfe',
                'created_at' => now(),
            ]
        ];
        DB::table('mutasi')->insert($data);
    }
}
