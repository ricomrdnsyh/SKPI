<div class="modal fade" id="form_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Organisasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="form_show_organisasi" class="modal-body-container">
                
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="edit_nama_organisasi" class="form-label  fw-bold fs-6">Nama Organisasi</label>
                        <input type="text" name="nama_organisasi" id="show_nama_organisasi"  class="form-control" placeholder="Contoh: Himpunan Mahasiswa Teknik Informatika" disabled>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_tingkat" class="form-label  fw-bold fs-6">Tingkat Organisasi</label>
                            <select name="tingkat" id="show_tingkat"  class="form-select" data-control="select2" data-hide-search="true" disabled>
                                <option value="Internasional">Internasional</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Universitas">Universitas</option>
                                <option value="Fakultas">Fakultas</option>
                            </select>
                        </div>

                        <div class="fv-row">
                            <label for="edit_jabatan" class="form-label  fw-bold fs-6">Jabatan</label>
                            <input type="text" name="jabatan" id="show_jabatan"  class="form-control" placeholder="Contoh: Ketua / Sekretaris" disabled>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_tahun_mulai" class="form-label  fw-bold fs-6">Tahun Mulai</label>
                            <input type="number" name="tahun_mulai" id="show_tahun_mulai"  class="form-control" placeholder="Contoh: 2023" disabled>
                        </div>

                        <div class="fv-row">
                            <label for="edit_tahun_selesai" class="form-label fw-bold fs-6">Tahun Selesai</label>
                            <input type="number" name="tahun_selesai" id="show_tahun_selesai" class="form-control" placeholder="Contoh: 2024" disabled>
                            <div class="text-muted mt-2">Kosongkan jika masih aktif.</div>
                        </div>
                    </div>

                    <div class="fv-row mb-5">
                        <label for="edit_file_bukti" class="form-label fw-bold fs-6">Unggah SK / Surat Keterangan Bukti (Opsional)</label>
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




