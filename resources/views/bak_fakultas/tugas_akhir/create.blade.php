<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Tugas Akhir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_create_tugas_akhir" action="{{ route('bak_fakultas.tugas_akhir.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="nim_create" class="form-label required fw-bold fs-6">Pilih Mahasiswa</label>
                        <select name="nim" id="nim_create" required class="form-select" data-control="select2" data-placeholder="Pilih Mahasiswa" data-dropdown-parent="#form_create">
                            <option value=""></option>
                            @foreach($mahasiswas as $mhs)
                                <option value="{{ $mhs->nim }}">{{ $mhs->nim }} - {{ $mhs->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="fv-row mb-5">
                        <label for="judul_create" class="form-label required fw-bold fs-6">Judul Tugas Akhir / Skripsi</label>
                        <textarea class="form-control" name="judul" id="judul_create" rows="3" required placeholder="Judul Tugas Akhir..."></textarea>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="pembimbing_1_create" class="form-label required fw-bold fs-6">Dosen Pembimbing 1 (Utama)</label>
                            <input type="text" name="pembimbing[0]" id="pembimbing_1_create" required class="form-control" placeholder="Nama Pembimbing 1">
                        </div>
                        <div class="fv-row">
                            <label for="pembimbing_2_create" class="form-label fw-bold fs-6">Dosen Pembimbing 2 (Pendamping)</label>
                            <input type="text" name="pembimbing[1]" id="pembimbing_2_create" class="form-control" placeholder="Nama Pembimbing 2 (Opsional)">
                            <div class="text-muted mt-2">Biarkan kosong jika tidak ada pembimbing pendamping.</div>
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
