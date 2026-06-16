<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProgresBelajar\ArtikelDibaca;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'subjek_materi_id',
        'slug',
        'judul',
        'deskripsi',
        'gambar'
    ];

    public function subjek_materi()
    {
        return $this->belongsTo(SubjekMateri::class, 'subjek_materi_id');
    }

    public function subjudul_artikel()
    {
        return $this->hasMany(SubJudulArtikel::class, 'id_artikel');
    }

    public function artikel_dibaca()
    {
        return $this->hasMany(ArtikelDibaca::class, 'id_artikel');
    }
}
