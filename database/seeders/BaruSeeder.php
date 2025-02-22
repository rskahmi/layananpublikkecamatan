<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '34409e38-c1a2-11ef-9206-d64449b24588',
                'status' => 'diajukan',
                'rd_id' => '34408f74-c1a2-11ef-9206-d64449b24588',
                'created_at' => now()
            ],
        ];
        DB::table('baru')->insert($data);
    }
}
