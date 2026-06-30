@extends('layout.main')

@section('title', 'Dashboard Mahasiswa')

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
                                <div class="symbol symbol-50px me-3">
                                    <div class="symbol-label bg-white text-primary fs-2 fw-bolder">{{ substr($mahasiswa->nama_lengkap, 0, 1) }}</div>
                                </div>
                                <div class="d-flex flex-column">
                                    <h2 class="text-white fw-bold fs-2 mb-2">Halo, {{ $mahasiswa->nama_lengkap }}</h2>
                                    <div class="text-white opacity-75 fs-6 fw-semibold">
                                        <span class="fw-bolder text-white">{{ $mahasiswa->nim }}</span>
                                        &middot; {{ $mahasiswa->programStudi->nama_prodi }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if($pengajuan)
                                    @php
                                        $statusClass = $pengajuan->status === 'dicetak' ? 'success' : ($pengajuan->status === 'ditolak' ? 'danger' : ($pengajuan->status === 'draft' ? 'warning' : 'primary'));
                                        $statusText = $pengajuan->status === 'dicetak' ? 'SKPI Telah Terbit' : ($pengajuan->status === 'ditolak' ? 'Pengajuan Ditolak' : ($pengajuan->status === 'draft' ? 'Perlu Revisi' : 'Sedang Diproses'));
                                    @endphp
                                    <span class="badge badge-light-{{ $statusClass }} fw-bold px-4 py-3 text-uppercase">
                                        {{ $statusText }}
                                    </span>
                                @else
                                    <span class="badge badge-light fw-bold px-4 py-3 text-uppercase">Belum Mengajukan</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-5 g-xl-8 mb-8">
                    {{-- Status Persetujuan Modul --}}
                    <div class="col-xl-12">
                        <div class="card shadow-sm border border-dashed border-dark rounded">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-3 mb-1"><i class="ki-duotone ki-element-11 fs-2 text-primary me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> Status Persetujuan Modul</span>
                                </h3>
                            </div>
                            <div class="card-body pt-5">
                                <div class="row g-3">
                                    @php
                                        $modules = [
                                            ['label' => 'Prestasi', 'icon' => 'ki-medal-star', 'color' => 'warning', 'approved' => $mahasiswa->allPrestasiApproved(), 'hasItems' => $prestasi->count() > 0, 'items' => $prestasi],
                                            ['label' => 'Organisasi', 'icon' => 'ki-profile-user', 'color' => 'info', 'approved' => $mahasiswa->allOrganisasiApproved(), 'hasItems' => $organisasi->count() > 0, 'items' => $organisasi],
                                            ['label' => 'Sertifikat', 'icon' => 'ki-document', 'color' => 'primary', 'approved' => $mahasiswa->allSertifikatApproved(), 'hasItems' => $sertifikat->count() > 0, 'items' => $sertifikat],
                                            ['label' => 'Magang / KP', 'icon' => 'ki-briefcase', 'color' => 'success', 'approved' => $mahasiswa->allMagangApproved(), 'hasItems' => $magang->count() > 0, 'items' => $magang],
                                            ['label' => 'Tugas Akhir', 'icon' => 'ki-book-open', 'color' => 'dark', 'approved' => $mahasiswa->tugasAkhirApproved(), 'hasItems' => (bool)$mahasiswa->tugasAkhir, 'items' => $mahasiswa->tugasAkhir ? collect([$mahasiswa->tugasAkhir]) : collect()],
                                        ];
                                    @endphp
                                    @foreach($modules as $mod)
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
                                        <div class="col">
                                            <div class="border border-dashed border-gray-300 rounded px-5 py-4 text-center hoverable">
                                                <i class="ki-duotone {{ $mod['icon'] }} fs-2x text-{{ $mod['color'] }} mb-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                <div class="fs-6 fw-bold text-gray-900 mb-1">{{ $mod['label'] }}</div>
                                                <span class="badge badge-light-{{ $statusColor }} fw-bolder">{{ $statusText }}</span>
                                                <div class="fs-7 text-muted mt-2">{{ $mod['items']->count() }} item</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Progress timeline --}}
                <div class="card shadow-sm border border-dashed border-dark rounded mb-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1"><i class="ki-duotone ki-route fs-2 text-primary me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> Progress Penerbitan SKPI</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="row g-3">
                            @foreach($steps as $stepNum => $step)
                                @php
                                    $stepColor = $step['status'] === 'sudah' ? 'success' : ($step['status'] === 'ditolak' ? 'danger' : ($step['status'] === 'revisi' ? 'warning' : 'secondary'));
                                    $stepText = $step['status'] === 'sudah' ? 'Selesai' : ($step['status'] === 'ditolak' ? 'Ditolak' : ($step['status'] === 'revisi' ? 'Revisi' : 'Menunggu'));
                                @endphp
                                <div class="col-md-2 col-sm-6">
                                    <div class="border border-dashed border-{{ $stepColor }} bg-light-{{ $stepColor }} rounded px-4 py-3 h-100 relative">
                                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                                            <span class="badge badge-{{ $stepColor }} fw-bolder">{{ $stepNum }}</span>
                                        </div>
                                        <div class="fs-7 fw-bolder text-gray-900 mt-3 pe-5">{{ $step['name'] }}</div>
                                        <div class="fs-8 text-muted mt-1">{{ $step['desc'] }}</div>
                                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top border-{{ $stepColor }}">
                                            <span class="badge badge-light-{{ $stepColor }} fs-9">{{ $stepText }}</span>
                                            @if($step['date'])
                                                <span class="text-muted fs-9 fw-semibold">{{ \Carbon\Carbon::parse($step['date'])->format('d/m/y') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row g-5 g-xl-8">
                    <div class="col-xl-8">
                        {{-- Kelengkapan Berkas --}}
                        <div class="card shadow-sm border border-dashed border-dark rounded mb-8">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-3 mb-1"><i class="ki-duotone ki-folder fs-2 text-primary me-2"><span class="path1"></span><span class="path2"></span></i> Kelengkapan Berkas</span>
                                </h3>
                            </div>
                            <div class="card-body pt-5">
                                <div class="row g-3">
                                    @php
                                        $berkas = [
                                            ['route' => 'mahasiswa.prestasi.index', 'label' => 'Prestasi', 'icon' => 'ki-medal-star', 'color' => 'warning', 'count' => $prestasi->count(), 'approved' => $prestasi->where('status', 'approved')->count()],
                                            ['route' => 'mahasiswa.organisasi.index', 'label' => 'Organisasi', 'icon' => 'ki-profile-user', 'color' => 'info', 'count' => $organisasi->count(), 'approved' => $organisasi->where('status', 'approved')->count()],
                                            ['route' => 'mahasiswa.sertifikat.index', 'label' => 'Sertifikat', 'icon' => 'ki-document', 'color' => 'primary', 'count' => $sertifikat->count(), 'approved' => $sertifikat->where('status', 'approved')->count()],
                                            ['route' => 'mahasiswa.magang.index', 'label' => 'Magang / KP', 'icon' => 'ki-briefcase', 'color' => 'success', 'count' => $magang->count(), 'approved' => $magang->where('status', 'approved')->count()],
                                        ];
                                    @endphp
                                    @foreach($berkas as $b)
                                    <div class="col-md-6">
                                        <a href="{{ route($b['route']) }}" class="border border-dashed border-gray-300 rounded px-5 py-4 d-flex align-items-center justify-content-between hoverable h-100">
                                            <div>
                                                <div class="text-muted fw-bold fs-7 text-uppercase mb-1">{{ $b['label'] }}</div>
                                                <div class="text-gray-900 fw-bolder fs-2">{{ $b['count'] }}</div>
                                                @if($b['approved'] > 0)
                                                    <div class="text-success fs-8 fw-bolder">{{ $b['approved'] }} disetujui</div>
                                                @elseif($b['count'] > 0)
                                                    <div class="text-warning fs-8 fw-bolder">Menunggu verifikasi</div>
                                                @else
                                                    <div class="text-muted fs-8 fw-semibold">Belum diisi</div>
                                                @endif
                                            </div>
                                            <div class="symbol symbol-50px symbol-circle">
                                                <div class="symbol-label bg-light-{{ $b['color'] }}">
                                                    <i class="ki-duotone {{ $b['icon'] }} fs-2x text-{{ $b['color'] }}"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Tugas Akhir --}}
                                <div class="mt-5 border border-dashed border-success bg-light-success rounded px-5 py-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="symbol symbol-40px symbol-circle">
                                                <div class="symbol-label bg-success">
                                                    <i class="ki-duotone ki-book-open fs-2 text-white"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-success fw-bold fs-8 text-uppercase mb-1">Tugas Akhir</div>
                                                @if($mahasiswa->tugasAkhir)
                                                    @php
                                                        $taStatus = $mahasiswa->tugasAkhir->status;
                                                        $badgeColor = $taStatus === 'approved' ? 'success' : ($taStatus === 'rejected' ? 'danger' : 'warning');
                                                    @endphp
                                                    <span class="badge badge-{{ $badgeColor }}">{{ $taStatus ?? 'pending' }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $taRaw = $mahasiswa->tugasAkhir;
                                            $isRejectedTa = $taRaw && $taRaw->status === 'rejected';
                                            $isLockedTa = !$isRejectedTa && $pengajuan && in_array($pengajuan->status, ['diajukan', 'verifikasi', 'dicetak']);
                                            $isApprovedTa = $taRaw && $taRaw->status === 'approved';
                                            $readonlyTa = $isLockedTa || $isApprovedTa;
                                            $canEditTa = !$readonlyTa;
                                        @endphp
                                        <a href="{{ route('mahasiswa.tugas_akhir.edit') }}" class="btn btn-sm btn-light-{{ $canEditTa ? 'primary' : 'secondary' }}">
                                            <i class="ki-duotone ki-{{ $canEditTa ? 'pencil' : 'magnifier' }} fs-3"><span class="path1"></span><span class="path2"></span></i>
                                            {{ $canEditTa ? 'Ubah' : 'Detail' }}
                                        </a>
                                    </div>
                                    @if($mahasiswa->tugasAkhir)
                                        <div class="fw-bolder text-gray-900 fs-6 mt-3">"{{ $mahasiswa->tugasAkhir->judul }}"</div>
                                        <div class="fs-8 text-muted mt-1">
                                            Pembimbing:
                                            @foreach($mahasiswa->tugasAkhir->pembimbingTugasAkhir as $pta)
                                                <span class="fw-bold text-gray-700">{{ $pta->nama_dosen }}</span>{{ !$loop->last ? ' & ' : '' }}
                                            @endforeach
                                        </div>
                                        @if($mahasiswa->tugasAkhir->keterangan)
                                            <div class="mt-3 p-3 bg-light-danger text-danger fs-8 fw-bold rounded border border-danger">
                                                <i class="ki-duotone ki-information fs-5 text-danger me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> {{ $mahasiswa->tugasAkhir->keterangan }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="mt-3 text-muted fs-8">Belum ada data tugas akhir.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        {{-- Status Pengajuan SKPI --}}
                        <div class="card shadow-sm border border-dashed border-dark rounded">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-3 mb-1"><i class="ki-duotone ki-send fs-2 text-primary me-2"><span class="path1"></span><span class="path2"></span></i> Status Pengajuan</span>
                                </h3>
                            </div>
                            <div class="card-body pt-5">
                                @if($pengajuan)
                                    <div class="mb-5">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="fw-bolder text-gray-800">Status Saat Ini</div>
                                            @php
                                                $pStatus = $pengajuan->status;
                                                $pColor = $pStatus === 'dicetak' ? 'success' : ($pStatus === 'ditolak' ? 'danger' : ($pStatus === 'draft' ? 'warning' : 'primary'));
                                            @endphp
                                            <span class="badge badge-light-{{ $pColor }} fw-bolder px-3 py-2 text-uppercase">{{ $pStatus }}</span>
                                        </div>
                                        @if($pengajuan->keterangan)
                                            <div class="bg-light-danger border border-danger border-dashed rounded p-4 mt-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="ki-duotone ki-information-5 fs-3 text-danger me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                    <span class="fw-bolder text-danger fs-7">Catatan / Revisi</span>
                                                </div>
                                                <div class="text-danger fs-8">{{ $pengajuan->keterangan }}</div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="border-top border-gray-200 pt-5 mt-5">
                                        <a href="{{ route('mahasiswa.pengajuan.show') }}" class="btn btn-primary w-100">
                                            <i class="ki-duotone ki-magnifier fs-3"><span class="path1"></span><span class="path2"></span></i> Lihat Detail Pengajuan
                                        </a>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="ki-duotone ki-file-deleted fs-5x text-muted mb-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="fs-6 fw-bold text-gray-800 mb-2">Belum Mengajukan SKPI</div>
                                        <div class="fs-8 text-muted mb-5">Anda belum membuat permohonan penerbitan SKPI. Pastikan semua berkas telah disetujui.</div>
                                        
                                        @php
                                            $canAjukan = $mahasiswa->allPrestasiApproved() && 
                                                         $mahasiswa->allOrganisasiApproved() && 
                                                         $mahasiswa->allSertifikatApproved() && 
                                                         $mahasiswa->allMagangApproved() && 
                                                         $mahasiswa->tugasAkhirApproved();
                                        @endphp

                                        @if($canAjukan)
                                            <form action="{{ route('mahasiswa.pengajuan.store') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="ki-duotone ki-send fs-3"><span class="path1"></span><span class="path2"></span></i> Ajukan SKPI Sekarang
                                                </button>
                                            </form>
                                        @else
                                            <div class="alert alert-dismissible bg-light-warning border border-warning border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                                                <i class="ki-duotone ki-shield-cross fs-2hx text-warning me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                                    <h5 class="mb-1 text-warning">Belum Memenuhi Syarat</h5>
                                                    <span class="fs-8 text-warning">Pastikan status semua berkas Anda (Prestasi, Organisasi, Sertifikat, Magang, Tugas Akhir) sudah berstatus <span class="fw-bolder">"Disetujui"</span> sebelum dapat mengajukan SKPI.</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-light-success w-100 disabled" disabled>
                                                <i class="ki-duotone ki-send fs-3"><span class="path1"></span><span class="path2"></span></i> Ajukan SKPI Sekarang
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
