<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Penilaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_edit_penilaian" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="edit_nilai_huruf" class="form-label required fw-bolder text-dark fs-6">Nilai Huruf</label>
                        <input type="text" name="nilai_huruf" id="edit_nilai_huruf" required class="form-control form-control-sm" placeholder="Contoh: A">
                    </div>
                    <div class="fv-row mb-5">
                        <label for="edit_nilai_min" class="form-label required fw-bolder text-dark fs-6">Nilai Minimum</label>
                        <input type="number" step="0.01" min="0" max="100" name="nilai_min" id="edit_nilai_min" required class="form-control form-control-sm" placeholder="Contoh: 85.00">
                    </div>
                    <div class="fv-row mb-5">
                        <label for="edit_nilai_max" class="form-label required fw-bolder text-dark fs-6">Nilai Maksimum</label>
                        <input type="number" step="0.01" min="0" max="100" name="nilai_max" id="edit_nilai_max" required class="form-control form-control-sm" placeholder="Contoh: 100.00">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" data-kt-contacts-type="submit" class="btn btn-sm btn-primary">
                        <span class="indicator-label">Update</span>
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
