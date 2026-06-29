@extends('layouts.app')

@section('title', $readonly ? 'Detail Organisasi' : 'Ubah Organisasi')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('mahasiswa.organisasi.index') }}" class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar
        </a>
        <h2 class="page-title">{{ $readonly ? 'Detail Organisasi' : 'Ubah Data Organisasi' }}</h2>
        <p class="page-desc">{{ $readonly ? 'Informasi detail data organisasi.' : 'Perbarui informasi keaktifan organisasi Anda.' }}</p>
    </div>

    @if($isLocked)
        <div class="p-4 rounded-xl font-bold text-sm bg-amber-50 text-amber-800 border border-gray-200 shadow-sm">
            <i class="fa-solid fa-lock mr-1"></i> Data tidak dapat diubah karena pengajuan SKPI sedang diproses.
        </div>
    @endif

    @if($organisasi->status === 'approved')
        <div class="p-4 rounded-xl font-bold text-sm bg-emerald-50 text-emerald-700 border border-gray-200 shadow-sm">
            <i class="fa-solid fa-check-circle mr-1"></i> Data yang telah disetujui tidak dapat diubah.
        </div>
    @endif

    @if($organisasi->status === 'rejected')
        <div class="p-4 rounded-xl bg-red-100 text-red-800 font-bold text-sm border border-gray-200 shadow-sm">
            <span><i class="fa-solid fa-circle-exclamation mr-1"></i> Alasan ditolak:</span>
            @if($organisasi->keterangan)
                {{ $organisasi->keterangan }}
            @else
                <span class="italic">Tidak ada catatan.</span>
            @endif
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-100 text-red-800 font-bold text-sm border border-gray-200 shadow-sm">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('partials.item_progress', ['steps' => $itemSteps, 'itemName' => 'Organisasi'])

    @include('partials.overall_progress', ['steps' => $overallSteps])

    <div class="card p-6 md:p-8">
        <form action="{{ route('mahasiswa.organisasi.update', $organisasi) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="nama_organisasi" class="form-label">Nama Organisasi</label>
                <input type="text" name="nama_organisasi" id="nama_organisasi" value="{{ old('nama_organisasi', $organisasi->nama_organisasi) }}" required class="form-input" {{ $readonly ? 'disabled' : '' }}>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tingkat" class="form-label">Tingkat Organisasi</label>
                    <select name="tingkat" id="tingkat" required class="form-select" {{ $readonly ? 'disabled' : '' }}>
                        <option value="Internasional" {{ old('tingkat', $organisasi->tingkat) === 'Internasional' ? 'selected' : '' }}>Internasional</option>
                        <option value="Nasional" {{ old('tingkat', $organisasi->tingkat) === 'Nasional' ? 'selected' : '' }}>Nasional</option>
                        <option value="Universitas" {{ old('tingkat', $organisasi->tingkat) === 'Universitas' ? 'selected' : '' }}>Universitas</option>
                        <option value="Fakultas" {{ old('tingkat', $organisasi->tingkat) === 'Fakultas' ? 'selected' : '' }}>Fakultas</option>
                    </select>
                </div>

                <div>
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $organisasi->jabatan) }}" required class="form-input" {{ $readonly ? 'disabled' : '' }}>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tahun_mulai" class="form-label">Tahun Mulai</label>
                    <input type="number" name="tahun_mulai" id="tahun_mulai" value="{{ old('tahun_mulai', $organisasi->tahun_mulai) }}" required class="form-input" {{ $readonly ? 'disabled' : '' }}>
                </div>

                <div>
                    <label for="tahun_selesai" class="form-label">Tahun Selesai</label>
                    <input type="number" name="tahun_selesai" id="tahun_selesai" value="{{ old('tahun_selesai', $organisasi->tahun_selesai) }}" class="form-input" {{ $readonly ? 'disabled' : '' }}>
                </div>
            </div>

            <div>
                <label for="file_bukti" class="form-label">{{ $readonly ? 'File Bukti' : 'Unggah File Bukti Baru (Pilih jika ingin mengganti, Max 2MB)' }}</label>
                @if($readonly)
                    @if($organisasi->file_bukti)
                        <p class="text-sm text-gray-600 mt-1">
                            <a href="{{ asset('storage/' . $organisasi->file_bukti) }}" target="_blank" class="font-bold hover:underline" style="color: #065f46;"><i class="fa-solid fa-file mr-1"></i>Lihat Berkas</a>
                        </p>
                    @else
                        <p class="text-sm text-gray-400 mt-1">Tidak ada berkas.</p>
                    @endif
                @else
                    <input type="file" name="file_bukti" id="file_bukti" class="form-input text-gray-600">
                    @if($organisasi->file_bukti)
                        <p class="text-xs text-gray-400 mt-2">File saat ini: <a href="{{ asset('storage/' . $organisasi->file_bukti) }}" target="_blank" class="font-bold hover:underline" style="color: #065f46;">Lihat Berkas</a></p>
                    @endif
                @endif
            </div>

            @if(!$readonly)
                <button type="submit" class="btn btn-primary w-full font-bold py-3.5">
                    Simpan Perubahan
                </button>
            @endif
        </form>
    </div>
</div>
@endsection
