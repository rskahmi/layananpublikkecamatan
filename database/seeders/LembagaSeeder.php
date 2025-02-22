<?php

namespace Database\Seeders;

use App\Models\LembagaModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LembagaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 'ce8816f3-d066-11ee-8bb8-744ca1759434',
                'nama_lembaga' => 'Dinas Perhubungan Kota Dumai',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'b76e2d6e-ebd8-11ee-95e5-2a57142798db',
                'nama_lembaga' => 'Kelurahan Tanjung Palas',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'b76e37f6-ebd8-11ee-95e5-2a57142798db',
                'nama_lembaga' => 'Kelurahan Jayamukti',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'b76e40f4-ebd8-11ee-95e5-2a57142798db',
                'nama_lembaga' => 'Kelurahan Bumi Ayu',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'b76e496f-ebd8-11ee-95e5-2a57142798db',
                'nama_lembaga' => 'Kelurahan Bukit Datuk',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'b76e51c7-ebd8-11ee-95e5-2a57142798db',
                'nama_lembaga' => 'Kelurahan Mundam',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'b76e5a20-ebd8-11ee-95e5-2a57142798db',
                'nama_lembaga' => 'Teluk Makmur',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'b76e6268-ebd8-11ee-95e5-2a57142798db',
                'nama_lembaga' => 'Kelurahan Purnama',
                'created_at' => '2024-03-27 07:43:05',
            ],

        ];
        DB::table('lembaga')->insert($data);
    }
}
