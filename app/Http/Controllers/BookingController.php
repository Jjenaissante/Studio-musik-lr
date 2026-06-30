<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Ruangan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // =============================
    // TAMPILKAN HALAMAN RIWAYAT
    // =============================
    public function history()
    {
        return view('history');
    }

    // =============================
    // TAMPILKAN HALAMAN KALENDER (PUBLIC - tidak perlu login)
    // =============================
    public function calendar()
    {
        return view('calendar');
    }

    // =============================
    // API: BUAT BOOKING BARU
    // Perlu login (dicek via middleware)
    // =============================
    public function store(Request $request)
    {
        $request->validate([
            'id_ruangan'      => 'required',
            'tanggal_booking' => 'required|date',
            'jam_mulai'       => 'required',
            'durasi'          => 'required|integer|min:1',
            'email'           => 'nullable|email',
            'no_hp'           => 'nullable|max:15',
        ]);

        $id_ruangan = $request->id_ruangan;
        $tgl        = $request->tanggal_booking;
        $jam        = $request->jam_mulai;
        $durasi     = $request->durasi;
        $catatan    = $request->catatan ?? '';
        $email      = $request->email ?? session('user_email', '');
        $no_hp      = $request->no_hp;

        // Validasi status ruangan
        $ruangan = Ruangan::find($id_ruangan);
        if (!$ruangan) {
            return response()->json(['success' => false, 'message' => 'Ruangan tidak ditemukan.']);
        }
        if ($ruangan->status === 'maintenance') {
            return response()->json(['success' => false, 'message' => 'Maaf, ruangan ini sedang dalam perawatan/maintenance.']);
        }
        if ($ruangan->status === 'unavailable') {
            return response()->json(['success' => false, 'message' => 'Maaf, ruangan ini tidak tersedia.']);
        }

        $jam_selesai = date('H:i', strtotime("$jam + $durasi hours"));

        // Cek double booking
        $exists = Booking::where('id_ruangan', $id_ruangan)
            ->where('tanggal_booking', $tgl)
            ->where('status_booking', '!=', 'cancelled')
            ->where(function ($query) use ($jam, $jam_selesai) {
                $query->where(function ($q) use ($jam, $jam_selesai) {
                    $q->where('jam_mulai', '<', $jam_selesai)
                      ->where('jam_selesai', '>', $jam);
                });
            })->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Maaf, slot waktu ini sudah dibooking orang lain.']);
        }

        $id_booking = 'BK' . substr(time(), -8);
        $id_user    = session('user_id');

        if (!$id_user) {
            return response()->json(['success' => false, 'message' => 'User not logged in'], 401);
        }

        try {
            DB::beginTransaction();

            Booking::create([
                'id_booking'      => $id_booking,
                'id_user'         => $id_user,
                'id_ruangan'      => $id_ruangan,
                'tanggal_booking' => $tgl,
                'jam_mulai'       => $jam,
                'jam_selesai'     => $jam_selesai,
                'durasi'          => $durasi,
                'status_booking'  => 'pending',
                'catatan'         => $catatan,
            ]);

            // Update email & no_hp user jika diberikan
            $userUpdate = [];
            if ($email && $email !== session('user_email')) {
                $userUpdate['email'] = $email;
            }
            if ($no_hp) {
                $userUpdate['no_hp'] = $no_hp;
            }
            if (!empty($userUpdate)) {
                DB::table('user')->where('id_user', $id_user)->update($userUpdate);
            }

            $ruangan    = Ruangan::find($id_ruangan);
            $tarif      = $ruangan->tarif_per_jam ?? 0;
            $total_bayar = $tarif * $durasi;

            DetailBooking::create([
                'id_booking'        => $id_booking,
                'total_bayar'       => $total_bayar,
                'status_pembayaran' => 'pending',
            ]);

            // Trigger Notifikasi Booking Baru
            Notifikasi::create([
                'id_user' => $id_user,
                'judul'   => 'Booking Baru Dibuat',
                'pesan'   => 'Booking #' . $id_booking . ' berhasil dibuat. Silakan lakukan pembayaran sebesar Rp ' . number_format($total_bayar, 0, ',', '.') . '.',
                'tipe'    => 'booking_created',
                'is_read' => false,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => [
                    'id_booking' => $id_booking,
                    'total_bayar' => $total_bayar
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }

    // =============================
    // API: BOOKING USER YANG LOGIN
    // =============================
    public function userBookings(Request $request)
    {
        $user_id = session('user_id');
        if (!$user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $query = Booking::with(['user', 'ruangan.studio', 'detailBooking'])
            ->where('id_user', $user_id);

        if ($request->status) {
            $query->where('status_booking', $request->status);
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->get()
            ->map(function ($b) {
                return [
                    'id_booking'       => $b->id_booking,
                    'id_user'          => $b->id_user,
                    'nama_user'        => optional($b->user)->nama_user,
                    'no_hp'            => optional($b->user)->no_hp,
                    'nama_studio'      => optional(optional($b->ruangan)->studio)->nama_studio,
                    'nama_ruangan'     => optional($b->ruangan)->nama_ruangan,
                    'tanggal_booking'  => $b->tanggal_booking,
                    'jam_mulai'        => $b->jam_mulai,
                    'jam_selesai'      => $b->jam_selesai,
                    'durasi'           => $b->durasi,
                    'status_booking'   => $b->status_booking,
                    'total_bayar'      => optional($b->detailBooking)->total_bayar ?? 0,
                    'status_pembayaran'=> optional($b->detailBooking)->status_pembayaran ?? null,
                    'bukti_pembayaran' => optional($b->detailBooking)->bukti_pembayaran ?? null,
                    'catatan'          => $b->catatan,
                ];
            });

        return response()->json(['success' => true, 'data' => $bookings]);
    }

    // =============================
    // API: UPLOAD BUKTI PEMBAYARAN
    // =============================
    public function uploadProof(Request $request)
    {
        $request->validate([
            'id_booking'       => 'required',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // Diperluas hingga 10MB agar aman untuk foto HP resolusi tinggi
        ]);

        $id_booking = $request->id_booking;
        $user_id    = session('user_id');

        // Pastikan booking milik user yang login
        $booking = Booking::where('id_booking', $id_booking)
            ->where('id_user', $user_id)
            ->first();

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan.'], 404);
        }

        $file     = $request->file('bukti_pembayaran');
        $filename = 'proof_' . $id_booking . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('bukti_pembayaran'), $filename);

        $detail = DetailBooking::where('id_booking', $id_booking)->first();
        if ($detail) {
            $detail->update([
                'bukti_pembayaran' => $filename,
                'status_pembayaran' => 'waiting_verification',
            ]);

            // Trigger Notifikasi Bukti Upload
            Notifikasi::create([
                'id_user' => $user_id,
                'judul'   => 'Bukti Pembayaran Diunggah',
                'pesan'   => 'Bukti pembayaran untuk Booking #' . $id_booking . ' berhasil diunggah. Menunggu verifikasi admin.',
                'tipe'    => 'payment_pending',
                'is_read' => false,
            ]);

            return response()->json(['success' => true, 'message' => 'Bukti pembayaran berhasil diupload']);
        }

        return response()->json(['success' => false, 'message' => 'Detail booking tidak ditemukan'], 404);
    }

    // =============================
    // API: SLOT TERSEDIA (PUBLIC - untuk kalender)
    // =============================
    public function availableSlots(Request $request)
    {
        $id_ruangan = $request->id_ruangan;
        $date       = $request->date;

        if (!$id_ruangan || !$date) {
            return response()->json(['success' => false, 'message' => 'Parameter kurang'], 400);
        }

        $bookings = Booking::where('id_ruangan', $id_ruangan)
            ->where('tanggal_booking', $date)
            ->where('status_booking', '!=', 'cancelled')
            ->get(['jam_mulai', 'jam_selesai']);

        $booked_slots = $bookings->map(function ($b) {
            return [
                'start'     => substr($b->jam_mulai, 0, 5),
                'end'       => substr($b->jam_selesai, 0, 5),
                'available' => false,
            ];
        });

        return response()->json(['success' => true, 'data' => $booked_slots]);
    }

    // =============================
    // API: SEMUA BOOKING UNTUK KALENDER (PUBLIC)
    // =============================
    public function calendarBookings(Request $request)
    {
        $query = Booking::with(['ruangan.studio'])
            ->where('status_booking', '!=', 'cancelled');

        if ($request->id_studio) {
            $query->whereHas('ruangan', function ($q) use ($request) {
                $q->where('id_studio', $request->id_studio);
            });
        }

        if ($request->month && $request->year) {
            $query->whereMonth('tanggal_booking', $request->month)
                  ->whereYear('tanggal_booking', $request->year);
        }

        $bookings = $query->orderBy('tanggal_booking')->get()->map(function ($b) {
            return [
                'id_booking'      => $b->id_booking,
                'nama_studio'     => optional(optional($b->ruangan)->studio)->nama_studio,
                'nama_ruangan'    => optional($b->ruangan)->nama_ruangan,
                'tanggal_booking' => $b->tanggal_booking,
                'jam_mulai'       => substr($b->jam_mulai, 0, 5),
                'jam_selesai'     => substr($b->jam_selesai, 0, 5),
                'status_booking'  => $b->status_booking,
            ];
        });

        return response()->json(['success' => true, 'data' => $bookings]);
    }

    // =============================
    // API: BATALKAN BOOKING (USER)
    // =============================
    public function cancelBooking(Request $request)
    {
        $request->validate([
            'id_booking' => 'required',
        ]);

        $id_booking = $request->id_booking;
        $user_id    = session('user_id');

        if (!$user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        try {
            DB::beginTransaction();

            $booking = Booking::where('id_booking', $id_booking)
                ->where('id_user', $user_id)
                ->first();

            if (!$booking) {
                return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan.'], 404);
            }

            if ($booking->status_booking !== 'pending') {
                return response()->json(['success' => false, 'message' => 'Hanya booking berstatus pending yang dapat dibatalkan.'], 422);
            }

            // Update status booking ke cancelled
            $booking->update([
                'status_booking' => 'cancelled',
            ]);

            // Update status pembayaran ke cancelled jika ada
            DetailBooking::where('id_booking', $id_booking)->update([
                'status_pembayaran' => 'cancelled',
            ]);

            // Trigger Notifikasi Batal oleh User
            Notifikasi::create([
                'id_user' => $user_id,
                'judul'   => 'Booking Dibatalkan',
                'pesan'   => 'Booking #' . $id_booking . ' telah berhasil Anda batalkan.',
                'tipe'    => 'booking_cancel_user',
                'is_read' => false,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Booking berhasil dibatalkan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal membatalkan booking: ' . $e->getMessage()], 500);
        }
    }
}
