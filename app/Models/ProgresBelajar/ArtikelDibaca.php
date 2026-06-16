<?php

namespace App\Models\ProgresBelajar;

use App\Models\User;
use App\Models\Artikel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArtikelDibaca extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_artikel',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel');
    }
}
