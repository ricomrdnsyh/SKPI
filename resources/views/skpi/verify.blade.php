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
                        <i class="ki-duotone ki-shield-tick fs-5x text-success mb-5"><span class="path1"></span><span class="path2"></span></i>
                        <h1 class="text-dark mb-3">Dokumen SKPI Valid!</h1>
                        <div class="text-gray-500 fs-5">Surat Keterangan Pendamping Ijazah (SKPI) ini terdaftar resmi di basis data Universitas Nurul Jadid.</div>
                    </div>

                    <div class="border border-dashed border-gray-300 rounded px-7 py-5 mb-10">
                        <h4 class="text-dark fw-bolder mb-5">Informasi Pemilik Dokumen</h4>
                        
                        <div class="row mb-5">
                            <div class="col-sm-5 fw-semibold text-muted">Nama Lengkap</div>
                            <div class="col-sm-7 fw-bolder text-dark">{{ $mahasiswa->nama_lengkap }}</div>
                        </div>
                        
                        <div class="row mb-5">
                            <div class="col-sm-5 fw-semibold text-muted">NIM</div>
                            <div class="col-sm-7 fw-bolder text-dark">{{ $mahasiswa->nim }}</div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-sm-5 fw-semibold text-muted">Program Studi</div>
                            <div class="col-sm-7 fw-bolder text-dark">{{ $mahasiswa->programStudi->nama_prodi ?? '-' }}</div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-sm-5 fw-semibold text-muted">Fakultas</div>
                            <div class="col-sm-7 fw-bolder text-dark">{{ $mahasiswa->programStudi->fakultas->nama_fakultas ?? '-' }}</div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-sm-5 fw-semibold text-muted">Tanggal Diterbitkan</div>
                            <div class="col-sm-7 fw-bolder text-dark">
                                @if($pengajuan && $pengajuan->tanggal_cetak)
                                    {{ \Carbon\Carbon::parse($pengajuan->tanggal_cetak)->translatedFormat('d F Y') }}
                                @else
                                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                                @endif
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-5 fw-semibold text-muted">Nomor SKPI</div>
                            <div class="col-sm-7 fw-bolder text-dark">{{ $pengajuan ? $pengajuan->nomor_skpi : '-' }}</div>
                        </div>
                    </div>

                    <div class="alert alert-primary d-flex align-items-center p-5">
                        <i class="ki-duotone ki-information-5 fs-2hx text-primary me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-primary">Informasi</h4>
                            <span>Untuk melihat detail capaian pembelajaran, sertifikat, dan prestasi, silakan hubungi bagian akademik Universitas Nurul Jadid.</span>
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