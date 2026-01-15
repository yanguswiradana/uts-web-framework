<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan Model User di-import

class AuthController extends Controller
{
    // ==========================================
    // 1. REGISTER USER BARU
    // ==========================================
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Pastikan di form namanya 'password_confirmation'
        ]);

        // 2. Buat User Baru di Database
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user', // Default role user biasa
        ]);

        // 3. Langsung Login Otomatis setelah daftar
        Auth::login($user);

        // 4. Redirect ke Home
        return redirect()->route('home')->with('success', 'Selamat datang, akun berhasil dibuat!');
    }

    // ==========================================
    // 2. LOGIN USER
    // ==========================================
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // 1. Validasi
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba Login
        if (Auth::attempt($credentials, $request->filled('remember'))) { // Support Remember Me
            $request->session()->regenerate();

            // Cek Role (Opsional: Kalau mau user admin dilarang login di sini)
            // if (Auth::user()->role === 'admin') { ... }

            return redirect()->intended(route('home'));
        }

        // 3. Jika Gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // ==========================================
    // 3. LOGOUT
    // ==========================================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}