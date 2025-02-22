<?php

namespace Database\Seeders;

use App\Models\IsoModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IsoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id'=> '56bd1227-d068-11ee-8bb8-744ca1759434',
                'nama'=> 'Sistem Manajemen Keamanan Informasi (Information Security Management System)',
                'jenis' => 'ISO 27001',
                'tgl_aktif' => '2023-12-10',
                'masa_berlaku'=> '2',
                'tgl_berakhir'=> '2024-12-10',
                'status'=> 'Aktif',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> 'b46ce768-f27c-11ee-97fc-2a57142798db',
                'nama'=> 'Panduan Sosial Tanggung Jawab Perusahaan (Social Responsibility)',
                'jenis' => 'ISO 26000',
                'tgl_aktif' => '2024-02-10',
                'masa_berlaku'=> '2',
                'tgl_berakhir'=> '2026-02-10',
                'status'=> 'Aktif',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> 'b46ced5f-f27c-11ee-97fc-2a57142798db',
                'nama'=> 'Sistem Manajemen Mutu (Quality Management System)',
                'jenis' => 'ISO 9001',
                'tgl_aktif' => '2022-06-15',
                'masa_berlaku'=> '2',
                'tgl_berakhir'=> '2024-06-15',
                'status'=> 'Aktif',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> 'b46cf1a6-f27c-11ee-97fc-2a57142798db',
                'nama'=> 'Sistem Manajemen Lingkungan (Environmental Management System)',
                'jenis' => 'ISO 14001',
                'tgl_aktif' => '2023-04-02',
                'masa_berlaku'=> '1',
                'tgl_berakhir'=> '2024-04-02',
                'status'=> 'Aktif',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> 'b46cf5a8-f27c-11ee-97fc-2a57142798db',
                'nama'=> 'Sistem Manajemen Energi (Energy Management System)',
                'jenis' => 'ISO 50001',
                'tgl_aktif' => '2020-09-22',
                'masa_berlaku'=> '3',
                'tgl_berakhir'=> '2023-09-22',
                'status'=> 'Tidak Aktif',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],

        ];
        DB::table('iso')->insert($data);
    }
}
