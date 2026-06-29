@extends('layouts.app')

@section('title', 'Tambah Prestasi')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('mahasiswa.prestasi.index') }}" class="inline-flex items-center gap-2 text-gray-600 font-semibold mb-4 text-sm hover:text-gray-900 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h2 class="page-title">Tambah Data Prestasi</h2>
        <p class="page-desc">Masukkan informasi prestasi dan unggah berkas bukti pendukung.</p>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200/60 text-red-800 text-sm shadow-sm">
            <div class="flex items-start gap-2.5">
                <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0"></i>
                <ul class="space-y-1 font-semibold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card p-6 md:p-8">
        <form action="{{ route('mahasiswa.prestasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="nama_prestasi" class="form-label">Nama Prestasi / Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="nama_prestasi" id="nama_prestasi" value="{{ old('nama_prestasi') }}" required class="form-input" placeholder="Contoh: Juara 1 Web Design Nasional">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="tingkat" class="form-label">Tingkat Prestasi <span class="text-red-500">*</span></label>
                    <select name="tingkat" id="tingkat" required class="form-select">
                        <option value="Internasional" {{ old('tingkat') === 'Internasional' ? 'selected' : '' }}>Internasional</option>
                        <option value="Nasional" {{ old('tingkat') === 'Nasional' ? 'selected' : '' }}>Nasional</option>
                        <option value="Provinsi" {{ old('tingkat') === 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                        <option value="Lokal" {{ old('tingkat') === 'Lokal' ? 'selected' : '' }}>Lokal / Kampus</option>
                    </select>
                </div>

                <div>
                    <label for="peringkat" class="form-label">Peringkat / Penghargaan <span class="text-red-500">*</span></label>
                    <input type="text" name="peringkat" id="peringkat" value="{{ old('peringkat') }}" required class="form-input" placeholder="Contoh: Juara 1 / Best Paper">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="penyelenggara" class="form-label">Penyelenggara <span class="text-red-500">*</span></label>
                    <input type="text" name="penyelenggara" id="penyelenggara" value="{{ old('penyelenggara') }}" required class="form-input" placeholder="Contoh: Puspresnas Kemendikbud">
                </div>

                <div>
                    <label for="tahun" class="form-label">Tahun Perolehan <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun" id="tahun" value="{{ old('tahun', date('Y')) }}" required class="form-input" placeholder="Contoh: 2026">
                </div>
            </div>

            <div>
                <label for="file_bukti" class="form-label">Unggah File Bukti <span class="text-red-500">*</span></label>
                <input type="file" name="file_bukti" id="file_bukti" required class="form-input">
                <p class="form-hint">Format: PDF / JPG / PNG, Maksimal 2MB</p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn btn-primary px-8 py-3 text-sm font-bold">
                    <i class="fa-solid fa-save"></i> Simpan Prestasi
                </button>
                <a href="{{ route('mahasiswa.prestasi.index') }}" class="btn btn-secondary px-6 py-3 text-sm">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection