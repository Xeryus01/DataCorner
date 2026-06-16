<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Audit Log untuk mencatat aktivitas admin.
 * Mencakup: siapa, apa yang dilakukan, pada data apa, kapan.
 */
class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';

    protected $fillable = [
        'admin_id',
        'admin_nama',
        'admin_role',
        'aksi',           // 'create', 'update', 'delete', 'verify', 'reject', 'login', 'logout'
        'modul',          // 'konsultasi', 'magang', 'riset', 'konten-edukasi', 'kuis', 'user', 'admin'
        'deskripsi',      // Deskripsi singkat aksi
        'data_id',        // ID data yang diubah
        'data_tipe',      // Nama model/tabel yang diubah
        'data_sebelum',   // JSON data sebelum perubahan (optional)
        'data_sesudah',   // JSON data setelah perubahan (optional)
        'ip_address',     // IP address admin
        'user_agent',     // Browser/device info
    ];

    protected $casts = [
        'data_sebelum' => 'array',
        'data_sesudah' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}