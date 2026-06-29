<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Informasi Surat Keterangan Pendamping Ijazah - Universitas Nurul Jadid (UNUJA)">
    <title>SKPI UNUJA — Sistem Pendamping Ijazah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen flex flex-col bg-gray-50 text-gray-900 font-['Outfit']">

    {{-- HEADER --}}
    <header class="bg-white sticky top-0 z-30 animate-fade-in shadow-sm border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 flex items-center justify-center font-bold text-white text-sm bg-unuja-600 rounded-lg shadow-sm">U</div>
                <span class="font-bold text-gray-900 text-lg tracking-tight">SKPI UNUJA</span>
            </div>
            <nav class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline btn-sm">
                            <i class="fa-solid fa-gauge text-xs"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-right-to-bracket text-xs"></i> Masuk
                        </a>
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    {{-- HERO --}}
    <main class="flex-1 flex items-center justify-center p-6 relative overflow-hidden">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-32 -right-32 w-80 h-80 bg-unuja-600 opacity-5 rounded-full"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-unuja-400 opacity-5 rounded-full"></div>
        </div>

        <div class="relative max-w-3xl text-center">
            <div class="animate-fade-in" style="animation-delay: 0.1s">
                <div class="w-24 h-24 flex items-center justify-center font-bold text-4xl text-white mx-auto mb-8 animate-float bg-unuja-600 rounded-2xl shadow-lg">
                    U
                </div>
            </div>

            <div class="animate-fade-in" style="animation-delay: 0.2s">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 tracking-tight mb-4 leading-tight">
                    Sistem Informasi<br>
                    <span class="text-unuja-600">
                        SKPI Digital
                    </span>
                </h1>
            </div>

            <div class="animate-fade-in" style="animation-delay: 0.3s">
                <p class="text-gray-500 text-lg mb-10 max-w-xl mx-auto leading-relaxed">
                    Surat Keterangan Pendamping Ijazah<br>
                    <span class="text-gray-900 font-semibold border-b-2 border-unuja-600">Universitas Nurul Jadid (UNUJA)</span>
                </p>
            </div>

            <div class="animate-fade-in" style="animation-delay: 0.4s">
                <div class="flex items-center justify-center gap-4 flex-wrap">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary px-8 py-3.5 text-base">
                                <i class="fa-solid fa-gauge"></i> Masuk ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary px-8 py-3.5 text-base shadow-md">
                                <i class="fa-solid fa-right-to-bracket"></i> Masuk ke Aplikasi
                            </a>
                        @endauth
                    @endif
                </div>
            </div>

            <div class="animate-fade-in mt-14" style="animation-delay: 0.5s">
                <div class="flex items-center justify-center gap-3 flex-wrap">
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-gray-200 text-xs font-semibold text-gray-600 shadow-sm">
                        <i class="fa-solid fa-shield-check text-emerald-500"></i> Terintegrasi
                    </span>
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-gray-200 text-xs font-semibold text-gray-600 shadow-sm">
                        <i class="fa-solid fa-bolt text-amber-500"></i> Cepat & Efisien
                    </span>
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-gray-200 text-xs font-semibold text-gray-600 shadow-sm">
                        <i class="fa-solid fa-file-pdf text-red-500"></i> Digital PDF
                    </span>
                </div>
            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white py-5 border-t border-gray-200">
        <p class="text-center text-xs font-medium text-gray-500">&copy; {{ date('Y') }} SKPI UNUJA. All rights reserved.</p>
    </footer>

</body>
</html>
