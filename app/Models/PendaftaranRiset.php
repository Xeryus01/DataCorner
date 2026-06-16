<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendaftaranRiset extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'judul_riset',
        'no_hp',
        'cv_file',
        'surat_permohonan',
        'surat_motivasi',
        'is_agreed',
        'agreed_at',
        'status',
        'laporan_riset',
        'sertifikat_riset',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'is_agreed' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
