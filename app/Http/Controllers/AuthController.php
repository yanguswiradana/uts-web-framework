<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- WAJIB DITAMBAHKAN AGAR TIDAK ERROR

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function logout(Request $request)
    {
        // Sekarang Auth:: sudah bisa dikenali
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Redirect ke halaman utama
        return redirect()->route('home'); 
    }
}