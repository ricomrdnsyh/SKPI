<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Verifikasi Keaslian SKPI Universitas Nurul Jadid">
    <title>Verifikasi Gagal - SKPI Universitas Nurul Jadid</title>
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
            background: linear-gradient(90deg, #be123c, #fb7185, #be123c);
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
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0px 8px 15px rgba(225, 29, 72, 0.2);
            transition: all 0.3s ease;
        }
        .status-badge.danger {
            background: linear-gradient(135deg, #e11d48, #be123c);
            color: #ffffff;
            border: 2px solid #fb7185;
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
            background-color: #fff1f2;
            border-radius: 12px;
            border: 2px dashed #fb7185;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
        .shield-icon {
            background: #ffe4e6;
            color: #e11d48;
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
                            <div class="status-badge danger mb-6">
                                <i class="ki-duotone ki-shield-cross fs-1 me-2">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                </i>
                                Dokumen Tidak Ditemukan
                            </div>
                            <p class="text-gray-600 fs-5 px-lg-10 lh-lg">
                                Maaf, QR Code ini tidak valid atau dokumen Surat Keterangan Pendamping Ijazah (SKPI) belum diterbitkan oleh pihak terkait.
                            </p>
                        </div>

                        <div class="verification-footer">
                            <div class="shield-icon">
                                <i class="ki-duotone ki-information-5 fs-2x">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-bold fs-5 mb-1" style="color: #9f1239;">Pusat Bantuan</span>
                                <span class="fs-7 lh-base" style="color: #be123c;">
                                    Jika Anda merasa ini adalah sebuah kesalahan, silakan hubungi pihak BAAK Universitas Nurul Jadid untuk informasi lebih lanjut.
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