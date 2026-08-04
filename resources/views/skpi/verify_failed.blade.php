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
</head>

<body id="kt_body" class="app-blank bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>
            body {
                background-color: #f4f6f9;
                font-family: 'Inter', Helvetica, sans-serif;
            }
            .official-card {
                background-color: #ffffff;
                border: 1px solid #e4e6ef;
                border-radius: 12px;
                box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.05);
                position: relative;
                overflow: hidden;
            }
            .official-card::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 8px;
                background: #f1416c;
            }
            .watermark {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                opacity: 0.04;
                width: 300px;
                pointer-events: none;
                z-index: 0;
            }
            .content-relative {
                position: relative;
                z-index: 1;
            }
            .status-badge {
                display: inline-flex;
                align-items: center;
                padding: 10px 24px;
                border-radius: 8px;
                font-weight: 700;
                font-size: 1.15rem;
                letter-spacing: 0.5px;
            }
            .status-badge.danger {
                background-color: #fff5f8;
                color: #f1416c;
                border: 1px dashed #f1416c;
            }
            .institution-title {
                font-size: 1.5rem;
                font-weight: 800;
                color: #181c32;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .document-title {
                font-size: 1.1rem;
                color: #5e6278;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
        </style>

        <div class="d-flex flex-column flex-column-fluid">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                
                <div class="w-lg-700px official-card p-10 p-lg-15 mx-auto">
                    <img src="{{ asset('assets/media/logos/unuja.png') }}" class="watermark" alt="Watermark" />
                    
                    <div class="content-relative">
                        <!-- Header -->
                        <div class="text-center mb-10 pb-5 border-bottom border-gray-300">
                            <img alt="Logo" src="{{ asset('assets/media/logos/unuja.png') }}" class="h-80px mb-5" />
                            <h1 class="institution-title mb-2">Universitas Nurul Jadid</h1>
                            <div class="document-title">Hasil Verifikasi Dokumen Akademik</div>
                        </div>

                        <!-- Status -->
                        <div class="text-center mb-10">
                            <div class="status-badge danger mb-5">
                                <i class="ki-duotone ki-shield-cross fs-2x text-danger me-3">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                </i>
                                DOKUMEN TIDAK DITEMUKAN
                            </div>
                            <div class="text-gray-600 fs-6">
                                Maaf, QR Code ini tidak valid atau dokumen Surat Keterangan Pendamping Ijazah (SKPI) belum diterbitkan oleh pihak terkait.
                            </div>
                        </div>

                        <!-- Footer Info -->
                        <div class="alert alert-secondary border border-gray-300 d-flex align-items-center p-5 mb-0">
                            <i class="ki-duotone ki-information-5 fs-2hx text-gray-600 me-4">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                            <div class="d-flex flex-column text-gray-600">
                                <span class="fw-bold">Pusat Bantuan</span>
                                <span class="fs-7">Jika Anda merasa ini adalah sebuah kesalahan, silakan hubungi pihak BAAK Universitas Nurul Jadid untuk informasi lebih lanjut.</span>
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