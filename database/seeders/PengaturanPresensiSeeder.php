<?php

namespace Database\Seeders;

use App\Models\PengaturanPresensi;
use App\Models\WilayahBps;
use Illuminate\Database\Seeder;

class PengaturanPresensiSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (PengaturanPresensi::count() > 0) {
            return;
        }

        $wilayah = WilayahBps::first();

        if (! $wilayah) {
            $wilayah = WilayahBps::create([
                'nama_wilayah' => 'Wilayah Default',
                'kode_wilayah' => 'DEFAULT',
                'tingkat_wilayah' => 'Nasional',
            ]);
        }

        PengaturanPresensi::create([
            'wilayah_bps_id' => $wilayah->id,
            'lat_kantor' => null,
            'long_kantor' => null,
            'radius_kantor' => 100,
            'jam_masuk_mulai' => '08:00:00',
            'jam_masuk_selesai' => '09:00:00',
            'jam_pulang_mulai' => '17:00:00',
            'toleransi_telat' => 0,
            'is_active' => false,
        ]);
    }
}
