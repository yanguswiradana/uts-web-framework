<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// IMPORT CONTROLLERS
// ==========================================

// 1. Controller Frontend
use App\Http\Controllers\KomikController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnimeController; // [BARU] Controller Anime Frontend

// 2. Controller Backend (Admin)
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ComicController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;

// [BARU] Import Controller Anime Admin (Pakai Alias agar tidak bentrok nama)
use App\Http\Controllers\Admin\AnimeController as AdminAnimeController;
use App\Http\Controllers\Admin\AnimeEpisodeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. FRONTEND PUBLIC (Bisa diakses siapa saja)
// ==========================================

// A. KOMIK ROUTES
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

// B. [BARU] ANIME ROUTES
Route::controller(AnimeController::class)->group(function() {
    // Halaman Utama Anime
    Route::get('/anime', 'index')->name('anime.index');
    
    // Halaman Detail Anime
    Route::get('/anime/{slug}', 'show')->name('anime.show');
    
    // Halaman Nonton (Player)
    Route::get('/anime/{slug}/watch/{episode}', 'watch')->name('anime.watch');
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

    // Halaman Dashboard & Kelola Data (Harus Login)
    Route::middleware(['auth'])->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Pengaturan Website
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // CRUD Data Komik
        Route::resource('comics', ComicController::class);
        Route::resource('chapters', ChapterController::class);
        Route::resource('genres', GenreController::class);
        Route::resource('users', UserController::class);

        // [BARU] CRUD Data Anime
        // Menggunakan alias 'AdminAnimeController' yang didefinisikan di atas
        Route::resource('animes', AdminAnimeController::class);
        Route::resource('anime_episodes', AnimeEpisodeController::class);

        // Logout Admin
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});