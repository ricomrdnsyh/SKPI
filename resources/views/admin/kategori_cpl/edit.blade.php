@extends('layouts.app')

@section('title', 'Ubah Kategori CPL')

@section('content')
    <div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
        <div>
            <a href="{{ route('kategori-cpl.index') }}"
                class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <h2 class="page-title">Ubah Kategori CPL</h2>
        </div>

        @if ($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-xs space-y-1">
                <p class="font-bold"><i class="fa-solid fa-circle-exclamation mr-1 text-red-600"></i> Ada kesalahan input:</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card p-6">
            <form action="{{ route('kategori-cpl.update', $kategori->id_kategori) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="kode_kategori" class="form-label">Kode Kategori</label>
                    <input type="text" name="kode_kategori" id="kode_kategori" value="{{ old('kode_kategori', $kategori->kode_kategori) }}" required class="form-input">
                </div>
                <div>
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required class="form-input">
                </div>
                <div>
                    <label for="urutan" class="form-label">Urutan</label>
                    <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $kategori->urutan) }}" class="form-input">
                </div>
                <button type="submit" class="btn btn-primary w-full py-3 text-sm">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
