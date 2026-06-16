<?php

namespace App\Models\TantanganBulanan;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilKuisTantanganBulanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_kuis_tantangan_bulanan',
        'skor',
        'jawaban_benar',
        'jawaban_salah',
        'durasi_pengerjaan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kuis_tantangan_bulanan()
    {
        return $this->belongsTo(KuisTantanganBulanan::class, 'id_kuis_tantangan_bulanan');
    }

    public function jawaban_user()
    {
        return $this->hasMany(JawabanTantanganBulanan::class, 'id_hasil_tantangan_bulanan');
    }

    // Accessor untuk format durasi yang mudah dibaca
    public function getDurasiFormatAttribute()
    {
        if (!$this->durasi_pengerjaan) return '0 menit';

        $menit = floor($this->durasi_pengerjaan / 60);
        $detik = $this->durasi_pengerjaan % 60;

        if ($menit > 0) {
            return $detik > 0 ? "{$menit} menit {$detik} detik" : "{$menit} menit";
        }

        return "{$detik} detik";
    }
}
