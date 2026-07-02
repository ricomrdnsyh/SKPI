<div class="border-top border-gray-200 pt-7 px-7 pb-7 mt-5">
    @if ($hasPendingItems)
        <div class="alert bg-light-warning border border-warning d-flex flex-column p-5 mb-5">
            <h5 class="mb-2 text-warning"><i class="ki-duotone ki-information-5 fs-2 text-warning me-2"><span
                        class="path1"></span><span class="path2"></span><span class="path3"></span></i> Verifikasi
                Lulus Belum Dapat Diproses</h5>
            <span class="text-warning fw-semibold">Masih ada berkas pendukung atau Tugas Akhir berstatus pending yang
                perlu disetujui/ditolak terlebih dahulu.</span>
        </div>
    @endif
    @if ($hasNoTugasAkhir)
        <div class="alert bg-light-info border border-info d-flex flex-column p-5 mb-5">
            <h5 class="mb-2 text-info"><i class="ki-duotone ki-information fs-2 text-info me-2"><span
                        class="path1"></span><span class="path2"></span><span class="path3"></span></i> Informasi
                Tugas Akhir</h5>
            <span class="text-info fw-semibold">Data Tugas Akhir belum diisi. Verifikasi berkas pendukung dapat tetap
                diproses, namun TA wajib dilengkapi sebelum SKPI dicetak.</span>
        </div>
    @endif

    <div class="row g-3">
        <!-- Tombol Tolak Permanen -->
        <div class="col-12 col-md-4">
            <button type="button" class="btn btn-danger w-100 fw-bolder" data-bs-toggle="modal"
                data-bs-target="#modalTolak">
                <i class="ki-duotone ki-cross-circle fs-2"><span class="path1"></span><span class="path2"></span></i>
                Tolak Permanen
            </button>
        </div>

        <!-- Tombol Revisi -->
        <div class="col-12 col-md-4">
            <button type="button" class="btn btn-warning w-100 fw-bolder" data-bs-toggle="modal"
                data-bs-target="#modalRevisi">
                <i class="ki-duotone ki-question-class fs-2"><span class="path1"></span><span
                        class="path2"></span></i> Perlu Revisi
            </button>
        </div>

        <!-- Tombol Setujui -->
        <div class="col-12 col-md-4">
            <form action="{{ route('bak_fakultas.verifikasi.checklist', $pengajuan->id_pengajuan) }}" method="POST"
                class="m-0" id="formSetujui">
                @csrf
                <input type="hidden" name="hasil_verifikasi" value="lulus">
                <button type="button" class="btn btn-success w-100 fw-bolder" onclick="confirmSetujui()"
                    {{ $hasPendingItems ? 'disabled' : '' }}>
                    <i class="ki-duotone ki-check-circle fs-2"><span class="path1"></span><span
                            class="path2"></span></i> Setujui SKPI
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="modalTolak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form action="{{ route('bak_fakultas.verifikasi.checklist', $pengajuan->id_pengajuan) }}" method="POST"
                onsubmit="const b=this.querySelector('button[type=submit]');b.setAttribute('data-kt-indicator','on');b.disabled=true;">
                @csrf
                <input type="hidden" name="hasil_verifikasi" value="ditolak">
                <div class="modal-header pt-7 pb-0 px-lg-10 border-0 justify-content-between align-items-center">
                    <h3 class="fw-bolder text-gray-900 mb-0">Tolak Pengajuan</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body px-lg-10 pt-5 pb-10">
                    <div class="alert bg-light-warning border border-warning d-flex align-items-center p-4 mb-7">
                        <i class="ki-duotone ki-information-5 fs-2hx text-warning me-4"><span
                                class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <div class="d-flex flex-column">
                            <h6 class="text-warning mb-1">Konfirmasi Penolakan</h6>
                            <span class="text-warning fw-semibold fs-7">Mahasiswa akan menerima alasan penolakan
                                ini.</span>
                        </div>
                    </div>

                    <div class="d-flex flex-column mb-4 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Alasan Penolakan</span>
                        </label>
                        <textarea name="catatan" class="form-control" rows="4" required
                            placeholder="Contoh: Format surat salah, data tidak lengkap..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-lg-10 pb-10">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <span class="indicator-label">Tolak Pengajuan</span>
                        <span class="indicator-progress">Menolak... <span
                                class="spinner-border spinner-border-sm ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Revisi -->
<div class="modal fade" id="modalRevisi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form action="{{ route('bak_fakultas.verifikasi.checklist', $pengajuan->id_pengajuan) }}" method="POST"
                onsubmit="const b=this.querySelector('button[type=submit]');b.setAttribute('data-kt-indicator','on');b.disabled=true;">
                @csrf
                <input type="hidden" name="hasil_verifikasi" value="perlu_revisi">
                <div class="modal-header pt-7 pb-0 px-lg-10 border-0 justify-content-between align-items-center">
                    <h3 class="fw-bolder text-gray-900 mb-0">Kembalikan untuk Revisi</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body px-lg-10 pt-5 pb-10">
                    <div class="alert bg-light-warning border border-warning d-flex align-items-center p-4 mb-7">
                        <i class="ki-duotone ki-information-5 fs-2hx text-warning me-4"><span
                                class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <div class="d-flex flex-column">
                            <h6 class="text-warning mb-1">Konfirmasi Revisi</h6>
                            <span class="text-warning fw-semibold fs-7">Mahasiswa harus memperbaiki bagian yang
                                disebutkan sebelum mengajukan kembali.</span>
                        </div>
                    </div>

                    <div class="d-flex flex-column mb-4 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Catatan Revisi</span>
                        </label>
                        <textarea name="catatan" class="form-control" rows="4" required
                            placeholder="Tulis bagian apa saja yang perlu diperbaiki..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-lg-10 pb-10">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <span class="indicator-label">Revisi ke Mahasiswa</span>
                        <span class="indicator-progress">Memproses... <span
                                class="spinner-border spinner-border-sm ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
