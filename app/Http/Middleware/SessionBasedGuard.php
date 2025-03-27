<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SessionBasedGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sessionKey = 'user_' . Auth::id();

        // Periksa apakah session key sesuai dengan pengguna yang login
        if (session($sessionKey) === null) {
            Auth::logout(); // Logout jika session tidak valid
            return redirect('/login')->withErrors(['error' => 'Session expired or invalid.']);
        }

        return $next($request);
    }
}
