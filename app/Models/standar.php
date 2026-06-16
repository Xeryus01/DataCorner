<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class standar extends Model
{
    use HasFactory;

    protected $table = 'standars';

    protected $fillable = [
        "judul",
        "gambar",
    ];
}
