@extends('layouts.app')

@section('title', 'Master Mahasiswa')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="page-title">Data Mahasiswa</h2>
                <p class="page-desc">Kelola data profil mahasiswa dan status kelulusan.</p>
            </div>
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Tambah Mahasiswa
            </a>
        </div>

        <div class="filter-bar">
            <div class="filter-label">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </div>
            <select id="filter-fakultas" class="filter-select">
                <option value="">Semua Fakultas</option>
                @foreach ($fakultasList as $f)
                    <option value="{{ $f->id_fakultas }}">{{ $f->nama_fakultas }}</option>
                @endforeach
            </select>
            <select id="filter-prodi" class="filter-select">
                <option value="">Semua Prodi</option>
                @foreach ($prodiList as $p)
                    <option value="{{ $p->id_prodi }}" data-fakultas="{{ $p->id_fakultas }}">{{ $p->nama_prodi }}</option>
                @endforeach
            </select>
        </div>

        <div class="card overflow-hidden">
            <div class="table-wrapper">
                <table id="table-mahasiswa" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th class="th">Nama Lengkap</th>
                            <th class="th">NIM</th>
                            <th class="th">Program Studi</th>
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
            var table = $('#table-mahasiswa').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('mahasiswa.datatable') }}',
                    data: function(d) {
                        d.id_fakultas = $('#filter-fakultas').val();
                        d.id_prodi = $('#filter-prodi').val();
                    }
                },
                language: {
                    url: '/i18n/id.json'
                },
                pageLength: 10,
                order: [],
                columns: [
                    { data: 'nama_lengkap' },
                    { data: 'nim' },
                    { data: 'prodi' },
                    { data: 'status' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            function filterProdiByFakultas() {
                var idFakultas = $('#filter-fakultas').val();
                $('#filter-prodi option').each(function() {
                    var $opt = $(this);
                    if ($opt.val() === '' || $opt.data('fakultas') == idFakultas || !idFakultas) {
                        $opt.show();
                    } else {
                        $opt.hide();
                    }
                });
                if ($('#filter-prodi').val() && !$('#filter-prodi').find('option:selected').is(':visible')) {
                    $('#filter-prodi').val('');
                }
            }

            $('#filter-fakultas').on('change', function() {
                filterProdiByFakultas();
                table.ajax.reload();
            });
            $('#filter-prodi').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush