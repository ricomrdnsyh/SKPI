<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriCpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KategoriCplController extends Controller
{
    public function index()
    {
        return view('admin.kategori_cpl.index');
    }

    public function create()
    {
        return view('admin.kategori_cpl.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:10|unique:kategori_cpl,kode_kategori',
            'nama_kategori' => 'required|string|max:255',
            'urutan' => 'nullable|integer|min:1|max:127',
        ]);

        KategoriCpl::create($request->only(['kode_kategori', 'nama_kategori', 'urutan']));

        return redirect()->route('kategori-cpl.index')->with('success', 'Kategori CPL berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $row = DB::table('kategori_cpl')->where('id_kategori', $id)->first();
        if (!$row) abort(404);
        $kategori = KategoriCpl::hydrate([(array) $row])->first();
        return view('admin.kategori_cpl.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $row = DB::table('kategori_cpl')->where('id_kategori', $id)->first();
        if (!$row) abort(404);
        $kategori = KategoriCpl::hydrate([(array) $row])->first();

        $request->validate([
            'kode_kategori' => 'required|string|max:10|unique:kategori_cpl,kode_kategori,' . $id . ',id_kategori',
            'nama_kategori' => 'required|string|max:255',
            'urutan' => 'nullable|integer|min:1|max:127',
        ]);

        $kategori->update($request->only(['kode_kategori', 'nama_kategori', 'urutan']));

        return redirect()->route('kategori-cpl.index')->with('success', 'Kategori CPL berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $row = DB::table('kategori_cpl')->where('id_kategori', $id)->first();
        if (!$row) abort(404);
        $kategori = KategoriCpl::hydrate([(array) $row])->first();

        $hasCpl = DB::table('cpl_prodi')->where('id_kategori', $id)->exists();
        if ($hasCpl) {
            return redirect()->route('kategori-cpl.index')->with('error', 'Kategori CPL tidak dapat dihapus karena masih digunakan oleh beberapa CPL Prodi.');
        }

        $kategori->delete();
        return redirect()->route('kategori-cpl.index')->with('success', 'Kategori CPL berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $query = DB::table('kategori_cpl')->select('kategori_cpl.*')->orderBy('urutan');

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                $editRoute = route('kategori-cpl.edit', $row->id_kategori);
                $deleteRoute = route('kategori-cpl.destroy', $row->id_kategori);
                return '<div class="flex justify-start gap-1">'
                    . '<a href="' . $editRoute . '" class="btn-edit"><i class="fa-solid fa-pen-to-square"></i></a>'
                    . '<form method="POST" action="' . $deleteRoute . '" onsubmit="return confirm(\'Yakin ingin menghapus kategori ini?\')">'
                    . csrf_field() . method_field('DELETE')
                    . '<button type="submit" class="btn-destroy"><i class="fa-solid fa-trash-can"></i></button>'
                    . '</form></div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
