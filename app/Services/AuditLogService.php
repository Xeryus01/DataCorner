<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Service untuk mencatat aktivitas admin ke dalam audit log.
 * Digunakan oleh controller admin untuk tracking semua perubahan data.
 */
class AuditLogService
{
    /**
     * Mencatat aktivitas admin.
     */
    public static function log(
        string $aksi,
        string $modul,
        string $deskripsi,
        ?int $dataId = null,
        ?string $dataTipe = null,
        ?array $dataSebelum = null,
        ?array $dataSesudah = null
    ): AuditLog {
        $admin = Auth::guard('admin')->user();
        $request = request();

        return AuditLog::create([
            'admin_id'     => $admin?->id,
            'admin_nama'   => $admin?->nama,
            'admin_role'   => $admin?->getRoleNames()->first(),
            'aksi'         => $aksi,
            'modul'        => $modul,
            'deskripsi'    => $deskripsi,
            'data_id'      => $dataId,
            'data_tipe'    => $dataTipe,
            'data_sebelum' => $dataSebelum,
            'data_sesudah' => $dataSesudah,
            'ip_address'   => $request?->ip(),
            'user_agent'   => $request?->userAgent(),
        ]);
    }

    /**
     * Log aktivitas singkat (untuk aksi sederhana).
     */
    public static function quick(string $aksi, string $modul, string $deskripsi): AuditLog
    {
        return self::log($aksi, $modul, $deskripsi);
    }

    /**
     * Log perubahan data (untuk update/delete).
     */
    public static function trackChange(
        string $modul,
        string $dataTipe,
        int $dataId,
        ?array $before,
        ?array $after
    ): AuditLog {
        return self::log(
            aksi: $after ? 'update' : 'delete',
            modul: $modul,
            deskripsi: ($after ? 'Mengubah' : 'Menghapus') . " data {$dataTipe} #{$dataId}",
            dataId: $dataId,
            dataTipe: $dataTipe,
            dataSebelum: $before,
            dataSesudah: $after
        );
    }
}