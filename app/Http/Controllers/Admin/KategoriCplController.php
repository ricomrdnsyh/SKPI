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
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Kategori CPL tidak dapat dihapus karena masih digunakan oleh beberapa CPL Prodi.'], 400);
            }
            return redirect()->route('kategori-cpl.index')->with('error', 'Kategori CPL tidak dapat dihapus karena masih digunakan oleh beberapa CPL Prodi.');
        }

        $kategori->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Kategori CPL berhasil dihapus.']);
        }
        return redirect()->route('kategori-cpl.index')->with('success', 'Kategori CPL berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $query = DB::table('kategori_cpl')->select('kategori_cpl.*')->orderBy('urutan');

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="'.$rowJson.'" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a>' . ' ' . '<a href="javascript:void(0)" onclick="editModal(this)" data-row="'.$rowJson.'" class="btn btn-sm btn-light btn-active-light-warning text-center" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></a>' . ' ' . '<button type="button" onclick="confirmDelete(\'' . $row->id_kategori . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>' . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
