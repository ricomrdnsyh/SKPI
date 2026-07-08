<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Program Studi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_edit_prodi" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="edit_id_fakultas" class="form-label required fw-bolder text-dark fs-6">Fakultas</label>
                        <select name="id_fakultas" id="edit_id_fakultas" required class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Fakultas">
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id_fakultas }}">{{ $f->nama_fakultas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="edit_nama_prodi" class="form-label required fw-bolder text-dark fs-6">Nama Program Studi</label>
                            <input type="text" name="nama_prodi" id="edit_nama_prodi" required class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="edit_kode_prodi" class="form-label fw-bolder text-dark fs-6">Kode Prodi</label>
                            <input type="text" name="kode_prodi" id="edit_kode_prodi" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="edit_jenjang" class="form-label required fw-bolder text-dark fs-6">Jenjang</label>
                            <select name="jenjang" id="edit_jenjang" required class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Jenjang" data-dropdown-parent="#form_edit">
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="S1">S1</option>
                                <option value="D3">D3</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="edit_gelar" class="form-label fw-bolder text-dark fs-6">Gelar</label>
                            <input type="text" name="gelar" id="edit_gelar" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="edit_sk_akreditasi" class="form-label fw-bolder text-dark fs-6">SK Akreditasi</label>
                            <input type="text" name="sk_akreditasi" id="edit_sk_akreditasi" class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="edit_tanggal_sk_akreditasi" class="form-label fw-bolder text-dark fs-6">Tanggal SK</label>
                            <div class="position-relative d-flex align-items-center">
                                <i class="fas fa-calendar-alt position-absolute ms-3"></i>
                                <input type="text" name="tanggal_sk_akreditasi" id="edit_tanggal_sk_akreditasi" class="form-control form-control-sm ps-10">
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="edit_masa_berlaku_akreditasi" class="form-label fw-bolder text-dark fs-6">Masa Berlaku Akreditasi</label>
                            <div class="position-relative d-flex align-items-center">
                                <i class="fas fa-calendar-alt position-absolute ms-3"></i>
                                <input type="text" name="masa_berlaku_akreditasi" id="edit_masa_berlaku_akreditasi" class="form-control form-control-sm ps-10">
                            </div>
                        </div>
                        <div class="fv-row">
                            <label for="edit_jenjang_kkni" class="form-label fw-bolder text-dark fs-6">Jenjang KKNI</label>
                            <input type="text" name="jenjang_kkni" id="edit_jenjang_kkni" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="edit_bahasa_pengantar" class="form-label fw-bolder text-dark fs-6">Bahasa Pengantar</label>
                            <input type="text" name="bahasa_pengantar" id="edit_bahasa_pengantar" class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="edit_lama_studi" class="form-label fw-bolder text-dark fs-6">Lama Studi</label>
                            <input type="text" name="lama_studi" id="edit_lama_studi" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="edit_jenis_pendidikan" class="form-label fw-bolder text-dark fs-6">Jenis Pendidikan</label>
                            <input type="text" name="jenis_pendidikan" id="edit_jenis_pendidikan" class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="edit_jenis_pendidikan_lanjutan" class="form-label fw-bolder text-dark fs-6">Pendidikan Lanjutan</label>
                            <input type="text" name="jenis_pendidikan_lanjutan" id="edit_jenis_pendidikan_lanjutan" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="fv-row mb-5">
                        <label for="edit_persyaratan_penerimaan" class="form-label fw-bolder text-dark fs-6">Persyaratan Penerimaan</label>
                        <textarea name="persyaratan_penerimaan" id="edit_persyaratan_penerimaan" rows="2" class="form-control form-control-sm"></textarea>
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
