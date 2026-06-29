@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
        <div>
            <a href="{{ route('users.index') }}"
                class="inline-flex items-center gap-2 text-black font-extrabold mb-4 text-sm hover:underline">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Daftar
            </a>
            <h2 class="page-title">Tambah Akun Pengguna</h2>
            <p class="page-desc">Daftarkan akun pengguna baru ke dalam sistem.</p>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
                <ul class="list-disc pl-4 space-y-1 font-semibold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card p-6">
            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                            class="form-input">
                    </div>

                    <div>
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            required class="form-input">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="role" class="form-label">Peran (Role)</label>
                        <select name="role" id="role" required class="form-select">
                            <option value="admin">Admin</option>
                            <option value="bak_fakultas">BAK Fakultas</option>
                        </select>
                    </div>

                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input">
                    </div>
                </div>

                <div id="fakultas-container" class="hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="id_fakultas" class="form-label">Hubungkan Fakultas</label>
                            <select name="id_fakultas" id="id_fakultas" class="form-select">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach ($fakultas as $f)
                                    <option value="{{ $f->id_fakultas }}" {{ old('id_fakultas') == $f->id_fakultas ? 'selected' : '' }}>
                                        {{ $f->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" required class="form-input"
                            placeholder="Minimal 6 karakter">
                    </div>

                    <div>
                        <label for="aktif" class="form-label">Status Akun</label>
                        <select name="aktif" id="aktif" required class="form-select">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-full py-3 text-sm">
                    Simpan User
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function toggleFields() {
        var role = $('#role').val();
        if (role === 'bak_fakultas') {
            $('#fakultas-container').removeClass('hidden');
            $('#id_fakultas').prop('required', true);
        } else {
            $('#fakultas-container').addClass('hidden');
            $('#id_fakultas').prop('required', false).val('');
        }
    }

    $('#role').on('change', toggleFields);
    toggleFields();
});
</script>
@endpush
