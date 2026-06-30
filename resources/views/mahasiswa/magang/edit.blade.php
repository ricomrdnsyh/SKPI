<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_edit_magang" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_tempat_magang" class="form-label required fw-bold fs-6">Mitra Industri (Perusahaan)</label>
                            <input type="text" name="tempat_magang" id="edit_tempat_magang" required class="form-control form-control-solid" placeholder="Contoh: PT. Sumber Jaya Makmur">
                        </div>

                        <div class="fv-row">
                            <label for="edit_posisi" class="form-label required fw-bold fs-6">Posisi / Jabatan Intern</label>
                            <input type="text" name="posisi" id="edit_posisi" required class="form-control form-control-solid" placeholder="Contoh: Junior Web Developer">
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_tanggal_mulai" class="form-label required fw-bold fs-6">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" required class="form-control form-control-solid">
                        </div>

                        <div class="fv-row">
                            <label for="edit_tanggal_selesai" class="form-label required fw-bold fs-6">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" required class="form-control form-control-solid">
                        </div>
                    </div>

                    <div class="fv-row mb-5">
                        <label for="edit_file_bukti" class="form-label fw-bold fs-6">Unggah Sertifikat Magang / Nilai Akhir (Opsional)</label>
                        <input type="file" name="file_bukti" id="edit_file_bukti" class="form-control form-control-solid">
                        <div class="text-muted mt-2">Format: PDF / JPG / PNG, Maksimal 2MB. Kosongkan jika tidak ingin mengubah file bukti.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
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
