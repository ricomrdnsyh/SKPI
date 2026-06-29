@extends('layouts.app')

@section('title', 'Ubah Fakultas')

@section('content')
    <div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
        <div>
            <a href="{{ route('fakultas.index') }}"
                class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <h2 class="page-title">Ubah Data Fakultas</h2>
        </div>

        <div class="card p-6">
            <form action="{{ route('fakultas.update', $fakultas->id_fakultas) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="nama_fakultas" class="form-label">Nama Fakultas</label>
                    <input type="text" name="nama_fakultas" id="nama_fakultas" value="{{ $fakultas->nama_fakultas }}"
                        required class="form-input">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label for="kode_fakultas" class="form-label">Kode Fakultas</label>
                        <input type="text" name="kode_fakultas" id="kode_fakultas" value="{{ $fakultas->kode_fakultas }}"
                            class="form-input">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="dekan" class="form-label">Nama Dekan</label>
                        <input type="text" name="dekan" id="dekan" value="{{ $fakultas->dekan }}"
                            class="form-input">
                    </div>
                </div>
                <div>
                    <label for="nidn_dekan" class="form-label">nidn Dekan</label>
                    <input type="text" name="nidn_dekan" id="nidn_dekan" value="{{ $fakultas->nidn_dekan }}"
                        class="form-input">
                </div>
                <button type="submit" class="btn btn-primary w-full py-3 text-sm">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
