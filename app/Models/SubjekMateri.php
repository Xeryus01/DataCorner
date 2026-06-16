<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubjekMateri extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'judul',
        'deskripsi',
        'gambar',
    ];

    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'subjek_materi_id');
    }

    public function video_pembelajaran()
    {
        return $this->hasMany(VideoPembelajaran::class, 'subjek_materi_id');
    }

    public function infografis()
    {
        return $this->hasMany(Infografis::class, 'subjek_materi_id');
    }
}
