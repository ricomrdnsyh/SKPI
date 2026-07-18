<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ClientSSO;

use App\Http\Controllers\Traits\FilterByProdi;

class FakultasController extends Controller
{
    use FilterByProdi;

    public function index()
    {
        return view('admin.fakultas.index');
    }

    // Tambah (create/store) dihapus karena sudah disinkronkan dari API

    public function edit($id)
    {
        $allowedFakultas = $this->getAllowedFakultasIds();
        if ($allowedFakultas !== null && !in_array($id, $allowedFakultas)) {
            abort(403, 'Akses ditolak.');
        }

        $row = DB::table('fakultas')->where('id_fakultas', $id)->first();
        if (!$row) abort(404);
        $fakultas = Fakultas::hydrate([(array) $row])->first();
        return view('admin.fakultas.edit', compact('fakultas'));
    }

    public function update(Request $request, $id)
    {
        $allowedFakultas = $this->getAllowedFakultasIds();
        if ($allowedFakultas !== null && !in_array($id, $allowedFakultas)) {
            abort(403, 'Akses ditolak.');
        }

        $row = DB::table('fakultas')->where('id_fakultas', $id)->first();
        if (!$row) abort(404);
        $fakultas = Fakultas::hydrate([(array) $row])->first();

        $messages = [
            'nama_fakultas.required' => 'Nama fakultas wajib diisi.',
            'kode_fakultas.max' => 'Kode fakultas maksimal 10 karakter.',
            'no_telepon.max' => 'Nomor telepon maksimal 15 karakter.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.'
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'nama_fakultas' => 'required|string|max:255',
            'kode_fakultas' => 'nullable|string|max:10',
            'dekan' => 'nullable|string|max:100',
            'nidn_dekan' => 'nullable|string|max:50',
            'no_telepon' => 'nullable|string|max:15',
            'status' => 'required|in:aktif,nonaktif',
        ], $messages);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['nama_fakultas', 'kode_fakultas', 'dekan', 'nidn_dekan', 'no_telepon', 'status']);
        $fakultas->update($data);

        Cache::forget('master:fakultas');
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data fakultas berhasil diperbarui.']);
        }
        return redirect()->route('fakultas.index')->with('success', 'Data fakultas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
            }
            abort(403, 'Akses ditolak.');
        }
        $row = DB::table('fakultas')->where('id_fakultas', $id)->first();
        if (!$row) abort(404);
        $fakultas = Fakultas::hydrate([(array) $row])->first();
        $fakultas->delete();
        Cache::forget('master:fakultas');
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data fakultas berhasil dihapus.']);
        }
        return redirect()->route('fakultas.index')->with('success', 'Data fakultas berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $query = DB::table('fakultas');

        $allowedFakultas = $this->getAllowedFakultasIds();
        if ($allowedFakultas !== null) {
            $query->whereIn('id_fakultas', $allowedFakultas);
        }

        return DataTables::of($query)
            ->addColumn('kode', fn($f) => $f->kode_fakultas ?? '-')
            ->addColumn('status', fn($f) => '<span class="badge ' . ($f->status === 'aktif' ? 'badge-success' : 'badge-danger') . '">' . ucfirst($f->status) . '</span>')
            ->addColumn('action', function ($row) {
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                $btn = '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a>' . ' ' . '<a href="javascript:void(0)" onclick="editModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-warning text-center" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></a>';
                if (Auth::user()->role === 'admin') {
                    $btn .= ' ' . '<button type="button" onclick="confirmDelete(\'' . $row->id_fakultas . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>';
                }
                $btn .= '</div>';
                return $btn;
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
            $data = $clientSSO->getFakultasFromApi();

            if (empty($data)) {
                return response()->json(['success' => false, 'message' => 'Data dari API kosong.']);
            }

            $newCount = 0;
            $updatedCount = 0;
            $unchangedCount = 0;

            foreach ($data as $item) {
                $fakultas = Fakultas::updateOrCreate(
                    ['id_fakultas' => $item['id_fakultas']],
                    [
                        'nama_fakultas' => $item['fakultas'] ?? 'Tanpa Nama',
                        'kode_fakultas' => $item['singkatan'] ?? null,
                    ]
                );

                if ($fakultas->wasRecentlyCreated) {
                    $newCount++;
                } else if ($fakultas->wasChanged()) {
                    $updatedCount++;
                } else {
                    $unchangedCount++;
                }
            }

            Cache::forget('master:fakultas');

            $message = "Sinkronisasi Selesai. Baru: {$newCount}, Diperbarui: {$updatedCount}, Tetap: {$unchangedCount}.";

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal sinkronisasi: ' . $e->getMessage()], 500);
        }
    }
}
