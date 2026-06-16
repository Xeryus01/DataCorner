<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use App\Models\ProgresBelajar\InfografisDilihat;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Infografis extends Model
{
    use HasFactory;

    protected $fillable = [
        'subjek_materi_id',
        'judul',
        'deskripsi',
        'gambar',
        'file_infografis',
    ];

    public function subjek_materi()
    {
        return $this->belongsTo(SubjekMateri::class, 'subjek_materi_id');
    }

    public function infografis_dilihat()
    {
        return $this->hasMany(InfografisDilihat::class, 'id_infografis');
    }
}
