@extends('layout.main')
@section('title', 'Dashboard Admin')
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
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_content" class="app-content flex-column-fluid mt-7">
        <div id="kt_app_content_container" class="app-container container-fluid">
                <!-- Dashboard Banner -->
                <div class="card border-0 shadow-sm mb-8 rounded-4" style="background-color: #ffffff; background-image: radial-gradient(ellipse at top right, rgba(58, 123, 213, 0.08) 0%, transparent 60%); position: relative; overflow: hidden;">
                    
                    <!-- Left Accent Line -->
                    <div class="position-absolute top-0 start-0 h-100 w-5px bg-primary rounded-start"></div>

                    <div class="card-body py-6 py-md-10 px-6 px-md-8 position-relative z-index-1">
                        <div class="d-flex align-items-sm-center justify-content-between flex-column flex-sm-row gap-5">
                            <div class="d-flex align-items-center gap-4">
                                <div class="symbol symbol-45px symbol-md-60px symbol-circle shadow-sm">
                                    <div class="symbol-label bg-light-primary">
                                        <i class="ki-duotone ki-shield-tick fs-1 fs-md-2x text-primary"><span class="path1"></span><span class="path2"></span></i>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <h2 class="text-gray-900 fw-bolder fs-2 fs-md-2hx mb-1">Dashboard Administrator</h2>
                                    <div class="text-muted fs-7 fs-md-5 fw-semibold">
                                        Pantau seluruh antrian verifikasi dan alur penerbitan SKPI
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center bg-white rounded-pill px-4 px-md-6 py-2 py-md-3 border border-gray-200 shadow-sm w-100 w-sm-auto justify-content-center" style="transition: all 0.3s ease;" onmouseover="this.classList.add('shadow'); this.classList.remove('shadow-sm');" onmouseout="this.classList.remove('shadow'); this.classList.add('shadow-sm');">
                                <div class="symbol symbol-30px symbol-circle me-2 me-md-3">
                                    <div class="symbol-label bg-light-primary">
                                        <i class="ki-duotone ki-calendar fs-5 fs-md-4 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                    </div>
                                </div>
                                <span class="text-gray-800 fw-bold fs-7 fs-md-6">{{ now()->translatedFormat('l, d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SKPI Stats Cards -->
                <div class="row g-5 g-xl-8 mb-8">
                    @php
                        $statCards = [
                            [
                                'label' => 'Perlu Verifikasi',
                                'value' => $skpiStats['pending'],
                                'color' => 'warning',
                                'icon' => 'ki-time',
                            ],
                            [
                                'label' => 'Sedang Diproses',
                                'value' => $skpiStats['verifikasi'],
                                'color' => 'info',
                                'icon' => 'ki-arrows-circle',
                            ],
                            [
                                'label' => 'Permohonan Cetak',
                                'value' => $skpiStats['permohonan_cetak_count'],
                                'color' => 'primary',
                                'icon' => 'ki-printer',
                            ],
                            [
                                'label' => 'Sudah Tercetak',
                                'value' => $skpiStats['completed'],
                                'color' => 'success',
                                'icon' => 'ki-check-circle',
                            ],
                            [
                                'label' => 'Total Verifikasi',
                                'value' => $skpiStats['sudah_verifikasi'],
                                'color' => 'dark',
                                'icon' => 'ki-chart-bar',
                            ],
                        ];
                    @endphp
                    @foreach ($statCards as $sc)
                        <div class="col-12 col-sm-6 col-md-4 col-xl mb-3 mb-xl-0">
                            <div class="card border border-dashed border-{{ $sc['color'] }} bg-light-{{ $sc['color'] }} hover-elevate-up card-xl-stretch h-100 transition-all">
                                <div class="card-body d-flex flex-column justify-content-center text-center py-6">
                                    <div class="mb-3">
                                        <i class="ki-duotone {{ $sc['icon'] }} text-{{ $sc['color'] }} fs-3x"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                    </div>
                                    <div class="text-gray-900 fw-bolder fs-2 mb-1">{{ $sc['value'] }}</div>
                                    <div class="fw-bold text-{{ $sc['color'] }}">{{ $sc['label'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- SKPI Queue Table Start -->
                <div class="card shadow-sm border border-dashed border-dark rounded">
                    <div class="card-header border-0 pt-6 px-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-3 mb-1">Antrian Pengajuan SKPI</span>
                                </h3>
                            </div>
                        </div>
                        <div class="card-toolbar w-100 w-md-auto mt-4 mt-md-0">
                            <div class="d-flex flex-row justify-content-end gap-3 w-100" data-kt-customer-table-toolbar="base">
                                <div class="w-50 w-md-200px">
                                    <select id="filter-prodi" class="form-select form-select-sm w-100 fw-bold"
                                        data-control="select2" data-placeholder="Semua Prodi">
                                        <option value="">Semua Prodi</option>
                                        @foreach ($prodis as $prodi)
                                            <option value="{{ $prodi }}">{{ $prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="status-filter-wrapper" class="w-50 w-md-200px">
                                    <select id="filter-status" class="form-select form-select-sm w-100 fw-bold"
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
                        <div class="table-responsive" style="overflow-x: auto; overflow-y: hidden;">
                            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 fw-bold border-bottom-0 gap-4 mt-2 flex-nowrap text-nowrap" style="padding-bottom: 2px;">
                                <li class="nav-item">
                                <a class="nav-link active tab-btn text-active-warning px-2 transition-all"
                                    data-bs-toggle="tab" href="#" data-tab="belum">
                                    <i class="ki-duotone ki-time fs-2 me-2"><span class="path1"></span><span
                                            class="path2"></span></i> Belum Verifikasi
                                    <span class="badge badge-light-warning text-warning ms-2"
                                        id="count-belum">{{ $skpiStats['pending'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn text-active-primary px-2 transition-all" data-bs-toggle="tab"
                                    href="#" data-tab="permohonan_cetak">
                                    <i class="ki-duotone ki-printer fs-2 me-2"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></i> Permohonan Cetak
                                    <span class="badge badge-light-primary text-primary ms-2"
                                        id="count-permohonan-cetak">{{ $skpiStats['permohonan_cetak_count'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn text-active-success px-2 transition-all" data-bs-toggle="tab"
                                    href="#" data-tab="sudah">
                                    <i class="ki-duotone ki-check-circle fs-2 me-2"><span class="path1"></span><span
                                            class="path2"></span></i> Sudah Verifikasi
                                    <span class="badge badge-light-success text-success ms-2"
                                        id="count-sudah">{{ $skpiStats['sudah_verifikasi'] }}</span>
                                </a>
                            </li>
                        </ul>
                        </div>
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
                <!-- SKPI Queue Table End -->
                
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