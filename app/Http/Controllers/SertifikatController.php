<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\SertifikatMahasiswa;
use App\Services\SkpiProgressService;
use App\Http\Controllers\Traits\BuildItemSteps;
use App\Http\Controllers\Traits\AutoResubmitPengajuan;
use App\Http\Requests\StoreSertifikatRequest;
use App\Helpers\DataTableHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SertifikatController extends Controller
{
    use BuildItemSteps, AutoResubmitPengajuan;
    public function index()
    {
        $id_mahasiswa = Auth::user()->id_mahasiswa;
        $filterOptions = [
            'jenis_sertifikat' => DB::table('sertifikat_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->select('jenis_sertifikat')->distinct()->pluck('jenis_sertifikat'),
            'bidang' => DB::table('sertifikat_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->select('bidang')->distinct()->orderBy('bidang')->pluck('bidang'),
            'status' => DB::table('sertifikat_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->select('status')->distinct()->pluck('status'),
        ];
        return view('mahasiswa.sertifikat.index', compact('filterOptions'));
    }

    public function create()
    {
        if ($this->checkPengajuanProcessing()) {
            return redirect()->route('mahasiswa.sertifikat.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }
        return view('mahasiswa.sertifikat.create');
    }

    public function store(StoreSertifikatRequest $request)
    {
        if ($this->checkPengajuanProcessing()) {
            return redirect()->route('mahasiswa.sertifikat.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }

        $data = $request->validated();
        $data['id_mahasiswa'] = Auth::user()->id_mahasiswa;
        $data['status'] = 'pending';

        if ($request->hasFile('file_bukti')) {
            $data['file_bukti'] = $request->file('file_bukti')->store('bukti_sertifikat', 'public');
        }

        SertifikatMahasiswa::create($data);
        $this->autoResubmitIfNeeded();

        if (request()->ajax()) { return response()->json(["success" => true, "message" => "Data sertifikat berhasil ditambahkan."]); }

        return redirect()->route('mahasiswa.sertifikat.index')->with('success', 'Data sertifikat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sertifikat = $this->getOwnedItem($id);

        $id_mahasiswa = Auth::user()->id_mahasiswa;
        $pengajuan = DB::table('pengajuan_skpi')->where('id_mahasiswa', $id_mahasiswa)->first();

        $isRejected = $sertifikat->status === 'rejected';
        $isLocked = !$isRejected && $pengajuan && in_array($pengajuan->status, ['dicetak']);
        $isApproved = $sertifikat->status === 'approved';
        $readonly = $isLocked || $isApproved;

        $mahasiswaRow = DB::table('mahasiswa')->where('id_mahasiswa', $sertifikat->id_mahasiswa)->first();
        $mahasiswa = $mahasiswaRow ? Mahasiswa::hydrate([(array) $mahasiswaRow])->first() : null;

        $itemSteps = $this->buildItemSteps($sertifikat);
        $overallSteps = app(SkpiProgressService::class)->getSteps($mahasiswa, $pengajuan);
        return view('mahasiswa.sertifikat.edit', compact('sertifikat', 'pengajuan', 'itemSteps', 'overallSteps', 'isLocked', 'readonly'));
    }

    public function update(StoreSertifikatRequest $request, $id)
    {
        $sertifikat = $this->getOwnedItem($id);
        if ($this->checkPengajuanProcessing($sertifikat)) {
            return redirect()->route('mahasiswa.sertifikat.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }

        if ($sertifikat->status === 'approved') {
            return redirect()->route('mahasiswa.sertifikat.index')->with('error', 'Data yang telah disetujui tidak dapat diubah.');
        }

        $data = $request->validated();
        $data['status'] = 'pending';
        $data['keterangan'] = null;

        $data['approved_by'] = null;
        $data['approved_at'] = null;

        if ($request->hasFile('file_bukti')) {
            if ($sertifikat->file_bukti) {
                Storage::disk('public')->delete($sertifikat->file_bukti);
            }
            $data['file_bukti'] = $request->file('file_bukti')->store('bukti_sertifikat', 'public');
        } else {
            unset($data['file_bukti']);
        }

        $sertifikat->update($data);
        $this->autoResubmitIfNeeded();

        if (request()->ajax()) { return response()->json(["success" => true, "message" => "Data sertifikat berhasil diperbarui."]); }

        return redirect()->route('mahasiswa.sertifikat.index')->with('success', 'Data sertifikat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sertifikat = $this->getOwnedItem($id);
        if ($this->checkPengajuanProcessing($sertifikat)) {
            return redirect()->route('mahasiswa.sertifikat.index')->with('error', 'Data tidak dapat dimodifikasi karena pengajuan SKPI sedang diproses atau sudah disetujui.');
        }

        if ($sertifikat->status === 'approved') {
            return redirect()->route('mahasiswa.sertifikat.index')->with('error', 'Data yang telah disetujui tidak dapat dihapus.');
        }

        if ($sertifikat->file_bukti) {
            Storage::disk('public')->delete($sertifikat->file_bukti);
        }

        $sertifikat->delete();

        if (request()->ajax()) { return response()->json(["success" => true, "message" => "Data sertifikat berhasil dihapus."]); }

        return redirect()->route('mahasiswa.sertifikat.index')->with('success', 'Data sertifikat berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $id_mahasiswa = Auth::user()->id_mahasiswa;
        $pengajuan = DB::table('pengajuan_skpi')->where('id_mahasiswa', $id_mahasiswa)->first();
        $query = DB::table('sertifikat_mahasiswa')->where('id_mahasiswa', $id_mahasiswa);

        if ($request->filled('jenis')) $query->where('jenis_sertifikat', $request->jenis);
        if ($request->filled('bidang')) $query->where('bidang', $request->bidang);
        if ($request->filled('status')) $query->where('status', $request->status);

        return DataTables::of($query)
            ->addColumn('jenis', fn($row) => $row->jenis_sertifikat)
            ->addColumn('tanggal_terbit', fn($row) => DataTableHelper::tanggal($row->tanggal_terbit))
            ->addColumn('bukti', fn($row) => DataTableHelper::buktiLink($row->file_bukti))
            ->addColumn('status', fn($row) => DataTableHelper::statusBadgeWithReason($row->status, $row->keterangan, ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger']))
            ->addColumn('action', function ($row) {
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a> ' . ' ' . '<a href="javascript:void(0)" onclick="editModal(this)" data-row="'.$rowJson.'" class="btn btn-sm btn-light btn-active-light-warning text-center" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></a>' . ' ' . '<button type="button" onclick="confirmDelete(\'' . $row->id_sertifikat . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>' . '</div>';
            })
            ->rawColumns(['action', 'bukti', 'status'])
            ->make(true);
    }

    private function getOwnedItem($id): SertifikatMahasiswa
    {
        $row = DB::table('sertifikat_mahasiswa')->where('id_sertifikat', $id)->first();
        if (!$row) {
            abort(404, 'Sertifikat tidak ditemukan.');
        }
        if ($row->id_mahasiswa !== Auth::user()->id_mahasiswa) {
            abort(403, 'Akses ditolak.');
        }
        return SertifikatMahasiswa::hydrate([(array) $row])->first();
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







