<?php

namespace Database\Seeders;

use App\Models\TjslModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TjslSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id'=> '3400b3c5-d08c-11ee-8bb8-744ca1759434',
                'nama'=> 'Program Penyuluhan Kesehatan Masyarakat',
                'jenis'=>'Terprogram',
                'anggaran'=> 50000000,
                'pic'=>'Sari',
                'contact' => '0822103523',
                'tanggal'=> '2024-02-10',
                'lembaga_id'=> 'ce8816f3-d066-11ee-8bb8-744ca1759434',
                'wilayah_id'=> '07608176-d067-11ee-8bb8-744ca1759434',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '5f123928-ebdb-11ee-95e5-2a57142798db',
                'nama'=> 'Program Pengembangan Ekonomi Lokal',
                'jenis'=>'Tidak Terprogram',
                'anggaran'=> 10000000,
                'pic'=>'Rini',
                'contact' => '0822103523',
                'tanggal'=> '2024-03-20',
                'lembaga_id'=> 'ce8816f3-d066-11ee-8bb8-744ca1759434',
                'wilayah_id'=> '3db97a5e-ebd7-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '5f124633-ebdb-11ee-95e5-2a57142798db',
                'nama'=> 'Program Tanggap Bencana',
                'jenis'=>'Terprogram',
                'anggaran'=> 15000000,
                'pic'=>'Eko',
                'contact' => '0822103523',
                'tanggal'=> '2023-11-15',
                'lembaga_id'=> 'ce8816f3-d066-11ee-8bb8-744ca1759434',
                'wilayah_id'=> 'eada0f12-ebd7-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '5f125135-ebdb-11ee-95e5-2a57142798db',
                'nama'=> 'Program Pemberdayaan Perempuan',
                'jenis'=>'Terprogram',
                'anggaran'=> 25000000,
                'pic'=>'Teguh',
                'contact' => '0822103523',
                'tanggal'=> '2024-01-10',
                'lembaga_id'=> 'ce8816f3-d066-11ee-8bb8-744ca1759434',
                'wilayah_id'=> '3db97a5e-ebd7-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=> '5f125c15-ebdb-11ee-95e5-2a57142798db',
                'nama'=> 'Program Pengembangan Teknologi Hijau',
                'jenis'=>'Sponsorship',
                'anggaran'=> 10000000,
                'pic'=>'Indra',
                'contact' => '0822103523',
                'tanggal'=> '2024-05-05',
                'lembaga_id'=> 'ce8816f3-d066-11ee-8bb8-744ca1759434',
                'wilayah_id'=> '07608176-d067-11ee-8bb8-744ca1759434',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
        ];
        DB::table('tjsl')->insert($data);
    }
}
