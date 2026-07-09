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
        $modStatus = function ($items) {
            if ($items->where('status', 'rejected')->isNotEmpty()) {
                return 'ditolak';
            }
            if ($items->where('status', 'pending')->isNotEmpty()) {
                return 'diproses';
            }
            if ($items->where('status', 'approved')->count() === $items->count() && $items->count() > 0) {
                return 'approved';
            }
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
    <div class="d-flex flex-column flex-column-fluid">
        <div class="app-content flex-column-fluid mt-7">
            <div class="app-container container-fluid">
                <div class="card mb-6 border border-dashed border-primary">
                    <div class="card-body pt-9 pb-0">
                        <div class="d-flex flex-wrap flex-sm-nowrap">
                            <div class="me-7 mb-4">
                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                    <div class="symbol-label bg-light-primary text-primary fs-2hx fw-bolder">
                                        {{ substr($mahasiswa->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div
                                        class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <span
                                                class="text-gray-900 fs-2 fw-bolder me-1">{{ $mahasiswa->nama_lengkap }}</span>
                                            <span
                                                class="badge {{ $statusClass }} ms-2">{{ strtoupper($pengajuan->status) }}</span>
                                        </div>
                                        <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                            <span class="d-flex align-items-center text-gray-500 me-5 mb-2">
                                                <i class="ki-duotone ki-profile-circle fs-4 me-1"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span></i> {{ $mahasiswa->nim }}
                                            </span>
                                            <span class="d-flex align-items-center text-gray-500 me-5 mb-2">
                                                <i class="ki-duotone ki-bank fs-4 me-1"><span class="path1"></span><span
                                                        class="path2"></span></i> Fakultas
                                                {{ $mahasiswa->programStudi->fakultas->nama_fakultas ?? '-' }}

                                            </span>
                                            <span class="d-flex align-items-center text-gray-500 mb-2">
                                                <i class="ki-duotone ki-book-open fs-4 me-1"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span><span class="path4"></span></i>
                                                {{ $mahasiswa->programStudi->nama_prodi }}
                                                ({{ $mahasiswa->programStudi->jenjang }})
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap flex-stack mt-2">
                                    <div class="d-flex flex-column flex-grow-1 pe-8">
                                        <div class="d-flex flex-wrap">
                                            <div
                                                class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-2 fw-bolder">{{ $mahasiswa->ipk ?? '-' }}</div>
                                                </div>
                                                <div class="fw-bold fs-6 text-gray-500">IPK</div>
                                            </div>
                                            <div
                                                class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-2 fw-bolder">{{ $mahasiswa->sks_lulus ?? '-' }}</div>
                                                </div>
                                                <div class="fw-bold fs-6 text-gray-500">SKS Lulus</div>
                                            </div>
                                            <div
                                                class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-2 fw-bolder">{{ $mahasiswa->predikat_kelulusan ?? '-' }}
                                                    </div>
                                                </div>
                                                <div class="fw-bold fs-6 text-gray-500">Predikat</div>
                                            </div>
                                            <div
                                                class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3 bg-light">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bolder text-gray-800">
                                                        {{ $mahasiswa->skpi->nim_ijazah ?? 'Belum ada' }}</div>
                                                </div>
                                                <div class="fw-bold fs-6 text-gray-500">NIM Ijazah</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder mt-5">
                            <li class="nav-item mt-2">
                                <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab"
                                    href="#tab_validasi">Validasi Berkas</a>
                            </li>
                            <li class="nav-item mt-2">
                                <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab"
                                    href="#tab_timeline">Timeline & Riwayat</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab_validasi" role="tabpanel">
                        @include('partials.overall_progress', [
                            'steps' => $steps,
                            'pengajuan' => $pengajuan,
                            'statusClass' => $statusClass,
                        ])
                        
                        @include('bak_fakultas.verifikasi._action_cards')

                        <div class="card border border-dashed border-dark mb-6">
                            <div class="card-header border-0 pt-6">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-3 mb-1 d-flex align-items-center"><i
                                            class="ki-duotone ki-shield-tick fs-1 me-2 text-primary"><span
                                                class="path1"></span><span class="path2"></span></i> Status Persetujuan
                                        Modul</span>
                                </h3>
                            </div>
                            <div class="card-body pt-5 pb-0">
                                <div class="row g-5">
                                    @foreach ($mods as $m)
                                        @php
                                            $c = match ($m['status']) {
                                                'approved' => 'bg-light-success text-success border-success',
                                                'ditolak' => 'bg-light-danger text-danger border-danger',
                                                'belum' => 'bg-light text-gray-500 border-gray-200',
                                                default => 'bg-light-warning text-warning border-warning',
                                            };
                                            $i = match ($m['status']) {
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
                                                    <i
                                                        class="ki-duotone {{ $i }} fs-4 me-1 {{ str_replace('bg-light-', 'text-', explode(' ', $c)[0]) }}"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                    {{ $m['status'] }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="separator separator-dashed my-6"></div>
                            @include('bak_fakultas.verifikasi._validation_data')
                            @if (in_array(Auth::user()->role, ['bak_fakultas', 'admin']) && $pengajuan->status === 'diajukan')
                                @include('bak_fakultas.verifikasi._checklist_form')
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab_timeline" role="tabpanel">
                        @if ($history->isNotEmpty())
                            <div class="card border border-dashed border-dark">
                                @include('bak_fakultas.verifikasi._timeline')
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function confirmReject(formId, inputId) {
            Swal.fire({
                title: 'Tolak Berkas',
                text: 'Tuliskan alasan penolakan berkas ini:',
                input: 'text',
                inputPlaceholder: 'Masukkan alasan tolak...',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Tolak Berkas',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Alasan penolakan tidak boleh kosong!');
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(inputId).value = result.value;
                    const form = document.getElementById(formId);
                    const btn = form.querySelector('button');
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                    btn.disabled = true;
                    form.submit();
                }
            });
        }

        function confirmSetujui() {
            @if (!empty($hasPendingItems))
                @php
                    $pendingModLabels = collect($mods)->where('status', 'diproses')->pluck('label')->toArray();
                    $pendingModsString = !empty($pendingModLabels) ? implode(', ', $pendingModLabels) : 'berkas pendukung atau Tugas Akhir';
                @endphp
                Swal.fire({
                    title: 'Verifikasi Belum Selesai',
                    html: 'Selesaikan verifikasi (setujui/tolak) pada bagian <b>{{ $pendingModsString }}</b> terlebih dahulu.',
                    icon: 'warning',
                    confirmButtonText: 'Ok, got it!',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            @endif
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
