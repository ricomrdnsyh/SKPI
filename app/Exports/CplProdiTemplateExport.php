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
            'Urutan',
            'Deskripsi CPL'
        ];
    }

    public function array(): array
    {
        return [
            ['S', 'CPL-S01', '1', 'Bertakwa kepada Tuhan Yang Maha Esa dan mampu menunjukkan sikap religius.'],
            ['S', 'CPL-S02', '2', 'Menjunjung tinggi nilai kemanusiaan dalam menjalankan tugas berdasarkan agama, moral dan etika.'],
            ['KU', 'CPL-KU01', '1', 'Mampu menerapkan pemikiran logis, kritis, sistematis, dan inovatif dalam konteks pengembangan atau implementasi ilmu pengetahuan dan teknologi yang memperhatikan dan menerapkan nilai humaniora yang sesuai dengan bidang keahliannya.'],
            ['KK', 'CPL-KK01', '1', 'Mampu merancang dan mengembangkan algoritma untuk berbagai keperluan seperti Network Security, Data Compression Multimedia Technologies, Mobile Computing Intelligent Systems, Information Management, Algorithms and Complexity, Human-Computer Interaction, Graphics and Visual Computing.'],
            ['P', 'CPL-P01', '1', 'Menguasai konsep teoritis bidang pengetahuan Ilmu Komputer/Informatika secara umum dan konsep teoritis bagian khusus dalam bidang pengetahuan tersebut secara mendalam, serta mampu memformulasikan penyelesaian masalah prosedural.'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
