@extends('layout.main')

@section('title', 'Dashboard BAAK Fakultas')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
    <style>
        .table-row-dashed tr {
            border-bottom: 1px dashed #cccccc !important;
        }

        .dataTable thead tr th {
            vertical-align: middle;
            border-bottom: 1px dashed #cccccc !important;
        }

        .dataTable th,
        .dataTable td {
            vertical-align: middle !important;
        }
    </style>
@endsection
@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content flex-column-fluid mt-7">
                <div id="kt_app_content_container" class="app-container container-fluid">

                    {{-- Welcome Banner --}}
                    <div class="card border-0 shadow-sm mb-8 overflow-hidden"
                        style="background: linear-gradient(112.14deg, #10B981 0%, #059669 100%);">
                        <div class="card-body py-8 position-relative">
                            <!-- BG pattern -->
                            <div class="position-absolute top-0 end-0 opacity-10">
                                <i class="ki-duotone ki-abstract-14 fs-10x text-white"><span class="path1"></span><span
                                        class="path2"></span></i>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap gap-4 position-relative z-index-1">
                                <div class="d-flex flex-column">
                                    <h2 class="text-white fw-bolder fs-1 mb-2">Dashboard BAAK Fakultas</h2>
                                    <div class="text-white opacity-75 fs-6 fw-semibold">Kelola antrian verifikasi dan alur
                                        penerbitan SKPI dengan mudah dan cepat.</div>
                                </div>
                                <div
                                    class="d-flex align-items-center bg-white bg-opacity-20 rounded px-5 py-3 border border-white border-opacity-25 shadow-sm">
                                    <i class="ki-duotone ki-calendar fs-2 text-white me-2"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span class="text-white fw-bold fs-6">{{ now()->translatedFormat('l, d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Stats Grid --}}
                    <div class="row g-5 g-xl-8 mb-8">
                        @php
                            $statCards = [
                                [
                                    'label' => 'Perlu Verifikasi',
                                    'value' => $stats['pending'],
                                    'color' => 'warning',
                                    'icon' => 'ki-time',
                                ],
                                [
                                    'label' => 'Sedang Diproses',
                                    'value' => $stats['verifikasi'],
                                    'color' => 'info',
                                    'icon' => 'ki-arrows-circle',
                                ],
                                [
                                    'label' => 'Permohonan Cetak',
                                    'value' => $stats['permohonan_cetak_count'],
                                    'color' => 'primary',
                                    'icon' => 'ki-printer',
                                ],
                                [
                                    'label' => 'Sudah Tercetak',
                                    'value' => $stats['completed'],
                                    'color' => 'success',
                                    'icon' => 'ki-check-circle',
                                ],
                                [
                                    'label' => 'Total Verifikasi',
                                    'value' => $stats['sudah_verifikasi'],
                                    'color' => 'dark',
                                    'icon' => 'ki-chart-bar',
                                ],
                            ];
                        @endphp
                        @foreach ($statCards as $sc)
                            <div class="col-12 col-sm-6 col-md-4 col-xl mb-3 mb-xl-0">
                                <div
                                    class="card border border-dashed border-{{ $sc['color'] }} bg-light-{{ $sc['color'] }} hover-elevate-up card-xl-stretch h-100 transition-all">
                                    <div class="card-body d-flex flex-column justify-content-center text-center py-6">
                                        <div class="mb-3">
                                            <i class="ki-duotone {{ $sc['icon'] }} text-{{ $sc['color'] }} fs-3x"><span
                                                    class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span><span class="path4"></span></i>
                                        </div>
                                        <div class="text-gray-900 fw-bolder fs-2 mb-1">{{ $sc['value'] }}</div>
                                        <div class="fw-bold text-{{ $sc['color'] }}">{{ $sc['label'] }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Card for Tabs and Table --}}
                    <div class="card shadow-sm border border-dashed border-dark rounded">
                        <div class="card-header border-0 pt-6 px-6">
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder fs-3 mb-1">Antrian Pengajuan SKPI</span>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <div class="d-flex justify-content-end gap-3" data-kt-customer-table-toolbar="base">
                                    <select id="filter-prodi" class="form-select form-select-sm w-250px fw-bold"
                                        data-control="select2" data-placeholder="Semua Prodi">
                                        <option value="">Semua Prodi</option>
                                        @foreach ($prodis as $prodi)
                                            <option value="{{ $prodi }}">{{ $prodi }}</option>
                                        @endforeach
                                    </select>
                                    <div id="status-filter-wrapper">
                                        <select id="filter-status" class="form-select form-select-sm w-200px fw-bold"
                                            data-control="select2" data-placeholder="Semua Status" data-hide-search="true">
                                            <option value="">Semua Status</option>
                                            @foreach ($statuses as $status)
                                                @if ($status !== 'diajukan')
                                                    <option value="{{ $status }}">
                                                        {{ ucwords(str_replace('_', ' ', $status)) }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0 px-6">
                            <ul
                                class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 fw-bold border-bottom-0 gap-4 mt-2">
                                <li class="nav-item">
                                    <a class="nav-link active tab-btn text-active-warning px-2 transition-all"
                                        data-bs-toggle="tab" href="#" data-tab="belum">
                                        <i class="ki-duotone ki-time fs-2 me-2"><span class="path1"></span><span
                                                class="path2"></span></i> Belum Verifikasi
                                        <span class="badge badge-light-warning text-warning ms-2"
                                            id="count-belum">{{ $stats['pending'] }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link tab-btn text-active-primary px-2 transition-all" data-bs-toggle="tab"
                                        href="#" data-tab="permohonan_cetak">
                                        <i class="ki-duotone ki-printer fs-2 me-2"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span></i> Permohonan Cetak
                                        <span class="badge badge-light-primary text-primary ms-2"
                                            id="count-permohonan-cetak">{{ $stats['permohonan_cetak_count'] }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link tab-btn text-active-success px-2 transition-all" data-bs-toggle="tab"
                                        href="#" data-tab="sudah">
                                        <i class="ki-duotone ki-check-circle fs-2 me-2"><span class="path1"></span><span
                                                class="path2"></span></i> Sudah Verifikasi
                                        <span class="badge badge-light-success text-success ms-2"
                                            id="count-sudah">{{ $stats['sudah_verifikasi'] }}</span>
                                    </a>
                                </li>
                            </ul>

                            <table id="table-bak-fakultas" class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="text-center min-w-100px">Aksi</th>
                                        <th class="min-w-200px">Mahasiswa</th>
                                        <th class="min-w-150px">Prodi</th>
                                        <th class="min-w-100px">Tanggal</th>
                                        <th class="min-w-100px">Verifikasi</th>
                                        <th class="min-w-150px">Progress</th>
                                        <th class="min-w-100px">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-700">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var activeTab = 'belum';
            $('#status-filter-wrapper').hide();

            var table = $('#table-bak-fakultas').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('bak_fakultas.datatable') }}',
                    data: function(d) {
                        d.prodi = $('#filter-prodi').val();
                        d.status = $('#filter-status').val();
                        d.tab = activeTab;
                    }
                },
                language: {
                    url: '/i18n/id.json'
                },
                dom: "<'row mb-4'<'col-sm-6 d-flex align-items-center justify-content-start'l><'col-sm-6 d-flex align-items-center justify-content-end'f>>" +
                    "<'table-responsive'tr>" +
                    "<'row mt-4'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>",
                pageLength: 10,
                order: [],
                columns: [{
                        data: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'mahasiswa'
                    },
                    {
                        data: 'prodi'
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'verifikasi'
                    },
                    {
                        data: 'progress'
                    },
                    {
                        data: 'status'
                    }
                ],
                drawCallback: function(settings) {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    })
                }
            });

            $('#filter-prodi, #filter-status').on('change', function() {
                table.draw();
            });

            $('.tab-btn').on('click', function(e) {
                e.preventDefault();
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');
                activeTab = $(this).data('tab');

                if (activeTab === 'belum' || activeTab === 'permohonan_cetak') {
                    $('#filter-status').val('').trigger('change');
                    $('#status-filter-wrapper').hide();
                } else {
                    $('#status-filter-wrapper').show();
                }

                table.column(4).visible(true);
                table.column(5).visible(true);

                table.draw();
            });
        });
    </script>
@endsection
