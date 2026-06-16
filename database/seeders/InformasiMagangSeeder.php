<?php

namespace Database\Seeders;

use App\Models\InformasiMagang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InformasiMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (InformasiMagang::count() === 0) {
            InformasiMagang::create([
                'deskripsi' => 'Informasi magang ini memberikan gambaran program magang dan persyaratan yang dibutuhkan.',
                'persyaratan' => 'Calon peserta harus berstatus mahasiswa atau fresh graduate dan memiliki motivasi tinggi.',
                'benefit' => 'Peserta akan mendapatkan pengalaman kerja, sertifikat, dan referensi dari program.',
                'info_kontak' => 'Hubungi tim magang melalui email magang@example.com atau telepon 021-1234567.',
            ]);
        }
    }
}
