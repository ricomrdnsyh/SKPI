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
<div class="card-header border-0 pt-6">
    <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1"><i class="ki-duotone ki-check-square fs-2 me-2 text-primary"><span class="path1"></span><span class="path2"></span></i> Validasi Data Mahasiswa</span>
        <span class="text-muted fw-semibold fs-7 mt-2">Tinjau dan validasi berkas bukti dukung yang diunggah oleh mahasiswa.</span>
    </h3>
</div>
<div class="card-body pt-5">
    {{-- Prestasi --}}
    <div class="mb-8">
        <h4 class="fw-bolder text-gray-800 mb-4 pb-2 border-bottom border-gray-200">
            <i class="ki-duotone ki-medal fs-2 me-2 text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> Prestasi
            <span class="badge badge-light-secondary ms-2 fw-normal fs-8">Verifikasi BAAK</span>
        </h4>
        <div class="d-flex flex-column gap-4">
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
                <div class="text-center py-5">
                    <i class="ki-duotone ki-medal fs-3x text-gray-300 mb-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                    <div class="text-muted fs-7 fw-semibold">Belum ada data prestasi.</div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Organisasi --}}
    <div class="mb-8">
        <h4 class="fw-bolder text-gray-800 mb-4 pb-2 border-bottom border-gray-200">
            <i class="ki-duotone ki-people fs-2 me-2 text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> Organisasi
            <span class="badge badge-light-secondary ms-2 fw-normal fs-8">Verifikasi BAAK</span>
        </h4>
        <div class="d-flex flex-column gap-4">
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
                <div class="text-center py-5">
                    <i class="ki-duotone ki-people fs-3x text-gray-300 mb-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                    <div class="text-muted fs-7 fw-semibold">Belum ada data organisasi.</div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Sertifikat --}}
    <div class="mb-8">
        <h4 class="fw-bolder text-gray-800 mb-4 pb-2 border-bottom border-gray-200">
            <i class="ki-duotone ki-scroll fs-2 me-2 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> Sertifikat
            <span class="badge badge-light-secondary ms-2 fw-normal fs-8">Verifikasi BAAK</span>
        </h4>
        <div class="d-flex flex-column gap-4">
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
                <div class="text-center py-5">
                    <i class="ki-duotone ki-scroll fs-3x text-gray-300 mb-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    <div class="text-muted fs-7 fw-semibold">Belum ada data sertifikat.</div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Magang --}}
    <div class="mb-8">
        <h4 class="fw-bolder text-gray-800 mb-4 pb-2 border-bottom border-gray-200">
            <i class="ki-duotone ki-briefcase fs-2 me-2 text-gray-600"><span class="path1"></span><span class="path2"></span></i> Magang / KP
            <span class="badge badge-light-secondary ms-2 fw-normal fs-8">Verifikasi BAAK</span>
        </h4>
        <div class="d-flex flex-column gap-4">
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
                <div class="text-center py-5">
                    <i class="ki-duotone ki-briefcase fs-3x text-gray-300 mb-2"><span class="path1"></span><span class="path2"></span></i>
                    <div class="text-muted fs-7 fw-semibold">Belum ada data magang.</div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Tugas Akhir --}}
    <div class="mb-0">
        <h4 class="fw-bolder text-gray-800 mb-4 pb-2 border-bottom border-gray-200">
            <i class="ki-duotone ki-book-open fs-2 me-2 text-info"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> Tugas Akhir / Skripsi
            <span class="badge badge-light-secondary ms-2 fw-normal fs-8">Verifikasi BAAK</span>
        </h4>
        
        @if($mahasiswa->tugasAkhir)
            @php
                $ta = $mahasiswa->tugasAkhir;
            @endphp
            @include('bak_fakultas.verifikasi._item_card', [
                'item' => $ta,
                'itemTitle' => $ta->judul,
                'itemSubtitle' => 'Pembimbing: ' . collect($ta->pembimbingTugasAkhir ?? [])->map(fn($d) => $d->nama_dosen)->implode(' & '),
                'status' => data_get($ta, 'status', 'pending'),
                'fileBukti' => null,
                'itemType' => 'tugas_akhir',
                'itemId' => $ta->id_tugas_akhir,
                'currentStage' => data_get($ta, 'current_stage'),
            ])
        @else
            <div class="alert bg-light-danger border border-danger d-flex align-items-center p-4">
                <i class="ki-duotone ki-information-5 fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                <div class="d-flex flex-column">
                    <span class="text-danger fw-semibold">Judul Tugas Akhir belum diisi oleh mahasiswa.</span>
                </div>
            </div>
        @endif
    </div>
</div>