<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ClientSSO;
use App\Http\Controllers\Traits\FilterByProdi;

class DosenController extends Controller
{
    use FilterByProdi;

    public function index()
    {
        $allowedProdis = $this->getAllowedProdiIds();

        $prodiQuery = DB::table('program_studi');
        if ($allowedProdis !== null) {
            $prodiQuery->whereIn('id_prodi', $allowedProdis);
        }
        $prodi = $prodiQuery->select('id_prodi', 'nama_prodi', 'id_fakultas')->get();
        $fakultas = DB::table('fakultas')->select('id_fakultas', 'nama_fakultas')->get();

        return view('admin.dosen.index', compact('prodi', 'fakultas'));
    }

    public function datatable(Request $request)
    {
        $query = DB::table('dosen')
            ->leftJoin('program_studi', 'dosen.id_prodi', '=', 'program_studi.id_prodi')
            ->leftJoin('fakultas', 'dosen.id_fakultas', '=', 'fakultas.id_fakultas')
            ->select('dosen.*', 'program_studi.nama_prodi as prodi_nama', 'fakultas.nama_fakultas as fakultas_nama');

        $allowedProdis = $this->getAllowedProdiIds();
        if ($allowedProdis !== null) {
            $query->whereIn('dosen.id_prodi', $allowedProdis);
        }

        if ($request->filled('id_prodi')) {
            $query->where('dosen.id_prodi', $request->id_prodi);
        }

        if ($request->filled('id_fakultas')) {
            $query->where('dosen.id_fakultas', $request->id_fakultas);
        }

        return DataTables::of($query)
            ->filterColumn('dosen', function($query, $keyword) {
                $query->where('dosen.nama_dosen', 'like', "%{$keyword}%")
                      ->orWhere('dosen.nidn', 'like', "%{$keyword}%");
            })
            ->filterColumn('prodi', function($query, $keyword) {
                $query->where('program_studi.nama_prodi', 'like', "%{$keyword}%");
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex justify-content-center gap-2">';
                $btn .= '<button class="btn btn-sm btn-light btn-active-light-info text-center btn-detail border-0" data-id="' . $row->id_penduduk . '" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></button>';
                $btn .= '<button class="btn btn-sm btn-light btn-active-light-warning text-center btn-edit border-0" data-id="' . $row->id_penduduk . '" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></button>';
                if (Auth::user()->role === 'admin') {
                    $btn .= '<button type="button" onclick="confirmDelete(\'' . $row->id_penduduk . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>';
                }
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('prodi', fn($p) => $p->prodi_nama ?? '-')
            ->addColumn('fakultas', fn($p) => $p->fakultas_nama ?? '-')
            ->addColumn('jenis_kelamin', fn($p) => $p->jenis_kelamin === 'L' ? 'Laki-laki' : ($p->jenis_kelamin === 'P' ? 'Perempuan' : '-'))
            ->rawColumns(['action'])
            ->make(true);
    }

    public function sync(ClientSSO $clientSSO)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        try {
            $prodis = ProgramStudi::all();

            if ($prodis->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Data Program Studi kosong, silakan sinkronisasi Prodi terlebih dahulu.']);
            }

            $newCount = 0;
            $updatedCount = 0;
            $unchangedCount = 0;

            foreach ($prodis as $prodi) {
                $data = $clientSSO->getDosenByProdi($prodi->id_prodi);

                if (empty($data)) {
                    continue;
                }

                foreach ($data as $item) {
                    $dosen = Dosen::updateOrCreate(
                        ['id_penduduk' => $item['id_penduduk']],
                        [
                            'nidn' => $item['nidn'] ?? null,
                            'nama_dosen' => $item['nama_penduduk'] ?? 'Tanpa Nama',
                            'jenis_kelamin' => $item['jenis_kelamin'] ?? null,
                            'email' => $item['email'] ?? null,
                            'no_hp' => $item['no_hp'] ?? null,
                            'id_fakultas' => $item['id_fakultas'] ?? null,
                            'id_prodi' => $item['id_sms'] ?? $prodi->id_prodi,
                        ]
                    );

                    if ($dosen->wasRecentlyCreated) {
                        $newCount++;
                    } else if ($dosen->wasChanged()) {
                        $updatedCount++;
                    } else {
                        $unchangedCount++;
                    }
                }
            }

            $message = "Sinkronisasi selesai. Baru: {$newCount}, Diperbarui: {$updatedCount}, Tetap: {$unchangedCount}.";

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal sinkronisasi: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $dosen = Dosen::with(['fakultas', 'programStudi'])->findOrFail($id);
        return response()->json($dosen);
    }

    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        return response()->json($dosen);
    }

    public function update(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'bak_fakultas'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $dosen = Dosen::findOrFail($id);

        if (Auth::user()->role === 'bak_fakultas') {
            $allowedProdis = $this->getAllowedProdiIds();
            if ($allowedProdis !== null && !in_array($dosen->id_prodi, $allowedProdis)) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak. Dosen tidak berada di fakultas Anda.'], 403);
            }
        }

        $request->validate([
            'nidn' => 'nullable|string|max:12',
            'nama_dosen' => 'required|string|max:100',
            'jenis_kelamin' => 'nullable|in:L,P',
            'email' => 'nullable|email|max:100',
            'no_hp' => 'nullable|string|max:15',
            'id_fakultas' => 'nullable|integer',
            'id_prodi' => 'nullable|string|max:50',
        ]);

        try {
            $dosen->update($request->all());

            return response()->json(['success' => true, 'message' => 'Data dosen berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        try {
            $dosen = Dosen::findOrFail($id);
            $dosen->delete();

            return response()->json(['success' => true, 'message' => 'Data dosen berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}
