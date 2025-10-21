<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 🚨 DIPERBAIKI: Menambahkan logika untuk checkbox "Ingat Saya"
        $remember = $request->boolean('remember-me');

        if (Auth::attempt($credentials, $remember)) {
            // 🚨 DIPERBAIKI: Regenerasi session untuk keamanan (mencegah session fixation)
            $request->session()->regenerate();
            
            // 🚨 DIPERBAIKI: Redirect ke halaman yang dituju sebelumnya, atau ke 'home'
            return redirect()->intended(route('home'))->with('success', 'Berhasil login');
        }

        // 🚨 DIPERBAIKI: Kembali dengan pesan error DAN mengisi kembali input email
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session dan regenerate token untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
