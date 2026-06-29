<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('web')->check() || Auth::guard('mahasiswa')->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $username = $request->username;
        $password = $request->password;

        if (Auth::guard('web')->attempt(['username' => $username, 'password' => $password])) {
            $user = Auth::guard('web')->user();
            if (!$user->aktif) {
                Auth::guard('web')->logout();
                return back()->withErrors(['username' => 'Akun Anda dinonaktifkan.'])->onlyInput('username');
            }
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        if (Auth::guard('mahasiswa')->attempt(['nim' => $username, 'password' => $password])) {
            $mahasiswa = Auth::guard('mahasiswa')->user();
            if ($mahasiswa->status !== 'Aktif' && $mahasiswa->status !== 'Lulus') {
                Auth::guard('mahasiswa')->logout();
                return back()->withErrors(['username' => 'Akun Anda dinonaktifkan.'])->onlyInput('username');
            }
            $request->session()->regenerate();
            Auth::shouldUse('mahasiswa');
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'username' => 'Username atau password salah, atau akun Anda dinonaktifkan.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('mahasiswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
