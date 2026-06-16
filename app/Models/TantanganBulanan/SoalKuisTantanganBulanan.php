<?php

namespace App\Models\TantanganBulanan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalKuisTantanganBulanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kuis_tantangan_bulanan',
        'gambar',
        'soal',
        'tipe_soal',
        'jawaban',
    ];

    public function kuis_tantangan_bulanan()
    {
        return $this->belongsTo(KuisTantanganBulanan::class, 'id_kuis_tantangan_bulanan');
    }

    public function opsi()
    {
        return $this->hasMany(OpsiSoalKuisTantanganBulanan::class, 'id_soal_tantangan');
    }

    public function jawaban_user()
    {
        return $this->hasMany(JawabanTantanganBulanan::class, 'id_soal_tantangan_bulanan');
    }
}
