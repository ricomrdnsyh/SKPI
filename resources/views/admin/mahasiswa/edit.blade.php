<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_edit_mahasiswa" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_nim" class="form-label required fw-bolder text-dark">NIM</label>
                            <input type="text" name="nim" id="edit_nim" required class="form-control form-control-sm" placeholder="Masukkan NIM">
                        </div>
                        <div class="fv-row">
                            <label for="edit_nama_lengkap" class="form-label required fw-bolder text-dark">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="edit_nama_lengkap" required class="form-control form-control-sm" placeholder="Nama lengkap sesuai ijazah">
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_id_prodi" class="form-label required fw-bolder text-dark">Program Studi</label>
                            <select name="id_prodi" id="edit_id_prodi" required class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Prodi">
                                <option value="">-- Pilih Prodi --</option>
                                @foreach($prodi as $p)
                                    <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="edit_id_kurikulum" class="form-label required fw-bolder text-dark">Kurikulum</label>
                            <select name="id_kurikulum" id="edit_id_kurikulum" required class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Kurikulum">
                                <option value="">-- Pilih Kurikulum --</option>
                                @foreach($kurikulums as $kur)
                                    <option value="{{ $kur->id_kurikulum }}">{{ $kur->nama_kurikulum }} ({{ $kur->tahun }}) - {{ $kur->prodi_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_tempat_lahir" class="form-label fw-bolder text-dark">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="edit_tempat_lahir" class="form-control form-control-sm" placeholder="Contoh: Probolinggo">
                        </div>
                        <div class="fv-row">
                            <label for="edit_tanggal_lahir" class="form-label fw-bolder text-dark">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_email" class="form-label fw-bolder text-dark">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control form-control-sm" placeholder="email@example.com">
                        </div>
                        <div class="fv-row">
                            <label for="edit_nomor_telepon" class="form-label fw-bolder text-dark">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon" id="edit_nomor_telepon" class="form-control form-control-sm" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="fv-row mb-6">
                        <label for="edit_password" class="form-label fw-bolder text-dark">Password Baru (Opsional)</label>
                        <input type="password" name="password" id="edit_password" class="form-control form-control-sm" placeholder="Minimal 6 karakter">
                        <div class="text-muted mt-2">Kosongkan jika tidak ingin mengubah password.</div>
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
