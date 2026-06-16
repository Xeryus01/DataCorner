<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProgresBelajar\VideoDilihat;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoPembelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'subjek_materi_id',
        'judul',
        'slug',
        'deskripsi',
        'link',
    ];


    // Function untuk mengubah link menjadi link embed
    public function getEmbedLinkAttribute()
    {
        $link = $this->link;

        // Cek jika link sudah embed
        if (strpos($link, 'youtube.com/embed/') !== false) {
            return $link;
        }

        // Cek jika link model watch?v=
        if (strpos($link, 'watch?v=') !== false) {
            $videoId = explode('watch?v=', $link)[1];
            // Buang parameter tambahan seperti &t= atau ?si=
            $videoId = explode('&', $videoId)[0];
            return "https://www.youtube.com/embed/{$videoId}";
        }

        // Cek jika link model youtu.be
        if (strpos($link, 'youtu.be/') !== false) {
            $videoId = explode('youtu.be/', $link)[1];
            $videoId = explode('?', $videoId)[0];
            return "https://www.youtube.com/embed/{$videoId}";
        }

        // Fallback jika tidak cocok
        return null;
    }

    // Function untuk mengambil thumbnail
    public function getThumbnailAttribute()
    {
        $link = $this->link;
        $videoId = null;

        // Cek link embed
        if (strpos($link, 'youtube.com/embed/') !== false) {
            $videoId = explode('youtube.com/embed/', $link)[1];
        }
        // Cek link watch?v=
        elseif (strpos($link, 'watch?v=') !== false) {
            $videoId = explode('watch?v=', $link)[1];
            $videoId = explode('&', $videoId)[0];
        }
        // Cek link youtu.be
        elseif (strpos($link, 'youtu.be/') !== false) {
            $videoId = explode('youtu.be/', $link)[1];
            $videoId = explode('?', $videoId)[0];
        }

        if ($videoId) {
            return "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
        }

        return null;
    }


    public function subjek_materi()
    {
        return $this->belongsTo(SubjekMateri::class, 'subjek_materi_id');
    }

    public function video_dilihat()
    {
        return $this->hasMany(VideoDilihat::class, 'id_video');
    }
}
