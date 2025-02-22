<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\DokumentasiTjslModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DokumentasiTjslSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id'=> '1d6d297d-d06a-11ee-8bb8-744ca1759434',
                'nama_kegiatan'=> 'Kegiatan Penyuluhan Kesehatan Masyarakat',
                'tanggal'=> '2024-02-15',
                'nama_file'=>'1715841464-66059.jpg',
                'tjsl_id'=> '3400b3c5-d08c-11ee-8bb8-744ca1759434',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '1e96dd35-f2da-11ee-97fc-2a57142798db',
                'nama_kegiatan'=> 'Kegiatan Seminar Pengembangan Ekonomi Lokal',
                'tanggal'=> '2024-03-10',
                'nama_file'=>'1715841464-66059.jpg',
                'tjsl_id'=> '5f123928-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '1e96e0d0-f2da-11ee-97fc-2a57142798db',
                'nama_kegiatan'=> 'Kegiatan Sosialisasi Tanggap Bencana',
                'tanggal'=> '2023-10-10',
                'nama_file'=>'1715841464-66059.jpg',
                'tjsl_id'=> '5f124633-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '7bccd339-f2da-11ee-97fc-2a57142798db',
                'nama_kegiatan'=> 'Kegiatan Sosialisai Pemberdayaan Perempuan',
                'tanggal'=> '2023-12-24',
                'nama_file'=>'1715841464-66059.jpg',
                'tjsl_id'=> '5f125135-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '7bccd877-f2da-11ee-97fc-2a57142798db',
                'nama_kegiatan'=> 'Kegiatan Pelatihan Pengembangan Teknologi Hijau',
                'tanggal'=> '2023-11-14',
                'nama_file'=>'1715841464-66059.jpg',
                'tjsl_id'=> '5f125c15-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
        ];
        DB::table('dokumentasi_tjsl')->insert($data);
    }
}
