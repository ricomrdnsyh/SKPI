@extends('layouts.app')

@section('title', 'Manajemen Magang')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="page-title">Magang / Kerja Praktik</h2>
                <p class="page-desc">Daftar riwayat magang / KP yang akan dicantumkan dalam SKPI setelah disetujui.</p>
            </div>
            <a href="{{ route('mahasiswa.magang.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i>
                Tambah Magang
            </a>
        </div>

        <div class="filter-bar">
            <div class="filter-label">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </div>
            <select id="filter-status" class="filter-select">
                <option value="">Semua Status</option>
                @foreach ($filterOptions['status'] as $v)
                    <option value="{{ $v }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="card overflow-hidden">
            <div class="table-wrapper">
                <table id="table-magang" class="display w-full">
                    <thead>
                        <tr>
                            <th class="th">Mitra Industri</th>
                            <th class="th">Posisi Intern</th>
                            <th class="th">Tanggal Mulai</th>
                            <th class="th">Tanggal Selesai</th>
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
            var table = $('#table-magang').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('mahasiswa.magang.datatable') }}',
                    data: function(d) {
                        d.status = $('#filter-status').val();
                    }
                },
                language: {
                    url: '/i18n/id.json'
                },
                pageLength: 10,
                order: [],
                columns: [{
                        data: 'mitra'
                    },
                    {
                        data: 'posisi'
                    },
                    {
                        data: 'tanggal_mulai'
                    },
                    {
                        data: 'tanggal_selesai'
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

            $('#filter-status').on('change', function() {
                table.draw();
            });
        });
    </script>
@endpush
