<div class="modal fade" id="form_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="form_show_prestasi" class="modal-body-container">
                
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="edit_nama_prestasi" class="form-label  fw-bold fs-6">Nama Prestasi / Kegiatan</label>
                        <input type="text" name="nama_prestasi" id="show_nama_prestasi"  class="form-control" placeholder="Contoh: Juara 1 Web Design Nasional" disabled>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_tingkat" class="form-label  fw-bold fs-6">Tingkat Prestasi</label>
                            <select name="tingkat" id="show_tingkat"  class="form-select" data-control="select2" data-hide-search="true" disabled>
                                <option value="Internasional">Internasional</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Provinsi">Provinsi</option>
                                <option value="Lokal">Lokal / Kampus</option>
                            </select>
                        </div>

                        <div class="fv-row">
                            <label for="edit_peringkat" class="form-label  fw-bold fs-6">Peringkat / Penghargaan</label>
                            <input type="text" name="peringkat" id="show_peringkat"  class="form-control" placeholder="Contoh: Juara 1 / Best Paper" disabled>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_penyelenggara" class="form-label  fw-bold fs-6">Penyelenggara</label>
                            <input type="text" name="penyelenggara" id="show_penyelenggara"  class="form-control" placeholder="Contoh: Puspresnas Kemendikbud" disabled>
                        </div>

                        <div class="fv-row">
                            <label for="edit_tahun" class="form-label  fw-bold fs-6">Tahun Perolehan</label>
                            <input type="number" name="tahun" id="show_tahun"  class="form-control" placeholder="Contoh: 2026" disabled>
                        </div>
                    </div>

                    <div class="fv-row mb-5">
                        <label for="edit_file_bukti" class="form-label fw-bold fs-6">Unggah File Bukti (Opsional)</label>
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




