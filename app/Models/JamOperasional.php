<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamOperasional extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'keterangan_hari',
        'jam_mulai',
        'jam_selesai',
    ];

    /**
     * Cek apakah jam operasional ini menunjukkan "Tutup" (00:00:00).
     */
    public function isTutup(): bool
    {
        if ($this->jam_mulai === null || $this->jam_selesai === null) return true;
        if ($this->jam_mulai === '00:00:00' && $this->jam_selesai === '00:00:00') return true;
        if ($this->jam_mulai === '00:00' && $this->jam_selesai === '00:00') return true;
        return false;
    }

    /**
     * Format jam mulai untuk ditampilkan.
     */
    public function getJamMulaiDisplayAttribute(): string
    {
        if ($this->isTutup()) return 'Tutup';
        return \Carbon\Carbon::parse($this->jam_mulai)->format('H.i');
    }

    /**
     * Format jam selesai untuk ditampilkan.
     */
    public function getJamSelesaiDisplayAttribute(): string
    {
        if ($this->isTutup()) return 'Tutup';
        return \Carbon\Carbon::parse($this->jam_selesai)->format('H.i');
    }
}
