@extends('layout.main')
@section('title', 'Dashboard')

@section('css')
    <style>
        :root {
            --primary-soft: #f0f7ff;
            --primary-color: #006ae6;
            --success-soft: #ecfdf3;
            --success-color: #12b76a;
            --warning-soft: #fffcf5;
            --warning-color: #f79009;
            --info-soft: #f0f9ff;
            --info-color: #0ea5e9;
            --border-color: #eaecf0;
            --text-main: #101828;
            --text-muted: #667085;
        }

        [data-bs-theme="dark"] {
            --primary-soft: rgba(0, 106, 230, 0.15);
            --success-soft: rgba(18, 183, 106, 0.15);
            --warning-soft: rgba(247, 144, 9, 0.15);
            --info-soft: rgba(14, 165, 233, 0.15);
            --border-color: var(--bs-border-color);
            --text-main: var(--bs-text-primary);
            --text-muted: var(--bs-text-muted);
        }

        [data-bs-theme="dark"] .glass-card {
            background: var(--bs-card-bg);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .dash-hero {
            background: linear-gradient(135deg, #006AE6 0%, #004CCC 100%);
            border-radius: 28px;
            padding: 3.5rem 4rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 106, 230, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dash-hero::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .dash-hero-pattern {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.5;
        }

        .hero-illus {
            position: absolute;
            right: 2rem;
            bottom: -2rem;
            height: 110%;
            object-fit: contain;
            opacity: 0.95;
            filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.1));
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .avatar-initial {
            width: 72px;
            height: 72px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.5);
            color: white;
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .glass-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(16, 24, 40, 0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(16, 24, 40, 0.08);
            border-color: #d0d5dd;
        }

        .info-chip {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            gap: 1.25rem;
            height: 100%;
        }

        .icon-box {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .glass-card:hover .icon-box {
            transform: scale(1.05);
        }

        .text-main {
            color: var(--text-main);
        }

        .text-muted {
            color: var(--text-muted);
        }

        @media (min-width: 768px) {
            .border-md-end {
                border-right: 1px solid var(--border-color);
            }
        }

        @media (max-width: 991px) {
            .dash-hero {
                padding: 2.5rem 1.5rem;
            }

            .hero-illus {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid mt-8 mb-10">
            <div id="kt_app_content_container" class="app-container container-fluid">

                @php
                    $jam = (int) date('G');
                    $sapaan =
                        $jam < 11
                            ? 'Selamat Pagi'
                            : ($jam < 15
                                ? 'Selamat Siang'
                                : ($jam < 18
                                    ? 'Selamat Sore'
                                    : 'Selamat Malam'));
                @endphp

                <div class="dash-hero" style="margin-bottom: -3rem; padding-bottom: 5rem;">
                    <div class="dash-hero-pattern"></div>

                    <svg class="hero-illus d-none d-lg-block" width="380" height="380" viewBox="0 0 380 380"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="190" cy="190" r="140" fill="white" fill-opacity="0.05" />
                        <circle cx="190" cy="190" r="100" fill="white" fill-opacity="0.1" />

                        <g transform="translate(40, 60) rotate(-8)">
                            <rect x="0" y="0" width="140" height="180" rx="12" fill="white"
                                fill-opacity="0.95" style="filter: drop-shadow(0 15px 25px rgba(0,0,0,0.15));" />
                            <rect x="10" y="10" width="120" height="160" rx="6" stroke="#006AE6"
                                stroke-width="2" stroke-opacity="0.2" fill="none" />
                            <rect x="35" y="30" width="70" height="10" rx="5" fill="#006AE6"
                                fill-opacity="0.3" />
                            <rect x="25" y="60" width="90" height="6" rx="3" fill="#006AE6"
                                fill-opacity="0.15" />
                            <rect x="25" y="75" width="75" height="6" rx="3" fill="#006AE6"
                                fill-opacity="0.15" />
                            <rect x="25" y="90" width="85" height="6" rx="3" fill="#006AE6"
                                fill-opacity="0.15" />
                            <circle cx="100" cy="135" r="18" fill="#f79009" />
                            <path d="M92 145 L85 165 L100 155 L115 165 L108 145 Z" fill="#f79009" fill-opacity="0.8" />
                            <path d="M30 145 Q 40 135 50 145 T 70 140" stroke="#006AE6" stroke-width="2" fill="none"
                                stroke-opacity="0.5" />
                            <rect x="30" y="150" width="40" height="2" fill="#006AE6" fill-opacity="0.2" />
                        </g>

                        <g transform="translate(180, 30) rotate(10)">
                            <path d="M75 25 L145 55 L75 85 L5 55 Z" fill="white" fill-opacity="0.98"
                                style="filter: drop-shadow(0 15px 25px rgba(0,0,0,0.12));" />
                            <path d="M30 65 L30 110 Q75 135 120 110 L120 65" fill="white" fill-opacity="0.8" />
                            <path d="M135 50 L135 95" stroke="white" stroke-width="4" stroke-linecap="round" />
                            <circle cx="135" cy="105" r="8" fill="white" />
                        </g>

                        <g transform="translate(200, 190) rotate(-15)">
                            <path d="M40 0 L60 0 L75 50 L25 50 Z" fill="#0ea5e9" fill-opacity="0.9"
                                style="filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));" />
                            <path d="M60 0 L80 0 L95 40 L55 40 Z" fill="#0284c7" fill-opacity="0.9" />
                            <circle cx="60" cy="70" r="40" fill="white"
                                style="filter: drop-shadow(0 15px 25px rgba(0,0,0,0.15));" />
                            <circle cx="60" cy="70" r="32" fill="#fffcf5" />
                            <circle cx="60" cy="70" r="28" fill="#f79009" />
                            <path d="M60 52 L64 62 L74 62 L66 68 L69 78 L60 72 L51 78 L54 68 L46 62 L56 62 Z"
                                fill="white" />
                        </g>

                        <path d="M40 220 L46 238 L64 244 L46 250 L40 268 L34 250 L16 244 L34 238 Z" fill="white"
                            fill-opacity="0.9" />
                        <path d="M320 80 L324 92 L336 96 L324 100 L320 112 L316 100 L304 96 L316 92 Z" fill="white"
                            fill-opacity="0.7" />
                        <circle cx="80" cy="40" r="6" fill="white" fill-opacity="0.6" />
                        <circle cx="310" cy="280" r="8" fill="white" fill-opacity="0.5" />
                    </svg>

                    <div class="position-relative z-index-1">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center gap-4 mb-6">
                                    <div class="avatar-initial">
                                        {{ strtoupper(substr($mahasiswa->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-white opacity-75 fs-5 mb-1 fw-medium tracking-wide">
                                            {{ $sapaan }},</div>
                                        <h1 class="text-white fw-bolder mb-0 display-6" style="letter-spacing: -0.5px;">
                                            {{ $mahasiswa->nama_lengkap }}
                                        </h1>
                                    </div>
                                </div>

                                <p class="text-white opacity-90 fs-5 mb-8"
                                    style="line-height: 1.6; max-width: 600px; font-weight: 300;">
                                    Selamat datang di portal SKPI Universitas Nurul Jadid. Pastikan Anda telah melengkapi
                                    seluruh kelengkapan portofolio sebelum mengajukan cetak Surat Keterangan Pendamping
                                    Ijazah (SKPI).
                                </p>

                                <div class="d-flex flex-wrap gap-4 align-items-center">
                                    @if ($pengajuan)
                                        @php
                                            $statusClass =
                                                $pengajuan->status === 'dicetak'
                                                    ? 'success'
                                                    : ($pengajuan->status === 'ditolak'
                                                        ? 'danger'
                                                        : ($pengajuan->status === 'draft'
                                                            ? 'warning'
                                                            : 'info'));
                                            $statusText =
                                                $pengajuan->status === 'dicetak'
                                                    ? 'SKPI Terbit'
                                                    : ($pengajuan->status === 'ditolak'
                                                        ? 'Pengajuan Ditolak'
                                                        : ($pengajuan->status === 'draft'
                                                            ? 'Perlu Revisi'
                                                            : 'Sedang Diproses'));
                                        @endphp
                                        <div
                                            class="d-flex align-items-center text-white bg-white bg-opacity-10 px-5 py-3 rounded-pill border border-white border-opacity-25">
                                            <i class="ki-duotone ki-flag text-white fs-4 me-2"><span
                                                    class="path1"></span><span class="path2"></span></i>
                                            <span class="fw-semibold tracking-wide">{{ $statusText }}</span>
                                        </div>
                                        @if ($pengajuan->status === 'dicetak')
                                            <a href="{{ route('bak_fakultas.skpi.print', $pengajuan->id_pengajuan) }}"
                                                target="_blank"
                                                class="btn btn-light text-success fw-bolder px-6 py-3 rounded-pill shadow-sm fs-6 hover-elevate-up">
                                                <i class="fas fa-download me-2"></i> Unduh PDF
                                            </a>
                                        @endif
                                    @else
                                        <div
                                            class="d-flex align-items-center text-white bg-white bg-opacity-10 px-5 py-3 rounded-pill border border-white border-opacity-25">
                                            <i class="ki-duotone ki-information text-white fs-4 me-2"><span
                                                    class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span></i>
                                            <span class="fw-semibold tracking-wide">Belum Mengajukan SKPI</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card glass-card position-relative z-index-2 mx-auto mb-10"
                    style="width: 96%; max-width: 1200px; padding: 0.5rem; box-shadow: 0 16px 32px rgba(0, 106, 230, 0.08);">
                    <div class="row g-0">
                        <div class="col-md-4 border-md-end">
                            <div class="info-chip p-4">
                                <div class="icon-box"
                                    style="background: var(--primary-soft); color: var(--primary-color);">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div>
                                    <div class="text-muted fs-8 fw-bolder text-uppercase tracking-wider mb-1">Nomor Induk
                                        Mahasiswa (NIM)</div>
                                    <div class="text-main fs-4 fw-bolder">{{ $mahasiswa->nim }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 border-md-end">
                            <div class="info-chip p-4">
                                <div class="icon-box"
                                    style="background: var(--warning-soft); color: var(--warning-color);">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="text-muted fs-8 fw-bolder text-uppercase tracking-wider mb-1">Fakultas
                                    </div>
                                    <div class="text-main fs-4 fw-bolder text-truncate"
                                        title="{{ $mahasiswa->programStudi->fakultas->nama_fakultas ?? 'Universitas Nurul Jadid' }}">
                                        {{ $mahasiswa->programStudi->fakultas->nama_fakultas ?? 'Universitas Nurul Jadid' }}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-chip p-4">
                                <div class="icon-box"
                                    style="background: var(--success-soft); color: var(--success-color);">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="text-muted fs-8 fw-bolder text-uppercase tracking-wider mb-1">Program Studi
                                    </div>
                                    <div class="text-main fs-4 fw-bolder text-truncate"
                                        title="{{ $mahasiswa->programStudi->nama_prodi }}">
                                        {{ $mahasiswa->programStudi->nama_prodi }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border border-dashed border-gray-300 rounded mb-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1"><i
                                    class="ki-duotone ki-route fs-2 text-primary me-2"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span
                                        class="path4"></span></i>Progress Pengajuan Cetak SKPI</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="row g-5">
                            @foreach ($steps as $stepNum => $step)
                                @php
                                    $stepColor =
                                        $step['status'] === 'sudah'
                                            ? 'success'
                                            : ($step['status'] === 'ditolak'
                                                ? 'danger'
                                                : ($step['status'] === 'revisi'
                                                    ? 'warning'
                                                    : 'secondary'));
                                    $themeColors = [
                                        1 => 'primary',
                                        2 => 'info',
                                        3 => 'primary',
                                        4 => 'info',
                                        5 => 'primary',
                                    ];
                                    $themeColor =
                                        $stepColor === 'secondary' ? $themeColors[$stepNum] ?? 'primary' : $stepColor;
                                    if ($step['status'] === 'sudah') {
                                        $badgeClass = 'badge-success';
                                        $stepText = 'Selesai';
                                    } elseif ($step['status'] === 'ditolak') {
                                        $badgeClass = 'badge-danger';
                                        $stepText = 'Ditolak';
                                    } elseif ($step['status'] === 'revisi') {
                                        $badgeClass = 'badge-warning text-gray-800';
                                        $stepText = 'Revisi';
                                    } else {
                                        $badgeClass = 'badge-light-warning';
                                        $stepText = 'Menunggu';
                                    }
                                    $circleTextColor = $themeColor === 'warning' ? 'text-gray-800' : 'text-white';
                                @endphp
                                <div class="col-md-6 col-lg position-relative">
                                    <div
                                        class="border border-dashed border-{{ $stepColor }} bg-light-{{ $stepColor }} rounded p-5 h-100 hover-elevate-up transition-all d-flex flex-column">
                                        <div class="d-flex align-items-center mb-4">
                                            <div class="symbol symbol-40px me-3">
                                                <div
                                                    class="symbol-label bg-{{ $themeColor }} {{ $circleTextColor }} fw-bolder fs-5 shadow-sm">
                                                    {{ $stepNum }}
                                                </div>
                                            </div>
                                            <div class="fs-6 fw-bolder text-{{ $themeColor }}">{{ $step['name'] }}
                                            </div>
                                        </div>
                                        <div class="fs-8 text-gray-700 mb-5">{{ $step['desc'] }}</div>
                                        <div
                                            class="d-flex justify-content-between align-items-center mt-auto pt-4 border-top border-{{ $themeColor }}">
                                            <span
                                                class="badge {{ $badgeClass }} fs-8 px-3 py-2 fw-bolder text-uppercase">{{ $stepText }}</span>
                                            @if ($step['date'])
                                                <span class="text-muted fs-8 fw-bold"><i
                                                        class="fas fa-clock me-1 text-{{ $themeColor }}"></i>{{ \Carbon\Carbon::parse($step['date'])->format('d/m/y') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if (!$loop->last)
                                        <div class="position-absolute top-50 start-100 translate-middle d-none d-lg-flex align-items-center justify-content-center bg-body rounded-circle shadow"
                                            style="z-index: 5; width: 32px; height: 32px;">
                                            <i class="fas fa-chevron-right fs-6 text-gray-500"></i>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-8">
                        <div class="card border border-dashed border-gray-300 rounded h-100 mb-8 mb-xl-0">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-3 mb-1"><i
                                            class="ki-duotone ki-folder fs-2 text-primary me-2"><span
                                                class="path1"></span><span class="path2"></span></i> Kelengkapan
                                        Berkas</span>
                                </h3>
                            </div>
                            <div class="card-body pt-5">
                                <div class="row g-3">
                                    @php
                                        $berkas = [
                                            [
                                                'route' => 'mahasiswa.prestasi.index',
                                                'label' => 'Prestasi',
                                                'icon' => 'ki-medal-star',
                                                'color' => 'warning',
                                                'count' => $prestasi->count(),
                                                'approved' => $prestasi->where('status', 'approved')->count(),
                                            ],
                                            [
                                                'route' => 'mahasiswa.organisasi.index',
                                                'label' => 'Organisasi',
                                                'icon' => 'ki-profile-user',
                                                'color' => 'info',
                                                'count' => $organisasi->count(),
                                                'approved' => $organisasi->where('status', 'approved')->count(),
                                            ],
                                            [
                                                'route' => 'mahasiswa.sertifikat.index',
                                                'label' => 'Sertifikat',
                                                'icon' => 'ki-document',
                                                'color' => 'primary',
                                                'count' => $sertifikat->count(),
                                                'approved' => $sertifikat->where('status', 'approved')->count(),
                                            ],
                                            [
                                                'route' => 'mahasiswa.magang.index',
                                                'label' => 'Magang / KP',
                                                'icon' => 'ki-briefcase',
                                                'color' => 'success',
                                                'count' => $magang->count(),
                                                'approved' => $magang->where('status', 'approved')->count(),
                                            ],
                                        ];
                                    @endphp
                                    @foreach ($berkas as $b)
                                        <div class="col-md-6">
                                            <a href="{{ route($b['route']) }}"
                                                class="border border-dashed border-gray-300 rounded px-5 py-4 d-flex align-items-center justify-content-between bg-body hover-elevate-up transition-all h-100">
                                                <div>
                                                    <div class="text-muted fw-bold fs-7 text-uppercase mb-1">
                                                        {{ $b['label'] }}</div>
                                                    <div class="text-gray-900 fw-bolder fs-2">{{ $b['count'] }}</div>
                                                    @if ($b['approved'] > 0)
                                                        <div class="text-success fs-8 fw-bolder">{{ $b['approved'] }}
                                                            disetujui</div>
                                                    @elseif($b['count'] > 0)
                                                        <div class="text-warning fs-8 fw-bolder">Menunggu verifikasi
                                                        </div>
                                                    @else
                                                        <div class="text-muted fs-8 fw-semibold">Belum diisi</div>
                                                    @endif
                                                </div>
                                                <div class="symbol symbol-50px symbol-circle">
                                                    <div class="symbol-label bg-light-{{ $b['color'] }}">
                                                        <i
                                                            class="ki-duotone {{ $b['icon'] }} fs-2x text-{{ $b['color'] }}"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                @php
                                    $taFilled = $mahasiswa->tugasAkhir && !empty($mahasiswa->tugasAkhir->judul);
                                    $taTheme = $taFilled ? 'success' : 'danger';
                                @endphp
                                <div
                                    class="mt-5 border border-dashed border-{{ $taTheme }} bg-light-{{ $taTheme }} rounded p-5 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-5 hover-elevate-up transition-all">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4 w-100">
                                        <div class="symbol symbol-50px symbol-circle flex-shrink-0">
                                            <div class="symbol-label bg-{{ $taTheme }}">
                                                <i class="ki-duotone ki-book-open fs-2x text-white"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span><span class="path4"></span></i>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center w-100 gap-4">
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center gap-2 mb-1">
                                                    <span
                                                        class="text-{{ $taTheme }} fw-bolder fs-8 text-uppercase">Tugas
                                                        Akhir / Skripsi</span>
                                                    @if ($taFilled)
                                                        @php
                                                            $taStatus = $mahasiswa->tugasAkhir->status;
                                                            $badgeColor =
                                                                $taStatus === 'approved'
                                                                    ? 'success'
                                                                    : ($taStatus === 'rejected'
                                                                        ? 'danger'
                                                                        : 'warning');
                                                        @endphp
                                                        <span
                                                            class="badge badge-light-{{ $badgeColor }} px-2 py-1 fs-9 text-uppercase fw-bold">{{ $taStatus ?? 'pending' }}</span>
                                                    @endif
                                                </div>
                                                @if ($taFilled)
                                                    <span
                                                        class="fw-bolder text-gray-900 fs-5 mb-1">"{{ $mahasiswa->tugasAkhir->judul }}"</span>
                                                    <span class="fs-8 text-muted">
                                                        Pembimbing:
                                                        @foreach ($mahasiswa->tugasAkhir->pembimbingTugasAkhir as $pta)
                                                            <span
                                                                class="fw-bold text-gray-700">{{ $pta->nama_dosen }}</span>{{ !$loop->last ? ' & ' : '' }}
                                                        @endforeach
                                                    </span>
                                                    @if ($mahasiswa->tugasAkhir->keterangan)
                                                        <div
                                                            class="mt-2 p-2 bg-light-danger text-danger fs-8 fw-bold rounded border border-danger border-dashed">
                                                            <i class="ki-duotone ki-information fs-6 text-danger me-1"><span
                                                                    class="path1"></span><span
                                                                    class="path2"></span><span class="path3"></span></i>
                                                            {{ $mahasiswa->tugasAkhir->keterangan }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="fs-5 fw-bolder text-danger mb-1">Belum Diisi</span>
                                                    <span class="fs-8 text-danger">Data tugas akhir wajib diisi sebelum
                                                        mengajukan SKPI.</span>
                                                @endif
                                            </div>
                                            <div
                                                class="d-flex flex-column align-items-start align-items-sm-end flex-shrink-0 mt-2 mt-sm-0">
                                                @php
                                                    $taRaw = $mahasiswa->tugasAkhir;
                                                    $isRejectedTa = $taRaw && $taRaw->status === 'rejected';
                                                    $isLockedTa =
                                                        !$isRejectedTa &&
                                                        $pengajuan &&
                                                        in_array($pengajuan->status, [
                                                            'diajukan',
                                                            'verifikasi',
                                                            'dicetak',
                                                        ]);
                                                    $isApprovedTa = $taRaw && $taRaw->status === 'approved';
                                                    $readonlyTa = $isLockedTa || $isApprovedTa;
                                                    $canEditTa = !$readonlyTa;
                                                @endphp
                                                <a href="{{ route('mahasiswa.tugas_akhir.edit') }}"
                                                    class="btn btn-sm btn-{{ $canEditTa ? $taTheme : 'secondary' }} px-4">
                                                    <i
                                                        class="ki-duotone ki-{{ $canEditTa ? 'pencil' : 'magnifier' }} fs-4"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                    {{ $canEditTa ? 'Isi / Ubah' : 'Detail' }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card border border-dashed border-gray-300 rounded h-100">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-3 mb-1"><i
                                            class="ki-duotone ki-send fs-2 text-primary me-2"><span
                                                class="path1"></span><span class="path2"></span></i> Status
                                        Pengajuan</span>
                                </h3>
                            </div>
                            <div class="card-body pt-5 d-flex flex-column">
                                @if ($pengajuan)
                                    <div class="mb-5 d-flex flex-column h-100">
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-4 border-bottom border-gray-200 pb-4">
                                            <div class="fw-bolder text-gray-800">Status Saat Ini</div>
                                            @php
                                                $pStatus = $pengajuan->status;
                                                $pColor =
                                                    $pStatus === 'dicetak'
                                                        ? 'success'
                                                        : ($pStatus === 'ditolak'
                                                            ? 'danger'
                                                            : ($pStatus === 'draft'
                                                                ? 'warning'
                                                                : 'primary'));
                                            @endphp
                                            <span
                                                class="badge badge-light-{{ $pColor }} fw-bolder px-3 py-2 text-uppercase">{{ $pStatus }}</span>
                                        </div>
                                        <div class="text-center mt-6 mb-auto">
                                            @if ($pStatus === 'dicetak')
                                                <i class="ki-duotone ki-check-circle fs-5x text-success mb-4"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                <div class="fs-5 fw-bold text-gray-800 mb-2">SKPI Telah Terbit!</div>
                                                <div class="fs-7 text-muted mb-5">Selamat! Dokumen SKPI Anda telah
                                                    dicetak
                                                    dan diterbitkan secara resmi.</div>
                                                <a href="{{ route('bak_fakultas.skpi.print', $pengajuan->id_pengajuan) }}"
                                                    target="_blank"
                                                    class="btn btn-success btn-sm d-inline-flex align-items-center fw-bold mt-2">
                                                    <i class="fas fa-download fs-4 me-2"></i> Unduh SKPI (PDF)
                                                </a>
                                            @elseif ($pStatus === 'ditolak' || $pStatus === 'draft')
                                                <i class="ki-duotone ki-cross-circle fs-5x text-danger mb-4"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                <div class="fs-5 fw-bold text-gray-800 mb-2">Perlu Perbaikan</div>
                                                <div class="fs-7 text-muted">
                                                    @if ($pengajuan->catatan_bak)
                                                        Silakan periksa catatan revisi di bawah ini dan lakukan
                                                        perbaikan.
                                                    @else
                                                        Silakan periksa catatan revisi pada masing-masing data yang
                                                        ditolak di menu Kelengkapan Berkas.
                                                    @endif
                                                </div>
                                            @else
                                                <i class="ki-duotone ki-time fs-5x text-primary mb-4"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                <div class="fs-5 fw-bold text-gray-800 mb-2">Sedang Diproses</div>
                                                <div class="fs-7 text-muted">Pengajuan SKPI Anda sedang dalam tahap
                                                    verifikasi. Silakan pantau progress timeline.</div>
                                            @endif
                                        </div>
                                        @if ($pengajuan->catatan_bak)
                                            <div
                                                class="bg-light-danger border border-danger border-dashed rounded p-4 mt-6 text-center">
                                                <div class="d-flex align-items-center justify-content-center mb-2">
                                                    <i class="ki-duotone ki-information-5 fs-3 text-danger me-2"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span></i>
                                                    <span class="fw-bolder text-danger fs-7">Catatan / Revisi</span>
                                                </div>
                                                <div class="text-danger fs-8">{{ $pengajuan->catatan_bak }}</div>
                                            </div>
                                        @endif
                                        @if ($pStatus === 'ditolak' || $pStatus === 'draft')
                                            <div class="mt-auto pt-6">
                                                <form action="{{ route('mahasiswa.pengajuan.submit') }}" method="POST"
                                                    onsubmit="event.preventDefault(); confirmAjukan(this);">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-warning w-100 fw-bold d-flex align-items-center justify-content-center">
                                                        <span class="indicator-label">
                                                            <span class="d-flex align-items-center"><i
                                                                    class="ki-duotone ki-send fs-3 me-2"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span></i> Ajukan Kembali
                                                                SKPI</span>
                                                        </span>
                                                        <span class="indicator-progress">
                                                            <span class="d-flex align-items-center">Mengajukan... <span
                                                                    class="spinner-border spinner-border-sm ms-2"></span></span>
                                                        </span>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center d-flex flex-column h-100">
                                        <div class="mb-auto mt-5">
                                            <i class="ki-duotone ki-file-deleted fs-5x text-muted mb-4"><span
                                                    class="path1"></span><span class="path2"></span></i>
                                            <div class="fs-6 fw-bold text-gray-800 mb-2">Belum Mengajukan SKPI</div>
                                            <div class="fs-8 text-muted mb-5">Anda belum membuat permohonan penerbitan
                                                SKPI. Pastikan semua berkas telah disetujui.</div>
                                        </div>
                                        @php
                                            $canAjukan =
                                                $mahasiswa->tugasAkhir && !empty($mahasiswa->tugasAkhir->judul);
                                        @endphp
                                        <div class="mt-auto">
                                            @if ($canAjukan)
                                                <div
                                                    class="alert bg-light-success border border-success border-dashed d-flex align-items-center p-6 mb-6 text-start">
                                                    <i class="fas fa-check-circle fs-1 text-success me-4"></i>
                                                    <span class="fs-7 text-success fw-bold">Tugas Akhir sudah diisi.
                                                        Anda dapat mengajukan SKPI sekarang!</span>
                                                </div>
                                                <form action="{{ route('mahasiswa.pengajuan.submit') }}" method="POST"
                                                    onsubmit="event.preventDefault(); confirmAjukan(this);">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                                        <span class="indicator-label">
                                                            <span class="d-flex align-items-center"><i
                                                                    class="ki-duotone ki-send fs-3 me-2"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span></i> Ajukan SKPI
                                                                Sekarang</span>
                                                        </span>
                                                        <span class="indicator-progress">
                                                            <span class="d-flex align-items-center">Mengajukan... <span
                                                                    class="spinner-border spinner-border-sm ms-2"></span></span>
                                                        </span>
                                                    </button>
                                                </form>
                                            @else
                                                <div
                                                    class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                                                    <i
                                                        class="ki-duotone ki-shield-cross fs-2hx text-danger me-4 mb-5 mb-sm-0"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span></i>
                                                    <div class="d-flex flex-column pe-0 pe-sm-10">
                                                        <h5 class="mb-1 text-danger">Belum Memenuhi Syarat</h5>
                                                        <span class="fs-8 text-danger">Anda wajib melengkapi data
                                                            <span class="fw-bolder">Tugas Akhir / Skripsi</span>
                                                            terlebih dahulu sebelum mengajukan SKPI.</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @if (session('success'))
        <script>
            Swal.fire({
                text: "{{ session('success') }}",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                text: "{{ session('error') }}",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-danger"
                }
            });
        </script>
    @endif

    <script>
        function confirmAjukan(form) {
            Swal.fire({
                title: 'Ajukan SKPI?',
                text: 'Apakah Anda yakin ingin mengajukan permohonan cetak SKPI? Pastikan semua data sudah benar.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ajukan',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Tunggu Sebentar...',
                        icon: 'info',
                        text: 'Sedang mengajukan permohonan...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    const btn = form.querySelector('button[type="submit"]');
                    if (btn) {
                        btn.setAttribute('data-kt-indicator', 'on');
                        btn.disabled = true;
                    }
                    form.submit();
                }
            });
        }
    </script>
@endsection

