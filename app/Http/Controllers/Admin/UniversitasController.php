<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Universitas;
use Illuminate\Http\Request;

class UniversitasController extends Controller
{
    public function index()
    {
        $universitas = Universitas::first();
        if (!$universitas) {
            $universitas = Universitas::create([
                'nama_perguruan_tinggi' => 'Universitas Nurul Jadid',
            ]);
        }
        return view('admin.universitas.index', compact('universitas'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_perguruan_tinggi' => 'required|string|max:100',
            'sk_akreditasi' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:50',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $universitas = Universitas::first();
        if ($universitas) {
            $universitas->update($request->all());
        }

        return redirect()->route('universitas.index')->with('success', 'Data universitas berhasil diperbarui.');
    }
}
