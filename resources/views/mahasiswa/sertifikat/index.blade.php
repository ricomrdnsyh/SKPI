@extends('layouts.app')

@section('title', 'Manajemen Sertifikat')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="page-title">Sertifikat Mahasiswa</h2>
                <p class="page-desc">Daftar sertifikat keahlian / pelatihan yang akan dicantumkan dalam SKPI setelah
                    disetujui.</p>
            </div>
            <a href="{{ route('mahasiswa.sertifikat.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i>
                Tambah Sertifikat
            </a>
        </div>

        <div class="filter-bar">
            <div class="filter-label">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </div>
            <select id="filter-jenis" class="filter-select">
                <option value="">Semua Jenis</option>
                @foreach ($filterOptions['jenis_sertifikat'] as $v)
                    <option value="{{ $v }}">{{ $v }}</option>
                @endforeach
            </select>
            <select id="filter-bidang" class="filter-select">
                <option value="">Semua Bidang</option>
                @foreach ($filterOptions['bidang'] as $v)
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
                <table id="table-sertifikat" class="display w-full">
                    <thead>
                        <tr>
                            <th class="th">Nama Sertifikat</th>
                            <th class="th">Jenis</th>
                            <th class="th">Bidang</th>
                            <th class="th">Penyelenggara</th>
                            <th class="th">Tanggal Terbit</th>
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
            var table = $('#table-sertifikat').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('mahasiswa.sertifikat.datatable') }}',
                    data: function(d) {
                        d.jenis = $('#filter-jenis').val();
                        d.bidang = $('#filter-bidang').val();
                        d.status = $('#filter-status').val();
                    }
                },
                language: {
                    url: '/i18n/id.json'
                },
                pageLength: 10,
                order: [],
                columns: [{
                        data: 'nama_sertifikat'
                    },
                    {
                        data: 'jenis'
                    },
                    {
                        data: 'bidang'
                    },
                    {
                        data: 'penyelenggara'
                    },
                    {
                        data: 'tanggal_terbit'
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

            $('#filter-jenis, #filter-bidang, #filter-status').on('change', function() {
                table.draw();
            });
        });
    </script>
@endpush
