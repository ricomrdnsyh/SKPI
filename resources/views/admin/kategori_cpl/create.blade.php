<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Kategori CPL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_create_kategori_cpl" action="{{ route('kategori-cpl.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="kode_kategori" class="form-label required fw-bolder text-dark fs-6">Kode Kategori</label>
                        <input type="text" name="kode_kategori" id="kode_kategori" required class="form-control form-control-sm" placeholder="Contoh: S, KU, KK, P">
                    </div>
                    <div class="fv-row mb-5">
                        <label for="nama_kategori" class="form-label required fw-bolder text-dark fs-6">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" required class="form-control form-control-sm" placeholder="Contoh: Sikap / Keterampilan Umum / Pengetahuan">
                    </div>
                    <div class="fv-row mb-5">
                        <label for="urutan" class="form-label fw-bolder text-dark fs-6">Urutan</label>
                        <input type="number" name="urutan" id="urutan" class="form-control form-control-sm" placeholder="Contoh: 1 (opsional)">
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
