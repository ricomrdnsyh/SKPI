@extends('layout.main')

@section('title', 'Rekapitulasi SKPI')

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

        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control,
        table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
        }

        .dt-buttons .btn-export-primary,
        .dt-buttons .btn-export-primary:focus,
        .dt-buttons .btn-export-primary:hover,
        .dt-buttons .btn-export-primary:active {
            background: #004289 !important;
            border-color: #004289 !important;
            color: #fff !important;
        }

        .dt-buttons .btn-export-primary:focus {
            box-shadow: none !important;
        }

        .dt-buttons .btn-export-primary i {
            color: #fff !important;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid mt-7">
            <div id="kt_app_content_container" class="app-container container-fluid">
                
                @if($role === 'admin')
                <div class="row g-5 g-xl-8 mb-8">
                    <div class="col-12 col-sm-6 col-md-4 col-xl mb-3 mb-xl-0">
                        <div class="card bg-white border border-dashed border-success shadow-sm hover-elevate-up h-100 overflow-hidden position-relative transition-all">
                            <div class="position-absolute top-0 end-0 mt-n4 me-n5 opacity-10">
                                <i class="ki-duotone ki-check-circle text-success" style="font-size: 8rem;">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </div>

                            <div class="card-body d-flex flex-column p-6 position-relative z-index-1">
                                <div class="d-flex justify-content-between align-items-start mb-5">
                                    <div class="symbol symbol-45px symbol-circle shadow-sm">
                                        <div class="symbol-label bg-light-success border border-success border-dashed">
                                            <i class="ki-duotone ki-check-circle fs-2 text-success">
                                                <span class="path1"></span><span class="path2"></span>
                                            </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column text-start mt-auto">
                                    <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1 ls-n2">{{ $totalSkpiGlobal }}</span>
                                    <span class="fs-6 fw-semibold text-gray-500 mt-2">Total SKPI Selesai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @foreach ($statsPerFakultas as $stat)
                    <div class="col-12 col-sm-6 col-md-4 col-xl mb-3 mb-xl-0">
                        <div class="card bg-white border border-dashed border-primary shadow-sm hover-elevate-up h-100 overflow-hidden position-relative transition-all">
                            <div class="position-absolute top-0 end-0 mt-n4 me-n5 opacity-10">
                                <i class="ki-duotone ki-bank text-primary" style="font-size: 8rem;">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </div>

                            <div class="card-body d-flex flex-column p-6 position-relative z-index-1">
                                <div class="d-flex justify-content-between align-items-start mb-5">
                                    <div class="symbol symbol-45px symbol-circle shadow-sm">
                                        <div class="symbol-label bg-light-primary border border-primary border-dashed">
                                            <i class="ki-duotone ki-bank fs-2 text-primary">
                                                <span class="path1"></span><span class="path2"></span>
                                            </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column text-start mt-auto">
                                    <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1 ls-n2">{{ $stat->total }}</span>
                                    <span class="fs-6 fw-semibold text-gray-500 mt-2">{{ $stat->nama_fakultas }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="card shadow-sm border border-dashed border-dark rounded">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Daftar Rekapitulasi SKPI Selesai</span>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end gap-2" data-kt-customer-table-toolbar="base">
                                <a href="#" id="btn-download-zip" class="btn btn-sm btn-primary">
                                    <i class="ki-duotone ki-file-down fs-2"><span class="path1"></span><span class="path2"></span></i> Download Semua PDF (ZIP)
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body py-4 px-8 filter-container mt-4">
                        <div class="border border-dashed rounded p-5 mb-5" style="border-color: #b5b5c3 !important;">
                            <h5 class="text-primary mb-4"><i class="fas fa-filter text-primary me-2"></i>Filter Data</h5>
                            <div class="row g-5">
                                @php
                                    $colClass = $role === 'admin' ? 'col-lg-4 col-md-4 col-sm-12' : 'col-lg-6 col-md-6 col-sm-12';
                                @endphp
                                @if($role === 'admin')
                                <div class="{{ $colClass }}">
                                    <label class="form-label fw-bold mb-2">Fakultas:</label>
                                    <select id="filter-fakultas" class="form-select form-select-sm" data-control="select2"
                                        data-placeholder="Semua Fakultas" data-allow-clear="true">
                                        <option value=""></option>
                                        @foreach ($fakultas as $id => $nama)
                                            <option value="{{ $id }}">{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="{{ $colClass }}">
                                    <label class="form-label fw-bold mb-2">Program Studi:</label>
                                    <select id="filter-prodi" class="form-select form-select-sm" data-control="select2"
                                        data-placeholder="Semua Program Studi" data-allow-clear="true" {{ $role === 'admin' ? 'disabled' : '' }}>
                                        <option value=""></option>
                                        @foreach ($prodis as $prodi)
                                            <option value="{{ $prodi->id_prodi }}" data-fakultas="{{ $prodi->id_fakultas ?? '' }}">{{ $prodi->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="{{ $colClass }}">
                                    <label class="form-label fw-bold mb-2">Tahun Akademik:</label>
                                    <select id="filter-tahun" class="form-select form-select-sm" data-control="select2"
                                        data-placeholder="Semua Tahun Akademik" data-allow-clear="true">
                                        <option value=""></option>
                                        @foreach ($tahun_akademiks as $id => $nama)
                                            <option value="{{ $id }}" {{ $id == $active_tahun_akademik ? 'selected' : '' }}>{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="table-rekapitulasi">
                                <thead class="">
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">No</th>
                                        <th class="min-w-150px">Nama Mahasiswa</th>
                                        <th class="min-w-100px">NIM</th>
                                        <th class="min-w-150px">Fakultas</th>
                                        <th class="min-w-150px">Program Studi</th>
                                        <th class="min-w-150px">No. SKPI</th>
                                        <th class="min-w-100px">Tanggal Terbit</th>
                                        <th class="text-center min-w-100px">Aksi</th>
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
            var table = $('#table-rekapitulasi').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('rekapitulasi.datatable') }}',
                    data: function(d) {
                        d.fakultas_filter = $('#filter-fakultas').val() || '';
                        d.prodi_filter = $('#filter-prodi').val();
                        d.tahun_akademik_filter = $('#filter-tahun').val();
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
                        title: 'Data Rekapitulasi SKPI',
                        className: 'btn btn-sm btn-primary mt-2 rounded-2'
                    },
                    {
                        extend: 'excel',
                        titleAttr: 'Excel',
                        title: 'Data Rekapitulasi SKPI',
                        className: 'btn btn-sm btn-primary mt-2 rounded-2'
                    }
                ],
                pageLength: 10,
                order: [
                    [6, 'desc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'nama_lengkap',
                        name: 'mahasiswa.nama_lengkap'
                    },
                    {
                        data: 'nim',
                        name: 'mahasiswa.nim'
                    },
                    {
                        data: 'nama_fakultas',
                        name: 'fakultas.nama_fakultas'
                    },
                    {
                        data: 'nama_prodi',
                        name: 'program_studi.nama_prodi'
                    },
                    {
                        data: 'nomor_skpi',
                        name: 'skpi.nomor_skpi'
                    },
                    {
                        data: 'tanggal_terbit',
                        name: 'skpi.tanggal_terbit'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
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
            @if($role === 'admin')
            var allProdiOptions = $('#filter-prodi option').clone();
            
            $('#filter-fakultas').on('change', function() {
                var fakultasId = $(this).val();
                var $prodiSelect = $('#filter-prodi');
                var currentVal = $prodiSelect.val();
                
                $prodiSelect.empty();
                $prodiSelect.append(allProdiOptions.filter('[value=""]'));
                
                if (fakultasId) {
                    $prodiSelect.prop('disabled', false);
                    $prodiSelect.append(allProdiOptions.filter(function() {
                        return $(this).data('fakultas') == fakultasId;
                    }));
                } else {
                    $prodiSelect.prop('disabled', true);
                }
                
                if ($prodiSelect.find('option[value="' + currentVal + '"]').length) {
                    $prodiSelect.val(currentVal);
                } else {
                    $prodiSelect.val('');
                }
                
                $prodiSelect.trigger('change.select2');
                table.draw();
            });
            
            $('#filter-prodi, #filter-tahun').on('change', function() {
                table.draw();
            });
            @else
            $('#filter-prodi, #filter-tahun').on('change', function() {
                table.draw();
            });
            @endif

            $('#btn-download-zip').on('click', function(e) {
                e.preventDefault();
                var url = '{{ route('rekapitulasi.download_zip') }}?';
                var params = new URLSearchParams();
                if ($('#filter-fakultas').length) {
                    params.append('fakultas_filter', $('#filter-fakultas').val() || '');
                }
                params.append('prodi_filter', $('#filter-prodi').val() || '');
                params.append('tahun_akademik_filter', $('#filter-tahun').val() || '');
                
                // SweetAlert for processing
                Swal.fire({
                    title: 'Memproses ZIP',
                    text: 'Sedang men-generate PDF dan mengompresnya. Mohon tunggu...',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Redirect to download URL
                window.location.href = url + params.toString();
                
                // Hide Swal after a few seconds (since download triggers in browser)
                setTimeout(function() {
                    Swal.close();
                }, 5000);
            });
        });
    </script>
@endsection
