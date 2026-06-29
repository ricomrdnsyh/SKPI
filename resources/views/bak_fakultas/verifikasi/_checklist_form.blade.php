<div class="card p-6 animate-fade-in" style="animation-delay: 0.2s">
    <h3 class="section-accent mb-4">
        <i class="fa-solid fa-file-signature"></i>
        Verifikasi Pengajuan SKPI
    </h3>

    @if ($hasPendingItems)
        <div class="p-3.5 bg-amber-50 text-amber-800 text-xs space-y-1 mb-4 leading-relaxed font-medium rounded-2xl border border-amber-200/60">
            <p class="font-bold"><i class="fa-solid fa-triangle-exclamation mr-1 text-amber-600"></i> Verifikasi Lulus Belum Dapat Diproses</p>
            <p class="text-[10px]">Masih ada berkas pendukung atau Tugas Akhir berstatus pending yang perlu disetujui/ditolak terlebih dahulu.</p>
        </div>
    @endif
    @if ($hasNoTugasAkhir)
        <div class="p-3.5 bg-blue-50 text-blue-800 text-xs space-y-1 mb-4 leading-relaxed font-medium rounded-2xl border border-blue-200/60">
            <p class="font-bold"><i class="fa-solid fa-circle-info mr-1 text-blue-600"></i> Informasi Tugas Akhir</p>
            <p class="text-[10px]">Data Tugas Akhir belum diisi. Verifikasi berkas pendukung dapat tetap diproses, namun TA wajib dilengkapi sebelum SKPI dicetak.</p>
        </div>
    @endif

    <form action="{{ route('bak_fakultas.verifikasi.checklist', $pengajuan->id_pengajuan) }}" method="POST" class="space-y-5">
        @csrf

        @php $cl = $pengajuan->checklist; @endphp

        <div class="space-y-4">
            <div>
                <label for="hasil_verifikasi" class="form-label">Hasil Verifikasi</label>
                <select name="hasil_verifikasi" id="hasil_verifikasi" required class="form-select">
                    <option value="perlu_revisi" {{ $cl && $cl->hasil_verifikasi === 'perlu_revisi' ? 'selected' : '' }}>
                        Perlu Revisi (Balikkan ke Mahasiswa)
                    </option>
                    <option value="lulus" {{ $cl && $cl->hasil_verifikasi === 'lulus' ? 'selected' : '' }}>
                        Lulus (Lanjut ke Penerbitan SKPI)
                    </option>
                    <option value="ditolak" {{ $cl && $cl->hasil_verifikasi === 'ditolak' ? 'selected' : '' }}>
                        Ditolak Permanen
                    </option>
                </select>
            </div>
            <div>
                <label for="catatan" class="form-label">Catatan Verifikasi</label>
                <textarea name="catatan" id="catatan" rows="3" class="form-input text-sm"
                    placeholder="Tulis alasan revisi/catatan tambahan...">{{ $cl->catatan ?? '' }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-full font-bold py-3 text-sm">
            <i class="fa-solid fa-check-circle"></i> Simpan Verifikasi
        </button>
    </form>
</div>