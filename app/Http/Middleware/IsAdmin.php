<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    // Cek apakah user login DAN rolenya admin
    if (Auth::check() && Auth::user()->role === 'admin') {
        return $next($request);
    }

    // Jika bukan admin, tendang ke halaman home atau login user
    return redirect('/')->with('error', 'Anda tidak memiliki akses admin.');
}
}
