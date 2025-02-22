<?php

namespace Database\Seeders;

use App\Models\PumkModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PumkSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id'=>'6becb763-d069-11ee-8bb8-744ca1759434',
                'nama_usaha'=>'Eco Laundry',
                'nama_pengusaha'=>'Lina',
                'contact' => '0822103523',
                'agunan'=>'Surat Izin Usaha',
                'anggaran'=> 15000000,
                'tanggal'=> '2024-02-01',
                'jatuh_tempo'=> '2025-02-01',
                'status'=> 'Lunas',
                'lembaga_id'=> 'b76e2d6e-ebd8-11ee-95e5-2a57142798db',
                'wilayah_id'=>'07608176-d067-11ee-8bb8-744ca1759434',
                'user_id'=>'7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'f0a1e62a-ebdb-11ee-95e5-2a57142798db',
                'nama_usaha'=> 'Bina Usaha Kerajinan',
                'nama_pengusaha'=> 'Tuti',
                'contact' => '0822103523',
                'agunan'=> 'Surat Izin Usaha',
                'anggaran'=> 10000000,
                'tanggal'=> '2023-12-10',
                'jatuh_tempo'=> '2024-12-10',
                'status'=> 'Lunas',
                'lembaga_id'=> 'b76e2d6e-ebd8-11ee-95e5-2a57142798db',
                'wilayah_id'=>'eada2ca8-ebd7-11ee-95e5-2a57142798db',
                'user_id'=>'7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'f0a1f19e-ebdb-11ee-95e5-2a57142798db',
                'nama_usaha'=>'Sejahtera Makanan Ringan',
                'nama_pengusaha'=>'Mirna',
                'contact' => '0822103523',
                'agunan'=>'Surat Izin Usaha',
                'anggaran'=> 20000000,
                'tanggal'=> '2024-01-21',
                'jatuh_tempo'=> '2024-10-21',
                'status'=> 'Tidak Lunas',
                'lembaga_id'=> 'b76e2d6e-ebd8-11ee-95e5-2a57142798db',
                'wilayah_id'=>'eada2386-ebd7-11ee-95e5-2a57142798db',
                'user_id'=>'7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'f0a1fb50-ebdb-11ee-95e5-2a57142798db',
                'nama_usaha'=>'Jaya Abadi Karya Batik',
                'nama_pengusaha'=>'Sukamto',
                'contact' => '0822103523',
                'agunan'=>'Surat Izin Usaha',
                'anggaran'=> 15000000,
                'tanggal'=> '2023-09-01',
                'jatuh_tempo'=> '2024-09-10',
                'status'=> 'Lunas',
                'lembaga_id'=> 'b76e2d6e-ebd8-11ee-95e5-2a57142798db',
                'wilayah_id'=>'eada2386-ebd7-11ee-95e5-2a57142798db',
                'user_id'=>'7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'f0a20505-ebdb-11ee-95e5-2a57142798db',
                'nama_usaha'=>'Cahaya Gemilang Handicraft',
                'nama_pengusaha'=>'Wiyanto',
                'contact' => '0822103523',
                'agunan'=>'Surat Izin Usaha',
                'anggaran'=> 10000000,
                'tanggal'=> '2024-04-01',
                'jatuh_tempo'=> '2025-04-01',
                'status'=> 'Lunas',
                'lembaga_id'=> 'b76e2d6e-ebd8-11ee-95e5-2a57142798db',
                'wilayah_id'=>'eada0f12-ebd7-11ee-95e5-2a57142798db',
                'user_id'=>'7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'f0a20e69-ebdb-11ee-95e5-2a57142798db',
                'nama_usaha'=>'Mekar Jaya Tani',
                'nama_pengusaha'=>'Rita',
                'contact' => '0822103523',
                'agunan'=>'Surat Izin Usaha',
                'anggaran'=> 25000000,
                'tanggal'=> '2024-03-25',
                'jatuh_tempo'=> '2025-03-25',
                'status'=> 'Lunas',
                'lembaga_id'=> 'b76e2d6e-ebd8-11ee-95e5-2a57142798db',
                'wilayah_id'=>'3db97a5e-ebd7-11ee-95e5-2a57142798db',
                'user_id'=>'7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],

        ];
        DB::table('pumk')->insert($data);
    }
}
