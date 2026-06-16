<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\akunuser;

class konsultasiKlik extends Model
{
    protected $table = 'konsultasi_klik';

    protected $fillable = [
        'users_id',
        'clicked_at',
        'data_diminta',
        'posisi',
        'instansi',
        'jenis_kelamin',
        'keperluan_data',
        'memiliki_akun',
    ];

    public function user()
    {
        return $this->belongsTo(akunuser::class, 'users_id');
    }
}

