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
                'nama_program'=> 'Olahan Lele Palas Jaya',
                'nama_kelompok'=> 'Olahan Lele Palas Jaya',
                'mitra_binaan'=> 'Olahan Lele Palas Jaya',
                'ketua_kelompok'=> 'Olahan Lele Palas Jaya',
                'contact'=>'082210004545',
                'pic'=>'Josep',
                'deskripsi'=> '<p>Pembekalan & Pendampingan untuk mengolah hasil panen POKDAKAN (kelompok pembudidaya ikan) Palas Jaya menjadi produk makanan populer seperti kerupuk, nugget & dawet</p>',
                'gambar'=> 'olahan-lele.jpg',
                'wilayah_id'=> '3db97a5e-ebd7-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '25c82d82-0840-11ef-aa80-d8bbc1b0aa03',
                'nama_program'=> 'Olahan Lele Palas Jaya',
                'nama_kelompok'=> 'Olahan Lele Palas Jaya',
                'mitra_binaan'=> 'Olahan Lele Palas Jaya',
                'ketua_kelompok'=> 'Olahan Lele Palas Jaya',
                'contact'=>'082210004545',
                'pic'=>'Josep',
                'deskripsi'=> '<p>Pembekalan & Pendampingan untuk mengolah hasil panen POKDAKAN (kelompok pembudidaya ikan) Palas Jaya menjadi produk makanan populer seperti kerupuk, nugget & dawet</p>',
                'gambar'=> 'olahan-lele.jpg',
                'wilayah_id'=> '3db97a5e-ebd7-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-28 07:43:05',
            ],
        ];
        DB::table('program_unggulan')->insert($data);
    }
}
