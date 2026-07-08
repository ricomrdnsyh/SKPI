<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Pendamping Ijazah</title>
    <style>
        @font-face {
            font-family: 'Cambria';
            src: url('{{ public_path('fonts/cambriab.ttf') }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'Cambria';
            src: url('{{ public_path('fonts/cambriai.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: italic;
        }

        @font-face {
            font-family: 'Cambria';
            src: url('{{ public_path('fonts/cambriaz.ttf') }}') format('truetype');
            font-weight: bold;
            font-style: italic;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }

        @page {
            margin: 0.5cm 2cm 2cm 2cm;
        }

        .header-table {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .title-uni {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        .sub-uni {
            font-size: 11px;
            text-align: center;
        }

        .title-doc {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 40px;
            line-height: 1.2;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            background-color: #f2f2f2;
            padding: 5px;
            margin-top: 15px;
            margin-bottom: 10px;
            border-left: 5px solid #163673;
            text-transform: uppercase;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .data-table td {
            padding: 4px;
            vertical-align: top;
        }

        .data-table td.label {
            width: 35%;
            font-weight: bold;
        }

        .data-table td.separator {
            width: 2%;
        }

        .data-table td.value {
            width: 63%;
        }

        .grid-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .grid-table th,
        .grid-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        .grid-table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .cpl-category {
            font-weight: bold;
            color: #163673;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .footer-table {
            width: 100%;
            margin-top: 30px;
        }

        .footer-table td {
            width: 50%;
            vertical-align: top;
        }

        .page-break {
            page-break-after: always;
        }

        .logo-cell {
            width: 17%;
            text-align: center;
            vertical-align: middle;
            padding-top: 10px;
            padding-bottom: 15px;
        }

        .title-cell {
            width: 58%;
            text-align: left;
            vertical-align: middle;
            padding-left: 20px;
            padding-top: 10px;
            padding-bottom: 15px;
            font-family: 'Cambria', 'Times New Roman', Times, serif;
        }

        .contact-cell {
            width: 25%;
            text-align: right;
            vertical-align: middle;
            font-style: italic;
            color: #777;
            font-size: 10px;
            font-family: 'Cambria', 'Times New Roman', Times, serif;
            line-height: 1.2;
            padding-top: 10px;
            padding-bottom: 15px;
        }
    </style>
</head>

<body>
    <div
        style="position: absolute; top: -2cm; left: -0.1cm; width: 18%; height: 200px; background-color: #264a85; z-index: -1;">
    </div>
    <table class="header-table" style="width: 100%; border: none; margin-bottom: 25px; border-collapse: collapse;">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('unuja.png') }}" alt="Logo UNUJA" style="width: 100px; height: auto;">
            </td>
            <td class="title-cell">
                <div
                    style="font-size: 16px; color: #000; margin-bottom: 0px; font-family: 'Cambria', 'Times New Roman', Times, serif; line-height: 1;">
                    YAYASAN NURUL JADID PAITON</div>
                <div
                    style="font-size: 20px; font-weight: bold; color: #000; margin-top: 0px; margin-bottom: 0px; font-family: 'Cambria', 'Times New Roman', Times, serif; text-transform: uppercase; line-height: 1;">
                    FAKULTAS {{ $fakultas->nama_fakultas ?? 'FAKULTAS AGAMA ISLAM' }}</div>
                <div
                    style="font-size: 26px; font-weight: bold; color: #163673; margin-top: -2px; margin-bottom: 0px; font-family: 'Cambria', 'Times New Roman', Times, serif; line-height: 1;">
                    UNIVERSITAS NURUL JADID</div>
                <div
                    style="font-size: 16px; color: #000; margin-top: 2px; font-family: 'Cambria', 'Times New Roman', Times, serif; line-height: 1;">
                    PROBOLINGGO JAWA TIMUR</div>
            </td>
            <td class="contact-cell">
                PP. Nurul Jadid<br>
                Karanganyar Paiton<br>
                Probolinggo 67291<br>
                {{ $fakultas->no_telepon ?? '0888 30 77077' }}<br>
                {{ strtolower($fakultas->kode_fakultas ?? 'info') }}@unuja.ac.id
            </td>
        </tr>
    </table>
    <div class="title-doc">
        <u>Surat Keterangan Pendamping Ijazah</u><br>
        <span style="font-size: 10px; font-weight: normal;">Nomor: {{ $skpi->nomor_skpi }}</span>
    </div>
    <div class="section-title">1. Identitas Pemegang SKPI</div>
    <table class="data-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="label">Tempat dan Tanggal Lahir</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->tempat_lahir }},
                {{ \Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->isoFormat('D MMMM YYYY') }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Induk Mahasiswa (NIM)</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->nim }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Ijazah Nasional (NIM Ijazah)</td>
            <td class="separator">:</td>
            <td class="value">{{ $skpi->nim_ijazah }}</td>
        </tr>
        <tr>
            <td class="label">Tahun Masuk / Tahun Lulus</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->tahun_masuk }} / {{ $mahasiswa->tahun_lulus }}</td>
        </tr>
        <tr>
            <td class="label">Gelar yang Diberikan</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->programStudi->gelar }}</td>
        </tr>
    </table>
    <div class="section-title">2. Identitas Penyelenggara Program</div>
    <table class="data-table">
        <tr>
            <td class="label">Nama Perguruan Tinggi</td>
            <td class="separator">:</td>
            <td class="value">Universitas Nurul Jadid</td>
        </tr>
        <tr>
            <td class="label">SK Akreditasi Perguruan Tinggi</td>
            <td class="separator">:</td>
            <td class="value">Terakreditasi Baik Sekali oleh BAN-PT</td>
        </tr>
        <tr>
            <td class="label">Fakultas / Program Studi</td>
            <td class="separator">:</td>
            <td class="value">{{ $fakultas->nama_fakultas }} / {{ $mahasiswa->programStudi->nama_prodi }}</td>
        </tr>
        <tr>
            <td class="label">SK Akreditasi Program Studi</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->programStudi->sk_akreditasi }}</td>
        </tr>
        <tr>
            <td class="label">Jenis & Jenjang Pendidikan</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->programStudi->jenis_pendidikan }}</td>
        </tr>
        <tr>
            <td class="label">Jenjang Kualifikasi KKNI</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->programStudi->jenjang_kkni }}</td>
        </tr>
        <tr>
            <td class="label">Bahasa Pengantar Kuliah</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->programStudi->bahasa_pengantar }}</td>
        </tr>
        <tr>
            <td class="label">Lama Studi Reguler</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->programStudi->lama_studi }}</td>
        </tr>
        <tr>
            <td class="label">Persyaratan Penerimaan</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->programStudi->persyaratan_penerimaan }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Pendidikan Lanjutan</td>
            <td class="separator">:</td>
            <td class="value">{{ $mahasiswa->programStudi->jenis_pendidikan_lanjutan }}</td>
        </tr>
        <tr>
            <td class="label">Status Profesi (Bila Ada)</td>
            <td class="separator">:</td>
            <td class="value">{{ $skpi->status_profesi ?? 'Belum ada keanggotaan profesi' }}</td>
        </tr>
    </table>
    <div class="page-break"></div>
    <div class="section-title">3. Capaian Pembelajaran Lulusan (CPL)</div>
    <div style="font-size: 10px; margin-bottom: 10px; font-style: italic;">
        Capaian Pembelajaran Lulusan merujuk pada Kerangka Kualifikasi Nasional Indonesia (KKNI):
    </div>
    @foreach ($cplList as $categoryName => $items)
        <div class="cpl-category">{{ $categoryName }}</div>
        <table class="grid-table" style="font-size: 10px; margin-bottom: 10px;">
            <thead>
                <tr>
                    <th style="width: 15%;">Kode</th>
                    <th style="width: 85%;">Deskripsi Kompetensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td style="font-weight: bold;">{{ $item->kode_cpl }}</td>
                        <td>{{ $item->deskripsi_cpl }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
    <div class="page-break"></div>
    <div class="section-title">4. Informasi Tambahan (Prestasi & Aktivitas)</div>
    <div style="font-weight: bold; margin-bottom: 5px;">A. Prestasi dan Penghargaan</div>
    @if ($prestasi->isEmpty())
        <div style="font-style: italic; margin-bottom: 10px; padding-left: 10px;">Tidak ada data prestasi yang
            diverifikasi.</div>
    @else
        <table class="grid-table" style="font-size: 10px; margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>Nama Kegiatan / Prestasi</th>
                    <th>Tingkat</th>
                    <th>Peringkat</th>
                    <th>Penyelenggara / Tahun</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prestasi as $p)
                    <tr>
                        <td>{{ $p->nama_prestasi }}</td>
                        <td>{{ $p->tingkat }}</td>
                        <td>{{ $p->peringkat }}</td>
                        <td>{{ $p->penyelenggara }} ({{ $p->tahun }})</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div style="font-weight: bold; margin-bottom: 5px;">B. Keikutsertaan Organisasi Mahasiswa</div>
    @if ($organisasi->isEmpty())
        <div style="font-style: italic; margin-bottom: 10px; padding-left: 10px;">Tidak ada data organisasi yang
            diverifikasi.</div>
    @else
        <table class="grid-table" style="font-size: 10px; margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>Nama Organisasi</th>
                    <th>Tingkat</th>
                    <th>Jabatan</th>
                    <th>Masa Bakti</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($organisasi as $o)
                    <tr>
                        <td>{{ $o->nama_organisasi }}</td>
                        <td>{{ $o->tingkat }}</td>
                        <td>{{ $o->jabatan }}</td>
                        <td>{{ $o->tahun_mulai }} - {{ $o->tahun_selesai ?? 'Sekarang' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div style="font-weight: bold; margin-bottom: 5px;">C. Sertifikat Keahlian & Pelatihan</div>
    @if ($sertifikat->isEmpty())
        <div style="font-style: italic; margin-bottom: 10px; padding-left: 10px;">Tidak ada data sertifikat yang
            diverifikasi.</div>
    @else
        <table class="grid-table" style="font-size: 10px; margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>Nama Sertifikasi / Pelatihan</th>
                    <th>Jenis</th>
                    <th>Bidang / Kompetensi</th>
                    <th>Penyelenggara / Tanggal Terbit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sertifikat as $s)
                    <tr>
                        <td>{{ $s->nama_sertifikat }}</td>
                        <td>{{ $s->jenis_sertifikat }}</td>
                        <td>{{ $s->bidang }}</td>
                        <td>{{ $s->penyelenggara }}
                            ({{ \Carbon\Carbon::parse($s->tanggal_terbit)->isoFormat('D MMM YYYY') }})
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div style="font-weight: bold; margin-bottom: 5px;">D. Kerja Praktik / Magang Industri</div>
    @if ($magang->isEmpty())
        <div style="font-style: italic; margin-bottom: 10px; padding-left: 10px;">Tidak ada data magang yang
            diverifikasi.</div>
    @else
        <table class="grid-table" style="font-size: 10px; margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>Mitra Industri</th>
                    <th>Posisi Intern</th>
                    <th>Periode Kegiatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($magang as $m)
                    <tr>
                        <td>{{ $m->tempatMagang->nama_perusahaan }} ({{ $m->tempatMagang->alamat }})</td>
                        <td>{{ $m->posisi }}</td>
                        <td>{{ \Carbon\Carbon::parse($m->tanggal_mulai)->isoFormat('D MMM YYYY') }} -
                            {{ \Carbon\Carbon::parse($m->tanggal_selesai)->isoFormat('D MMM YYYY') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div style="font-weight: bold; margin-bottom: 5px;">E. Judul Tugas Akhir (Skripsi)</div>
    @if (!$tugasAkhir)
        <div style="font-style: italic; margin-bottom: 10px; padding-left: 10px;">Tidak ada data Tugas Akhir.</div>
    @else
        <table class="data-table" style="margin-left: 10px;">
            <tr>
                <td style="width: 20%; font-weight: bold;">Judul Skripsi</td>
                <td style="width: 2%;">:</td>
                <td style="width: 78%; font-style: italic;">"{{ $tugasAkhir->judul }}"</td>
            </tr>
            @foreach ($tugasAkhir->pembimbingTugasAkhir as $index => $pta)
                <tr>
                    <td style="font-weight: bold;">Pembimbing {{ $index + 1 }}</td>
                    <td>:</td>
                    <td>{{ $pta->nama_dosen }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    <div style="font-weight: bold; margin-top: 15px; margin-bottom: 5px;">F. Tabel Sistem Penilaian</div>
    <table class="grid-table" style="font-size: 9px; width: 60%; margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Nilai Huruf</th>
                <th>Nilai Minimum</th>
                <th>Nilai Maksimum</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penilaian as $pn)
                <tr>
                    <td style="font-weight: bold; text-align: center;">{{ $pn->nilai_huruf }}</td>
                    <td style="text-align: center;">{{ $pn->nilai_min }}</td>
                    <td style="text-align: center;">{{ $pn->nilai_max }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="footer-table">
        <tr>
            <td style="width: 50%; vertical-align: bottom;">
                <div
                    style="font-size: 8px; color: #555; border: 1px solid #ddd; padding: 8px; border-radius: 4px; width: 85%; line-height: 1.3;">
                    <strong>Pernyataan Keaslian Dokumen:</strong><br>
                    Dokumen ini diterbitkan secara elektronik oleh Universitas Nurul Jadid dan telah disetujui secara
                    digital oleh Dekan. Scan QR code di sebelah kanan menggunakan kamera ponsel untuk memverifikasi
                    keaslian data langsung pada sistem penjaminan mutu universitas.
                </div>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: top;">
                <div style="display: inline-block; text-align: left;">
                    Probolinggo, {{ \Carbon\Carbon::parse($skpi->tanggal_terbit)->isoFormat('D MMMM YYYY') }}<br>
                    Dekan Fakultas Teknik,<br>
                    <div style="margin-top: 8px; margin-bottom: 8px;">
                    @php
                        $verifyUrl = route('skpi.verify', ['id_skpi' => $skpi]);
                        $qrCodeBase64 = base64_encode(
                            \SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate($verifyUrl),
                        );
                    @endphp
                    <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" width="80" height="80"
                        alt="QR Code Keaslian">
                </div>
                <strong
                    style="text-decoration: underline;">{{ $skpi->ditandatangani_oleh ?? $fakultas->dekan }}</strong><br>
                NIDN: {{ $skpi->nidn_penandatangan ?? $fakultas->nidn_dekan }}
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
