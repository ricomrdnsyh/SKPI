<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_create_prestasi" action="{{ route('mahasiswa.prestasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="nama_prestasi" class="form-label required fw-bold fs-6">Nama Prestasi / Kegiatan</label>
                        <input type="text" name="nama_prestasi" id="nama_prestasi" required class="form-control" placeholder="Contoh: Juara 1 Web Design Nasional">
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="tingkat" class="form-label required fw-bold fs-6">Tingkat Prestasi</label>
                            <select name="tingkat" id="tingkat" required class="form-select" data-control="select2" data-hide-search="true">
                                <option value="Internasional">Internasional</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Provinsi">Provinsi</option>
                                <option value="Lokal">Lokal / Kampus</option>
                            </select>
                        </div>

                        <div class="fv-row">
                            <label for="peringkat" class="form-label required fw-bold fs-6">Peringkat / Penghargaan</label>
                            <input type="text" name="peringkat" id="peringkat" required class="form-control" placeholder="Contoh: Juara 1 / Best Paper">
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="penyelenggara" class="form-label required fw-bold fs-6">Penyelenggara</label>
                            <input type="text" name="penyelenggara" id="penyelenggara" required class="form-control" placeholder="Contoh: Puspresnas Kemendikbud">
                        </div>

                        <div class="fv-row">
                            <label for="tahun" class="form-label required fw-bold fs-6">Tahun Perolehan</label>
                            <input type="number" name="tahun" id="tahun" required class="form-control" placeholder="Contoh: 2026">
                        </div>
                    </div>

                    <div class="fv-row mb-5">
                        <label for="file_bukti" class="form-label required fw-bold fs-6">Unggah File Bukti</label>
                        <input type="file" name="file_bukti" id="file_bukti" required class="form-control">
                        <div class="text-muted mt-2">Format: PDF / JPG / PNG, Maksimal 2MB</div>
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

