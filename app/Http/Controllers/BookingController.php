<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function list(Request $request)
    {
        $query = Booking::with(['user', 'ruangan.studio', 'detail']);

        // IDOR Fix: Non-admin users can only see their own bookings
        if (Auth::user()->role !== 'admin') {
            $query->where('id_user', Auth::id());
        } elseif ($request->has('user_id')) {
            $query->where('id_user', $request->user_id);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status_booking', $request->status);
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')
                          ->orderBy('jam_mulai', 'desc')
                          ->get()
                          ->map(function($booking) {
                              return [
                                  'id_booking' => $booking->id_booking,
                                  'id_user' => $booking->id_user,
                                  'id_ruangan' => $booking->id_ruangan,
                                  'tanggal_booking' => $booking->tanggal_booking,
                                  'jam_mulai' => $booking->jam_mulai,
                                  'jam_selesai' => $booking->jam_selesai,
                                  'durasi' => $booking->durasi,
                                  'status_booking' => $booking->status_booking,
                                  'catatan' => $booking->catatan,
                                  'nama_user' => $booking->user->nama_user,
                                  'no_hp' => $booking->user->no_hp,
                                  'nama_studio' => $booking->ruangan->studio->nama_studio,
                                  'nama_ruangan' => $booking->ruangan->nama_ruangan,
                                  'total_bayar' => $booking->detail->total_bayar ?? 0,
                                  'status_pembayaran' => $booking->detail->status_pembayaran ?? 'pending',
                                  'bukti_pembayaran' => $booking->detail->bukti_pembayaran ?? null,
                              ];
                          });

        return response()->json(['success' => true, 'data' => $bookings]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_ruangan' => 'required',
            'tanggal_booking' => 'required|date',
            'jam_mulai' => 'required',
            'durasi' => 'required|integer',
            'catatan' => 'nullable|string',
        ]);

        $id_booking = 'BK' . substr(time(), -8);
        $jam_mulai = $validated['jam_mulai'];
        $durasi = $validated['durasi'];
        $jam_selesai = date('H:i', strtotime("$jam_mulai + $durasi hours"));

        // Validasi Double Booking
        $exists = Booking::where('id_ruangan', $validated['id_ruangan'])
            ->where('tanggal_booking', $validated['tanggal_booking'])
            ->where('status_booking', '!=', 'cancelled')
            ->where(function($query) use ($jam_mulai, $jam_selesai) {
                $query->where('jam_mulai', '<', $jam_selesai)
                      ->where('jam_selesai', '>', $jam_mulai);
            })->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Maaf, slot waktu ini sudah dibooking orang lain.'], 422);
        }

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'id_booking' => $id_booking,
                'id_user' => Auth::id(),
                'id_ruangan' => $validated['id_ruangan'],
                'tanggal_booking' => $validated['tanggal_booking'],
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'durasi' => $durasi,
                'status_booking' => 'pending',
                'catatan' => $validated['catatan'] ?? '',
            ]);

            $tarif = Ruangan::where('id_ruangan', $validated['id_ruangan'])->value('tarif_per_jam') ?? 0;
            $total_bayar = $tarif * $durasi;

            DetailBooking::create([
                'id_booking' => $id_booking,
                'total_bayar' => $total_bayar,
                'status_pembayaran' => 'pending',
            ]);

            DB::commit();
            return response()->json(['success' => true, 'data' => ['id_booking' => $id_booking]]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }

    public function uploadProof(Request $request)
    {
        $request->validate([
            'id_booking' => 'required',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $id_booking = $request->id_booking;
        $file = $request->file('bukti_pembayaran');

        $filename = 'proof_' . $id_booking . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('bukti_pembayaran'), $filename);

        $detail = DetailBooking::where('id_booking', $id_booking)->first();
        if ($detail) {
            $detail->update([
                'bukti_pembayaran' => $filename,
                'status_pembayaran' => 'waiting_verification'
            ]);
            return response()->json(['success' => true, 'message' => 'Bukti pembayaran berhasil diupload']);
        }

        return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
    }

    public function availableSlots(Request $request)
    {
        $id_ruangan = $request->query('id_ruangan');
        $date = $request->query('date');

        if (!$id_ruangan || !$date) {
            return response()->json(['success' => false, 'message' => 'Missing params'], 400);
        }

        $bookings = Booking::where('id_ruangan', $id_ruangan)
            ->where('tanggal_booking', $date)
            ->where('status_booking', '!=', 'cancelled')
            ->get();

        $booked_slots = $bookings->map(function($b) {
            return [
                'start' => substr($b->jam_mulai, 0, 5),
                'end' => substr($b->jam_selesai, 0, 5),
                'available' => false
            ];
        });

        return response()->json(['success' => true, 'data' => $booked_slots]);
    }
}
