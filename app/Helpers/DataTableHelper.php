<?php

namespace App\Helpers;

class DataTableHelper
{
    public static function progressBar(int $completed, int $total = 6): string
    {
        $percent = round(($completed / $total) * 100);
        return <<<HTML
        <div class="space-y-1" style="min-width: 120px;">
            <div class="flex items-center justify-between text-[10px] font-bold text-gray-500">
                <span>{$completed}/{$total} Selesai</span>
                <span class="text-unuja-600">{$percent}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-1">
                <div class="bg-emerald-500 h-1 rounded-full" style="width: {$percent}%"></div>
            </div>
        </div>
        HTML;
    }

    public static function statusBadge(string $status, array $map = []): string
    {
        $defaultMap = [
            'diajukan' => 'warning',
            'verifikasi' => 'info',
            'dicetak' => 'success',
            'ditolak' => 'danger',
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'draft' => 'secondary',
        ];

        $map = array_merge($defaultMap, $map);
        $class = $map[$status] ?? 'secondary';
        $label = ucwords(str_replace('_', ' ', $status));

        return '<span class="badge badge-' . $class . '">' . $label . '</span>';
    }

    public static function statusBadgeWithReason(string $status, ?string $keterangan, array $map = []): string
    {
        $html = self::statusBadge($status, $map);
        if ($status === 'rejected' || $status === 'ditolak') {
            $alasan = $keterangan ? e($keterangan) : '<i>Tidak ada catatan.</i>';
            $html .= '<p class="text-[10px] text-red-600 mt-0.5 leading-tight">' . $alasan . '</p>';
        }
        return $html;
    }

    public static function buktiLink(?string $filePath): string
    {
        if (!$filePath) return '-';
        return '<a href="' . asset('storage/' . $filePath) . '" target="_blank" class="btn btn-sm btn-light-primary px-3 py-2"><i class="fas fa-file-alt me-1"></i> File</a>';
    }

    public static function actionButtons(array $actions): string
    {
        $html = '<div class="d-flex justify-content-center gap-2">';
        foreach ($actions as $action) {
            if ($action['type'] === 'edit') {
                $html .= '<a href="' . $action['url'] . '" class="btn btn-sm btn-light btn-active-light-warning" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';
            } elseif ($action['type'] === 'delete') {
                $html .= '<form method="POST" action="' . $action['url'] . '" onsubmit="return confirm(\'Yakin ingin menghapus?\')" class="d-inline">'
                    . csrf_field() . method_field('DELETE')
                    . '<button type="submit" class="btn btn-sm btn-light btn-active-light-danger border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fa-solid fa-trash-can"></i></button></form>';
            } elseif ($action['type'] === 'detail' || $action['type'] === 'view') {
                $html .= '<a href="' . $action['url'] . '" class="btn btn-sm btn-light btn-active-light-info" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fa-solid fa-eye"></i></a>';
            } elseif ($action['type'] === 'custom') {
                $html .= $action['html'];
            }
        }
        $html .= '</div>';
        return $html;
    }

    public static function tanggal(\DateTime|string|null $date): string
    {
        if (!$date) return '-';
        return \Carbon\Carbon::parse($date)->isoFormat('D MMM YYYY');
    }
}
