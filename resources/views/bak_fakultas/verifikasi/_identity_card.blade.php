<div class="card-header border-0 pt-6">
    <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1"><i class="ki-duotone ki-profile-user fs-2 me-2 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> Identitas Pemohon</span>
    </h3>
</div>
<div class="card-body pt-5">
    <div class="table-responsive">
        <table class="table table-row-dashed table-row-gray-300 gy-4 align-middle">
            <tbody>
                @php
                    $fields = [
                        ['label' => 'Nama Lengkap', 'value' => $mahasiswa->nama_lengkap],
                        ['label' => 'NIM', 'value' => $mahasiswa->nim],
                        ['label' => 'NIM Ijazah', 'value' => $mahasiswa->skpi->nim_ijazah ?? null, 'empty' => '<span class="badge badge-light-warning fw-bold text-uppercase fs-8"><i class="ki-duotone ki-time fs-7 me-1"><span class="path1"></span><span class="path2"></span></i> Diinput saat penerbitan</span>'],
                        ['label' => 'Program Studi', 'value' => $mahasiswa->programStudi->nama_prodi],
                        ['label' => 'Tempat, Tanggal Lahir', 'value' => $mahasiswa->tempat_lahir . ', ' . $mahasiswa->tanggal_lahir],
                    ];
                @endphp
                @foreach($fields as $f)
                    <tr>
                        <td class="text-muted fw-semibold w-250px">{{ $f['label'] }}</td>
                        <td class="fw-bolder text-gray-800">
                            {!! $f['value'] ?? ($f['empty'] ?? '<span class="text-gray-400 fw-normal">-</span>') !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>