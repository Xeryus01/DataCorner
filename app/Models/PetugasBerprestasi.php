<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetugasBerprestasi extends Model
{
    protected $table = 'petugas_berprestasi';

    protected $fillable = [
        'konsultan_id',
        'triwulan',
        'tahun',
        'nilai',
        'sertifikat',
    ];

    public function konsultan()
    {
        return $this->belongsTo(konsultan::class, 'konsultan_id');
    }
}
