<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::with('ruangan')->get();
        return response()->json([
            'success' => true,
            'data' => $studios
        ]);
    }

    public function show($id)
    {
        $studio = Studio::with('ruangan')->find($id);
        if ($studio) {
            return response()->json([
                'success' => true,
                'data' => $studio
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Studio not found'], 404);
    }

    public function updateRoom(Request $request)
    {
        $validated = $request->validate([
            'id_ruangan' => 'required|string',
            'nama_ruangan' => 'required|string',
            'kapasitas' => 'required|integer',
            'tarif' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $ruangan = Ruangan::find($validated['id_ruangan']);
        if ($ruangan) {
            $ruangan->update([
                'nama_ruangan' => $validated['nama_ruangan'],
                'kapasitas' => $validated['kapasitas'],
                'tarif_per_jam' => $validated['tarif'],
                'status' => $validated['status'],
            ]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Room not found'], 404);
    }

    public function deleteRoom(Request $request)
    {
        $id = $request->input('id_ruangan');
        $ruangan = Ruangan::find($id);
        if ($ruangan) {
            $ruangan->delete();
            return response()->json(['success' => true, 'message' => 'Terhapus']);
        }
        return response()->json(['success' => false, 'message' => 'Gagal hapus'], 404);
    }
}
