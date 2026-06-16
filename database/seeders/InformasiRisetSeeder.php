<?php

namespace Database\Seeders;

use App\Models\InformasiRiset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformasiRisetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (InformasiRiset::count() === 0) {
            InformasiRiset::create([
                'deskripsi' => 'Informasi riset ini menjelaskan peluang kolaborasi riset dengan institusi kami.',
                'persyaratan' => 'Tim riset harus memiliki proposal yang jelas dan relevan dengan bidang statistik atau data.',
                'benefit' => 'Kolaborasi riset akan memberikan akses data, bimbingan, dan publikasi bersama.',
                'info_kontak' => 'Hubungi tim riset melalui email riset@example.com atau telepon 021-7654321.',
            ]);
        }
    }
}
