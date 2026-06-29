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
        $id_mahasiswa = Auth::user()->id_mahasiswa;
        $filterOptions = [
            'tingkat' => DB::table('organisasi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->select('tingkat')->distinct()->orderBy('tingkat')->pluck('tingkat'),
            'status' => DB::table('organisasi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->select('status')->distinct()->pluck('status'),
        ];
        return view('mahasiswa.organisasi.index', compact('filterOptions'));
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
        $data['id_mahasiswa'] = Auth::user()->id_mahasiswa;
        $data['status'] = 'pending';

        if ($request->hasFile('file_bukti')) {
            $data['file_bukti'] = $request->file('file_bukti')->store('bukti_organisasi', 'public');
        }

        OrganisasiMahasiswa::create($data);
        $this->autoResubmitIfNeeded();

        return redirect()->route('mahasiswa.organisasi.index')->with('success', 'Data organisasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $organisasi = $this->getOwnedItem($id);

        $id_mahasiswa = Auth::user()->id_mahasiswa;
        $pengajuan = DB::table('pengajuan_skpi')->where('id_mahasiswa', $id_mahasiswa)->first();

        $isRejected = $organisasi->status === 'rejected';
        $isLocked = !$isRejected && $pengajuan && in_array($pengajuan->status, ['dicetak']);
        $isApproved = $organisasi->status === 'approved';
        $readonly = $isLocked || $isApproved;

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

        return redirect()->route('mahasiswa.organisasi.index')->with('success', 'Data organisasi berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $id_mahasiswa = Auth::user()->id_mahasiswa;
        $pengajuan = DB::table('pengajuan_skpi')->where('id_mahasiswa', $id_mahasiswa)->first();
        $query = DB::table('organisasi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa);

        if ($request->filled('tingkat')) $query->where('tingkat', $request->tingkat);
        if ($request->filled('status')) $query->where('status', $request->status);

        return DataTables::of($query)
            ->addColumn('bukti', fn($row) => DataTableHelper::buktiLink($row->file_bukti))
            ->addColumn('status', fn($row) => DataTableHelper::statusBadgeWithReason($row->status, $row->keterangan, ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger']))
            ->addColumn('action', function ($row) use ($pengajuan) {
                $isRejected = $row->status === 'rejected';
                $isLocked = !$isRejected && $pengajuan && in_array($pengajuan->status, ['dicetak']);
                $isApproved = $row->status === 'approved';
                $readonly = $isLocked || $isApproved;

                if ($readonly) {
                    return DataTableHelper::actionButtons([
                        ['type' => 'detail', 'url' => route('mahasiswa.organisasi.edit', $row->id_organisasi_mhs)],
                    ]);
                } else {
                    return DataTableHelper::actionButtons([
                        ['type' => 'edit', 'url' => route('mahasiswa.organisasi.edit', $row->id_organisasi_mhs)],
                        ['type' => 'delete', 'url' => route('mahasiswa.organisasi.destroy', $row->id_organisasi_mhs)],
                    ]);
                }
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
        if ($row->id_mahasiswa !== Auth::user()->id_mahasiswa) {
            abort(403, 'Akses ditolak.');
        }
        return OrganisasiMahasiswa::hydrate([(array) $row])->first();
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
