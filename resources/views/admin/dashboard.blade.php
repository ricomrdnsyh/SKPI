@extends('layout.main')
@section('title', 'Dashboard')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/buttons.dataTables.min.css') }}">
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

        .dataTable td.dt-control:before,
        .dataTable th.dt-control:before {
            display: none !important;
            content: "" !important;
        }

        table.dataTable td.dt-control,
        table.dataTable th.dt-control {
            position: relative !important;
            width: 28px !important;
            min-width: 28px !important;
            padding: 0 !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        table.dataTable.collapsed tbody tr:not(.child) td.dt-control:before,
        table.dataTable.collapsed tbody tr:not(.child) th.dt-control:before {
            display: inline-flex !important;
            content: "+" !important;
            position: absolute !important;
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, calc(-50% + 7px)) !important;
            width: 18px !important;
            height: 18px !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 999px !important;
            color: #fff !important;
            font-weight: 900 !important;
            font-size: 13px !important;
            line-height: 1 !important;
            background: #0d6efd !important;
            box-shadow: 0 0 0 2px #ffffff, 0 2px 6px rgba(0, 0, 0, .18) !important;
        }

        table.dataTable.collapsed tbody tr.parent:not(.child) td.dt-control:before,
        table.dataTable.collapsed tbody tr.parent:not(.child) th.dt-control:before {
            content: "-" !important;
            background: #dc3545 !important;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr>td.child,
        table.dataTable.dtr-inline.collapsed>tbody>tr>th.child,
        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dataTables_empty {
            cursor: default !important;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr>td.child:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr>th.child:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dataTables_empty:before {
            display: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid mt-7">
            <div id="kt_app_content_container" class="app-container container-fluid">

                <div class="card border-0 mb-8 rounded-4 overflow-hidden shadow-sm"
                    style="background: linear-gradient(135deg, #0A2342 0%, #1756A9 100%);">
                    <div class="position-absolute top-0 end-0 opacity-10">
                        <i class="ki-duotone ki-element-11 text-white"
                            style="font-size: 15rem; transform: translate(30%, -20%);">
                            <span class="path1"></span><span class="path2"></span><span class="path3"></span><span
                                class="path4"></span>
                        </i>
                    </div>
                    <div class="position-absolute bottom-0 start-0 opacity-10">
                        <i class="ki-duotone ki-shield-tick text-white"
                            style="font-size: 10rem; transform: translate(-30%, 30%);">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </div>

                    <div class="card-body py-6 py-md-10 px-6 px-md-8 position-relative z-index-1">
                        <div class="d-flex align-items-center justify-content-between flex-column flex-md-row gap-5">

                            <div
                                class="d-flex align-items-center flex-column flex-sm-row text-center text-sm-start gap-4 gap-sm-6">
                                <div class="symbol symbol-60px symbol-md-70px symbol-circle shadow-sm">
                                    <div
                                        class="symbol-label bg-white bg-opacity-10 border border-white border-dashed border-opacity-50">
                                        <i class="ki-duotone ki-shield-tick fs-2x fs-md-3x text-white"><span
                                                class="path1"></span><span class="path2"></span></i>
                                    </div>
                                </div>

                                <div class="d-flex flex-column">
                                    <h2 class="text-white fw-bolder fs-2 fs-md-1 mb-2">Dashboard Administrator</h2>
                                    <div class="text-white text-opacity-75 fs-6 fs-md-5 fw-semibold">
                                        Pantau seluruh antrian verifikasi dan alur penerbitan SKPI
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center w-100 w-md-auto">
                                <div class="bg-white bg-opacity-10 rounded-4 p-4 border border-white border-opacity-25 shadow-sm d-flex align-items-center justify-content-center gap-4 w-100"
                                    style="backdrop-filter: blur(8px);">
                                    <div class="symbol symbol-40px symbol-circle shadow-sm">
                                        <div class="symbol-label bg-white bg-opacity-25">
                                            <i class="ki-duotone ki-calendar fs-3 text-white"><span
                                                    class="path1"></span><span class="path2"></span></i>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column text-start">
                                        <span class="text-white text-opacity-75 fw-bold fs-7 text-uppercase mb-1">Hari
                                            Ini</span>
                                        <span
                                            class="text-white fw-bolder fs-5">{{ now()->translatedFormat('d F Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row g-5 g-xl-8 mb-8">
                    @php
                        $statCards = [
                            [
                                'label' => 'Total Pengajuan',
                                'value' => $skpiStats['total_pengajuan'],
                                'color' => 'primary',
                                'icon' => 'ki-abstract-14',
                            ],
                            [
                                'label' => 'Draft',
                                'value' => $skpiStats['draft'],
                                'color' => 'dark',
                                'icon' => 'ki-file',
                            ],
                            [
                                'label' => 'Diajukan',
                                'value' => $skpiStats['diajukan'],
                                'color' => 'warning',
                                'icon' => 'ki-time',
                            ],
                            [
                                'label' => 'Verifikasi',
                                'value' => $skpiStats['verifikasi'],
                                'color' => 'info',
                                'icon' => 'ki-document',
                            ],
                            [
                                'label' => 'Dicetak',
                                'value' => $skpiStats['dicetak'],
                                'color' => 'success',
                                'icon' => 'ki-check-circle',
                            ],
                            [
                                'label' => 'Ditolak',
                                'value' => $skpiStats['ditolak'],
                                'color' => 'danger',
                                'icon' => 'ki-cross-circle',
                            ],
                        ];
                    @endphp
                    @foreach ($statCards as $sc)
                        <div class="col-12 col-sm-6 col-md-4 col-xl mb-3 mb-xl-0">
                            <div
                                class="card bg-white border border-dashed border-{{ $sc['color'] }} shadow-sm hover-elevate-up h-100 overflow-hidden position-relative transition-all">
                                <div class="position-absolute top-0 end-0 mt-n4 me-n5 opacity-10">
                                    <i class="ki-duotone {{ $sc['icon'] }} text-{{ $sc['color'] }}"
                                        style="font-size: 8rem;">
                                        <span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span><span class="path4"></span>
                                    </i>
                                </div>

                                <div class="card-body d-flex flex-column p-6 position-relative z-index-1">
                                    <div class="d-flex justify-content-between align-items-start mb-5">
                                        <div class="symbol symbol-45px symbol-circle shadow-sm">
                                            <div
                                                class="symbol-label bg-light-{{ $sc['color'] }} border border-{{ $sc['color'] }} border-dashed">
                                                <i class="ki-duotone {{ $sc['icon'] }} fs-2 text-{{ $sc['color'] }}">
                                                    <span class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span><span class="path4"></span>
                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column text-start mt-auto">
                                        <span
                                            class="fs-2hx fw-bolder text-gray-800 me-2 lh-1 ls-n2">{{ $sc['value'] }}</span>
                                        <span class="fs-6 fw-semibold text-gray-500 mt-2">{{ $sc['label'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="card shadow-sm border border-dashed border-dark rounded">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Antrian Pengajuan SKPI</span>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end gap-2" data-kt-customer-table-toolbar="base">
                            </div>
                        </div>
                    </div>
                    <div class="card-body py-4 px-8 filter-container mt-4">
                        <div class="border border-dashed rounded p-5 mb-5" style="border-color: #b5b5c3 !important;">
                            <h5 class="text-primary mb-4"><i class="fas fa-filter text-primary me-2"></i>Filter Data</h5>
                            <div class="row g-5">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <label class="form-label fw-bold mb-2">Fakultas:</label>
                                    <select id="filter-fakultas" class="form-select form-select-sm" data-control="select2"
                                        data-placeholder="Semua Fakultas" data-allow-clear="true">
                                        <option value=""></option>
                                        @foreach ($fakultas as $id => $nama)
                                            <option value="{{ $id }}">{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <label class="form-label fw-bold mb-2">Program Studi:</label>
                                    <select id="filter-prodi" class="form-select form-select-sm" data-control="select2"
                                        data-placeholder="Semua Program Studi" data-allow-clear="true" disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <label class="form-label fw-bold mb-2">Tahun Akademik:</label>
                                    <select id="filter-tahun-akademik" class="form-select form-select-sm"
                                        data-control="select2" data-placeholder="Semua Tahun Akademik"
                                        data-allow-clear="true">
                                        <option value=""></option>
                                        @foreach ($tahun_akademiks as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ isset($active_tahun_akademik) && $active_tahun_akademik == $id ? 'selected' : '' }}>
                                                {{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12" id="status-filter-wrapper">
                                    <label class="form-label fw-bold mb-2">Status:</label>
                                    <select id="filter-status" class="form-select form-select-sm" data-control="select2"
                                        data-placeholder="Semua Status" data-hide-search="true" data-allow-clear="true">
                                        <option value=""></option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}">
                                                {{ ucwords(str_replace('_', ' ', $status)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table id="table-bak-fakultas" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="text-center p-0" style="width:28px; min-width:28px;"></th>
                                    <th class="text-center min-w-100px">Actions</th>
                                    <th class="min-w-150px">NIM</th>
                                    <th class="min-w-200px">Nama Mahasiswa</th>
                                    <th class="min-w-150px">Fakultas</th>
                                    <th class="min-w-150px">Program Studi</th>
                                    <th class="min-w-150px">Status</th>
                                    <th class="min-w-150px">Tanggal Pengajuan</th>
                                    <th class="min-w-150px">Verifikasi</th>
                                    <th class="min-w-150px">Progress</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bold text-gray-800">
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table-bak-fakultas').DataTable({
                processing: false,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: 0
                    }
                },
                columnDefs: [{
                    targets: 0,
                    className: 'dt-control',
                    orderable: false,
                    searchable: false
                }],
                ajax: {
                    url: '{{ route('bak_fakultas.datatable') }}',
                    data: function(d) {
                        d.fakultas = $('#filter-fakultas').val();
                        d.prodi = $('#filter-prodi').val();
                        d.status = $('#filter-status').val();
                        d.tahun_akademik = $('#filter-tahun-akademik').val();
                        d.tab = 'all';
                    }
                },
                language: {
                    url: '/i18n/id.json'
                },
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'colvis',
                        collectionLayout: 'fixed columns',
                        collectionTitle: 'Pengaturan Kolom',
                        className: 'btn btn-sm btn-primary mt-2 rounded-2',
                        columns: ':not(.noVis)'
                    },
                    {
                        extend: 'csv',
                        titleAttr: 'Csv',
                        title: 'Data SKPI',
                        className: 'btn btn-sm btn-primary mt-2 rounded-2'
                    },
                    {
                        extend: 'excel',
                        titleAttr: 'Excel',
                        title: 'Data SKPI',
                        className: 'btn btn-sm btn-primary mt-2 rounded-2'
                    }
                ],
                pageLength: 10,
                order: [
                    [7, 'desc']
                ],
                columns: [{
                        data: null,
                        defaultContent: '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'nim'
                    },
                    {
                        data: 'mahasiswa'
                    },
                    {
                        data: 'fakultas'
                    },
                    {
                        data: 'prodi'
                    }, {
                        data: 'status'
                    },
                    {
                        data: 'tanggal_pengajuan'
                    },
                    {
                        data: 'verifikasi'
                    },
                    {
                        data: 'progress'
                    }
                ],
                drawCallback: function(settings) {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                        '[data-bs-toggle="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    })
                }
            });

            const allProdis = @json($prodis);

            $('#filter-fakultas').on('change', function() {
                const fakultasId = $(this).val();
                const prodiSelect = $('#filter-prodi');

                prodiSelect.empty().append('<option value=""></option>');

                if (fakultasId) {
                    const filteredProdis = allProdis.filter(p => p.id_fakultas == fakultasId);
                    filteredProdis.forEach(p => {
                        prodiSelect.append(
                            `<option value="${p.nama_prodi}">${p.nama_prodi}</option>`);
                    });
                    prodiSelect.prop('disabled', false);
                } else {
                    prodiSelect.prop('disabled', true);
                }

                // Update UI select2
                prodiSelect.trigger('change.select2');
                table.draw();
            });

            $('#filter-prodi, #filter-status, #filter-tahun-akademik').on('change', function() {
                table.draw();
            });
        });
    </script>
@endsection
