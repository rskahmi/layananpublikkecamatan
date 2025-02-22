<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RiwayatPenerbitanModel;

class RiwayatPenerbitanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '070f03b2-c7e4-11ef-ac6f-8a69bb8478fa',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'am' ,
                'alasan' => '-',
                'penerbitan_id' => '070eeee0-c7e4-11ef-ac6f-8a69bb8478fa',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now()
            ],
            [
                'id' => '070f0ae2-c7e4-11ef-ac6f-8a69bb8478fa',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'am' ,
                'alasan' => '-',
                'penerbitan_id' => '070ef552-c7e4-11ef-ac6f-8a69bb8478fa',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now()
            ],
            [
                'id' => '070f0fd8-c7e4-11ef-ac6f-8a69bb8478fa',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'am' ,
                'alasan' => '-',
                'penerbitan_id' => '070efc14-c7e4-11ef-ac6f-8a69bb8478fa',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now()
            ],

            ];
            DB::table('riwayat_penerbitan')->insert($data);
    }
}
