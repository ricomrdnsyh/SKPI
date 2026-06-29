@extends('layouts.app')

@section('title', 'Master Kurikulum')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="page-title">Kurikulum Program Studi</h2>
                <p class="page-desc">Kelola data kurikulum per program studi berdasarkan tahun.</p>
            </div>
            <a href="{{ route('kurikulum.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Tambah Kurikulum
            </a>
        </div>

        <div class="filter-bar">
            <div class="filter-label">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </div>
            <select id="filter-prodi" class="filter-select">
                <option value="">Semua Program Studi</option>
                @foreach ($prodiList as $prodi)
                    <option value="{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>
        </div>

        <div class="card overflow-hidden">
            <div class="table-wrapper">
                <table id="table-kurikulum" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th class="th">Program Studi</th>
                            <th class="th">Nama Kurikulum</th>
                            <th class="th">Tahun</th>
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
            var table = $('#table-kurikulum').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('kurikulum.datatable') }}',
                    data: function(d) {
                        d.id_prodi = $('#filter-prodi').val();
                    }
                },
                language: {
                    url: '/i18n/id.json'
                },
                pageLength: 10,
                order: [],
                columns: [{
                        data: 'prodi'
                    },
                    {
                        data: 'nama_kurikulum'
                    },
                    {
                        data: 'tahun'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#filter-prodi').on('change', function() {
                table.draw();
            });
        });
    </script>
@endpush
