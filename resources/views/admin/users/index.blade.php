@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="page-title">Manajemen Pengguna</h2>
                <p class="page-desc">Kelola data pengguna, peranan, dan status keaktifan akun.</p>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-user-plus"></i>
                Tambah Pengguna
            </a>
        </div>

        <div class="filter-bar">
            <div class="filter-label">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </div>
            <select id="filter-role" class="filter-select">
                <option value="">Semua Role</option>
                @foreach ($roleOptions as $role)
                    <option value="{{ $role }}">{{ ucfirst(str_replace('_', ' ', $role)) }}</option>
                @endforeach
            </select>
            <select id="filter-prodi" class="filter-select">
                <option value="">Semua Prodi</option>
                @foreach ($prodiList as $prodi)
                    <option value="{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>
        </div>

        <div class="card overflow-hidden">
            <div class="table-wrapper">
                <table id="table-users" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th class="th">Nama Lengkap</th>
                            <th class="th">Username</th>
                            <th class="th">Peran (Role)</th>
                            <th class="th">Hubungan Akademik</th>
                            <th class="th">Status</th>
                            <th class="th text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#table-users').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('users.datatable') }}',
                    data: function(d) {
                        d.role = $('#filter-role').val();
                        d.id_prodi = $('#filter-prodi').val();
                    }
                },
                language: {
                    url: '/i18n/id.json'
                },
                pageLength: 10,
                order: [],
                columns: [{
                        data: 'nama_lengkap'
                    },
                    {
                        data: 'username'
                    },
                    {
                        data: 'role'
                    },
                    {
                        data: 'hubungan'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });
            $('#filter-role, #filter-prodi').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
