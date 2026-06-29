<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use App\Http\Controllers\Traits\FilterByProdi;

class ProgramStudiController extends Controller
{
    use FilterByProdi;

    public function index()
    {
        $allowedProdis = $this->getAllowedProdiIds();
        
        $jenjangQuery = DB::table('program_studi');
        if ($allowedProdis !== null) {
            $jenjangQuery->whereIn('id_prodi', $allowedProdis);
        }
        $jenjangOptions = $jenjangQuery->select('jenjang')->distinct()->pluck('jenjang')->sort()->values();

        $allowedFakultas = $this->getAllowedFakultasIds();
        $fakultasQuery = DB::table('fakultas');
        if ($allowedFakultas !== null) {
            $fakultasQuery->whereIn('id_fakultas', $allowedFakultas);
        }
        $fakultasOptions = $fakultasQuery->pluck('nama_fakultas')->sort()->values();

        return view('admin.prodi.index', compact('jenjangOptions', 'fakultasOptions'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }
        $fakultas = DB::table('fakultas')->select('id_fakultas', 'nama_fakultas')->get();
        return view('admin.prodi.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }
        $request->validate([
            'id_fakultas' => 'required|exists:fakultas,id_fakultas',
            'nama_prodi' => 'required|string|max:255',
            'kode_prodi' => 'nullable|string|max:10',
            'jenjang' => 'required|in:D3,S1,S2,S3',
            'gelar' => 'nullable|string|max:50',
            'sk_akreditasi' => 'nullable|string|max:100',
            'tanggal_sk_akreditasi' => 'nullable|date',
            'masa_berlaku_akreditasi' => 'nullable|date',
            'jenjang_kkni' => 'nullable|string|max:10',
            'bahasa_pengantar' => 'nullable|string|max:50',
            'lama_studi' => 'nullable|string|max:50',
            'jenis_pendidikan' => 'nullable|string|max:100',
            'jenis_pendidikan_lanjutan' => 'nullable|string|max:100',
            'persyaratan_penerimaan' => 'nullable|string',
            'alamat_prodi' => 'nullable|string',
            'telepon_prodi' => 'nullable|string|max:20',
            'email_prodi' => 'nullable|email|max:100',
        ]);

        ProgramStudi::create($request->all());

        Cache::forget('master:program_studi');
        Cache::forget('master:prodi_options');
        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $allowedProdis = $this->getAllowedProdiIds();
        if ($allowedProdis !== null && !in_array($id, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        $row = DB::table('program_studi')->where('id_prodi', $id)->first();
        if (!$row) abort(404);
        $prodi = ProgramStudi::hydrate([(array) $row])->first();
        $fakultas = DB::table('fakultas')->select('id_fakultas', 'nama_fakultas')->get();
        return view('admin.prodi.edit', compact('prodi', 'fakultas'));
    }

    public function update(Request $request, $id)
    {
        $allowedProdis = $this->getAllowedProdiIds();
        if ($allowedProdis !== null && !in_array($id, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        $row = DB::table('program_studi')->where('id_prodi', $id)->first();
        if (!$row) abort(404);
        $prodi = ProgramStudi::hydrate([(array) $row])->first();

        $request->validate([
            'id_fakultas' => 'required|exists:fakultas,id_fakultas',
            'nama_prodi' => 'required|string|max:255',
            'kode_prodi' => 'nullable|string|max:10',
            'jenjang' => 'required|in:D3,S1,S2,S3',
            'gelar' => 'nullable|string|max:50',
            'sk_akreditasi' => 'nullable|string|max:100',
            'tanggal_sk_akreditasi' => 'nullable|date',
            'masa_berlaku_akreditasi' => 'nullable|date',
            'jenjang_kkni' => 'nullable|string|max:10',
            'bahasa_pengantar' => 'nullable|string|max:50',
            'lama_studi' => 'nullable|string|max:50',
            'jenis_pendidikan' => 'nullable|string|max:100',
            'jenis_pendidikan_lanjutan' => 'nullable|string|max:100',
            'persyaratan_penerimaan' => 'nullable|string',
            'alamat_prodi' => 'nullable|string',
            'telepon_prodi' => 'nullable|string|max:20',
            'email_prodi' => 'nullable|email|max:100',
        ]);

        $prodi->update($request->all());

        Cache::forget('master:program_studi');
        Cache::forget('master:prodi_options');
        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }
        $row = DB::table('program_studi')->where('id_prodi', $id)->first();
        if (!$row) abort(404);
        $prodi = ProgramStudi::hydrate([(array) $row])->first();
        $prodi->delete();
        Cache::forget('master:program_studi');
        Cache::forget('master:prodi_options');
        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $query = DB::table('program_studi')
            ->leftJoin('fakultas', 'program_studi.id_fakultas', '=', 'fakultas.id_fakultas')
            ->select('program_studi.*', 'fakultas.nama_fakultas as fakultas_nama');

        $allowedProdis = $this->getAllowedProdiIds();
        if ($allowedProdis !== null) {
            $query->whereIn('program_studi.id_prodi', $allowedProdis);
        }

        if ($request->filled('id_fakultas')) {
            $query->where('fakultas.nama_fakultas', $request->id_fakultas);
        }

        return DataTables::of($query)
            ->addColumn('prodi', fn($p) => $p->nama_prodi . ($p->gelar ? ' (' . $p->gelar . ')' : ''))
            ->addColumn('jenjang', fn($p) => $p->jenjang . ($p->gelar ? ' - ' . $p->gelar : ''))
            ->addColumn('akreditasi', fn($p) => ($p->sk_akreditasi ?? '-') . ($p->masa_berlaku_akreditasi ? ' s.d ' . Carbon::parse($p->masa_berlaku_akreditasi)->isoFormat('D MMM YYYY') : ''))
            ->addColumn('fakultas', fn($p) => $p->fakultas_nama ?? '-')
            ->addColumn('action', function ($row) {
                $editRoute = route('prodi.edit', $row->id_prodi);
                $deleteRoute = route('prodi.destroy', $row->id_prodi);
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
