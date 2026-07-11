<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TugasAkhirController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!in_array($user->role, ['bak_fakultas', 'admin'])) {
            abort(403);
        }

        if ($user->role === 'bak_fakultas') {
            $id_fakultas = $user->programStudi->id_fakultas;
            
            $mahasiswas = Mahasiswa::whereHas('programStudi', function($q) use ($id_fakultas) {
                $q->where('id_fakultas', $id_fakultas);
            })->get();

            $filterOptions = [
                'status' => DB::table('tugas_akhir')
                    ->join('mahasiswa', 'tugas_akhir.id_mahasiswa', '=', 'mahasiswa.id_mahasiswa')
                    ->join('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
                    ->where('program_studi.id_fakultas', $id_fakultas)
                    ->select('tugas_akhir.status')->distinct()->pluck('status'),
            ];
        } else {
            $mahasiswas = Mahasiswa::all();
            
            $filterOptions = [
                'status' => DB::table('tugas_akhir')
                    ->select('status')->distinct()->pluck('status'),
            ];
        }

        return view('bak_fakultas.tugas_akhir.index', compact('filterOptions', 'mahasiswas'));
    }

    private function checkIsLocked($tugasAkhir)
    {
        if (!$tugasAkhir) return false;
        
        $pengajuan = DB::table('pengajuan_skpi')->where('id_mahasiswa', $tugasAkhir->id_mahasiswa)->first();
        $isRejected = $tugasAkhir->status === 'rejected';
        $isLocked = !$isRejected && $pengajuan && in_array($pengajuan->status, ['diajukan', 'verifikasi', 'dicetak']);
        $isApproved = $tugasAkhir->status === 'approved';
        
        return $isLocked || $isApproved;
    }

    public function datatable(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['bak_fakultas', 'admin'])) {
            abort(403);
        }

        $query = TugasAkhir::join('mahasiswa', 'tugas_akhir.id_mahasiswa', '=', 'mahasiswa.id_mahasiswa')
            ->join('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
            ->select('tugas_akhir.*', 'mahasiswa.nama_lengkap as nama_mahasiswa', 'mahasiswa.nim');

        if ($user->role === 'bak_fakultas') {
            $id_fakultas = $user->programStudi->id_fakultas;
            $query->where('program_studi.id_fakultas', $id_fakultas);
        }

        if ($request->filled('status')) {
            $query->where('tugas_akhir.status', $request->status);
        }

        return DataTables::of($query)
            ->filterColumn('nama_mahasiswa', function($query, $keyword) {
                $query->where('mahasiswa.nama_lengkap', 'like', "%{$keyword}%");
            })
            ->filterColumn('nim', function($query, $keyword) {
                $query->where('mahasiswa.nim', 'like', "%{$keyword}%");
            })
            ->addColumn('pembimbing', function($row) {
                // Eager loading should ideally be done in the query, but since we are joining,
                // we can just fetch the related model instances.
                $tugasAkhir = TugasAkhir::with('pembimbing')->find($row->id_tugas_akhir);
                if (!$tugasAkhir || $tugasAkhir->pembimbing->isEmpty()) return '-';
                
                $html = '<ul class="mb-0 ps-3">';
                foreach($tugasAkhir->pembimbing as $p) {
                    $html .= '<li>' . e($p->nama_dosen) . '</li>';
                }
                $html .= '</ul>';
                return $html;
            })
            ->addColumn('status', function ($row) {
                $statusMap = [
                    'approved' => ['badge-light-success', 'Disetujui'],
                    'rejected' => ['badge-light-danger', 'Ditolak'],
                    'pending'  => ['badge-light-warning', 'Menunggu']
                ];
                $s = $statusMap[$row->status] ?? ['badge-light-secondary', ucfirst($row->status)];
                return '<span class="badge ' . $s[0] . ' fw-bold px-4 py-2">' . $s[1] . '</span>';
            })
            ->addColumn('action', function ($row) {
                $tugasAkhir = TugasAkhir::with('pembimbing')->find($row->id_tugas_akhir);
                $pembimbingNames = $tugasAkhir ? $tugasAkhir->pembimbing->pluck('nama_dosen')->toArray() : [];
                $pembimbing1 = $pembimbingNames[0] ?? '';
                $pembimbing2 = $pembimbingNames[1] ?? '';
                
                $data = htmlspecialchars(json_encode([
                    'id_tugas_akhir' => $row->id_tugas_akhir,
                    'id_mahasiswa' => $row->id_mahasiswa,
                    'judul' => $row->judul,
                    'pembimbing_1' => $pembimbing1,
                    'pembimbing_2' => $pembimbing2
                ]), ENT_QUOTES, 'UTF-8');

                $isLocked = (new self)->checkIsLocked($tugasAkhir);

                if ($isLocked) {
                    return '
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-sm btn-light btn-active-light-secondary text-center border-0" disabled data-bs-toggle="tooltip" data-bs-title="Terkunci (Sudah disetujui / dalam proses SKPI)">
                            <i class="fas fa-lock"></i>
                        </button>
                    </div>';
                }

                return '
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-sm btn-light btn-active-light-warning text-center border-0" data-bs-toggle="tooltip" data-bs-title="Edit"
                        onclick="editTugasAkhir(' . $row->id_tugas_akhir . ', ' . $data . ')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"
                        onclick="confirmDelete(' . $row->id_tugas_akhir . ')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>';
            })
            ->rawColumns(['status', 'pembimbing', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['bak_fakultas', 'admin'])) {
            abort(403);
        }

        $request->validate([
            'id_mahasiswa' => 'required|exists:mahasiswa,id_mahasiswa',
            'judul' => 'required|string',
            'pembimbing' => 'required|array',
            'pembimbing.0' => 'required|string', // Pembimbing 1 is required
        ]);

        DB::transaction(function () use ($request) {
            $tugasAkhir = TugasAkhir::updateOrCreate(
                ['id_mahasiswa' => $request->id_mahasiswa],
                [
                    'judul' => $request->judul,
                    'status' => 'pending',
                    'approved_by' => null,
                    'approved_at' => null,
                    'keterangan' => null,
                ]
            );

            DB::table('pembimbing_tugas_akhir')
                ->where('id_tugas_akhir', $tugasAkhir->id_tugas_akhir)
                ->delete();

            $pembimbingNames = collect($request->pembimbing)
                ->filter(fn($name) => !empty(trim($name)))
                ->unique()
                ->values();

            foreach ($pembimbingNames as $index => $nameDosen) {
                DB::table('pembimbing_tugas_akhir')->insert([
                    'id_tugas_akhir' => $tugasAkhir->id_tugas_akhir,
                    'nama_dosen' => trim($nameDosen),
                    'urutan_pembimbing' => $index + 1,
                ]);
            }
            
            // Auto approve if it's bak_fakultas adding? The previous modules did NOT auto approve.
            // Let's keep it pending, so they can verify it via the Verifikasi page, or maybe approve immediately?
            // "model tabel seperti yang lain" means just CRUD. The existing data pendukung are saved as 'pending' even if admin creates them.
        });

        return redirect()->route('bak_fakultas.tugas_akhir.index')->with('success', 'Data Tugas Akhir berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['bak_fakultas', 'admin'])) {
            abort(403);
        }

        $request->validate([
            'id_mahasiswa' => 'required|exists:mahasiswa,id_mahasiswa',
            'judul' => 'required|string',
            'pembimbing' => 'required|array',
            'pembimbing.0' => 'required|string',
        ]);

        $tugasAkhir = TugasAkhir::findOrFail($id);
        
        if ($this->checkIsLocked($tugasAkhir)) {
            return redirect()->route('bak_fakultas.tugas_akhir.index')->with('error', 'Data tidak dapat diubah karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }

        DB::transaction(function () use ($request, $tugasAkhir) {
            $tugasAkhir->update([
                'id_mahasiswa' => $request->id_mahasiswa,
                'judul' => $request->judul,
                // Status remains unchanged when editing by admin? Or reset to pending? Let's keep existing status.
            ]);

            DB::table('pembimbing_tugas_akhir')
                ->where('id_tugas_akhir', $tugasAkhir->id_tugas_akhir)
                ->delete();

            $pembimbingNames = collect($request->pembimbing)
                ->filter(fn($name) => !empty(trim($name)))
                ->unique()
                ->values();

            foreach ($pembimbingNames as $index => $nameDosen) {
                DB::table('pembimbing_tugas_akhir')->insert([
                    'id_tugas_akhir' => $tugasAkhir->id_tugas_akhir,
                    'nama_dosen' => trim($nameDosen),
                    'urutan_pembimbing' => $index + 1,
                ]);
            }
        });

        return redirect()->route('bak_fakultas.tugas_akhir.index')->with('success', 'Data Tugas Akhir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['bak_fakultas', 'admin'])) {
            abort(403);
        }

        $tugasAkhir = TugasAkhir::findOrFail($id);
        
        if ($this->checkIsLocked($tugasAkhir)) {
            return response()->json(['success' => false, 'message' => 'Data tidak dapat dihapus karena pengajuan SKPI sedang diproses atau sudah disetujui.'], 403);
        }
        
        DB::transaction(function () use ($tugasAkhir) {
            DB::table('pembimbing_tugas_akhir')
                ->where('id_tugas_akhir', $tugasAkhir->id_tugas_akhir)
                ->delete();
            $tugasAkhir->delete();
        });

        return response()->json(['success' => true, 'message' => 'Data Tugas Akhir berhasil dihapus.']);
    }
}
