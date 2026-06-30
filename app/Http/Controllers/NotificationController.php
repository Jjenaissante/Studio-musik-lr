<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotificationController extends Controller
{
    // Mengambil semua notifikasi milik user yang sedang login
    public function getNotifications(Request $request)
    {
        $userId = session('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        // Ambil 20 notifikasi terbaru
        $notifications = Notifikasi::where('id_user', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'judul' => $n->judul,
                    'pesan' => $n->pesan,
                    'tipe' => $n->tipe,
                    'is_read' => $n->is_read,
                    'time_ago' => $n->created_at->diffForHumans(),
                    'created_at' => $n->created_at->format('d M Y H:i'),
                ];
            });

        // Hitung jumlah notifikasi yang belum dibaca
        $unreadCount = Notifikasi::where('id_user', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    // Menandai notifikasi sebagai sudah dibaca (bisa semua atau spesifik id)
    public function markAsRead(Request $request)
    {
        $userId = session('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $query = Notifikasi::where('id_user', $userId);

        if ($request->has('id')) {
            $query->where('id', $request->id);
        } else {
            $query->where('is_read', false);
        }

        $query->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai dibaca.',
        ]);
    }
}
