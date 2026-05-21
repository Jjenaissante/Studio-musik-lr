<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::with('ruangans')->get();
        return view('index', compact('studios'));
    }

    public function show($id)
    {
        $studio = Studio::with('ruangans')->findOrFail($id);
        return view('studio-detail', compact('studio'));
    }

    public function getStudios()
    {
        $studios = Studio::with('ruangans')->get();
        return response()->json(['success' => true, 'data' => $studios]);
    }

    public function getStudio($id)
    {
        $studio = Studio::with('ruangans')->find($id);
        if (!$studio) {
            return response()->json(['success' => false, 'message' => 'Studio not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $studio]);
    }
}
