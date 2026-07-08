<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MasterDataController extends Controller
{
    public function dashboard()
    {
        $stats = Cache::remember('admin:dashboard:stats', 3600, function () {
            $tableMap = [
                'fakultas' => 'fakultas',
                'program_studi' => 'program_studi',
                'mahasiswa' => 'mahasiswa',
                'cpl_prodi' => 'cpl_prodi',
                'kurikulum' => 'kurikulum',
                'sistem_penilaian' => 'sistem_penilaian',
                'users' => 'users',
                'kategori_cpl' => 'kategori_cpl',
            ];

            $stats = collect($tableMap)->map(fn($t) => DB::table($t)->count())->all();

            $stats['cpl'] = $stats['cpl_prodi'];
            $stats['prodi'] = $stats['program_studi'];
            $stats['penilaian'] = $stats['sistem_penilaian'];
            unset($stats['cpl_prodi'], $stats['program_studi'], $stats['sistem_penilaian']);

            return $stats;
        });

        $statusCounts = Cache::remember('admin:skpi_status_counts', 3600, function () {
            return DB::table('pengajuan_skpi')
                ->selectRaw('COALESCE(status, "unknown") as status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status');
        });

        $permohonanCetakCount = Cache::remember('admin:skpi_permohonan_cetak_count', 3600, function () {
            return DB::table('pengajuan_skpi')
                ->where('status', 'verifikasi')
                ->where('permohonan_cetak', true)
                ->count();
        });

        $pendingCount = \App\Models\PengajuanSkpi::hasPendingItems()->count();

        $skpiStats = [
            'pending' => $pendingCount,
            'verifikasi' => $statusCounts->get('verifikasi', 0),
            'completed' => $statusCounts->get('dicetak', 0),
            'sudah_verifikasi' => $statusCounts->only(['verifikasi', 'dicetak', 'ditolak'])->sum(),
            'permohonan_cetak_count' => $permohonanCetakCount,
        ];

        $statuses = Cache::remember('master:pengajuan_statuses', 7200, function () {
            return DB::table('pengajuan_skpi')->select('status')->distinct()->pluck('status')->sort()->values();
        });

        $prodis = Cache::remember('master:prodi_names:all', 7200, function () {
            return DB::table('program_studi')->pluck('nama_prodi')->sort()->values();
        });

        return view('admin.dashboard', compact('stats', 'skpiStats', 'statuses', 'prodis'));
    }
}
