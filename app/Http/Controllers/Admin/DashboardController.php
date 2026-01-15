<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Import semua Model yang dibutuhkan
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Statistik (Count)
        $totalComics = Comic::count();
        $totalChapters = Chapter::count();
        $totalGenres = Genre::count();
        // Hitung User (Kecuali Admin agar data real member)
        $totalUsers = User::where('role', '!=', 'admin')->count();

        // 2. Ambil 5 Komik Terakhir Ditambahkan (Untuk Tabel)
        $latestComics = Comic::with('genres')->latest()->take(5)->get();

        // 3. Ambil 5 Komik dengan Chapter Terbanyak (Top Active)
        $topComics = Comic::withCount('chapters')
            ->orderBy('chapters_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalComics', 
            'totalChapters', 
            'totalGenres', 
            'totalUsers',
            'latestComics',
            'topComics'
        ));
    }
}