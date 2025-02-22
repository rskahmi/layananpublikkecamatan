<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SIJModel;



class SIJSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'a62d3e9c-d4bb-11ee-b3a2-8f8e0fcb098b',
                'jenis' => 'Sakit',
                'tanggal' => now(),
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ],
            [
                'id' => '92c1e1f2-d4bb-11ee-a2be-bbb3e4b54a68',
                'jenis' => 'Melayat',
                'tanggal' => now(),
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ],
            [
                'id' => 'bb839810-d4bb-11ee-9037-abc5f65ad6b1',
                'jenis' => 'Dinas',
                'tanggal' => now(),
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ],
            ];
            DB::table('sij')->insert($data);

    }
}
