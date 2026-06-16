<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveiLayanan extends Model
{
    protected $table = 'survei_layanan';

    protected $fillable = [
        'tahun',
        'link',
        'is_active',
    ];
}
