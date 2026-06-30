<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data CPL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_edit_cpl" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="fv-row mb-6">
                        <label for="edit_id_prodi" class="form-label required fw-bolder text-dark">Program Studi</label>
                        <select name="id_prodi" id="edit_id_prodi" required class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Prodi">
                            <option value="">-- Pilih Prodi --</option>
                            @foreach($prodi as $p)
                                <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_id_kurikulum" class="form-label required fw-bolder text-dark">Kurikulum</label>
                            <select name="id_kurikulum" id="edit_id_kurikulum" required class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Kurikulum">
                                <option value="">-- Pilih Kurikulum --</option>
                                @foreach($kurikulums as $kur)
                                    <option value="{{ $kur->id_kurikulum }}">{{ $kur->nama_kurikulum }} ({{ $kur->tahun }}) - {{ $kur->prodi_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="edit_id_kategori" class="form-label required fw-bolder text-dark">Kategori CPL</label>
                            <select name="id_kategori" id="edit_id_kategori" required class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Kategori">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->kode_kategori }} - {{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="edit_kode_cpl" class="form-label required fw-bolder text-dark">Kode CPL</label>
                            <input type="text" name="kode_cpl" id="edit_kode_cpl" required class="form-control form-control-sm" placeholder="Contoh: CPL-S01">
                        </div>
                        <div class="fv-row">
                            <label for="edit_urutan" class="form-label fw-bolder text-dark">Urutan Tampil</label>
                            <input type="number" name="urutan" id="edit_urutan" class="form-control form-control-sm" placeholder="Contoh: 1">
                        </div>
                    </div>

                    <div class="fv-row mb-6">
                        <label for="edit_deskripsi_cpl" class="form-label required fw-bolder text-dark">Deskripsi CPL</label>
                        <textarea name="deskripsi_cpl" id="edit_deskripsi_cpl" rows="4" required class="form-control form-control-sm" placeholder="Ketik deskripsi capaian pembelajaran..."></textarea>
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
