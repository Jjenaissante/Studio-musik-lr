<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudioController extends Controller
{
    // Halaman homepage dengan data studio
    public function index()
    {
        return view('index');
    }

    // API: Daftar semua studio (public)
    public function getStudios()
    {
        try {
            $studios = DB::table('studio')->get();
            foreach ($studios as $studio) {
                $studio->ruangan = DB::table('ruangan')
                    ->where('id_studio', $studio->id_studio)
                    ->whereIn('status', ['available', 'maintenance'])
                    ->get();
            }
            return response()->json(['success' => true, 'data' => $studios]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // API: Ruangan berdasarkan studio (public)
    public function getRuangan(Request $request)
    {
        try {
            $query = DB::table('ruangan')->whereIn('status', ['available', 'maintenance']);
            if ($request->id_studio) {
                $query->where('id_studio', $request->id_studio);
            }
            $ruangan = $query->get();
            return response()->json(['success' => true, 'data' => $ruangan]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}