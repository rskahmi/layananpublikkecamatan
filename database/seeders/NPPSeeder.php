<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\NPPModel;


class NPPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'jenis' => 'UMD',
                'tanggal' => now(),
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' =>now() ,
            ],
            [
                'id' => 'f5b82b94-d066-11ee-8bb8-744ca1759434',
                'jenis' => 'Reim',
                'tanggal' => now(),
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => now(),
            ],
            [
                'id' => '2fbc1b1e-d0c1-11ee-9bfa-4e4e1f8a1d25',
                'jenis' => 'UMD',
                'tanggal' => now(),
                'user_id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'created_at' => now(),
            ],
            [
                'id' => '3cbf1d3e-d0c1-11ee-9bfa-4e4e1f8a1d25',
                'jenis' => 'Reim',
                'tanggal' => now(),
                'user_id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'created_at' => now(),
            ],
        ];
        DB::table('npp')->insert($data);
    }
}
