@extends('layouts.app')

@section('title', 'Detail Verifikasi SKPI')

@section('content')
    @php
        $backRoute = route('bak_fakultas.dashboard');
        $statusColors = [
            'dicetak' => 'bg-emerald-100 text-emerald-800',
            'verifikasi' => 'bg-blue-100 text-blue-800',
            'diajukan' => 'bg-amber-100 text-amber-800',
            'ditolak' => 'bg-red-100 text-red-800',
            'draft' => 'bg-gray-100 text-gray-800',
        ];
        $statusClass = $statusColors[$pengajuan->status] ?? 'bg-gray-100 text-gray-800';
        $steps = $mahasiswa->getSkpiProgressSteps($pengajuan);
        $role = Auth::user()->role;
    @endphp

    <div class="space-y-8">
        {{-- Header --}}
        <div class="animate-fade-in">
            <a href="{{ $backRoute }}"
                class="inline-flex items-center gap-2 text-gray-600 font-semibold mb-4 text-sm hover:text-gray-900 transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="page-title">Data Mahasiswa & Status Modul</h2>
                    <p class="page-desc">
                        Pemohon: <span class="font-bold text-gray-900">{{ $mahasiswa->nama_lengkap }}</span>
                        (NIM: {{ $mahasiswa->nim }})
                    </p>
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    @if ($pengajuan->status !== 'draft')
                        <a href="{{ route('bak_fakultas.skpi.print', $pengajuan->id_pengajuan) }}" target="_blank"
                            class="btn btn-success btn-sm">
                            <i class="fa-solid fa-file-pdf"></i> Preview SKPI (PDF)
                        </a>
                    @endif
                    <span class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-xl {{ $statusClass }}">
                        Status: {{ $pengajuan->status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Progress Timeline --}}
        @include('partials.overall_progress', ['steps' => $steps])

        {{-- Action cards --}}
        @if (Auth::user()->role === 'bak_fakultas')
            @include('bak_fakultas.verifikasi._action_cards')
        @endif

        {{-- Module status overview --}}
        <div class="card p-6 animate-fade-in" style="animation-delay: 0.1s">
            <h3 class="section-accent mb-4"><i class="fa-solid fa-list-check"></i> Status Persetujuan Modul</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
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
                            'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            'ditolak' => 'bg-red-100 text-red-800 border-red-200',
                            'belum' => 'bg-gray-50 text-gray-500 border-gray-200',
                            default => 'bg-amber-100 text-amber-800 border-amber-200',
                        };
                        $i = match($m['status']) {
                            'approved' => 'fa-check-circle',
                            'ditolak' => 'fa-times-circle',
                            'belum' => 'fa-circle',
                            default => 'fa-clock',
                        };
                    @endphp
                    <div class="p-3.5 {{ $c }} text-center rounded-2xl border">
                        <p class="font-bold text-xs">{{ $m['label'] }}</p>
                        <p class="text-[9px] font-bold uppercase tracking-wider mt-1"><i class="fa-solid {{ $i }} mr-0.5"></i> {{ $m['status'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Checklist form for BAK --}}
        @if (Auth::user()->role === 'bak_fakultas' && $pengajuan->status === 'diajukan')
            @include('bak_fakultas.verifikasi._checklist_form')
        @endif

        {{-- Main content --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-8">
                @include('bak_fakultas.verifikasi._identity_card')
            </div>

            <div class="space-y-8">
                @include('bak_fakultas.verifikasi._validation_data')
                @include('bak_fakultas.verifikasi._prodi_academic_data')
            </div>
        </div>

        {{-- Timeline --}}
        @if ($history->isNotEmpty())
            @include('bak_fakultas.verifikasi._timeline')
        @endif
    </div>
@endsection