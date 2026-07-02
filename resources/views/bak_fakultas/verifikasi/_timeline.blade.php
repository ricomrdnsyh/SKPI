<div class="card-header border-0 pt-6">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1"><i class="ki-duotone ki-time fs-2 me-2 text-primary"><span class="path1"></span><span class="path2"></span></i> Riwayat Aktivitas SKPI</span>
        </h3>
    </div>
    <div class="card-body pt-5">
        <div class="timeline">
            @php $prevDate = null; @endphp
            @foreach ($history as $h)
                @php
                    $waktu = \Carbon\Carbon::parse($h['waktu']);
                    $showDate = !$prevDate || !$waktu->isSameDay($prevDate);
                    $prevDate = $waktu;
                    $isPositive = in_array($h['status'], ['approved', 'sudah', 'lulus', 'dicetak', 'submitted']);
                    $dotClass = $isPositive ? 'text-success' : (in_array($h['status'], ['ditolak', 'rejected']) ? 'text-danger' : 'text-warning');
                    $badgeClass = $isPositive ? 'badge-light-success text-success' : (in_array($h['status'], ['ditolak', 'rejected']) ? 'badge-light-danger text-danger' : 'badge-light-warning text-warning');
                @endphp
                
                @if ($showDate)
                    <div class="timeline-item mb-5">
                        <div class="timeline-line w-40px"></div>
                        <div class="timeline-icon symbol symbol-circle symbol-40px">
                            <div class="symbol-label bg-light">
                                <i class="ki-duotone ki-calendar fs-2 text-gray-500"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                        </div>
                        <div class="timeline-content mt-n1">
                            <div class="pe-3 mb-5">
                                <div class="fs-5 fw-bold mb-2">{{ $waktu->isoFormat('D MMMM YYYY') }}</div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="timeline-item">
                    <div class="timeline-line w-40px"></div>
                    <div class="timeline-icon symbol symbol-circle symbol-40px">
                        <div class="symbol-label bg-light">
                            <i class="ki-duotone ki-record fs-2 {{ $dotClass }}"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="timeline-content mb-10 mt-n1">
                        <div class="pe-3 mb-5">
                            <div class="fs-5 fw-bold mb-2">{{ $h['aksi'] }} 
                                <span class="badge {{ $badgeClass }} ms-2 text-uppercase fw-bold">{{ $h['status'] }}</span>
                            </div>
                            <div class="d-flex align-items-center mt-1 fs-6">
                                <div class="text-muted me-2 fs-7">{{ $waktu->format('H:i') }}</div>
                                <div class="text-gray-800 fw-semibold">{{ $h['detail'] }}</div>
                            </div>
                            @if ($h['catatan'])
                                <div class="mt-3">
                                    <div class="bg-light p-3 rounded border border-gray-200 fs-7 text-gray-700 fst-italic">
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