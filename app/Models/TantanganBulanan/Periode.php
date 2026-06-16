<?php

namespace App\Models\TantanganBulanan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Periode extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode',
        'status_leaderboard'
    ];

    public function kuis()
    {
        return $this->hasMany(KuisTantanganBulanan::class, 'id_periode');
    }
}
