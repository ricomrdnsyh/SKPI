<div class="card border border-dashed mb-6">
    <div class="card-header border-0 pt-6">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1"><i class="ki-duotone ki-book-open fs-2 me-2 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> Data Akademik</span>
        </h3>
    </div>
    <div class="card-body pt-5">
        <div class="row g-5">
            @php
                $acadFields = [
                    ['label' => 'Program Studi', 'value' => $mahasiswa->programStudi->nama_prodi, 'icon' => 'ki-book-square', 'color' => 'primary'],
                    ['label' => 'Jenjang', 'value' => $mahasiswa->programStudi->jenjang, 'icon' => 'ki-abstract-26', 'color' => 'success'],
                    ['label' => 'Fakultas', 'value' => $mahasiswa->programStudi->fakultas->nama_fakultas ?? '-', 'icon' => 'ki-bank', 'color' => 'info'],
                    ['label' => 'IPK', 'value' => $mahasiswa->ipk ?? 'Belum diisi', 'icon' => 'ki-chart-line-up', 'color' => 'warning'],
                    ['label' => 'SKS Lulus', 'value' => $mahasiswa->sks_lulus ?? 'Belum diisi', 'icon' => 'ki-chart-simple', 'color' => 'danger'],
                    ['label' => 'Predikat Kelulusan', 'value' => $mahasiswa->predikat_kelulusan ?? 'Belum diisi', 'icon' => 'ki-medal-star', 'color' => 'dark'],
                ];
            @endphp
            @foreach($acadFields as $f)
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="border border-dashed border-gray-300 rounded p-4 text-center h-100 bg-light">
                        <i class="ki-duotone {{ $f['icon'] }} fs-2x text-{{ $f['color'] }} mb-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                        <div class="text-muted fw-semibold fs-7 mb-1">{{ $f['label'] }}</div>
                        <div class="fw-bolder text-gray-900 fs-6">{{ $f['value'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>