<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="robots" content="index, follow">
    <meta name="description" content="SKPI - Surat Keterangan Pendamping Ijazah Universitas Nurul Jadid.">
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/unuja.png') }}" />
    <title>SKPI | Universitas Nurul Jadid</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    },
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            900: '#14532d',
                        },
                        unujablue: {
                            800: '#1e3a8a',
                            900: '#1e3a5f',
                            950: '#0f2744'
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        .clip-diagonal {
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-800 bg-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-200 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 relative">
                <!-- Logo -->
                <a href="#beranda" class="flex-shrink-0 flex items-center">
                    <img class="h-8 md:h-9 w-auto" src="{{ asset('assets/media/logos/skpi-dark.png') }}"
                        alt="Logo SKPI">
                </a>

                <!-- Centered Desktop Menu -->
                <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 items-center space-x-8">
                    <a href="#beranda"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-700 transition">Beranda</a>
                    <a href="#tentang"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-700 transition">Tentang</a>
                    <a href="#alur"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-700 transition">Alur</a>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-4">
                    <!-- CTA Button Desktop -->
                    <a href="{{ route('login') }}"
                        class="hidden md:inline-flex items-center justify-center px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 shadow-lg shadow-blue-700/30 hover:shadow-blue-700/50 transition-all duration-200 hover:-translate-y-0.5">
                        Masuk Portal
                    </a>

                    <!-- Mobile menu button -->
                    <button id="mobile-menu-btn"
                        class="md:hidden p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu Panel -->
        <div id="mobile-menu-panel" class="md:hidden hidden bg-white border-t border-slate-100">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 shadow-lg">
                <a href="#beranda"
                    class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50">Beranda</a>
                <a href="#tentang"
                    class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900">Tentang</a>
                <a href="#dokumen"
                    class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900">Dokumen</a>
                <a href="{{ route('login') }}"
                    class="block w-full text-center mt-4 px-3 py-3 rounded-xl text-base font-bold text-white bg-blue-700 hover:bg-blue-800">Masuk
                    Portal</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda"
        class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-unujablue-950 clip-diagonal">
        <!-- Abstract Background Shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div
                class="absolute -top-40 -right-40 w-96 h-96 bg-blue-600 rounded-full mix-blend-multiply filter blur-[120px] opacity-60 animate-blob">
            </div>
            <div
                class="absolute top-40 -left-20 w-72 h-72 bg-emerald-500 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob" style="animation-delay: 2s">
            </div>
            <div
                class="absolute bottom-0 right-1/4 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-[120px] opacity-50 animate-blob" style="animation-delay: 4s">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div>
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full bg-blue-900/50 border border-blue-400/20 mb-6 backdrop-blur-sm opacity-0 animate-fade-in-up">
                        <span class="flex w-2 h-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span>
                        <span class="text-sm font-semibold text-blue-200">Terintegrasi dengan SSO UNUJA</span>
                    </div>
                    <h1
                        class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-[1.1] mb-6 opacity-0 animate-fade-in-up" style="animation-delay: 200ms;">
                        Surat Keterangan <br />
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Pendamping
                            Ijazah</span>
                    </h1>
                    <p class="text-lg text-slate-300 mb-8 max-w-xl leading-relaxed opacity-0 animate-fade-in-up" style="animation-delay: 400ms;">
                        Dokumen resmi yang memuat informasi tentang pencapaian akademik dan kualifikasi lulusan
                        Universitas Nurul Jadid, selaras dengan Kerangka Kualifikasi Nasional Indonesia (KKNI).
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 opacity-0 animate-fade-in-up" style="animation-delay: 600ms;">
                        <a href="{{ route('login') }}"
                            class="group inline-flex items-center justify-center px-8 py-4 text-base font-bold text-unujablue-950 bg-white rounded-xl hover:bg-blue-50 transition-all duration-300 shadow-[0_0_20px_rgba(255,255,255,0.2)] hover:scale-105 hover:-translate-y-1">
                            Akses Dashboard
                            <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                        <a href="#tentang"
                            class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-transparent border border-white/30 rounded-xl hover:bg-white/10 transition-all duration-300 hover:scale-105 hover:-translate-y-1">
                            Pelajari SKPI
                        </a>
                    </div>
                </div>

                <!-- Illustration -->
                <div class="hidden lg:flex justify-end relative opacity-0 animate-fade-in-up" style="animation-delay: 800ms;">
                    <div class="relative w-full max-w-lg hover:z-20">
                        <!-- Glass Card 1 -->
                        <div
                            class="group absolute -top-10 -right-4 w-72 bg-white/10 backdrop-blur-xl border border-white/20 p-6 rounded-2xl shadow-2xl transform rotate-3 animate-[float_6s_ease-in-out_infinite] hover:bg-white/20 hover:border-white/40 hover:shadow-blue-400/20 transition-all duration-300 cursor-default">
                            <div class="flex items-center gap-4 mb-4 group-hover:scale-105 group-hover:translate-x-2 transition-all duration-300">
                                <div
                                    class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center border border-blue-400/30">
                                    <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold">Validasi KKNI</h4>
                                    <p class="text-blue-200 text-xs">Standar Nasional</p>
                                </div>
                            </div>
                            <div class="w-full bg-white/20 h-2 rounded-full mb-2 overflow-hidden">
                                <div class="w-full h-full bg-blue-400 rounded-full group-hover:bg-blue-300 group-hover:translate-x-full transition-all duration-1000 -translate-x-full"></div>
                                <div class="w-full h-full bg-blue-400 rounded-full -mt-2"></div>
                            </div>
                            <div class="w-3/4 bg-white/20 h-2 rounded-full overflow-hidden">
                                <div class="w-full h-full bg-blue-400 rounded-full group-hover:bg-blue-300 group-hover:translate-x-full transition-all duration-1000 delay-100 -translate-x-full"></div>
                                <div class="w-full h-full bg-blue-400 rounded-full -mt-2"></div>
                            </div>
                        </div>

                        <!-- Glass Card 2 -->
                        <div
                            class="group relative mt-20 w-80 bg-gradient-to-br from-white to-blue-50 p-6 rounded-2xl shadow-2xl border border-white z-10 animate-[float_7s_ease-in-out_infinite_reverse] hover:shadow-blue-500/20 hover:border-blue-200 transition-all duration-300 cursor-default">
                            <div class="flex items-center justify-between mb-6 group-hover:scale-105 transition-transform duration-300">
                                <h3 class="text-slate-800 font-extrabold text-lg group-hover:text-blue-700 transition-colors">Sertifikat SKPI</h3>
                                <span
                                    class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-1 rounded">Terverifikasi</span>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start gap-3 p-2 -mx-2 rounded-xl hover:bg-blue-100/50 transition-colors group-hover:translate-x-1 duration-300">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0 group-hover:bg-blue-200 group-hover:rotate-12 transition-all">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-slate-800 font-bold text-sm">Prestasi & Penghargaan</p>
                                        <p class="text-slate-500 text-xs">3 Sertifikat tercatat</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-2 -mx-2 rounded-xl hover:bg-indigo-100/50 transition-colors group-hover:translate-x-1 duration-300 delay-75">
                                    <div
                                        class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center shrink-0 group-hover:bg-indigo-200 group-hover:rotate-12 transition-all">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-slate-800 font-bold text-sm">Magang & Organisasi</p>
                                        <p class="text-slate-500 text-xs">2 Pengalaman tercatat</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Section -->
    <section id="tentang" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <div>
                    <h2 class="text-blue-700 font-bold tracking-wide uppercase text-sm mb-3">Tentang SKPI</h2>
                    <h3 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-6">Dokumen Resmi
                        Pendamping Ijazah Kelulusan</h3>
                    <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                        Surat Keterangan Pendamping Ijazah (SKPI) adalah dokumen resmi yang diterbitkan oleh Universitas
                        Nurul Jadid. SKPI berfungsi merekam secara komprehensif seluruh prestasi, kompetensi, dan
                        pengalaman mahasiswa selama menempuh masa studi.
                    </p>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                        Dokumen ini bertujuan memudahkan lulusan memasuki dunia kerja dengan memaparkan kualifikasi
                        nyata yang tidak tertulis pada ijazah dan transkrip nilai konvensional.
                    </p>
                </div>

                <!-- Features List Right Side -->
                <div class="space-y-6">
                    <div
                        class="group flex items-start bg-slate-50 rounded-2xl p-6 border border-slate-100 hover:border-blue-200 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-14 h-14 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shrink-0 mr-5 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-blue-700 transition-colors">Standar KKNI</h4>
                            <p class="text-slate-600 text-sm leading-relaxed">Disusun berdasarkan pedoman Kerangka
                                Kualifikasi Nasional Indonesia yang diakui secara nasional maupun internasional.</p>
                        </div>
                    </div>

                    <div
                        class="group flex items-start bg-slate-50 rounded-2xl p-6 border border-slate-100 hover:border-emerald-200 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shrink-0 mr-5 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-emerald-700 transition-colors">Tanda Tangan Elektronik</h4>
                            <p class="text-slate-600 text-sm leading-relaxed">Dokumen terbit dilengkapi dengan QR Code
                                dan sertifikasi elektronik (TTE) sehingga keasliannya terjamin 100%.</p>
                        </div>
                    </div>

                    <div
                        class="group flex items-start bg-slate-50 rounded-2xl p-6 border border-slate-100 hover:border-indigo-200 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center shrink-0 mr-5 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-indigo-700 transition-colors">SSO Terintegrasi</h4>
                            <p class="text-slate-600 text-sm leading-relaxed">Login mudah menggunakan Single Sign-On
                                (SSO) UNUJA. Data profil dan akademik otomatis tersinkronisasi.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Dokumen / Alur Section (Timeline) -->
    <section id="alur" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-blue-700 font-bold tracking-wide uppercase text-sm mb-3">Tata Cara</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-slate-900">Alur Penerbitan SKPI</h3>
                <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">Tiga langkah mudah dalam proses melengkapi dan
                    memvalidasi portofolio dokumen SKPI sebelum diterbitkan.</p>
            </div>

            <!-- Horizontal Timeline -->
            <div class="relative max-w-5xl mx-auto flex justify-center">
                <!-- Line -->
                <div class="hidden md:block absolute top-12 left-[15%] right-[15%] h-1 bg-slate-200 z-0 rounded-full">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 w-full relative z-10">

                    <!-- Step 1 -->
                    <div class="group flex flex-col items-center text-center p-4 rounded-2xl hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-24 h-24 rounded-full bg-white border-4 border-slate-50 shadow-xl text-blue-600 flex items-center justify-center text-3xl font-extrabold mb-6 relative group-hover:scale-110 transition-transform duration-300">
                            1
                            <!-- Active indicator -->
                            <div
                                class="absolute -inset-1 rounded-full border-2 border-blue-500 border-dashed animate-[spin_10s_linear_infinite]">
                            </div>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-700 transition-colors">Pengisian Data</h4>
                        <p class="text-slate-600 text-sm">Masuk ke portal, pada data pendukung, unggah berkas
                            sertifikat prestasi atau pengalaman yang Anda miliki.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="group flex flex-col items-center text-center p-4 rounded-2xl hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-24 h-24 rounded-full bg-white border-4 border-slate-50 shadow-xl text-emerald-600 flex items-center justify-center text-3xl font-extrabold mb-6 group-hover:scale-110 transition-transform duration-300">
                            2
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-emerald-600 transition-colors">Verifikasi BAAK Fakultas</h4>
                        <p class="text-slate-600 text-sm">Data yang diunggah akan diverifikasi kebenarannya oleh
                            BAAK Fakultas secara sistem.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="group flex flex-col items-center text-center p-4 rounded-2xl hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-24 h-24 rounded-full bg-blue-700 border-4 border-slate-50 shadow-xl shadow-blue-700/30 text-white flex items-center justify-center text-3xl font-extrabold mb-6 group-hover:scale-110 transition-transform duration-300">
                            3
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-700 transition-colors">Penerbitan</h4>
                        <p class="text-slate-600 text-sm">SKPI resmi terbit bersamaan dengan ijazah kelulusan dan siap
                            diunduh dalam bentuk file digital ber-TTE.</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <footer class="relative mt-auto" style="background: linear-gradient(160deg, #0f2744, #1e3a5f 50%, #1e40af);">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 pt-16 pb-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8">
                <div class="sm:col-span-2 lg:col-span-4">
                    <div class="mb-6">
                        <img src="{{ asset('assets/media/logos/skpi.png') }}" alt="Logo SKPI"
                            class="h-10 lg:h-[45px] w-auto object-contain hover:opacity-90 active:opacity-90 transition-opacity active:scale-[0.98]">
                    </div>
                    <p class="text-white/50 text-sm leading-relaxed max-w-xs">
                        Portal layanan surat menyurat mahasiswa Universitas Nurul Jadid yang terintegrasi secara digital
                        untuk kemudahan layanan akademik.
                    </p>
                    <div class="flex gap-2.5 mt-6">
                        <a href="https://www.facebook.com/universitasnuruljadid/" target="_blank"
                            class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center text-white/40 hover:bg-white/10 active:bg-white/10 hover:text-yellow-400 active:text-yellow-400 transition-all no-underline active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/unujaofficial/" target="_blank"
                            class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center text-white/40 hover:bg-white/10 active:bg-white/10 hover:text-yellow-400 active:text-yellow-400 transition-all no-underline active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" />
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                            </svg>
                        </a>
                        <a href="https://x.com/unujaofficial" target="_blank"
                            class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center text-white/40 hover:bg-white/10 active:bg-white/10 hover:text-yellow-400 active:text-yellow-400 transition-all no-underline active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                        <a href="https://www.tiktok.com/@unujaofficial" target="_blank"
                            class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center text-white/40 hover:bg-white/10 active:bg-white/10 hover:text-yellow-400 active:text-yellow-400 transition-all no-underline active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.27 6.27 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.79 1.54V6.78a4.85 4.85 0 01-1.02-.09z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-3 lg:col-start-5">
                    <h4 class="font-bold text-white/80 text-xs uppercase tracking-[0.15em] mb-4">Kontak</h4>
                    <div class="w-8 h-0.5 rounded-full mb-5 bg-yellow-400"></div>
                    <ul class="flex flex-col gap-3.5 text-sm text-white/50 list-none p-0 m-0">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-white/50" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span
                                class="leading-relaxed hover:text-yellow-400 active:text-yellow-400 transition-colors cursor-default active:scale-[0.98]">
                                JL. PP Nurul Jadid, Dusun Tj. Lor, Karanganyar, Kec. Paiton, Kabupaten Probolinggo, Jawa
                                Timur 67291
                            </span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 shrink-0 text-white/50" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <a href="tel:+628883077077"
                                class="text-white/50 no-underline hover:text-yellow-400 active:text-yellow-400 transition-colors active:scale-[0.98]">0888
                                30 77077</a>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 shrink-0 text-white/50" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="6 9 6 2 18 2 18 9" />
                                <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2" />
                                <rect x="6" y="14" width="12" height="8" />
                            </svg>
                            <span
                                class="hover:text-yellow-400 active:text-yellow-400 transition-colors cursor-default active:scale-[0.98]">Fax
                                0888 30 77077</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 shrink-0 text-white/50" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <a href="mailto:unuja@unuja.ac.id"
                                class="text-white/50 no-underline hover:text-yellow-400 active:text-yellow-400 transition-colors active:scale-[0.98]">unuja@unuja.ac.id</a>
                        </li>
                    </ul>
                </div>

                <div class="lg:col-span-3">
                    <h4 class="font-bold text-white/80 text-xs uppercase tracking-[0.15em] mb-4">Internal</h4>
                    <div class="w-8 h-0.5 rounded-full mb-5 bg-yellow-400"></div>
                    <ul class="flex flex-col gap-2.5 text-sm list-none p-0 m-0">
                        <li>
                            <a href="https://unuja.ac.id" target="_blank"
                                class="inline-flex items-center gap-2 text-white/50 no-underline hover:text-yellow-400 active:text-yellow-400 hover:translate-x-1.5 active:translate-x-1.5 transition-all duration-300 group active:scale-[0.98]">
                                <svg class="w-3.5 h-3.5 text-white/50 group-hover:text-yellow-400 group-active:text-yellow-400 transition-colors shrink-0 active:scale-[0.98]"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                Universitas Nurul Jadid
                            </a>
                        </li>
                        <li>
                            <a href="https://pmb.unuja.ac.id" target="_blank"
                                class="inline-flex items-center gap-2 text-white/50 no-underline hover:text-yellow-400 active:text-yellow-400 hover:translate-x-1.5 active:translate-x-1.5 transition-all duration-300 group active:scale-[0.98]">
                                <svg class="w-3.5 h-3.5 text-white/50 group-hover:text-yellow-400 group-active:text-yellow-400 transition-colors shrink-0 active:scale-[0.98]"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                PMB Universitas Nurul Jadid
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" target="_blank"
                                class="inline-flex items-center gap-2 text-white/50 no-underline hover:text-yellow-400 active:text-yellow-400 hover:translate-x-1.5 active:translate-x-1.5 transition-all duration-300 group active:scale-[0.98]">
                                <svg class="w-3.5 h-3.5 text-white/50 group-hover:text-yellow-400 group-active:text-yellow-400 transition-colors shrink-0 active:scale-[0.98]"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                Portal SSO Universitas Nurul Jadid
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="lg:col-span-2">
                    <h4 class="font-bold text-white/80 text-xs uppercase tracking-[0.15em] mb-4">Navigasi</h4>
                    <div class="w-8 h-0.5 rounded-full mb-5 bg-yellow-400"></div>
                    <ul class="flex flex-col gap-2.5 text-sm list-none p-0 m-0">
                        <li>
                            <a href="#beranda"
                                class="inline-flex items-center gap-2 text-white/50 no-underline hover:text-yellow-400 active:text-yellow-400 hover:translate-x-1.5 active:translate-x-1.5 transition-all duration-300 group active:scale-[0.98]">
                                <svg class="w-3.5 h-3.5 text-white/50 group-hover:text-yellow-400 group-active:text-yellow-400 transition-colors shrink-0 active:scale-[0.98]"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="#tentang"
                                class="inline-flex items-center gap-2 text-white/50 no-underline hover:text-yellow-400 active:text-yellow-400 hover:translate-x-1.5 active:translate-x-1.5 transition-all duration-300 group active:scale-[0.98]">
                                <svg class="w-3.5 h-3.5 text-white/50 group-hover:text-yellow-400 group-active:text-yellow-400 transition-colors shrink-0 active:scale-[0.98]"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                Tentang
                            </a>
                        </li>
                        <li>
                            <a href="#dokumen"
                                class="inline-flex items-center gap-2 text-white/50 no-underline hover:text-yellow-400 active:text-yellow-400 hover:translate-x-1.5 active:translate-x-1.5 transition-all duration-300 group active:scale-[0.98]">
                                <svg class="w-3.5 h-3.5 text-white/50 group-hover:text-yellow-400 group-active:text-yellow-400 transition-colors shrink-0 active:scale-[0.98]"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                Alur
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-t border-white/5">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 py-5 flex flex-col md:flex-row items-center justify-between gap-3">
                <p class="text-sm text-white/30 m-0 font-medium">&copy; 2026 PDSI Universitas Nurul Jadid. Hak Cipta
                    Dilindungi.</p>
                <div class="flex items-center gap-4 text-sm text-white/30">
                    <a href="#"
                        class="text-white/30 no-underline hover:text-yellow-400 active:text-yellow-400 transition-colors active:scale-[0.98]">Kebijakan
                        Privasi</a>
                    <span class="w-1 h-1 rounded-full bg-white/10"></span>
                    <a href="#"
                        class="text-white/30 no-underline hover:text-yellow-400 active:text-yellow-400 transition-colors active:scale-[0.98]">Syarat
                        &amp; Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu-panel');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 20) {
                nav.classList.add('shadow-md');
            } else {
                nav.classList.remove('shadow-md');
            }
        });
    </script>

    <script>
        const btn = document.getElementById('btnMobileMenu');
        const menu = document.getElementById('mobileMenu');
        const iconOpen = document.getElementById('iconOpen');
        const iconClose = document.getElementById('iconClose');

        btn?.addEventListener('click', () => {
            const isHidden = menu.classList.contains('hidden');
            menu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', String(isHidden));
        });

        menu?.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', () => {
                menu.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
            });
        });

        document.querySelectorAll('.faq-trigger').forEach(trigger => {
            trigger.addEventListener('click', () => {
                const item = trigger.closest('.faq-item');
                const isOpen = item.classList.contains('open');
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
                if (!isOpen) item.classList.add('open');
            });
        });
    </script>
</body>

</html>
