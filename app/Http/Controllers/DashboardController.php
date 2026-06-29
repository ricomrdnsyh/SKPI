<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        return match ($user->role) {
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            'bak_fakultas' => redirect()->route('bak_fakultas.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('login')->with('error', 'Role tidak valid.'),
        };
    }
}
