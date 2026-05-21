<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'nama_user' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return response()->json(['success' => true, 'message' => 'Profil berhasil diperbarui']);
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password saat ini salah'], 422);
        }

        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return response()->json(['success' => true, 'message' => 'Password berhasil diubah']);
    }
}
