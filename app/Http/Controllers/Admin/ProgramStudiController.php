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
use App\Services\ClientSSO;
use App\Models\Fakultas;

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

        $fakultas = DB::table('fakultas')->select('id_fakultas', 'nama_fakultas')->get();

        return view('admin.prodi.index', compact('jenjangOptions', 'fakultasOptions', 'fakultas'));
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

        $data = $request->all();
        $data['id_prodi'] = (string) \Illuminate\Support\Str::uuid();
        ProgramStudi::create($data);

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
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data program studi berhasil dihapus.']);
        }
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
            $query->where('program_studi.id_fakultas', $request->id_fakultas);
        }

        return DataTables::of($query)
            ->filterColumn('prodi', function($query, $keyword) {
                $query->whereRaw("CONCAT(program_studi.nama_prodi, ' (', IFNULL(program_studi.gelar, ''), ')') like ?", ["%{$keyword}%"])
                      ->orWhere('program_studi.nama_prodi', 'like', "%{$keyword}%");
            })
            ->filterColumn('jenjang', function($query, $keyword) {
                $query->whereRaw("CONCAT(program_studi.jenjang, ' - ', IFNULL(program_studi.gelar, '')) like ?", ["%{$keyword}%"])
                      ->orWhere('program_studi.jenjang', 'like', "%{$keyword}%");
            })
            ->filterColumn('akreditasi', function($query, $keyword) {
                $query->where('program_studi.sk_akreditasi', 'like', "%{$keyword}%");
            })
            ->filterColumn('fakultas', function($query, $keyword) {
                $query->where('fakultas.nama_fakultas', 'like', "%{$keyword}%");
            })
            ->addColumn('prodi', fn($p) => $p->nama_prodi . ($p->gelar ? ' (' . $p->gelar . ')' : ''))
            ->addColumn('jenjang', fn($p) => $p->jenjang . ($p->gelar ? ' - ' . $p->gelar : ''))
            ->addColumn('akreditasi', fn($p) => ($p->sk_akreditasi ?? '-') . ($p->masa_berlaku_akreditasi ? ' s.d ' . Carbon::parse($p->masa_berlaku_akreditasi)->isoFormat('D MMM YYYY') : ''))
            ->addColumn('fakultas', fn($p) => $p->fakultas_nama ?? '-')
            ->addColumn('status', fn($p) => '<span class="badge ' . ($p->status === 'aktif' || $p->status === 'active' ? 'badge-success' : 'badge-danger') . '">' . ucfirst($p->status === 'active' ? 'Aktif' : $p->status) . '</span>')
            ->addColumn('action', function ($row) {
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a>' . ' ' . '<a href="javascript:void(0)" onclick="editModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-warning text-center" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></a>' . ' ' . '<button type="button" onclick="confirmDelete(\'' . $row->id_prodi . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>' . '</div>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function sync(ClientSSO $clientSSO)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        try {
            $fakultasList = Fakultas::all();

            if ($fakultasList->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Data Fakultas kosong, silakan sinkronisasi fakultas terlebih dahulu.']);
            }

            $newCount = 0;
            $updatedCount = 0;
            $unchangedCount = 0;

            foreach ($fakultasList as $fakultas) {
                $data = $clientSSO->getProdiByFakultas($fakultas->id_fakultas);

                if (empty($data)) {
                    continue;
                }

                foreach ($data as $item) {
                    $prodi = ProgramStudi::updateOrCreate(
                        ['id_prodi' => $item['id_sms']],
                        [
                            'id_fakultas' => $item['id_fakultas'] ?? $fakultas->id_fakultas,
                            'nama_prodi' => $item['prodi'] ?? 'Tanpa Nama',
                            'kode_prodi' => $item['singkatan'] ?? null,
                            'jenjang' => null
                        ]
                    );

                    if ($prodi->wasRecentlyCreated) {
                        $newCount++;
                    } else if ($prodi->wasChanged()) {
                        $updatedCount++;
                    } else {
                        $unchangedCount++;
                    }
                }
            }

            Cache::forget('master:program_studi');
            Cache::forget('master:prodi_options');

            $message = "Sinkronisasi selesai. Baru: {$newCount}, Diperbarui: {$updatedCount}, Tetap: {$unchangedCount}.";

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal sinkronisasi: ' . $e->getMessage()], 500);
        }
    }
}
