<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananProdukStatistik extends Model
{
    protected $table = 'layanan_produk_statistik';
    protected $fillable = [

        'periode',
        'pemohon_nol_rupiah',
        'penjualan_data_mikro',
        'penjualan_peta',
        'publikasi_elektronik',
        'jumlah',
    ];
}
