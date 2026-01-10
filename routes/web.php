<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KomikController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PUBLIC ROUTES (Frontend Pengunjung)
// ==========================================
Route::get('/', [KomikController::class, 'home'])->name('home');
Route::get('/explore', [KomikController::class, 'index'])->name('explore.index');
Route::get('/library', [KomikController::class, 'library'])->name('library.index');
Route::get('/komik/{slug}', [KomikController::class, 'show'])->name('komik.show');
Route::get('/komik/{slug}/read/{chapter}', [KomikController::class, 'read'])->name('komik.read');

// ==========================================
// 2. AUTH ROUTES (Login/Register User Biasa)
// ==========================================
// Note: Pastikan kamu punya route POST untuk proses loginnya juga nanti
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 3. ADMIN ROUTES (Backend Dashboard)
// ==========================================
Route::prefix('admin')->group(function () {
    
    // A. Route Tamu Admin (Belum Login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminController::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.login.submit');
    });

    // B. Route Khusus Admin (Sudah Login + Middleware 'is_admin')
    Route::middleware(['auth', 'is_admin'])->group(function () {
        
        // Dashboard Utama
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Manajemen Konten (Sesuai Menu Sidebar)
        Route::get('/comics', [AdminController::class, 'comics'])->name('admin.comics.index');
        Route::get('/chapters', [AdminController::class, 'chapters'])->name('admin.chapters.index');
        Route::get('/genres', [AdminController::class, 'genres'])->name('admin.genres.index');

        // Manajemen User & Sistem
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');

        // Logout
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});