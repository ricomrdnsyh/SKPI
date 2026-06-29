@extends('layouts.app')

@section('title', 'Master Fakultas')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="page-title">Data Fakultas</h2>
                <p class="page-desc">Kelola data fakultas dan pimpinan dekanat.</p>
            </div>
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('fakultas.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Tambah Fakultas
            </a>
            @endif
        </div>

        <div class="card overflow-hidden">
            <div class="table-wrapper">
                <table id="table-fakultas" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th class="th">Nama Fakultas</th>
                            <th class="th">Kode</th>
                            <th class="th">Dekan</th>
                            <th class="th">Aksi</th>
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
            $('#table-fakultas').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('fakultas.datatable') }}',
                language: {
                    url: '/i18n/id.json'
                },
                pageLength: 10,
                order: [],
                columns: [{
                        data: 'nama_fakultas'
                    },
                    {
                        data: 'kode'
                    },
                    {
                        data: 'dekan'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
