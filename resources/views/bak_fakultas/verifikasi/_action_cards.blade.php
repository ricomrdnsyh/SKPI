@if (in_array(Auth::user()->role, ['bak_fakultas', 'admin']))
    @php
        $prevPengajuanApprovals = \App\Models\Approval::where('approvable_type', 'pengajuan_skpi')
            ->where('approvable_id', $pengajuan->id_pengajuan)
            ->get();
        $pengajuanCycleCount = $prevPengajuanApprovals->where('role', 'baak')->count();
        $isResubmission = $pengajuanCycleCount > 0;
    @endphp
    @if ($isResubmission && $pengajuan->status === 'diajukan' && !$pengajuan->diverifikasi_oleh)
        <div
            class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-5">
            <i class="ki-duotone ki-arrows-circle fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span
                    class="path2"></span></i>
            <div class="d-flex flex-column pe-0 pe-sm-10">
                <h5 class="mb-1 text-primary">Pengajuan Ulang (Siklus ke-{{ $pengajuanCycleCount + 1 }})</h5>
                <span>Mahasiswa telah memperbaiki data dan mengajukan ulang. Semua item perlu diverifikasi ulang.</span>
            </div>
        </div>
    @endif
    @if ($pengajuan->status === 'verifikasi' && $pengajuan->permohonan_cetak && !$pengajuan->skpi)
        <div class="card border border-success border-dashed mb-5">
            <div class="card-body p-6">
                <h4 class="mb-3 text-success"><i class="ki-duotone ki-printer fs-2 text-success me-2"><span
                            class="path1"></span><span class="path2"></span><span class="path3"></span><span
                            class="path4"></span><span class="path5"></span></i> Proses & Terbitkan SKPI</h4>
                <p class="text-muted fs-6 mb-5">Mahasiswa telah mengajukan permohonan cetak. Masukkan nomor ijazah
                    nasional dan status profesi (opsional) untuk menerbitkan SKPI.</p>
                <form action="{{ route('bak_fakultas.verifikasi.publish', $pengajuan->id_pengajuan) }}" method="POST">
                    @csrf
                    <div class="row mb-5">
                        <div class="col-md-6 mb-5 mb-md-0">
                            <label for="nim_ijazah" class="required form-label fw-bold">Nomor Ijazah Nasional (NIM
                                Ijazah)</label>
                            <input type="text" name="nim_ijazah" id="nim_ijazah"
                                class="form-control form-control-solid"
                                value="{{ old('nim_ijazah', $mahasiswa->nim ?? '') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="status_profesi" class="form-label fw-bold">Status Profesi (Opsional)</label>
                            <input type="text" name="status_profesi" id="status_profesi"
                                class="form-control form-control-solid"
                                value="{{ old('status_profesi', 'Belum ada keanggotaan profesi') }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bolder">
                        <i class="ki-duotone ki-badge fs-2"><span class="path1"></span><span
                                class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                class="path5"></span></i> Terbitkan & Cetak SKPI
                    </button>
                </form>
            </div>
        </div>
    @endif
    @if ($pengajuan->status === 'dicetak')
        <div class="card border border-success border-dashed mb-5">
            <div class="card-body p-6">
                <h4 class="mb-3 text-success"><i class="ki-duotone ki-printer fs-2 text-success me-2"><span
                            class="path1"></span><span class="path2"></span><span class="path3"></span><span
                            class="path4"></span><span class="path5"></span></i> Cetak Ulang / Batalkan SKPI</h4>
                <p class="text-muted fs-6 mb-5">SKPI sudah diterbitkan. Klik tombol di bawah untuk mencetak ulang
                    dokumen PDF.</p>
                <a href="{{ route('bak_fakultas.skpi.print', $pengajuan->id_pengajuan) }}?nim_ijazah={{ urlencode($mahasiswa->skpi->nim_ijazah ?? '') }}"
                    target="_blank" class="btn btn-success w-100 fw-bolder mb-6">
                    <i class="ki-duotone ki-file-down fs-2"><span class="path1"></span><span class="path2"></span></i>
                    Cetak Ulang PDF
                </a>
                <div class="separator separator-dashed mb-6"></div>
                <div class="alert bg-light-danger border border-danger d-flex flex-column p-5">
                    <h5 class="mb-2 text-danger"><i class="ki-duotone ki-shield-cross fs-2 text-danger me-2"><span
                                class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        Batalkan Cetak SKPI</h5>
                    <p class="text-danger fw-semibold fs-7 mb-4">Jika dibatalkan, status akan dikembalikan ke Draft agar
                        mahasiswa dapat menambah/mengubah data. Dokumen SKPI yang sudah diterbitkan akan dihapus.</p>
                    <form action="{{ route('bak_fakultas.verifikasi.cancel_print', $pengajuan->id_pengajuan) }}"
                        method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan cetak SKPI ini?')">
                        @csrf
                        <textarea name="catatan" required class="form-control form-control-solid mb-4" rows="3"
                            placeholder="Alasan pembatalan cetak (wajib diisi)..."></textarea>
                        <button type="submit" class="btn btn-danger w-100 fw-bolder">
                            <i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span
                                    class="path2"></span><span class="path3"></span><span
                                    class="path4"></span><span class="path5"></span></i> Batalkan & Kembalikan ke
                            Draft
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @if ($pengajuan->status === 'draft')
        <div
            class="alert alert-dismissible bg-light-warning border border-warning d-flex flex-column flex-sm-row p-5 mb-5">
            <i class="ki-duotone ki-message-edit fs-2hx text-warning me-4 mb-5 mb-sm-0"><span
                    class="path1"></span><span class="path2"></span></i>
            <div class="d-flex flex-column pe-0 pe-sm-10">
                <h5 class="mb-1 text-warning">Menunggu Revisi Mahasiswa</h5>
                <span>Pengajuan ditandai perlu revisi. Menunggu mahasiswa memperbaiki data dan mengajukan ulang.</span>
                @if ($pengajuan->catatan_bak)
                    <div class="bg-warning bg-opacity-10 rounded border border-warning border-opacity-50 p-3 mt-3">
                        <div class="fw-bolder text-warning mb-1">Catatan:</div>
                        <div class="text-gray-800">{{ $pengajuan->catatan_bak }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif
    @if ($pengajuan->status === 'ditolak')
        <div
            class="alert alert-dismissible bg-light-danger border border-danger d-flex flex-column flex-sm-row p-5 mb-5">
            <i class="ki-duotone ki-cross-circle fs-2hx text-danger me-4 mb-5 mb-sm-0"><span
                    class="path1"></span><span class="path2"></span></i>
            <div class="d-flex flex-column pe-0 pe-sm-10">
                <h5 class="mb-1 text-danger">Pengajuan Ditolak</h5>
                <span>Pengajuan cetak SKPI ini telah ditolak. Menunggu mahasiswa mengajukan ulang.</span>
                @if ($pengajuan->catatan_bak)
                    <div class="bg-danger bg-opacity-10 rounded border border-danger border-opacity-50 p-3 mt-3">
                        <div class="fw-bolder text-danger mb-1">Alasan:</div>
                        <div class="text-gray-800">{{ $pengajuan->catatan_bak }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endif
