<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SistemPenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SistemPenilaianController extends Controller
{
    public function index()
    {
        $nilaiHurufOptions = DB::table('sistem_penilaian')->select('nilai_huruf')->distinct()->pluck('nilai_huruf')->sort()->values();
        return view('admin.penilaian.index', compact('nilaiHurufOptions'));
    }

    public function create()
    {
        return view('admin.penilaian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nilai_huruf' => 'required|string|max:5|unique:sistem_penilaian,nilai_huruf',
            'nilai_min' => 'required|numeric|between:0,100',
            'nilai_max' => 'required|numeric|between:0,100|gte:nilai_min',
        ]);

        SistemPenilaian::create($request->all());

        return redirect()->route('penilaian.index')->with('success', 'Sistem penilaian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $row = DB::table('sistem_penilaian')->where('id_penilaian', $id)->first();
        if (!$row) abort(404);
        $penilaian = SistemPenilaian::hydrate([(array) $row])->first();
        return view('admin.penilaian.edit', compact('penilaian'));
    }

    public function update(Request $request, $id)
    {
        $row = DB::table('sistem_penilaian')->where('id_penilaian', $id)->first();
        if (!$row) abort(404);
        $penilaian = SistemPenilaian::hydrate([(array) $row])->first();

        $request->validate([
            'nilai_huruf' => 'required|string|max:5|unique:sistem_penilaian,nilai_huruf,' . $id . ',id_penilaian',
            'nilai_min' => 'required|numeric|between:0,100',
            'nilai_max' => 'required|numeric|between:0,100|gte:nilai_min',
        ]);

        $penilaian->update($request->all());

        return redirect()->route('penilaian.index')->with('success', 'Sistem penilaian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $row = DB::table('sistem_penilaian')->where('id_penilaian', $id)->first();
        if (!$row) abort(404);
        $penilaian = SistemPenilaian::hydrate([(array) $row])->first();
        $penilaian->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Sistem penilaian berhasil dihapus.']);
        }
        return redirect()->route('penilaian.index')->with('success', 'Sistem penilaian berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $query = DB::table('sistem_penilaian')->select('sistem_penilaian.*');

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="'.$rowJson.'" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a>' . ' ' . '<a href="javascript:void(0)" onclick="editModal(this)" data-row="'.$rowJson.'" class="btn btn-sm btn-light btn-active-light-warning text-center" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></a>' . ' ' . '<button type="button" onclick="confirmDelete(\'' . $row->id_penilaian . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>' . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
