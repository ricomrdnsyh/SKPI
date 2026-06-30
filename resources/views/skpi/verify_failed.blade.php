<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Verifikasi Keaslian SKPI Universitas Nurul Jadid">
    <title>Verifikasi Gagal - SKPI UNUJA</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/unuja.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
</head>
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>
            body {
                background-image: url('{{ asset('assets/media/auth/bg4.jpg') }}');
            }
        </style>

        <div class="d-flex flex-column flex-column-fluid">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <div class="mb-10 text-center">
                    <img alt="Logo" src="{{ asset('assets/media/logos/unuja.png') }}" class="h-60px mb-5" />
                    <h1 class="text-white fw-bolder fs-2qx">Universitas Nurul Jadid</h1>
                    <div class="text-white fw-semibold fs-5">Sistem Verifikasi Keaslian Dokumen Akademik Resmi</div>
                </div>

                <div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <div class="text-center mb-10">
                        <i class="ki-duotone ki-shield-cross fs-5x text-danger mb-5"><span class="path1"></span><span class="path2"></span></i>
                        <h1 class="text-dark mb-3">Dokumen Tidak Ditemukan!</h1>
                        <div class="text-gray-500 fs-5">Maaf, QR Code ini tidak valid atau dokumen Surat Keterangan Pendamping Ijazah (SKPI) belum diterbitkan.</div>
                    </div>

                    <div class="alert alert-danger d-flex align-items-center p-5">
                        <i class="ki-duotone ki-information-5 fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-danger">Informasi</h4>
                            <span>Jika Anda merasa ini adalah sebuah kesalahan, silakan hubungi pihak BAAK Universitas Nurul Jadid untuk informasi lebih lanjut.</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-center flex-column-auto p-10">
                    <div class="d-flex align-items-center fw-semibold fs-6 text-white opacity-75">
                        &copy; {{ date('Y') }} SKPI UNUJA &mdash; Universitas Nurul Jadid
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>
</html>