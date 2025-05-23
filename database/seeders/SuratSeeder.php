<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '2fbc1b1e-d0c1-11ee-9bfa-4e4e1f8a1d2',
                'jenis' => 'BBM',
                'tanggal' => now(),
                'user_id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'created_at' =>now() ,
            ],
            [
                'id' => '6cb55eb6-10f8-11f0-8445-924a2459768',
                'jenis' => 'KTP',
                'tanggal' => now(),
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' =>now() ,
            ],
            [
                'id' => '6cb55eb6-10f8-11f0-8445-924a2459790',
                'jenis' => 'KK',
                'tanggal' => now(),
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' =>now() ,
            ],
            [
                'id' => '6cb55eb6-10f8-11f0-8445-924a2459721',
                'jenis' => 'SKTM',
                'tanggal' => now(),
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' =>now() ,
            ],
            ];
            DB::table('surat')->insert($data);
    }
}
