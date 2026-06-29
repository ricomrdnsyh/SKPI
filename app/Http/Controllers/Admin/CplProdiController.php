<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CplProdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Traits\FilterByProdi;

class CplProdiController extends Controller
{
    use FilterByProdi;

    public function index()
    {
        $allowedProdis = $this->getAllowedProdiIds();
        $prodiList = $this->getProdiOptions($allowedProdis);

        if ($allowedProdis === null) {
            $kurikulumList = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->get();
        } else {
            $kurikulumList = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->whereIn('kurikulum.id_prodi', $allowedProdis)
                ->get();
        }

        return view('admin.cpl.index', compact('prodiList', 'kurikulumList'));
    }

    public function create()
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis === null) {
            $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->orderBy('tahun', 'desc')
                ->get();
        } else {
            $prodi = DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->whereIn('kurikulum.id_prodi', $allowedProdis)
                ->orderBy('tahun', 'desc')
                ->get();
        }
        $kategori = DB::table('kategori_cpl')->select('id_kategori', 'kode_kategori', 'nama_kategori', 'urutan')->orderBy('urutan')->get();
        return view('admin.cpl.create', compact('prodi', 'kurikulums', 'kategori'));
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
            'id_kurikulum' => 'required|exists:kurikulum,id_kurikulum',
            'id_kategori' => 'required|exists:kategori_cpl,id_kategori',
            'kode_cpl' => 'required|string|max:20',
            'deskripsi_cpl' => 'required|string',
            'urutan' => 'nullable|integer',
        ]);

        CplProdi::create($request->all());

        return redirect()->route('cpl.index')->with('success', 'Data CPL Prodi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $row = DB::table('cpl_prodi')->where('id_cpl', $id)->first();
        if (!$row) abort(404);
        $cpl = CplProdi::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($cpl->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        if ($allowedProdis === null) {
            $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->orderBy('tahun', 'desc')
                ->get();
        } else {
            $prodi = DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->whereIn('kurikulum.id_prodi', $allowedProdis)
                ->orderBy('tahun', 'desc')
                ->get();
        }
        $kategori = DB::table('kategori_cpl')->select('id_kategori', 'kode_kategori', 'nama_kategori', 'urutan')->orderBy('urutan')->get();
        return view('admin.cpl.edit', compact('cpl', 'prodi', 'kurikulums', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $row = DB::table('cpl_prodi')->where('id_cpl', $id)->first();
        if (!$row) abort(404);
        $cpl = CplProdi::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($cpl->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        if ($allowedProdis !== null && !in_array($request->id_prodi, $allowedProdis)) {
            abort(403, 'Akses prodi tidak diizinkan.');
        }

        $request->validate([
            'id_prodi' => 'required|exists:program_studi,id_prodi',
            'id_kurikulum' => 'required|exists:kurikulum,id_kurikulum',
            'id_kategori' => 'required|exists:kategori_cpl,id_kategori',
            'kode_cpl' => 'required|string|max:20',
            'deskripsi_cpl' => 'required|string',
            'urutan' => 'nullable|integer',
        ]);

        $cpl->update($request->all());

        return redirect()->route('cpl.index')->with('success', 'Data CPL Prodi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $row = DB::table('cpl_prodi')->where('id_cpl', $id)->first();
        if (!$row) abort(404);
        $cpl = CplProdi::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($cpl->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        $cpl->delete();
        return redirect()->route('cpl.index')->with('success', 'Data CPL Prodi berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        $query = DB::table('cpl_prodi')
            ->leftJoin('program_studi', 'cpl_prodi.id_prodi', '=', 'program_studi.id_prodi')
            ->leftJoin('kurikulum', 'cpl_prodi.id_kurikulum', '=', 'kurikulum.id_kurikulum')
            ->leftJoin('kategori_cpl', 'cpl_prodi.id_kategori', '=', 'kategori_cpl.id_kategori')
            ->select(
                'cpl_prodi.*',
                'program_studi.nama_prodi as prodi_nama',
                'kurikulum.nama_kurikulum as kurikulum_nama',
                'kategori_cpl.nama_kategori as kategori_nama'
            );

        if ($allowedProdis !== null) {
            $query->whereIn('cpl_prodi.id_prodi', $allowedProdis);
        }

        if ($request->filled('id_prodi')) {
            $query->where('cpl_prodi.id_prodi', $request->id_prodi);
        }
        if ($request->filled('id_kurikulum')) {
            $query->where('cpl_prodi.id_kurikulum', $request->id_kurikulum);
        }

        return DataTables::of($query)
            ->addColumn('prodi', fn($c) => $c->prodi_nama ?? '-')
            ->addColumn('kurikulum', fn($c) => $c->kurikulum_nama ?? '-')
            ->addColumn('kategori', fn($c) => $c->kategori_nama ?? '-')
            ->addColumn('deskripsi', fn($c) => Str::limit($c->deskripsi_cpl, 50))
            ->addColumn('action', function ($row) {
                $editRoute = route('cpl.edit', $row->id_cpl);
                $deleteRoute = route('cpl.destroy', $row->id_cpl);
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
