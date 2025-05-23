<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramUnggulanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id'=> '3439636e-083f-11ef-aa80-d8bbc1b0aa03',
                'nama_kegiatan'=> 'Pelayanan Kesehatan Gratis',
                'nama_kelompok'=> 'Jalan Kp.Baru Sawang',
                'mitra'=> 'PT Timah Tbk',
                'contact'=>'082210004545',
                'pic'=>'Risky Ahmi',
                'deskripsi'=> 'Pelayanan Kesehatan Gratis merupakan kegiatan sosial yang diselenggarakan oleh Pemerintah Kecamatan Kundur Barat bekerja sama dengan tenaga medis dari Puskesmas setempat. Kegiatan ini bertujuan untuk meningkatkan kesadaran masyarakat akan pentingnya kesehatan dengan memberikan layanan pemeriksaan kesehatan umum, pengecekan tekanan darah, gula darah, serta konsultasi medis secara cuma-cuma. Pelayanan ini menyasar seluruh lapisan masyarakat, khususnya warga yang membutuhkan akses layanan kesehatan secara cepat dan mudah.',
                'gambar'=> 'foto.jpg',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '25c82d82-0840-11ef-aa80-d8bbc1b0aa03',
                'nama_kegiatan'=> 'Lomba Tari Melayu',
                'nama_kelompok'=> 'Jalan Kp.Baru Sawang',
                'mitra'=> '-',
                'contact'=>'082210004545',
                'pic'=>'Risky Ahmi',
                'deskripsi'=> 'Lomba Tari Melayu merupakan ajang seni budaya yang diselenggarakan oleh Kecamatan Kundur Barat dalam rangka melestarikan dan memperkenalkan kekayaan budaya Melayu kepada generasi muda. Kegiatan ini diikuti oleh perwakilan dari berbagai desa dengan menampilkan tarian tradisional yang mencerminkan nilai-nilai kearifan lokal, keindahan gerak, serta keharmonisan dalam kebudayaan Melayu. Selain sebagai bentuk hiburan, lomba ini juga menjadi sarana edukatif dan wadah ekspresi seni bagi masyarakat.',
                'gambar'=> 'foto.jpg',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-28 07:43:05',
            ],
        ];
        DB::table('program_unggulan')->insert($data);
    }
}
