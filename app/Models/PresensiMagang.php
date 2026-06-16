<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiMagang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pendaftaran_magang',
        'tanggal',
        'jam_masuk',
        'lat_masuk',
        'long_masuk',
        'jam_pulang',
        'lat_pulang',
        'long_pulang',
        'status_masuk',
        'status_pulang',
        'keterangan_masuk',
        'keterangan_pulang',
    ];

    public function pendaftaran_magang()
    {
        return $this->belongsTo(PendaftaranMagang::class, 'id_pendaftaran_magang');
    }


    public function getStatusMasukLabelAttribute()
    {
        $map = [
            'tepat_waktu' => 'Hadir (Tepat Waktu)',
            'terlambat' => 'Hadir (Terlambat)',
            'luar_area' => 'Hadir (Di Luar Area)',
            'terlambat_luar_area' => 'Hadir (Terlambat & Di Luar Area)',
        ];

        return $map[$this->status_masuk] ?? '-';
    }

    public function getStatusPulangLabelAttribute()
    {
        $map = [
            'tepat_waktu' => 'Pulang Tepat Waktu',
            'pulang_cepat' => 'Pulang Cepat',
            'luar_area' => 'Pulang di Luar Area',
            'pulang_cepat_luar_area' => 'Pulang Cepat & Di Luar Area',
        ];

        return $map[$this->status_pulang] ?? '-';
    }


}
