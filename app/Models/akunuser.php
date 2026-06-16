<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ← gunakan Authenticatable
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\konsultasiKlik;
use App\Models\janjitemu;

class akunuser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        "nama",
        "email",
        "no_hp",
        "password",    
    ];

    protected $hidden = ['password', 'remember_token'];

    public function janjiTemu()
    {
        return $this->hasMany(janjitemu::class, 'users_id');
    }
    public function jumlahKlik()
    {
        return $this->hasMany(konsultasiKlik::class, 'users_id');
    }

}
