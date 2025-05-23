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
                'deskripsi' => '+6285835401314',
                'created_at' => '2024-03-27 07:44:05',
            ],
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759419',
                'gambar'=>'',
                'jenis'=>'email',
                'deskripsi' => 'riskyahmi123@gmail.com',
                'created_at' => '2024-03-27 07:44:05',
            ],
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759465',
                'gambar'=>'',
                'jenis'=>'visi',
                'deskripsi' => 'Visi dari Kecamatan Kundur Barat yaitu “Terwujudnya Kecamatan
                                Kundur Barat yang Profesional dalam pelayanan, menuju masyarakat tangguh,
                                beriman dan berbudaya yang berbasis usaha keras dan kebersamaan”.',
                'created_at' => '2024-03-27 07:44:35',
            ],
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759463',
                'gambar'=>'',
                'jenis'=>'misi',
                'deskripsi' => 'Misi dari Kecamatan Kundur Barat yaitu :
                                1. Mewujudkan Pelayanan Prima kepada Masyarakat.
                                2. Mewujudkan Masyarakat Kundur Barat yang berkualitas, berdayaguna dan
                                berhasil guna.
                                3. Mewujudkan Masyarakat Kundur Barat yang beriman, taat beribadah sesuai
                                dengan agama yang di anut.
                                4. Mewujudkan masyarakat yang berbudaya yang ditutukberatkan pada
                                pelestarian budaya melayu.
                                5. Mewujudkan masyarakat yang mau bekerja keras dan menjunjung tinggi
                                nilai-nilai kebersamaan.
                                6. Mewujudkan Kundur Barat yang aman, indah, damai, sejuk dan sejahtera.
                                7. Mewujudkan masyarakat yang mentaati hukum dan perundang-undangan;
                                8. Melaksankan Pemeliharaan Prasarana dan Fasilitas pelayanan umum;
                                9. Mengoptimalkan penyelenggaraan kegiatan pemerintahan di tingkat
                                Kecamatan;
                                10. Mengoptimalkan pembinaan pelenggaraan pemerintah Desa ',
                'created_at' => '2024-03-27 07:47:55',
            ],
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759502',
                'gambar'=>'sejarah.png',
                'jenis'=>'sejarah',
                // 'deskripsi' => 'Kecamatan Kundur Barat merupakan salah satu Kecamatan dari 9
                //                 (sembilan) Kecamatan yang terbentuk di Kabupaten Karimun. Kecamatan
                //                 Kundur Barat sebelumnya merupakan bagian dari Wilayah Administratif
                //                 Kecamatan Kundur yang terdiri dari Desa/Kelurahan Tanjung Batu Barat,
                //                 Tanjung Batu Kota, Alai, Sungai Sebesi, Sungai Ungar, Sungai Ungar Utara,
                //                 Lebuh, Penarah, Sebele, Urung, Sawang, Sawang laut, Kundur, dan Teluk
                //                 Radang.
                //                 Kabupaten Karimun dibentuk berdasarkan Undang-Undang Nomor 53
                //                 Tahun 1999 yang ditetapkan di Jakarta pada tanggal 4 oktober 1999, yang
                //                 dahulunya hanya terdiri dari 3 (tiga) Kecamatan, yaitu Kecamatan Karimun,
                //                 Kecamatan Kundur, dan Kecamatan Moro selanjutnya dimekarkan menjadi 9
                //                 (sembilan) Kecamatan, salah satu diantaranya adalah Kecamatan Kundur
                //                 Barat.Wilayah Kecamatan Kundur Barat membawahi 4 (empat) Desa dan 1
                //                 (satu) Kelurahan, yaitu :
                //                 1. Kelurahan Sawang
                //                 2. Desa Sawang Laut
                //                 3. Desa Kundur
                //                 4. Desa Sawang Selatan
                //                 5. Desa Gemuruh
                //                 ',
                'deskripsi' => '',
                'created_at' => '2024-03-27 07:49:55',
            ],
            [
                'id'=>'6becb763-d069-11ee-5fb8-744ca1759502',
                'gambar'=>'alursurat.png',
                'jenis'=>'alursurat',
                'deskripsi' => '',
                'created_at' => '2024-03-27 07:49:55',
            ],
            [
                'id'=>'6becb763-d069-11ee-5fb8-744ca1759521',
                'gambar'=>'alurpengaduan.png',
                'jenis'=>'alurpengaduan',
                'deskripsi' => 'ini deskripsi pengaduan',
                'created_at' => '2024-03-27 07:49:55',
            ],
             [
                'id'=>'6becb763-d069-11ee-5fb8-744ca175950',
                'gambar'=>'alurakun.png',
                'jenis'=>'alurakun',
                'deskripsi' => '',
                'created_at' => '2024-03-27 07:49:55',
            ],
        ];
        DB::table('profil_perusahaan')->insert($data);
    }
}
