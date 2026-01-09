<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KomikController;
use App\Http\Controllers\AuthController;
use App\http\Controllers\AdminComicController;

Route::get('/', [KomikController::class, 'home'])->name('home');
Route::get('/explore', [KomikController::class, 'index'])->name('explore.index');
Route::get('/library', [KomikController::class, 'library'])->name('library.index'); // Route Baru
Route::get('/komik/{slug}', [KomikController::class, 'show'])->name('komik.show');
Route::get('/komik/{slug}/read/{chapter}', [KomikController::class, 'read'])->name('komik.read');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

// Grouping Route Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminComicController::class, 'index'])->name('dashboard');
    
    // Form Tambah
    Route::get('/create', [AdminComicController::class, 'create'])->name('create');
    
    // Proses Simpan
    Route::post('/store', [AdminComicController::class, 'store'])->name('store');
    
    // Hapus
    Route::delete('/delete/{id}', [AdminComicController::class, 'destroy'])->name('destroy');
});

// Route untuk Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');