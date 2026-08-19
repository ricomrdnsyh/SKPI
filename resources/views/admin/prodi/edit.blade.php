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
                        <label for="edit_id_fakultas"
                            class="form-label required fw-bolder text-dark fs-6">Fakultas</label>
                        <select name="id_fakultas" id="edit_id_fakultas" required class="form-select form-select-sm"
                            data-control="select2" data-placeholder="Pilih Fakultas">
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach ($fakultas as $f)
                                <option value="{{ $f->id_fakultas }}">{{ $f->nama_fakultas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="edit_nama_prodi" class="form-label required fw-bolder text-dark fs-6">Nama
                                Program Studi</label>
                            <input type="text" name="nama_prodi" id="edit_nama_prodi" required
                                class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="edit_kode_prodi" class="form-label required fw-bolder text-dark fs-6">Singkatan</label>
                            <input type="text" name="kode_prodi" id="edit_kode_prodi" required
                                class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="edit_jenjang"
                                class="form-label required fw-bolder text-dark fs-6">Jenjang</label>
                            <select name="jenjang" id="edit_jenjang" required class="form-select form-select-sm"
                                data-control="select2" data-placeholder="Pilih Jenjang"
                                data-dropdown-parent="#form_edit">
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="Diploma 3">Diploma 3</option>
                                <option value="Strata 1">Strata 1</option>
                                <option value="Strata 2">Strata 2</option>
                                <option value="Strata 3">Strata 3</option>
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="edit_gelar" class="form-label required fw-bolder text-dark fs-6">Gelar</label>
                            <input type="text" name="gelar" id="edit_gelar" required class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="edit_jenjang_kkni" class="form-label required fw-bolder text-dark fs-6">Jenjang
                                KKNI</label>
                            <input type="text" name="jenjang_kkni" id="edit_jenjang_kkni" required
                                class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="edit_bahasa_pengantar" class="form-label required fw-bolder text-dark fs-6">Bahasa
                                Pengantar</label>
                            <input type="text" name="bahasa_pengantar" id="edit_bahasa_pengantar" required
                                class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="edit_lama_studi" class="form-label required fw-bolder text-dark fs-6">Lama Studi</label>
                            <input type="text" name="lama_studi" id="edit_lama_studi" required
                                class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="edit_jenis_pendidikan" class="form-label required fw-bolder text-dark fs-6">Jenis
                                Pendidikan</label>
                            <select name="jenis_pendidikan" id="edit_jenis_pendidikan" required
                                class="form-select form-select-sm" data-control="select2"
                                data-placeholder="Pilih Jenis Pendidikan" data-dropdown-parent="#form_edit">
                                <option value="">-- Pilih Jenis Pendidikan --</option>
                                <option value="Diploma 3">Diploma 3</option>
                                <option value="Sarjana">Sarjana</option>
                                <option value="Magister">Magister</option>
                                <option value="Doktor">Doktor</option>
                            </select>
                        </div>
                    </div>
                    <div class="fv-row mb-5">
                        <label for="edit_jenis_pendidikan_lanjutan"
                            class="form-label required fw-bolder text-dark fs-6">Pendidikan Lanjutan</label>
                        <input type="text" name="jenis_pendidikan_lanjutan" id="edit_jenis_pendidikan_lanjutan" required
                            class="form-control form-control-sm">
                    </div>

                    <div class="fv-row mb-5">
                        <label for="edit_persyaratan_penerimaan"
                            class="form-label required fw-bolder text-dark fs-6">Persyaratan Penerimaan</label>
                        <textarea name="persyaratan_penerimaan" id="edit_persyaratan_penerimaan" rows="2" required
                            class="form-control form-control-sm"></textarea>
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
