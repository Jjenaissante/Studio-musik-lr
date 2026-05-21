<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StudioController;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', [StudioController::class, 'index'])->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/me', [AuthController::class, 'me']);

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/calendar', [BookingController::class, 'calendar'])->name('calendar');
    Route::get('/history', [BookingController::class, 'history'])->name('history');

    Route::post('/booking', [BookingController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'userBookings']);
    Route::post('/upload-proof', [BookingController::class, 'uploadProof']);
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/stats', [AdminController::class, 'dashboardStats']);
    Route::get('/recent-bookings', [AdminController::class, 'recentBookings']);
    Route::get('/all-bookings', [AdminController::class, 'allBookings']);
    Route::post('/confirm-booking', [AdminController::class, 'confirmBooking']);
    Route::post('/cancel-booking', [AdminController::class, 'cancelBooking']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::post('/update-room', [AdminController::class, 'updateRoom']);
    Route::post('/delete-room', [AdminController::class, 'deleteRoom']);
});

// Public API-like routes
Route::get('/studios', [StudioController::class, 'getStudios']);
Route::get('/studio/{id}', [StudioController::class, 'getStudio']);
Route::get('/available-slots', [BookingController::class, 'availableSlots']);

// Detail Studio (Public)
Route::get('/studio-detail/{id}', [StudioController::class, 'show'])->name('studio.detail');
