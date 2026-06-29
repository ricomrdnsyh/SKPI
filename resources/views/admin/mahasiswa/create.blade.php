@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('mahasiswa.index') }}" class="inline-flex items-center gap-2 text-gray-600 font-semibold mb-4 text-sm hover:text-gray-900 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h2 class="page-title">Tambah Data Mahasiswa</h2>
        <p class="page-desc">Lengkapi data profil mahasiswa baru.</p>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200/60 text-red-800 text-sm shadow-sm">
            <div class="flex items-start gap-2.5">
                <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0"></i>
                <ul class="space-y-1 font-semibold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card p-6 md:p-8">
        <form action="{{ route('mahasiswa.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="nim" class="form-label">NIM <span class="text-red-500">*</span></label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim') }}" required class="form-input" placeholder="Masukkan NIM">
                </div>
                <div>
                    <label for="id_prodi" class="form-label">Program Studi <span class="text-red-500">*</span></label>
                    <select name="id_prodi" id="id_prodi" required class="form-select">
                        <option value="">-- Pilih Prodi --</option>
                        @foreach($prodi as $p)
                            <option value="{{ $p->id_prodi }}" {{ old('id_prodi') == $p->id_prodi ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="id_kurikulum" class="form-label">Kurikulum <span class="text-red-500">*</span></label>
                    <select name="id_kurikulum" id="id_kurikulum" required class="form-select">
                        <option value="">-- Pilih Kurikulum --</option>
                        @foreach($kurikulums as $kur)
                            <option value="{{ $kur->id_kurikulum }}" {{ old('id_kurikulum') == $kur->id_kurikulum ? 'selected' : '' }}>{{ $kur->nama_kurikulum }} ({{ $kur->tahun }}) - {{ $kur->prodi_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="form-input" placeholder="Nama lengkap sesuai ijazah">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-input" placeholder="Contoh: Probolinggo">
                </div>
                <div>
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input" placeholder="email@example.com">
                </div>
                <div>
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}" class="form-input" placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-input" placeholder="Minimal 6 karakter">
                <p class="form-hint">Kosongkan jika tidak ingin mengubah password.</p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn btn-primary px-8 py-3 text-sm font-bold">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary px-6 py-3 text-sm">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection