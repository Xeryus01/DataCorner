<?php

namespace App\Models\TantanganBulanan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsiSoalKuisTantanganBulanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_soal_tantangan',
        'label',
        'teks_opsi'
    ];

    public function soal_tantangan_bulanan()
    {
        return $this->belongsTo(SoalKuisTantanganBulanan::class, 'id_soal_tantangan');
    }
}
