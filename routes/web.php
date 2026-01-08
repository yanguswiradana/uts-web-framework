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
