<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Surat Keterangan Pendamping Ijazah Universitas Nurul Jadid">
    <title>SKPI UNUJA - Sistem Informasi Surat Keterangan Pendamping Ijazah</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/unuja.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .landing-dark-bg {
            background-color: #1e1e2d;
            background-image: url('{{ asset('assets/media/svg/illustrations/bg-4.svg') }}');
            background-position: center;
            background-size: cover;
        }
    </style>
</head>
<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" class="bg-white position-relative app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="mb-0" id="home">
            <div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg">
                <div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <div class="container">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center flex-equal">
                                <button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none" id="kt_landing_menu_toggle">
                                    <i class="ki-duotone ki-abstract-14 fs-2hx"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                                <a href="{{ url('/') }}">
                                    <img alt="Logo" src="{{ asset('assets/media/logos/unuja.png') }}" class="logo-default h-40px h-lg-50px" />
                                </a>
                            </div>
                            <div class="d-lg-block" id="kt_header_nav_wrapper">
                                <div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true" data-kt-drawer-name="landing-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="200px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
                                    <div class="menu menu-column flex-nowrap menu-rounded menu-lg-row menu-title-gray-500 menu-state-title-primary nav nav-flush fs-5 fw-semibold" id="kt_landing_menu">
                                        <div class="menu-item">
                                            <a class="menu-link nav-link active py-3 px-4 px-xxl-6" href="#home" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Home</a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link nav-link py-3 px-4 px-xxl-6" href="#tentang" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Tentang SKPI</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-equal text-end ms-1">
                                @if(Auth::check())
                                    <a href="{{ route('dashboard') }}" class="btn btn-success">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">Sign In</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column flex-center w-100 min-h-350px min-h-lg-500px px-9">
                    <div class="text-center mb-5 mb-lg-10 py-10 py-lg-20">
                        <h1 class="text-white lh-base fw-bolder fs-2x fs-lg-3x mb-15">
                            Sistem Informasi<br />
                            <span class="text-primary">Surat Keterangan Pendamping Ijazah</span>
                            <br />Universitas Nurul Jadid
                        </h1>
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Masuk ke Sistem</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-10 py-lg-20" id="tentang">
            <div class="container">
                <div class="text-center mb-12">
                    <h3 class="fs-2hx text-dark mb-5" id="how-it-works" data-kt-scroll-offset="{default: 100, lg: 150}">Apa itu SKPI?</h3>
                    <div class="fs-5 text-muted fw-bold">Surat Keterangan Pendamping Ijazah (SKPI) atau Diploma Supplement adalah dokumen yang memuat<br />informasi tentang pemenuhan kompetensi lulusan dalam suatu program pendidikan tinggi.</div>
                </div>
                <div class="row w-100 gy-10 mb-md-20">
                    <div class="col-md-4 px-5">
                        <div class="text-center mb-10 mb-md-0">
                            <i class="ki-duotone ki-medal fs-5x text-success mb-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                            <h4 class="fs-3 fw-bold text-dark">Rekam Prestasi</h4>
                            <p class="fs-6 fw-semibold text-muted">Mencatat seluruh prestasi dan penghargaan selama menjadi mahasiswa.</p>
                        </div>
                    </div>
                    <div class="col-md-4 px-5">
                        <div class="text-center mb-10 mb-md-0">
                            <i class="ki-duotone ki-document fs-5x text-primary mb-5"><span class="path1"></span><span class="path2"></span></i>
                            <h4 class="fs-3 fw-bold text-dark">Dokumen Resmi</h4>
                            <p class="fs-6 fw-semibold text-muted">Dokumen pendamping sah ijazah sesuai standar KKNI (Kerangka Kualifikasi Nasional Indonesia).</p>
                        </div>
                    </div>
                    <div class="col-md-4 px-5">
                        <div class="text-center mb-10 mb-md-0">
                            <i class="ki-duotone ki-chart-pie-3 fs-5x text-danger mb-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            <h4 class="fs-3 fw-bold text-dark">Kompetensi</h4>
                            <p class="fs-6 fw-semibold text-muted">Membuktikan keahlian tambahan yang dimiliki lulusan siap kerja di industri nyata.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-0">
            <div class="landing-dark-bg pt-20">
                <div class="container">
                    <div class="row py-10 py-lg-20">
                        <div class="col-lg-6 pe-lg-16 mb-10 mb-lg-0">
                            <div class="rounded landing-dark-border p-9 mb-10">
                                <h2 class="text-white">Butuh Bantuan?</h2>
                                <span class="fw-normal fs-4 text-gray-500">
                                    Silahkan hubungi Biro Administrasi Akademik (BAAK) UNUJA.
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 ps-lg-16">
                            <div class="d-flex justify-content-center">
                                <div class="d-flex fw-semibold flex-column me-20">
                                    <h4 class="fw-bold text-gray-400 mb-6">Tautan Penting</h4>
                                    <a href="#" class="text-white opacity-50 text-hover-primary fs-5 mb-6">Website Utama</a>
                                    <a href="#" class="text-white opacity-50 text-hover-primary fs-5 mb-6">Sistem Akademik (Siakad)</a>
                                    <a href="#" class="text-white opacity-50 text-hover-primary fs-5 mb-6">PMB UNUJA</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="landing-dark-separator"></div>
                <div class="container">
                    <div class="d-flex flex-column flex-md-row flex-stack py-7 py-lg-10">
                        <div class="d-flex align-items-center order-2 order-md-1">
                            <a href="{{ url('/') }}">
                                <img alt="Logo" src="{{ asset('assets/media/logos/unuja.png') }}" class="h-30px h-md-40px" />
                            </a>
                            <span class="mx-5 fs-6 fw-semibold text-gray-600 pt-1">
                                &copy; {{ date('Y') }} SKPI UNUJA.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>
</html>
