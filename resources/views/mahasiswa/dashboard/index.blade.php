@extends('layout.main')
@section('title', 'Dashboard Mahasiswa')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content flex-column-fluid mt-7">
                <div id="kt_app_content_container" class="app-container container-fluid">
                    <div class="card bg-light-primary mb-8" style="background: linear-gradient(135deg, rgba(235, 244, 255, 0.8) 0%, rgba(225, 238, 255, 0.4) 100%); border: 1px solid rgba(0, 158, 247, 0.1); box-shadow: 0 10px 30px rgba(0, 158, 247, 0.05); backdrop-filter: blur(10px); transition: transform 0.3s ease;">
                        <div class="card-body p-8">
                            <div class="d-flex align-items-start align-items-sm-center gap-6 w-100">
                                <div class="symbol symbol-65px flex-shrink-0" style="filter: drop-shadow(0 5px 15px rgba(0, 158, 247, 0.3));">
                                    <div class="symbol-label bg-primary text-white fs-1 fw-bolder rounded-circle">
                                        {{ substr($mahasiswa->nama_lengkap, 0, 1) }}</div>
                                </div>
                                <div
                                    class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center w-100 gap-4">
                                    <div class="d-flex flex-column">
                                        <h2 class="text-gray-900 fw-bold fs-1 mb-2" style="letter-spacing: -0.5px;">Halo, <span style="background: linear-gradient(135deg, #009ef7 0%, #3250ef 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $mahasiswa->nama_lengkap }}</span>
                                        </h2>
                                        <div
                                            class="text-gray-600 fs-6 fw-semibold d-flex flex-wrap align-items-center mt-1 gap-4">
                                            <div class="d-flex align-items-center bg-white px-3 py-1 rounded shadow-sm">
                                                <i class="fas fa-id-card text-primary me-2"></i>
                                                <span>{{ $mahasiswa->nim }}</span>
                                            </div>
                                            <div class="d-flex align-items-center bg-white px-3 py-1 rounded shadow-sm">
                                                <i class="fas fa-graduation-cap text-primary me-2"></i>
                                                <span>{{ $mahasiswa->programStudi->nama_prodi }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0 flex-shrink-0" style="animation: pulse 2s infinite;">
                                        <style>
                                            @keyframes pulse {
                                                0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(0, 158, 247, 0.4); }
                                                70% { transform: scale(1.02); box-shadow: 0 0 0 10px rgba(0, 158, 247, 0); }
                                                100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(0, 158, 247, 0); }
                                            }
                                        </style>
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
                                                        ? 'SKPI Telah Terbit'
                                                        : ($pengajuan->status === 'ditolak'
                                                            ? 'Pengajuan Ditolak'
                                                            : ($pengajuan->status === 'draft'
                                                                ? 'Perlu Revisi'
                                                                : 'Sedang Diproses'));
                                            @endphp
                                            <span class="badge badge-{{ $statusClass }} fw-bold px-5 py-4 fs-6 rounded-pill text-uppercase shadow-sm border border-{{ $statusClass }}">
                                                {{ $statusText }}
                                            </span>
                                        @else
                                            <span
                                                class="badge badge-warning text-white fw-bold px-5 py-4 fs-6 rounded-pill text-uppercase shadow-sm">Belum
                                                Mengajukan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border border-dashed border-dark rounded mb-8">
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
                                        // Logika warna dasar card berdasarkan status (abu-abu jika menunggu)
                                        $stepColor =
                                            $step['status'] === 'sudah'
                                                ? 'success'
                                                : ($step['status'] === 'ditolak'
                                                    ? 'danger'
                                                    : ($step['status'] === 'revisi'
                                                        ? 'warning'
                                                        : 'secondary'));
                                        // Variasi warna cerah untuk teks, angka, dan badge jika masih 'Menunggu'
                                        $themeColors = [
                                            1 => 'primary',
                                            2 => 'info',
                                            3 => 'primary',
                                            4 => 'info',
                                            5 => 'primary',
                                        ];
                                        // Gunakan warna status asli jika sudah selesai/ditolak/revisi,
                                        // tapi gunakan warna tema cerah jika masih 'Menunggu' (secondary)
                                        $themeColor =
                                            $stepColor === 'secondary'
                                                ? $themeColors[$stepNum] ?? 'primary'
                                                : $stepColor;
                                        // Logika teks dan badge status
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
                                        // Khusus warna teks di dalam lingkaran agar jelas saat background warning (kuning)
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
                                            <div class="position-absolute top-50 start-100 translate-middle d-none d-lg-flex align-items-center justify-content-center bg-white rounded-circle shadow"
                                                style="z-index: 5; width: 32px; height: 32px;">
                                                <i class="fas fa-chevron-right fs-6 text-gray-500"></i>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row g-5 g-xl-8 mb-8">
                        <div class="col-xl-12">
                            <div class="card border border-dashed border-dark rounded">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder fs-3 mb-1"><i
                                                class="ki-duotone ki-element-11 fs-2 text-primary me-2"><span
                                                    class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span><span class="path4"></span></i> Status
                                            Persetujuan Modul</span>
                                    </h3>
                                </div>
                                <div class="card-body pt-5">
                                    <div class="row g-3">
                                        @php
                                            $modules = [
                                                [
                                                    'label' => 'Prestasi',
                                                    'icon' => 'ki-medal-star',
                                                    'color' => 'warning',
                                                    'approved' => $mahasiswa->allPrestasiApproved(),
                                                    'hasItems' => $prestasi->count() > 0,
                                                    'items' => $prestasi,
                                                ],
                                                [
                                                    'label' => 'Organisasi',
                                                    'icon' => 'ki-profile-user',
                                                    'color' => 'info',
                                                    'approved' => $mahasiswa->allOrganisasiApproved(),
                                                    'hasItems' => $organisasi->count() > 0,
                                                    'items' => $organisasi,
                                                ],
                                                [
                                                    'label' => 'Sertifikat',
                                                    'icon' => 'ki-document',
                                                    'color' => 'primary',
                                                    'approved' => $mahasiswa->allSertifikatApproved(),
                                                    'hasItems' => $sertifikat->count() > 0,
                                                    'items' => $sertifikat,
                                                ],
                                                [
                                                    'label' => 'Magang / KP',
                                                    'icon' => 'ki-briefcase',
                                                    'color' => 'success',
                                                    'approved' => $mahasiswa->allMagangApproved(),
                                                    'hasItems' => $magang->count() > 0,
                                                    'items' => $magang,
                                                ],
                                                [
                                                    'label' => 'Tugas Akhir',
                                                    'icon' => 'ki-book-open',
                                                    'color' => 'dark',
                                                    'approved' => $mahasiswa->tugasAkhirApproved(),
                                                    'hasItems' => (bool) $mahasiswa->tugasAkhir,
                                                    'items' => $mahasiswa->tugasAkhir
                                                        ? collect([$mahasiswa->tugasAkhir])
                                                        : collect(),
                                                ],
                                            ];
                                        @endphp
                                        @foreach ($modules as $mod)
                                            @php
                                                $allApproved = $mod['approved'];
                                                $anyRejected = $mod['items']->where('status', 'rejected')->isNotEmpty();
                                                $noItems = !$mod['hasItems'];
                                                if ($noItems) {
                                                    $statusColor = 'secondary';
                                                    $statusText = 'Belum Diisi';
                                                } elseif ($allApproved) {
                                                    $statusColor = 'success';
                                                    $statusText = 'Disetujui';
                                                } elseif ($anyRejected) {
                                                    $statusColor = 'danger';
                                                    $statusText = 'Ditolak';
                                                } else {
                                                    $statusColor = 'warning';
                                                    $statusText = 'Diproses';
                                                }
                                            @endphp
                                            <div class="col-12 col-sm-6 col-md-4 col-xl mb-3 mb-xl-0">
                                                <div
                                                    class="border border-dashed border-gray-300 rounded px-5 py-4 text-center bg-white hover-elevate-up transition-all cursor-pointer">
                                                    <i
                                                        class="ki-duotone {{ $mod['icon'] }} fs-2x text-{{ $mod['color'] }} mb-2"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span class="path4"></span></i>
                                                    <div class="fs-6 fw-bold text-gray-900 mb-1">{{ $mod['label'] }}</div>
                                                    <span
                                                        class="badge badge-light-{{ $statusColor }} fw-bolder">{{ $statusText }}</span>
                                                    <div class="fs-7 text-muted mt-2">{{ $mod['items']->count() }} item
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-5 g-xl-8">
                        <div class="col-xl-8">
                            <div class="card border border-dashed border-dark rounded h-100 mb-8 mb-xl-0">
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
                                                    class="border border-dashed border-gray-300 rounded px-5 py-4 d-flex align-items-center justify-content-between bg-white hover-elevate-up transition-all h-100">
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
                                                                        class="path2"></span><span
                                                                        class="path3"></span></i>
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
                            <div class="card border border-dashed border-dark rounded h-100">
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
                                                    <form action="{{ route('mahasiswa.pengajuan.submit') }}"
                                                        method="POST"
                                                        onsubmit="const b=this.querySelector('button');b.setAttribute('data-kt-indicator','on');b.disabled=true;">
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
                                                    <form action="{{ route('mahasiswa.pengajuan.submit') }}"
                                                        method="POST"
                                                        onsubmit="const b=this.querySelector('button');b.setAttribute('data-kt-indicator','on');b.disabled=true;">
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
@endsection
