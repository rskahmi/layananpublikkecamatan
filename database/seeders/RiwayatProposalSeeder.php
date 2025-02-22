<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RiwayatProposalSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => '007c8ab2-ecce-11ee-95e5-2a57042798db',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'am',
                'alasan'=> 'Akan segera diproses',
                'surat_balasan' => '',
                'proposal_id' => '76cdbe1c-d067-11ee-8bb8-744ca1759434',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-20 07:43:05',
            ],
            [
                'id' => '007c8ab2-ecce-11ee-95e5-2a57142798db',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'am',
                'alasan'=> 'Akan segera diproses',
                'surat_balasan' => '',
                'proposal_id' => 'aa88fd1d-ebd9-11ee-95e5-2a57142798db',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-03-20 07:43:05',
            ],
            [
                'id' => '7e70312b-05c4-11ef-999f-2a57142718db',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'am',
                'alasan'=> 'Akan segera di tindak lanjut',
                'surat_balasan' => '',
                'proposal_id' => 'aa8934c1-ebd9-11ee-95e5-2a57142798db',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-04-10 07:15:34',
            ],
            [
                'id' => '7e70312b-05c4-11ef-999f-2a57142798db',
                'tindakan' => 1,
                'status' => 'diajukan',
                'peninjau' => 'am',
                'alasan'=> 'Akan segera di tindak lanjut',
                'surat_balasan' => '',
                'proposal_id' => 'cbfb81f9-f2d9-11ee-97fc-2a57142798db',
                'user_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'created_at' => '2024-04-10 07:15:34',
            ],

        ];
        DB::table('riwayat_proposal')->insert($data);

    }
}
