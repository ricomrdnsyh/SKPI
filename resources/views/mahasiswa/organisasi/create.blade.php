@extends('layouts.app')

@section('title', 'Tambah Organisasi')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('mahasiswa.organisasi.index') }}" class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar
        </a>
        <h2 class="page-title">Tambah Data Organisasi</h2>
        <p class="page-desc">Masukkan informasi riwayat keaktifan organisasi Anda.</p>
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
        <form action="{{ route('mahasiswa.organisasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="nama_organisasi" class="form-label">Nama Organisasi</label>
                <input type="text" name="nama_organisasi" id="nama_organisasi" value="{{ old('nama_organisasi') }}" required class="form-input" placeholder="Contoh: Himpunan Mahasiswa Teknik Informatika">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tingkat" class="form-label">Tingkat Organisasi</label>
                    <select name="tingkat" id="tingkat" required class="form-select">
                        <option value="Internasional" {{ old('tingkat') === 'Internasional' ? 'selected' : '' }}>Internasional</option>
                        <option value="Nasional" {{ old('tingkat') === 'Nasional' ? 'selected' : '' }}>Nasional</option>
                        <option value="Universitas" {{ old('tingkat') === 'Universitas' ? 'selected' : '' }}>Universitas</option>
                        <option value="Fakultas" {{ old('tingkat') === 'Fakultas' ? 'selected' : '' }}>Fakultas</option>
                    </select>
                </div>

                <div>
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" required class="form-input" placeholder="Contoh: Ketua / Sekretaris">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tahun_mulai" class="form-label">Tahun Mulai</label>
                    <input type="number" name="tahun_mulai" id="tahun_mulai" value="{{ old('tahun_mulai', date('Y')) }}" required class="form-input" placeholder="Contoh: 2023">
                </div>

                <div>
                    <label for="tahun_selesai" class="form-label">Tahun Selesai (Kosongkan jika aktif)</label>
                    <input type="number" name="tahun_selesai" id="tahun_selesai" value="{{ old('tahun_selesai') }}" class="form-input" placeholder="Contoh: 2024">
                </div>
            </div>

            <div>
                <label for="file_bukti" class="form-label">Unggah SK / Surat Keterangan Bukti (PDF / JPG / PNG, Max 2MB)</label>
                <input type="file" name="file_bukti" id="file_bukti" required class="form-input text-gray-600">
            </div>

            <button type="submit" class="btn btn-primary w-full font-bold py-3.5">
                Simpan Organisasi
            </button>
        </form>
    </div>
</div>
@endsection
