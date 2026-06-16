<?php

namespace App\Models\TantanganBulanan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KuisTantanganBulanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_periode',
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_menit',
        'status',
        'slug',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode');
    }

    public function soal_tantangan_bulanan()
    {
        return $this->hasMany(SoalKuisTantanganBulanan::class, 'id_kuis_tantangan_bulanan');
    }

    public function hasil_tantangan_bulanan()
    {
        return $this->hasMany(HasilKuisTantanganBulanan::class, 'id_kuis_tantangan_bulanan');
    }
}
