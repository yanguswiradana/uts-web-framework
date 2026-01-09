<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Menampilkan Form Login Admin
    public function index()
    {
        return view('admin.login');
    }

    // Proses Login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek lagi apakah dia admin
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('admin/dashboard');
            }

            // Jika login sukses tapi bukan admin, logout paksa
            Auth::logout();
            return back()->withErrors(['email' => 'Akun Anda bukan Admin.']);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Halaman Dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Logout Admin
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
