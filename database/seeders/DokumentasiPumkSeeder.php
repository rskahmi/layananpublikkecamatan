<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\DokumentasiPumkModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DokumentasiPumkSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id'=>'f69b590c-d069-11ee-8bb8-744ca1759434',
                'nama_kegiatan'=>'Pemantauan Usaha Eco Laundry',
                'tanggal'=>'2024-03-25',
                'nama_file'=>'Dokumentasi Akhir',
                'pumk_id'=>'6becb763-d069-11ee-8bb8-744ca1759434',
                'user_id'=>'7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'1e96cbd5-f2da-11ee-97fc-2a57142798db',
                'nama_kegiatan'=>'Pemberian Dana Bantuan kepada Bina Usaha Kerajinan',
                'tanggal'=>'2023-12-25',
                'nama_file'=>'Dokumentasi Awal',
                'pumk_id'=>'f0a1e62a-ebdb-11ee-95e5-2a57142798db',
                'user_id'=>'7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'1e96d15f-f2da-11ee-97fc-2a57142798db',
                'nama_kegiatan'=>'Pemantauan Usaha Sejahtera Makanan Ringan',
                'tanggal'=>'2024-03-25',
                'nama_file'=>'Dokumentasi Akhir',
                'pumk_id'=>'f0a1f19e-ebdb-11ee-95e5-2a57142798db',
                'user_id'=>'7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'1e96d566-f2da-11ee-97fc-2a57142798db',
                'nama_kegiatan'=>'Pemantauan Usaha Jaya Abadi Karya Batik',
                'tanggal'=>'2024-01-20',
                'nama_file'=>'Dokumentasi Akhir',
                'pumk_id'=>'f0a1fb50-ebdb-11ee-95e5-2a57142798db',
                'user_id'=>'7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'1e96d986-f2da-11ee-97fc-2a57142798db',
                'nama_kegiatan'=>'Pemantauan Usaha Cahaya Gemilang Handicraft',
                'tanggal'=>'2023-10-25',
                'nama_file'=>'Dokumentasi Akhir',
                'pumk_id'=>'f0a20505-ebdb-11ee-95e5-2a57142798db',
                'user_id'=>'7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
        ];
        DB::table('dokumentasi_pumk')->insert($data);
    }
}
