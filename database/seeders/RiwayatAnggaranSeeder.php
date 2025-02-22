<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RiwayatAnggaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id'=>'bc8b68e2-d069-11ee-8bb8-744ca1759434',
                'tujuan'=> 'Bantuan Dana Program',
                'tanggal'=> '2024-01-10',
                'nominal'=> 1000000,
                'sisa_anggaran'=> 49000000,
                'tjsl_id' => '3400b3c5-d08c-11ee-8bb8-744ca1759434',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'44c3036b-ecd2-11ee-95e5-2a57142798db',
                'tujuan'=> 'Bantuan Dana Program',
                'tanggal'=> '2024-01-20',
                'nominal'=> 1000000,
                'sisa_anggaran'=> 9000000,
                'tjsl_id' => '5f125c15-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'44c30eae-ecd2-11ee-95e5-2a57142798db',
                'tujuan'=> 'Bantuan Dana Program dan Dukungan Kolaboratif',
                'tanggal'=> '2024-02-08',
                'nominal'=> 1000000,
                'sisa_anggaran'=> 9000000,
                'tjsl_id' => '5f123928-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'44c3182e-ecd2-11ee-95e5-2a57142798db',
                'tujuan'=> 'Bantuan Dana Program',
                'tanggal'=> '2024-02-21',
                'nominal'=> 1000000,
                'sisa_anggaran'=> 14000000,
                'tjsl_id' => '5f124633-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'44c3215c-ecd2-11ee-95e5-2a57142798db',
                'tujuan'=> 'Bantuan Dana Program dan Dukungan Kolaboratif',
                'tanggal'=> '2024-03-16',
                'nominal'=> 1000000,
                'sisa_anggaran'=> 24000000,
                'tjsl_id' => '5f125135-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'44c32a48-ecd2-11ee-95e5-2a57142798db',
                'tujuan'=> 'Bantuan Dana Program dan Dukungan Kolaboratif',
                'tanggal'=> '2024-03-30',
                'nominal'=> 1000000,
                'sisa_anggaran'=> 48000000,
                'tjsl_id' => '3400b3c5-d08c-11ee-8bb8-744ca1759434',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:06',
            ],

        ];
        DB::table('riwayat_anggaran')->insert($data);
    }
}
