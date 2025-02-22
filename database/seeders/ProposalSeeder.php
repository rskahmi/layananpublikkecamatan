<?php

namespace Database\Seeders;

use App\Models\ProposalModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProposalSeeder extends Seeder
{
    public function run(): void
    {
        $data =  [
            [
                'id' => '76cdbe1c-d067-11ee-8bb8-744ca1759434',
                'anggaran' => 25000000,
                'status' => 'diajukan',
                'total_waktu' => 7,
                'jenis' => 'sponsorship',
                'lembaga_id' =>'ce8816f3-d066-11ee-8bb8-744ca1759434',
                'wilayah_id' => '07608176-d067-11ee-8bb8-744ca1759434',
                'berkas_id'=> '313cdb26-d067-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'aa88fd1d-ebd9-11ee-95e5-2a57142798db',
                'anggaran' => 20000000,
                'total_waktu' => 3,
                'status' => 'diajukan',
                'jenis' => 'terprogram',
                'lembaga_id' =>'ce8816f3-d066-11ee-8bb8-744ca1759434',
                'wilayah_id' => '07608176-d067-11ee-8bb8-744ca1759434',
                'berkas_id'=> '3bc87f80-ebd3-11ee-95e5-2a57142798db',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'aa8934c1-ebd9-11ee-95e5-2a57142798db',
                'anggaran' => 25000000,
                'total_waktu' => 10,
                'status' => 'diajukan',
                'jenis' => 'tidak terprogram',
                'lembaga_id' =>'ce8816f3-d066-11ee-8bb8-744ca1759434',
                'wilayah_id' => '07608176-d067-11ee-8bb8-744ca1759434',
                'berkas_id'=> '18785235-ebd6-11ee-95e5-2a57142798db',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'cbfb81f9-f2d9-11ee-97fc-2a57142798db',
                'anggaran' => 10000000,
                'total_waktu' => 5,
                'status' => 'diajukan',
                'jenis' => 'sponsorship',
                'lembaga_id' =>'ce8816f3-d066-11ee-8bb8-744ca1759434',
                'wilayah_id' => '07608176-d067-11ee-8bb8-744ca1759434',
                'berkas_id'=> '46c6cc82-ebd6-11ee-95e5-2a57142798db',
                'created_at' => '2024-04-04 07:43:05',
            ],

        ];

        DB::table('proposal')->insert($data);
    }
}
