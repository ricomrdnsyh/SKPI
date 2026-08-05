<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Pendamping Ijazah</title>
    <style>
        @font-face {
            font-family: 'Garamond';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path('fonts/garamond.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Garamond';
            font-style: normal;
            font-weight: bold;
            src: url('{{ public_path('fonts/garamond_bold.ttf') }}') format('truetype');
        }

        body {
            font-family: 'Garamond', serif;
            font-size: 12pt;
            line-height: 1.25;
            color: #000;
        }

        @page {
            size: 210mm 330mm;
            margin: 1.5cm 1.5cm 1.5cm 1.5cm;
        }

        .header-title-container {
            text-align: center;
            margin-top: -20px;
            margin-bottom: 10px;
            padding-left: 50px;
        }

        .header-text {
            font-weight: bold;
            margin: 0;
            line-height: 1.0;
        }

        .header-contact-wrapper {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            margin-bottom: 25px;
            margin-left: -25px;
            margin-right: -25px;
        }

        .header-contact {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 50px;
            margin-top: -2px;
            margin-bottom: 1px;
            font-size: 10pt;
            line-height: 1.0;
        }

        .doc-title-container {
            text-align: center;
            margin-bottom: 5px;
        }

        .doc-number {
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 2px;
        }

        .doc-desc {
            font-size: 12pt;
            line-height: 1.0;
            color: #333;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: -1px;
            page-break-inside: auto;
        }

        .content-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .content-table th,
        .content-table td {
            border: 1px solid #f4b084;
            padding: 2px 4px;
            vertical-align: middle;
            line-height: 1.1;
        }

        .content-table .section-header {
            background-color: #ed7d31;
            font-weight: bold;
            text-align: left;
            padding-left: 30px;
            font-size: 12pt;
        }

        .label-col {
            width: 40%;
        }

        .signature-table {
            width: 100%;
            margin-top: 20px;
            border: none;
            page-break-inside: avoid;
        }

        .signature-table td {
            border: none;
            padding: 0;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header-title-container">
        <div class="header-text" style="font-size: 20pt;">YAYASAN NURUL JADID PAITON</div>
        <div class="header-text" style="font-size: 22pt;">
            {{ strtoupper($universitas->nama_perguruan_tinggi ?? 'UNIVERSITAS NURUL JADID') }}</div>
        <div class="header-text" style="font-size: 18pt;">SURAT KETERANGAN PENDAMPING IJAZAH</div>
    </div>

    <div class="header-contact-wrapper">
        <div class="header-contact">PP. Nurul Jadid Karanganyar Paiton Probolinggo 67291 Telp.
            {{ $universitas->no_telepon ?? '08883077077' }} Email: {{ $universitas->email ?? 'unuja@unuja.ac.id' }}
        </div>
    </div>

    <div class="doc-title-container">
        <div class="doc-number"><u>Nomor : {{ $skpi->nomor_skpi }}</u></div>
        <div class="doc-desc">
            Surat Keterangan Pendamping Ijazah sebagai pelengkap Ijazah yang menerangkan capaian pembelajaran dan<br>
            prestasi dari pemegang Ijazah selama masa studi
        </div>
    </div>

    <table class="content-table">
        <tr>
            <td colspan="2" class="section-header">01. INFORMASI TENTANG IDENTITAS DIRI PEMEGANG SKPI</td>
        </tr>
        <tr>
            <td class="label-col">Nama Lengkap</td>
            <td>{{ $mahasiswa->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="label-col">Tempat Dan Tanggal Lahir</td>
            <td>{{ $mahasiswa->tempat_lahir }},
                {{ \Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->isoFormat('D MMMM YYYY') }}</td>
        </tr>
        <tr>
            <td class="label-col">Nomer Induk Mahasiswa</td>
            <td>{{ $mahasiswa->nim }}</td>
        </tr>
        <tr>
            <td class="label-col">Nomer Ijazah Nasional</td>
            <td>{{ $skpi->nomor_ijazah_nasional }}</td>
        </tr>
        <tr>
            <td class="label-col">Tahun Masuk</td>
            <td>{{ $apiTahunMasuk ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Tahun Lulus</td>
            <td>{{ $apiTahunLulus ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Gelar</td>
            <td>{{ $mahasiswa->programStudi->gelar }}</td>
        </tr>
        <tr>
            <td colspan="2" class="section-header">02. INFORMASI TENTANG IDENTITAS PENYELENGGARA PROGRAM</td>
        </tr>
        <tr>
            <td class="label-col">SK Akreditasi Perguruan Tinggi</td>
            <td>{{ $universitas->sk_akreditasi ?? 'Terakreditasi Baik Sekali oleh BAN-PT' }}</td>
        </tr>
        <tr>
            <td class="label-col">Persyaratan Penerimaan</td>
            <td>{{ $mahasiswa->programStudi->persyaratan_penerimaan }}</td>
        </tr>
        <tr>
            <td class="label-col">Nama Perguruan Tinggi</td>
            <td>{{ $universitas->nama_perguruan_tinggi ?? 'Universitas Nurul Jadid' }}</td>
        </tr>
        <tr>
            <td class="label-col">Bahasa Pengantar Kuliah</td>
            <td>{{ $mahasiswa->programStudi->bahasa_pengantar }}</td>
        </tr>
        <tr>
            <td class="label-col">Fakultas</td>
            <td>{{ $fakultas->nama_fakultas }}</td>
        </tr>
        <tr>
            <td class="label-col">Program Studi</td>
            <td>{{ $mahasiswa->programStudi->nama_prodi }} ({{ $mahasiswa->programStudi->kode_prodi }})</td>
        </tr>
        <tr>
            <td class="label-col">Sistem Penilaian</td>
            <td>
                @php
                    $penilaianList = [];
                    foreach ($penilaian as $pn) {
                        $penilaianList[] = $pn->nilai_min . '-' . $pn->nilai_max . '=' . $pn->nilai_huruf;
                    }
                    echo implode(', ', $penilaianList) . '.';
                @endphp
            </td>
        </tr>
        <tr>
            <td class="label-col">Lama Studi Reguler</td>
            <td>{{ $mahasiswa->programStudi->lama_studi }}</td>
        </tr>
        <tr>
            <td class="label-col">Jenis & Jenjang Pendidikan</td>
            <td>{{ $mahasiswa->programStudi->jenis_pendidikan }} ({{ $mahasiswa->programStudi->jenjang }})</td>
        </tr>
        <tr>
            <td class="label-col">Jenis & Jenjang Pendidikan Lanjutan</td>
            <td>{{ $mahasiswa->programStudi->jenis_pendidikan_lanjutan }}</td>
        </tr>
        <tr>
            <td class="label-col">Jenjang Kualifikasi Sesuai KKNI</td>
            <td>{{ $mahasiswa->programStudi->jenjang_kkni }}</td>
        </tr>
        <tr>
            <td class="label-col">Status Profesi (Bila Ada)</td>
            <td>{{ $skpi->status_profesi ?? 'Belum ada keanggotaan profesi' }}</td>
        </tr>
    </table>

    <table class="content-table">
        <tr>
            <td colspan="2" class="section-header">03. INFORMASI TENTANG KUALIFIKASI DAN HASIL CAPAIAN</td>
        </tr>
        <tr>
            <td style="font-weight: bold; width: 12%; text-align: left; white-space: nowrap;">KODE</td>
            <td style="font-weight: bold; text-align: left; border-left: none;">CAPAIAN PEMBELAJARAN</td>
        </tr>
        @php
            $alphabet = 'A';
        @endphp
        @foreach ($cplList as $categoryName => $items)
            <tr>
                <td colspan="2" style="font-weight: bold; vertical-align: middle;">{{ $alphabet }}.
                    {{ strtoupper($categoryName) }}</td>
            </tr>
            @foreach ($items as $item)
                <tr>
                    <td style="text-align: left; border-right: none; white-space: nowrap; vertical-align: top;">
                        {{ $item->kode_cpl }}</td>
                    <td style="text-align: justify; border-left: none; vertical-align: top;">
                        <div style="text-align: justify;">{{ $item->deskripsi_cpl }}</div>
                    </td>
                </tr>
            @endforeach
            @php $alphabet++; @endphp
        @endforeach
    </table>

    <table class="content-table">
        <tr>
            <td colspan="2" class="section-header">04. INFORMASI TAMBAHAN</td>
        </tr>
        <tr>
            <td style="width: 5%; text-align: left; border-right: none; vertical-align: top;">4.1.</td>
            <td style="border-left: none;">
                Prestasi/Penghargaan<br>
                @if (!$prestasi->isEmpty())
                    @foreach ($prestasi as $p)
                        {{ $p->nama_prestasi }} ({{ $p->tahun }})<br>
                    @endforeach
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: left; border-right: none; vertical-align: top;">4.2.</td>
            <td style="border-left: none;">
                Keikutsertaan dalam organisasi<br>
                @if (!$organisasi->isEmpty())
                    @foreach ($organisasi as $o)
                        {{ $o->nama_organisasi }} ({{ $o->jabatan }}) Periode {{ $o->tahun_mulai }} -
                        {{ $o->tahun_selesai ?? 'Sekarang' }}<br>
                    @endforeach
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: left; border-right: none; vertical-align: top;">4.3.</td>
            <td style="border-left: none;">
                Sertifikat Keahlian<br>
                @if (!$sertifikat->isEmpty())
                    @foreach ($sertifikat as $s)
                        {{ $s->nama_sertifikat }}<br>
                    @endforeach
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: left; border-right: none; vertical-align: top;">4.4.</td>
            <td style="border-left: none;">
                Kerja Praktik/Magang<br>
                @if (!$magang->isEmpty())
                    @foreach ($magang as $m)
                        {{ $m->tempatMagang->nama_perusahaan }} ({{ $m->posisi }}) Periode
                        {{ \Carbon\Carbon::parse($m->tanggal_mulai)->isoFormat('D MMMM YYYY') }}
                        -
                        {{ \Carbon\Carbon::parse($m->tanggal_selesai)->isoFormat('D MMMM YYYY') }}<br>
                    @endforeach
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: left; border-right: none; vertical-align: top;">4.5.</td>
            <td style="border-left: none;">
                Judul Tugas Akhir<br>
                @if ($tugasAkhir)
                    {{ strtoupper($tugasAkhir->judul) }}<br>
                    @foreach ($tugasAkhir->pembimbingTugasAkhir as $index => $pta)
                        Pembimbing {{ $index + 1 }}: {{ $pta->nama_dosen }}<br>
                    @endforeach
                @endif
            </td>
        </tr>
    </table>

    <table class="signature-table">
        <tr>
            <td style="width: 50%; vertical-align: top; text-align: left; padding-left: 10px;">
                Probolinggo, {{ \Carbon\Carbon::parse($skpi->tanggal_terbit)->isoFormat('D MMMM YYYY') }}<br>
                Dekan,<br>
                @if ($pengajuan->status === 'dicetak')
                    @php
                        $verifyUrl = route('skpi.verify', ['id_skpi' => $skpi]);
                        $qrCodeBase64 = base64_encode(
                            \SimpleSoftwareIO\QrCode\Facades\QrCode::size(120)
                                ->errorCorrection('H')
                                ->generate($verifyUrl),
                        );
                        $logoPath = public_path('assets/media/logos/unuja.png');
                        $logoBase64 = base64_encode(file_get_contents($logoPath));
                    @endphp
                    <div
                        style="width: 120px; height: 120px; display: inline-block; text-align: left; margin-top: 4px; margin-bottom: 1px;">
                        <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" width="120" height="120"
                            style="display: block;" alt="QR Code Keaslian">
                        <div
                            style="margin-top: -77px; margin-left: 43px; width: 34px; height: 34px; background-color: white; border-radius: 2px;">
                            <img src="data:image/png;base64,{{ $logoBase64 }}" width="30" height="30"
                                style="margin-top: 2px; margin-left: 2px;">
                        </div>
                    </div><br>
                @else
                    <div style="width: 116px; height: 116px; display: inline-block; text-align: center; margin-top: 4px; margin-bottom: 1px; border: 2px dashed #999; border-radius: 8px;">
                        <div style="margin-top: 45px;"><strong style="font-size: 20px; color: #999;">DRAFT</strong></div>
                    </div><br>
                @endif
                <strong
                    style="text-decoration: underline;">{{ $skpi->ditandatangani_oleh ?? $fakultas->dekan }}</strong><br>
                NIY.{{ $skpi->nidn_penandatangan ?? $fakultas->niy_dekan }}
            </td>
            <td style="width: 50%;"></td>
        </tr>
    </table>
</body>

</html>
