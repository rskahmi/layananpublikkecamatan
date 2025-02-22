<?php

namespace Database\Seeders;

use App\Models\MediaModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RilisSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id'=> '96d82f2b-d068-11ee-8bb8-744ca1759434',
                'judul'=> 'Bantu Warga Terdampak Covid-19, Pertamina Bagikan Bantuan Paket Sembako',
                'deskripsi'=>'Warga Kelurahan Kasang dan Sijenjang tengah Ring I Pertamina Jambi mengaku bahagia mendapat bantuan sembako dari Pertamina. Salah seorang penerima manfaat menyampaikan rasa syukur dan terima kasihnya atas bantuan ini',
                'gambar'=> 'CSR-NEWS-BANTUAN-SEMBAKO-MOR-II.jpg',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> 'aede56c0-ebdc-11ee-95e5-2a57142798db',
                'judul'=> 'Memperingati Bulan K3 PT RU II Dumai',
                'deskripsi'=> 'Sebagai salah satu rangkaian acara peringatan Bulan K3, PT KPI Unit Dumai mengadakan Street Campaign aspek Kesehatan dan Keselamatan Kerja',
                'gambar'=> 'bulan-k3',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '3326cd39-ebf1-11ee-95e5-2a57142798db',
                'judul'=> 'Inovasi Jaga Lahan Gambut',
                'deskripsi'=>'Selamat Hari Lahan Basah Sedunia! Terus berkontribusi untuk pemberdayaan masyarakat, KPI melalui @csrpertaminaru2sungaipakning hadirkan inovasi Nozzle Gambut',
                'gambar'=> 'arboretum.',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '544fa6ce-ebf1-11ee-95e5-2a57142798db',
                'judul'=> 'Pertamina SMEXPO RU II',
                'deskripsi'=> 'Raih 2 Penghargaan PROPER dari KLHK RI merupakan bukti nyata PT Kilang Pertamina Internasional Unit Dumai dalam menjaga lingkungan dan salah satu bentuk penerapan SDGs dan ESG',
                'gambar'=> 'arboretum.jpeg',
                'created_at' => '2024-03-27 07:43:05',
            ],
            // [
            //     'id'=> '544fb01c-ebf1-11ee-95e5-2a57142798db',
            //     'judul'=> 'Peduli Korban Banjir',
            //     'deskripsi'=> 'Salah satu bentuk kepedulian PT KPI Unit Dumai terhadap masyarakat terdampak dari meluapnya Sungai Rokan yaitu dengan menyalurkan 270 paket sembako di Teluk Berembun Kabupaten Rokan Hilir',
            //     'jenis'=> 'Media Cetak',
            //     'gambar'=> 'spkmtp.webp',',
            //     'created_at' => '2024-03-27 07:43:05',
            // ],

        ];
        DB::table('rilis')->insert($data);
    }
}
