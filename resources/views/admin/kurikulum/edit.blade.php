@extends('layouts.app')

@section('title', 'Ubah Kurikulum')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('kurikulum.index') }}" class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h2 class="page-title">Ubah Kurikulum Program Studi</h2>
    </div>

    <div class="card p-6">
        <form action="{{ route('kurikulum.update', $kurikulum->id_kurikulum) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="id_prodi" class="form-label">Program Studi</label>
                <select name="id_prodi" id="id_prodi" required class="form-select">
                    <option value="">-- Pilih Prodi --</option>
                    @foreach($prodi as $p)
                        <option value="{{ $p->id_prodi }}" {{ $kurikulum->id_prodi == $p->id_prodi ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="nama_kurikulum" class="form-label">Nama Kurikulum</label>
                <input type="text" name="nama_kurikulum" id="nama_kurikulum" value="{{ $kurikulum->nama_kurikulum }}" required class="form-input">
            </div>

            <div>
                <label for="tahun" class="form-label">Tahun Kurikulum</label>
                <input type="number" name="tahun" id="tahun" value="{{ $kurikulum->tahun }}" required class="form-input" min="2000" max="2099">
            </div>

            <button type="submit" class="btn btn-primary w-full py-3 text-sm">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
