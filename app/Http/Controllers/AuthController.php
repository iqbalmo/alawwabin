<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // <-- Tambahkan ini

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
            
            // 🚨 DIPERBAIKI: Redirect sesuai role user
            $user = Auth::user();
            
            if ($user->role === 'guru') {
                return redirect()->route('gurulog.index')->with('success', 'Berhasil login sebagai Guru');
            }
            
            // Default redirect ke home untuk role lainnya
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

    public function showPasswordForm()
    {
        return view('auth.password'); // Kita akan buat view ini
    }

    /**
     * Memproses perubahan password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi input
        $request->validate([
            'current_password' => [
                'required',
                // Cek apakah password saat ini cocok
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Password saat ini tidak cocok.');
                    }
                },
            ],
            'new_password' => 'required|string|min:8|confirmed', // 'confirmed' akan otomatis mencocokkan dengan 'new_password_confirmation'
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal harus 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // 2. Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('password.edit')->with('success', 'Password Anda telah berhasil diperbarui!');
    }
}