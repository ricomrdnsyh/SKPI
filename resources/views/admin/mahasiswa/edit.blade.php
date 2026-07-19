<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_edit_mahasiswa" action="" method="POST" enctype="multipart/form-data">
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
                            <select name="id_prodi" id="edit_id_prodi" required class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#form_edit" data-placeholder="Pilih Prodi">
                                <option value="">-- Pilih Prodi --</option>
                                @foreach($prodi as $p)
                                    <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="edit_id_kurikulum" class="form-label required fw-bolder text-dark">Kurikulum</label>
                            <select name="id_kurikulum" id="edit_id_kurikulum" required class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#form_edit" data-placeholder="Pilih Kurikulum">
                                <option value="">-- Pilih Kurikulum --</option>
                                @foreach($kurikulums as $kur)
                                    <option value="{{ $kur->id_kurikulum }}">{{ $kur->nama_kurikulum }} - {{ $kur->prodi_nama }}</option>
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
                            <div class="position-relative d-flex align-items-center">
                                <i class="fas fa-calendar-alt position-absolute ms-4 fs-5 text-gray-500"></i>
                                <input class="form-control form-control-sm ps-12" placeholder="Pilih tanggal" id="edit_tanggal_lahir" name="tanggal_lahir" type="text">
                            </div>
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
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_tahun_masuk" class="form-label fw-bolder text-dark">Tahun Masuk</label>
                            <input type="number" name="tahun_masuk" id="edit_tahun_masuk" class="form-control form-control-sm" placeholder="Contoh: 2023">
                        </div>
                        <div class="fv-row">
                            <label for="edit_status" class="form-label fw-bolder text-dark">Status</label>
                            <select name="status" id="edit_status" class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#form_edit" data-placeholder="Pilih Status">
                                <option value="Aktif">Aktif</option>
                                <option value="Lulus">Lulus</option>
                            </select>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_tahun_lulus" class="form-label fw-bolder text-dark">Tahun Lulus</label>
                            <input type="number" name="tahun_lulus" id="edit_tahun_lulus" class="form-control form-control-sm" placeholder="Contoh: 2027">
                        </div>
                        <div class="fv-row">
                            <label for="edit_tanggal_lulus" class="form-label fw-bolder text-dark">Tanggal Lulus</label>
                            <div class="position-relative d-flex align-items-center">
                                <i class="fas fa-calendar-alt position-absolute ms-4 fs-5 text-gray-500"></i>
                                <input class="form-control form-control-sm ps-12" placeholder="Pilih tanggal" id="edit_tanggal_lulus" name="tanggal_lulus" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_ipk" class="form-label fw-bolder text-dark">IPK</label>
                            <input type="number" step="0.01" max="4.00" name="ipk" id="edit_ipk" class="form-control form-control-sm" placeholder="Contoh: 3.85">
                        </div>
                        <div class="fv-row">
                            <label for="edit_foto" class="form-label fw-bolder text-dark">Foto (Opsional)</label>
                            <input type="file" name="foto" id="edit_foto" class="form-control form-control-sm" accept="image/*">
                            <div class="text-muted mt-2">Biarkan kosong jika tidak ingin mengubah foto.</div>
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
