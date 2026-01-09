<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KomikController;
use App\Http\Controllers\AuthController;

Route::get('/', [KomikController::class, 'home'])->name('home');
Route::get('/explore', [KomikController::class, 'index'])->name('explore.index');
Route::get('/library', [KomikController::class, 'library'])->name('library.index'); // Route Baru
Route::get('/komik/{slug}', [KomikController::class, 'show'])->name('komik.show');
Route::get('/komik/{slug}/read/{chapter}', [KomikController::class, 'read'])->name('komik.read');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');


use App\Http\Controllers\AdminController;

Route::prefix('admin')->group(function () {
    // Route tamu (belum login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminController::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.login.submit');
    });

    // Route khusus Admin (sudah login + middleware is_admin)
    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});