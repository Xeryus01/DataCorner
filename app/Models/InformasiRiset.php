<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InformasiRiset extends Model
{
    use HasFactory;

    protected $fillable = [
        'deskripsi',
        'persyaratan',
        'benefit',
        'info_kontak',
    ];
}
