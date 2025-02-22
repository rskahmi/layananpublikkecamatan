<?php

namespace Database\Seeders;

use App\Models\BerkasModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BerkasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => '313cdb26-d067-11ee-8bb8-744ca1759434',
                'nomor_berkas' => '08.006/CSR/IV/2024',
                'nama_berkas' => 'Proposal pengadaan lapangan sepak bola di kelurahan Jayamukti',
                'jenis' => 'Proposal',
                'tanggal' => '2024-02-15',
                'nama_pengirim' => 'Joko',
                'contact' => '082210158998',
                'file_berkas' => 'proposal.pdf',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-02-18 07:50:53',
            ],
            [
                'id' => '3bc87f80-ebd3-11ee-95e5-2a57142798db',
                'nomor_berkas' => '009/CSR/IV/2024',
                'nama_berkas' => 'Proposal permohonan pengadaan mobil siaga warga',
                'jenis' => 'Proposal',
                'tanggal' => '2024-03-15',
                'nama_pengirim' => 'Bambang',
                'contact' => '082210158998',
                'file_berkas' => 'proposal.pdf',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],

            [
                'id' => '313cdb26-d067-11ee-8bb8-744ca1759436',
                'nomor_berkas' => '08.00611/CSR/IV/2024',
                'nama_berkas' => 'Surat Permohonan Kolaborasi dan Dukungan untuk Program Pengembangan Teknologi Ramah Lingkungan',
                'jenis' => 'Surat',
                'tanggal' => '2024-01-12',
                'nama_pengirim' => 'Rafli',
                'contact' => '082210158998',
                'file_berkas' => 'surat.pdf',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '73fab323-ebd5-11ee-95e5-2a57142798db',
                'nomor_berkas' => '08.00612/CSR/IV/2024',
                'nama_berkas' => 'Surat Pengembangan Program Pelatihan Kewirausahaan Bagi Pemuda Berbasis Teknologi',
                'jenis' => 'Surat',
                'tanggal' => '2024-02-28',
                'nama_pengirim' => 'Citra',
                'contact' => '082210158998',
                'file_berkas' => 'surat.pdf',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '97648f92-ebd5-11ee-95e5-2a57142798db',
                'nomor_berkas' => '08.00613/CSR/IV/2024',
                'nama_berkas' => 'Surat Permohonan Bantuan Dana untuk Program Peningkatan Kualitas Pendidikan Anak Usia Dini',
                'jenis' => 'Surat',
                'tanggal' => '2024-04-10',
                'nama_pengirim' => 'Yuni',
                'contact' => '082210158998',
                'file_berkas' => 'surat.pdf',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'ae4a957f-ebd5-11ee-95e5-2a57142798db',
                'nomor_berkas' => '08.00614/CSR/IV/2024',
                'nama_berkas' => 'Surat Permohonan Bantuan Dana untuk Program Pemberdayaan Perempuan di Bidang Kewirausahaan',
                'jenis' => 'Surat',
                'tanggal' => '2023-12-10',
                'nama_pengirim' => 'Maya',
                'contact' => '082210158998',
                'file_berkas' => 'surat.pdf',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'cd409601-ebd5-11ee-95e5-2a57142798db',
                'nomor_berkas' => '08.00615/CSR/IV/2024',
                'nama_berkas' => 'Surat Pengadaan Peralatan Teknologi untuk Pusat Pembelajaran Digital di Sekolah-sekolah Pedesaan',
                'jenis' => 'Surat',
                'tanggal' => '2023-12-20',
                'nama_pengirim' => 'Dewi',
                'contact' => '082210158998',
                'file_berkas' => 'surat.pdf',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '18785235-ebd6-11ee-95e5-2a57142798db',
                'nomor_berkas' => '08.00616/CSR/IV/2024',
                'nama_berkas' => 'Proposal Permohonan dana pemberdayaan Petani Lokal Melalui Pelatihan Pertanian Berkelanjutan',
                'jenis' => 'Proposal',
                'tanggal' => '2024-04-10',
                'nama_pengirim' => 'Ahmad',
                'contact' => '082210158998',
                'file_berkas' => 'proposal.pdf',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '2d50d410-ebd6-11ee-95e5-2a57142798db',
                'nomor_berkas' => '08.00617/CSR/IV/2024',
                'nama_berkas' => 'Surat Permohonan bantuan dana untuk Pengembangan Infrastruktur Transportasi Ramah Lingkungan',
                'jenis' => 'Surat',
                'tanggal' => '2024-03-18',
                'nama_pengirim' => 'Cahya',
                'contact' => '082210158998',
                'file_berkas' => 'surat.pdf',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '46c6cc82-ebd6-11ee-95e5-2a57142798db',
                'nomor_berkas' => '08.00618/CSR/IV/2024',
                'nama_berkas' => 'Proposal Pemberdayaan UMKM Melalui Pelatihan Manajemen Usaha dan Pemasaran',
                'jenis' => 'Proposal',
                'tanggal' => '2024-04-05',
                'nama_pengirim' => 'Wahyu',
                'contact' => '082210158998',
                'file_berkas' => 'proposal.pdf',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
        ];
        DB::table('berkas')->insert($data);
    }
}
