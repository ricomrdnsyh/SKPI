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
        return redirect()->route('penilaian.index')->with('success', 'Sistem penilaian berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $query = DB::table('sistem_penilaian')->select('sistem_penilaian.*');

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                $editRoute = route('penilaian.edit', $row->id_penilaian);
                $deleteRoute = route('penilaian.destroy', $row->id_penilaian);
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
