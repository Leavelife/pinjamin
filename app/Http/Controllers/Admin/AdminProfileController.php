<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'prodi' => 'nullable|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'nullable|string',
            'foto_profile' => 'nullable|image'
        ]);

        if ($request->hasFile('foto_profile')) {
            $fileName = time().'.'.$request->foto_profile->extension();
            $request->foto_profile->storeAs('profile', $fileName, 'public');
            $user->foto_profile = $fileName;
        }

        $user->update($request->only('name','prodi','email','no_hp'));

        return response()->json(['message' => 'Profile admin diperbarui']);
    }
}
