<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananPojokStatistik extends Model
{
    protected $table = 'layanan_pojok_statistik';
    protected $fillable = [
        'periode',
        'pengunjung_unik',
        'kunjungan',
        'rata_harian',
        'layanan_tercetak',
        'digilib_online',
        'jumlah',
    ];
}
