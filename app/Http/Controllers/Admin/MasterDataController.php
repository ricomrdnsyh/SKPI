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

        $statusCounts = DB::table('pengajuan_skpi')
            ->selectRaw('COALESCE(status, "unknown") as status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $permohonanCetakCount = DB::table('pengajuan_skpi')
            ->where('status', 'verifikasi')
            ->where('permohonan_cetak', true)
            ->count();

        $pendingCount = \App\Models\PengajuanSkpi::hasPendingItems()->count();

        $skpiStats = [
            'pending' => $pendingCount,
            'verifikasi' => $statusCounts['verifikasi'] ?? 0,
            'completed' => $statusCounts['dicetak'] ?? 0,
            'sudah_verifikasi' => $statusCounts->only(['diajukan', 'verifikasi', 'dicetak', 'ditolak'])->sum(),
            'permohonan_cetak_count' => $permohonanCetakCount,
        ];

        $statuses = Cache::remember('master:pengajuan_statuses', 7200, function () {
            return DB::table('pengajuan_skpi')
                ->select('status')->distinct()
                ->pluck('status')->sort()->values();
        });

        $prodis = Cache::remember('master:prodi_with_fakultas:all', 7200, function () {
            return DB::table('program_studi')->select('id_fakultas', 'nama_prodi')->orderBy('nama_prodi')->get();
        });

        $tahun_akademiks = Cache::remember('master:tahun_akademik_ordered', 7200, function () {
            return DB::table('tahun_akademik')->orderByDesc('id_tahun_akademik')->pluck('nama', 'id_tahun_akademik')->toArray();
        });

        $active_tahun_akademik = Cache::remember('master:tahun_akademik_active', 7200, function () {
            return DB::table('tahun_akademik')->where('is_active', 1)->value('id_tahun_akademik');
        });

        $fakultas = Cache::remember('master:fakultas:all', 7200, function () {
            return DB::table('fakultas')->pluck('nama_fakultas', 'id_fakultas')->toArray();
        });

        return view('admin.dashboard', compact('stats', 'skpiStats', 'statuses', 'prodis', 'tahun_akademiks', 'active_tahun_akademik', 'fakultas'));
    }
}
