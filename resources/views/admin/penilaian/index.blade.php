@extends('layouts.app')

@section('title', 'Master Sistem Penilaian')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="page-title">Sistem Penilaian</h2>
                <p class="page-desc">Kelola data konversi nilai huruf secara global.</p>
            </div>
            <a href="{{ route('penilaian.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Tambah Penilaian
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="table-wrapper">
                <table id="table-penilaian" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th class="th">Nilai Huruf</th>
                            <th class="th">Nilai Minimum</th>
                            <th class="th">Nilai Maksimum</th>
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
            var table = $('#table-penilaian').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('penilaian.datatable') }}',
                language: {
                    url: '/i18n/id.json'
                },
                pageLength: 10,
                order: [],
                columns: [
                    {
                        data: 'nilai_huruf'
                    },
                    {
                        data: 'nilai_min'
                    },
                    {
                        data: 'nilai_max'
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
