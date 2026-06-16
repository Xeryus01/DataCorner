<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'admins';
    protected $guard_name = 'admin';
    protected $fillable = ['email', 'nama', 'username', 'password', 'wilayah_bps_id'];
    protected $hidden = ['password', 'remember_token'];

    public function wilayah()
    {
        return $this->belongsTo(WilayahBps::class, 'wilayah_bps_id');
    }
}
