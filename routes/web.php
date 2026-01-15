<?php

use Illuminate\Support\Facades\Route;

// Controller Frontend
use App\Http\Controllers\KomikController;
use App\Http\Controllers\AuthController;

// Controller Backend (Admin)
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ComicController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. FRONTEND PUBLIC (Bisa diakses siapa saja)
// ==========================================
Route::controller(KomikController::class)->group(function() {
    Route::get('/', 'home')->name('home');
    Route::get('/explore', 'index')->name('explore.index');
    // Route::get('/library', 'library'); <-- HAPUS DARI SINI
    Route::get('/komik/{slug}', 'show')->name('komik.show');
    Route::get('/komik/{slug}/read/{chapter}', 'read')->name('komik.read');
});

// ==========================================
// 2. FRONTEND PRIVATE (Hanya User Login)
// ==========================================
Route::middleware(['auth'])->controller(KomikController::class)->group(function() {
    // Pindahkan Library kesini agar terkunci
    Route::get('/library', 'library')->name('library.index');
});

// ==========================================
// 3. AUTHENTICATION (LOGIN/REGISTER USER BIASA)
// ==========================================
Route::controller(AuthController::class)->group(function() {
    // Guest only (Hanya yang belum login boleh akses halaman login/register)
    Route::middleware('guest')->group(function() {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate')->name('login.submit');
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'store')->name('register.submit');
    });

    // Logout perlu login dulu
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

// ==========================================
// 4. BACKEND ADMIN (DASHBOARD)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // A. Route Tamu Admin (Belum Login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');
    });

    // B. Route Khusus Admin (Sudah Login + Wajib Role Admin)
    // Pastikan middleware 'is_admin' sudah Anda buat/daftarkan di kernel.
    // Jika belum punya middleware is_admin, gunakan: middleware(['auth']) dulu sementara.
    Route::middleware(['auth', 'is_admin'])->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
// Di dalam group Admin -> Middleware Auth & IsAdmin
Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // CRUD Resource
        Route::resource('comics', ComicController::class);
        Route::resource('chapters', ChapterController::class);
        Route::resource('genres', GenreController::class);
        Route::resource('users', UserController::class);
        

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});