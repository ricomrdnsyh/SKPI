<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use App\Http\Controllers\Traits\FilterByProdi;

class FakultasController extends Controller
{
    use FilterByProdi;

    public function index()
    {
        return view('admin.fakultas.index');
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }
        return view('admin.fakultas.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }
        $request->validate([
            'nama_fakultas' => 'required|string|max:255',
            'kode_fakultas' => 'nullable|string|max:10',
            'dekan' => 'nullable|string|max:100',
            'nidn_dekan' => 'nullable|string|max:50',
        ]);

        $data = $request->only(['nama_fakultas', 'kode_fakultas', 'dekan', 'nidn_dekan']);
        Fakultas::create($data);

        Cache::forget('master:fakultas');
        return redirect()->route('fakultas.index')->with('success', 'Data fakultas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $allowedFakultas = $this->getAllowedFakultasIds();
        if ($allowedFakultas !== null && !in_array($id, $allowedFakultas)) {
            abort(403, 'Akses ditolak.');
        }

        $row = DB::table('fakultas')->where('id_fakultas', $id)->first();
        if (!$row) abort(404);
        $fakultas = Fakultas::hydrate([(array) $row])->first();
        return view('admin.fakultas.edit', compact('fakultas'));
    }

    public function update(Request $request, $id)
    {
        $allowedFakultas = $this->getAllowedFakultasIds();
        if ($allowedFakultas !== null && !in_array($id, $allowedFakultas)) {
            abort(403, 'Akses ditolak.');
        }

        $row = DB::table('fakultas')->where('id_fakultas', $id)->first();
        if (!$row) abort(404);
        $fakultas = Fakultas::hydrate([(array) $row])->first();

        $request->validate([
            'nama_fakultas' => 'required|string|max:255',
            'kode_fakultas' => 'nullable|string|max:10',
            'dekan' => 'nullable|string|max:100',
            'nidn_dekan' => 'nullable|string|max:50',
        ]);

        $data = $request->only(['nama_fakultas', 'kode_fakultas', 'dekan', 'nidn_dekan']);
        $fakultas->update($data);

        Cache::forget('master:fakultas');
        return redirect()->route('fakultas.index')->with('success', 'Data fakultas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }
        $row = DB::table('fakultas')->where('id_fakultas', $id)->first();
        if (!$row) abort(404);
        $fakultas = Fakultas::hydrate([(array) $row])->first();
        $fakultas->delete();
        Cache::forget('master:fakultas');
        return redirect()->route('fakultas.index')->with('success', 'Data fakultas berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $query = DB::table('fakultas');

        $allowedFakultas = $this->getAllowedFakultasIds();
        if ($allowedFakultas !== null) {
            $query->whereIn('id_fakultas', $allowedFakultas);
        }

        return DataTables::of($query)
            ->addColumn('kode', fn($f) => $f->kode_fakultas ?? '-')
            ->addColumn('action', function ($row) {
                $editRoute = route('fakultas.edit', $row->id_fakultas);
                $deleteRoute = route('fakultas.destroy', $row->id_fakultas);
                $html = '<div class="flex justify-start gap-1">'
                    . '<a href="' . $editRoute . '" class="btn-edit"><i class="fa-solid fa-pen-to-square"></i></a>';
                
                if (Auth::user()->role === 'admin') {
                    $html .= '<form method="POST" action="' . $deleteRoute . '" onsubmit="return confirm(\'Yakin?\')">'
                        . csrf_field() . method_field('DELETE')
                        . '<button type="submit" class="btn-destroy"><i class="fa-solid fa-trash-can"></i></button>'
                        . '</form>';
                }
                
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
