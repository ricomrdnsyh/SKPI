@extends('layouts.app')

@section('title', 'Master Kategori CPL')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="page-title">Data Kategori CPL</h2>
                <p class="page-desc">Kelola data kategori Capaian Pembelajaran Lulusan (CPL) program studi.</p>
            </div>
            <a href="{{ route('kategori-cpl.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Tambah Kategori CPL
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="table-wrapper">
                <table id="table-kategori-cpl" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th class="th">Kode Kategori</th>
                            <th class="th">Nama Kategori</th>
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
            $('#table-kategori-cpl').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('kategori-cpl.datatable') }}',
                language: {
                    url: '/i18n/id.json'
                },
                pageLength: 10,
                order: [],
                columns: [
                    { data: 'kode_kategori' },
                    { data: 'nama_kategori' },
                    { data: 'urutan' },
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
