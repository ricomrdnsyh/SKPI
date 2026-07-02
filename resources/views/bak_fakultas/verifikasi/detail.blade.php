@extends('layout.main')

@section('title', 'Detail Verifikasi SKPI')

@section('content')
    @php
        $backRoute = route('bak_fakultas.dashboard');
        $statusColors = [
            'dicetak' => 'badge-light-success',
            'verifikasi' => 'badge-light-primary',
            'diajukan' => 'badge-light-warning',
            'ditolak' => 'badge-light-danger',
            'draft' => 'badge-light-secondary',
        ];
        $statusClass = $statusColors[$pengajuan->status] ?? 'badge-light-secondary';
        $steps = $mahasiswa->getSkpiProgressSteps($pengajuan);
        $role = Auth::user()->role;
    @endphp

    <div class="d-flex flex-column flex-column-fluid">
        <div class="app-content flex-column-fluid mt-7">
            <div class="app-container container-fluid">
                
                {{-- Header --}}
                <div class="mb-5 d-none">
                    {{-- Intentionally empty or hidden header if needed later --}}
                </div>

                {{-- Progress Timeline --}}
                <div class="mb-6">
                    @include('partials.overall_progress', [
                        'steps' => $steps,
                        'pengajuan' => $pengajuan,
                        'statusClass' => $statusClass
                    ])
                </div>

                {{-- Action cards --}}
                @if (Auth::user()->role === 'bak_fakultas')
                    <div class="mb-6">
                        @include('bak_fakultas.verifikasi._action_cards')
                    </div>
                @endif

                {{-- Module status overview --}}
                <div class="card border border-dashed border-dark mb-6">
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1"><i class="ki-duotone ki-check-square fs-2 me-2 text-primary"><span class="path1"></span><span class="path2"></span></i> Status Persetujuan Modul</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        @if (!empty($hasPendingItems) && $pengajuan->status === 'diajukan' && !$pengajuan->diverifikasi_oleh)
                            <div class="alert bg-light-warning border border-warning border-dashed d-flex flex-column flex-sm-row p-5 mb-7">
                                <i class="ki-duotone ki-information-5 fs-2hx text-warning me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                    <h5 class="mb-1 text-warning">Verifikasi Item Belum Selesai</h5>
                                    <span>Anda harus memverifikasi (approve/reject) semua item Prestasi, Organisasi, Sertifikat, Magang, dan Tugas Akhir terlebih dahulu sebelum dapat menyetujui pengajuan cetak SKPI.</span>
                                </div>
                            </div>
                        @endif
                        <div class="row g-5">
                            @php
                                $modStatus = function($items) {
                                    if ($items->where('status', 'rejected')->isNotEmpty()) return 'ditolak';
                                    if ($items->where('status', 'pending')->isNotEmpty()) return 'diproses';
                                    if ($items->where('status', 'approved')->count() === $items->count() && $items->count() > 0) return 'approved';
                                    return 'belum';
                                };
                                $taMod = $mahasiswa->tugasAkhir ? collect([$mahasiswa->tugasAkhir]) : collect();
                                $mods = [
                                    ['label' => 'Prestasi', 'status' => $modStatus($prestasi)],
                                    ['label' => 'Organisasi', 'status' => $modStatus($organisasi)],
                                    ['label' => 'Sertifikat', 'status' => $modStatus($sertifikat)],
                                    ['label' => 'Magang', 'status' => $modStatus($magang)],
                                    ['label' => 'Tugas Akhir', 'status' => $modStatus($taMod)],
                                ];
                            @endphp
                            @foreach($mods as $m)
                                @php
                                    $c = match($m['status']) {
                                        'approved' => 'bg-light-success text-success border-success',
                                        'ditolak' => 'bg-light-danger text-danger border-danger',
                                        'belum' => 'bg-light text-gray-500 border-gray-200',
                                        default => 'bg-light-warning text-warning border-warning',
                                    };
                                    $i = match($m['status']) {
                                        'approved' => 'ki-check-circle',
                                        'ditolak' => 'ki-cross-circle',
                                        'belum' => 'ki-information-5',
                                        default => 'ki-time',
                                    };
                                @endphp
                                <div class="col-6 col-md">
                                    <div class="border border-dashed rounded p-4 text-center {{ $c }}">
                                        <div class="fs-6 fw-bolder mb-1 text-gray-800">{{ $m['label'] }}</div>
                                        <div class="fs-7 fw-bold text-uppercase mt-2">
                                            <i class="ki-duotone {{ $i }} fs-4 me-1 {{ str_replace('bg-light-', 'text-', explode(' ', $c)[0]) }}"><span class="path1"></span><span class="path2"></span></i>
                                            {{ $m['status'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Academic Data --}}
                <div class="mb-6">
                    @include('bak_fakultas.verifikasi._prodi_academic_data')
                </div>

                {{-- Main content: Merged Profile & Validation --}}
                <div class="row g-6 mb-6">
                    <div class="col-lg-5 col-xl-4">
                        <div class="card border border-dashed border-dark mb-6">
                            @include('bak_fakultas.verifikasi._identity_card')
                        </div>
                        
                        {{-- Timeline --}}
                        @if ($history->isNotEmpty())
                            <div class="card border border-dashed border-dark">
                                @include('bak_fakultas.verifikasi._timeline')
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-7 col-xl-8">
                        <div class="card border border-dashed border-dark h-100">
                            @include('bak_fakultas.verifikasi._validation_data')
                            
                            {{-- Checklist form for BAK --}}
                            @if (Auth::user()->role === 'bak_fakultas' && $pengajuan->status === 'diajukan')
                                @include('bak_fakultas.verifikasi._checklist_form')
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    function confirmSetujui() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menyetujui pengajuan SKPI ini untuk dilanjutkan ke proses pencetakan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setujui SKPI',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('formSetujui');
                const btn = form.querySelector('button[type="button"]');
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
                btn.disabled = true;
                form.submit();
            }
        });
    }
</script>
@endsection