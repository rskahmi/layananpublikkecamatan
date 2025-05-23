<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id'=> '96d82f2b-d068-11ee-8bb8-744ca1759430',
                'judul'=> 'Himbauan Camat Kundur Barat Sukseskan MTQ Se-Kabupaten Karimun di Kantor Camat Kundur Barat',
                'deskripsi'=>'Camat Kundur Barat mengimbau seluruh masyarakat untuk turut menyukseskan pelaksanaan Musabaqah Tilawatil Quran (MTQ) Se-Kabupaten Karimun yang diselenggarakan di Kantor Camat Kundur Barat. Partisipasi aktif dan dukungan dari seluruh elemen masyarakat diharapkan dapat menciptakan suasana yang khidmat, meriah, dan penuh semangat kebersamaan dalam menanamkan nilai-nilai Al-Quran',
                'foto'=> 'foto.jpg',
                'created_at' => '2024-03-27 07:43:05',
            ],

        ];
        DB::table('pengumuman')->insert($data);
    }
}
