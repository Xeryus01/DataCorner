<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahBps extends Model
{
    use HasFactory;

    protected $table = 'wilayah_bps';

    protected $fillable = [
        'nama_wilayah',
        'kode_wilayah',
        'tingkat_wilayah'        
    ];
    
    public function pengaturanPresensi()
    {
        return $this->hasMany(PengaturanPresensi::class, 'wilayah_bps_id');
    }

    public function pendaftaranMagangs()
    {
        return $this->hasMany(PendaftaranMagang::class, 'wilayah_bps_id');
    } 
}
