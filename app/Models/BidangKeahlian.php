<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\konsultan;

class BidangKeahlian extends Model
{
    protected $fillable = [
        'nama_bidang',
        'status',
    ];

    public function konsultans()
    {
        return $this->belongsToMany(
            konsultan::class,
            'bidang_keahlian_konsultan',
            'bidang_keahlian_id',
            'konsultan_id'
        );
    }
}
