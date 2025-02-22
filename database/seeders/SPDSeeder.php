<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SPDModel;

class SPDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '0a6269a2-c5ed-466b-b9e4-88450032d8d0',
                'tanggal' => now(),
                'tanggalberangkat' => now(),
                'tanggalpulang' => now(),
                'tujuan' => 'jakarta',
                'status' => 'diajukan',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ]
            ];
            DB::table('spd')->insert($data);
    }
}
