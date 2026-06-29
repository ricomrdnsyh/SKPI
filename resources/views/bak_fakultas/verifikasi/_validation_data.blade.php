@php
    $role = Auth::user()->role;

    $filterGrupA = function($collection) {
        return $collection;
    };

    $filteredPrestasi = $filterGrupA($prestasi);
    $filteredOrganisasi = $filterGrupA($organisasi);
    $filteredSertifikat = $filterGrupA($sertifikat);
    $filteredMagang = $filterGrupA($magang);
@endphp
<div class="card p-6 animate-fade-in" style="animation-delay: 0.25s">
    <h3 class="section-accent mb-2">
        <i class="fa-solid fa-list-check text-emerald-500"></i>
        Validasi Data Mahasiswa
    </h3>
    <p class="text-xs text-gray-400 mb-6">Tinjau dan validasi berkas bukti dukung yang diunggah oleh mahasiswa.</p>

    {{-- Prestasi --}}
    <div class="space-y-4 mb-8">
        <h4 class="section-accent pb-2 border-b border-gray-200/60">
            <i class="fa-solid fa-trophy text-amber-500"></i> Prestasi
            <span class="text-[9px] font-normal text-gray-400 ml-2">(Verifikasi BAAK)</span>
        </h4>
        @forelse($filteredPrestasi as $p)
            @include('bak_fakultas.verifikasi._item_card', [
                'item' => $p,
                'itemTitle' => $p->nama_prestasi,
                'itemSubtitle' => $p->peringkat . ' | ' . $p->tingkat . ' | ' . $p->penyelenggara . ' (' . $p->tahun . ')',
                'status' => $p->status,
                'fileBukti' => $p->file_bukti,
                'itemType' => 'prestasi',
                'itemId' => $p->getKey(),
                'currentStage' => $p->current_stage,
            ])
        @empty
            <div class="empty-state py-8">
                <i class="fa-solid fa-trophy text-gray-300"></i>
                <p class="text-xs text-gray-400">Belum ada data prestasi.</p>
            </div>
        @endforelse
    </div>

    {{-- Organisasi --}}
    <div class="space-y-4 mb-8">
        <h4 class="section-accent pb-2 border-b border-gray-200/60">
            <i class="fa-solid fa-users-rectangle text-emerald-500"></i> Organisasi
            <span class="text-[9px] font-normal text-gray-400 ml-2">(Verifikasi BAAK)</span>
        </h4>
        @forelse($filteredOrganisasi as $o)
            @include('bak_fakultas.verifikasi._item_card', [
                'item' => $o,
                'itemTitle' => $o->nama_organisasi,
                'itemSubtitle' => $o->jabatan . ' | ' . $o->tingkat . ' | Periode: ' . $o->tahun_mulai . ' - ' . ($o->tahun_selesai ?? 'Sekarang'),
                'status' => $o->status,
                'fileBukti' => $o->file_bukti,
                'itemType' => 'organisasi',
                'itemId' => $o->getKey(),
                'currentStage' => $o->current_stage,
            ])
        @empty
            <div class="empty-state py-8">
                <i class="fa-solid fa-users-rectangle text-gray-300"></i>
                <p class="text-xs text-gray-400">Belum ada data organisasi.</p>
            </div>
        @endforelse
    </div>

    {{-- Sertifikat --}}
    <div class="space-y-4 mb-8">
        <h4 class="section-accent pb-2 border-b border-gray-200/60">
            <i class="fa-solid fa-file-signature text-blue-500"></i> Sertifikat
            <span class="text-[9px] font-normal text-gray-400 ml-2">(Verifikasi BAAK)</span>
        </h4>
        @forelse($filteredSertifikat as $s)
            @include('bak_fakultas.verifikasi._item_card', [
                'item' => $s,
                'itemTitle' => $s->nama_sertifikat,
                'itemSubtitle' => $s->jenis_sertifikat . ' | Bidang: ' . $s->bidang . ' | ' . $s->penyelenggara . ' (' . \Carbon\Carbon::parse($s->tanggal_terbit)->format('d/m/y') . ')',
                'status' => $s->status,
                'fileBukti' => $s->file_bukti,
                'itemType' => 'sertifikat',
                'itemId' => $s->getKey(),
                'currentStage' => $s->current_stage,
            ])
        @empty
            <div class="empty-state py-8">
                <i class="fa-solid fa-file-signature text-gray-300"></i>
                <p class="text-xs text-gray-400">Belum ada data sertifikat.</p>
            </div>
        @endforelse
    </div>

    {{-- Magang --}}
    <div class="space-y-4 mb-8">
        <h4 class="section-accent pb-2 border-b border-gray-200/60">
            <i class="fa-solid fa-briefcase text-gray-500"></i> Magang / KP
            <span class="text-[9px] font-normal text-gray-400 ml-2">(Verifikasi BAAK)</span>
        </h4>
        @forelse($filteredMagang as $m)
            @include('bak_fakultas.verifikasi._item_card', [
                'item' => $m,
                'itemTitle' => $m->tempatMagang->nama_perusahaan ?? 'Perusahaan',
                'itemSubtitle' => $m->posisi . ' | Periode: ' . \Carbon\Carbon::parse($m->tanggal_mulai)->format('d/m/y') . ' - ' . \Carbon\Carbon::parse($m->tanggal_selesai)->format('d/m/y'),
                'status' => $m->status,
                'fileBukti' => $m->file_bukti,
                'itemType' => 'magang',
                'itemId' => $m->getKey(),
                'currentStage' => $m->current_stage,
            ])
        @empty
            <div class="empty-state py-8">
                <i class="fa-solid fa-briefcase text-gray-300"></i>
                <p class="text-xs text-gray-400">Belum ada data magang.</p>
            </div>
        @endforelse
    </div>

    {{-- Tugas Akhir --}}
    <div class="space-y-4">
        <h4 class="section-accent pb-2 border-b border-gray-200/60">
            <i class="fa-solid fa-graduation-cap text-emerald-500"></i> Tugas Akhir / Skripsi
            <span class="text-[9px] font-normal text-gray-400 ml-2">(Verifikasi BAAK)</span>
        </h4>
        @if($mahasiswa->tugasAkhir)
            @php
                $ta = $mahasiswa->tugasAkhir;
                $taStage = $ta->current_stage ?? 'waiting_baak';
                $showTa = true;
            @endphp
            @if($showTa)
                <div class="p-5 bg-white space-y-3 rounded-2xl border border-gray-200/80 shadow-sm">
                    <div class="flex justify-between items-start gap-3">
                        <div class="min-w-0">
                            <p class="font-bold text-gray-900 text-sm">{{ $ta->judul }}</p>
                            <p class="text-[11px] text-gray-500 mt-0.5 font-medium">
                                Pembimbing: {{ collect($ta->pembimbingTugasAkhir)->map(fn($d) => $d->nama_dosen)->implode(' & ') }}
                            </p>
                        </div>
                        @php
                            $taBadgeClass = $ta->status === 'approved' ? 'badge-approved' : ($ta->status === 'rejected' ? 'badge-rejected' : 'badge-pending');
                            $taStatusLabel = $ta->status === 'approved' ? 'Disetujui' : ($ta->status === 'rejected' ? 'Ditolak' : 'Menunggu');
                        @endphp
                        <span class="badge {{ $taBadgeClass }}">{{ $taStatusLabel }}</span>
                    </div>

                    {{-- BAK actions --}}
                    @if(($ta->status === 'pending' || !$ta->status) && Auth::user()->role === 'bak_fakultas')
                        <div class="flex gap-2 pt-3 border-t border-gray-200/60">
                            <form action="{{ route('bak_fakultas.tugas_akhir.approve', $ta->id_tugas_akhir) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-xs">Approve</button>
                            </form>
                            <form action="{{ route('bak_fakultas.tugas_akhir.reject', $ta->id_tugas_akhir) }}" method="POST" class="flex gap-2 flex-1">
                                @csrf
                                <input type="text" name="keterangan" required class="form-input flex-1 text-xs" placeholder="Alasan tolak...">
                                <button type="submit" class="btn btn-danger btn-xs">Reject</button>
                            </form>
                        </div>
                    @endif

                    {{-- Rejection reason --}}
                    @if($ta->status === 'rejected' && $ta->keterangan)
                        <div class="p-2.5 bg-red-50 border border-red-200/60 rounded-xl text-red-800 text-[10px] font-medium">
                            <span class="font-bold">Alasan:</span> {{ $ta->keterangan }}
                        </div>
                    @endif
                </div>
            @else
                <div class="empty-state py-8">
                    <i class="fa-solid fa-graduation-cap text-gray-300"></i>
                    <p class="text-xs text-gray-400">Tidak ada data Tugas Akhir.</p>
                </div>
            @endif
        @else
            <div class="p-3.5 bg-red-50 text-red-700 text-xs font-medium rounded-2xl border border-red-200/60 flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                Judul Tugas Akhir belum diisi oleh mahasiswa.
            </div>
        @endif
    </div>
</div>