<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Organisasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_create_organisasi" action="{{ route('mahasiswa.organisasi.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="nama_organisasi" class="form-label required fw-bold fs-6">Nama Organisasi</label>
                        <input type="text" name="nama_organisasi" id="nama_organisasi" required class="form-control"
                            placeholder="Contoh: Himpunan Mahasiswa Teknik Informatika">
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="tingkat" class="form-label required fw-bold fs-6">Tingkat Organisasi</label>
                            <select name="tingkat" id="tingkat" required class="form-select" data-control="select2"
                                data-hide-search="true">
                                <option value="Internasional">Internasional</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Universitas">Universitas</option>
                                <option value="Fakultas">Fakultas</option>
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="jabatan" class="form-label required fw-bold fs-6">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan" required class="form-control"
                                placeholder="Contoh: Ketua / Sekretaris">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="tahun_mulai" class="form-label required fw-bold fs-6">Tahun Mulai</label>
                            <input type="number" name="tahun_mulai" id="tahun_mulai" value="{{ date('Y') }}"
                                required class="form-control" placeholder="Contoh: 2023">
                        </div>
                        <div class="fv-row">
                            <label for="tahun_selesai" class="form-label fw-bold fs-6">Tahun Selesai</label>
                            <input type="number" name="tahun_selesai" id="tahun_selesai" class="form-control"
                                placeholder="Kosongkan jika masih aktif">
                        </div>
                    </div>
                    <div class="fv-row mb-5">
                        <label for="file_bukti" class="form-label required fw-bold fs-6">Unggah SK / Surat Keterangan
                            Bukti</label>
                        <input type="file" name="file_bukti" id="file_bukti" required class="form-control">
                        <div class="text-muted mt-2">Format: PDF / JPG / PNG, Maksimal 2MB.</div>
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
