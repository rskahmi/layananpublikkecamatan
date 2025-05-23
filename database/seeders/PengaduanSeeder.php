<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'ew2269a2-c5ed-466b-b9e4-88450032dwez',
                'tanggal' => now(),
                'deskripsi' => 'ini deskripsi',
                'status' => 'diajukan',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ],
            [
                'id' => '0a6269a2-c5ed-466b-b9e4-884500329',
                'tanggal' => now(),
                'deskripsi' => 'ini deskripsi',
                'status' => 'diterima',
                'user_id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'created_at' => now(),
            ],
            [
                'id' => '0a6269a2-c5ed-466b-b9e4-88450032d721',
                'tanggal' => now(),
                'deskripsi' => 'ini deskripsi',
                'status' => 'proses',
                'user_id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'created_at' => now(),
            ],
            [
                'id' => '0a6269a2-c5ed-466b-b9e4-88450032dii',
                'tanggal' => now(),
                'deskripsi' => 'ini deskripsi',
                'status' => 'ditolak',
                'user_id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'created_at' => now(),
            ],
            ];
            DB::table('pengaduan')->insert($data);
    }
}
