<?php

namespace App\Models\TantanganBulanan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTantanganBulanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_hasil_tantangan_bulanan',
        'id_soal_tantangan_bulanan',
        'jawaban_user',
        'benar',
    ];

    protected $casts = [
        'benar' => 'boolean',
    ];

    public function soal()
    {
        return $this->belongsTo(SoalKuisTantanganBulanan::class, 'id_soal_tantangan_bulanan');
    }

    public function hasil()
    {
        return $this->belongsTo(HasilKuisTantanganBulanan::class, 'id_hasil_tantangan_bulanan');
    }
}
