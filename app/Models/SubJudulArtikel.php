<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class SubJudulArtikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_artikel',
        'sub_judul',
        'urutan',
    ];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel');
    }

    public function detail_sub_judul_artikel()
    {
        return $this->hasMany(DetailSubJudulArtikel::class, 'sub_judul_artikel_id');
    }
}
