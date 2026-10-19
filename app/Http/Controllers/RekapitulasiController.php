<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Helpers\DataTableHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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
        set_time_limit(600); // 10 minutes limit
        @ini_set('memory_limit', '512M');
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
            return back()->with('error', 'Tidak ada data SKPI selesai untuk diunduh pada filter yang dipilih.');
        }

        if ($items->count() > 50) {
            return back()->with('error', "Jumlah data terlalu banyak ({$items->count()} mahasiswa). Batas maksimal unduh langsung adalah 50 berkas agar tidak terjadi timeout pada server. Silakan gunakan filter Program Studi dan Tahun Akademik untuk memperkecil data.");
        }

        if (!class_exists(\ZipArchive::class)) {
            return back()->with('error', 'Ekstensi PHP ZipArchive belum terpasang atau aktif di server.');
        }

        $storageDir = storage_path('app/public');
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        $zipFileName = 'Rekapitulasi_SKPI_' . date('Ymd_His') . '.zip';
        $zipFilePath = $storageDir . DIRECTORY_SEPARATOR . $zipFileName;

        $zip = new \ZipArchive();
        $openResult = $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        if ($openResult !== TRUE) {
            \Illuminate\Support\Facades\Log::error("ZipArchive::open gagal dengan kode: {$openResult} pada {$zipFilePath}");
            return back()->with('error', 'Gagal membuat file ZIP di server. Pastikan izin tulis (permission) folder storage/app/public sudah benar.');
        }

        $countSuccess = 0;
        foreach ($items as $item) {
            try {
                $pengajuan = \App\Models\PengajuanSkpi::find($item->id_pengajuan);
                $skpi = \App\Models\Skpi::where('id_pengajuan', $item->id_pengajuan)->first();
                if ($pengajuan && $skpi) {
                    $pdf = $skpiService->generatePdf($pengajuan, $skpi);
                    $filename = "SKPI_{$item->nim}_{$item->nama_lengkap}.pdf";
                    // sanitize filename
                    $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename);
                    $zip->addFromString($filename, $pdf->output());
                    $countSuccess++;
                    unset($pdf);
                    gc_collect_cycles();
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning("Gagal generate PDF SKPI untuk NIM {$item->nim}: " . $e->getMessage());
            }
        }
        $zip->close();

        if ($countSuccess === 0 || !file_exists($zipFilePath)) {
            if (file_exists($zipFilePath)) {
                @unlink($zipFilePath);
            }
            return back()->with('error', 'Tidak ada file PDF yang berhasil dibuat ke dalam ZIP.');
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function initBatchZip(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $this->cleanOldBatches();

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
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada data SKPI selesai untuk diunduh pada filter yang dipilih.'
            ], 422);
        }

        if (!class_exists(\ZipArchive::class)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ekstensi PHP ZipArchive belum terpasang atau aktif di server.'
            ], 500);
        }

        $batchId = (string) Str::uuid();
        $batchDir = storage_path('app/public/zip_batches/' . $batchId);
        $filesDir = $batchDir . '/files';

        if (!is_dir($filesDir)) {
            mkdir($filesDir, 0755, true);
        }

        $manifest = [
            'batch_id' => $batchId,
            'created_at' => now()->toIso8601String(),
            'total' => $items->count(),
            'items' => $items->toArray()
        ];

        file_put_contents($batchDir . '/manifest.json', json_encode($manifest));

        return response()->json([
            'status' => 'success',
            'batch_id' => $batchId,
            'total' => $items->count(),
            'chunk_size' => 15
        ]);
    }

    public function processBatchZip(Request $request, \App\Services\SkpiService $skpiService)
    {
        $batchId = $request->batch_id;
        if (!Str::isUuid($batchId)) {
            return response()->json(['status' => 'error', 'message' => 'Batch ID tidak valid.'], 400);
        }

        $batchDir = storage_path('app/public/zip_batches/' . $batchId);
        $manifestPath = $batchDir . '/manifest.json';
        if (!file_exists($manifestPath)) {
            return response()->json(['status' => 'error', 'message' => 'Sesi unduhan telah kedaluwarsa atau tidak ditemukan.'], 404);
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);
        $items = $manifest['items'] ?? [];
        $total = count($items);
        $offset = (int) $request->input('offset', 0);
        $limit = (int) $request->input('limit', 15);

        $chunk = array_slice($items, $offset, $limit);
        $filesDir = $batchDir . '/files';
        if (!is_dir($filesDir)) {
            mkdir($filesDir, 0755, true);
        }

        set_time_limit(180);
        @ini_set('memory_limit', '512M');

        foreach ($chunk as $item) {
            $item = (object) $item;
            try {
                $filename = "SKPI_{$item->nim}_{$item->nama_lengkap}.pdf";
                $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename);
                $filePath = $filesDir . DIRECTORY_SEPARATOR . $filename;

                if (!file_exists($filePath)) {
                    $pengajuan = \App\Models\PengajuanSkpi::find($item->id_pengajuan);
                    $skpi = \App\Models\Skpi::where('id_pengajuan', $item->id_pengajuan)->first();
                    if ($pengajuan && $skpi) {
                        $pdf = $skpiService->generatePdf($pengajuan, $skpi);
                        file_put_contents($filePath, $pdf->output());
                        unset($pdf);
                        gc_collect_cycles();
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("Gagal generate PDF SKPI untuk NIM {$item->nim}: " . $e->getMessage());
            }
        }

        $nextOffset = $offset + count($chunk);
        $percent = $total > 0 ? (int) round(($nextOffset / $total) * 100) : 100;
        if ($percent > 100) $percent = 100;

        return response()->json([
            'status' => 'success',
            'current' => $nextOffset,
            'total' => $total,
            'percent' => $percent,
            'done' => $nextOffset >= $total
        ]);
    }

    public function finalizeBatchZip(Request $request)
    {
        $batchId = $request->batch_id;
        if (!Str::isUuid($batchId)) {
            return response()->json(['status' => 'error', 'message' => 'Batch ID tidak valid.'], 400);
        }

        $batchDir = storage_path('app/public/zip_batches/' . $batchId);
        $filesDir = $batchDir . '/files';
        if (!is_dir($filesDir)) {
            return response()->json(['status' => 'error', 'message' => 'Direktori berkas tidak ditemukan.'], 404);
        }

        $zipFileName = 'Rekapitulasi_SKPI_' . date('Ymd_His') . '.zip';
        $zipFilePath = $batchDir . DIRECTORY_SEPARATOR . $zipFileName;

        $zip = new \ZipArchive();
        $openResult = $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        if ($openResult !== TRUE) {
            return response()->json(['status' => 'error', 'message' => 'Gagal membuat arsip ZIP di server.'], 500);
        }

        $pdfFiles = glob($filesDir . DIRECTORY_SEPARATOR . '*.pdf');
        if (empty($pdfFiles)) {
            $zip->close();
            return response()->json(['status' => 'error', 'message' => 'Tidak ada file PDF yang berhasil dibuat.'], 422);
        }

        foreach ($pdfFiles as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();

        // Clean up individual pdf files to save disk space
        foreach ($pdfFiles as $file) {
            @unlink($file);
        }
        @rmdir($filesDir);
        @unlink($batchDir . '/manifest.json');

        return response()->json([
            'status' => 'success',
            'download_url' => route('rekapitulasi.zip.download', $batchId),
            'total_files' => count($pdfFiles)
        ]);
    }

    public function downloadBatchZip(string $batchId)
    {
        if (!Str::isUuid($batchId)) {
            abort(404);
        }

        $batchDir = storage_path('app/public/zip_batches/' . $batchId);
        $zipFiles = glob($batchDir . DIRECTORY_SEPARATOR . '*.zip');

        if (empty($zipFiles) || !file_exists($zipFiles[0])) {
            abort(404, 'File ZIP tidak ditemukan atau telah kedaluwarsa.');
        }

        $zipFilePath = $zipFiles[0];

        return response()->download($zipFilePath, basename($zipFilePath))->deleteFileAfterSend(true);
    }

    private function cleanOldBatches(): void
    {
        $baseDir = storage_path('app/public/zip_batches');
        if (!is_dir($baseDir)) return;

        $now = time();
        foreach (glob($baseDir . '/*', GLOB_ONLYDIR) as $dir) {
            if ($now - filemtime($dir) > 7200) { // older than 2 hours
                File::deleteDirectory($dir);
            }
        }
    }
}
