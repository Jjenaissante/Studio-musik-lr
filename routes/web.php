<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan baris ini ada

// Halaman Utama
Route::get('/', function () {
    return view('index');
});

// Jalur Login Resmi Laravel
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);