<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class janjitemu extends Model
{
    protected $table = 'janjitemu';

    protected $fillable = [
        'users_id',        
        'keperluan',
        'instansi_lembaga',
        'keperluan_data',
        'data_diminta',
        'tanggal',
        'jam',
        'jenis',
        'jumlah_orang',
        'layanan_dibutuhkan',
        'status',
        'zoom_link',
        'alasan_batal',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function jadwal()
    {
        return $this->hasOne(jadwal::class);
    }

}
