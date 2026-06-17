<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BidangKeahlian;

class Konsultan extends Model
{
    use HasFactory;
    protected $table = 'konsultans';

    protected $fillable = [
    "email",
    "nama",
    "image",
    "gambar",
    "posisi",
    "keahlian",
    "status",
    "status_updated_at",
    "alasan",
    "password",
    "no_hp",
    "created_at",
    "updated_at",
    "tanggal_mulai_tidak_tersedia",
    "tanggal_selesai_tidak_tersedia",
    ];
    public function jadwals()
{
    return $this->hasMany(jadwal::class);
}

    public function petugas(){
        return $this->hasMany(petugas::class, 'konsultan_id');
    }

    public function petugasBerprestasi()
    {
        return $this->hasMany(PetugasBerprestasi::class, 'konsultan_id');
    }

    public function bidangKeahlian()
    {
        return $this->belongsToMany(
            BidangKeahlian::class,
            'bidang_keahlian_konsultan',
            'konsultan_id',
            'bidang_keahlian_id'
        );
    }    

}
