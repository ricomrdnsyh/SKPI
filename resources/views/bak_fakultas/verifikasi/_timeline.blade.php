<div class="card p-6 animate-fade-in" style="animation-delay: 0.1s">
    <h3 class="section-accent mb-6">
        <i class="fa-solid fa-timeline"></i>
        Riwayat Aktivitas SKPI
    </h3>
    <div class="relative pl-8 space-y-0">
        @php $prevDate = null; @endphp
        @foreach ($history as $h)
            @php
                $waktu = \Carbon\Carbon::parse($h['waktu']);
                $showDate = !$prevDate || !$waktu->isSameDay($prevDate);
                $prevDate = $waktu;
                $isPositive = in_array($h['status'], ['approved', 'sudah', 'lulus', 'dicetak', 'submitted']);
                $dotClass = $isPositive ? 'bg-emerald-500 border-emerald-500' : (in_array($h['status'], ['ditolak', 'rejected']) ? 'bg-red-500 border-red-500' : 'bg-amber-500 border-amber-500');
                $badgeClass = $isPositive ? 'bg-emerald-100 text-emerald-700' : (in_array($h['status'], ['ditolak', 'rejected']) ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700');
            @endphp
            @if ($showDate)
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider py-2 -ml-8 pt-6 mt-2 first:border-t-0 first:pt-0 first:mt-0 border-t border-gray-200/60">
                    {{ $waktu->isoFormat('D MMMM YYYY') }}
                </div>
            @endif
            <div class="relative pb-6 group">
                <div class="absolute -left-8 top-1 w-3.5 h-3.5 rounded-full border-2 {{ $dotClass }} shadow-sm"></div>
                <div class="p-4 bg-white rounded-2xl border border-gray-200/80 shadow-sm transition-all duration-200 hover:shadow-md">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-sm font-bold text-gray-900">{{ $h['aksi'] }}</span>
                                <span class="text-[9px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $badgeClass }}">{{ $h['status'] }}</span>
                            </div>
                            <p class="text-xs text-gray-600 mt-1 font-medium">{{ $h['detail'] }}</p>
                            @if ($h['catatan'])
                                <p class="text-[10px] text-gray-500 mt-1.5 italic bg-gray-50 p-2 rounded-lg border border-gray-100">&ldquo;{{ $h['catatan'] }}&rdquo;</p>
                            @endif
                        </div>
                        <div class="text-[10px] text-gray-500 font-bold whitespace-nowrap shrink-0">
                            {{ $waktu->format('H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>