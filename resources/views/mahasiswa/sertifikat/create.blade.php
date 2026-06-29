@extends('layouts.app')

@section('title', 'Tambah Sertifikat')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('mahasiswa.sertifikat.index') }}" class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar
        </a>
        <h2 class="page-title">Tambah Data Sertifikat</h2>
        <p class="page-desc">Masukkan informasi sertifikat keahlian / pelatihan Anda.</p>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-100 text-red-800 font-bold text-sm border border-gray-200 shadow-sm">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-6 md:p-8">
        <form action="{{ route('mahasiswa.sertifikat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="nama_sertifikat" class="form-label">Nama Sertifikat / Pelatihan</label>
                <input type="text" name="nama_sertifikat" id="nama_sertifikat" value="{{ old('nama_sertifikat') }}" required class="form-input" placeholder="Contoh: Cisco Certified Network Associate">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="jenis_sertifikat" class="form-label">Jenis Sertifikat</label>
                    <select name="jenis_sertifikat" id="jenis_sertifikat" required class="form-select">
                        <option value="Keagamaan" {{ old('jenis_sertifikat') === 'Keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                        <option value="Teknis" {{ old('jenis_sertifikat') === 'Teknis' ? 'selected' : '' }}>Teknis</option>
                        <option value="Bahasa" {{ old('jenis_sertifikat') === 'Bahasa' ? 'selected' : '' }}>Bahasa</option>
                        <option value="Profesional" {{ old('jenis_sertifikat') === 'Profesional' ? 'selected' : '' }}>Profesional</option>
                    </select>
                </div>

                <div>
                    <label for="bidang" class="form-label">Bidang Keahlian / Kompetensi</label>
                    <input type="text" name="bidang" id="bidang" value="{{ old('bidang') }}" required class="form-input" placeholder="Contoh: Keamanan Jaringan / Bahasa Inggris">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="penyelenggara" class="form-label">Penyelenggara</label>
                    <input type="text" name="penyelenggara" id="penyelenggara" value="{{ old('penyelenggara') }}" required class="form-input" placeholder="Contoh: Cisco Networking Academy">
                </div>

                <div>
                    <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                    <input type="date" name="tanggal_terbit" id="tanggal_terbit" value="{{ old('tanggal_terbit', date('Y-m-d')) }}" required class="form-input">
                </div>
            </div>

            <div>
                <label for="file_bukti" class="form-label">Unggah File Bukti Sertifikat (PDF / JPG / PNG, Max 2MB)</label>
                <input type="file" name="file_bukti" id="file_bukti" required class="form-input text-gray-600">
            </div>

            <button type="submit" class="btn btn-primary w-full font-bold py-3.5">
                Simpan Sertifikat
            </button>
        </form>
    </div>
</div>
@endsection
