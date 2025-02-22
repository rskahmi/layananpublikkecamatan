<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UMDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'a18d2e6e-d066-11ee-8bb8-744ca1759434',
                'status' => 'diajukan',
                'npp_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now()
            ],
            [
                'id' => '4d67c2be-d0c1-11ee-9bfa-4e4e1f8a1d25',
                'status' => 'diajukan',
                'npp_id' => '2fbc1b1e-d0c1-11ee-9bfa-4e4e1f8a1d25',
                'created_at' => now()
            ]
            ];
            DB::table('umd')->insert($data);
    }
}
