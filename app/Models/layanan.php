<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class layanan extends Model
{
    use HasFactory;
    protected $table = 'layanans';

    protected $fillable = [
        "gambar",
        "judul",
        "deskripsi",
        "link",
    ];
}
