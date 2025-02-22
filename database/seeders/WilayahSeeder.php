<?php

namespace Database\Seeders;

use App\Models\WilayahModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => '07608176-d067-11ee-8bb8-744ca1759434',
                'alamat' => 'Jl. Kusuma',
                'kelurahan' => 'Jayamukti',
                'kecamatan' => 'Dumai Timur',
                'kota' => 'Dumai',
                'latitude'=> '1.6631967',
                'longitude'=> '101.4470369',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => '3db97a5e-ebd7-11ee-95e5-2a57142798db',
                'alamat' => 'Jl. Makmur',
                'kelurahan' => 'Tj. Palas',
                'kecamatan' => 'Dumai Timur',
                'kota' => 'Dumai',
                'latitude'=> '1.656134773075115',
                'longitude'=> '101.46427172241557',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'eada0f12-ebd7-11ee-95e5-2a57142798db',
                'alamat' => 'Jl. Budi Utomo',
                'kelurahan' => 'Bumiayu',
                'kecamatan' => 'Dumai Selatan',
                'kota' => 'Dumai',
                'latitude'=> '1.6548349',
                'longitude'=> '101.4361787',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'eada2386-ebd7-11ee-95e5-2a57142798db',
                'alamat' => 'Jl. Prabumulih',
                'kelurahan' => 'Bukit Datuk',
                'kecamatan' => 'Dumai Selatan',
                'kota' => 'Dumai',
                'latitude'=> '1.65913',
                'longitude'=> '101.444028',
                'created_at' => '2024-03-27 07:43:05',
            ],
            [
                'id' => 'eada2ca8-ebd7-11ee-95e5-2a57142798db',
                'alamat' => 'Jl. Dermaga',
                'kelurahan' => 'Purnama',
                'kecamatan' => 'Dumai Barat',
                'kota' => 'Dumai',
                'latitude'=> '1.6528936',
                'longitude'=> '101.4399235',
                'created_at' => '2024-03-27 07:43:05',
            ],
        ];
        DB::table('wilayah')->insert($data);
    }
}
