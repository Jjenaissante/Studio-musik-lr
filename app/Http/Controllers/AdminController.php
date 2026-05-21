<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Ruangan;
use App\Models\Studio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function dashboardStats()
    {
        $stats = [];
        $stats['total_bookings'] = Booking::count();
        $stats['confirmed_bookings'] = Booking::whereIn('status_booking', ['confirmed', 'completed'])->count();
        $stats['pending_bookings'] = Booking::where('status_booking', 'pending')->count();

        $stats['total_revenue'] = DetailBooking::whereHas('booking', function ($query) {
            $query->whereIn('status_booking', ['confirmed', 'completed']);
        })->sum('total_bayar');

        return response()->json(['success' => true, 'data' => $stats]);
    }

    public function recentBookings(Request $request)
    {
        $limit = $request->limit ?? 5;
        $bookings = Booking::with(['user', 'ruangan.studio', 'detailBooking'])
            ->orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($b) {
                return [
                    'id_booking' => $b->id_booking,
                    'nama_user' => $b->user->nama_user,
                    'nama_studio' => $b->ruangan->studio->nama_studio,
                    'tanggal_booking' => $b->tanggal_booking,
                    'status_booking' => $b->status_booking,
                    'total_bayar' => $b->detailBooking->total_bayar ?? 0
                ];
            });

        return response()->json(['success' => true, 'data' => $bookings]);
    }

    public function allBookings(Request $request)
    {
        $query = Booking::with(['user', 'ruangan.studio', 'detailBooking']);

        if ($request->status) {
            $query->where('status_booking', $request->status);
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->get()
            ->map(function ($b) {
                return [
                    'id_booking' => $b->id_booking,
                    'id_user' => $b->id_user,
                    'nama_user' => $b->user->nama_user,
                    'no_hp' => $b->user->no_hp,
                    'nama_studio' => $b->ruangan->studio->nama_studio,
                    'nama_ruangan' => $b->ruangan->nama_ruangan,
                    'tanggal_booking' => $b->tanggal_booking,
                    'jam_mulai' => $b->jam_mulai,
                    'jam_selesai' => $b->jam_selesai,
                    'durasi' => $b->durasi,
                    'status_booking' => $b->status_booking,
                    'total_bayar' => $b->detailBooking->total_bayar ?? 0,
                    'status_pembayaran' => $b->detailBooking->status_pembayaran ?? null,
                    'bukti_pembayaran' => $b->detailBooking->bukti_pembayaran ?? null,
                    'catatan' => $b->catatan
                ];
            });

        return response()->json(['success' => true, 'data' => $bookings]);
    }

    public function confirmBooking(Request $request)
    {
        $id = $request->id_booking;
        $booking = Booking::find($id);
        if ($booking) {
            $booking->update(['status_booking' => 'confirmed']);
            return response()->json(['success' => true, 'message' => 'Booking dikonfirmasi']);
        }
        return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
    }

    public function cancelBooking(Request $request)
    {
        $id = $request->id_booking;
        $booking = Booking::find($id);
        if ($booking) {
            $booking->update(['status_booking' => 'cancelled']);
            return response()->json(['success' => true, 'message' => 'Booking dibatalkan']);
        }
        return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
    }

    public function users()
    {
        $users = User::where('role', 'user')->get(['id_user', 'nama_user', 'email', 'no_hp', 'role']);
        return response()->json(['success' => true, 'data' => $users]);
    }

    public function updateRoom(Request $request)
    {
        $id = $request->id_ruangan;
        $ruangan = Ruangan::find($id);
        if ($ruangan) {
            $ruangan->update([
                'nama_ruangan' => $request->nama_ruangan,
                'kapasitas' => $request->kapasitas,
                'tarif_per_jam' => $request->tarif,
                'status' => $request->status,
            ]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Room not found'], 404);
    }

    public function deleteRoom(Request $request)
    {
        $id = $request->id_ruangan;
        $ruangan = Ruangan::find($id);
        if ($ruangan) {
            $ruangan->delete();
            return response()->json(['success' => true, 'message' => 'Terhapus']);
        }
        return response()->json(['success' => false, 'message' => 'Gagal hapus'], 404);
    }
}
