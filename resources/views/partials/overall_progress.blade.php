@props(['steps'])

<div class="card p-6 animate-fade-in" style="animation-delay: 0.05s">
    <div class="section-accent mb-5">
        <i class="fa-solid fa-route"></i>
        <h3 class="text-sm font-bold text-gray-900">Progress Penerbitan SKPI</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
        @foreach($steps as $stepNum => $step)
            @php
                $isDone = $step['status'] === 'sudah';
                $isRejected = $step['status'] === 'ditolak';
                $isRevisi = $step['status'] === 'revisi';
                $numClass = $isDone ? 'bg-emerald-500 text-white' : ($isRejected ? 'bg-red-500 text-white' : ($isRevisi ? 'bg-amber-500 text-white' : 'bg-gray-200 text-gray-500'));
                $statusClass = $isDone ? 'bg-emerald-100 text-emerald-700' : ($isRejected ? 'bg-red-100 text-red-700' : ($isRevisi ? 'bg-amber-100 text-amber-700' : 'bg-gray-200 text-gray-500'));
            @endphp
            <div class="relative p-4 bg-white rounded-2xl border border-gray-200/80 shadow-sm transition-all duration-200 hover:shadow-md {{ $isDone ? 'bg-emerald-50/30' : '' }}">
                <div class="absolute top-3 right-3 w-5 h-5 font-bold text-[9px] flex items-center justify-center rounded-lg {{ $numClass }}">
                    {{ $stepNum }}
                </div>
                <p class="font-bold text-xs text-gray-900 pr-6">{{ $step['name'] }}</p>
                <p class="text-[10px] text-gray-500 mt-1.5 leading-relaxed">{{ $step['desc'] }}</p>
                <div class="mt-3 pt-3 flex items-center justify-between border-t border-gray-200/60">
                    <span class="text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $statusClass }}">
                        {{ $step['status'] === 'sudah' ? 'Selesai' : ($step['status'] === 'ditolak' ? 'Ditolak' : ($step['status'] === 'revisi' ? 'Revisi' : ucfirst($step['status']))) }}
                    </span>
                    @if($step['date'])
                        <span class="text-[9px] text-gray-400 font-medium">{{ \Carbon\Carbon::parse($step['date'])->format('d/m/y') }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>