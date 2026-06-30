@if (Auth::user()->role === 'bak_fakultas')
    @php
        $prevPengajuanApprovals = \App\Models\Approval::where('approvable_type', 'pengajuan_skpi')
            ->where('approvable_id', $pengajuan->id_pengajuan)
            ->get();
        $pengajuanCycleCount = $prevPengajuanApprovals->where('role', 'baak')->count();
        $isResubmission = $pengajuanCycleCount > 0;
    @endphp

    @if($isResubmission && $pengajuan->status === 'diajukan' && !$pengajuan->diverifikasi_oleh)
        <div class="card p-5 animate-scale-in" style="border-color: #8b5cf6; background: linear-gradient(135deg, #f5f3ff, #ede9fe);">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-1 bg-violet-600 text-white text-[10px] font-bold rounded-lg">
                    <i class="fa-solid fa-rotate mr-1"></i> Pengajuan Ulang (Siklus ke-{{ $pengajuanCycleCount + 1 }})
                </span>
            </div>
            <p class="text-xs text-violet-800 font-medium">Mahasiswa telah memperbaiki data dan mengajukan ulang. Semua item perlu diverifikasi ulang.</p>
        </div>
    @endif

    @if ($pengajuan->status === 'diajukan' && !$pengajuan->diverifikasi_oleh)
        @if (!empty($hasPendingItems))
            <div class="card p-6 animate-scale-in" style="border-color: #f59e0b;">
                <h4 class="section-accent mb-3"><i class="fa-solid fa-triangle-exclamation text-amber-600"></i> Verifikasi Item Belum Selesai</h4>
                <p class="text-xs text-gray-600 font-medium">Anda harus memverifikasi (approve/reject) semua item Prestasi, Organisasi, Sertifikat, Magang, dan Tugas Akhir terlebih dahulu sebelum dapat menyetujui pengajuan cetak SKPI.</p>
            </div>
        @else
            <div class="card p-6 animate-scale-in" style="border-color: #3b82f6;">
                <h4 class="section-accent mb-3"><i class="fa-solid fa-check-circle text-blue-600"></i> Verifikasi Pengajuan Cetak</h4>
                <p class="text-xs text-gray-600 font-medium mb-4">Semua item telah diverifikasi. Setujui atau tolak pengajuan cetak SKPI ini.</p>
                <div class="flex gap-3">
                    <form action="{{ route('bak_fakultas.pengajuan_cetak.approve', $pengajuan->id_pengajuan) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-check mr-1"></i> Setujui
                        </button>
                    </form>
                    <form action="{{ route('bak_fakultas.pengajuan_cetak.reject', $pengajuan->id_pengajuan) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="keterangan" required class="form-control form-control-solid text-xs w-44" placeholder="Alasan tolak...">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-xmark mr-1"></i> Tolak
                        </button>
                    </form>
                </div>
            </div>
        @endif
    @endif

    @if ($pengajuan->status === 'verifikasi' && $pengajuan->permohonan_cetak && !$pengajuan->skpi)
        <div class="card p-6 animate-scale-in" style="border-color: #22c55e;">
            <h4 class="section-accent mb-3"><i class="fa-solid fa-print text-emerald-600"></i> Proses & Terbitkan SKPI</h4>
            <p class="text-xs text-gray-600 font-medium mb-4">Mahasiswa telah mengajukan permohonan cetak. Masukkan nomor ijazah nasional dan status profesi (opsional) untuk menerbitkan SKPI.</p>
            <form action="{{ route('bak_fakultas.verifikasi.publish', $pengajuan->id_pengajuan) }}" method="POST" class="form mb-6">
                @csrf
                <div>
                    <label for="nim_ijazah" class="form-label fw-bold">Nomor Ijazah Nasional (NIM Ijazah)</label>
                    <input type="text" name="nim_ijazah" id="nim_ijazah" class="form-control form-control-solid text-sm" value="{{ old('nim_ijazah', $mahasiswa->nim ?? '') }}" required>
                </div>
                <div>
                    <label for="status_profesi" class="form-label fw-bold">Status Profesi (Opsional)</label>
                    <input type="text" name="status_profesi" id="status_profesi" class="form-control form-control-solid text-sm" value="{{ old('status_profesi', 'Belum ada keanggotaan profesi') }}">
                </div>
                <button type="submit" class="btn btn-success w-full py-3 text-sm font-bold">
                    <i class="fa-solid fa-certificate mr-1"></i> Terbitkan & Cetak SKPI
                </button>
            </form>
        </div>
    @endif

    @if ($pengajuan->status === 'dicetak')
        <div class="card p-6 animate-scale-in" style="border-color: #22c55e;">
            <h4 class="section-accent mb-3"><i class="fa-solid fa-print text-emerald-600"></i> Cetak Ulang / Batalkan SKPI</h4>
            <p class="text-xs text-gray-600 font-medium mb-4">SKPI sudah diterbitkan. Klik tombol di bawah untuk mencetak ulang dokumen PDF.</p>
            
            <div class="form mb-6">
                <a href="{{ route('bak_fakultas.skpi.print', $pengajuan->id_pengajuan) }}?nim_ijazah={{ urlencode($mahasiswa->skpi->nim_ijazah ?? '') }}" target="_blank"
                    class="btn btn-success w-full inline-flex justify-center text-sm font-bold">
                    <i class="fa-solid fa-download mr-1"></i> Cetak Ulang PDF
                </a>

                <hr class="border-gray-200">

                <div class="bg-red-50 p-5 rounded-2xl border border-red-200/60">
                    <h5 class="text-xs font-bold text-red-800 flex items-center gap-1.5 mb-2">
                        <i class="fa-solid fa-ban"></i> Batalkan Cetak SKPI
                    </h5>
                    <p class="text-[10px] text-red-600 font-medium mb-3">Jika dibatalkan, status akan dikembalikan ke Draft agar mahasiswa dapat menambah/mengubah data. Dokumen SKPI yang sudah diterbitkan akan dihapus.</p>
                    
                    <form action="{{ route('bak_fakultas.verifikasi.cancel_print', $pengajuan->id_pengajuan) }}" method="POST" class="form mb-6" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan cetak SKPI ini?')">
                        @csrf
                        <div>
                            <textarea name="catatan" required class="form-control form-control-solid text-sm w-full h-20" placeholder="Alasan pembatalan cetak (wajib diisi)..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-full py-2.5 text-sm font-bold">
                            <i class="fa-solid fa-trash-can mr-1"></i> Batalkan & Kembalikan ke Draft
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($pengajuan->status === 'draft')
        <div class="card p-6 animate-scale-in" style="border-color: #f59e0b;">
            <h4 class="section-accent mb-3"><i class="fa-solid fa-pen-to-square text-amber-600"></i> Menunggu Revisi Mahasiswa</h4>
            <p class="text-xs text-gray-600 font-medium">Pengajuan ditandai perlu revisi. Menunggu mahasiswa memperbaiki data dan mengajukan ulang.</p>
            @if($pengajuan->catatan_bak)
                <div class="p-3.5 bg-amber-50 text-amber-800 text-xs font-medium mt-3 rounded-xl border border-amber-200/60">
                    <p class="font-bold mb-0.5"><i class="fa-solid fa-message mr-1"></i> Catatan:</p>
                    <p>{{ $pengajuan->catatan_bak }}</p>
                </div>
            @endif
        </div>
    @endif

    @if ($pengajuan->status === 'ditolak')
        <div class="card p-6 animate-scale-in" style="border-color: #ef4444;">
            <h4 class="section-accent mb-3"><i class="fa-solid fa-circle-xmark text-red-600"></i> Pengajuan Ditolak</h4>
            <p class="text-xs text-gray-600 font-medium">Pengajuan cetak SKPI ini telah ditolak. Menunggu mahasiswa mengajukan ulang.</p>
            @if($pengajuan->catatan_bak)
                <div class="p-3.5 bg-red-50 text-red-800 text-xs font-medium mt-3 rounded-xl border border-red-200/60">
                    <p class="font-bold mb-0.5"><i class="fa-solid fa-message mr-1"></i> Alasan:</p>
                    <p>{{ $pengajuan->catatan_bak }}</p>
                </div>
            @endif
        </div>
    @endif
@endif