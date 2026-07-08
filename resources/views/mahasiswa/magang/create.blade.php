<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_create_magang" action="{{ route('mahasiswa.magang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if(in_array(Auth::user()->role, ['bak_fakultas', 'admin']))
                    <div class="fv-row mb-5">
                        <label for="id_mahasiswa_create" class="form-label required fw-bold fs-6">Pilih Mahasiswa</label>
                        <select name="id_mahasiswa" id="id_mahasiswa_create" required class="form-select" data-control="select2" data-placeholder="Pilih Mahasiswa" data-dropdown-parent="#form_create">
                            <option value=""></option>
                            @foreach($mahasiswas as $mhs)
                                <option value="{{ $mhs->id_mahasiswa }}">{{ $mhs->nim }} - {{ $mhs->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="tempat_magang" class="form-label required fw-bold fs-6">Mitra Industri (Perusahaan)</label>
                            <input type="text" name="tempat_magang" id="tempat_magang" required class="form-control" placeholder="Contoh: PT. Sumber Jaya Makmur">
                        </div>
                        <div class="fv-row">
                            <label for="posisi" class="form-label required fw-bold fs-6">Posisi / Jabatan Intern</label>
                            <input type="text" name="posisi" id="posisi" required class="form-control" placeholder="Contoh: Junior Web Developer">
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="tanggal_mulai" class="form-label required fw-bold fs-6">Tanggal Mulai</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="text" name="tanggal_mulai" id="tanggal_mulai" value="{{ date('Y-m-d') }}" required class="form-control" placeholder="Pilih tanggal mulai">
                            </div>
                        </div>
                        <div class="fv-row">
                            <label for="tanggal_selesai" class="form-label required fw-bold fs-6">Tanggal Selesai</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="text" name="tanggal_selesai" id="tanggal_selesai" value="{{ date('Y-m-d') }}" required class="form-control" placeholder="Pilih tanggal selesai">
                            </div>
                        </div>
                    </div>
                    <div class="fv-row mb-5">
                        <label for="file_bukti" class="form-label required fw-bold fs-6">Unggah Sertifikat Magang / Nilai Akhir</label>
                        <input type="file" name="file_bukti" id="file_bukti" required class="form-control">
                        <div class="text-muted mt-2">Format: PDF / JPG / PNG, Maksimal 2MB.</div>
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
