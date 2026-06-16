<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            InformasiMagangSeeder::class,
            InformasiRisetSeeder::class,
            PengaturanPresensiSeeder::class,
        ]);
    }
}
