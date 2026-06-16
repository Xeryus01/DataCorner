<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananRekomendasi extends Model
{
    protected $table = 'layanan_rekomendasi';
    protected $fillable = [
        'periode',
        'survei',
        'kompromin',
        'opd',
        'instansi',
        'jumlah',
    ];
}
