<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class petugas extends Model
{
    use HasFactory;
    protected $table = 'petugas_harian';

    protected $fillable = [
        "konsultan_id",
        "tanggal",
        "status",
    ];

    public function konsultan()
{
    return $this->belongsTo(konsultan::class);
}

}
