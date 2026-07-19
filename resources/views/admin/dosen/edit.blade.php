<div class="modal fade" id="modal_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_edit" class="form" action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label class="form-label required fw-bolder text-dark fs-6">Nama Dosen</label>
                        <input type="text" name="nama_dosen" id="edit_nama_dosen" class="form-control form-control-sm" placeholder="Nama Lengkap Dosen" required />
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label class="form-label fw-bolder text-dark fs-6">NIDN</label>
                            <input type="text" name="nidn" id="edit_nidn" class="form-control form-control-sm" placeholder="NIDN Dosen" />
                        </div>
                        <div class="fv-row">
                            <label class="form-label fw-bolder text-dark fs-6">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="edit_jenis_kelamin" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Pilih Jenis Kelamin" data-dropdown-parent="#modal_edit">
                                <option value=""></option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label class="form-label fw-bolder text-dark fs-6">No. Handphone</label>
                            <input type="text" name="no_hp" id="edit_no_hp" class="form-control form-control-sm" placeholder="No Handphone" />
                        </div>
                        <div class="fv-row">
                            <label class="form-label fw-bolder text-dark fs-6">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control form-control-sm" placeholder="Email Dosen" />
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label class="form-label fw-bolder text-dark fs-6">Fakultas</label>
                            <select name="id_fakultas" id="edit_id_fakultas" class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Fakultas" data-allow-clear="true" data-dropdown-parent="#modal_edit">
                                <option value=""></option>
                                @foreach ($fakultas as $f)
                                    <option value="{{ $f->id_fakultas }}">{{ $f->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row">
                            <label class="form-label fw-bolder text-dark fs-6">Program Studi</label>
                            <select name="id_prodi" id="edit_id_prodi" class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Prodi" data-allow-clear="true" data-dropdown-parent="#modal_edit">
                                <option value=""></option>
                                @foreach ($prodi as $p)
                                    <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btn_submit_edit" class="btn btn-sm btn-primary">
                        <span class="indicator-label">Update</span>
                        <span class="indicator-progress" style="display: none;">Tunggu sebentar... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
