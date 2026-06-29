@extends('layouts.app')

@section('title', 'Master Program Studi')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="page-title">Program Studi</h2>
                <p class="page-desc">Kelola data program studi, akreditasi, dan jenjang KKNI.</p>
            </div>
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('prodi.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Tambah Prodi
            </a>
            @endif
        </div>

        <div class="filter-bar">
            <div class="filter-label">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </div>
            <select id="filter-fakultas" class="filter-select">
                <option value="">Semua Fakultas</option>
                @foreach ($fakultasOptions as $opt)
                    <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
            </select>
        </div>

        <div class="card overflow-hidden">
            <div class="table-wrapper">
                <table id="table-prodi" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th class="th">Program Studi</th>
                            <th class="th">Jenjang / Gelar</th>
                            <th class="th">Akreditasi (SK)</th>
                            <th class="th">Fakultas</th>
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
            var table = $('#table-prodi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('prodi.datatable') }}',
                    data: function(d) {
                        d.id_fakultas = $('#filter-fakultas').val();
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
                        data: 'jenjang'
                    },
                    {
                        data: 'akreditasi'
                    },
                    {
                        data: 'fakultas'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#filter-fakultas').on('change', function() {
                table.draw();
            });
        });
    </script>
@endpush
