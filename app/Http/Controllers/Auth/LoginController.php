<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Mengautentikasi pengguna
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Jika berhasil, redirect ke halaman tugas
            return redirect()->route('tasks.index')->with('success', 'Login successful');
        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Logout pengguna
    public function logout(Request $request)
{
    Auth::logout(); // Menghapus sesi pengguna
    $request->session()->invalidate(); // Menghancurkan sesi
    $request->session()->regenerateToken(); // Menghasilkan token CSRF baru untuk menghindari serangan

    return redirect()->route('login')->with('success', 'Logged out successfully');
}
}
