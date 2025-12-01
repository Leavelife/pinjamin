<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function me()
    {
        return response()->json(Auth::user());
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255|unique:users,email,' . $user->id,
            'prodi' => 'string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto_profile' => 'nullable|image|max:2048',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('foto_profile')) {
            $path = $request->file('foto_profile')->store('profile', 'public');
            $user->foto_profile = $path;
        }

        // Update sesuai kolom database
        $user->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'prodi'         => $request->prodi,
            'no_hp'         => $request->no_hp,
            'foto_profile'  => $user->foto_profile, // tetap path hasil upload
        ]);

        return redirect()->route('profile.view.page')->with('success', 'Profil berhasil diperbarui!');
    }

}
