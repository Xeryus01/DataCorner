<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WilayahBps;

class PengaturanPresensi extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_presensi';

    protected $fillable = [
        'wilayah_bps_id',
        'lat_kantor',
        'long_kantor',
        'radius_kantor',
        'jam_masuk_mulai',
        'jam_masuk_selesai',
        'jam_pulang_mulai',
        'toleransi_telat',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function wilayahBps()
    {
        return $this->belongsTo(WilayahBps::class, 'wilayah_bps_id');
    }
}
