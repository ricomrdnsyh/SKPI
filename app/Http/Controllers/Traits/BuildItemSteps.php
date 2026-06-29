<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\DB;

trait BuildItemSteps
{
    protected function buildItemSteps(object $item): array
    {
        $class = get_class($item);
        $morphType = 'unknown';
        $itemId = null;

        if (str_contains($class, 'PrestasiMahasiswa')) {
            $morphType = 'prestasi';
            $itemId = $item->id_prestasi;
        } elseif (str_contains($class, 'OrganisasiMahasiswa')) {
            $morphType = 'organisasi';
            $itemId = $item->id_organisasi_mhs;
        } elseif (str_contains($class, 'SertifikatMahasiswa')) {
            $morphType = 'sertifikat';
            $itemId = $item->id_sertifikat;
        } elseif (str_contains($class, 'MagangMahasiswa')) {
            $morphType = 'magang';
            $itemId = $item->id_magang;
        }

        $approvals = DB::table('approvals')
            ->leftJoin('users', 'approvals.user_id', '=', 'users.id_user')
            ->where('approvable_type', $morphType)
            ->where('approvable_id', $itemId)
            ->select('approvals.*', 'users.nama_lengkap')
            ->get()
            ->keyBy('role');

        $steps = [
            [
                'label' => 'Diajukan',
                'done' => true,
                'icon' => 'check',
                'color' => 'bg-emerald-500',
                'info' => 'Data telah diajukan oleh Mahasiswa',
                'note' => null,
            ]
        ];

        // --- BAAK ---
        $baakRejected = $item->status === 'rejected';
        $baakApproved = !is_null($item->approved_by) && !$baakRejected;
        $baakDone = $baakApproved || $baakRejected;

        $baakApprovalRecord = $approvals->get('baak');
        $baakInfo = 'Menunggu verifikasi oleh BAAK';
        if ($baakApproved && $baakApprovalRecord) {
            $timeStr = date('d M Y H:i', strtotime($baakApprovalRecord->created_at));
            $baakInfo = "Disetujui oleh BAAK Fakultas ({$baakApprovalRecord->nama_lengkap}) - {$timeStr}";
        } elseif ($baakApproved) {
            $baakInfo = "Disetujui oleh BAAK Fakultas";
        } elseif ($baakRejected && $baakApprovalRecord) {
            $timeStr = date('d M Y H:i', strtotime($baakApprovalRecord->created_at));
            $baakInfo = "Ditolak oleh BAAK Fakultas ({$baakApprovalRecord->nama_lengkap}) - {$timeStr}";
        } elseif ($baakRejected) {
            $baakInfo = "Ditolak oleh BAAK Fakultas";
        }

        $steps[] = [
            'label' => $baakApproved ? 'Disetujui BAAK' : ($baakRejected ? 'Ditolak BAAK' : 'Verifikasi BAAK'),
            'done' => $baakDone,
            'icon' => $baakApproved ? 'check' : ($baakRejected ? 'xmark' : 'clock'),
            'color' => $baakApproved ? 'bg-emerald-500' : ($baakRejected ? 'bg-red-500' : 'bg-yellow-500'),
            'info' => $baakInfo,
            'note' => $baakRejected ? $item->keterangan : null,
        ];

        return $steps;
    }
}
