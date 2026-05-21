<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckAdmin;

// --- VIEWS ---
Route::get('/', function () {
    return view('index');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function() {
        return view('admin');
    })->middleware(CheckAdmin::class);

    Route::get('/calendar', function() {
        return view('calendar');
    });

    Route::get('/history', function() {
        return view('history');
    });

    Route::get('/profile', function() {
        return view('profile');
    });
});

// --- AUTH API ---
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::get('/api/me', [AuthController::class, 'me']);

// --- STUDIO API ---
Route::get('/api/studios', [StudioController::class, 'index']);
Route::get('/api/studios/{id}', [StudioController::class, 'show']);

Route::middleware(['auth'])->group(function () {
    Route::post('/api/update-room', [StudioController::class, 'updateRoom'])->middleware(CheckAdmin::class);
    Route::post('/api/delete-room', [StudioController::class, 'deleteRoom'])->middleware(CheckAdmin::class);

    // --- BOOKING API ---
    Route::get('/api/bookings', [BookingController::class, 'list']);
    Route::post('/api/booking', [BookingController::class, 'store']);
    Route::post('/api/upload-proof', [BookingController::class, 'uploadProof']);

    // --- PROFILE API ---
    Route::post('/api/update-profile', [ProfileController::class, 'update']);
    Route::post('/api/change-password', [ProfileController::class, 'changePassword']);
    Route::post('/api/cancel-booking', [AdminController::class, 'cancelBooking']); // Reusing admin cancel for user self-cancel
});

Route::get('/api/available-slots', [BookingController::class, 'availableSlots']);

// --- ADMIN API ---
Route::middleware(['auth', CheckAdmin::class])->group(function () {
    Route::get('/api/dashboard-stats', [AdminController::class, 'dashboardStats']);
    Route::get('/api/users', [AdminController::class, 'users']);
    Route::get('/api/recent-bookings', [AdminController::class, 'recentBookings']);
    Route::post('/api/confirm-booking', [AdminController::class, 'confirmBooking']);
});
