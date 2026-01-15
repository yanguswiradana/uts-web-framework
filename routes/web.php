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
// A. FRONTEND (PENGUNJUNG)
// ==========================================
Route::controller(KomikController::class)->group(function() {
    Route::get('/', 'home')->name('home');
    Route::get('/explore', 'index')->name('explore.index');
    Route::get('/library', 'library')->name('library.index');
    Route::get('/komik/{slug}', 'show')->name('komik.show');
    Route::get('/komik/{slug}/read/{chapter}', 'read')->name('komik.read');
});

// ==========================================
// B. AUTHENTICATION (LOGIN/REGISTER USER BIASA)
// ==========================================
Route::controller(AuthController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('login.submit');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'store')->name('register.submit');
    Route::post('/logout', 'logout')->name('logout');
});

// ==========================================
// C. BACKEND ADMIN (DASHBOARD)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // 1. Route Tamu Admin (Belum Login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');
    });

    // 2. Route Khusus Admin (Sudah Login + Cek Role)
    // Pastikan middleware 'is_admin' ada, atau ganti 'auth' saja
    Route::middleware(['auth', 'is_admin'])->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');

        // CRUD Resource
        Route::resource('comics', ComicController::class);
        Route::resource('chapters', ChapterController::class);
        Route::resource('genres', GenreController::class);
        Route::resource('users', UserController::class);

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});