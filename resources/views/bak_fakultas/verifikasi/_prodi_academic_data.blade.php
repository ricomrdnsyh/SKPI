<div class="card p-6 animate-fade-in" style="animation-delay: 0.3s">
    <h3 class="section-accent mb-4">
        <i class="fa-solid fa-graduation-cap"></i>
        Data Akademik
    </h3>
    <div class="space-y-0">
        @php
            $acadFields = [
                ['label' => 'Program Studi', 'value' => $mahasiswa->programStudi->nama_prodi],
                ['label' => 'Jenjang', 'value' => $mahasiswa->programStudi->jenjang],
                ['label' => 'Fakultas', 'value' => $mahasiswa->programStudi->fakultas->nama_fakultas ?? '-'],
                ['label' => 'IPK', 'value' => $mahasiswa->ipk ?? null],
                ['label' => 'SKS Lulus', 'value' => $mahasiswa->sks_lulus ?? null],
                ['label' => 'Predikat Kelulusan', 'value' => $mahasiswa->predikat_kelulusan ?? null],
            ];
        @endphp
        @foreach($acadFields as $f)
            <div class="flex items-start py-3 border-b border-gray-100 last:border-0">
                <span class="text-xs font-semibold text-gray-500 w-1/3 shrink-0">{{ $f['label'] }}</span>
                <span class="text-sm font-bold text-gray-900">{{ $f['value'] ?? 'Belum diisi' }}</span>
            </div>
        @endforeach
    </div>
</div>