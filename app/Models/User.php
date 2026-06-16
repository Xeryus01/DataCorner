<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\janjitemu;
use App\Models\konsultasiKlik;
use App\Models\KuisReguler\HasilKuisReguler;
use App\Models\ProgresBelajar\ArtikelDibaca;
use App\Models\ProgresBelajar\VideoDilihat;
use App\Models\TantanganBulanan\HasilKuisTantanganBulanan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama', 'name', 'email', 'no_hp', 'password', 'role_id',
        'jenis_kelamin', 'instansi', 'foto', 'otp_code', 'otp_expires_at',
        'is_verified', 'pending_email', 'slug'
    ];

    protected $hidden = ['password', 'remember_token', 'otp_code'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
            'is_verified' => 'boolean',
        ];
    }

    public function role() { return $this->belongsTo(Role::class); }
    public function janjiTemu() { return $this->hasMany(janjitemu::class, 'users_id'); }
    public function jumlahKlik() { return $this->hasMany(konsultasiKlik::class, 'users_id'); }
    public function pendaftaran_magang() { return $this->hasMany(PendaftaranMagang::class, 'user_id'); }
    public function pendaftaran_riset() { return $this->hasMany(PendaftaranRiset::class, 'user_id'); }
    public function hasil_kuis_reguler() { return $this->hasMany(HasilKuisReguler::class, 'id_user'); }
    public function hasil_kuis_tantangan_bulanan() { return $this->hasMany(HasilKuisTantanganBulanan::class, 'id_user'); }
    public function artikel_dibaca() { return $this->hasMany(ArtikelDibaca::class, 'id_user'); }
    public function video_dilihat() { return $this->hasMany(VideoDilihat::class, 'id_user'); }

    public function getSlugAttribute($value)
    {
        if (!empty($value)) return $value;
        $displayName = $this->name ?: $this->nama ?: $this->email ?: 'user';
        return $this->id . '-' . Str::slug($displayName);
    }
}
