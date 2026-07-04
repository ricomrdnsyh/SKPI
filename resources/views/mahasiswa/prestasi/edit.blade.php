<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_edit_prestasi" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="edit_nama_prestasi" class="form-label required fw-bold fs-6">Nama Prestasi / Kegiatan</label>
                        <input type="text" name="nama_prestasi" id="edit_nama_prestasi" required class="form-control" placeholder="Contoh: Juara 1 Web Design Nasional">
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_tingkat" class="form-label required fw-bold fs-6">Tingkat Prestasi</label>
                            <select name="tingkat" id="edit_tingkat" required class="form-select" data-control="select2" data-hide-search="true">
                                <option value="Internasional">Internasional</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Provinsi">Provinsi</option>
                                <option value="Lokal">Lokal / Kampus</option>
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="edit_peringkat" class="form-label required fw-bold fs-6">Peringkat / Penghargaan</label>
                            <input type="text" name="peringkat" id="edit_peringkat" required class="form-control" placeholder="Contoh: Juara 1 / Best Paper">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_penyelenggara" class="form-label required fw-bold fs-6">Penyelenggara</label>
                            <input type="text" name="penyelenggara" id="edit_penyelenggara" required class="form-control" placeholder="Contoh: Puspresnas Kemendikbud">
                        </div>
                        <div class="fv-row">
                            <label for="edit_tahun" class="form-label required fw-bold fs-6">Tahun Perolehan</label>
                            <input type="number" name="tahun" id="edit_tahun" required class="form-control" placeholder="Contoh: 2026">
                        </div>
                    </div>
                    <div class="fv-row mb-5">
                        <label for="edit_file_bukti" class="form-label fw-bold fs-6">Unggah File Bukti (Opsional)</label>
                        <input type="file" name="file_bukti" id="edit_file_bukti" class="form-control">
                        <div class="text-muted mt-2">Format: PDF / JPG / PNG, Maksimal 2MB. Kosongkan jika tidak ingin mengubah file bukti.</div>
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
