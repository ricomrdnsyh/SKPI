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

        return view('admin.dashboard', compact('stats'));
    }
}
