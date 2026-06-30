<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Ruangan;
use App\Models\Studio;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Tampilkan halaman admin
    public function index()
    {
        return view('admin');
    }

    // Statistik dashboard
    public function dashboardStats()
    {
        $stats = [];
        $stats['total_bookings']     = Booking::count();
        $stats['confirmed_bookings'] = Booking::whereIn('status_booking', ['confirmed', 'completed'])->count();
        $stats['pending_bookings']   = Booking::where('status_booking', 'pending')->count();
        $stats['cancelled_bookings'] = Booking::where('status_booking', 'cancelled')->count();

        $stats['total_revenue'] = DetailBooking::whereHas('booking', function ($query) {
            $query->whereIn('status_booking', ['confirmed', 'completed']);
        })->sum('total_bayar');

        $stats['total_users'] = User::where('role', 'user')->count();

        return response()->json(['success' => true, 'data' => $stats]);
    }

    // Booking terbaru
    public function recentBookings(Request $request)
    {
        $limit    = $request->limit ?? 5;
        $query    = Booking::with(['user', 'ruangan.studio', 'detailBooking']);

        if ($request->status) {
            $query->where('status_booking', $request->status);
        }

        if ($request->id_studio) {
            $query->whereHas('ruangan', function ($q) use ($request) {
                $q->where('id_studio', $request->id_studio);
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($b) {
                return [
                    'id_booking'        => $b->id_booking,
                    'id_user'           => $b->id_user,
                    'nama_user'         => optional($b->user)->nama_user,
                    'no_hp'             => optional($b->user)->no_hp,
                    'email_user'        => optional($b->user)->email,
                    'nama_studio'       => optional(optional($b->ruangan)->studio)->nama_studio,
                    'nama_ruangan'      => optional($b->ruangan)->nama_ruangan,
                    'tanggal_booking'   => $b->tanggal_booking,
                    'jam_mulai'         => substr($b->jam_mulai, 0, 5),
                    'jam_selesai'       => substr($b->jam_selesai, 0, 5),
                    'durasi'            => $b->durasi,
                    'status_booking'    => $b->status_booking,
                    'total_bayar'       => optional($b->detailBooking)->total_bayar ?? 0,
                    'status_pembayaran' => optional($b->detailBooking)->status_pembayaran ?? null,
                    'bukti_pembayaran'  => optional($b->detailBooking)->bukti_pembayaran ?? null,
                    'catatan'           => $b->catatan,
                ];
            });

        return response()->json(['success' => true, 'data' => $bookings]);
    }

    // Semua booking (dengan filter)
    public function allBookings(Request $request)
    {
        $query = Booking::with(['user', 'ruangan.studio', 'detailBooking']);

        if ($request->status) {
            $query->where('status_booking', $request->status);
        }

        if ($request->id_studio) {
            $query->whereHas('ruangan', function ($q) use ($request) {
                $q->where('id_studio', $request->id_studio);
            });
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->get()
            ->map(function ($b) {
                return [
                    'id_booking'        => $b->id_booking,
                    'id_user'           => $b->id_user,
                    'nama_user'         => optional($b->user)->nama_user,
                    'no_hp'             => optional($b->user)->no_hp,
                    'email_user'        => optional($b->user)->email,
                    'nama_studio'       => optional(optional($b->ruangan)->studio)->nama_studio,
                    'nama_ruangan'      => optional($b->ruangan)->nama_ruangan,
                    'tanggal_booking'   => $b->tanggal_booking,
                    'jam_mulai'         => substr($b->jam_mulai, 0, 5),
                    'jam_selesai'       => substr($b->jam_selesai, 0, 5),
                    'durasi'            => $b->durasi,
                    'status_booking'    => $b->status_booking,
                    'total_bayar'       => optional($b->detailBooking)->total_bayar ?? 0,
                    'status_pembayaran' => optional($b->detailBooking)->status_pembayaran ?? null,
                    'bukti_pembayaran'  => optional($b->detailBooking)->bukti_pembayaran ?? null,
                    'catatan'           => $b->catatan,
                ];
            });

        return response()->json(['success' => true, 'data' => $bookings]);
    }

    // Konfirmasi booking
    public function confirmBooking(Request $request)
    {
        $id      = $request->id_booking;
        $booking = Booking::find($id);
        if ($booking) {
            $booking->update(['status_booking' => 'confirmed']);
            if ($booking->detailBooking) {
                $booking->detailBooking->update(['status_pembayaran' => 'verified']);
            }
            
            // Trigger Notifikasi
            Notifikasi::create([
                'id_user' => $booking->id_user,
                'judul'   => 'Booking Dikonfirmasi',
                'pesan'   => 'Booking Anda #' . $booking->id_booking . ' telah disetujui oleh admin.',
                'tipe'    => 'booking_acc',
                'is_read' => false,
            ]);

            return response()->json(['success' => true, 'message' => 'Booking dikonfirmasi']);
        }
        return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan'], 404);
    }

    // Batalkan booking
    public function cancelBooking(Request $request)
    {
        $id      = $request->id_booking;
        $booking = Booking::find($id);
        if ($booking) {
            $booking->update(['status_booking' => 'cancelled']);
            
            // Trigger Notifikasi
            Notifikasi::create([
                'id_user' => $booking->id_user,
                'judul'   => 'Booking Dibatalkan Admin',
                'pesan'   => 'Booking Anda #' . $booking->id_booking . ' telah dibatalkan oleh admin.',
                'tipe'    => 'booking_cancel',
                'is_read' => false,
            ]);

            return response()->json(['success' => true, 'message' => 'Booking dibatalkan']);
        }
        return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan'], 404);
    }

    // Selesaikan booking
    public function completeBooking(Request $request)
    {
        $id      = $request->id_booking;
        $booking = Booking::find($id);
        if ($booking) {
            $booking->update(['status_booking' => 'completed']);
            
            // Trigger Notifikasi
            Notifikasi::create([
                'id_user' => $booking->id_user,
                'judul'   => 'Booking Selesai',
                'pesan'   => 'Terima kasih! Sesi booking Anda #' . $booking->id_booking . ' telah selesai.',
                'tipe'    => 'booking_complete',
                'is_read' => false,
            ]);

            return response()->json(['success' => true, 'message' => 'Booking diselesaikan']);
        }
        return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan'], 404);
    }

    // Daftar user
    public function users()
    {
        $users = User::where('role', 'user')
            ->get(['id_user', 'nama_user', 'email', 'no_hp', 'role', 'created_at']);
        return response()->json(['success' => true, 'data' => $users]);
    }

    // Update room
    public function updateRoom(Request $request)
    {
        $id      = $request->id_ruangan;
        $ruangan = Ruangan::find($id);
        if ($ruangan) {
            $ruangan->update([
                'nama_ruangan' => $request->nama_ruangan,
                'kapasitas'    => $request->kapasitas,
                'tarif_per_jam'=> $request->tarif,
                'status'       => $request->status,
                'fasilitas'    => $request->fasilitas,
            ]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Room tidak ditemukan'], 404);
    }

    // Hapus room
    public function deleteRoom(Request $request)
    {
        $id      = $request->id_ruangan;
        $ruangan = Ruangan::find($id);
        if ($ruangan) {
            $ruangan->delete();
            return response()->json(['success' => true, 'message' => 'Ruangan berhasil dihapus']);
        }
        return response()->json(['success' => false, 'message' => 'Gagal hapus'], 404);
    }

    // Ambil semua data studio untuk admin
    public function getStudiosAdmin()
    {
        try {
            $studios = DB::table('studio')->get();
            return response()->json(['success' => true, 'data' => $studios]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Ambil semua data ruangan untuk admin
    public function getRoomsAdmin()
    {
        try {
            $rooms = DB::table('ruangan')->get();
            return response()->json(['success' => true, 'data' => $rooms]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
