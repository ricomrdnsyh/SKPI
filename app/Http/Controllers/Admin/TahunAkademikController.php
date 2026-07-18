<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ClientSSO;

class TahunAkademikController extends Controller
{
    public function index()
    {
        return view('admin.tahun_akademik.index');
    }

    public function datatable(Request $request)
    {
        $query = DB::table('tahun_akademik')->orderBy('id_tahun_akademik', 'desc');

        return DataTables::of($query)
            ->addColumn('status', fn($f) => '<span class="badge ' . ($f->is_active ? 'badge-success' : 'badge-danger') . '">' . ($f->is_active ? 'Aktif' : 'Nonaktif') . '</span>')
            ->addColumn('action', function ($row) {
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a>' . '</div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function sync(ClientSSO $clientSSO)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        try {
            $data = $clientSSO->getTahunAkademikFromApi();

            if (empty($data)) {
                return response()->json(['success' => false, 'message' => 'Data dari API kosong.']);
            }

            $newCount = 0;
            $updatedCount = 0;
            $unchangedCount = 0;

            foreach ($data as $item) {
                $isActive = (isset($item['aktif']) && $item['aktif'] === 'y') ? true : false;
                
                $tahun = TahunAkademik::updateOrCreate(
                    ['id_tahun_akademik' => $item['id_smt']],
                    [
                        'nama' => $item['nm_smt'] ?? 'Tanpa Nama',
                        'is_active' => $isActive,
                    ]
                );

                if ($tahun->wasRecentlyCreated) {
                    $newCount++;
                } else if ($tahun->wasChanged()) {
                    $updatedCount++;
                } else {
                    $unchangedCount++;
                }
            }

            Cache::forget('master:tahun_akademik');

            $message = "Sinkronisasi Selesai. Baru: {$newCount}, Diperbarui: {$updatedCount}, Tetap: {$unchangedCount}.";

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal sinkronisasi: ' . $e->getMessage()], 500);
        }
    }
}
