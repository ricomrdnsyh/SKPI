@props(['steps'])

<div class="card border border-dashed border-dark mb-6">
    <div class="card-header border-0 pt-6 d-flex justify-content-between align-items-center flex-wrap gap-4">
        <h3 class="card-title align-items-start flex-column m-0">
            <span class="card-label fw-bolder fs-3 mb-1"><i class="ki-duotone ki-route fs-2 me-2 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> Pengajuan Cetak SKPI dan statusnya</span>
        </h3>
        
        @if(isset($pengajuan) && isset($statusClass))
            <div class="d-flex align-items-center gap-3 flex-wrap">
                @if ($pengajuan->status !== 'draft')
                    <a href="{{ route('bak_fakultas.skpi.print', $pengajuan->id_pengajuan) }}" target="_blank" class="btn btn-success btn-sm fw-bold">
                        <i class="ki-duotone ki-file-down fs-2"><span class="path1"></span><span class="path2"></span></i> Preview SKPI (PDF)
                    </a>
                @endif
                <span class="badge {{ $statusClass }} fs-6 fw-bolder px-4 py-2 text-uppercase">
                    Status: {{ $pengajuan->status }}
                </span>
            </div>
        @endif
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
                    <div class="border border-dashed border-{{ $stepColor }} bg-light-{{ $stepColor }} rounded p-5 h-100 hover-elevate-up transition-all d-flex flex-column">
                        <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-40px me-3">
                                <div class="symbol-label bg-{{ $themeColor }} {{ $circleTextColor }} fw-bolder fs-5 shadow-sm">
                                    {{ $stepNum }}
                                </div>
                            </div>
                            <div class="fs-6 fw-bolder text-{{ $themeColor }}">{{ $step['name'] }}
                            </div>
                        </div>
                        <div class="fs-8 text-gray-700 mb-5">{{ $step['desc'] }}</div>

                        <div class="d-flex justify-content-between align-items-center mt-auto pt-4 border-top border-{{ $themeColor }}">
                            <span class="badge {{ $badgeClass }} fs-8 px-3 py-2 fw-bolder text-uppercase">{{ $stepText }}</span>
                            @if ($step['date'])
                                <span class="text-muted fs-8 fw-bold"><i class="fas fa-clock me-1 text-{{ $themeColor }}"></i>{{ \Carbon\Carbon::parse($step['date'])->format('d/m/y') }}</span>
                            @endif
                        </div>
                    </div>
                    @if (!$loop->last)
                        <div class="position-absolute top-50 start-100 translate-middle d-none d-lg-flex align-items-center justify-content-center bg-white rounded-circle shadow" style="z-index: 5; width: 32px; height: 32px;">
                            <i class="fas fa-chevron-right fs-6 text-gray-500"></i>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>