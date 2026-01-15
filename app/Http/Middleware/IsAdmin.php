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
        // Cek 1: Apakah sudah login?
        // Cek 2: Apakah role-nya admin?
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'AKSES DITOLAK: Halaman ini khusus Admin.');
        }

        return $next($request);
    }
}