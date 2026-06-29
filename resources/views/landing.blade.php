<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Surat Keterangan Pendamping Ijazah Universitas Nurul Jadid">
    <title>SKPI UNUJA - Sistem Informasi Surat Keterangan Pendamping Ijazah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #0d1b38 0%, #1a3266 50%, #0d1b38 100%);
        }

        .hero-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.15;
            pointer-events: none;
        }

        .step-connector {
            position: absolute;
            top: 2.5rem;
            left: calc(50% + 2.5rem);
            right: calc(-50% + 2.5rem);
            height: 2px;
            background: linear-gradient(90deg, #3a5a9e, transparent);
        }

        .step-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .step-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
        }

        .role-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .role-card:hover {
            transform: translateY(-3px);
        }

        .nav-blur {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    {{-- Navbar --}}
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/80 nav-blur border-b border-gray-200/60">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <div
                    class="w-8 h-8 flex items-center justify-center text-white text-xs font-bold bg-unuja-600 rounded-xl shadow-sm">
                    U</div>
                <span class="font-bold text-sm text-gray-900">SKPI <span
                        class="font-medium text-gray-400">UNUJA</span></span>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm hidden sm:inline-flex">Masuk</a>
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm"><i
                        class="fa-solid fa-arrow-right-to-bracket"></i> Masuk ke Sistem</a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="hero-gradient relative min-h-[90vh] flex items-center overflow-hidden pt-16">
        <div class="hero-glow" style="top: -10%; left: -5%; background: #4e72bd;"></div>
        <div class="hero-glow" style="bottom: -10%; right: -5%; background: #6b8ac9;"></div>
        <div class="max-w-6xl mx-auto px-6 w-full">
            <div class="max-w-3xl mx-auto text-center">
                <div
                    class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-sm rounded-full border border-white/10 mb-8 animate-fade-in">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse-subtle"></span>
                    <span class="text-[11px] font-semibold text-white/70 tracking-wide">Sistem Resmi Universitas Nurul
                        Jadid</span>
                </div>
                <h1
                    class="text-4xl md:text-6xl lg:text-7xl font-black text-white tracking-tight leading-[1.1] mb-6 animate-slide-up">
                    Surat Keterangan<br><span
                        class="text-transparent bg-clip-text bg-linear-to-r from-unuja-200 to-blue-300">Pendamping
                        Ijazah</span>
                </h1>
                <p class="text-base md:text-lg text-white/50 max-w-xl mx-auto leading-relaxed mb-10 animate-fade-in"
                    style="animation-delay: 0.15s">
                    Platform digital penerbitan SKPI Universitas Nurul Jadid — dokumen resmi yang menjelaskan capaian
                    pembelajaran dan kualifikasi lulusan.
                </p>
                <div class="flex items-center justify-center gap-3 flex-wrap animate-fade-in"
                    style="animation-delay: 0.25s">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-unuja-900 font-bold rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        Mulai Sekarang <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="#alur"
                        class="inline-flex items-center gap-2 px-8 py-3.5 bg-white/10 text-white font-semibold rounded-2xl border border-white/10 hover:bg-white/20 transition-all duration-200 text-sm">
                        <i class="fa-regular fa-circle-play"></i> Lihat Alur
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="bg-white border-b border-gray-200/80">
        <div class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="animate-fade-in">
                <p class="text-4xl font-black text-gray-900">3</p>
                <p class="text-xs font-semibold text-gray-400 mt-1.5 uppercase tracking-wider">Tahapan Penerbitan</p>
            </div>
            <div class="animate-fade-in" style="animation-delay: 0.05s">
                <p class="text-4xl font-black text-gray-900">3</p>
                <p class="text-xs font-semibold text-gray-400 mt-1.5 uppercase tracking-wider">Role Pengguna</p>
            </div>
            <div class="animate-fade-in" style="animation-delay: 0.1s">
                <p class="text-4xl font-black text-gray-900">4</p>
                <p class="text-xs font-semibold text-gray-400 mt-1.5 uppercase tracking-wider">Jenis Data Pendukung</p>
            </div>
            <div class="animate-fade-in" style="animation-delay: 0.15s">
                <p class="text-4xl font-black text-gray-900">100%</p>
                <p class="text-xs font-semibold text-gray-400 mt-1.5 uppercase tracking-wider">Digital & Online</p>
            </div>
        </div>
    </section>

    {{-- Alur Penerbitan --}}
    <section id="alur" class="max-w-6xl mx-auto px-6 py-24">
        <div class="text-center mb-16">
            <span
                class="inline-block px-3 py-1 bg-unuja-100 text-unuja-700 text-[10px] font-bold rounded-full uppercase tracking-wider mb-4">Alur
                Kerja</span>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Bagaimana Cara Kerjanya?</h2>
            <p class="text-gray-500 text-sm mt-3 max-w-lg mx-auto">Tiga tahapan sederhana menuju penerbitan SKPI digital
                yang sah dan terverifikasi.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6 relative">
            @php
                $steps = [
                    [
                        'num' => '01',
                        'icon' => 'fa-solid fa-paper-plane',
                        'title' => 'Submit Pengajuan',
                        'role' => 'Mahasiswa',
                        'desc' =>
                            'Lengkapi data prestasi, organisasi, sertifikat, magang, dan tugas akhir, lalu ajukan permohonan SKPI melalui sistem.',
                    ],
                    [
                        'num' => '02',
                        'icon' => 'fa-solid fa-check-double',
                        'title' => 'Verifikasi BAAK',
                        'role' => 'BAAK Fakultas',
                        'desc' =>
                            'BAAK Fakultas memverifikasi seluruh data pendukung, menyetujui/menolak setiap item, dan memberikan hasil verifikasi.',
                    ],
                    [
                        'num' => '03',
                        'icon' => 'fa-solid fa-file-pdf',
                        'title' => 'Terbitkan SKPI',
                        'role' => 'BAAK Fakultas',
                        'desc' =>
                            'BAAK menetapkan NIM Ijazah dan menerbitkan SKPI resmi. Dokumen dapat diunduh mahasiswa dalam format PDF dengan QR code.',
                    ],
                ];
            @endphp
            @foreach ($steps as $i => $s)
                <div class="step-card bg-white p-7 rounded-2xl shadow-sm border border-gray-200/80 relative animate-slide-up"
                    style="animation-delay: {{ 0.1 + $i * 0.1 }}s">
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-12 h-12 flex items-center justify-center text-unuja-600 bg-unuja-50 rounded-xl">
                            <i class="{{ $s['icon'] }} text-xl"></i>
                        </div>
                        <span class="text-3xl font-black text-gray-200">{{ $s['num'] }}</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-1">{{ $s['title'] }}</h3>
                    <p class="text-[10px] font-bold text-unuja-600 uppercase tracking-wider mb-2.5">{{ $s['role'] }}
                    </p>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $s['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Role Cards --}}
    <section class="bg-unuja-900 border-y border-unuja-800">
        <div class="max-w-6xl mx-auto px-6 py-24">
            <div class="text-center mb-16">
                <span
                    class="inline-block px-3 py-1 bg-white/10 text-white/60 text-[10px] font-bold rounded-full uppercase tracking-wider mb-4">Pengguna</span>
                <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight">Yang Terlibat dalam Sistem</h2>
                <p class="text-white/30 text-sm mt-3">Setiap role memiliki peran dan tanggung jawab spesifik dalam alur
                    penerbitan SKPI</p>
            </div>
            <div class="grid md:grid-cols-3 gap-5 max-w-4xl mx-auto">
                @php
                    $roles = [
                        [
                            'icon' => 'fa-solid fa-user-graduate',
                            'name' => 'Mahasiswa',
                            'desc' => 'Mengisi data pendukung dan mengajukan permohonan SKPI',
                            'color' => 'from-emerald-500 to-emerald-600',
                        ],
                        [
                            'icon' => 'fa-solid fa-clipboard-check',
                            'name' => 'BAAK Fakultas',
                            'desc' => 'Memverifikasi data dan menerbitkan SKPI',
                            'color' => 'from-unuja-500 to-unuja-600',
                        ],
                        [
                            'icon' => 'fa-solid fa-shield-halved',
                            'name' => 'Administrator',
                            'desc' => 'Mengelola master data dan pengguna sistem',
                            'color' => 'from-violet-500 to-violet-600',
                        ],
                    ];
                @endphp
                @foreach ($roles as $i => $r)
                    <div class="role-card p-6 text-center rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm animate-fade-in"
                        style="animation-delay: {{ 0.1 + $i * 0.1 }}s">
                        <div
                            class="w-12 h-12 flex items-center justify-center mx-auto mb-4 bg-linear-to-br {{ $r['color'] }} text-white rounded-xl shadow-lg">
                            <i class="{{ $r['icon'] }} text-lg"></i>
                        </div>
                        <h3 class="font-bold text-white text-base">{{ $r['name'] }}</h3>
                        <p class="text-sm text-white/40 mt-2 leading-relaxed">{{ $r['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-6 py-20 text-center">
            <h2 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight mb-3">Siap Memulai?</h2>
            <p class="text-gray-500 text-sm mb-8 max-w-md mx-auto">Masuk ke sistem untuk mengajukan atau memverifikasi
                permohonan SKPI.</p>
            <a href="{{ route('login') }}"
                class="inline-flex items-center gap-2 px-8 py-3.5 bg-unuja-600 text-white font-bold rounded-2xl shadow-lg hover:bg-unuja-700 hover:-translate-y-0.5 transition-all duration-200 text-sm">
                Masuk ke Sistem <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-50 border-t border-gray-200">
        <div class="max-w-6xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <div
                    class="w-7 h-7 flex items-center justify-center text-white text-[9px] font-bold bg-unuja-600 rounded-lg">
                    U</div>
                <span class="text-xs font-semibold text-gray-500">SKPI UNUJA</span>
            </div>
            <p class="text-xs text-gray-400 font-medium">&copy; {{ date('Y') }} Universitas Nurul Jadid. All
                rights reserved.</p>
        </div>
    </footer>

</body>

</html>
