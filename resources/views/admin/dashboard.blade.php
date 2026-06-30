@extends('layout.main')

@section('title', 'Dashboard Admin')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid mt-7">
            <div id="kt_app_content_container" class="app-container container-fluid">
                
                {{-- Welcome Banner --}}
                <div class="card border-transparent shadow-sm mb-5" style="background: linear-gradient(112.14deg, #00D2FF 0%, #3A7BD5 100%);">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-4">
                            <div class="d-flex align-items-center gap-4">
                                <div class="d-flex flex-column">
                                    <h2 class="text-white fw-bold fs-2 mb-2">Dashboard Administrator</h2>
                                    <div class="text-white opacity-75 fs-6 fw-semibold">Manajemen master data akademik dan konfigurasi sistem SKPI.</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge badge-light-success fw-bold px-4 py-3 text-uppercase">
                                    <i class="ki-duotone ki-check fs-2 text-success me-1"></i> Sistem Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="row g-5 g-xl-8">
                    @php
                        $menuCards = [
                            ['route' => 'fakultas.index', 'label' => 'Fakultas', 'key' => 'fakultas', 'icon' => 'ki-bank', 'color' => 'warning', 'desc' => 'Kelola data fakultas'],
                            ['route' => 'prodi.index', 'label' => 'Program Studi', 'key' => 'prodi', 'icon' => 'ki-book-open', 'color' => 'danger', 'desc' => 'Kelola program studi'],
                            ['route' => 'mahasiswa.index', 'label' => 'Mahasiswa', 'key' => 'mahasiswa', 'icon' => 'ki-profile-user', 'color' => 'success', 'desc' => 'Data profil mahasiswa'],
                            ['route' => 'cpl.index', 'label' => 'CPL Prodi', 'key' => 'cpl', 'icon' => 'ki-medal-star', 'color' => 'info', 'desc' => 'Capaian pembelajaran'],
                            ['route' => 'kurikulum.index', 'label' => 'Kurikulum', 'key' => 'kurikulum', 'icon' => 'ki-calendar', 'color' => 'primary', 'desc' => 'Kurikulum prodi'],
                            ['route' => 'penilaian.index', 'label' => 'Sistem Penilaian', 'key' => 'penilaian', 'icon' => 'ki-chart-simple', 'color' => 'danger', 'desc' => 'Konversi nilai huruf'],
                            ['route' => 'kategori-cpl.index', 'label' => 'Kategori CPL', 'key' => 'kategori_cpl', 'icon' => 'ki-tag', 'color' => 'dark', 'desc' => 'Kategori CPL'],
                            ['route' => 'users.index', 'label' => 'Pengguna', 'key' => 'users', 'icon' => 'ki-setting-2', 'color' => 'secondary', 'desc' => 'Manajemen akun'],
                        ];
                    @endphp
                    
                    @foreach($menuCards as $card)
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route($card['route']) }}" class="card bg-{{ $card['color'] }} hoverable card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body">
                                <i class="ki-duotone {{ $card['icon'] }} text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                <div class="text-white fw-bold fs-2 mb-2 mt-5">{{ $stats[$card['key']] ?? 0 }}</div>
                                <div class="fw-semibold text-white">{{ $card['label'] }}</div>
                                <div class="text-white opacity-75 fs-7 mt-1">{{ $card['desc'] }}</div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection