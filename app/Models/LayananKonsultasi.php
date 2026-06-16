<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananKonsultasi extends Model
{
    protected $table = 'layanan_konsultasi';
    protected $fillable = [
        'periode',
        'konsultasi_online',
        'kunjungan_langsung',
        'datapedia',
        'surat',
        'jumlah',
    ];
}
