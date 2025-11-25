<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KomikController;
use App\Http\Controllers\LibraryController;

Route::get('/', function () {
    return view('home');
});

Route::get('/library', [LibraryController::class, 'index'])->name('library.index');

Route::get('/explore', [KomikController::class, 'index'])->name('explore.index');