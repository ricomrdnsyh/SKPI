@extends('layouts.app')

@section('title', 'Manajemen Organisasi')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="page-title">Organisasi Mahasiswa</h2>
                <p class="page-desc">Daftar keaktifan organisasi yang akan dicantumkan dalam SKPI setelah disetujui.</p>
            </div>
            <a href="{{ route('mahasiswa.organisasi.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i>
                Tambah Organisasi
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
            <select id="filter-status" class="filter-select">
                <option value="">Semua Status</option>
                @foreach ($filterOptions['status'] as $v)
                    <option value="{{ $v }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="card overflow-hidden">
            <div class="table-wrapper">
                <table id="table-organisasi" class="display w-full">
                    <thead>
                        <tr>
                            <th class="th">Nama Organisasi</th>
                            <th class="th">Tingkat</th>
                            <th class="th">Jabatan</th>
                            <th class="th">Tahun Mulai</th>
                            <th class="th">Tahun Selesai</th>
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
            var table = $('#table-organisasi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('mahasiswa.organisasi.datatable') }}',
                    data: function(d) {
                        d.tingkat = $('#filter-tingkat').val();
                        d.status = $('#filter-status').val();
                    }
                },
                language: {
                    url: '/i18n/id.json'
                },
                pageLength: 10,
                order: [],
                columns: [{
                        data: 'nama_organisasi'
                    },
                    {
                        data: 'tingkat'
                    },
                    {
                        data: 'jabatan'
                    },
                    {
                        data: 'tahun_mulai'
                    },
                    {
                        data: 'tahun_selesai'
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

            $('#filter-tingkat, #filter-status').on('change', function() {
                table.draw();
            });
        });
    </script>
@endpush
