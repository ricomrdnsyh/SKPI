<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Sertifikat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_create_sertifikat" action="{{ route('mahasiswa.sertifikat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if(in_array(Auth::user()->role, ['bak_fakultas', 'admin']))
                    <div class="fv-row mb-5">
                        <label for="nim_create" class="form-label required fw-bold fs-6">Pilih Mahasiswa</label>
                        <select name="nim" id="nim_create" required class="form-select" data-control="select2" data-placeholder="Pilih Mahasiswa" data-dropdown-parent="#form_create">
                            <option value=""></option>
                            @foreach($mahasiswas as $mhs)
                                <option value="{{ $mhs->nim }}">{{ $mhs->nim }} - {{ $mhs->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="fv-row mb-5">
                        <label for="nama_sertifikat" class="form-label required fw-bold fs-6">Nama Sertifikat / Pelatihan</label>
                        <input type="text" name="nama_sertifikat" id="nama_sertifikat" required class="form-control" placeholder="Contoh: Cisco Certified Network Associate">
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="jenis_sertifikat" class="form-label required fw-bold fs-6">Jenis Sertifikat</label>
                            <select name="jenis_sertifikat" id="jenis_sertifikat" required class="form-select" data-control="select2" data-hide-search="true">
                                <option value="Keagamaan">Keagamaan</option>
                                <option value="Teknis">Teknis</option>
                                <option value="Bahasa">Bahasa</option>
                                <option value="Profesional">Profesional</option>
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="bidang" class="form-label required fw-bold fs-6">Bidang Keahlian / Kompetensi</label>
                            <input type="text" name="bidang" id="bidang" required class="form-control" placeholder="Contoh: Keamanan Jaringan / Bahasa Inggris">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="penyelenggara" class="form-label required fw-bold fs-6">Penyelenggara</label>
                            <input type="text" name="penyelenggara" id="penyelenggara" required class="form-control" placeholder="Contoh: Cisco Networking Academy">
                        </div>
                        <div class="fv-row">
                            <label for="tanggal_terbit" class="form-label required fw-bold fs-6">Tanggal Terbit</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="text" name="tanggal_terbit" id="tanggal_terbit" value="{{ date('Y-m-d') }}" required class="form-control" placeholder="Pilih tanggal terbit">
                            </div>
                        </div>
                    </div>
                    <div class="fv-row mb-5">
                        <label for="file_bukti" class="form-label required fw-bold fs-6">Unggah File Bukti Sertifikat</label>
                        <div class="mt-1">
                            <label class="d-flex flex-column align-items-center justify-content-center p-5 border border-2 border-dashed border-primary rounded-3 cursor-pointer" style="background-color: #f1faff;">
                                <i class="fas fa-cloud-upload-alt text-primary fs-2x mb-2"></i>
                                <span class="text-primary fw-bolder fs-6 mb-1">Pilih file bukti dokumen</span>
                                <span class="text-muted fs-7 mb-2">atau klik untuk menelusuri file</span>
                                <span class="text-muted fs-8">Format: PDF / JPG / PNG, Maksimal 2MB</span>
                                <input type="file" name="file_bukti" id="file_bukti" required class="d-none" onchange="document.getElementById('file_name_display_create_sertifikat').textContent = this.files[0] ? this.files[0].name : ''; document.getElementById('file_name_display_create_sertifikat').style.display = this.files[0] ? 'inline-block' : 'none';">
                                <div id="file_name_display_create_sertifikat" class="mt-4 badge badge-light-success fs-6 py-2 px-4" style="display: none;"></div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" data-kt-contacts-type="submit" class="btn btn-sm btn-primary">
                        <span class="indicator-label"><i class="fas fa-save me-1"></i> Simpan</span>
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
