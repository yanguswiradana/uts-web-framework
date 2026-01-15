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
// 1. FRONTEND PUBLIC
// ==========================================
Route::controller(KomikController::class)->group(function() {
    Route::get('/', 'home')->name('home');
    Route::get('/explore', 'index')->name('explore.index');
    Route::get('/komik/{slug}', 'show')->name('komik.show');
    Route::get('/komik/{slug}/read/{chapter}', 'read')->name('komik.read');
});

// ==========================================
// 2. FRONTEND PRIVATE (Auth Required)
// ==========================================
Route::middleware(['auth'])->controller(KomikController::class)->group(function() {
    
    // Library
    Route::get('/library', 'library')->name('library.index');
    
    // Bookmark Action
    Route::post('/komik/{slug}/bookmark', 'toggleBookmark')->name('komik.bookmark');

    // --- RATING ACTION (BARU) ---
    Route::post('/komik/{slug}/rate', 'rate')->name('komik.rate');
});

// ==========================================
// 3. AUTHENTICATION
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
// 4. BACKEND ADMIN
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        Route::resource('comics', ComicController::class);
        Route::resource('chapters', ChapterController::class);
        Route::resource('genres', GenreController::class);
        Route::resource('users', UserController::class);

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});