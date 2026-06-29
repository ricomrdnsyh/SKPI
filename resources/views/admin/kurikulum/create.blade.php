@extends('layouts.app')

@section('title', 'Tambah Kurikulum')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('kurikulum.index') }}" class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h2 class="page-title">Tambah Kurikulum Program Studi</h2>
    </div>

    <div class="card p-6">
        <form action="{{ route('kurikulum.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="id_prodi" class="form-label">Program Studi</label>
                <select name="id_prodi" id="id_prodi" required class="form-select">
                    <option value="">-- Pilih Prodi --</option>
                    @foreach($prodi as $p)
                        <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="nama_kurikulum" class="form-label">Nama Kurikulum</label>
                <input type="text" name="nama_kurikulum" id="nama_kurikulum" required class="form-input" placeholder="Contoh: Kurikulum 2024">
            </div>

            <div>
                <label for="tahun" class="form-label">Tahun Kurikulum</label>
                <input type="number" name="tahun" id="tahun" required class="form-input" placeholder="Contoh: 2024" min="2000" max="2099">
            </div>

            <button type="submit" class="btn btn-primary w-full py-3 text-sm">Simpan</button>
        </form>
    </div>
</div>
@endsection
