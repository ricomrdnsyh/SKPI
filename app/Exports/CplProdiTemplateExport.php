<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CplProdiTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function headings(): array
    {
        return [
            'Kode Kategori',
            'Kode CPL',
            'Deskripsi CPL',
            'Urutan'
        ];
    }

    public function array(): array
    {
        return [
            ['S', 'S1', 'Bertakwa kepada Tuhan Yang Maha Esa dan mampu menunjukkan sikap religius', '1'],
            ['P', 'P1', 'Menguasai konsep teoritis bidang pengetahuan tertentu secara umum', '2'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
