<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboardStats()
    {
        $stats = [];
        $stats['total_bookings'] = Booking::count();
        $stats['confirmed_bookings'] = Booking::whereIn('status_booking', ['confirmed', 'completed'])->count();
        $stats['pending_bookings'] = Booking::where('status_booking', 'pending')->count();

        $stats['total_revenue'] = DetailBooking::whereHas('booking', function($q) {
            $q->whereIn('status_booking', ['confirmed', 'completed']);
        })->sum('total_bayar');

        return response()->json(['success' => true, 'data' => $stats]);
    }

    public function users()
    {
        $users = User::where('role', 'user')->get(['id_user', 'nama_user', 'email', 'no_hp', 'role']);
        return response()->json(['success' => true, 'data' => $users]);
    }

    public function recentBookings(Request $request)
    {
        $limit = $request->query('limit', 5);
        $bookings = Booking::with(['user', 'ruangan.studio', 'detail'])
            ->orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($b) {
                return [
                    'id_booking' => $b->id_booking,
                    'nama_user' => $b->user->nama_user,
                    'nama_studio' => $b->ruangan->studio->nama_studio,
                    'tanggal_booking' => $b->tanggal_booking,
                    'status_booking' => $b->status_booking,
                    'total_bayar' => $b->detail->total_bayar ?? 0
                ];
            });

        return response()->json(['success' => true, 'data' => $bookings]);
    }

    public function confirmBooking(Request $request)
    {
        $id = $request->input('id_booking');
        $booking = Booking::find($id);
        if ($booking) {
            $booking->update(['status_booking' => 'confirmed']);
            return response()->json(['success' => true, 'message' => 'Booking dikonfirmasi']);
        }
        return response()->json(['success' => false, 'message' => 'Gagal update database'], 404);
    }

    public function cancelBooking(Request $request)
    {
        $id = $request->input('id_booking');
        $booking = Booking::find($id);
        if ($booking) {
            // Authorization Fix: Only Admin or the owner can cancel
            if (auth()->user()->role !== 'admin' && $booking->id_user !== auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            $booking->update(['status_booking' => 'cancelled']);
            return response()->json(['success' => true, 'message' => 'Booking dibatalkan']);
        }
        return response()->json(['success' => false, 'message' => 'Gagal update database'], 404);
    }
}
