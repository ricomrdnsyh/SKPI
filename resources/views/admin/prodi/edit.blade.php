@extends('layouts.app')

@section('title', 'Ubah Program Studi')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('prodi.index') }}" class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h2 class="page-title">Ubah Program Studi</h2>
    </div>

    <div class="card p-6">
        <form action="{{ route('prodi.update', $prodi->id_prodi) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="id_fakultas" class="form-label">Fakultas</label>
                    <select name="id_fakultas" id="id_fakultas" required class="form-select">
                        @foreach($fakultas as $f)
                            <option value="{{ $f->id_fakultas }}" {{ $prodi->id_fakultas == $f->id_fakultas ? 'selected' : '' }}>{{ $f->nama_fakultas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                    <input type="text" name="nama_prodi" id="nama_prodi" value="{{ $prodi->nama_prodi }}" required class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="kode_prodi" class="form-label">Kode Prodi</label>
                    <input type="text" name="kode_prodi" id="kode_prodi" value="{{ $prodi->kode_prodi }}" class="form-input">
                </div>
                <div>
                    <label for="jenjang" class="form-label">Jenjang</label>
                    <select name="jenjang" id="jenjang" required class="form-select">
                        <option value="S1" {{ $prodi->jenjang === 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="D3" {{ $prodi->jenjang === 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S2" {{ $prodi->jenjang === 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ $prodi->jenjang === 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>
                <div>
                    <label for="gelar" class="form-label">Gelar</label>
                    <input type="text" name="gelar" id="gelar" value="{{ $prodi->gelar }}" class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="sk_akreditasi" class="form-label">SK Akreditasi</label>
                    <input type="text" name="sk_akreditasi" id="sk_akreditasi" value="{{ $prodi->sk_akreditasi }}" class="form-input">
                </div>
                <div>
                    <label for="tanggal_sk_akreditasi" class="form-label">Tanggal SK</label>
                    <input type="date" name="tanggal_sk_akreditasi" id="tanggal_sk_akreditasi" value="{{ $prodi->tanggal_sk_akreditasi }}" class="form-input">
                </div>
                <div>
                    <label for="masa_berlaku_akreditasi" class="form-label">Masa Berlaku Akreditasi</label>
                    <input type="date" name="masa_berlaku_akreditasi" id="masa_berlaku_akreditasi" value="{{ $prodi->masa_berlaku_akreditasi }}" class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="jenjang_kkni" class="form-label">Jenjang KKNI</label>
                    <input type="text" name="jenjang_kkni" id="jenjang_kkni" value="{{ $prodi->jenjang_kkni }}" class="form-input">
                </div>
                <div>
                    <label for="bahasa_pengantar" class="form-label">Bahasa Pengantar</label>
                    <input type="text" name="bahasa_pengantar" id="bahasa_pengantar" value="{{ $prodi->bahasa_pengantar }}" class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="lama_studi" class="form-label">Lama Studi</label>
                    <input type="text" name="lama_studi" id="lama_studi" value="{{ $prodi->lama_studi }}" class="form-input">
                </div>
                <div>
                    <label for="jenis_pendidikan" class="form-label">Jenis Pendidikan</label>
                    <input type="text" name="jenis_pendidikan" id="jenis_pendidikan" value="{{ $prodi->jenis_pendidikan }}" class="form-input">
                </div>
                <div>
                    <label for="jenis_pendidikan_lanjutan" class="form-label">Pendidikan Lanjutan</label>
                    <input type="text" name="jenis_pendidikan_lanjutan" id="jenis_pendidikan_lanjutan" value="{{ $prodi->jenis_pendidikan_lanjutan }}" class="form-input">
                </div>
            </div>

            <div>
                <label for="persyaratan_penerimaan" class="form-label">Persyaratan Penerimaan</label>
                <textarea name="persyaratan_penerimaan" id="persyaratan_penerimaan" rows="2" class="form-input">{{ $prodi->persyaratan_penerimaan }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary w-full py-3 text-sm">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
