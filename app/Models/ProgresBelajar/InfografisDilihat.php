<?php

namespace App\Models\ProgresBelajar;

use App\Models\Infografis;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfografisDilihat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_infografis',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function infografis()
    {
        return $this->belongsTo(Infografis::class, 'id_infografis');
    }
}
