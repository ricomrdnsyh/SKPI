@php
    $isTugasAkhir = $itemType === 'tugas_akhir';
    if ($status === 'approved') {
        $badgeClass = 'badge-light-success text-success';
        $statusLabel = 'Disetujui';
        $bgClass = 'bg-light-success';
        $borderColor = 'border-success';
    } elseif ($status === 'rejected') {
        $badgeClass = 'badge-light-danger text-danger';
        $statusLabel = 'Ditolak';
        $bgClass = 'bg-light-danger';
        $borderColor = 'border-danger';
    } else {
        $badgeClass = 'badge-light-warning text-warning';
        $statusLabel = 'Menunggu';
        $bgClass = 'bg-light-warning';
        $borderColor = 'border-warning';
    }
@endphp
<div class="border border-dashed {{ $borderColor }} {{ $bgClass }} rounded p-5 mb-5">
    <div class="d-flex justify-content-between align-items-start gap-3">
        <div class="d-flex flex-column min-w-0">
            <div class="fw-bolder text-gray-900 fs-5 mb-1">{{ $itemTitle }}</div>
            @if ($itemSubtitle)
                <div class="text-muted fs-8 fw-semibold">{{ $itemSubtitle }}</div>
            @endif
            @if ($fileBukti)
                <div class="mt-3">
                    <a href="{{ asset('storage/' . $fileBukti) }}" target="_blank"
                        class="btn btn-sm btn-primary px-3 py-1 fw-bold fs-8">
                        <i class="ki-duotone ki-file-down fs-4 me-1"><span class="path1"></span><span
                                class="path2"></span></i> Berkas Bukti
                    </a>
                </div>
            @endif
        </div>
        <span class="badge {{ $badgeClass }} text-uppercase fw-bold shrink-0 mt-1">{{ $statusLabel }}</span>
    </div>
    @if ($status === 'pending' && in_array(Auth::user()->role, ['bak_fakultas', 'admin']))
        <div
            class="d-flex flex-column flex-sm-row justify-content-end align-items-sm-center gap-2 pt-4 mt-4 border-top border-gray-300">
            @if ($isTugasAkhir)
                <form action="{{ route('bak_fakultas.tugas_akhir.reject', $itemId) }}" method="POST"
                    id="form-reject-ta-{{ $itemId }}" class="m-0">
                    @csrf
                    <input type="hidden" name="keterangan" id="ket-ta-{{ $itemId }}">
                    <button type="button" onclick="confirmReject('form-reject-ta-{{ $itemId }}', 'ket-ta-{{ $itemId }}')"
                        class="btn btn-danger btn-sm fw-bolder px-4 py-2 shadow-sm d-flex align-items-center justify-content-center"
                        style="min-width: 90px;">
                        <span class="indicator-label">
                            <span class="d-flex align-items-center"><i class="ki-duotone ki-cross fs-2 me-1"><span
                                        class="path1"></span><span class="path2"></span></i> Tolak</span>
                        </span>
                    </button>
                </form>
                <form action="{{ route('bak_fakultas.tugas_akhir.approve', $itemId) }}" method="POST" class="m-0"
                    onsubmit="const b=this.querySelector('button');b.innerHTML='<span class=\'spinner-border spinner-border-sm\'></span>';b.disabled=true;">
                    @csrf
                    <button type="submit"
                        class="btn btn-success btn-sm fw-bolder px-4 py-2 shadow-sm d-flex align-items-center justify-content-center"
                        style="min-width: 90px;">
                        <span class="indicator-label">
                            <span class="d-flex align-items-center"><i class="ki-duotone ki-check fs-2 me-1"></i>
                                Setujui</span>
                        </span>
                    </button>
                </form>
            @else
                <form action="{{ route('bak_fakultas.data.reject', ['type' => $itemType, 'id' => $itemId]) }}"
                    method="POST" id="form-reject-{{ $itemType }}-{{ $itemId }}" class="m-0">
                    @csrf
                    <input type="hidden" name="keterangan" id="ket-{{ $itemType }}-{{ $itemId }}">
                    <button type="button" onclick="confirmReject('form-reject-{{ $itemType }}-{{ $itemId }}', 'ket-{{ $itemType }}-{{ $itemId }}')"
                        class="btn btn-danger btn-sm fw-bolder px-4 py-2 shadow-sm d-flex align-items-center justify-content-center"
                        style="min-width: 90px;">
                        <span class="indicator-label">
                            <span class="d-flex align-items-center"><i class="ki-duotone ki-cross fs-2 me-1"><span
                                        class="path1"></span><span class="path2"></span></i> Tolak</span>
                        </span>
                    </button>
                </form>
                <form action="{{ route('bak_fakultas.data.approve', ['type' => $itemType, 'id' => $itemId]) }}"
                    method="POST" class="m-0"
                    onsubmit="const b=this.querySelector('button');b.innerHTML='<span class=\'spinner-border spinner-border-sm\'></span>';b.disabled=true;">
                    @csrf
                    <button type="submit"
                        class="btn btn-success btn-sm fw-bolder px-4 py-2 shadow-sm d-flex align-items-center justify-content-center"
                        style="min-width: 90px;">
                        <span class="indicator-label">
                            <span class="d-flex align-items-center"><i class="ki-duotone ki-check fs-2 me-1"></i>
                                Setujui</span>
                        </span>
                    </button>
                </form>
            @endif
        </div>
    @endif
    @if ($status === 'rejected' && !empty($item->keterangan))
        <div
            class="bg-white rounded border border-danger border-dashed p-3 mt-4 text-gray-800 fs-8 d-flex align-items-start">
            <i class="ki-duotone ki-information-5 fs-2 text-danger me-2"><span class="path1"></span><span
                    class="path2"></span><span class="path3"></span></i>
            <div>
                <span class="fw-bolder text-danger d-block mb-1">Alasan Penolakan:</span>
                {{ $item->keterangan }}
            </div>
        </div>
    @endif
</div>
