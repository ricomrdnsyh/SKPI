<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\PrestasiMahasiswa;
use App\Services\SkpiProgressService;
use App\Http\Controllers\Traits\BuildItemSteps;
use App\Http\Controllers\Traits\AutoResubmitPengajuan;
use App\Http\Requests\StorePrestasiRequest;
use App\Helpers\DataTableHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PrestasiController extends Controller
{
    use BuildItemSteps, AutoResubmitPengajuan;
    public function index()
    {
        $id_mahasiswa = Auth::user()->id_mahasiswa;
        $filterOptions = [
            'tingkat' => DB::table('prestasi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->select('tingkat')->distinct()->orderBy('tingkat')->pluck('tingkat'),
            'tahun' => DB::table('prestasi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun'),
            'status' => DB::table('prestasi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->select('status')->distinct()->pluck('status'),
        ];
        return view('mahasiswa.prestasi.index', compact('filterOptions'));
    }

    public function create()
    {
        if ($this->checkPengajuanProcessing()) {
            return redirect()->route('mahasiswa.prestasi.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }
        return view('mahasiswa.prestasi.create');
    }

    public function store(StorePrestasiRequest $request)
    {
        if ($this->checkPengajuanProcessing()) {
            return redirect()->route('mahasiswa.prestasi.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }

        $data = $request->validated();
        $data['id_mahasiswa'] = Auth::user()->id_mahasiswa;
        $data['status'] = 'pending';

        if ($request->hasFile('file_bukti')) {
            $data['file_bukti'] = $request->file('file_bukti')->store('bukti_prestasi', 'public');
        }

        PrestasiMahasiswa::create($data);
        $this->autoResubmitIfNeeded();

        if (request()->ajax()) { return response()->json(["success" => true, "message" => "Data prestasi berhasil ditambahkan dan menunggu verifikasi."]); }

        return redirect()->route('mahasiswa.prestasi.index')->with('success', 'Data prestasi berhasil ditambahkan dan menunggu verifikasi.');
    }

    public function edit($id)
    {
        $prestasi = $this->getOwnedItem($id);

        $id_mahasiswa = Auth::user()->id_mahasiswa;
        $pengajuan = DB::table('pengajuan_skpi')->where('id_mahasiswa', $id_mahasiswa)->first();

        $isRejected = $prestasi->status === 'rejected';
        $isLocked = !$isRejected && $pengajuan && in_array($pengajuan->status, ['dicetak']);
        $isApproved = $prestasi->status === 'approved';
        $readonly = $isLocked || $isApproved;

        $mahasiswaRow = DB::table('mahasiswa')->where('id_mahasiswa', $prestasi->id_mahasiswa)->first();
        $mahasiswa = $mahasiswaRow ? Mahasiswa::hydrate([(array) $mahasiswaRow])->first() : null;

        $itemSteps = $this->buildItemSteps($prestasi);
        $overallSteps = app(SkpiProgressService::class)->getSteps($mahasiswa, $pengajuan);
        return view('mahasiswa.prestasi.edit', compact('prestasi', 'pengajuan', 'itemSteps', 'overallSteps', 'isLocked', 'readonly'));
    }

    public function update(StorePrestasiRequest $request, $id)
    {
        $prestasi = $this->getOwnedItem($id);
        if ($this->checkPengajuanProcessing($prestasi)) {
            return redirect()->route('mahasiswa.prestasi.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }

        if ($prestasi->status === 'approved') {
            return redirect()->route('mahasiswa.prestasi.index')->with('error', 'Data yang telah disetujui tidak dapat diubah.');
        }

        $data = $request->validated();
        $data['status'] = 'pending';
        $data['keterangan'] = null;

        $data['approved_by'] = null;
        $data['approved_at'] = null;

        if ($request->hasFile('file_bukti')) {
            if ($prestasi->file_bukti) {
                Storage::disk('public')->delete($prestasi->file_bukti);
            }
            $data['file_bukti'] = $request->file('file_bukti')->store('bukti_prestasi', 'public');
        } else {
            unset($data['file_bukti']);
        }

        $prestasi->update($data);
        $this->autoResubmitIfNeeded();

        if (request()->ajax()) { return response()->json(["success" => true, "message" => "Data prestasi berhasil diperbarui."]); }

        return redirect()->route('mahasiswa.prestasi.index')->with('success', 'Data prestasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $prestasi = $this->getOwnedItem($id);
        if ($this->checkPengajuanProcessing($prestasi)) {
            return redirect()->route('mahasiswa.prestasi.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }

        if ($prestasi->status === 'approved') {
            return redirect()->route('mahasiswa.prestasi.index')->with('error', 'Data yang telah disetujui tidak dapat dihapus.');
        }

        if ($prestasi->file_bukti) {
            Storage::disk('public')->delete($prestasi->file_bukti);
        }

        $prestasi->delete();

        if (request()->ajax()) { return response()->json(["success" => true, "message" => "Data prestasi berhasil dihapus."]); }

        return redirect()->route('mahasiswa.prestasi.index')->with('success', 'Data prestasi berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $id_mahasiswa = Auth::user()->id_mahasiswa;
        $pengajuan = DB::table('pengajuan_skpi')->where('id_mahasiswa', $id_mahasiswa)->first();
        $query = DB::table('prestasi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa);

        if ($request->filled('tingkat')) $query->where('tingkat', $request->tingkat);
        if ($request->filled('tahun')) $query->where('tahun', $request->tahun);
        if ($request->filled('status')) $query->where('status', $request->status);

        return DataTables::of($query)
            ->addColumn('bukti', fn($row) => DataTableHelper::buktiLink($row->file_bukti))
            ->addColumn('status', fn($row) => DataTableHelper::statusBadge($row->status, ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger']))
            ->addColumn('catatan', fn($row) => $row->keterangan ? e($row->keterangan) : '-')
            ->addColumn('action', function ($row) {
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a> ' . ' ' . '<a href="javascript:void(0)" onclick="editModal(this)" data-row="'.$rowJson.'" class="btn btn-sm btn-light btn-active-light-warning text-center" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></a>' . ' ' . '<button type="button" onclick="confirmDelete(\'' . $row->id_prestasi . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>' . '</div>';
            })
            ->rawColumns(['action', 'bukti', 'status'])
            ->make(true);
    }

    private function getOwnedItem($id): PrestasiMahasiswa
    {
        $row = DB::table('prestasi_mahasiswa')->where('id_prestasi', $id)->first();
        if (!$row) {
            abort(404, 'Prestasi tidak ditemukan.');
        }
        if ($row->id_mahasiswa !== Auth::user()->id_mahasiswa) {
            abort(403, 'Akses ditolak.');
        }
        return PrestasiMahasiswa::hydrate([(array) $row])->first();
    }

    private function checkPengajuanProcessing($item = null): bool
    {
        if ($item && $item->status === 'rejected') {
            return false;
        }
        $id_mahasiswa = Auth::user()->id_mahasiswa;
        $pengajuan = DB::table('pengajuan_skpi')->where('id_mahasiswa', $id_mahasiswa)->first();
        return $pengajuan && in_array($pengajuan->status, ['dicetak']);
    }
}







