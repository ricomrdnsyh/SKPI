<div class="modal fade" id="form_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="form_show_magang" class="modal-body-container">
                <div class="modal-body">
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_tempat_magang" class="form-label  fw-bold fs-6">Mitra Industri (Perusahaan)</label>
                            <input type="text" name="tempat_magang" id="show_tempat_magang"  class="form-control" placeholder="Contoh: PT. Sumber Jaya Makmur" disabled>
                        </div>
                        <div class="fv-row">
                            <label for="edit_posisi" class="form-label  fw-bold fs-6">Posisi / Jabatan Intern</label>
                            <input type="text" name="posisi" id="show_posisi"  class="form-control" placeholder="Contoh: Junior Web Developer" disabled>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_tanggal_mulai" class="form-label  fw-bold fs-6">Tanggal Mulai</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="text" name="tanggal_mulai" id="show_tanggal_mulai"  class="form-control" disabled>
                            </div>
                        </div>
                        <div class="fv-row">
                            <label for="edit_tanggal_selesai" class="form-label  fw-bold fs-6">Tanggal Selesai</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="text" name="tanggal_selesai" id="show_tanggal_selesai"  class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="fv-row mb-5">
                        <label for="edit_file_bukti" class="form-label fw-bold fs-6">Unggah Sertifikat Magang / Nilai Akhir (Opsional)</label>
                        <div id="show_file_bukti_container" class="mt-2"></div>
                    </div>
                    <div class="fv-row mb-5">
                        <label class="form-label fw-bold fs-6">Status Pengajuan</label>
                        <input type="text" id="show_status" class="form-control" disabled>
                    </div>
                    <div class="fv-row mb-5">
                        <label class="form-label fw-bold fs-6">Keterangan / Alasan</label>
                        <textarea id="show_keterangan" class="form-control" rows="3" disabled></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
