<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\Genre; // Pastikan Model Genre di-import

class AdminController extends Controller
{
    // ==========================================
    // 1. AUTHENTICATION
    // ==========================================

    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('admin/dashboard');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Akun Anda bukan Admin.']);
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    // ==========================================
    // 2. DASHBOARD
    // ==========================================

    public function dashboard()
    {
        $stats = [
            'total_comics' => Comic::count(),
            'total_chapters' => Chapter::count(),
            'total_users' => User::count(),
            'total_views' => '2.4M',
            'reports' => 3
        ];

        // Ambil 5 chapter terbaru dengan relasi komik
        $recentUpdates = Chapter::with('comic')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUpdates'));
    }

    // ==========================================
    // 3. MENU MANAJEMEN KONTEN
    // ==========================================

    public function comics()
    {
        // UPDATE: Tambahkan with('genres') agar query efisien (N+1 problem solver)
        $comics = Comic::with('genres')
            ->latest()
            ->paginate(10);
            
        return view('admin.comics.index', compact('comics'));
    }

    public function chapters()
    {
        $chapters = Chapter::with('comic')
            ->latest()
            ->paginate(15);

        return view('admin.chapters.index', compact('chapters'));
    }

    public function genres()
    {
        // Kita ambil data genre sekalian, jaga-jaga kalau view genres sudah siap
        $genres = Genre::latest()->paginate(20);
        return view('admin.genres.index', compact('genres'));
    }

    // ==========================================
    // 4. MENU SISTEM & USER
    // ==========================================

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function settings()
    {
        return view('admin.settings.index');
    }
}