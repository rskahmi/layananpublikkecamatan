<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PemberitaanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id'=> '544fb911-ebf1-11ee-95e5-2a57142798db',
                'jenis'=> 'media online',
                'tautan'=>'https://web-pertamina.azurewebsites.net/en/news-room/csr-news/bantu-warga-terdampak-covid-19-pertamina-bagikan-bantuan-paket-sembako',
                'gambar'=> 'Baru-Terbesar-di-Indonesia.jpg',
                'respon'=> 'Positif',
                'rilis_id'=> '96d82f2b-d068-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'3d0b10e4-ecd0-11ee-95e5-2a57142798db',
                'jenis'=> 'media online',
                'tautan'=>'https://radarbali.jawapos.com/ekonomi/704164837/indonesia-international-motor-show-2024-pertamina-tampilkan-inovasi-energi-hijau-dan-gandeng-valentino-rossi',
                'gambar'=> 'Baru-Terbesar-di-Indonesia.jpg',
                'respon'=> 'Positif',
                'rilis_id'=>'aede56c0-ebdc-11ee-95e5-2a57142798db',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'3d0b1cb0-ecd0-11ee-95e5-2a57142798db',
                'jenis'=> 'media cetak',
                'tautan'=>'-',
                'gambar'=> 'Baru-Terbesar-di-Indonesia.jpg',
                'respon'=> 'Netral',
                'rilis_id'=>'3326cd39-ebf1-11ee-95e5-2a57142798db',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'3d0b2639-ecd0-11ee-95e5-2a57142798db',
                'jenis'=> 'media elektronik',
                'tautan'=>'-',
                'gambar'=> 'Baru-Terbesar-di-Indonesia.jpg',
                'respon'=> 'Positif',
                'rilis_id'=>'544fa6ce-ebf1-11ee-95e5-2a57142798db',
                'created_at' => '2024-03-27 07:43:05',
            ],
        ];
        DB::table('pemberitaan')->insert($data);
    }
}
