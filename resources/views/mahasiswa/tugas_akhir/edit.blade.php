@extends('layout.main')
@section('title', $readonly ? 'Detail Tugas Akhir' : 'Ubah Tugas Akhir')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content flex-column-fluid mt-7">
                <div id="kt_app_content_container" class="app-container container-fluid">
                    <div class="card shadow-sm border border-dashed border-dark rounded">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-3 mb-1">
                                        <i class="fa-solid fa-graduation-cap text-primary me-2"></i>
                                        {{ $readonly ? 'Detail Tugas Akhir / Skripsi' : 'Ubah Data Tugas Akhir / Skripsi' }}
                                    </span>
                                </h3>
                            </div>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="card-body pt-5">
                            <div
                                class="alert bg-light-primary border border-dashed border-primary d-flex align-items-center p-5 mb-8">
                                <i class="fa-solid fa-circle-info fs-2hx text-primary me-4"></i>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-primary">Informasi Pengisian</h4>
                                    <span class="text-dark">Mohon perhatikan pedoman penulisan berikut:
                                        <ul class="mb-0 mt-2">
                                            <li><strong>Judul Tugas Akhir / Skripsi</strong> harus ditulis dengan awalan huruf kapital pada setiap awal kata (Title Case).</li>
                                            <li><strong>Nama Dosen Pembimbing</strong> harus ditulis secara lengkap dan benar beserta gelar akademiknya.</li>
                                        </ul>
                                    </span>
                                </div>
                            </div>
                            @if ($isLocked)
                                <div class="alert alert-warning d-flex align-items-center p-5 mb-8">
                                    <i class="fa-solid fa-lock fs-2hx text-warning me-4"></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-warning">Perhatian</h4>
                                        <span>Data tidak dapat diubah karena pengajuan SKPI sedang diproses.</span>
                                    </div>
                                </div>
                            @endif
                            @if (($mahasiswa->tugasAkhir->status ?? '') === 'approved')
                                <div class="alert alert-success d-flex align-items-center p-5 mb-8">
                                    <i class="fa-solid fa-check-circle fs-2hx text-success me-4"></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-success">Disetujui</h4>
                                        <span>Data yang telah disetujui tidak dapat diubah.</span>
                                    </div>
                                </div>
                            @endif
                            @if (($mahasiswa->tugasAkhir->status ?? '') === 'rejected')
                                <div class="alert alert-danger d-flex align-items-center p-5 mb-8">
                                    <i class="fa-solid fa-circle-exclamation fs-2hx text-danger me-4"></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-danger">Ditolak</h4>
                                        <span>Alasan ditolak:
                                            {{ $mahasiswa->tugasAkhir->keterangan ?: '(Tidak ada catatan)' }}</span>
                                    </div>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger p-5 mb-8">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form id="kt_tugas_akhir_form" action="{{ route('mahasiswa.tugas_akhir.update') }}" method="POST" class="form mb-0">
                                @csrf
                                <div class="fv-row mb-8">
                                    <label for="judul" class="form-label required fw-bold fs-6">Judul Tugas Akhir /
                                        Skripsi</label>
                                    <textarea name="judul" id="judul" rows="3" required class="form-control" {{ $readonly ? 'disabled' : '' }}>{{ old('judul', $mahasiswa->tugasAkhir->judul ?? '') }}</textarea>
                                </div>
                                @php
                                    $pembimbingNames = [];
                                    if ($mahasiswa->tugasAkhir) {
                                        $pembimbingNames = collect($mahasiswa->tugasAkhir->pembimbingTugasAkhir)
                                            ->pluck('nama_dosen')
                                            ->toArray();
                                    }
                                @endphp
                                <div class="row g-8 mb-8">
                                    <div class="col-md-6 fv-row">
                                        <label class="form-label required fw-bold fs-6">Dosen Pembimbing 1 (Utama)</label>
                                        <select name="pembimbing[0]" class="form-select" data-control="select2" data-placeholder="Pilih Dosen Pembimbing 1" required {{ $readonly ? 'disabled' : '' }}>
                                            <option value=""></option>
                                            @foreach($dosens as $dosen)
                                                <option value="{{ $dosen->nama_dosen }}" {{ (old('pembimbing.0', $pembimbingNames[0] ?? '')) == $dosen->nama_dosen ? 'selected' : '' }}>
                                                    {{ $dosen->nama_dosen }} {{ $dosen->nidn ? '('.$dosen->nidn.')' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 fv-row">
                                        <label class="form-label fw-bold fs-6">Dosen Pembimbing 2 (Pendamping)</label>
                                        <select name="pembimbing[1]" class="form-select" data-control="select2" data-placeholder="Pilih Dosen Pembimbing 2" data-allow-clear="true" {{ $readonly ? 'disabled' : '' }}>
                                            <option value=""></option>
                                            @foreach($dosens as $dosen)
                                                <option value="{{ $dosen->nama_dosen }}" {{ (old('pembimbing.1', $pembimbingNames[1] ?? '')) == $dosen->nama_dosen ? 'selected' : '' }}>
                                                    {{ $dosen->nama_dosen }} {{ $dosen->nidn ? '('.$dosen->nidn.')' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="form-text mt-2 text-muted">Opsional, biarkan kosong jika tidak ada pembimbing pendamping.</div>
                                    </div>
                                </div>
                                @if (!$readonly)
                                    <div class="separator my-10"></div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" id="kt_tugas_akhir_submit" class="btn btn-primary fw-bold px-8">
                                            <span class="indicator-label">
                                                <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                                            </span>
                                            <span class="indicator-progress">
                                                Menyimpan... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                            </div>
        </div>
    </div>
@endsection
@section('js')
@if (!$readonly)
<script>
    document.getElementById('kt_tugas_akhir_form').addEventListener('submit', function() {
        var btn = document.getElementById('kt_tugas_akhir_submit');
        btn.setAttribute('data-kt-indicator', 'on');
        btn.disabled = true;
    });
</script>
@endif
@endsection
