@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="space-y-6">
    {{-- Welcome card --}}
    <div class="card overflow-hidden animate-fade-in">
        <div class="relative px-6 py-6 bg-linear-to-br from-unuja-800 via-unuja-700 to-unuja-900">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.3) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.2) 0%, transparent 40%);"></div>
            <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 flex items-center justify-center bg-linear-to-br from-white/20 to-white/5 text-white font-black text-lg rounded-2xl shadow-lg border border-white/10 shrink-0">
                        {{ substr($mahasiswa->nama_lengkap, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-white tracking-tight">Halo, {{ $mahasiswa->nama_lengkap }}</h2>
                        <p class="text-sm text-white/50 mt-0.5">
                            <span class="font-bold text-white/70">{{ $mahasiswa->nim }}</span>
                            <span class="mx-1.5 text-white/20">&middot;</span>
                            {{ $mahasiswa->programStudi->nama_prodi }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    @if($pengajuan)
                        <div class="px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-xl backdrop-blur-sm border border-white/10 {{ $pengajuan->status === 'dicetak' ? 'bg-emerald-500/20 text-emerald-200' : ($pengajuan->status === 'ditolak' ? 'bg-red-500/20 text-red-200' : ($pengajuan->status === 'draft' ? 'bg-amber-500/20 text-amber-200' : 'bg-blue-500/20 text-blue-200')) }}">
                            @if($pengajuan->status === 'diajukan' || $pengajuan->status === 'verifikasi')
                                <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse-subtle inline-block mr-1.5 align-middle"></span>
                            @endif
                            {{ $pengajuan->status === 'dicetak' ? 'SKPI Telah Terbit' : ($pengajuan->status === 'ditolak' ? 'Pengajuan Ditolak' : ($pengajuan->status === 'draft' ? 'Perlu Revisi' : 'Sedang Diproses')) }}
                        </div>
                    @else
                        <div class="px-4 py-1.5 bg-white/10 text-white/50 text-[10px] font-bold rounded-xl border border-white/10">Belum Mengajukan</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Module Approval Status --}}
    <div class="card p-6 animate-fade-in" style="animation-delay: 0.05s">
        <div class="section-accent mb-5">
            <i class="fa-solid fa-list-check"></i>
            Status Persetujuan Modul
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            @php
                $modules = [
                    ['label' => 'Prestasi', 'icon' => 'fa-trophy', 'gradient' => 'from-amber-400 to-orange-500', 'approved' => $mahasiswa->allPrestasiApproved(), 'hasItems' => $prestasi->count() > 0, 'items' => $prestasi],
                    ['label' => 'Organisasi', 'icon' => 'fa-users-rectangle', 'gradient' => 'from-blue-400 to-indigo-500', 'approved' => $mahasiswa->allOrganisasiApproved(), 'hasItems' => $organisasi->count() > 0, 'items' => $organisasi],
                    ['label' => 'Sertifikat', 'icon' => 'fa-file-signature', 'gradient' => 'from-violet-400 to-purple-500', 'approved' => $mahasiswa->allSertifikatApproved(), 'hasItems' => $sertifikat->count() > 0, 'items' => $sertifikat],
                    ['label' => 'Magang / KP', 'icon' => 'fa-briefcase', 'gradient' => 'from-teal-400 to-emerald-500', 'approved' => $mahasiswa->allMagangApproved(), 'hasItems' => $magang->count() > 0, 'items' => $magang],
                    ['label' => 'Tugas Akhir', 'icon' => 'fa-graduation-cap', 'gradient' => 'from-green-400 to-emerald-600', 'approved' => $mahasiswa->tugasAkhirApproved(), 'hasItems' => (bool)$mahasiswa->tugasAkhir, 'items' => $mahasiswa->tugasAkhir ? collect([$mahasiswa->tugasAkhir]) : collect()],
                ];
            @endphp
            @foreach($modules as $mod)
                @php
                    $allApproved = $mod['approved'];
                    $anyRejected = $mod['items']->where('status', 'rejected')->isNotEmpty();
                    $somePending = $mod['items']->where('status', 'pending')->isNotEmpty();
                    $noItems = !$mod['hasItems'];

                    if ($noItems) {
                        $statusColor = 'bg-gray-100 text-gray-500';
                        $statusText = 'Belum Diisi';
                        $statusIcon = 'fa-circle';
                    } elseif ($allApproved) {
                        $statusColor = 'bg-emerald-100 text-emerald-700';
                        $statusText = 'Disetujui';
                        $statusIcon = 'fa-check-circle';
                    } elseif ($anyRejected) {
                        $statusColor = 'bg-red-100 text-red-700';
                        $statusText = 'Ditolak';
                        $statusIcon = 'fa-times-circle';
                    } else {
                        $statusColor = 'bg-amber-100 text-amber-700';
                        $statusText = 'Diproses';
                        $statusIcon = 'fa-clock';
                    }
                @endphp
                <div class="p-4 bg-white rounded-2xl border border-gray-200/80 shadow-sm flex flex-col items-center text-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md group">
                    <div class="w-10 h-10 flex items-center justify-center mb-3 rounded-xl shadow-lg bg-linear-to-br {{ $mod['gradient'] }} text-white group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid {{ $mod['icon'] }} text-sm"></i>
                    </div>
                    <p class="font-bold text-xs text-gray-900">{{ $mod['label'] }}</p>
                    <span class="inline-flex items-center gap-1 text-[9px] font-bold uppercase tracking-wider mt-1.5 px-2.5 py-0.5 rounded-full {{ $statusColor }}">
                        <i class="fa-solid {{ $statusIcon }}"></i> {{ $statusText }}
                    </span>
                    <p class="text-[9px] text-gray-400 font-medium mt-1">{{ $mod['items']->count() }} item</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Progress timeline --}}
    <div class="card p-6 animate-fade-in" style="animation-delay: 0.1s">
        <div class="section-accent mb-5">
            <i class="fa-solid fa-route"></i>
            Progress Penerbitan SKPI
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            @foreach($steps as $stepNum => $step)
                <div class="relative p-4 rounded-2xl border shadow-sm transition-all duration-200 hover:-translate-y-0.5 {{ $step['status'] === 'sudah' ? 'bg-emerald-50 border-emerald-200' : ($step['status'] === 'ditolak' ? 'bg-red-50 border-red-200' : ($step['status'] === 'revisi' ? 'bg-amber-50 border-amber-200' : 'bg-gray-50 border-gray-200/80')) }}">
                    <div class="absolute top-3 right-3 w-6 h-6 font-bold text-[10px] flex items-center justify-center rounded-lg {{ $step['status'] === 'sudah' ? 'bg-emerald-500 text-white' : ($step['status'] === 'ditolak' ? 'bg-red-500 text-white' : ($step['status'] === 'revisi' ? 'bg-amber-500 text-white' : 'bg-gray-200 text-gray-500')) }}">
                        {{ $stepNum }}
                    </div>
                    <p class="font-bold text-xs text-gray-900 pr-7">{{ $step['name'] }}</p>
                    <p class="text-[10px] text-gray-500 mt-1.5 leading-relaxed">{{ $step['desc'] }}</p>
                    <div class="mt-3 pt-3 flex items-center justify-between border-t border-gray-200/60">
                        <span class="text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $step['status'] === 'sudah' ? 'bg-emerald-100 text-emerald-700' : ($step['status'] === 'ditolak' ? 'bg-red-100 text-red-700' : ($step['status'] === 'revisi' ? 'bg-amber-100 text-amber-700' : 'bg-gray-200 text-gray-500')) }}">
                            {{ $step['status'] === 'sudah' ? 'Selesai' : ($step['status'] === 'ditolak' ? 'Ditolak' : ($step['status'] === 'revisi' ? 'Revisi' : 'Menunggu')) }}
                        </span>
                        @if($step['date'])
                            <span class="text-[9px] text-gray-400 font-medium">{{ \Carbon\Carbon::parse($step['date'])->format('d/m/y') }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Kelengkapan Berkas --}}
            <div class="card p-6 animate-fade-in" style="animation-delay: 0.15s">
                <div class="section-accent mb-5">
                    <i class="fa-solid fa-folder-open"></i>
                    Kelengkapan Berkas
                </div>
                <div class="grid grid-cols-2 gap-3">
                    @php
                        $berkas = [
                            ['route' => 'mahasiswa.prestasi.index', 'label' => 'Prestasi', 'icon' => 'fa-trophy', 'gradient' => 'from-amber-400 to-orange-500', 'count' => $prestasi->count(), 'approved' => $prestasi->where('status', 'approved')->count()],
                            ['route' => 'mahasiswa.organisasi.index', 'label' => 'Organisasi', 'icon' => 'fa-users-rectangle', 'gradient' => 'from-blue-400 to-indigo-500', 'count' => $organisasi->count(), 'approved' => $organisasi->where('status', 'approved')->count()],
                            ['route' => 'mahasiswa.sertifikat.index', 'label' => 'Sertifikat', 'icon' => 'fa-file-signature', 'gradient' => 'from-violet-400 to-purple-500', 'count' => $sertifikat->count(), 'approved' => $sertifikat->where('status', 'approved')->count()],
                            ['route' => 'mahasiswa.magang.index', 'label' => 'Magang / KP', 'icon' => 'fa-briefcase', 'gradient' => 'from-teal-400 to-emerald-500', 'count' => $magang->count(), 'approved' => $magang->where('status', 'approved')->count()],
                        ];
                    @endphp
                    @foreach($berkas as $b)
                    <a href="{{ route($b['route']) }}" class="p-4 bg-white rounded-2xl border border-gray-200/80 shadow-sm flex items-center justify-between transition-all duration-200 group hover:-translate-y-0.5 hover:shadow-md">
                        <div>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ $b['label'] }}</p>
                            <p class="text-2xl font-black text-gray-900 mt-0.5">{{ $b['count'] }}</p>
                            @if($b['approved'] > 0)
                                <p class="text-[9px] text-emerald-600 font-bold">{{ $b['approved'] }} disetujui</p>
                            @elseif($b['count'] > 0)
                                <p class="text-[9px] text-amber-600 font-bold">Menunggu verifikasi</p>
                            @else
                                <p class="text-[9px] text-gray-400 font-medium">Belum diisi</p>
                            @endif
                        </div>
                        <div class="w-11 h-11 flex items-center justify-center rounded-xl shadow-lg bg-linear-to-br {{ $b['gradient'] }} text-white group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid {{ $b['icon'] }} text-sm"></i>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Tugas Akhir --}}
                <div class="mt-4 p-5 bg-linear-to-br from-emerald-50 to-emerald-50/50 rounded-2xl border border-emerald-200/80 shadow-sm">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 flex items-center justify-center bg-linear-to-br from-green-400 to-emerald-600 rounded-xl shadow-lg">
                                <i class="fa-solid fa-graduation-cap text-white text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Tugas Akhir</p>
                                @if($mahasiswa->tugasAkhir)
                                    @php
                                        $taStatus = $mahasiswa->tugasAkhir->status;
                                        $badgeColor = $taStatus === 'approved' ? 'badge-emerald' : ($taStatus === 'rejected' ? 'badge-rejected' : 'badge-pending');
                                    @endphp
                                    <span class="badge {{ $badgeColor }}">{{ $taStatus ?? 'pending' }}</span>
                                @endif
                            </div>
                        </div>
                        @php
                            $taRaw = $mahasiswa->tugasAkhir;
                            $isRejectedTa = $taRaw && $taRaw->status === 'rejected';
                            $isLockedTa = !$isRejectedTa && $pengajuan && in_array($pengajuan->status, ['diajukan', 'verifikasi', 'dicetak']);
                            $isApprovedTa = $taRaw && $taRaw->status === 'approved';
                            $readonlyTa = $isLockedTa || $isApprovedTa;
                            $canEditTa = !$readonlyTa;
                        @endphp
                        <a href="{{ route('mahasiswa.tugas_akhir.edit') }}" class="btn {{ $canEditTa ? 'btn-primary' : 'btn-secondary' }} btn-xs">
                            <i class="fa-solid {{ $canEditTa ? 'fa-pen-to-square' : 'fa-magnifying-glass' }}"></i>
                            {{ $canEditTa ? 'Ubah' : 'Detail' }}
                        </a>
                    </div>
                    @if($mahasiswa->tugasAkhir)
                        <p class="font-bold text-gray-900 text-sm mt-2">"{{ $mahasiswa->tugasAkhir->judul }}"</p>
                        <p class="text-xs text-gray-500 mt-1">
                            Pembimbing:
                            @foreach($mahasiswa->tugasAkhir->pembimbingTugasAkhir as $pta)
                                <span class="font-semibold text-gray-700">{{ $pta->nama_dosen }}</span>{{ !$loop->last ? ' & ' : '' }}
                            @endforeach
                        </p>
                        @if($mahasiswa->tugasAkhir->keterangan)
                            <div class="mt-3 p-3 bg-red-100/80 text-red-800 text-[10px] font-bold rounded-xl border border-red-200/60">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                <span class="font-extrabold">Alasan ditolak:</span> {{ $mahasiswa->tugasAkhir->keterangan }}
                            </div>
                        @endif
                    @else
                        <div class="mt-2 p-3 bg-amber-100/80 text-amber-800 text-xs font-bold rounded-xl border border-amber-200/60">
                            <i class="fa-solid fa-circle-info mr-1"></i> Belum ada judul Tugas Akhir.
                        </div>
                    @endif
                </div>
            </div>

            {{-- SKPI Download section --}}
            @if(isset($steps[3]) && $steps[3]['status'] === 'sudah')
                <div class="card p-6 animate-fade-in" style="animation-delay: 0.2s; border-color: #22c55e;">
                    <div class="section-accent mb-2">
                        <i class="fa-solid fa-file-pdf text-emerald-600"></i>
                        <span class="text-emerald-800">Surat Keterangan Pendamping Ijazah</span>
                    </div>
                    @if($mahasiswa->skpi)
                        <p class="text-xs text-emerald-700 font-medium mb-4">SKPI telah diterbitkan. Anda dapat mengunduh dokumen PDF.</p>
                        <a href="{{ route('bak_fakultas.skpi.print', $pengajuan->id_pengajuan) }}?nim_ijazah={{ urlencode($mahasiswa->skpi->nim_ijazah) }}" target="_blank" class="btn btn-success">
                            <i class="fa-solid fa-download"></i> Unduh SKPI (PDF)
                        </a>
                    @elseif($pengajuan->permohonan_cetak)
                        <p class="text-xs text-amber-700 font-medium mb-4">Permohonan cetak telah dikirim. Menunggu penerbitan oleh BAAK Fakultas.</p>
                        <div class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-100 text-amber-800 text-xs font-bold rounded-xl border border-amber-200/60">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse inline-block"></span>
                            Menunggu verifikasi dan pencetakan
                        </div>
                    @else
                        <p class="text-xs text-gray-500 font-medium mb-4">Ajukan permohonan cetak SKPI ke BAAK Fakultas untuk menerbitkan SKPI Anda.</p>
                        <form action="{{ route('mahasiswa.pengajuan.request_print') }}" method="POST" onsubmit="return confirm('Ajukan permohonan cetak SKPI sekarang?')">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-paper-plane mr-1"></i> Ajukan Permohonan Cetak SKPI
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>

        {{-- Pengajuan Sidebar --}}
        <div>
            <div class="card p-6 h-full animate-fade-in" style="animation-delay: 0.2s">
                <div class="section-accent mb-5">
                    <i class="fa-solid fa-paper-plane"></i>
                    Pengajuan SKPI
                </div>
                @if(!$pengajuan)
                    <p class="text-xs text-gray-500 leading-relaxed mb-5 font-medium">
                        Ajukan verifikasi SKPI agar data pendukung Anda dapat diproses oleh BAAK Fakultas.
                    </p>
                    @if(!$mahasiswa->tugasAkhir)
                        <div class="p-3.5 bg-amber-50 text-amber-800 text-[11px] font-medium rounded-xl border border-amber-200/60 mb-5 leading-relaxed">
                            <p class="font-bold"><i class="fa-solid fa-circle-info mr-1 text-amber-600"></i> Tugas Akhir Belum Diisi</p>
                            <p class="mt-0.5 text-[10px]">Anda tetap dapat mengajukan verifikasi sekarang, namun Tugas Akhir wajib dilengkapi sebelum SKPI dapat dicetak.</p>
                        </div>
                    @endif
                    <form action="{{ route('mahasiswa.pengajuan.submit') }}" method="POST" onsubmit="return confirm('Ajukan verifikasi SKPI sekarang?')">
                        @csrf
                        <div class="mb-4">
                            <label for="catatan_mahasiswa" class="form-label">Catatan (opsional)</label>
                            <textarea name="catatan_mahasiswa" id="catatan_mahasiswa" rows="3" class="form-input text-sm" placeholder="Ketik keterangan jika ada..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-full py-3 text-sm font-bold shadow-lg shadow-unuja-600/20">
                            <i class="fa-solid fa-paper-plane"></i> Ajukan Verifikasi SKPI
                        </button>
                    </form>
                @else
                    <div class="space-y-4">
                        <div class="p-4 bg-emerald-50 text-emerald-800 text-xs font-bold rounded-2xl border border-emerald-200/60 shadow-sm">
                            <i class="fa-solid fa-check-circle mr-1.5"></i>
                            Diajukan {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->isoFormat('D MMM YYYY H:mm') }}
                        </div>
                        @if($pengajuan->catatan_bak)
                            <div class="p-4 bg-amber-50 text-amber-900 text-xs font-medium rounded-2xl border border-amber-200/60 shadow-sm">
                                <p class="font-bold mb-1"><i class="fa-solid fa-message mr-1"></i> Catatan BAAK:</p>
                                <p>{{ $pengajuan->catatan_bak }}</p>
                            </div>
                        @endif
                        @if($pengajuan->status === 'ditolak')
                            <div class="p-4 bg-red-50 rounded-2xl border border-red-200/60 shadow-sm">
                                <p class="text-xs font-bold text-red-800 mb-3"><i class="fa-solid fa-circle-xmark mr-1"></i> Pengajuan Ditolak</p>
                                <form action="{{ route('mahasiswa.pengajuan.submit') }}" method="POST" onsubmit="return confirm('Ajukan ulang pengajuan SKPI?')">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-full py-2.5 text-xs">Ajukan Ulang</button>
                                </form>
                            </div>
                        @elseif($pengajuan->status === 'draft')
                            <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200/60 shadow-sm">
                                <p class="text-xs font-bold text-amber-800 mb-3"><i class="fa-solid fa-pen-to-square mr-1"></i> Perlu Revisi — Silakan perbaiki data dan ajukan ulang</p>
                                <form action="{{ route('mahasiswa.pengajuan.submit') }}" method="POST" onsubmit="return confirm('Ajukan ulang pengajuan SKPI?')">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-full py-2.5 text-xs">Ajukan Ulang</button>
                                </form>
                            </div>
                        @endif
                        @if($pengajuan->status === 'diajukan' || $pengajuan->status === 'verifikasi')
                            <div class="p-4 bg-blue-50 rounded-2xl border border-blue-200/60 shadow-sm text-center">
                                <span class="w-3 h-3 rounded-full bg-blue-500 animate-pulse inline-block mb-2"></span>
                                <p class="text-xs font-bold text-blue-800">Pengajuan sedang diproses oleh BAAK Fakultas</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection