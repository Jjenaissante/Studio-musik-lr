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
    public function store(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required',
            'tanggal_booking' => 'required|date',
            'jam_mulai' => 'required',
            'durasi' => 'required|integer|min:1',
        ]);

        $id_ruangan = $request->id_ruangan;
        $tgl = $request->tanggal_booking;
        $jam = $request->jam_mulai;
        $durasi = $request->durasi;
        $catatan = $request->catatan ?? '';

        $jam_selesai = date('H:i', strtotime("$jam + $durasi hours"));

        // Validasi Double Booking
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
        $id_user = Auth::id() ?? $request->id_user; // Fallback for testing or if user id is passed

        if (!$id_user) {
            return response()->json(['success' => false, 'message' => 'User not logged in'], 401);
        }

        try {
            DB::beginTransaction();

            $booking = Booking::create([
                'id_booking' => $id_booking,
                'id_user' => $id_user,
                'id_ruangan' => $id_ruangan,
                'tanggal_booking' => $tgl,
                'jam_mulai' => $jam,
                'jam_selesai' => $jam_selesai,
                'durasi' => $durasi,
                'status_booking' => 'pending',
                'catatan' => $catatan,
            ]);

            $ruangan = Ruangan::find($id_ruangan);
            $tarif = $ruangan->tarif_per_jam ?? 0;
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

    public function userBookings(Request $request)
    {
        $user_id = Auth::id() ?? $request->user_id;
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
                'status_pembayaran' => 'waiting_verification',
            ]);
            return response()->json(['success' => true, 'message' => 'Bukti pembayaran berhasil diupload']);
        }

        return response()->json(['success' => false, 'message' => 'Booking detail not found'], 404);
    }

    public function availableSlots(Request $request)
    {
        $id_ruangan = $request->id_ruangan;
        $date = $request->date;

        if (!$id_ruangan || !$date) {
            return response()->json(['success' => false, 'message' => 'Missing params'], 400);
        }

        $bookings = Booking::where('id_ruangan', $id_ruangan)
            ->where('tanggal_booking', $date)
            ->where('status_booking', '!=', 'cancelled')
            ->get(['jam_mulai', 'jam_selesai']);

        $booked_slots = $bookings->map(function ($b) {
            return [
                'start' => substr($b->jam_mulai, 0, 5),
                'end' => substr($b->jam_selesai, 0, 5),
                'available' => false
            ];
        });

        return response()->json(['success' => true, 'data' => $booked_slots]);
    }

    public function history()
    {
        return view('history');
    }

    public function calendar()
    {
        return view('calendar');
    }
}
