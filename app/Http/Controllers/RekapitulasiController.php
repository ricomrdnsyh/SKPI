<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Helpers\DataTableHelper;
use Illuminate\Support\Facades\Auth;

class RekapitulasiController extends Controller
{
    use \App\Http\Controllers\Traits\FilterByProdi;

    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // Mendapatkan total SKPI selesai per Fakultas (tampilkan semua fakultas)
        $statsPerFakultasQuery = DB::table('fakultas')
            ->leftJoin('program_studi', 'fakultas.id_fakultas', '=', 'program_studi.id_fakultas')
            ->leftJoin('mahasiswa', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
            ->leftJoin('skpi', 'mahasiswa.nim', '=', 'skpi.nim')
            ->select('fakultas.nama_fakultas', DB::raw('COUNT(skpi.id_skpi) as total'));

        if ($role === 'bak_fakultas') {
            $idFakultas = $this->getAllowedFakultasIds($user);
            $statsPerFakultasQuery->whereIn('fakultas.id_fakultas', $idFakultas);
        }

        $statsPerFakultas = $statsPerFakultasQuery->groupBy('fakultas.id_fakultas', 'fakultas.nama_fakultas')->orderBy('fakultas.nama_fakultas')->get();

        $prodis = Cache::remember('master:prodi:all_ids_with_fakultas', 7200, function () {
            return DB::table('program_studi')->select('id_prodi', 'nama_prodi', 'id_fakultas')->orderBy('nama_prodi')->get();
        });

        if ($role === 'bak_fakultas') {
            $idFakultas = $this->getAllowedFakultasIds($user);
            $prodis = $prodis->filter(function ($prodi) use ($idFakultas) {
                return in_array($prodi->id_fakultas, $idFakultas);
            });
        }

        $tahun_akademiks = Cache::remember('master:tahun_akademik_ordered', 7200, function () {
            return DB::table('tahun_akademik')->orderByDesc('id_tahun_akademik')->pluck('nama', 'id_tahun_akademik')->toArray();
        });

        $active_tahun_akademik = Cache::remember('master:tahun_akademik_active', 7200, function () {
            return DB::table('tahun_akademik')->where('is_active', 1)->value('id_tahun_akademik');
        });

        $fakultas = Cache::remember('master:fakultas:all', 7200, function () {
            return DB::table('fakultas')->pluck('nama_fakultas', 'id_fakultas')->toArray();
        });
        
        $totalSkpiGlobal = $statsPerFakultas->sum('total');

        return view('rekapitulasi.index', compact('statsPerFakultas', 'totalSkpiGlobal', 'prodis', 'tahun_akademiks', 'active_tahun_akademik', 'fakultas', 'role'));
    }

    public function datatable(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $query = DB::table('skpi')
            ->join('mahasiswa', 'skpi.nim', '=', 'mahasiswa.nim')
            ->join('pengajuan_skpi', 'skpi.id_pengajuan', '=', 'pengajuan_skpi.id_pengajuan')
            ->join('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
            ->join('fakultas', 'program_studi.id_fakultas', '=', 'fakultas.id_fakultas')
            ->select([
                'skpi.id_skpi',
                'skpi.nomor_skpi',
                'skpi.tanggal_terbit',
                'skpi.ditandatangani_oleh',
                'pengajuan_skpi.sk_akreditasi',
                'mahasiswa.nim',
                'mahasiswa.nama_lengkap',
                'program_studi.nama_prodi',
                'fakultas.nama_fakultas',
                'pengajuan_skpi.id_tahun_akademik',
                'program_studi.id_fakultas',
                'program_studi.id_prodi',
                'skpi.id_pengajuan'
            ]);

        if ($role === 'bak_fakultas') {
            $idFakultas = $this->getAllowedFakultasIds($user);
            $query->whereIn('program_studi.id_fakultas', $idFakultas);
        }

        if ($request->filled('fakultas_filter')) {
            $query->where('program_studi.id_fakultas', $request->fakultas_filter);
        }
        if ($request->filled('prodi_filter')) {
            $query->where('mahasiswa.id_prodi', $request->prodi_filter);
        }
        if ($request->filled('tahun_akademik_filter')) {
            $query->where('pengajuan_skpi.id_tahun_akademik', $request->tahun_akademik_filter);
        }

        return \Yajra\DataTables\Facades\DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($item) use ($role) {
                $printUrl = route('bak_fakultas.skpi.print', $item->id_pengajuan);
                return \App\Helpers\DataTableHelper::actionButtons([
                    [
                        'type' => 'custom',
                        'html' => '<a href="' . $printUrl . '" target="_blank" class="btn btn-sm btn-light btn-active-light-info" data-bs-toggle="tooltip" data-bs-title="Lihat / Download PDF"><i class="fa-solid fa-eye"></i></a>'
                    ]
                ]);
            })
            ->editColumn('tanggal_terbit', function ($item) {
                return $item->tanggal_terbit ? \Carbon\Carbon::parse($item->tanggal_terbit)->locale('id')->isoFormat('D MMMM YYYY') : '-';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function downloadZip(Request $request, \App\Services\SkpiService $skpiService)
    {
        set_time_limit(300); // 5 minutes limit
        $user = Auth::user();
        $role = $user->role;

        $query = DB::table('skpi')
            ->join('mahasiswa', 'skpi.nim', '=', 'mahasiswa.nim')
            ->join('pengajuan_skpi', 'skpi.id_pengajuan', '=', 'pengajuan_skpi.id_pengajuan')
            ->join('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
            ->select(['pengajuan_skpi.id_pengajuan', 'skpi.nomor_skpi', 'mahasiswa.nama_lengkap', 'mahasiswa.nim']);

        if ($role === 'bak_fakultas') {
            $idFakultas = $this->getAllowedFakultasIds($user);
            $query->whereIn('program_studi.id_fakultas', $idFakultas);
        }

        if ($request->filled('fakultas_filter')) {
            $query->where('program_studi.id_fakultas', $request->fakultas_filter);
        }
        if ($request->filled('prodi_filter')) {
            $query->where('mahasiswa.id_prodi', $request->prodi_filter);
        }
        if ($request->filled('tahun_akademik_filter')) {
            $query->where('pengajuan_skpi.id_tahun_akademik', $request->tahun_akademik_filter);
        }

        $items = $query->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk diunduh.');
        }

        $zipFileName = 'Rekapitulasi_SKPI_' . date('Ymd_His') . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        $zip = new \ZipArchive();
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($items as $item) {
                $pengajuan = \App\Models\PengajuanSkpi::find($item->id_pengajuan);
                $skpi = \App\Models\Skpi::where('id_pengajuan', $item->id_pengajuan)->first();
                if ($pengajuan && $skpi) {
                    $pdf = $skpiService->generatePdf($pengajuan, $skpi);
                    $filename = "SKPI_{$item->nim}_{$item->nama_lengkap}.pdf";
                    // sanitize filename
                    $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename);
                    $zip->addFromString($filename, $pdf->output());
                }
            }
            $zip->close();
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}
