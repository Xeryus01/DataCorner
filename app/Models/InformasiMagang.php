<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiMagang extends Model
{
    use HasFactory;

    protected $fillable = [
        'deskripsi',
        'persyaratan',
        'benefit',
        'info_kontak',
    ];
}
