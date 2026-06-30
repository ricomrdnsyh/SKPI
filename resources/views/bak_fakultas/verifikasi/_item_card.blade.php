@php
    $isTugasAkhir = $itemType === 'tugas_akhir';

    if ($status === 'approved') {
        $badgeClass = 'badge-approved';
        $statusLabel = 'Disetujui';
    } elseif ($status === 'rejected') {
        $badgeClass = 'badge-rejected';
        $statusLabel = 'Ditolak';
    } else {
        $badgeClass = 'badge-pending';
        $statusLabel = 'Menunggu';
    }
@endphp
<div class="p-4 bg-white space-y-3 rounded-2xl border border-gray-200/80 shadow-sm">
    <div class="flex justify-between items-start gap-3">
        <div class="min-w-0">
            <p class="font-bold text-gray-900 text-sm">{{ $itemTitle }}</p>
            @if($itemSubtitle)
                <p class="text-[11px] text-gray-500 mt-0.5 font-medium">{{ $itemSubtitle }}</p>
            @endif
        </div>
        <span class="badge {{ $badgeClass }} shrink-0">{{ $statusLabel }}</span>
    </div>

    @if ($fileBukti)
        <a href="{{ asset('storage/' . $fileBukti) }}" target="_blank"
            class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-800 hover:underline transition">
            <i class="fa-solid fa-file-pdf"></i> Lihat Berkas Bukti
        </a>
    @endif

    {{-- BAAK: Approve/Reject --}}
    @if ($status === 'pending' && Auth::user()->role === 'bak_fakultas')
        <div class="flex gap-2 pt-3 border-t border-gray-200/60">
            @if($isTugasAkhir)
                <form action="{{ route('bak_fakultas.tugas_akhir.approve', $itemId) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-xs">Approve</button>
                </form>
                <form action="{{ route('bak_fakultas.tugas_akhir.reject', $itemId) }}" method="POST" class="flex gap-2 flex-1">
                    @csrf
                    <input type="text" name="keterangan" required class="form-control form-control-solid flex-1 text-xs" placeholder="Alasan tolak...">
                    <button type="submit" class="btn btn-danger btn-xs">Reject</button>
                </form>
            @else
                <form action="{{ route('bak_fakultas.data.approve', ['type' => $itemType, 'id' => $itemId]) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-xs">Approve</button>
                </form>
                <form action="{{ route('bak_fakultas.data.reject', ['type' => $itemType, 'id' => $itemId]) }}" method="POST" class="flex gap-2 flex-1">
                    @csrf
                    <input type="text" name="keterangan" required class="form-control form-control-solid flex-1 text-xs" placeholder="Alasan tolak...">
                    <button type="submit" class="btn btn-danger btn-xs">Reject</button>
                </form>
            @endif
        </div>
    @endif

    {{-- Rejection reason --}}
    @if ($status === 'rejected' && !empty($item->keterangan))
        <div class="p-2.5 bg-red-50 text-red-800 text-[10px] font-medium rounded-xl border border-red-200/60">
            <span class="font-bold">Alasan:</span> {{ $item->keterangan }}
        </div>
    @endif
</div>