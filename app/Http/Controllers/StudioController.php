<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Baris ini wajib ada untuk akses database

class StudioController extends Controller
{
    public function index()
    {
        // Ambil data dari tabel studio kamu (pastikan nama tabelnya benar)
        $studios = DB::table('studio')->get();

        // Kirim datanya ke file index.blade.php
        return view('index', ['studio' => $studios]);
    }
}   