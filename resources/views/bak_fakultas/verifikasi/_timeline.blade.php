<div class="card-header border-0 pt-6">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1"><i class="ki-duotone ki-time fs-2 me-2 text-primary"><span class="path1"></span><span class="path2"></span></i> Riwayat Aktivitas SKPI</span>
        </h3>
    </div>
    <div class="card-body pt-5">
        <div class="timeline">
            @foreach ($history as $h)
                @php
                    $waktu = \Carbon\Carbon::parse($h['waktu'])->timezone('Asia/Jakarta');
                    $statusMapping = match(true) {
                        in_array($h['status'], ['approved', 'sudah', 'lulus', 'dicetak']) => ['color' => 'success', 'icon' => 'ki-check-circle'],
                        in_array($h['status'], ['ditolak', 'rejected']) => ['color' => 'danger', 'icon' => 'ki-cross-circle'],
                        in_array($h['status'], ['submitted', 'diajukan']) => ['color' => 'primary', 'icon' => 'ki-send'],
                        default => ['color' => 'warning', 'icon' => 'ki-time'],
                    };
                    $color = $statusMapping['color'];
                    $icon = $statusMapping['icon'];
                @endphp
                <div class="timeline-item">
                    <div class="timeline-line w-40px"></div>
                    <div class="timeline-icon symbol symbol-circle symbol-40px">
                        <div class="symbol-label bg-light-{{ $color }}">
                            <i class="ki-duotone {{ $icon }} fs-2 text-{{ $color }}"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="timeline-content mb-10 mt-n1">
                        <div class="pe-3 mb-5">
                            <div class="fs-5 fw-bold mb-2">{{ $h['aksi'] }} 
                                <span class="badge badge-light-{{ $color }} ms-2 text-uppercase fw-bold">{{ $h['status'] }}</span>
                            </div>
                            <div class="d-flex align-items-center mt-1 fs-6">
                                <div class="text-muted me-2 fs-7">{{ $waktu->isoFormat('D MMMM YYYY, HH:mm') }} WIB</div>
                                <div class="text-gray-800 fw-semibold">{{ $h['detail'] }}</div>
                            </div>
                            @if ($h['catatan'])
                                <div class="mt-4">
                                    <div class="bg-light-{{ $color }} p-4 rounded border border-{{ $color }} border-dashed fs-7 text-{{ $color }} fw-bold">
                                        <i class="ki-duotone ki-message-text-2 fs-4 me-1 text-{{ $color }}"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                        "{{ $h['catatan'] }}"
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>