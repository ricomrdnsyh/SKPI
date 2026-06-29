@extends('layouts.app')

@section('title', 'Tambah Magang')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('mahasiswa.magang.index') }}" class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar
        </a>
        <h2 class="page-title">Tambah Data Magang / KP</h2>
        <p class="page-desc">Masukkan informasi riwayat magang / kerja praktik Anda.</p>
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
        <form action="{{ route('mahasiswa.magang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tempat_magang" class="form-label">Mitra Industri (Perusahaan)</label>
                    <input type="text" name="tempat_magang" id="tempat_magang" value="{{ old('tempat_magang') }}" required class="form-input" placeholder="Contoh: PT. Sumber Jaya Makmur">
                </div>

                <div>
                    <label for="posisi" class="form-label">Posisi / Jabatan Intern</label>
                    <input type="text" name="posisi" id="posisi" value="{{ old('posisi') }}" required class="form-input" placeholder="Contoh: Junior Web Developer">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required class="form-input">
                </div>

                <div>
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai', date('Y-m-d')) }}" required class="form-input">
                </div>
            </div>

            <div>
                <label for="file_bukti" class="form-label">Unggah Sertifikat Magang / Nilai Akhir (PDF / JPG / PNG, Max 2MB)</label>
                <input type="file" name="file_bukti" id="file_bukti" required class="form-input text-gray-600">
            </div>

            <button type="submit" class="btn btn-primary w-full font-bold py-3.5">
                Simpan Magang
            </button>
        </form>
    </div>
</div>
@endsection
