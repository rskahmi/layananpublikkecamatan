<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RilisSeeder::class,
            ProgramUnggulanSeeder::class,
            ProfilPerusahaanSeeder::class,
            SuratSeeder::class,
            BBMSeeder::class,
            RiwayatBBMSeeder::class,
            KTPSeeder::class,
            RiwayatKTPSeeder::class,
            PengaduanSeeder::class,
            RiwayatPengaduanSeeder::class,
            KKSeeder::class,
            RiwayatKKSeeder::class,
            SKTMSeeder::class,
            RiwayatSKTMSeeder::class,
            BeritaSeeder::class,
            PengumumanSeeder::class,
        ]);
    }
}
