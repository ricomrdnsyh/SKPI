<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\OrganisasiMahasiswa;
use App\Services\SkpiProgressService;
use App\Http\Controllers\Traits\BuildItemSteps;
use App\Http\Controllers\Traits\AutoResubmitPengajuan;
use App\Http\Requests\StoreOrganisasiRequest;
use App\Helpers\DataTableHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class OrganisasiController extends Controller
{
    use BuildItemSteps, AutoResubmitPengajuan;
    public function index()
    {
        $user = Auth::user();
        if (in_array($user->role, ['bak_fakultas', 'admin'])) {
            $filterOptions = [
                'tingkat' => DB::table('organisasi_mahasiswa')->select('tingkat')->distinct()->orderBy('tingkat')->pluck('tingkat'),
                'status' => DB::table('organisasi_mahasiswa')->select('status')->distinct()->pluck('status'),
            ];
            if ($user->role === 'bak_fakultas') {
                $id_fakultas = $user->programStudi->id_fakultas;
                $mahasiswas = Mahasiswa::whereHas('programStudi', function($q) use ($id_fakultas) {
                    $q->where('id_fakultas', $id_fakultas);
                })->get();
            } else {
                $mahasiswas = Mahasiswa::all();
            }
            return view('mahasiswa.organisasi.index', compact('filterOptions', 'mahasiswas'));
        } else {
            $id_mahasiswa = $user->id_mahasiswa;
            $filterOptions = [
                'tingkat' => DB::table('organisasi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->select('tingkat')->distinct()->orderBy('tingkat')->pluck('tingkat'),
                'status' => DB::table('organisasi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->select('status')->distinct()->pluck('status'),
            ];
            return view('mahasiswa.organisasi.index', compact('filterOptions'));
        }
    }

    public function create()
    {
        if ($this->checkPengajuanProcessing()) {
            return redirect()->route('mahasiswa.organisasi.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }
        return view('mahasiswa.organisasi.create');
    }

    public function store(StoreOrganisasiRequest $request)
    {
        if ($this->checkPengajuanProcessing()) {
            return redirect()->route('mahasiswa.organisasi.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }

        $data = $request->validated();
        if (in_array(Auth::user()->role, ['bak_fakultas', 'admin'])) {
            $request->validate(['id_mahasiswa' => 'required|exists:mahasiswa,id_mahasiswa']);
            $data['id_mahasiswa'] = $request->id_mahasiswa;
        } else {
            $data['id_mahasiswa'] = Auth::user()->id_mahasiswa;
        }
        $data['status'] = 'pending';

        if ($request->hasFile('file_bukti')) {
            $data['file_bukti'] = $request->file('file_bukti')->store('bukti_organisasi', 'public');
        }

        OrganisasiMahasiswa::create($data);
        $this->autoResubmitIfNeeded();

        if (request()->ajax()) { return response()->json(["success" => true, "message" => "Data organisasi berhasil ditambahkan."]); }

        return redirect()->route('mahasiswa.organisasi.index')->with('success', 'Data organisasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $organisasi = $this->getOwnedItem($id);

        $user = Auth::user();
        if (in_array($user->role, ['bak_fakultas', 'admin'])) {
            $pengajuan = DB::table('pengajuan_skpi')->where('id_mahasiswa', $organisasi->id_mahasiswa)->first();
            $isLocked = false;
            $readonly = false;
        } else {
            $id_mahasiswa = $user->id_mahasiswa;
            $pengajuan = DB::table('pengajuan_skpi')->where('id_mahasiswa', $id_mahasiswa)->first();

            $isRejected = $organisasi->status === 'rejected';
            $isLocked = !$isRejected && $pengajuan && in_array($pengajuan->status, ['dicetak']);
            $isApproved = $organisasi->status === 'approved';
            $readonly = $isLocked || $isApproved;
        }

        $mahasiswaRow = DB::table('mahasiswa')->where('id_mahasiswa', $organisasi->id_mahasiswa)->first();
        $mahasiswa = $mahasiswaRow ? Mahasiswa::hydrate([(array) $mahasiswaRow])->first() : null;

        $itemSteps = $this->buildItemSteps($organisasi);
        $overallSteps = app(SkpiProgressService::class)->getSteps($mahasiswa, $pengajuan);
        return view('mahasiswa.organisasi.edit', compact('organisasi', 'pengajuan', 'itemSteps', 'overallSteps', 'isLocked', 'readonly'));
    }

    public function update(StoreOrganisasiRequest $request, $id)
    {
        $organisasi = $this->getOwnedItem($id);
        if ($this->checkPengajuanProcessing($organisasi)) {
            return redirect()->route('mahasiswa.organisasi.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }

        if ($organisasi->status === 'approved') {
            return redirect()->route('mahasiswa.organisasi.index')->with('error', 'Data yang telah disetujui tidak dapat diubah.');
        }

        $data = $request->validated();
        $data['status'] = 'pending';
        $data['keterangan'] = null;

        $data['approved_by'] = null;
        $data['approved_at'] = null;

        if ($request->hasFile('file_bukti')) {
            if ($organisasi->file_bukti) {
                Storage::disk('public')->delete($organisasi->file_bukti);
            }
            $data['file_bukti'] = $request->file('file_bukti')->store('bukti_organisasi', 'public');
        } else {
            unset($data['file_bukti']);
        }

        $organisasi->update($data);
        $this->autoResubmitIfNeeded();

        if (request()->ajax()) { return response()->json(["success" => true, "message" => "Data organisasi berhasil diperbarui."]); }

        return redirect()->route('mahasiswa.organisasi.index')->with('success', 'Data organisasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $organisasi = $this->getOwnedItem($id);
        if ($this->checkPengajuanProcessing($organisasi)) {
            return redirect()->route('mahasiswa.organisasi.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }

        if ($organisasi->status === 'approved') {
            return redirect()->route('mahasiswa.organisasi.index')->with('error', 'Data yang telah disetujui tidak dapat dihapus.');
        }

        if ($organisasi->file_bukti) {
            Storage::disk('public')->delete($organisasi->file_bukti);
        }

        $organisasi->delete();

        if (request()->ajax()) { return response()->json(["success" => true, "message" => "Data organisasi berhasil dihapus."]); }

        return redirect()->route('mahasiswa.organisasi.index')->with('success', 'Data organisasi berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $user = Auth::user();
        $query = DB::table('organisasi_mahasiswa');
        
        if (in_array($user->role, ['bak_fakultas', 'admin'])) {
            $query->join('mahasiswa', 'organisasi_mahasiswa.id_mahasiswa', '=', 'mahasiswa.id_mahasiswa')
                  ->join('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
                  ->select('organisasi_mahasiswa.*', 'mahasiswa.nama_lengkap as nama_mahasiswa', 'mahasiswa.nim');
            
            if ($user->role === 'bak_fakultas') {
                $id_fakultas = $user->programStudi->id_fakultas;
                $query->where('program_studi.id_fakultas', $id_fakultas);
            }
        } else {
            $query->where('id_mahasiswa', $user->id_mahasiswa);
        }

        if ($request->filled('tingkat')) $query->where('tingkat', $request->tingkat);
        if ($request->filled('status')) $query->where('organisasi_mahasiswa.status', $request->status);

        return DataTables::of($query)
            ->filterColumn('nama_mahasiswa', function($query, $keyword) {
                $query->where('mahasiswa.nama_lengkap', 'like', "%{$keyword}%");
            })
            ->filterColumn('nim', function($query, $keyword) {
                $query->where('mahasiswa.nim', 'like', "%{$keyword}%");
            })
            ->addColumn('bukti', fn($row) => DataTableHelper::buktiLink($row->file_bukti))
            ->addColumn('status', fn($row) => DataTableHelper::statusBadge($row->status, ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger']))
            ->addColumn('catatan', fn($row) => $row->keterangan ? e($row->keterangan) : '-')
            ->addColumn('action', function ($row) {
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a> ' . ' ' . '<a href="javascript:void(0)" onclick="editModal(this)" data-row="'.$rowJson.'" class="btn btn-sm btn-light btn-active-light-warning text-center" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></a>' . ' ' . '<button type="button" onclick="confirmDelete(\'' . $row->id_organisasi_mhs . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>' . '</div>';
            })
            ->rawColumns(['action', 'bukti', 'status'])
            ->make(true);
    }

    private function getOwnedItem($id): OrganisasiMahasiswa
    {
        $row = DB::table('organisasi_mahasiswa')->where('id_organisasi_mhs', $id)->first();
        if (!$row) {
            abort(404, 'Organisasi tidak ditemukan.');
        }
        if (!in_array(Auth::user()->role, ['bak_fakultas', 'admin']) && $row->id_mahasiswa !== Auth::user()->id_mahasiswa) {
            abort(403, 'Akses ditolak.');
        }
        return OrganisasiMahasiswa::hydrate([(array) $row])->first();
    }

    private function checkPengajuanProcessing($item = null): bool
    {
        if (in_array(Auth::user()->role, ['bak_fakultas', 'admin'])) {
            return false;
        }
        if ($item && $item->status === 'rejected') {
            return false;
        }
        $id_mahasiswa = Auth::user()->id_mahasiswa;
        $pengajuan = DB::table('pengajuan_skpi')->where('id_mahasiswa', $id_mahasiswa)->first();
        return $pengajuan && in_array($pengajuan->status, ['dicetak']);
    }
}







