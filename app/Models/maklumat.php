<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maklumat extends Model
{
    use HasFactory;
    protected $table = 'maklumats';

    protected $fillable = [
        "judul",
        "file",
    ];
}
