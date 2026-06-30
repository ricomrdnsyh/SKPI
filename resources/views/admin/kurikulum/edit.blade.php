<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Kurikulum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_edit_kurikulum" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="edit_id_prodi" class="form-label required fw-bolder text-dark fs-6">Program Studi</label>
                        <select name="id_prodi" id="edit_id_prodi" required class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Prodi">
                            <option value="">-- Pilih Prodi --</option>
                            @foreach($prodi as $p)
                                <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fv-row mb-5">
                        <label for="edit_nama_kurikulum" class="form-label required fw-bolder text-dark fs-6">Nama Kurikulum</label>
                        <input type="text" name="nama_kurikulum" id="edit_nama_kurikulum" required class="form-control form-control-sm" placeholder="Contoh: Kurikulum 2024">
                    </div>

                    <div class="fv-row mb-5">
                        <label for="edit_tahun" class="form-label required fw-bolder text-dark fs-6">Tahun Kurikulum</label>
                        <input type="number" name="tahun" id="edit_tahun" required class="form-control form-control-sm" placeholder="Contoh: 2024" min="2000" max="2099">
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
