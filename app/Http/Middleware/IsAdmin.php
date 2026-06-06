<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN role-nya adalah 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            // Jika benar admin, silakan masuk
            return $next($request);
        }

        // Jika bukan admin tapi iseng maksa masuk URL ini, tendang balik ke dashboard biasa!
        return redirect()->route('dashboard');
    }
}