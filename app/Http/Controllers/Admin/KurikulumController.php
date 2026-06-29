<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Traits\FilterByProdi;

class KurikulumController extends Controller
{
    use FilterByProdi;

    public function index()
    {
        $allowedProdis = $this->getAllowedProdiIds();
        $prodiList = $this->getProdiOptions($allowedProdis);
        return view('admin.kurikulum.index', compact('prodiList'));
    }

    public function create()
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis === null) {
            $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
        } else {
            $prodi = DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
        }

        return view('admin.kurikulum.create', compact('prodi'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($request->id_prodi, $allowedProdis)) {
            abort(403, 'Akses prodi tidak diizinkan.');
        }

        $request->validate([
            'id_prodi' => 'required|exists:program_studi,id_prodi',
            'nama_kurikulum' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:2099',
        ]);

        $existing = DB::table('kurikulum')->where('id_prodi', $request->id_prodi)
            ->where('tahun', $request->tahun)
            ->first();

        if ($existing) {
            return back()->withInput()->with('error', 'Kurikulum dengan tahun ' . $request->tahun . ' sudah ada untuk prodi ini.');
        }

        Kurikulum::create([
            'id_prodi' => $request->id_prodi,
            'nama_kurikulum' => $request->nama_kurikulum,
            'tahun' => $request->tahun,
        ]);

        return redirect()->route('kurikulum.index')->with('success', 'Data kurikulum berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $row = DB::table('kurikulum')->where('id_kurikulum', $id)->first();
        if (!$row) abort(404);
        $kurikulum = Kurikulum::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($kurikulum->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        if ($allowedProdis === null) {
            $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
        } else {
            $prodi = DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
        }

        return view('admin.kurikulum.edit', compact('kurikulum', 'prodi'));
    }

    public function update(Request $request, $id)
    {
        $row = DB::table('kurikulum')->where('id_kurikulum', $id)->first();
        if (!$row) abort(404);
        $kurikulum = Kurikulum::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($kurikulum->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        if ($allowedProdis !== null && !in_array($request->id_prodi, $allowedProdis)) {
            abort(403, 'Akses prodi tidak diizinkan.');
        }

        $request->validate([
            'id_prodi' => 'required|exists:program_studi,id_prodi',
            'nama_kurikulum' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:2099',
        ]);

        $existing = DB::table('kurikulum')->where('id_prodi', $request->id_prodi)
            ->where('tahun', $request->tahun)
            ->where('id_kurikulum', '!=', $id)
            ->first();

        if ($existing) {
            return back()->withInput()->with('error', 'Kurikulum dengan tahun ' . $request->tahun . ' sudah ada untuk prodi ini.');
        }

        $kurikulum->update([
            'id_prodi' => $request->id_prodi,
            'nama_kurikulum' => $request->nama_kurikulum,
            'tahun' => $request->tahun,
        ]);

        return redirect()->route('kurikulum.index')->with('success', 'Data kurikulum berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $row = DB::table('kurikulum')->where('id_kurikulum', $id)->first();
        if (!$row) abort(404);
        $kurikulum = Kurikulum::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($kurikulum->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        $kurikulum->delete();
        return redirect()->route('kurikulum.index')->with('success', 'Data kurikulum berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        $query = DB::table('kurikulum')
            ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
            ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama');

        if ($allowedProdis !== null) {
            $query->whereIn('kurikulum.id_prodi', $allowedProdis);
        }

        if ($request->filled('id_prodi')) {
            $query->where('kurikulum.id_prodi', $request->id_prodi);
        }

        return DataTables::of($query)
            ->addColumn('prodi', fn($k) => $k->prodi_nama ?? '-')
            ->addColumn('action', function ($row) {
                $editRoute = route('kurikulum.edit', $row->id_kurikulum);
                $deleteRoute = route('kurikulum.destroy', $row->id_kurikulum);
                return '<div class="flex justify-start gap-1">'
                    . '<a href="' . $editRoute . '" class="btn-edit"><i class="fa-solid fa-pen-to-square"></i></a>'
                    . '<form method="POST" action="' . $deleteRoute . '" onsubmit="return confirm(\'Yakin?\')">'
                    . csrf_field() . method_field('DELETE')
                    . '<button type="submit" class="btn-destroy"><i class="fa-solid fa-trash-can"></i></button>'
                    . '</form></div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
