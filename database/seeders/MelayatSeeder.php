<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MelayatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'b1cd3d2e-d4bc-11ee-b74a-7b1fd8b5069b',
                'status' => 'diajukan',
                'sij_id' => '92c1e1f2-d4bb-11ee-a2be-bbb3e4b54a68',
                'created_at' => now()
            ]
            ];
            DB::table('melayat')->insert($data);
    }
}
