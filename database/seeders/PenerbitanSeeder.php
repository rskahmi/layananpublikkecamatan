<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PenerbitanModel;

class PenerbitanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '070eeee0-c7e4-11ef-ac6f-8a69bb8478fa',
                'jenis' => 'Baru',
                'tanggal' => now(),
                'status' => 'diajukan',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ],
            [
                'id' => '070ef552-c7e4-11ef-ac6f-8a69bb8478fa',
                'jenis' => 'Ganti',
                'tanggal' => now(),
                'status' => 'diajukan',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ],
            [
                'id' => '070efc14-c7e4-11ef-ac6f-8a69bb8478fa',
                'jenis' => 'Kembalikan',
                'tanggal' => now(),
                'status' => 'diajukan',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ],
            ];
            DB::table('penerbitan')->insert($data);
    }
}
