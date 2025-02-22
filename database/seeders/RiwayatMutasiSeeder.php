<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MutasiModel;

class RiwayatMutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '8f1c32be-f275-4466-91ad-cae89c2a55a0',
                'tindakan' => 1,
                'status' => 'proses',
                'peninjau' => 'mgr-adm' ,
                'alasan' => '-',
                'mutasi_id' => '12525520-cf66-47ce-94ea-600ad6680c6d',
                'user_id' => '8f2f4c57-ecd2-11ee-909b-2b68b9c84cfe',
                'created_at' => now()
            ]
            ];
            DB::table('riwayat_mutasi')->insert($data);
    }
}
