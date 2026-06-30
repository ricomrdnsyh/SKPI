<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Program Studi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_create_prodi" action="{{ route('prodi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="id_fakultas" class="form-label required fw-bolder text-dark fs-6">Fakultas</label>
                        <select name="id_fakultas" id="id_fakultas" required class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Fakultas">
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id_fakultas }}">{{ $f->nama_fakultas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="nama_prodi" class="form-label required fw-bolder text-dark fs-6">Nama Program Studi</label>
                            <input type="text" name="nama_prodi" id="nama_prodi" required class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="kode_prodi" class="form-label fw-bolder text-dark fs-6">Kode Prodi</label>
                            <input type="text" name="kode_prodi" id="kode_prodi" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="jenjang" class="form-label required fw-bolder text-dark fs-6">Jenjang</label>
                            <select name="jenjang" id="jenjang" required class="form-select form-select-sm" data-control="select2" data-hide-search="true">
                                <option value="S1">S1</option>
                                <option value="D3">D3</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="gelar" class="form-label fw-bolder text-dark fs-6">Gelar</label>
                            <input type="text" name="gelar" id="gelar" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="sk_akreditasi" class="form-label fw-bolder text-dark fs-6">SK Akreditasi</label>
                            <input type="text" name="sk_akreditasi" id="sk_akreditasi" class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="tanggal_sk_akreditasi" class="form-label fw-bolder text-dark fs-6">Tanggal SK</label>
                            <div class="position-relative d-flex align-items-center">
                                <i class="fas fa-calendar-alt position-absolute ms-3"></i>
                                <input type="text" name="tanggal_sk_akreditasi" id="tanggal_sk_akreditasi" class="form-control form-control-sm ps-10">
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="masa_berlaku_akreditasi" class="form-label fw-bolder text-dark fs-6">Masa Berlaku Akreditasi</label>
                            <div class="position-relative d-flex align-items-center">
                                <i class="fas fa-calendar-alt position-absolute ms-3"></i>
                                <input type="text" name="masa_berlaku_akreditasi" id="masa_berlaku_akreditasi" class="form-control form-control-sm ps-10">
                            </div>
                        </div>
                        <div class="fv-row">
                            <label for="jenjang_kkni" class="form-label fw-bolder text-dark fs-6">Jenjang KKNI</label>
                            <input type="text" name="jenjang_kkni" id="jenjang_kkni" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="bahasa_pengantar" class="form-label fw-bolder text-dark fs-6">Bahasa Pengantar</label>
                            <input type="text" name="bahasa_pengantar" id="bahasa_pengantar" value="Indonesia" class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="lama_studi" class="form-label fw-bolder text-dark fs-6">Lama Studi</label>
                            <input type="text" name="lama_studi" id="lama_studi" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-5">
                        <div class="fv-row">
                            <label for="jenis_pendidikan" class="form-label fw-bolder text-dark fs-6">Jenis Pendidikan</label>
                            <input type="text" name="jenis_pendidikan" id="jenis_pendidikan" class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="jenis_pendidikan_lanjutan" class="form-label fw-bolder text-dark fs-6">Pendidikan Lanjutan</label>
                            <input type="text" name="jenis_pendidikan_lanjutan" id="jenis_pendidikan_lanjutan" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="fv-row mb-5">
                        <label for="persyaratan_penerimaan" class="form-label fw-bolder text-dark fs-6">Persyaratan Penerimaan</label>
                        <textarea name="persyaratan_penerimaan" id="persyaratan_penerimaan" rows="2" class="form-control form-control-sm"></textarea>
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
