<div class="modal fade" id="form_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Sertifikat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="form_show_sertifikat" class="modal-body-container">
                
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="edit_nama_sertifikat" class="form-label  fw-bold fs-6">Nama Sertifikat / Pelatihan</label>
                        <input type="text" name="nama_sertifikat" id="show_nama_sertifikat"  class="form-control" placeholder="Contoh: Cisco Certified Network Associate" disabled>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_jenis_sertifikat" class="form-label  fw-bold fs-6">Jenis Sertifikat</label>
                            <select name="jenis_sertifikat" id="show_jenis_sertifikat"  class="form-select" data-control="select2" data-hide-search="true" disabled>
                                <option value="Keagamaan">Keagamaan</option>
                                <option value="Teknis">Teknis</option>
                                <option value="Bahasa">Bahasa</option>
                                <option value="Profesional">Profesional</option>
                            </select>
                        </div>

                        <div class="fv-row">
                            <label for="edit_bidang" class="form-label  fw-bold fs-6">Bidang Keahlian / Kompetensi</label>
                            <input type="text" name="bidang" id="show_bidang"  class="form-control" placeholder="Contoh: Keamanan Jaringan / Bahasa Inggris" disabled>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_penyelenggara" class="form-label  fw-bold fs-6">Penyelenggara</label>
                            <input type="text" name="penyelenggara" id="show_penyelenggara"  class="form-control" placeholder="Contoh: Cisco Networking Academy" disabled>
                        </div>

                        <div class="fv-row">
                            <label for="edit_tanggal_terbit" class="form-label  fw-bold fs-6">Tanggal Terbit</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="text" name="tanggal_terbit" id="show_tanggal_terbit"  class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="fv-row mb-5">
                        <label for="edit_file_bukti" class="form-label fw-bold fs-6">Unggah File Bukti Sertifikat (Opsional)</label>
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
