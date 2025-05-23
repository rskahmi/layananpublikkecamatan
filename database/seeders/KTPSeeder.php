<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KTPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '9aebda44-10f8-11f0-8445-924a24597683',
                'status' => 'diajukan',
                'surat_id' => '6cb55eb6-10f8-11f0-8445-924a2459768',
                'created_at' => now()
            ]
            ];
            DB::table('ktp')->insert($data);
    }
}
