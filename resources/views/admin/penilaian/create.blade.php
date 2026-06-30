<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Penilaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_create_penilaian" action="{{ route('penilaian.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="nilai_huruf" class="form-label required fw-bolder text-dark fs-6">Nilai Huruf</label>
                        <input type="text" name="nilai_huruf" id="nilai_huruf" required class="form-control form-control-sm" placeholder="Contoh: A">
                    </div>
                    <div class="fv-row mb-5">
                        <label for="nilai_min" class="form-label required fw-bolder text-dark fs-6">Nilai Minimum</label>
                        <input type="number" step="0.01" min="0" max="100" name="nilai_min" id="nilai_min" required class="form-control form-control-sm" placeholder="Contoh: 85.00">
                    </div>
                    <div class="fv-row mb-5">
                        <label for="nilai_max" class="form-label required fw-bolder text-dark fs-6">Nilai Maksimum</label>
                        <input type="number" step="0.01" min="0" max="100" name="nilai_max" id="nilai_max" required class="form-control form-control-sm" placeholder="Contoh: 100.00">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" data-kt-contacts-type="submit" class="btn btn-sm btn-primary">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress" style="display: none;">
                            Tunggu sebentar...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
