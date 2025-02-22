<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'c0f9bc6e-d4bc-11ee-bf39-2f8ac38bbd08',
                'status' => 'diajukan',
                'sij_id' => 'bb839810-d4bb-11ee-9037-abc5f65ad6b1',
                'created_at' => now()
            ]
            ];
        DB::table('dinas')->insert($data);
    }
}
