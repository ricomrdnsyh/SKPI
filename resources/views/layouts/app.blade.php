<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SKPI UNUJA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="font-['Outfit'] text-gray-900 antialiased min-h-screen bg-gray-100">

    <div id="sidebar-overlay" class="sidebar-overlay hidden opacity-0 md:hidden"></div>

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}
        <aside id="sidebar"
            class="fixed md:static inset-y-0 left-0 z-50 w-64 lg:w-72 bg-unuja-900 text-white flex flex-col shrink-0 overflow-hidden h-screen transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            {{-- Brand --}}
            <div class="px-5 py-4 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 flex items-center justify-center font-black text-white text-sm bg-linear-to-br from-unuja-500 to-unuja-700 rounded-xl shadow-lg shadow-unuja-900/50">
                        U</div>
                    <div>
                        <h1 class="font-bold tracking-wide leading-tight text-sm text-white">SKPI UNUJA</h1>
                        <span class="text-[8px] text-white/30 font-medium">Sistem Pendamping Ijazah</span>
                    </div>
                    <button id="sidebar-close"
                        class="md:hidden ml-auto p-1.5 text-white/30 hover:text-white transition rounded-lg hover:bg-white/10">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
            </div>

            {{-- User profile --}}
            <div class="px-4 py-3.5 flex items-center gap-3 border-b border-white/10">
                <div class="w-9 h-9 flex items-center justify-center bg-linear-to-br from-unuja-500 to-unuja-700 text-white font-bold uppercase text-xs rounded-xl shrink-0 shadow-lg shadow-unuja-900/50">
                    {{ substr(Auth::user()->nama_lengkap, 0, 2) }}
                </div>
                <div class="overflow-hidden min-w-0">
                    <p class="text-sm font-semibold truncate text-white/90">{{ Auth::user()->nama_lengkap }}</p>
                    <span class="inline-block text-[7px] uppercase font-semibold tracking-wider px-1.5 py-0.5 mt-0.5 bg-white/10 text-white/60 rounded-md">
                        {{ str_replace('_', ' ', Auth::user()->role) }}
                    </span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-3 space-y-0.5 overflow-y-auto overflow-x-hidden">
                @php $role = Auth::user()->role; @endphp

                <a href="{{ route('dashboard') }}"
                    class="side-link {{ Request::is('dashboard') || Request::is('*/dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge w-4.5 text-center text-sm"></i>
                    <span>Dashboard</span>
                </a>

                @if ($role === 'mahasiswa')
                    <div class="side-label">Data Pendukung</div>
                    <a href="{{ route('mahasiswa.prestasi.index') }}"
                        class="side-link {{ Request::is('mahasiswa/prestasi*') ? 'active' : '' }}">
                        <i class="fa-solid fa-trophy w-4.5 text-center text-sm"></i><span>Prestasi</span>
                    </a>
                    <a href="{{ route('mahasiswa.organisasi.index') }}"
                        class="side-link {{ Request::is('mahasiswa/organisasi*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users-rectangle w-4.5 text-center text-sm"></i><span>Organisasi</span>
                    </a>
                    <a href="{{ route('mahasiswa.sertifikat.index') }}"
                        class="side-link {{ Request::is('mahasiswa/sertifikat*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-signature w-4.5 text-center text-sm"></i><span>Sertifikat</span>
                    </a>
                    <a href="{{ route('mahasiswa.magang.index') }}"
                        class="side-link {{ Request::is('mahasiswa/magang*') ? 'active' : '' }}">
                        <i class="fa-solid fa-briefcase w-4.5 text-center text-sm"></i><span>Magang / KP</span>
                    </a>
                    <a href="{{ route('mahasiswa.tugas_akhir.edit') }}"
                        class="side-link {{ Request::is('mahasiswa/tugas-akhir*') ? 'active' : '' }}">
                        <i class="fa-solid fa-graduation-cap w-4.5 text-center text-sm"></i><span>Tugas Akhir</span>
                    </a>
                @endif

                @if ($role === 'bak_fakultas')
                    <div class="side-label">Layanan Akademik</div>
                    <a href="{{ route('bak_fakultas.dashboard') }}"
                        class="side-link {{ Request::is('bak-fakultas*') ? 'active' : '' }}">
                        <i class="fa-solid fa-list-check w-4.5 text-center text-sm"></i><span>Antrian SKPI</span>
                    </a>
                @endif

                @if ($role === 'bak_fakultas')
                    <div class="side-label">Data Akademik</div>
                    <a href="{{ route('mahasiswa.index') }}"
                        class="side-link {{ Request::is('akademik/mahasiswa*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-graduate w-4.5 text-center text-sm"></i><span>Mahasiswa</span>
                    </a>
                    <a href="{{ route('fakultas.index') }}"
                        class="side-link {{ Request::is('akademik/fakultas*') ? 'active' : '' }}">
                        <i class="fa-solid fa-building w-4.5 text-center text-sm"></i><span>Fakultas</span>
                    </a>
                    <a href="{{ route('prodi.index') }}"
                        class="side-link {{ Request::is('akademik/prodi*') ? 'active' : '' }}">
                        <i class="fa-solid fa-graduation-cap w-4.5 text-center text-sm"></i><span>Prodi</span>
                    </a>
                    <a href="{{ route('cpl.index') }}"
                        class="side-link {{ Request::is('akademik/cpl*') ? 'active' : '' }}">
                        <i class="fa-solid fa-book-open w-4.5 text-center text-sm"></i><span>CPL Prodi</span>
                    </a>
                    <a href="{{ route('kurikulum.index') }}"
                        class="side-link {{ Request::is('akademik/kurikulum*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar w-4.5 text-center text-sm"></i><span>Kurikulum</span>
                    </a>
                @endif

                @if ($role === 'admin')
                    <div class="side-label">Manajemen Sistem</div>
                    <a href="{{ route('users.index') }}"
                        class="side-link {{ Request::is('admin/users*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-gear w-4.5 text-center text-sm"></i><span>Pengguna</span>
                    </a>
                    <a href="{{ route('fakultas.index') }}"
                        class="side-link {{ Request::is('akademik/fakultas*') ? 'active' : '' }}">
                        <i class="fa-solid fa-building w-4.5 text-center text-sm"></i><span>Fakultas</span>
                    </a>
                    <a href="{{ route('prodi.index') }}"
                        class="side-link {{ Request::is('akademik/prodi*') ? 'active' : '' }}">
                        <i class="fa-solid fa-graduation-cap w-4.5 text-center text-sm"></i><span>Prodi</span>
                    </a>
                    <a href="{{ route('kategori-cpl.index') }}"
                        class="side-link {{ Request::is('admin/kategori-cpl*') ? 'active' : '' }}">
                        <i class="fa-solid fa-tags w-4.5 text-center text-sm"></i><span>Kategori CPL</span>
                    </a>
                    <a href="{{ route('mahasiswa.index') }}"
                        class="side-link {{ Request::is('akademik/mahasiswa*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-graduate w-4.5 text-center text-sm"></i><span>Mahasiswa</span>
                    </a>
                    <a href="{{ route('cpl.index') }}"
                        class="side-link {{ Request::is('akademik/cpl*') ? 'active' : '' }}">
                        <i class="fa-solid fa-book-open w-4.5 text-center text-sm"></i><span>CPL Prodi</span>
                    </a>
                    <a href="{{ route('kurikulum.index') }}"
                        class="side-link {{ Request::is('akademik/kurikulum*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar w-4.5 text-center text-sm"></i><span>Kurikulum</span>
                    </a>
                    <a href="{{ route('penilaian.index') }}"
                        class="side-link {{ Request::is('admin/penilaian*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-simple w-4.5 text-center text-sm"></i><span>Sistem Penilaian</span>
                    </a>
                @endif
            </nav>

            {{-- Logout --}}
            <div class="p-3 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-white/30 hover:bg-red-500/80 hover:text-white transition-all duration-200 text-sm cursor-pointer font-semibold rounded-xl">
                        <i class="fa-solid fa-right-from-bracket w-4.5 text-center"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-100">

            {{-- Header --}}
            <header class="bg-white/95 backdrop-blur-sm px-4 md:px-6 lg:px-8 py-3.5 flex items-center justify-between shrink-0 shadow-sm border-b border-gray-200/80 sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <button id="sidebar-open"
                        class="md:hidden p-2 -ml-1 text-gray-500 hover:bg-gray-100 rounded-xl transition border border-gray-200 w-9 h-9 flex items-center justify-center">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div class="h-5 w-px bg-gray-200 md:hidden"></div>
                    <div class="text-sm font-medium">
                        <span class="text-gray-400 hidden sm:inline">Hari ini,</span>
                        <span class="text-gray-800 font-semibold ml-0.5">{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="h-5 w-px bg-gray-200 hidden sm:block"></div>
                    <div class="text-right hidden sm:block">
                        <p class="text-[8px] text-gray-400 font-semibold uppercase tracking-wider leading-none">Masuk sebagai</p>
                        <p class="text-sm font-bold text-gray-900">{{ Auth::user()->username }}</p>
                    </div>
                    <div class="w-8 h-8 flex items-center justify-center bg-linear-to-br from-unuja-500 to-unuja-700 text-white font-bold uppercase text-xs rounded-xl shrink-0 shadow-sm sm:hidden">
                        {{ substr(Auth::user()->nama_lengkap, 0, 2) }}
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
                @if (session('success'))
                    <div class="flash-message mb-6 bg-emerald-50 border-emerald-200/60 text-emerald-800 shadow-sm">
                        <i class="fa-solid fa-circle-check text-lg text-emerald-500 mt-0.5 shrink-0"></i>
                        <div class="flex-1 text-sm font-medium">{{ session('success') }}</div>
                        <i class="fa-solid fa-xmark text-emerald-400 hover:text-emerald-600 text-sm mt-0.5 shrink-0 cursor-pointer"></i>
                    </div>
                @endif

                @if (session('error'))
                    <div class="flash-message mb-6 bg-red-50 border-red-200/60 text-red-800 shadow-sm">
                        <i class="fa-solid fa-circle-xmark text-lg text-red-500 mt-0.5 shrink-0"></i>
                        <div class="flex-1 text-sm font-medium">{{ session('error') }}</div>
                        <i class="fa-solid fa-xmark text-red-400 hover:text-red-600 text-sm mt-0.5 shrink-0 cursor-pointer"></i>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="flash-message mb-6 bg-amber-50 border-amber-200/60 text-amber-800 shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation text-lg text-amber-500 mt-0.5 shrink-0"></i>
                        <div class="flex-1 text-sm font-medium">{{ session('warning') }}</div>
                        <i class="fa-solid fa-xmark text-amber-400 hover:text-amber-600 text-sm mt-0.5 shrink-0 cursor-pointer"></i>
                    </div>
                @endif

                <div id="main-content">
                    @yield('content')
                </div>
            </main>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>

    @stack('scripts')
</body>

</html>
