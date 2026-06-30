@extends('layout.main')

@section('title', $readonly ? 'Detail Tugas Akhir' : 'Ubah Tugas Akhir')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid mt-7">
            <div id="kt_app_content_container" class="app-container container-fluid">

    <div class="mx-auto" style="max-width: 800px;">
        <div>
            <a href="{{ route('mahasiswa.dashboard') }}"
                class="btn btn-sm btn-light btn-active-light-primary mb-4">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <h2 class="fw-bolder fs-2 mb-5">{{ $readonly ? 'Detail Tugas Akhir / Skripsi' : 'Ubah Data Tugas Akhir / Skripsi' }}</h2>
            <p class="page-desc">{{ $readonly ? 'Informasi detail data Tugas Akhir.' : 'Masukkan judul skripsi dan nama dosen pembimbing Anda secara lengkap.' }}</p>
        </div>

        @if($isLocked)
            <div class="p-4 rounded-xl font-bold text-sm bg-amber-50 text-amber-800 border border-gray-200 shadow-sm">
                <i class="fa-solid fa-lock mr-1"></i> Data tidak dapat diubah karena pengajuan SKPI sedang diproses.
            </div>
        @endif

        @if(($mahasiswa->tugasAkhir->status ?? '') === 'approved')
            <div class="p-4 rounded-xl font-bold text-sm bg-emerald-50 text-emerald-700 border border-gray-200 shadow-sm">
                <i class="fa-solid fa-check-circle mr-1"></i> Data yang telah disetujui tidak dapat diubah.
            </div>
        @endif

        @if(($mahasiswa->tugasAkhir->status ?? '') === 'rejected')
            <div class="p-4 rounded-xl bg-red-100 text-red-800 font-bold text-sm border border-gray-200 shadow-sm">
                <span><i class="fa-solid fa-circle-exclamation mr-1"></i> Alasan ditolak:</span>
                {{ $mahasiswa->tugasAkhir->keterangan ?: '(Tidak ada catatan)' }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-xl bg-red-100 text-red-800 font-bold text-sm border border-gray-200 shadow-sm">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @include('partials.item_progress', ['steps' => $itemSteps, 'itemName' => 'Tugas Akhir'])

        @include('partials.overall_progress', ['steps' => $overallSteps])

        <div class="card p-6 md:p-8">
            <form action="{{ route('mahasiswa.tugas_akhir.update') }}" method="POST" class="form mb-6">
                @csrf

                <div>
                    <label for="judul" class="form-label fw-bold fw-bold">Judul Tugas Akhir / Skripsi</label>
                    <textarea name="judul" id="judul" rows="4" required class="form-control form-control-solid"
                        placeholder="Masukkan judul tugas akhir Anda dengan huruf kapital di awal kata..." {{ $readonly ? 'disabled' : '' }}>{{ old('judul', $mahasiswa->tugasAkhir->judul ?? '') }}</textarea>
                </div>

                <div class="form mb-4">
                    <label class="form-label fw-bold fw-bold">Dosen Pembimbing</label>
                    <div id="pembimbing-container" class="form mb-6">
                        @php
                            $pembimbingNames = [];
                            if ($mahasiswa->tugasAkhir) {
                                $pembimbingNames = collect($mahasiswa->tugasAkhir->pembimbingTugasAkhir)
                                    ->pluck('nama_dosen')
                                    ->toArray();
                            }
                            if (empty($pembimbingNames)) {
                                $pembimbingNames = [null, null];
                            } elseif (count($pembimbingNames) == 1) {
                                $pembimbingNames[] = null;
                            }
                        @endphp

                        @foreach($pembimbingNames as $index => $currentName)
                            <div class="flex items-center gap-3 pembimbing-row animate-fade-in">
                                <span class="text-xs font-bold text-gray-400 w-8 shrink-0 font-mono">#{{ $index + 1 }}</span>
                                <div class="flex-1">
                                    <input type="text" name="pembimbing[]" class="form-control form-control-solid select-pembimbing"
                                        value="{{ old("pembimbing.{$index}", $currentName) }}"
                                        placeholder="Nama Dosen Pembimbing..."
                                        {{ $index === 0 ? 'required' : '' }} {{ $readonly ? 'disabled' : '' }}>
                                </div>
                                @if($index >= 2 && !$readonly)
                                    <button type="button" class="btn btn-sm btn-danger btn-remove-pembimbing shrink-0" onclick="this.closest('.pembimbing-row').remove(); renumberPembimbing();">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @else
                                    <div class="w-10 shrink-0"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if(!$readonly)
                        <div class="flex justify-end mt-2">
                            <button type="button" id="btn-add-pembimbing" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-plus"></i> Tambah Dosen Pembimbing
                            </button>
                        </div>
                    @endif
                </div>

                @if(!$readonly)
                    <button type="submit" class="btn btn-primary w-100 font-bold py-3.5">Simpan Perubahan</button>
                @endif
            </form>
        </div>
    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@if(!$readonly)
<script>
    document.getElementById('btn-add-pembimbing').addEventListener('click', function() {
        const container = document.getElementById('pembimbing-container');
        const rows = container.getElementsByClassName('pembimbing-row');
        const nextIndex = rows.length + 1;

        const newRow = document.createElement('div');
        newRow.className = 'flex items-center gap-3 pembimbing-row animate-fade-in';
        
        newRow.innerHTML = `
            <span class="text-xs font-bold text-gray-400 w-8 shrink-0 font-mono">#${nextIndex}</span>
            <div class="flex-1">
                <input type="text" name="pembimbing[]" class="form-control form-control-solid select-pembimbing" placeholder="Nama Dosen Pembimbing...">
            </div>
            <button type="button" class="btn btn-sm btn-danger btn-remove-pembimbing shrink-0" onclick="this.closest('.pembimbing-row').remove(); renumberPembimbing();">
                <i class="fa-solid fa-trash"></i>
            </button>
        `;
        container.appendChild(newRow);
    });

    function renumberPembimbing() {
        const container = document.getElementById('pembimbing-container');
        const rows = container.getElementsByClassName('pembimbing-row');
        for (let i = 0; i < rows.length; i++) {
            const label = rows[i].querySelector('span');
            label.textContent = `#${i + 1}`;
            
            const existingBtn = rows[i].querySelector('.btn-remove-pembimbing');
            const placeholder = rows[i].querySelector('.w-10');
            
            if (i < 2) {
                if (existingBtn) {
                    const div = document.createElement('div');
                    div.className = 'w-10 shrink-0';
                    existingBtn.replaceWith(div);
                }
                const select = rows[i].querySelector('input');
                if (i === 0) {
                    select.setAttribute('required', 'required');
                } else {
                    select.removeAttribute('required');
                }
            } else {
                if (placeholder) {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'btn btn-sm btn-danger btn-remove-pembimbing shrink-0';
                    btn.onclick = function() { this.closest('.pembimbing-row').remove(); renumberPembimbing(); };
                    btn.innerHTML = '<i class="fa-solid fa-trash"></i>';
                    placeholder.replaceWith(btn);
                }
            }
        }
    }
</script>
@endif
@endsection
