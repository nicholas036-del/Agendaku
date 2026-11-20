<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menangani proses autentikasi login.
     */
    public function authenticate(Request $request)
    {
        // 1. Validasi input form (menggunakan 'username' sesuai tampilan UI)
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 2. Cek kredensial ke database menggunakan kolom 'username'
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            // 3. Redirect ke halaman dashboard sesuai role
            $user = Auth::user();
            if ($user->role === 'student') {
                return redirect()->route('students.index');
            } elseif ($user->role === 'teacher') {
                return redirect()->route('teachers.index');
            } elseif ($user->role === 'council') {
                return redirect()->route('council.index');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.index');
            } else {
                Auth::logout();
                return back()->withErrors(['username' => 'Role tidak dikenali.']);
            }
        }

        // 4. JIKA GAGAL: Kembalikan ke halaman login dengan pesan error & pertahankan input username
        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->onlyInput('username');
    }
}