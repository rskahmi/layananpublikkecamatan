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
                'judul'=> 'Himbauan Camat Kundur Barat Sukseskan MTQ Se-Kabupaten Karimun di Kantor Camat Kundur Barat',
                'deskripsi'=>'Camat Kundur Barat mengimbau seluruh masyarakat untuk turut menyukseskan pelaksanaan Musabaqah Tilawatil Quran (MTQ) Se-Kabupaten Karimun yang diselenggarakan di Kantor Camat Kundur Barat. Partisipasi aktif dan dukungan dari seluruh elemen masyarakat diharapkan dapat menciptakan suasana yang khidmat, meriah, dan penuh semangat kebersamaan dalam menanamkan nilai-nilai Al-Quran',
                'gambar'=> 'foto.jpg',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> 'aede56c0-ebdc-11ee-95e5-2a57142798db',
                'judul'=> 'Penutupan Sementara Pelayanan Administrasi Kecamatan',
                'deskripsi'=> 'Diberitahukan kepada seluruh masyarakat bahwa pelayanan administrasi di Kantor Camat Kundur Barat akan ditutup sementara pada tanggal 2 hingga 3 April 2024 dalam rangka perbaikan sistem jaringan. Pelayanan akan kembali normal pada tanggal 4 April 2024. Mohon maaf atas ketidaknyamanan yang ditimbulkan.',
                'gambar'=> 'foto.jpg',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '3326cd39-ebf1-11ee-95e5-2a57142798db',
                'judul'=> 'Gotong Royong Massal Menyambut Hari Jadi Kecamatan',
                'deskripsi'=>'Dalam rangka menyambut Hari Jadi Kecamatan Kundur Barat, dihimbau kepada seluruh warga untuk ikut serta dalam kegiatan gotong royong massal yang akan dilaksanakan pada hari Sabtu, 6 April 2024, pukul 07.30 WIB. Kegiatan ini mencakup pembersihan lingkungan kantor dan fasilitas umum.',
                'gambar'=> 'foto.jpg',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '544fa6ce-ebf1-11ee-95e5-2a57142798db',
                'judul'=> 'Jadwal Pelayanan Mobil Keliling Kependudukan',
                'deskripsi'=> 'Kecamatan Kundur Barat menginformasikan kepada masyarakat bahwa pelayanan mobil keliling untuk perekaman dan pencetakan KTP-El akan dilaksanakan pada tanggal 10 April 2024 di Lapangan Bola Sawang. Diharapkan warga yang belum memiliki KTP-El dapat memanfaatkan kesempatan ini.',
                'gambar'=> 'foto.jpeg',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '544fa6ce-ebf1-11ee-95e5-2a57142798gh',
                'judul'=> 'Lomba Pembuatan Video Profil Desa Tingkat Kecamatan',
                'deskripsi'=> 'Diberitahukan bahwa akan diadakan lomba pembuatan video profil desa tingkat Kecamatan Kundur Barat yang terbuka untuk seluruh desa. Pendaftaran dibuka hingga 15 April 2024. Karya terbaik akan mewakili kecamatan ke tingkat kabupaten. Info selengkapnya dapat dilihat di papan pengumuman kantor camat.',
                'gambar'=> 'foto.jpeg',
                'created_at' => '2024-03-27 07:43:05',
            ],
        ];
        DB::table('rilis')->insert($data);
    }
}
