<?php

namespace App\Models\KuisReguler;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilKuisReguler extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_kuis_reguler',
        'skor',
        'jawaban_benar',
        'jawaban_salah',
        'durasi_pengerjaan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kuis_reguler()
    {
        return $this->belongsTo(KuisReguler::class, 'id_kuis_reguler');
    }

    public function jawaban_kuis_reguler()
    {
        return $this->hasMany(JawabanKuisReguler::class, 'id_hasil_kuis_reguler');
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

    public function getGradeAttribute()
    {
        if ($this->skor >= 80) return 'A';
        if ($this->skor >= 70) return 'B';
        if ($this->skor >= 60) return 'C';
        if ($this->skor >= 50) return 'D';
        return 'E';
    }
}
