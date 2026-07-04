<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Fakultas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_create_fakultas" action="{{ route('fakultas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="nama_fakultas" class="form-label required fw-bolder text-dark fs-6">Nama
                                Fakultas</label>
                            <input type="text" name="nama_fakultas" id="nama_fakultas" required
                                class="form-control form-control-sm form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="kode_fakultas" class="form-label fw-bolder text-dark fs-6">Singkatan</label>
                            <input type="text" name="kode_fakultas" id="kode_fakultas"
                                class="form-control form-control-sm form-control-sm">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="dekan" class="form-label fw-bolder text-dark fs-6">Nama Dekan</label>
                            <input type="text" name="dekan" id="dekan"
                                class="form-control form-control-sm form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="nidn_dekan" class="form-label fw-bolder text-dark fs-6">NIDN Dekan</label>
                            <input type="text" name="nidn_dekan" id="nidn_dekan"
                                class="form-control form-control-sm form-control-sm">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="no_telepon" class="form-label fw-bolder text-dark fs-6">Telepon Fakultas</label>
                            <input type="text" name="no_telepon" id="no_telepon"
                                class="form-control form-control-sm form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label class="form-label required fw-bolder text-dark fs-6">Status</label>
                            <div class="d-flex align-items-center mt-3">
                                <div class="form-check form-check-custom form-check-sm me-5">
                                    <input class="form-check-input" type="radio" value="aktif" name="status"
                                        id="f_status_aktif" required checked />
                                    <label class="form-check-label text-dark" for="f_status_aktif">Aktif</label>
                                </div>
                                <div class="form-check form-check-custom form-check-sm">
                                    <input class="form-check-input" type="radio" value="nonaktif" name="status"
                                        id="f_status_nonaktif" required />
                                    <label class="form-check-label text-dark" for="f_status_nonaktif">Nonaktif</label>
                                </div>
                            </div>
                        </div>
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
