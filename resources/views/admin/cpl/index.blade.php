@extends('layouts.app')

@section('title', 'Master CPL Prodi')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="page-title">Capaian Pembelajaran Lulusan (CPL)</h2>
                <p class="page-desc">Kelola data kompetensi / CPL berdasarkan masing-masing program studi.</p>
            </div>
            <a href="{{ route('cpl.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Tambah CPL
            </a>
        </div>

        <div class="filter-bar">
            <div class="filter-label">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </div>
            <select id="filter-prodi" class="filter-select">
                <option value="">-- Semua Prodi --</option>
                @foreach ($prodiList as $p)
                    <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                @endforeach
            </select>
            <select id="filter-kurikulum" class="filter-select">
                <option value="">-- Semua Kurikulum --</option>
                @foreach ($kurikulumList as $k)
                    <option value="{{ $k->id_kurikulum }}">{{ $k->nama_kurikulum }}</option>
                @endforeach
            </select>
        </div>

        <div class="card overflow-hidden">
            <div class="table-wrapper">
                <table id="table-cpl" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th class="th">Prodi</th>
                            <th class="th">Kurikulum</th>
                            <th class="th">Kategori</th>
                            <th class="th">Kode CPL</th>
                            <th class="th">Deskripsi</th>
                            <th class="th">Urutan</th>
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
            let table = $('#table-cpl').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('cpl.datatable') }}',
                    data: function(d) {
                        d.id_prodi = $('#filter-prodi').val();
                        d.id_kurikulum = $('#filter-kurikulum').val();
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
                        data: 'kurikulum'
                    },
                    {
                        data: 'kategori'
                    },
                    {
                        data: 'kode_cpl'
                    },
                    {
                        data: 'deskripsi'
                    },
                    {
                        data: 'urutan'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#filter-prodi, #filter-kurikulum').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
