<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KembalikanSeeder extends Seeder
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
                'rd_id' => '34409b4a-c1a2-11ef-9206-d64449b24588',
                'created_at' => now()
            ],
        ];
        DB::table('kembalikan')->insert($data);
    }
}
