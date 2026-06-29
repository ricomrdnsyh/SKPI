@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    {{-- Welcome Banner --}}
    <div class="card overflow-hidden animate-fade-in">
        <div class="relative px-6 py-6 bg-linear-to-br from-unuja-800 via-unuja-700 to-unuja-900">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.3) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.2) 0%, transparent 40%);"></div>
            <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-black text-white tracking-tight">Dashboard Administrator</h2>
                    <p class="text-sm text-white/50 mt-1">Manajemen master data akademik dan konfigurasi sistem SKPI.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 text-[10px] font-bold text-white/70 uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse-subtle"></span>
                        Sistem Aktif
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 stagger-children">
        @php
            $menuCards = [
                ['route' => 'fakultas.index', 'label' => 'Fakultas', 'key' => 'fakultas', 'icon' => 'fa-building', 'gradient' => 'from-amber-400 to-orange-500', 'ring' => 'ring-amber-200', 'desc' => 'Kelola data fakultas'],
                ['route' => 'prodi.index', 'label' => 'Program Studi', 'key' => 'prodi', 'icon' => 'fa-graduation-cap', 'gradient' => 'from-pink-400 to-rose-500', 'ring' => 'ring-pink-200', 'desc' => 'Kelola program studi'],
                ['route' => 'mahasiswa.index', 'label' => 'Mahasiswa', 'key' => 'mahasiswa', 'icon' => 'fa-user-graduate', 'gradient' => 'from-emerald-400 to-green-500', 'ring' => 'ring-emerald-200', 'desc' => 'Data profil mahasiswa'],
                ['route' => 'cpl.index', 'label' => 'CPL Prodi', 'key' => 'cpl', 'icon' => 'fa-book-open', 'gradient' => 'from-violet-400 to-purple-500', 'ring' => 'ring-violet-200', 'desc' => 'Capaian pembelajaran'],
                ['route' => 'kurikulum.index', 'label' => 'Kurikulum', 'key' => 'kurikulum', 'icon' => 'fa-calendar', 'gradient' => 'from-cyan-400 to-teal-500', 'ring' => 'ring-cyan-200', 'desc' => 'Kurikulum prodi'],
                ['route' => 'penilaian.index', 'label' => 'Sistem Penilaian', 'key' => 'penilaian', 'icon' => 'fa-chart-simple', 'gradient' => 'from-rose-400 to-red-500', 'ring' => 'ring-rose-200', 'desc' => 'Konversi nilai huruf'],
                ['route' => 'kategori-cpl.index', 'label' => 'Kategori CPL', 'key' => 'kategori_cpl', 'icon' => 'fa-tags', 'gradient' => 'from-indigo-400 to-blue-500', 'ring' => 'ring-indigo-200', 'desc' => 'Kategori CPL'],
                ['route' => 'users.index', 'label' => 'Pengguna', 'key' => 'users', 'icon' => 'fa-user-gear', 'gradient' => 'from-slate-400 to-gray-500', 'ring' => 'ring-slate-200', 'desc' => 'Manajemen akun'],
            ];
        @endphp
        @foreach($menuCards as $card)
        <a href="{{ route($card['route']) }}" class="stat-card group animate-fade-in relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-linear-to-br {{ $card['gradient'] }} opacity-[0.06] -translate-y-6 translate-x-6 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative flex items-start justify-between">
                <div class="space-y-1">
                    <p class="stat-label">{{ $card['label'] }}</p>
                    <p class="stat-value">{{ $stats[$card['key']] ?? 0 }}</p>
                    <p class="text-[10px] text-gray-400 font-medium mt-1">{{ $card['desc'] }}</p>
                </div>
                <div class="w-11 h-11 flex items-center justify-center text-white text-sm shrink-0 rounded-xl shadow-lg bg-linear-to-br {{ $card['gradient'] }} group-hover:scale-110 group-hover:shadow-xl transition-all duration-300">
                    <i class="fa-solid {{ $card['icon'] }}"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-[11px] text-unuja-600 font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    Kelola <i class="fa-solid fa-arrow-right ml-0.5 text-[9px]"></i>
                </p>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection