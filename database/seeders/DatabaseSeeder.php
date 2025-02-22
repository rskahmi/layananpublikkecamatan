<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            WilayahSeeder::class,
            LembagaSeeder::class,
            BerkasSeeder::class,
            ProposalSeeder::class,
            RiwayatProposalSeeder::class,
            PumkSeeder::class,
            DokumentasiPumkSeeder::class,
            IsoSeeder::class,
            RilisSeeder::class,
            PembayaranSeeder::class,
            TjslSeeder::class,
            RiwayatAnggaranSeeder::class,
            DokumentasiTjslSeeder::class,
            ProgramUnggulanSeeder::class,
            PemberitaanSeeder::class,
            ProfilPerusahaanSeeder::class,
            NPPSeeder::class,
            UMDSeeder::class,
            RiwayatUMDSeeder::class,
            ReimSeeder::class,
            RiwayatReimSeeder::class,
            RDSeeder::class,
            BaruSeeder::class,
            RiwayatBaruSeeder::class,
            GantiSeeder::class,
            RiwayatGantiSeeder::class,
            KembalikanSeeder::class,
            RiwayatKembalikanSeeder::class,
            SPDSeeder::class,
            RiwayatSPDSeeder::class,
            SIJSeeder::class,
            MelayatSeeder::class,
            RiwayatMelayatSeeder::class,
            SakitSeeder::class,
            RiwayatSakitSeeder::class,
            DinasSeeder::class,
            RiwayatDinasSeeder::class,
            SPDLSeeder::class,
            RiwayatSPDLSeeder::class,
            RotasiSeeder::class,
            RiwayatRotasiSeeder::class,
            MutasiSeeder::class,
            RiwayatMutasiSeeder::class,
            PromosiSeeder::class,
            RiwayatPromosiSeeder::class,
            PenerbitanSeeder::class,
            RiwayatPenerbitanSeeder::class
        ]);
    }
}
