<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'nama' => 'Masyarakat 1',
                'email'=> 'masyarakat1@gmail.com',
                'password' => Hash::make('12345678'),
                'password_confirmation' => Hash::make('12345678'),
                'nip' => '2155222',
                'role' =>'masyarakat',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'nama' => 'Masyarakat 2',
                'email'=> 'masyarakat2@gmail.com',
                'password' => Hash::make('12345678'),
                'password_confirmation' => Hash::make('12345678'),
                'nip' => '2155222',
                'role' =>'masyarakat',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '585f56ca-ecd1-11ee-95e5-2a57142791db',
                'nama' => 'Petugas Administrasi',
                'email'=> 'petugasadministrasi@gmail.com',
                'password' => Hash::make('12345678'),
                'password_confirmation' => Hash::make('12345678'),
                'nip' => '21553010',
                'role' =>'petugasadministrasi',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '7b9a8d3e-ecd2-11ee-a953-3f3d26db2a12',
                'nama' => 'Kepala Seksi',
                'email'=> 'kepalaseksi@gmail.com',
                'password' => Hash::make('12345678'),
                'password_confirmation' => Hash::make('12345678'),
                'nip' => '21553010',
                'role' =>'kepalaseksi',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '8f2f4c57-ecd2-11ee-909b-2b68b9c84cfe',
                'nama' => 'Sekretaris Camat',
                'email'=> 'sekretariscamat@gmail.com',
                'password' => Hash::make('12345678'),
                'password_confirmation' => Hash::make('12345678'),
                'nip' => '21553010',
                'role' =>'sekretariscamat',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '67bfe7b9-ecd2-11ee-b9f8-bf347983eb26',
                'nama' => 'Camat',
                'email'=> 'camat@gmail.com',
                'password' => Hash::make('12345678'),
                'password_confirmation' => Hash::make('12345678'),
                'nip' => '21553010',
                'role' =>'camat',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
        ];
        User::insert($data);
    }
}
