<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailSubJudulArtikel extends Model
{
    use HasFactory;

    protected $fillable = ([
        'sub_judul_artikel_id',
        'konten_text',
        'link_embed',
        'gambar',
        'urutan'
    ]);

    public function sub_judul_artikel()
    {
        return $this->belongsTo(SubJudulArtikel::class, 'sub_judul_artikel_id');
    }
}
