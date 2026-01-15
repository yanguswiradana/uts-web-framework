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
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. FRONTEND PUBLIC (Bisa diakses siapa saja)
// ==========================================
Route::controller(KomikController::class)->group(function() {
    // Halaman Utama
    Route::get('/', 'home')->name('home');
    
    // Halaman Jelajah/Pencarian
    Route::get('/explore', 'index')->name('explore.index');
    
    // Halaman Detail Komik
    Route::get('/komik/{slug}', 'show')->name('komik.show');
    
    // Halaman Baca Chapter
    Route::get('/komik/{slug}/read/{chapter}', 'read')->name('komik.read');
});

// ==========================================
// 2. FRONTEND PRIVATE (Harus Login)
// ==========================================
Route::middleware(['auth'])->controller(KomikController::class)->group(function() {
    
    // Halaman Library (Bookmark)
    Route::get('/library', 'library')->name('library.index');
    
    // Action: Tambah/Hapus Bookmark
    Route::post('/komik/{slug}/bookmark', 'toggleBookmark')->name('komik.bookmark');

    // Action: Beri Rating
    Route::post('/komik/{slug}/rate', 'rate')->name('komik.rate');

    // Action: Kirim Komentar (Chapter)
    Route::post('/chapter/{id}/comment', 'postComment')->name('chapter.comment');
});

// ==========================================
// 3. AUTHENTICATION (Login/Register)
// ==========================================
Route::controller(AuthController::class)->group(function() {
    Route::middleware('guest')->group(function() {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate')->name('login.submit');
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'store')->name('register.submit');
    });

    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

// ==========================================
// 4. BACKEND ADMIN (Dashboard)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Halaman Login Admin
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');
    });

    // Halaman Dashboard & Kelola Data
    Route::middleware(['auth'])->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Pengaturan Website
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // CRUD Data
        Route::resource('comics', ComicController::class);
        Route::resource('chapters', ChapterController::class);
        Route::resource('genres', GenreController::class);
        Route::resource('users', UserController::class);

        // Logout Admin
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});