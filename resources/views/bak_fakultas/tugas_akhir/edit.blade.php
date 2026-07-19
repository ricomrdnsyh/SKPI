<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data Tugas Akhir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="kt_modal_edit_form" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_tugas_akhir" id="edit_id_tugas_akhir">
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label for="edit_nim" class="form-label required fw-bold fs-6">Pilih Mahasiswa</label>
                        <select name="nim" id="edit_nim" required class="form-select"
                            data-control="select2" data-placeholder="Pilih Mahasiswa" data-dropdown-parent="#form_edit">
                            <option value=""></option>
                            @foreach ($mahasiswas as $mhs)
                                <option value="{{ $mhs->nim }}">{{ $mhs->nim }} - {{ $mhs->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fv-row mb-5">
                        <label for="edit_judul" class="form-label required fw-bold fs-6">Judul Tugas Akhir /
                            Skripsi</label>
                        <textarea class="form-control" name="judul" id="edit_judul" rows="3" required
                            placeholder="Judul Tugas Akhir..."></textarea>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-6 mb-6">
                        <div class="fv-row">
                            <label for="edit_pembimbing_1" class="form-label required fw-bold fs-6">Dosen Pembimbing 1 (Utama)</label>
                            <select name="pembimbing[0]" id="edit_pembimbing_1" required class="form-select" data-control="select2" data-placeholder="Pilih Pembimbing 1" data-dropdown-parent="#form_edit">
                                <option value=""></option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->nama_dosen }}">{{ $dosen->nama_dosen }} {{ $dosen->nidn ? '('.$dosen->nidn.')' : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row">
                            <label for="edit_pembimbing_2" class="form-label fw-bold fs-6">Dosen Pembimbing 2 (Pendamping)</label>
                            <select name="pembimbing[1]" id="edit_pembimbing_2" class="form-select" data-control="select2" data-placeholder="Pilih Pembimbing 2 (Opsional)" data-allow-clear="true" data-dropdown-parent="#form_edit">
                                <option value=""></option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->nama_dosen }}">{{ $dosen->nama_dosen }} {{ $dosen->nidn ? '('.$dosen->nidn.')' : '' }}</option>
                                @endforeach
                            </select>
                            <div class="text-muted mt-2">Biarkan kosong jika tidak ada pembimbing pendamping.</div>
                        </div>
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
