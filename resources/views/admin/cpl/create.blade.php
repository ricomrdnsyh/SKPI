@extends('layouts.app')

@section('title', 'Tambah CPL Prodi')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('cpl.index') }}" class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h2 class="page-title">Tambah Capaian Pembelajaran Lulusan (CPL)</h2>
    </div>

    <div class="card p-6">
        <form action="{{ route('cpl.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="id_prodi" class="form-label">Program Studi</label>
                    <select name="id_prodi" id="id_prodi" required class="form-select">
                        @foreach($prodi as $p)
                            <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="id_kurikulum" class="form-label">Kurikulum</label>
                    <select name="id_kurikulum" id="id_kurikulum" required class="form-select">
                        <option value="">-- Pilih Kurikulum --</option>
                        @foreach($kurikulums as $kur)
                            <option value="{{ $kur->id_kurikulum }}">{{ $kur->nama_kurikulum }} ({{ $kur->tahun }}) - {{ $kur->prodi_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="id_kategori" class="form-label">Kategori CPL</label>
                    <select name="id_kategori" id="id_kategori" required class="form-select">
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->kode_kategori }} - {{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="kode_cpl" class="form-label">Kode CPL</label>
                    <input type="text" name="kode_cpl" id="kode_cpl" required class="form-input" placeholder="Contoh: CPL-S01">
                </div>
                <div>
                    <label for="urutan" class="form-label">Urutan Tampil</label>
                    <input type="number" name="urutan" id="urutan" class="form-input" placeholder="Contoh: 1">
                </div>
            </div>

            <div>
                <label for="deskripsi_cpl" class="form-label">Deskripsi CPL</label>
                <textarea name="deskripsi_cpl" id="deskripsi_cpl" rows="4" required class="form-input" placeholder="Ketik deskripsi capaian pembelajaran..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-full py-3 text-sm">Simpan</button>
        </form>
    </div>
</div>
@endsection
