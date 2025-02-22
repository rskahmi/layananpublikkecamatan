<?php

namespace Database\Seeders;

use App\Models\PembayaranModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id'=>'383bf257-d06a-11ee-8bb8-744ca1759434',
                'jumlah_pembayaran'=> 300000,
                'tanggal'=> '2024-01-18',
                'sisa_pembayaran'=> 5000000,
                'pumk_id'=> '6becb763-d069-11ee-8bb8-744ca1759434',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'e3177351-ecd2-11ee-95e5-2a57142798db',
                'jumlah_pembayaran'=> 1000000,
                'tanggal'=> '2024-01-18',
                'sisa_pembayaran'=> 6000000,
                'pumk_id'=> '6becb763-d069-11ee-8bb8-744ca1759434',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'e3177e50-ecd2-11ee-95e5-2a57142798db',
                'jumlah_pembayaran'=> 800000,
                'tanggal'=> '2024-01-18',
                'sisa_pembayaran'=> 3200000,
                'pumk_id'=> 'f0a1e62a-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'e31787a4-ecd2-11ee-95e5-2a57142798db',
                'jumlah_pembayaran'=> 350000,
                'tanggal'=> '2024-01-18',
                'sisa_pembayaran'=> 4500000,
                'pumk_id'=> 'f0a1f19e-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'e317914f-ecd2-11ee-95e5-2a57142798db',
                'jumlah_pembayaran'=> 4000000,
                'tanggal'=> '2024-01-18',
                'sisa_pembayaran'=> 11000000,
                'pumk_id'=> 'f0a1fb50-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'e3179b1c-ecd2-11ee-95e5-2a57142798db',
                'jumlah_pembayaran'=> 5000000,
                'tanggal'=> '2024-01-18',
                'sisa_pembayaran'=> 1500000,
                'pumk_id'=> 'f0a20e69-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'e317a507-ecd2-11ee-95e5-2a57142798db',
                'jumlah_pembayaran'=> 600000,
                'tanggal'=> '2024-01-18',
                'sisa_pembayaran'=> 12000000,
                'pumk_id'=> 'f0a20e69-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id'=>'e317adfe-ecd2-11ee-95e5-2a57142798db',
                'jumlah_pembayaran'=> 75000000,
                'tanggal'=> '2024-01-18',
                'sisa_pembayaran'=> 14000000,
                'pumk_id'=> 'f0a20505-ebdb-11ee-95e5-2a57142798db',
                'user_id'=> '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
        ];
        DB::table('pembayaran')->insert($data);
    }
}
