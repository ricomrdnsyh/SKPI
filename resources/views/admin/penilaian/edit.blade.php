@extends('layouts.app')

@section('title', 'Ubah Penilaian')

@section('content')
<div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div>
        <a href="{{ route('penilaian.index') }}" class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h2 class="page-title">Ubah Aturan Penilaian</h2>
    </div>

    <div class="card p-6">
        <form action="{{ route('penilaian.update', $penilaian->id_penilaian) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="nilai_huruf" class="form-label">Nilai Huruf</label>
                    <input type="text" name="nilai_huruf" id="nilai_huruf" value="{{ $penilaian->nilai_huruf }}" required class="form-input">
                </div>
                <div>
                    <label for="nilai_min" class="form-label">Nilai Minimum</label>
                    <input type="number" step="0.01" min="0" max="100" name="nilai_min" id="nilai_min" value="{{ $penilaian->nilai_min }}" required class="form-input">
                </div>
                <div>
                    <label for="nilai_max" class="form-label">Nilai Maksimum</label>
                    <input type="number" step="0.01" min="0" max="100" name="nilai_max" id="nilai_max" value="{{ $penilaian->nilai_max }}" required class="form-input">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-full py-3 text-sm">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
