<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KomikController;

Route::get('/', [KomikController::class, 'home'])->name('home');
Route::get('/explore', [KomikController::class, 'index'])->name('explore.index');
Route::get('/library', [KomikController::class, 'library'])->name('library.index'); // Route Baru
Route::get('/komik/{slug}', [KomikController::class, 'show'])->name('komik.show');
