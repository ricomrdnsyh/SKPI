<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Sertifikat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_edit_sertifikat" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @if(Auth::user()->role === 'bak_fakultas')
                    <div class="fv-row mb-5">
                        <label for="id_mahasiswa_edit" class="form-label required fw-bold fs-6">Pilih Mahasiswa</label>
                        <select name="id_mahasiswa" id="id_mahasiswa_edit" required class="form-select" data-control="select2" data-placeholder="Pilih Mahasiswa" data-dropdown-parent="#form_edit">
                            <option value=""></option>
                            @foreach($mahasiswas as $mhs)
                                <option value="{{ $mhs->id_mahasiswa }}">{{ $mhs->nim }} - {{ $mhs->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="fv-row mb-5">
                        <label for="edit_nama_sertifikat" class="form-label required fw-bold fs-6">Nama Sertifikat / Pelatihan</label>
                        <input type="text" name="nama_sertifikat" id="edit_nama_sertifikat" required class="form-control" placeholder="Contoh: Cisco Certified Network Associate">
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_jenis_sertifikat" class="form-label required fw-bold fs-6">Jenis Sertifikat</label>
                            <select name="jenis_sertifikat" id="edit_jenis_sertifikat" required class="form-select" data-control="select2" data-hide-search="true">
                                <option value="Keagamaan">Keagamaan</option>
                                <option value="Teknis">Teknis</option>
                                <option value="Bahasa">Bahasa</option>
                                <option value="Profesional">Profesional</option>
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="edit_bidang" class="form-label required fw-bold fs-6">Bidang Keahlian / Kompetensi</label>
                            <input type="text" name="bidang" id="edit_bidang" required class="form-control" placeholder="Contoh: Keamanan Jaringan / Bahasa Inggris">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_penyelenggara" class="form-label required fw-bold fs-6">Penyelenggara</label>
                            <input type="text" name="penyelenggara" id="edit_penyelenggara" required class="form-control" placeholder="Contoh: Cisco Networking Academy">
                        </div>
                        <div class="fv-row">
                            <label for="edit_tanggal_terbit" class="form-label required fw-bold fs-6">Tanggal Terbit</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="text" name="tanggal_terbit" id="edit_tanggal_terbit" required class="form-control" placeholder="Pilih tanggal terbit">
                            </div>
                        </div>
                    </div>
                    <div class="fv-row mb-5">
                        <label for="edit_file_bukti" class="form-label fw-bold fs-6">Unggah File Bukti Sertifikat (Opsional)</label>
                        <input type="file" name="file_bukti" id="edit_file_bukti" class="form-control">
                        <div class="text-muted mt-2">Format: PDF / JPG / PNG, Maksimal 2MB. Kosongkan jika tidak ingin mengubah file.</div>
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
