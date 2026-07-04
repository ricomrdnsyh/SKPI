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
</head>
<body id="kt_body" class="app-blank bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
            body {
                background: linear-gradient(135deg, #f5f7fa 0%, #e4ebf5 100%);
                font-family: 'Outfit', sans-serif;
            }
            body::before {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-image: url('{{ asset('assets/media/logos/unuja.png') }}');
                background-size: 800px;
                background-position: center;
                background-repeat: no-repeat;
                opacity: 0.04;
                z-index: -1;
                animation: floatLogo 20s ease-in-out infinite alternate;
            }
            @keyframes floatLogo {
                0% { transform: scale(1) translateY(0); }
                100% { transform: scale(1.05) translateY(-20px); }
            }
            @keyframes fadeInSlide {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.4);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
                border-radius: 20px;
                animation: fadeInSlide 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .glass-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 25px 45px rgba(0, 0, 0, 0.08);
            }
            .info-row {
                transition: all 0.2s ease;
                padding: 10px;
                border-radius: 8px;
            }
            .info-row:hover {
                background: rgba(0, 163, 255, 0.05);
                transform: translateX(5px);
            }
            .check-icon-anim {
                animation: popIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
                opacity: 0;
            }
            @keyframes popIn {
                0% { transform: scale(0.5); opacity: 0; }
                100% { transform: scale(1); opacity: 1; }
            }
            .gradient-text {
                background: linear-gradient(135deg, #0061ff 0%, #60efff 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                font-weight: 700;
            }
            @media (max-width: 768px) {
                body::before {
                    background-size: 120vw;
                }
                .glass-card {
                    padding: 2rem !important;
                }
            }
        </style>
        <div class="d-flex flex-column flex-column-fluid">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <div class="mb-10 text-center" style="animation: fadeInSlide 0.6s ease-out forwards;">
                    <img alt="Logo" src="{{ asset('assets/media/logos/unuja.png') }}" class="h-80px mb-5" />
                    <h1 class="text-dark fw-bolder fs-2qx">Universitas Nurul Jadid</h1>
                    <div class="text-gray-600 fw-semibold fs-5">Sistem Verifikasi Keaslian Dokumen Akademik Resmi</div>
                </div>
                <div class="w-lg-650px glass-card p-10 p-lg-15 mx-auto">
                    <div class="text-center mb-10">
                        <div class="check-icon-anim">
                            <i class="ki-duotone ki-shield-tick fs-5x text-success mb-5" style="filter: drop-shadow(0px 8px 16px rgba(80, 205, 137, 0.3));">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </div>
                        <h1 class="gradient-text mb-3 fs-2x">Dokumen SKPI Valid!</h1>
                        <div class="text-gray-600 fs-5">Surat Keterangan Pendamping Ijazah (SKPI) ini terdaftar resmi di
                            basis data Universitas Nurul Jadid.</div>
                    </div>
                    <div class="bg-light-primary rounded px-7 py-6 mb-10" style="border-left: 4px solid #009ef7;">
                        <h4 class="text-primary fw-bolder mb-6 d-flex align-items-center">
                            <i class="ki-duotone ki-profile-circle fs-3 text-primary me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            Informasi Pemilik Dokumen
                        </h4>
                        <div class="row info-row">
                            <div class="col-sm-5 fw-semibold text-gray-600">Nama Lengkap</div>
                            <div class="col-sm-7 fw-bolder text-gray-900">{{ $mahasiswa->nama_lengkap }}</div>
                        </div>
                        <div class="row info-row">
                            <div class="col-sm-5 fw-semibold text-gray-600">NIM</div>
                            <div class="col-sm-7 fw-bolder text-gray-900">{{ $mahasiswa->nim }}</div>
                        </div>
                        <div class="row info-row">
                            <div class="col-sm-5 fw-semibold text-gray-600">Program Studi</div>
                            <div class="col-sm-7 fw-bolder text-gray-900">{{ $mahasiswa->programStudi->nama_prodi ?? '-' }}
                            </div>
                        </div>
                        <div class="row info-row">
                            <div class="col-sm-5 fw-semibold text-gray-600">Fakultas</div>
                            <div class="col-sm-7 fw-bolder text-gray-900">{{ $fakultas->nama_fakultas ?? '-' }}</div>
                        </div>
                        <div class="row info-row">
                            <div class="col-sm-5 fw-semibold text-gray-600">Tanggal Diterbitkan</div>
                            <div class="col-sm-7 fw-bolder text-gray-900">
                                @if ($skpi && $skpi->tanggal_terbit)
                                    {{ \Carbon\Carbon::parse($skpi->tanggal_terbit)->translatedFormat('d F Y') }}
                                @else
                                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                                @endif
                            </div>
                        </div>
                        <div class="row info-row">
                            <div class="col-sm-5 fw-semibold text-gray-600">Nomor SKPI</div>
                            <div class="col-sm-7 fw-bolder text-gray-900">{{ $skpi ? $skpi->nomor_skpi : '-' }}</div>
                        </div>
                    </div>
                    <div class="alert alert-primary border border-dashed border-primary d-flex align-items-center p-5">
                        <i class="ki-duotone ki-information-5 fs-2hx text-primary me-4"><span
                                class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-primary">Informasi</h4>
                            <span>Untuk melihat detail capaian pembelajaran, sertifikat, dan prestasi, silakan hubungi
                                bagian akademik Universitas Nurul Jadid.</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-center flex-column-auto p-10">
                    <div class="d-flex align-items-center fw-semibold fs-6 text-gray-600">
                        &copy; {{ date('Y') }} Universitas Nurul Jadid
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>
</html>
