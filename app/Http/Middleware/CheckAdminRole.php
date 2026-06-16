<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk mengecek role admin menggunakan Spatie Permission.
 * 
 * Usage:
 *   Route::middleware(['auth:admin', 'role:admin'])->group(...)
 *   Route::middleware(['auth:admin', 'role:admin,operator'])->group(...)
 */
class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('loginAdmin');
        }

        // Jika tidak ada role yang dispesifikkan, izinkan semua admin yang sudah login
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah admin memiliki salah satu role yang dibutuhkan
        foreach ($roles as $role) {
            if ($admin->hasRole($role)) {
                return $next($request);
            }
        }

        // Jika tidak punya role yang sesuai, redirect ke dashboard dengan pesan error
        return redirect()->route('dashboard.index')
            ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}