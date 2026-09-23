<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Verifikasi Keaslian SKPI Universitas Nurul Jadid">
    <title>Verifikasi Keaslian SKPI - Universitas Nurul Jadid</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/unuja.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style>
        body {
            background-color: #f8f9fa;
            background-image: radial-gradient(#e4e6ef 1px, transparent 1px);
            background-size: 24px 24px;
            font-family: 'Inter', Helvetica, sans-serif;
        }
        .official-card {
            background-color: #ffffff;
            border: 1px solid #e4e6ef;
            border-radius: 16px;
            box-shadow: 0px 20px 50px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }
        .official-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(90deg, #059669, #34d399, #059669);
            z-index: 10;
        }
        .official-card-inner {
            position: relative;
            z-index: 1;
            padding: 3rem;
            border: 1px solid rgba(0,0,0,0.03);
            border-radius: 12px;
            margin: 1rem;
            background: linear-gradient(180deg, #ffffff 0%, #fafcff 100%);
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.03;
            width: 350px;
            pointer-events: none;
            z-index: 0;
        }
        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .info-table th {
            text-align: left;
            padding: 16px 20px;
            color: #7e8299;
            font-weight: 500;
            font-size: 0.95rem;
            width: 35%;
            border-bottom: 1px dashed #e4e6ef;
        }
        .info-table td {
            font-weight: 700;
            color: #181c32;
            padding: 16px 20px;
            font-size: 1rem;
            border-bottom: 1px dashed #e4e6ef;
        }
        .info-table tr:last-child th,
        .info-table tr:last-child td {
            border-bottom: none;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0px 8px 15px rgba(16, 185, 129, 0.2);
            transition: all 0.3s ease;
        }
        .status-badge.success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #ffffff;
            border: 2px solid #34d399;
        }
        .status-badge i {
            color: #ffffff !important;
        }
        .institution-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .document-title {
            font-size: 1.1rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 5px;
        }
        .verification-footer {
            background-color: #f0fdf4;
            border-radius: 12px;
            border: 2px dashed #10b981;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
        .shield-icon {
            background: #e8fff3;
            color: #10b981;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        @media (max-width: 768px) {
            .official-card-inner {
                padding: 1.5rem;
                margin: 0.5rem;
            }
            .info-table th, .info-table td {
                display: block;
                width: 100%;
                padding: 10px 15px;
            }
            .info-table th {
                border-bottom: none;
                padding-bottom: 0;
            }
            .status-badge {
                padding: 10px 20px;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body id="kt_body" class="app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-column-fluid">
            <div class="d-flex flex-center flex-column flex-column-fluid p-5 p-lg-10">
                
                <div class="w-100 w-lg-800px official-card mx-auto">
                    <img src="{{ asset('assets/media/logos/unuja.png') }}" class="watermark" alt="Watermark" />
                    
                    <div class="official-card-inner">
                        <div class="text-center mb-12 pb-8 border-bottom border-gray-200">
                            <img alt="Logo UNUJA" src="{{ asset('assets/media/logos/unuja.png') }}" class="h-90px mb-6" />
                            <h1 class="institution-title mb-1">Universitas Nurul Jadid</h1>
                            <div class="document-title">Hasil Verifikasi Dokumen Akademik</div>
                        </div>

                        <div class="text-center mb-12">
                            <div class="status-badge success mb-6">
                                <i class="ki-duotone ki-shield-tick fs-1 me-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                Dokumen Valid
                            </div>
                            <p class="text-gray-600 fs-5 px-lg-10 lh-lg">
                                Menyatakan bahwa <strong>Surat Keterangan Pendamping Ijazah (SKPI)</strong> di bawah ini terdaftar resmi dan sah di basis data sistem akademik Universitas Nurul Jadid.
                            </p>
                        </div>

                        <div class="border border-gray-200 bg-white rounded-xl mb-12 overflow-hidden shadow-sm">
                            <table class="info-table">
                                <tbody>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>{{ $mahasiswa->nama_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Induk Mahasiswa (NIM)</th>
                                        <td>{{ $mahasiswa->nim }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fakultas</th>
                                        <td>{{ $fakultas->nama_fakultas ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Program Studi</th>
                                        <td>{{ $mahasiswa->programStudi->nama_prodi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Diterbitkan</th>
                                        <td>
                                            @if ($skpi && $skpi->tanggal_terbit)
                                                {{ \Carbon\Carbon::parse($skpi->tanggal_terbit)->translatedFormat('d F Y') }}
                                            @else
                                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nomor SKPI</th>
                                        <td class="text-primary font-monospace">{{ $skpi ? $skpi->nomor_skpi : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="verification-footer">
                            <div class="shield-icon">
                                <i class="ki-duotone ki-verify fs-2x">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-bold fs-5 mb-1" style="color: #065f46;">Otentikasi Digital</span>
                                <span class="fs-7 lh-base" style="color: #047857;">
                                    Dokumen ini dilindungi dan diverifikasi secara elektronik. Untuk informasi lebih lanjut mengenai capaian pembelajaran dan prestasi mahasiswa bersangkutan, silakan hubungi BAAK Universitas Nurul Jadid.
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="d-flex flex-center flex-column-auto p-10">
                    <div class="d-flex align-items-center fw-semibold fs-6 text-gray-500">
                        &copy; {{ date('Y') }} Universitas Nurul Jadid &mdash; Sistem Verifikasi SKPI
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>
</html>
