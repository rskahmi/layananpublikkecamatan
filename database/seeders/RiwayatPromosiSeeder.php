<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatPromosiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '19d1f00b-1d39-40dd-b431-ff79e4ab8113',
                'tindakan' => 1,
                'status' => 'proses',
                'peninjau' => 'mgr-adm',
                'alasan' => '-',
                'promosi_id' => '0db220b2-2fa2-4cbb-8f6b-fab967db5957',
                'user_id' => '8f2f4c57-ecd2-11ee-909b-2b68b9c84cfe',
                'created_at' => now()
            ]
            ];
            DB::table('riwayat_promosi')->insert($data);
    }
}
