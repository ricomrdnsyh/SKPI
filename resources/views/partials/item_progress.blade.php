@props(['steps', 'itemName' => 'Data Ini'])

<div class="card shadow-sm"><div class="card-body">
    <h3 class="text-sm font-bold text-gray-900 mb-5 flex items-center gap-2">
        <i class="fa-solid fa-clock-rotate-left text-unuja-600"></i> Progress Approval {{ $itemName }}
    </h3>
    <div class="form mb-6">
        @foreach($steps as $i => $step)
        <div class="relative flex items-start gap-4 {{ !$loop->last ? 'pb-5' : '' }}">
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 flex items-center justify-center text-xs font-bold text-white rounded-xl shadow-sm {{ $step['color'] }}">
                    <i class="fa-solid fa-{{ $step['icon'] }}"></i>
                </div>
                @if(!$loop->last)
                    <div class="w-0.5 flex-1 min-h-[2rem] bg-gray-200 mt-1"></div>
                @endif
            </div>
            <div class="pt-0.5">
                <p class="text-sm font-bold text-gray-900">{{ $step['label'] }}</p>
                <p class="text-muted fs-7 font-medium">{{ $step['info'] }}</p>
                @if(($step['note'] ?? false))
                    <p class="text-xs text-red-600 mt-1 font-bold flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ $step['note'] }}
                    </p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>