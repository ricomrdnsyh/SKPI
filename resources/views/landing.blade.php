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
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        },
                        blob: {
                            '0%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                            '33%': {
                                transform: 'translate(30px, -50px) scale(1.1)'
                            },
                            '66%': {
                                transform: 'translate(-20px, 20px) scale(0.9)'
                            },
                            '100%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
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

        .bg-dot-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-800 bg-white">

    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-200 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 relative">
                <a href="#beranda" class="flex-shrink-0 flex items-center">
                    <img class="h-8 md:h-9 w-auto" src="{{ asset('assets/media/logos/skpi-dark.png') }}"
                        alt="Logo SKPI">
                </a>

                <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 items-center space-x-8">
                    <a href="#beranda"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-700 transition">Beranda</a>
                    <a href="#tentang"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-700 transition">Tentang</a>
                    <a href="#alur"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-700 transition">Alur</a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="https://sso.unuja.ac.id"
                        class="group hidden md:inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 shadow-[0_5px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_8px_20px_rgba(79,70,229,0.5)] transition-all duration-300 hover:-translate-y-0.5 hover:scale-[1.02] overflow-hidden relative">
                        <div
                            class="absolute inset-0 bg-white/20 w-1/4 -skew-x-12 -ml-10 group-hover:translate-x-[400%] transition-transform duration-700 ease-out">
                        </div>
                        <svg class="w-4 h-4 text-blue-100 group-hover:text-white transition-colors drop-shadow-sm group-hover:translate-x-0.5"
                            fill="currentColor" viewBox="0 0 512 512">
                            <path
                                d="M416 448h-84c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h84c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32h-84c-6.6 0-12-5.4-12-12V76c0-6.6 5.4-12 12-12h84c53 0 96 43 96 96v192c0 53-43 96-96 96zm-47-201L201 79c-15-15-41-4.5-41 17v96H24c-13.3 0-24 10.7-24 24v96c0 13.3 10.7 24 24 24h136v96c0 21.5 26 32 41 17l168-168c9.3-9.4 9.3-24.6 0-34z">
                            </path>
                        </svg>
                        <span class="tracking-wide drop-shadow-sm">Masuk Portal</span>
                    </a>

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
        <div id="mobile-menu-panel" class="md:hidden hidden bg-white border-t border-slate-100">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 shadow-lg">
                <a href="#beranda"
                    class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50">Beranda</a>
                <a href="#tentang"
                    class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900">Tentang</a>
                <a href="#alur"
                    class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900">Alur</a>
                <a href="https://sso.unuja.ac.id"
                    class="group flex w-full items-center justify-center gap-2 mt-4 px-3 py-3 rounded-xl text-base font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 shadow-[0_5px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_8px_20px_rgba(79,70,229,0.5)] transition-all duration-300 overflow-hidden relative">
                    <div
                        class="absolute inset-0 bg-white/20 w-1/4 -skew-x-12 -ml-10 group-hover:translate-x-[400%] transition-transform duration-700 ease-out">
                    </div>
                    <svg class="w-4 h-4 text-blue-100 group-hover:text-white transition-colors drop-shadow-sm group-hover:translate-x-0.5"
                        fill="currentColor" viewBox="0 0 512 512">
                        <path
                            d="M416 448h-84c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h84c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32h-84c-6.6 0-12-5.4-12-12V76c0-6.6 5.4-12 12-12h84c53 0 96 43 96 96v192c0 53-43 96-96 96zm-47-201L201 79c-15-15-41-4.5-41 17v96H24c-13.3 0-24 10.7-24 24v96c0 13.3 10.7 24 24 24h136v96c0 21.5 26 32 41 17l168-168c9.3-9.4 9.3-24.6 0-34z">
                        </path>
                    </svg>
                    <span class="tracking-wide drop-shadow-sm">Masuk Portal</span>
                </a>
            </div>
        </div>
    </nav>

    <section id="beranda" class="relative pt-24 pb-20 lg:pt-32 lg:pb-32 overflow-hidden bg-unujablue-950">
        <div class="absolute inset-0 bg-dot-pattern opacity-50 z-0 pointer-events-none"></div>
        <div
            class="absolute inset-0 bg-gradient-to-t from-unujablue-950 via-unujablue-950/20 to-transparent z-0 pointer-events-none">
        </div>

        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div
                class="absolute -top-40 -right-40 w-96 h-96 bg-blue-600 rounded-full mix-blend-multiply filter blur-[120px] opacity-60 animate-blob">
            </div>
            <div class="absolute top-40 -left-20 w-72 h-72 bg-emerald-500 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob"
                style="animation-delay: 2s">
            </div>
            <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-[120px] opacity-50 animate-blob"
                style="animation-delay: 4s">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left mt-8 lg:mt-0">
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full bg-blue-900/50 border border-blue-400/20 mb-6 backdrop-blur-sm opacity-0 animate-fade-in-up mx-auto lg:mx-0">
                        <span class="flex w-2 h-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span>
                        <span class="text-xs sm:text-sm font-semibold text-blue-200">Terintegrasi dengan SSO
                            UNUJA</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-[1.15] mb-6 opacity-0 animate-fade-in-up"
                        style="animation-delay: 200ms;">
                        Surat Keterangan <br class="hidden sm:block" />
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Pendamping
                            Ijazah</span>
                    </h1>
                    <p class="text-base sm:text-lg text-slate-300 mb-8 max-w-xl mx-auto lg:mx-0 leading-relaxed opacity-0 animate-fade-in-up"
                        style="animation-delay: 400ms;">
                        Dokumen resmi yang memuat informasi tentang pencapaian akademik dan kualifikasi lulusan
                        Universitas Nurul Jadid, selaras dengan Kerangka Kualifikasi Nasional Indonesia (KKNI).
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 opacity-0 animate-fade-in-up"
                        style="animation-delay: 600ms;">
                        <a href="https://sso.unuja.ac.id"
                            class="group relative inline-flex items-center justify-center gap-2.5 px-8 py-4 text-sm sm:text-base font-bold text-white bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl overflow-hidden shadow-[0_10px_20px_rgba(79,70,229,0.3)] hover:shadow-[0_15px_30px_rgba(79,70,229,0.5)] transition-all duration-300 hover:-translate-y-1 hover:scale-[1.02]">
                            <div
                                class="absolute inset-0 bg-white/20 w-1/4 -skew-x-12 -ml-10 group-hover:translate-x-[500%] transition-transform duration-700 ease-out">
                            </div>
                            <svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                </path>
                            </svg>
                            <span class="drop-shadow-sm tracking-wide">Akses Dashboard</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform drop-shadow-sm ml-1"
                                fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="#tentang"
                            class="group inline-flex items-center justify-center gap-2.5 px-8 py-4 text-sm sm:text-base font-bold text-white bg-white/5 border border-white/20 rounded-2xl hover:bg-white/10 hover:border-white/40 transition-all duration-300 backdrop-blur-md hover:-translate-y-1">
                            <svg class="w-5 h-5 text-blue-300 group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            <span
                                class="tracking-wide text-slate-100 group-hover:text-white transition-colors">Pelajari
                                SKPI</span>
                        </a>
                    </div>
                </div>
                <div class="hidden lg:flex justify-end relative opacity-0 animate-fade-in-up"
                    style="animation-delay: 800ms;">
                    <div class="relative w-full max-w-[420px] mt-8 hover:z-20">
                        <div
                            class="absolute inset-0 bg-blue-500/20 filter blur-[100px] rounded-full z-0 pointer-events-none">
                        </div>
                        <div
                            class="absolute top-0 right-0 w-[300px] h-[380px] bg-white rounded-3xl shadow-2xl transform rotate-6 translate-x-8 translate-y-2 border border-slate-200 p-6 z-10 transition-transform duration-700 hover:rotate-12 hover:translate-x-12 select-none">
                            <div class="flex items-center gap-3 mb-8 border-b border-slate-100 pb-5">
                                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="w-24 h-2.5 bg-slate-200 rounded-full mb-2"></div>
                                    <div class="w-16 h-2 bg-slate-100 rounded-full"></div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="w-full h-2.5 bg-slate-100 rounded-full"></div>
                                <div class="w-5/6 h-2.5 bg-slate-100 rounded-full"></div>
                                <div class="w-4/6 h-2.5 bg-slate-100 rounded-full"></div>
                                <div class="w-full h-2.5 bg-slate-100 rounded-full mt-8"></div>
                                <div class="w-1/2 h-2.5 bg-slate-100 rounded-full"></div>
                            </div>
                            <div
                                class="absolute bottom-8 right-8 w-20 h-20 rounded-full border-2 border-dashed border-blue-100 flex items-center justify-center opacity-50">
                                <div class="w-14 h-14 bg-blue-50/50 rounded-full flex items-center justify-center">
                                    <svg class="w-7 h-7 text-blue-200" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div
                            class="relative z-20 w-[360px] bg-slate-900/70 backdrop-blur-2xl border border-white/10 rounded-3xl p-7 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.8)] transform -rotate-2 -translate-x-2 mt-16 transition-transform duration-700 hover:rotate-0 hover:scale-105">
                            <div class="flex items-center justify-between mb-8 border-b border-white/10 pb-6">
                                <div class="flex items-center gap-4">
                                    <div class="relative w-12 h-12">
                                        <div
                                            class="absolute inset-0 rounded-full border-2 border-emerald-500/30 border-t-emerald-400 animate-[spin_3s_linear_infinite]">
                                        </div>
                                        <div
                                            class="absolute inset-1 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.5)]">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                stroke-width="3" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-white font-extrabold text-lg tracking-wide">Status Dokumen</h3>
                                        <p
                                            class="text-emerald-400 text-xs font-bold tracking-wider flex items-center gap-1.5 mt-0.5">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                                            TERVERIFIKASI
                                        </p>
                                    </div>
                                </div>
                                <div class="bg-white/5 border border-white/10 px-3 py-1.5 rounded-xl text-center">
                                    <span
                                        class="text-slate-400 text-[9px] font-black uppercase tracking-widest block mb-0.5">Standar</span>
                                    <span class="text-white text-sm font-black drop-shadow-sm">KKNI 6</span>
                                </div>
                            </div>
                            <div class="space-y-5">
                                <div
                                    class="flex items-center justify-between group cursor-default bg-white/5 p-3 -mx-3 rounded-2xl hover:bg-white/10 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center border border-blue-500/30 group-hover:bg-blue-500 group-hover:text-white transition-colors shadow-inner">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span
                                            class="text-slate-300 font-semibold text-sm group-hover:text-white transition-colors">Prestasi
                                            & Penghargaan</span>
                                    </div>
                                    <div
                                        class="text-white font-black bg-blue-500/20 border border-blue-500/30 px-3 py-1 rounded-full text-xs drop-shadow-sm">
                                        5 Dok</div>
                                </div>
                                <div
                                    class="flex items-center justify-between group cursor-default bg-white/5 p-3 -mx-3 rounded-2xl hover:bg-white/10 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center border border-indigo-500/30 group-hover:bg-indigo-500 group-hover:text-white transition-colors shadow-inner">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span
                                            class="text-slate-300 font-semibold text-sm group-hover:text-white transition-colors">Keorganisasian</span>
                                    </div>
                                    <div
                                        class="text-white font-black bg-indigo-500/20 border border-indigo-500/30 px-3 py-1 rounded-full text-xs drop-shadow-sm">
                                        3 Keg</div>
                                </div>
                                <div
                                    class="flex items-center justify-between group cursor-default bg-white/5 p-3 -mx-3 rounded-2xl hover:bg-white/10 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center border border-purple-500/30 group-hover:bg-purple-500 group-hover:text-white transition-colors shadow-inner">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span
                                            class="text-slate-300 font-semibold text-sm group-hover:text-white transition-colors">Sertifikasi
                                            & Pelatihan</span>
                                    </div>
                                    <div
                                        class="text-white font-black bg-purple-500/20 border border-purple-500/30 px-3 py-1 rounded-full text-xs drop-shadow-sm">
                                        4 Ser</div>
                                </div>
                            </div>
                            <div
                                class="mt-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-4 flex items-center justify-between shadow-[0_10px_20px_rgba(79,70,229,0.3)]">
                                <span
                                    class="text-blue-100 text-[10px] font-black uppercase tracking-widest drop-shadow-sm">Total
                                    Dokumen Valid</span>
                                <span class="text-white text-2xl font-black drop-shadow-md">12</span>
                            </div>
                        </div>
                        <div
                            class="absolute -bottom-4 -left-6 z-30 bg-emerald-500 px-4 py-2.5 rounded-2xl shadow-[0_15px_30px_rgba(16,185,129,0.4)] border border-emerald-400 transform -rotate-6 animate-[float_5s_ease-in-out_infinite_reverse] cursor-default">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-white drop-shadow-sm" fill="none" stroke="currentColor"
                                    stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-white font-black text-xs tracking-wide drop-shadow-sm">Siap
                                    Terbit</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-0 transform translate-y-[1px]">
            <svg class="relative block w-full h-[40px] md:h-[60px] lg:h-[70px]" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z"
                    fill="#ffffff"></path>
            </svg>
        </div>
    </section>

    <section id="tentang" class="py-16 lg:py-24 bg-white relative overflow-hidden">
        <div
            class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob pointer-events-none">
        </div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-emerald-50 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob pointer-events-none"
            style="animation-delay: 2s"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

                <div class="relative text-center lg:text-left mt-4 lg:mt-0">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-100 mb-6 mx-auto lg:mx-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-blue-700 font-bold text-xs uppercase tracking-wider">Tentang SKPI</span>
                    </div>

                    <h3 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 leading-[1.15] mb-6">
                        Dokumen Resmi <br class="hidden sm:block" />
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Pendamping
                            Ijazah</span>
                    </h3>

                    <div
                        class="w-20 h-1.5 bg-gradient-to-r from-blue-500 to-emerald-400 rounded-full mb-8 mx-auto lg:mx-0">
                    </div>

                    <p class="text-base sm:text-lg text-slate-600 mb-6 leading-relaxed font-medium text-justify">
                        Surat Keterangan Pendamping Ijazah (SKPI) adalah dokumen resmi yang diterbitkan oleh Universitas
                        Nurul Jadid. SKPI berfungsi merekam secara komprehensif seluruh prestasi, kompetensi, dan
                        pengalaman mahasiswa selama menempuh masa studi.
                    </p>
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed text-justify">
                        Dokumen ini bertujuan memudahkan lulusan memasuki dunia kerja dengan memaparkan kualifikasi
                        nyata yang tidak tertulis pada ijazah dan transkrip nilai konvensional.
                    </p>
                </div>

                <div class="space-y-6 relative">
                    <div class="absolute left-[35px] top-8 bottom-8 w-px bg-slate-200/60 hidden sm:block z-0"></div>
                    <div
                        class="group relative flex flex-row items-start bg-white rounded-3xl p-5 sm:p-6 border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:border-blue-200 hover:shadow-[0_8px_30px_rgb(59,130,246,0.12)] hover:-translate-y-1 transition-all duration-300 z-10">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 rounded-3xl transition-opacity duration-300 pointer-events-none">
                        </div>

                        <div
                            class="relative w-12 h-12 sm:w-14 sm:h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0 mr-4 sm:mr-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 shadow-sm">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <div class="relative">
                            <h4
                                class="text-lg sm:text-xl font-bold text-slate-900 mb-1 sm:mb-2 group-hover:text-blue-700 transition-colors">
                                Standar KKNI</h4>
                            <p
                                class="text-slate-500 text-xs sm:text-sm leading-relaxed group-hover:text-slate-700 transition-colors">
                                Disusun berdasarkan pedoman Kerangka Kualifikasi Nasional Indonesia yang diakui secara
                                nasional maupun internasional.</p>
                        </div>
                    </div>
                    <div
                        class="group relative flex flex-row items-start bg-white rounded-3xl p-5 sm:p-6 border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] hover:-translate-y-1 transition-all duration-300 z-10">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-emerald-50/50 to-transparent opacity-0 group-hover:opacity-100 rounded-3xl transition-opacity duration-300 pointer-events-none">
                        </div>

                        <div
                            class="relative w-12 h-12 sm:w-14 sm:h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0 mr-4 sm:mr-6 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500 shadow-sm">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="relative">
                            <h4
                                class="text-lg sm:text-xl font-bold text-slate-900 mb-1 sm:mb-2 group-hover:text-emerald-600 transition-colors">
                                Tanda Tangan Elektronik</h4>
                            <p
                                class="text-slate-500 text-xs sm:text-sm leading-relaxed group-hover:text-slate-700 transition-colors">
                                Dokumen terbit dilengkapi dengan QR Code dan sertifikasi elektronik (TTE) sehingga
                                keasliannya terjamin 100%.</p>
                        </div>
                    </div>
                    <div
                        class="group relative flex flex-row items-start bg-white rounded-3xl p-5 sm:p-6 border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:border-indigo-200 hover:shadow-[0_8px_30px_rgb(99,102,241,0.12)] hover:-translate-y-1 transition-all duration-300 z-10">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-indigo-50/50 to-transparent opacity-0 group-hover:opacity-100 rounded-3xl transition-opacity duration-300 pointer-events-none">
                        </div>

                        <div
                            class="relative w-12 h-12 sm:w-14 sm:h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0 mr-4 sm:mr-6 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shadow-sm">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div class="relative">
                            <h4
                                class="text-lg sm:text-xl font-bold text-slate-900 mb-1 sm:mb-2 group-hover:text-indigo-700 transition-colors">
                                SSO Terintegrasi</h4>
                            <p
                                class="text-slate-500 text-xs sm:text-sm leading-relaxed group-hover:text-slate-700 transition-colors">
                                Login mudah menggunakan Single Sign-On (SSO) UNUJA. Data profil dan akademik otomatis
                                tersinkronisasi.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="alur" class="py-16 lg:py-24 bg-slate-50 relative overflow-hidden">
        <div class="absolute inset-0 bg-dot-pattern opacity-30 z-0 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-100/50 border border-blue-200 mb-6">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="text-blue-700 font-bold text-xs uppercase tracking-wider">Tata Cara</span>
                </div>
                <h3 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6">Alur Penerbitan SKPI
                </h3>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                    Tiga langkah mudah dalam proses melengkapi dan memvalidasi portofolio dokumen SKPI sebelum
                    diterbitkan secara resmi.
                </p>
            </div>

            <div class="relative max-w-5xl mx-auto">
                <div
                    class="hidden md:block absolute top-[56px] left-[15%] right-[15%] h-1.5 bg-gradient-to-r from-blue-200 via-emerald-200 to-indigo-200 z-0 rounded-full">
                </div>
                <div
                    class="md:hidden absolute top-[56px] bottom-[56px] left-[50%] w-1.5 bg-gradient-to-b from-blue-200 via-emerald-200 to-indigo-200 z-0 rounded-full -translate-x-1/2">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 w-full relative z-10">
                    <div class="group relative flex flex-col items-center text-center">
                        <div
                            class="w-28 h-28 rounded-full bg-white p-2 shadow-[0_8px_30px_rgb(0,0,0,0.06)] mb-8 relative z-10 group-hover:-translate-y-2 transition-transform duration-500">
                            <div
                                class="w-full h-full rounded-full bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center text-4xl font-extrabold relative overflow-hidden">
                                <span class="relative z-10">1</span>
                                <div
                                    class="absolute inset-0 bg-gradient-to-tr from-blue-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>
                            <div
                                class="absolute -inset-2 rounded-full border-2 border-blue-400 border-dashed animate-[spin_10s_linear_infinite] opacity-50 group-hover:opacity-100 transition-opacity">
                            </div>
                        </div>
                        <div
                            class="bg-white p-6 sm:p-8 rounded-3xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 group-hover:border-blue-200 transition-colors duration-300 w-full relative overflow-hidden">
                            <div
                                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <h4
                                class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-700 transition-colors">
                                Pengisian Data</h4>
                            <p class="text-slate-500 text-sm leading-relaxed">Masuk ke portal, pada data pendukung,
                                unggah berkas sertifikat prestasi atau pengalaman yang Anda miliki.</p>
                        </div>
                    </div>
                    <div class="group relative flex flex-col items-center text-center">
                        <div
                            class="w-28 h-28 rounded-full bg-white p-2 shadow-[0_8px_30px_rgb(0,0,0,0.06)] mb-8 relative z-10 group-hover:-translate-y-2 transition-transform duration-500">
                            <div
                                class="w-full h-full rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-4xl font-extrabold relative overflow-hidden">
                                <span class="relative z-10">2</span>
                                <div
                                    class="absolute inset-0 bg-gradient-to-tr from-emerald-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>
                            <div
                                class="absolute -inset-2 rounded-full border-2 border-emerald-400 border-dashed animate-[spin_10s_linear_infinite_reverse] opacity-50 group-hover:opacity-100 transition-opacity">
                            </div>
                        </div>
                        <div
                            class="bg-white p-6 sm:p-8 rounded-3xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 group-hover:border-emerald-200 transition-colors duration-300 w-full relative overflow-hidden">
                            <div
                                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-emerald-500 opacity-100">
                            </div>
                            <h4
                                class="text-xl font-bold text-slate-900 mb-3 group-hover:text-emerald-600 transition-colors">
                                Verifikasi Fakultas</h4>
                            <p class="text-slate-500 text-sm leading-relaxed">Data yang diunggah akan diverifikasi
                                kebenarannya oleh BAAK Fakultas secara sistem.</p>
                        </div>
                    </div>
                    <div class="group relative flex flex-col items-center text-center">
                        <div
                            class="w-28 h-28 rounded-full bg-white p-2 shadow-[0_8px_30px_rgb(0,0,0,0.06)] mb-8 relative z-10 group-hover:-translate-y-2 transition-transform duration-500">
                            <div
                                class="w-full h-full rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-4xl font-extrabold relative overflow-hidden">
                                <span class="relative z-10">3</span>
                                <div
                                    class="absolute inset-0 bg-gradient-to-tr from-indigo-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>
                            <div
                                class="absolute -inset-2 rounded-full border-2 border-indigo-400 border-dashed animate-[spin_10s_linear_infinite] opacity-50 group-hover:opacity-100 transition-opacity">
                            </div>
                        </div>
                        <div
                            class="bg-white p-6 sm:p-8 rounded-3xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 group-hover:border-indigo-200 transition-colors duration-300 w-full relative overflow-hidden">
                            <div
                                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-400 to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <h4
                                class="text-xl font-bold text-slate-900 mb-3 group-hover:text-indigo-700 transition-colors">
                                Penerbitan Resmi</h4>
                            <p class="text-slate-500 text-sm leading-relaxed">SKPI resmi terbit bersamaan dengan ijazah
                                kelulusan dan siap diunduh dalam bentuk file digital ber-TTE.</p>
                        </div>
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
                            <a href="https://sso.unuja.ac.id" target="_blank"
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('error'))
        <script>
            Swal.fire({
                text: "{{ session('error') }}",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, mengerti",
                customClass: {
                    confirmButton: "bg-blue-700 text-white px-4 py-2 rounded-xl font-bold hover:bg-blue-800"
                }
            });
        </script>
    @endif
</body>

</html>
