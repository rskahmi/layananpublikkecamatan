<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'f6e9b734-d4bc-11ee-90d5-fbe70bb0a2ed',
                'status' => 'diajukan',
                'sij_id' => 'a62d3e9c-d4bb-11ee-b3a2-8f8e0fcb098b',
                'created_at' => now()
            ]
            ];
            DB::table('sakit')->insert($data);
            }
}
