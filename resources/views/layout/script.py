import sys

with open(r'c:\laragon\www\skpi\resources\views\layout\sidebar.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

start_str = '<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="kt_app_sidebar_menu"'
end_str = '</div>\n            </div>\n        </div>\n    </div>\n\n    <div class="app-sidebar-footer'

start_idx = content.find(start_str)
end_idx = content.find(end_str)

new_menu = '''<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">
                    
                    <div class="menu-item">
                        <a class="menu-link {{ Request::is('dashboard') || Request::is('*/dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-gauge fs-4"></i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>

                    @if ( === 'mahasiswa')
                        <div class="menu-item pt-5">
                            <div class="menu-content pb-2">
                                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Data Pendukung</span>
                            </div>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('mahasiswa/prestasi*') ? 'active' : '' }}" href="{{ route('mahasiswa.prestasi.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-trophy fs-4"></i></span>
                                <span class="menu-title">Prestasi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('mahasiswa/organisasi*') ? 'active' : '' }}" href="{{ route('mahasiswa.organisasi.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-users-rectangle fs-4"></i></span>
                                <span class="menu-title">Organisasi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('mahasiswa/sertifikat*') ? 'active' : '' }}" href="{{ route('mahasiswa.sertifikat.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-file-signature fs-4"></i></span>
                                <span class="menu-title">Sertifikat</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('mahasiswa/magang*') ? 'active' : '' }}" href="{{ route('mahasiswa.magang.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-briefcase fs-4"></i></span>
                                <span class="menu-title">Magang / KP</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('mahasiswa/tugas-akhir*') ? 'active' : '' }}" href="{{ route('mahasiswa.tugas_akhir.edit') }}">
                                <span class="menu-icon"><i class="fa-solid fa-graduation-cap fs-4"></i></span>
                                <span class="menu-title">Tugas Akhir</span>
                            </a>
                        </div>
                    @endif

                    @if ( === 'bak_fakultas')
                        <div class="menu-item pt-5">
                            <div class="menu-content pb-2">
                                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Layanan Akademik</span>
                            </div>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('bak-fakultas*') ? 'active' : '' }}" href="{{ route('bak_fakultas.dashboard') }}">
                                <span class="menu-icon"><i class="fa-solid fa-list-check fs-4"></i></span>
                                <span class="menu-title">Antrian SKPI</span>
                            </a>
                        </div>
                        <div class="menu-item pt-5">
                            <div class="menu-content pb-2">
                                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Data Akademik</span>
                            </div>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/mahasiswa*') ? 'active' : '' }}" href="{{ route('mahasiswa.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-user-graduate fs-4"></i></span>
                                <span class="menu-title">Mahasiswa</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/fakultas*') ? 'active' : '' }}" href="{{ route('fakultas.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-building fs-4"></i></span>
                                <span class="menu-title">Fakultas</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/prodi*') ? 'active' : '' }}" href="{{ route('prodi.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-graduation-cap fs-4"></i></span>
                                <span class="menu-title">Prodi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/cpl*') ? 'active' : '' }}" href="{{ route('cpl.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-book-open fs-4"></i></span>
                                <span class="menu-title">CPL Prodi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/kurikulum*') ? 'active' : '' }}" href="{{ route('kurikulum.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-calendar fs-4"></i></span>
                                <span class="menu-title">Kurikulum</span>
                            </a>
                        </div>
                    @endif

                    @if ( === 'admin')
                        <div class="menu-item pt-5">
                            <div class="menu-content pb-2">
                                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Manajemen Sistem</span>
                            </div>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-user-gear fs-4"></i></span>
                                <span class="menu-title">Pengguna</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/fakultas*') ? 'active' : '' }}" href="{{ route('fakultas.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-building fs-4"></i></span>
                                <span class="menu-title">Fakultas</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/prodi*') ? 'active' : '' }}" href="{{ route('prodi.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-graduation-cap fs-4"></i></span>
                                <span class="menu-title">Prodi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('admin/kategori-cpl*') ? 'active' : '' }}" href="{{ route('kategori-cpl.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-tags fs-4"></i></span>
                                <span class="menu-title">Kategori CPL</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/mahasiswa*') ? 'active' : '' }}" href="{{ route('mahasiswa.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-user-graduate fs-4"></i></span>
                                <span class="menu-title">Mahasiswa</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/cpl*') ? 'active' : '' }}" href="{{ route('cpl.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-book-open fs-4"></i></span>
                                <span class="menu-title">CPL Prodi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('akademik/kurikulum*') ? 'active' : '' }}" href="{{ route('kurikulum.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-calendar fs-4"></i></span>
                                <span class="menu-title">Kurikulum</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Request::is('admin/penilaian*') ? 'active' : '' }}" href="{{ route('penilaian.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-chart-simple fs-4"></i></span>
                                <span class="menu-title">Sistem Penilaian</span>
                            </a>
                        </div>
                    @endif
'''

new_content = content[:start_idx] + new_menu + content[end_idx:]

with open(r'c:\laragon\www\skpi\resources\views\layout\sidebar.blade.php', 'w', encoding='utf-8') as f:
    f.write(new_content)
