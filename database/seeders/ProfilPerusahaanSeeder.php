<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759459',
                'gambar'=>'',
                'jenis'=>'telepon',
                'deskripsi' => '+6287893504595',
                'jabatan' => '',
                'tingkatan' => 0,
                'kategori' => '',
                'created_at' => '2024-03-27 07:44:05',
            ],
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759419',
                'gambar'=>'',
                'jenis'=>'email',
                'deskripsi' => 'csrru2@gmail.com',
                'jabatan' => '',
                'tingkatan' => 0,
                'kategori' => '',
                'created_at' => '2024-03-27 07:44:05',
            ],
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759465',
                'gambar'=>'',
                'jenis'=>'visi',
                'deskripsi' => 'Sebagai Perusahaan Kilang Minyak dan Petrokimia Berkelas Dunia.',
                'jabatan' => '',
                'tingkatan' => 0,
                'kategori' => '',
                'created_at' => '2024-03-27 07:44:35',
            ],
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759463',
                'gambar'=>'',
                'jenis'=>'misi',
                'deskripsi' => 'Menjalankan bisnis Kilang Minyak dan Petrokimia secara Profesional dan berstandar Internasional dengan prinsip keekonomian yang kuat dan berwawasan lingkungan.',
                'jabatan' => '',
                'tingkatan' => 0,
                'kategori' => '',
                'created_at' => '2024-03-27 07:47:55',
            ],
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759493',
                'gambar'=>'kilang.jpg',
                'jenis'=>'sekilas',
                'deskripsi' => 'Berbagai',
                'jabatan' => '',
                'tingkatan' => 0,
                'kategori' => '',
                'created_at' => '2024-03-27 07:49:55',
            ],
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759502',
                'gambar'=>'sejarah.png',
                'jenis'=>'sejarah',
                'deskripsi' => '1969',
                'jabatan' => '',
                'tingkatan' => 0,
                'kategori' => '',
                'created_at' => '2024-03-27 07:49:55',
            ],
            [
                'id'=>'6becb763-d069-111e-8bb8-744ca1759632',
                'gambar'=>'didik-subagyo.jpeg',
                'jenis'=>'struktur',
                'deskripsi' => 'Didik Subagyo',
                'jabatan' => 'General Manager',
                'tingkatan' => 1,
                'kategori' => '',
                'created_at' => '2024-03-27 07:55:55',
            ],
            [
                'id'=>'6becd763-d069-11ee-8bb8-744ca1759632',
                'gambar'=>'agustiawan.JPG',
                'jenis'=>'struktur',
                'deskripsi' => 'Agustiawan',
                'jabatan' => 'Area Manager Comm, Rel & CSR',
                'tingkatan' => 2,
                'kategori' => '',
                'created_at' => '2024-03-27 07:55:55',
            ],
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759632',
                'gambar'=>'deni-saputra-ramadhan.JPG',
                'jenis'=>'struktur',
                'deskripsi' => 'Deni Saputra',
                'jabatan' => 'Sr Officer 1 Comm, Rel',
                'tingkatan' => 3,
                'kategori' => '',
                'created_at' => '2024-03-27 07:55:55',
            ],
            [
                'id'=>'6becb763-d069-11ee-8dd8-744ca1759632',
                'gambar'=>'gatra-wiraandika.jpeg',
                'jenis'=>'struktur',
                'deskripsi' => 'Gatra Wiraandika',
                'jabatan' => 'Jr Officer 1 CSR',
                'tingkatan' => 4,
                'kategori' => '',
                'created_at' => '2024-03-27 07:55:55',
            ],
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca175955',
                'gambar'=>'biosolar.png',
                'jenis'=>'produk',
                'deskripsi' => 'Biosolar',
                'jabatan' => '',
                'tingkatan' => 0,
                'kategori' => 'BBM',
                'created_at' => '2024-03-27 07:55:55',
            ],
        ];
        DB::table('profil_perusahaan')->insert($data);
    }
}
