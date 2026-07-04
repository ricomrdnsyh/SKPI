<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_create_users" action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="fv-row mb-6">
                        <label for="username" class="form-label required fw-bolder text-dark">Username</label>
                        <input type="text" name="username" id="username" required
                            class="form-control form-control-sm">
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="nama_lengkap" class="form-label required fw-bolder text-dark">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" required
                                class="form-control form-control-sm">
                        </div>
                        <div class="fv-row">
                            <label for="email" class="form-label fw-bolder text-dark">Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="role" class="form-label required fw-bolder text-dark">Role</label>
                            <select name="role" id="role" required class="form-select form-select-sm"
                                data-control="select2" data-allow-clear="true" data-placeholder="Pilih Role">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="bak_fakultas">BAK Fakultas</option>
                            </select>
                        </div>
                        <div class="fv-row" id="fakultas-container">
                            <label for="id_fakultas" class="form-label fw-bolder text-dark">Hubungkan Fakultas</label>
                            <select name="id_fakultas" id="id_fakultas" class="form-select form-select-sm"
                                data-control="select2" data-allow-clear="true" data-placeholder="Pilih Fakultas">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach ($fakultas as $f)
                                    <option value="{{ $f->id_fakultas }}">
                                        {{ $f->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="password" class="form-label required fw-bolder text-dark">Password</label>
                            <input type="password" name="password" id="password" required
                                class="form-control form-control-sm" placeholder="Minimal 6 karakter">
                        </div>
                        <div class="fv-row">
                            <label class="form-label required fw-bolder text-dark">Status Akun</label>
                            <div class="d-flex align-items-center mt-3">
                                <div class="form-check form-check-custom form-check-sm me-5">
                                    <input class="form-check-input" type="radio" value="1" name="aktif"
                                        id="aktif_1" required checked />
                                    <label class="form-check-label" for="aktif_1">Aktif</label>
                                </div>
                                <div class="form-check form-check-custom form-check-sm">
                                    <input class="form-check-input" type="radio" value="0" name="aktif"
                                        id="aktif_0" required />
                                    <label class="form-check-label" for="aktif_0">Nonaktif</label>
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
