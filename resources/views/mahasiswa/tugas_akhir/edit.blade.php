@extends('layout.main')
@section('title', $readonly ? 'Detail Tugas Akhir' : 'Tugas Akhir')
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
                                    {{ $readonly ? 'Detail Tugas Akhir / Skripsi' : 'Data Tugas Akhir / Skripsi' }}
                                </span>
                            </h3>
                        </div>
                    </div>
                    <div class="separator my-2"></div>
                    <div class="card-body pt-5">
                        <form id="kt_tugas_akhir_form" action="{{ route('mahasiswa.tugas_akhir.update') }}" method="POST"
                            class="form mb-0">
                            @csrf
                            <div class="fv-row mb-8">
                                <label class="form-label fw-bold fs-6">Judul Tugas Akhir / Skripsi</label>
                                <textarea name="judul" rows="3" class="form-control" disabled>{{ $judulApi ?? '' }}</textarea>
                            </div>

                            <div class="row g-8 mb-8">
                                <div class="col-md-6 fv-row">
                                    <label class="form-label fw-bold fs-6">Dosen Pembimbing 1 (Utama)</label>
                                    <input type="text" name="pembimbing[0]" class="form-control"
                                        value="{{ $pembimbingNames[0] ?? '' }}" disabled>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="form-label fw-bold fs-6">Dosen Pembimbing 2 (Pendamping)</label>
                                    <input type="text" name="pembimbing[1]" class="form-control"
                                        value="{{ $pembimbingNames[1] ?? '' }}" disabled>
                                </div>
                            </div>
                            @if (!$readonly && (!isset($mahasiswa->tugasAkhir) || $mahasiswa->tugasAkhir->status === 'rejected'))
                                <div class="separator my-10"></div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" id="kt_tugas_akhir_submit" class="btn btn-primary fw-bold px-8">
                                        <span class="indicator-label">
                                            <i class="fa-solid fa-save me-2"></i> Simpan & Ajukan
                                        </span>
                                        <span class="indicator-progress">
                                            Menyimpan... <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
