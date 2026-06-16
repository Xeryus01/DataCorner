<?php

namespace App\Models\KuisReguler;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanKuisReguler extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_hasil_kuis_reguler',
        'id_soal_kuis_reguler',
        'jawaban_user',
        'benar',
    ];

    protected $casts = [
        'benar' => 'boolean',
    ];

    public function soal()
    {
        return $this->belongsTo(SoalKuisReguler::class, 'id_soal_kuis_reguler');
    }

    public function hasil()
    {
        return $this->belongsTo(HasilKuisReguler::class, 'id_hasil_kuis_reguler');
    }
}
