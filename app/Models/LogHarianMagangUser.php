<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogHarianMagangUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pendaftaran_magang',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'uraian_kegiatan',
        'status_kehadiran',
        'catatan',
        'status_verifikasi',
        'bukti_izin',
    ];

    public function pendaftaran_magang()
    {
        return $this->belongsTo(PendaftaranMagang::class, 'id_pendaftaran_magang');
    }

    public function presensi()
    {
        return $this->hasOne(PresensiMagang::class, 'id_pendaftaran_magang', 'id_pendaftaran_magang')
            ->whereDate('tanggal', $this->tanggal);
    }

}
