<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/library', function () {
    return view('pages.library');
});
Route::get('/explore', function () {
    return view('pages.explore');
});
