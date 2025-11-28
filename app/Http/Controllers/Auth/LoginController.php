<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            // gunakan role jika dikirim untuk redirect berbeda
            $role = $request->input('role','user');
            return redirect()->intended($role === 'admin' ? '/admin' : '/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }
}