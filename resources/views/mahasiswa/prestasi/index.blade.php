@extends('layouts.app')

@section('title', 'Manajemen Prestasi')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between animate-fade-in">
            <div>
                <h2 class="page-title">Prestasi Mahasiswa</h2>
                <p class="page-desc">Daftar capaian prestasi yang akan dicantumkan dalam SKPI setelah disetujui.</p>
            </div>
            <a href="{{ route('mahasiswa.prestasi.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i>
                Tambah Prestasi
            </a>
        </div>

        <div class="filter-bar">
            <div class="filter-label">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </div>
            <select id="filter-tingkat" class="filter-select">
                <option value="">Semua Tingkat</option>
                @foreach ($filterOptions['tingkat'] as $v)
                    <option value="{{ $v }}">{{ $v }}</option>
                @endforeach
            </select>
            <select id="filter-tahun" class="filter-select">
                <option value="">Semua Tahun</option>
                @foreach ($filterOptions['tahun'] as $v)
                    <option value="{{ $v }}">{{ $v }}</option>
                @endforeach
            </select>
            <select id="filter-status" class="filter-select">
                <option value="">Semua Status</option>
                @foreach ($filterOptions['status'] as $v)
                    <option value="{{ $v }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="card overflow-hidden animate-fade-in" style="animation-delay: 0.1s">
            <div class="table-wrapper">
                <table id="table-prestasi" class="display w-full">
                    <thead>
                        <tr>
                            <th class="th">Nama Prestasi</th>
                            <th class="th">Tingkat</th>
                            <th class="th">Peringkat</th>
                            <th class="th">Penyelenggara</th>
                            <th class="th">Tahun</th>
                            <th class="th">Bukti</th>
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
            var table = $('#table-prestasi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('mahasiswa.prestasi.datatable') }}',
                    data: function(d) {
                        d.tingkat = $('#filter-tingkat').val();
                        d.tahun = $('#filter-tahun').val();
                        d.status = $('#filter-status').val();
                    }
                },
                language: {
                    url: '/i18n/id.json'
                },
                pageLength: 10,
                order: [],
                columns: [{
                        data: 'nama_prestasi'
                    },
                    {
                        data: 'tingkat'
                    },
                    {
                        data: 'peringkat'
                    },
                    {
                        data: 'penyelenggara'
                    },
                    {
                        data: 'tahun'
                    },
                    {
                        data: 'bukti',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#filter-tingkat, #filter-tahun, #filter-status').on('change', function() {
                table.draw();
            });
        });
    </script>
@endpush
