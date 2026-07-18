<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Traits\FilterByProdi;

class MahasiswaCrudController extends Controller
{
    use FilterByProdi;

    public function index()
    {
        $allowedProdis = $this->getAllowedProdiIds();
        $prodiList = $this->getProdiOptions($allowedProdis);

        $allowedFakultas = $this->getAllowedFakultasIds();
        $fakultasList = $allowedFakultas === null ? DB::table('fakultas')->select('id_fakultas', 'nama_fakultas')->get() : DB::table('fakultas')->whereIn('id_fakultas', $allowedFakultas)->get();

        if ($allowedProdis === null) {
            $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->get();
        } else {
            $prodi = DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->whereIn('kurikulum.id_prodi', $allowedProdis)
                ->get();
        }

        return view('admin.mahasiswa.index', compact('fakultasList', 'prodiList', 'prodi', 'kurikulums'));
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
                ->get();
        } else {
            $prodi = DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->whereIn('kurikulum.id_prodi', $allowedProdis)
                ->get();
        }
        return view('admin.mahasiswa.create', compact('prodi', 'kurikulums'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($request->id_prodi, $allowedProdis)) {
            abort(403, 'Akses prodi tidak diizinkan.');
        }

        $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswa,nim',
            'id_prodi' => 'required|exists:program_studi,id_prodi',
            'id_kurikulum' => 'required|exists:kurikulum,id_kurikulum',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'email' => 'nullable|email|max:100',
            'nomor_telepon' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $data = $request->all();
        if (!$request->filled('password')) {
            unset($data['password']);
        }

        Mahasiswa::create($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $row = DB::table('mahasiswa')->where('nim', $id)->first();
        if (!$row) abort(404);
        $mahasiswa = Mahasiswa::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($mahasiswa->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        if ($allowedProdis === null) {
            $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->get();
        } else {
            $prodi = DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->whereIn('kurikulum.id_prodi', $allowedProdis)
                ->get();
        }
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'prodi', 'kurikulums'));
    }

    public function update(Request $request, $id)
    {
        $row = DB::table('mahasiswa')->where('nim', $id)->first();
        if (!$row) abort(404);
        $mahasiswa = Mahasiswa::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null) {
            if (!in_array($mahasiswa->id_prodi, $allowedProdis)) {
                abort(403, 'Akses ditolak.');
            }
            if (!in_array($request->id_prodi, $allowedProdis)) {
                abort(403, 'Akses prodi tidak diizinkan.');
            }
        }

        $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswa,nim,' . $id . ',nim',
            'id_prodi' => 'required|exists:program_studi,id_prodi',
            'id_kurikulum' => 'required|exists:kurikulum,id_kurikulum',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'email' => 'nullable|email|max:100',
            'nomor_telepon' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $data = $request->all();
        if (!$request->filled('password')) {
            unset($data['password']);
        }

        $mahasiswa->update($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $row = DB::table('mahasiswa')->where('nim', $id)->first();
        if (!$row) abort(404);
        $mahasiswa = Mahasiswa::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($mahasiswa->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        $mahasiswa->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data mahasiswa berhasil dihapus.']);
        }
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        $query = DB::table('mahasiswa')
            ->leftJoin('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
            ->select('mahasiswa.*', 'program_studi.nama_prodi as prodi_nama');

        if ($allowedProdis !== null) {
            $query->whereIn('mahasiswa.id_prodi', $allowedProdis);
        }

        if ($request->filled('id_prodi')) {
            $query->where('mahasiswa.id_prodi', $request->id_prodi);
        }
        if ($request->filled('id_fakultas')) {
            $query->where('program_studi.id_fakultas', $request->id_fakultas);
        }

        return DataTables::of($query)
            ->filterColumn('prodi', function($query, $keyword) {
                $query->where('program_studi.nama_prodi', 'like', "%{$keyword}%");
            })
            ->addColumn('prodi', fn($m) => $m->prodi_nama ?? '-')
            ->addColumn('status', fn($m) => '<span class="badge badge-success">' . ($m->status ?? 'Aktif') . '</span>')
            ->addColumn('action', function ($row) {
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="'.$rowJson.'" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a>' . ' ' . '<a href="javascript:void(0)" onclick="editModal(this)" data-row="'.$rowJson.'" class="btn btn-sm btn-light btn-active-light-warning text-center" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></a>' . ' ' . '<button type="button" onclick="confirmDelete(\'' . $row->nim . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>' . '</div>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
