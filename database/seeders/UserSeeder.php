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
                'nama' => 'user1',
                'email'=> 'user1@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'HSE',
                'nip' => '2155222',
                'role' =>'admin',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '9212c2a0-c177-11ef-91ae-8aef9f07e607',
                'nama' => 'user2',
                'email'=> 'user2@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'IT',
                'nip' => '2155222',
                'role' =>'admin',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '585f45a6-ecd1-11ee-95e5-2a57142798db',
                'nama' => 'staf2',
                'email'=> 'staf2@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'Administrasi',
                'nip' => '524242',
                'role' =>'admin-comrel',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '585f56ca-ecd1-11ee-95e5-2a57142798db',
                'nama' => 'staf3',
                'email'=> 'staf3@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'Administrasi',
                'nip' => '98652',
                'role' =>'admin-csr',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '45ca9b8a-c711-11ef-b06a-c278880034b1',
                'nama' => 'staf4',
                'email'=> 'staf4@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'Administrasi',
                'nip' => '98652',
                'role' =>'admin-staf4',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '45caa2ce-c711-11ef-b06a-c278880034b1',
                'nama' => 'staf5',
                'email'=> 'staf5@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'Administrasi',
                'nip' => '98652',
                'role' =>'admin-staf5',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'c3438cd4-c711-11ef-8a1f-c278880034b1',
                'nama' => 'staf6',
                'email'=> 'staf6@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'Administrasi',
                'nip' => '98652',
                'role' =>'admin-staf6',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'e1a3423b-b256-4e4d-89a1-1b2d6947f912',
                'nama' => 'sarana',
                'email'=> 'sarana@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'Sarana',
                'nip' => '98652',
                'role' =>'sarana',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '585f56ca-ecd1-11ee-95e5-2a57142791db',
                'nama' => 'staf1',
                'email'=> 'staf1@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'Administrasi',
                'nip' => '21553010',
                'role' =>'am',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '7b9a8d3e-ecd2-11ee-a953-3f3d26db2a12',
                'nama' => 'Manager Adm',
                'email'=> 'mgradm@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'Administrasi',
                'nip' => '21553010',
                'role' =>'mgr-adm',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '8f2f4c57-ecd2-11ee-909b-2b68b9c84cfe',
                'nama' => 'AVP Adm',
                'email'=> 'avpadm@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'Administrasi',
                'nip' => '21553010',
                'role' =>'avp-adm',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '67bfe7b9-ecd2-11ee-b9f8-bf347983eb26',
                'nama' => 'DHAK',
                'email'=> 'dhak@gmail.com',
                'password' => Hash::make('12345678'),
                'departemen' => 'DHAK Area Kundur',
                'nip' => '21553010',
                'role' =>'dhak',
                'status' => 'verify',
                'created_at' => '2024-03-27 07:43:05',
            ],
        ];
        User::insert($data);
    }
}
