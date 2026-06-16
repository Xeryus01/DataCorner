<?php

namespace App\Models\KuisReguler;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsiSoalKuisReguler extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_soal_kuis_reguler',
        'label',
        'teks_opsi',
    ];

    public function soal_kuis_reguler()
    {
        return $this->belongsTo(SoalKuisReguler::class, 'id_soal_kuis_reguler');
    }
}
