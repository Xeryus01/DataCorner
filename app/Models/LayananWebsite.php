<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananWebsite extends Model
{
    protected $table = 'layanan_website';
    protected $fillable = [

        'periode',
        'active_users',
        'new_users',
        'returning_users',
        'total_users',
        'sessions',
        'bounce_rate',
    ];
}
