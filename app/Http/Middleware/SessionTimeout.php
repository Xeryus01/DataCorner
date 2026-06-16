<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    protected $timeout = 43200; // waktu dalam detik (2 jam)

    public function handle($request, Closure $next)
{
    if (session()->has('loginStatus') && session('loginStatus') === true) {
        $lastActivity = session('lastActivityTime');
        $now = time();

        if ($lastActivity && ($now - $lastActivity) > $this->timeout) {
            session()->flush();

            // Redirect ke halaman sebelumnya dengan flag timeout
            return redirect()->route('loginUser')->with('session_timeout', true);
        }

        session(['lastActivityTime' => $now]);
    }

    return $next($request);
}

}
