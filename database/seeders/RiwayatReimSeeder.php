<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RiwayatReimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'c7f3d80e-d066-11ee-8bb8-744ca1759434',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'am' ,
                'alasan' => '-',
                'reim_id' => 'b36d4520-d066-11ee-8bb8-744ca1759434',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now()
            ],
            [
                'id' => '4d67c2be-d0c1-11ee-9bfa-4e4e1f8a1d25',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'am' ,
                'alasan' => '-',
                'reim_id' => '2fbc1b1e-d0c1-11ee-9bfa-4e4e1f8a1d25',
                'user_id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'created_at' => now()
            ]
            ];
            DB::table('riwayat_reim')->insert($data);
    }
}
