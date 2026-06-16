<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananPerpustakaan extends Model
{

    protected $table = 'layanan_perpustakaan';   
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
