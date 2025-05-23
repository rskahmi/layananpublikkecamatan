<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BBMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'a18d2e6e-d066-11ee-8bb8-744ca1759434',
                'status' => 'diajukan',
                'surat_id' => '2fbc1b1e-d0c1-11ee-9bfa-4e4e1f8a1d2',
                'created_at' => now()
            ]
            ];
            DB::table('bbm')->insert($data);
    }
}
