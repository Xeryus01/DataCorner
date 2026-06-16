<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // Cek URL path atau guard berdasarkan prefix route
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('loginAdmin');
            }

            // Guard default (web/user)
            return route('loginUser');
        }

        return null;
    }
}
