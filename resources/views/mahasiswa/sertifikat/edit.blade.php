@extends('layouts.app')

@section('title', $readonly ? 'Detail Sertifikat' : 'Ubah Sertifikat')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('mahasiswa.sertifikat.index') }}" class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar
        </a>
        <h2 class="page-title">{{ $readonly ? 'Detail Sertifikat' : 'Ubah Data Sertifikat' }}</h2>
        <p class="page-desc">{{ $readonly ? 'Informasi detail data sertifikat.' : 'Perbarui informasi sertifikat Anda.' }}</p>
    </div>

    @if($isLocked)
        <div class="p-4 rounded-xl font-bold text-sm bg-amber-50 text-amber-800 border border-gray-200 shadow-sm">
            <i class="fa-solid fa-lock mr-1"></i> Data tidak dapat diubah karena pengajuan SKPI sedang diproses.
        </div>
    @endif

    @if($sertifikat->status === 'approved')
        <div class="p-4 rounded-xl font-bold text-sm bg-emerald-50 text-emerald-700 border border-gray-200 shadow-sm">
            <i class="fa-solid fa-check-circle mr-1"></i> Data yang telah disetujui tidak dapat diubah.
        </div>
    @endif

    @if($sertifikat->status === 'rejected')
        <div class="p-4 rounded-xl bg-red-100 text-red-800 font-bold text-sm border border-gray-200 shadow-sm">
            <span><i class="fa-solid fa-circle-exclamation mr-1"></i> Alasan ditolak:</span>
            @if($sertifikat->keterangan)
                {{ $sertifikat->keterangan }}
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

    @include('partials.item_progress', ['steps' => $itemSteps, 'itemName' => 'Sertifikat'])

    @include('partials.overall_progress', ['steps' => $overallSteps])

    <div class="card p-6 md:p-8">
        <form action="{{ route('mahasiswa.sertifikat.update', $sertifikat) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="nama_sertifikat" class="form-label">Nama Sertifikat / Pelatihan</label>
                <input type="text" name="nama_sertifikat" id="nama_sertifikat" value="{{ old('nama_sertifikat', $sertifikat->nama_sertifikat) }}" required class="form-input" {{ $readonly ? 'disabled' : '' }}>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="jenis_sertifikat" class="form-label">Jenis Sertifikat</label>
                    <select name="jenis_sertifikat" id="jenis_sertifikat" required class="form-select" {{ $readonly ? 'disabled' : '' }}>
                        <option value="Keagamaan" {{ old('jenis_sertifikat', $sertifikat->jenis_sertifikat) === 'Keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                        <option value="Teknis" {{ old('jenis_sertifikat', $sertifikat->jenis_sertifikat) === 'Teknis' ? 'selected' : '' }}>Teknis</option>
                        <option value="Bahasa" {{ old('jenis_sertifikat', $sertifikat->jenis_sertifikat) === 'Bahasa' ? 'selected' : '' }}>Bahasa</option>
                        <option value="Profesional" {{ old('jenis_sertifikat', $sertifikat->jenis_sertifikat) === 'Profesional' ? 'selected' : '' }}>Profesional</option>
                    </select>
                </div>

                <div>
                    <label for="bidang" class="form-label">Bidang Keahlian / Kompetensi</label>
                    <input type="text" name="bidang" id="bidang" value="{{ old('bidang', $sertifikat->bidang) }}" required class="form-input" {{ $readonly ? 'disabled' : '' }}>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="penyelenggara" class="form-label">Penyelenggara</label>
                    <input type="text" name="penyelenggara" id="penyelenggara" value="{{ old('penyelenggara', $sertifikat->penyelenggara) }}" required class="form-input" {{ $readonly ? 'disabled' : '' }}>
                </div>

                <div>
                    <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                    <input type="date" name="tanggal_terbit" id="tanggal_terbit" value="{{ old('tanggal_terbit', $sertifikat->tanggal_terbit->format('Y-m-d')) }}" required class="form-input" {{ $readonly ? 'disabled' : '' }}>
                </div>
            </div>

            <div>
                <label for="file_bukti" class="form-label">{{ $readonly ? 'File Bukti' : 'Unggah File Bukti Baru (Pilih jika ingin mengganti, Max 2MB)' }}</label>
                @if($readonly)
                    @if($sertifikat->file_bukti)
                        <p class="text-sm text-gray-600 mt-1">
                            <a href="{{ asset('storage/' . $sertifikat->file_bukti) }}" target="_blank" class="font-bold hover:underline" style="color: #065f46;"><i class="fa-solid fa-file mr-1"></i>Lihat Berkas</a>
                        </p>
                    @else
                        <p class="text-sm text-gray-400 mt-1">Tidak ada berkas.</p>
                    @endif
                @else
                    <input type="file" name="file_bukti" id="file_bukti" class="form-input text-gray-600">
                    @if($sertifikat->file_bukti)
                        <p class="text-xs text-gray-400 mt-2">File saat ini: <a href="{{ asset('storage/' . $sertifikat->file_bukti) }}" target="_blank" class="font-bold hover:underline" style="color: #065f46;">Lihat Berkas</a></p>
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
