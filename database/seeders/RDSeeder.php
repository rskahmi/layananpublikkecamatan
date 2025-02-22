<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RDModel;

class RDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '34408f74-c1a2-11ef-9206-d64449b24588',
                'jenis' => 'Baru',
                'tanggal' => now(),
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ],
            [
                'id' => '3440978a-c1a2-11ef-9206-d64449b24588',
                'jenis' => 'Ganti',
                'tanggal' => now(),
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ],
            [
                'id' => '34409b4a-c1a2-11ef-9206-d64449b24588',
                'jenis' => 'Kembalikan',
                'tanggal' => now(),
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ],
        ];
        DB::table('rd')->insert($data);
    }
}
