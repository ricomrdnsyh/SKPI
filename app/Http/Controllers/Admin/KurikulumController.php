<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ClientSSO;
use App\Models\ProgramStudi;
use App\Http\Controllers\Traits\FilterByProdi;

class KurikulumController extends Controller
{
    use FilterByProdi;

    public function index()
    {
        $allowedProdis = $this->getAllowedProdiIds();
        $prodiList = $this->getProdiOptions($allowedProdis);
        if ($allowedProdis === null) {
            $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
        } else {
            $prodi = DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
        }

        return view('admin.kurikulum.index', compact('prodiList', 'prodi'));
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
        ]);

        $existing = DB::table('kurikulum')->where('id_prodi', $request->id_prodi)
            ->where('nama_kurikulum', $request->nama_kurikulum)
            ->first();

        if ($existing) {
            return back()->withInput()->with('error', 'Kurikulum dengan nama ' . $request->nama_kurikulum . ' sudah ada untuk prodi ini.');
        }

        Kurikulum::create([
            'id_prodi' => $request->id_prodi,
            'nama_kurikulum' => $request->nama_kurikulum,
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
        ]);

        $existing = DB::table('kurikulum')->where('id_prodi', $request->id_prodi)
            ->where('nama_kurikulum', $request->nama_kurikulum)
            ->where('id_kurikulum', '!=', $id)
            ->first();

        if ($existing) {
            return back()->withInput()->with('error', 'Kurikulum dengan nama ' . $request->nama_kurikulum . ' sudah ada untuk prodi ini.');
        }

        $kurikulum->update([
            'id_prodi' => $request->id_prodi,
            'nama_kurikulum' => $request->nama_kurikulum,
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
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data kurikulum berhasil dihapus.']);
        }
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
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="'.$rowJson.'" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a>' . ' ' . '<a href="javascript:void(0)" onclick="editModal(this)" data-row="'.$rowJson.'" class="btn btn-sm btn-light btn-active-light-warning text-center" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></a>' . ' ' . '<button type="button" onclick="confirmDelete(\'' . $row->id_kurikulum . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>' . '</div>';
            })
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
                return response()->json(['success' => false, 'message' => 'Data Program Studi kosong, silakan sinkronisasi prodi terlebih dahulu.']);
            }

            $newCount = 0;
            $updatedCount = 0;
            $unchangedCount = 0;

            foreach ($prodis as $prodi) {
                $data = $clientSSO->getKurikulumFromApi($prodi->id_prodi);

                if (empty($data)) {
                    continue;
                }

                foreach ($data as $item) {
                    $namaKurikulum = $item['nm_kurikulum'] ?? $item['nama_kurikulum'] ?? null;

                    if ($namaKurikulum) {
                        $kurikulum = Kurikulum::updateOrCreate(
                            [
                                'id_prodi' => $prodi->id_prodi,
                                'nama_kurikulum' => $namaKurikulum,
                            ]
                        );

                        if ($kurikulum->wasRecentlyCreated) {
                            $newCount++;
                        } else if ($kurikulum->wasChanged()) {
                            $updatedCount++;
                        } else {
                            $unchangedCount++;
                        }
                    }
                }
            }

            $message = "Sinkronisasi selesai. Baru: {$newCount}, Diperbarui: {$updatedCount}, Tetap: {$unchangedCount}.";

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal sinkronisasi: ' . $e->getMessage()], 500);
        }
    }
}
