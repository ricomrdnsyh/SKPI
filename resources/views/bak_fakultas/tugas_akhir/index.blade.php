@extends('layout.main')
@section('title', 'Tugas Akhir')
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
                <div class="card shadow-sm border border-dashed border-dark rounded">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <h3 class="card-title align-items-start flex-column"><span
                                        class="card-label fw-bolder fs-3 mb-1">List Tugas Akhir</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="separator my-5"></div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="table-tugas-akhir">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="text-center p-0" style="width:28px; min-width:28px;"></th>
                                    <th class="text-center min-w-100px">Actions</th>
                                    <th class="min-w-100px">NIM</th>
                                    <th class="min-w-150px">Mahasiswa</th>
                                    <th class="min-w-200px">Judul</th>
                                    <th class="min-w-150px">Pembimbing</th>
                                    <th class="min-w-100px">Status</th>
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

    <!-- Modal Detail -->
    <div class="modal fade" id="modal_detail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Tugas Akhir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="fv-row mb-5">
                        <label class="form-label fw-bolder text-dark fs-6">NIM</label>
                        <div class="form-control form-control-sm bg-light" id="detail_nim"></div>
                    </div>
                    <div class="fv-row mb-5">
                        <label class="form-label fw-bolder text-dark fs-6">Nama Mahasiswa</label>
                        <div class="form-control form-control-sm bg-light" id="detail_mahasiswa"></div>
                    </div>
                    <div class="fv-row mb-5">
                        <label class="form-label fw-bolder text-dark fs-6">Judul Tugas Akhir</label>
                        <div class="form-control form-control-sm bg-light h-auto" style="min-height: 70px;"
                            id="detail_judul"></div>
                    </div>
                    <div class="fv-row mb-5">
                        <label class="form-label fw-bolder text-dark fs-6">Pembimbing 1</label>
                        <div class="form-control form-control-sm bg-light" id="detail_pembimbing_1"></div>
                    </div>
                    <div class="fv-row mb-5">
                        <label class="form-label fw-bolder text-dark fs-6">Pembimbing 2</label>
                        <div class="form-control form-control-sm bg-light" id="detail_pembimbing_2"></div>
                    </div>
                    <div class="fv-row mb-5">
                        <label class="form-label fw-bolder text-dark fs-6">Status</label>
                        <div id="detail_status" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tugas Akhir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="kt_modal_edit_form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_id_tugas_akhir" name="id_tugas_akhir">

                        <div class="fv-row mb-5">
                            <label class="form-label required fw-bolder text-dark fs-6">Mahasiswa</label>
                            <select class="form-select form-select-sm" data-control="select2"
                                data-dropdown-parent="#form_edit" data-placeholder="Pilih Mahasiswa" name="nim"
                                id="edit_nim" required>
                                <option value="">Pilih Mahasiswa</option>
                                @foreach ($mahasiswas as $m)
                                    <option value="{{ $m->nim }}">{{ $m->nim }} - {{ $m->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row mb-5">
                            <label class="form-label required fw-bolder text-dark fs-6">Judul Tugas Akhir</label>
                            <textarea class="form-control form-control-sm" name="judul" id="edit_judul" rows="3" required></textarea>
                        </div>
                        <div class="fv-row mb-5">
                            <label class="form-label required fw-bolder text-dark fs-6">Pembimbing 1</label>
                            <input type="text" class="form-control form-control-sm" name="pembimbing[]"
                                id="edit_pembimbing_1" required />
                        </div>
                        <div class="fv-row mb-5">
                            <label class="form-label fw-bolder text-dark fs-6">Pembimbing 2 (Opsional)</label>
                            <input type="text" class="form-control form-control-sm" name="pembimbing[]"
                                id="edit_pembimbing_2" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <span class="indicator-label"><i class="fas fa-save me-1"></i> Update</span>
                            <span class="indicator-progress" style="display: none;">
                                Tunggu sebentar...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/lodash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/print.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.js') }}"></script>
    @include('bak_fakultas.tugas_akhir.script.index')
@endsection
