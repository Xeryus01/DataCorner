<?php

namespace App\Models\ProgresBelajar;

use App\Models\User;
use App\Models\VideoPembelajaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoDilihat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_video',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function video()
    {
        return $this->belongsTo(VideoPembelajaran::class, 'id_video');
    }
}
