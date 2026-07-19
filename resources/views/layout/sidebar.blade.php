<style>
    #kt_app_sidebar_user .user-card {
        background: rgba(255, 255, 255, 0.03);
        border: none;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    #kt_app_sidebar_user .user-card:hover {
        background: rgba(255, 255, 255, 0.08) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    body[data-kt-app-sidebar-minimize="on"] #kt_app_sidebar_user .sidebar-minimize-hide,
    html[data-kt-app-sidebar-minimize="on"] #kt_app_sidebar_user .sidebar-minimize-hide,
    body.app-sidebar-minimize #kt_app_sidebar_user .sidebar-minimize-hide,
    html.app-sidebar-minimize #kt_app_sidebar_user .sidebar-minimize-hide {
        display: none !important
    }

    body[data-kt-app-sidebar-minimize="on"] #kt_app_sidebar_user,
    html[data-kt-app-sidebar-minimize="on"] #kt_app_sidebar_user,
    body.app-sidebar-minimize #kt_app_sidebar_user,
    html.app-sidebar-minimize #kt_app_sidebar_user {
        padding-left: .5rem !important;
        padding-right: .5rem !important
    }

    body[data-kt-app-sidebar-minimize="on"] #kt_app_sidebar_user .user-card,
    html[data-kt-app-sidebar-minimize="on"] #kt_app_sidebar_user .user-card,
    body.app-sidebar-minimize #kt_app_sidebar_user .user-card,
    html.app-sidebar-minimize #kt_app_sidebar_user .user-card {
        padding: .5rem !important
    }

    body[data-kt-app-sidebar-minimize="on"] #kt_app_sidebar_footer .sidebar-minimize-hide,
    html[data-kt-app-sidebar-minimize="on"] #kt_app_sidebar_footer .sidebar-minimize-hide,
    body.app-sidebar-minimize #kt_app_sidebar_footer .sidebar-minimize-hide,
    html.app-sidebar-minimize #kt_app_sidebar_footer .sidebar-minimize-hide {
        display: none !important
    }

    body[data-kt-app-sidebar-minimize="on"] #kt_app_sidebar_footer .btn,
    html[data-kt-app-sidebar-minimize="on"] #kt_app_sidebar_footer .btn,
    body.app-sidebar-minimize #kt_app_sidebar_footer .btn,
    html.app-sidebar-minimize #kt_app_sidebar_footer .btn {
        padding-left: .75rem !important;
        padding-right: .75rem !important;
        justify-content: center !important
    }


    #kt_app_sidebar_footer .btn {
        background: rgba(255, 255, 255, 0.04) !important;
        border: none !important;
        color: rgba(255, 255, 255, 0.8) !important;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        font-weight: 600;
        padding: 0.75rem 1rem;
    }

    #kt_app_sidebar_footer .btn i {
        color: rgba(255, 255, 255, 0.8) !important;
        transition: all 0.3s ease;
    }

    #kt_app_sidebar_footer .btn:hover {
        background: rgba(220, 53, 69, 0.85) !important;

        color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.25);
        transform: translateY(-1px);
    }

    #kt_app_sidebar_footer .btn:hover i {
        color: #ffffff !important;
        transform: translateX(3px);

    }


    #kt_app_sidebar_menu_scroll::-webkit-scrollbar {
        width: 4px;
    }

    #kt_app_sidebar_menu_scroll::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }

    #kt_app_sidebar_menu_scroll:hover::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.25);
    }

    #kt_app_sidebar_logo .app-sidebar-logo-default {
        height: 55px !important;
        width: auto !important;
        margin-top: 0px;
        margin-left: 0;
        max-width: 100%;
        object-fit: contain;
        object-position: left center;
    }

    #kt_app_sidebar_logo .app-sidebar-logo-minimize {
        height: 28px !important;
        width: auto !important;
        object-fit: contain;
        object-position: center;
    }

    @media (min-width: 992px) {
        #kt_app_sidebar_logo {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #kt_app_sidebar_logo>a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 100%;
        }
    }

    @media (max-width: 991.98px) {
        #kt_app_sidebar_logo .app-sidebar-logo-default {
            height: 45px !important;
            max-width: 100%;
        }

        #kt_app_sidebar_logo .app-sidebar-logo-minimize {
            height: 24px !important;
        }
    }


    #kt_app_sidebar_menu .menu-item .menu-arrow:after {
        content: "+" !important;
        background: none !important;
        -webkit-mask-image: none !important;
        mask-image: none !important;
        transform: none !important;
        font-size: 1.25rem !important;
        font-weight: 400 !important;
        color: inherit !important;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    #kt_app_sidebar_menu .menu-item.show>.menu-link .menu-arrow:after,
    #kt_app_sidebar_menu .menu-item.here>.menu-link .menu-arrow:after {
        content: "-" !important;
    }
</style>
@php
    $currentUser = Auth::user();
    $roleName = 'Pengguna';
    if ($currentUser) {
        if ($currentUser->role == 'admin') {
            $roleName = 'Administrator';
        } elseif ($currentUser->role == 'bak_fakultas') {
            $roleName = 'Fakultas';
        } elseif ($currentUser->role == 'mahasiswa') {
            $roleName = 'Mahasiswa';
        }
    }
    $role = $currentUser->role ?? '';
@endphp
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="#">
            <img alt="Logo" src="{{ asset('assets/media/logos/skpi.png') }}" class="app-sidebar-logo-default" />
            <img alt="Logo" src="{{ asset('assets/media/logos/unuja.png') }}" class="app-sidebar-logo-minimize" />
        </a>
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span><span class="path2"></span>
            </i>
        </div>
    </div>
    <div class="px-4 pt-4 pb-3" id="kt_app_sidebar_user">
        <a href="#"
            class="user-card d-flex flex-column align-items-center text-center w-100 rounded-3 p-3 text-decoration-none">
            <div class="symbol symbol-42px symbol-circle position-relative">
                <img src="{{ asset('assets/media/avatars/profile.png') }}" alt="avatar"
                    class="w-30 h-30 object-fit-cover" />
                <span
                    class="position-absolute translate-middle bottom-0 start-100 bg-success rounded-circle border-2 border-white"
                    style="width:10px;height:10px;"></span>
            </div>
            <div class="sidebar-minimize-hide mt-2 w-100">
                <div class="text-white fw-semibold text-truncate">{{ $currentUser?->nama_lengkap ?? 'User' }}</div>
                <div class="text-gray-400 fs-8 text-truncate">
                    {{ $roleName }}
                </div>
            </div>
        </a>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_user, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">
                    <div class="menu-item pt-5">
                        <div class="menu-content pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Main</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::is('dashboard') || Request::is('*/dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-element-11 fs-2">
                                    <span class="path1"></span><span class="path2"></span>
                                    <span class="path3"></span><span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>
                    @if ($role === 'admin')
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('admin/users*') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-user-gear fs-4"></i></span>
                                <span class="menu-title">Pengguna</span>
                            </a>
                        </div>
                    @endif
                    @if ($role === 'bak_fakultas')
                        <div class="menu-item pt-5">
                            <div class="menu-content pb-2">
                                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Master</span>
                            </div>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/fakultas*') ? 'active' : '' }}"
                                href="{{ route('fakultas.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-building fs-4"></i></span>
                                <span class="menu-title">Fakultas</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/prodi*') ? 'active' : '' }}"
                                href="{{ route('prodi.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-graduation-cap fs-4"></i></span>
                                <span class="menu-title">Program Studi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/dosen*') ? 'active' : '' }}"
                                href="{{ route('dosen.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-chalkboard-user fs-4"></i></span>
                                <span class="menu-title">Dosen</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/kategori-cpl*') ? 'active' : '' }}"
                                href="{{ route('kategori-cpl.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-tags fs-4"></i></span>
                                <span class="menu-title">Kategori CPL</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/cpl*') ? 'active' : '' }}"
                                href="{{ route('cpl.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-book-open fs-4"></i></span>
                                <span class="menu-title">CPL Prodi</span>
                            </a>
                        </div>
                    @endif
                    @if ($role === 'admin')
                        <div class="menu-item pt-5">
                            <div class="menu-content pb-2">
                                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Master</span>
                            </div>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/fakultas*') ? 'active' : '' }}"
                                href="{{ route('fakultas.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-building fs-4"></i></span>
                                <span class="menu-title">Fakultas</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/prodi*') ? 'active' : '' }}"
                                href="{{ route('prodi.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-graduation-cap fs-4"></i></span>
                                <span class="menu-title">Program Studi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/dosen*') ? 'active' : '' }}"
                                href="{{ route('dosen.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-chalkboard-user fs-4"></i></span>
                                <span class="menu-title">Dosen</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/kurikulum*') ? 'active' : '' }}"
                                href="{{ route('kurikulum.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-calendar fs-4"></i></span>
                                <span class="menu-title">Kurikulum</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('admin/tahun-akademik*') ? 'active' : '' }}"
                                href="{{ route('tahun-akademik.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-calendar-days fs-4"></i></span>
                                <span class="menu-title">Tahun Akademik</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('admin/penilaian*') ? 'active' : '' }}"
                                href="{{ route('penilaian.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-chart-simple fs-4"></i></span>
                                <span class="menu-title">Sistem Penilaian</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/kategori-cpl*') ? 'active' : '' }}"
                                href="{{ route('kategori-cpl.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-tags fs-4"></i></span>
                                <span class="menu-title">Kategori CPL</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/cpl*') ? 'active' : '' }}"
                                href="{{ route('cpl.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-book-open fs-4"></i></span>
                                <span class="menu-title">CPL Prodi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/mahasiswa*') ? 'active' : '' }}"
                                href="{{ route('mahasiswa.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-user-graduate fs-4"></i></span>
                                <span class="menu-title">Mahasiswa</span>
                            </a>
                        </div>
                    @endif
                    @if (in_array($role, ['mahasiswa', 'bak_fakultas', 'admin']))
                        <div class="menu-item pt-5">
                            <div class="menu-content pb-2">
                                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Data Pendukung</span>
                            </div>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('mahasiswa/prestasi*') ? 'active' : '' }}"
                                href="{{ route('mahasiswa.prestasi.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-trophy fs-4"></i></span>
                                <span class="menu-title">Prestasi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('mahasiswa/organisasi*') ? 'active' : '' }}"
                                href="{{ route('mahasiswa.organisasi.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-users-rectangle fs-4"></i></span>
                                <span class="menu-title">Organisasi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('mahasiswa/sertifikat*') ? 'active' : '' }}"
                                href="{{ route('mahasiswa.sertifikat.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-file-signature fs-4"></i></span>
                                <span class="menu-title">Sertifikat</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('mahasiswa/magang*') ? 'active' : '' }}"
                                href="{{ route('mahasiswa.magang.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-briefcase fs-4"></i></span>
                                <span class="menu-title">Magang / KP</span>
                            </a>
                        </div>
                    @endif
                    @if ($role === 'mahasiswa')
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('mahasiswa/tugas-akhir*') ? 'active' : '' }}"
                                href="{{ route('mahasiswa.tugas_akhir.edit') }}">
                                <span class="menu-icon"><i class="fa-solid fa-graduation-cap fs-4"></i></span>
                                <span class="menu-title">Tugas Akhir</span>
                            </a>
                        </div>
                    @elseif (in_array($role, ['bak_fakultas', 'admin']))
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('bak-fakultas/tugas-akhir*') ? 'active' : '' }}"
                                href="{{ route('bak_fakultas.tugas_akhir.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-graduation-cap fs-4"></i></span>
                                <span class="menu-title">Tugas Akhir</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="app-sidebar-footer px-4 pb-4 mt-auto" id="kt_app_sidebar_footer">
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="btn btn-sm btn-light w-100 d-flex align-items-center justify-content-center gap-2">
            <i class="ki-duotone ki-exit-right fs-4">
                <span class="path1"></span><span class="path2"></span>
            </i>
            <span class="sidebar-minimize-hide fw-semibold">Logout</span>
        </a>
    </div>
</div>
