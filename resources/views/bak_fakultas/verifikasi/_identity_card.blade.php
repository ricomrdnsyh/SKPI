<div class="card p-6 animate-fade-in" style="animation-delay: 0.15s">
    <h3 class="section-accent mb-4">
        <i class="fa-solid fa-address-card"></i>
        Identitas Pemohon
    </h3>
    <div class="form mb-6">
        @php
            $fields = [
                ['label' => 'Nama Lengkap', 'value' => $mahasiswa->nama_lengkap],
                ['label' => 'NIM', 'value' => $mahasiswa->nim],
                ['label' => 'NIM Ijazah', 'value' => $mahasiswa->skpi->nim_ijazah ?? null, 'empty' => '<span class="inline-flex items-center gap-1 text-amber-700 font-semibold text-[10px] bg-amber-100 px-2 py-0.5 rounded-lg"><i class="fa-solid fa-clock-rotate-left"></i> Diinput saat penandatanganan</span>'],
                ['label' => 'Program Studi', 'value' => $mahasiswa->programStudi->nama_prodi],
                ['label' => 'Tempat, Tanggal Lahir', 'value' => $mahasiswa->tempat_lahir . ', ' . $mahasiswa->tanggal_lahir],
            ];
        @endphp
        @foreach($fields as $f)
            <div class="flex items-start py-3 border-b border-gray-100 last:border-0">
                <span class="text-xs font-semibold text-gray-500 w-1/3 shrink-0">{{ $f['label'] }}</span>
                <span class="text-sm font-bold text-gray-900">
                    {!! $f['value'] ?? ($f['empty'] ?? '<span class="text-gray-400 font-normal">-</span>') !!}
                </span>
            </div>
        @endforeach
    </div>
</div>