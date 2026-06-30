<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\NotificationController;

// =============================
// HALAMAN UMUM (PUBLIC)
// =============================

// Homepage
Route::get('/', [StudioController::class, 'index'])->name('home');

// Kalender - Bisa diakses tanpa login
Route::get('/calendar', [BookingController::class, 'calendar'])->name('calendar');

// =============================
// AUTENTIKASI
// =============================

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Cek status sesi (untuk frontend JS)
Route::get('/auth/me', [AuthController::class, 'me'])->name('auth.me');

// =============================
// API DATA (PUBLIC - untuk kalender & studio)
// =============================

// Data studio & ruangan (public)
Route::get('/api/studios', [StudioController::class, 'getStudios'])->name('api.studios');
Route::get('/api/ruangan', [StudioController::class, 'getRuangan'])->name('api.ruangan');

// Slot yang tersedia (public - untuk kalender)
Route::get('/api/bookings/available-slots', [BookingController::class, 'availableSlots'])->name('api.slots');

// Semua booking untuk kalender (public)
Route::get('/api/bookings/calendar', [BookingController::class, 'calendarBookings'])->name('api.calendar');

// =============================
// HALAMAN USER (Perlu Login)
// =============================

Route::middleware('auth.session')->group(function () {
    // Riwayat booking user
    Route::get('/history', [BookingController::class, 'history'])->name('history');

    // API Booking user
    Route::get('/api/bookings/my', [BookingController::class, 'userBookings'])->name('api.my-bookings');

    // Buat booking baru
    Route::post('/api/bookings', [BookingController::class, 'store'])->name('api.booking.store');

    // Upload bukti pembayaran
    Route::post('/api/bookings/upload-proof', [BookingController::class, 'uploadProof'])->name('api.booking.upload-proof');

    // Batalkan booking (hanya jika status pending)
    Route::post('/api/bookings/cancel', [BookingController::class, 'cancelBooking'])->name('api.booking.cancel');

    // Notifikasi user
    Route::get('/api/notifications', [NotificationController::class, 'getNotifications'])->name('api.notifications');
    Route::post('/api/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('api.notifications.mark-as-read');
});

// =============================
// HALAMAN ADMIN (Perlu Login Admin)
// =============================

Route::middleware('auth.admin')->group(function () {
    // Dashboard admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // API Admin
    Route::get('/api/admin/stats', [AdminController::class, 'dashboardStats'])->name('api.admin.stats');
    Route::get('/api/admin/bookings/recent', [AdminController::class, 'recentBookings'])->name('api.admin.recent');
    Route::get('/api/admin/bookings', [AdminController::class, 'allBookings'])->name('api.admin.all-bookings');
    Route::post('/api/admin/bookings/confirm', [AdminController::class, 'confirmBooking'])->name('api.admin.confirm');
    Route::post('/api/admin/bookings/cancel', [AdminController::class, 'cancelBooking'])->name('api.admin.cancel');
    Route::post('/api/admin/bookings/complete', [AdminController::class, 'completeBooking'])->name('api.admin.complete');
    Route::get('/api/admin/users', [AdminController::class, 'users'])->name('api.admin.users');
    Route::get('/api/admin/studios', [AdminController::class, 'getStudiosAdmin'])->name('api.admin.studios');
    Route::get('/api/admin/rooms', [AdminController::class, 'getRoomsAdmin'])->name('api.admin.rooms');
    Route::post('/api/admin/rooms/update', [AdminController::class, 'updateRoom'])->name('api.admin.update-room');
    Route::post('/api/admin/rooms/delete', [AdminController::class, 'deleteRoom'])->name('api.admin.delete-room');
});