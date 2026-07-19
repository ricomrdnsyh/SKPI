@extends('layout.main')
@section('title', 'Tahun Akademik')
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
                                        class="card-label fw-bolder fs-3 mb-1">List Tahun Akademik</span></h3>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end gap-2" data-kt-customer-table-toolbar="base">
                                <button type="button" class="btn btn-sm btn-primary" id="btn_sync_tahun_akademik"><i
                                        class="fas fa-sync"></i> Sinkronisasi Data Tahun Akademik</button>
                            </div>
                        </div>
                    </div>
                    <div class="separator my-5"></div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="table-tahun-akademik">
                            <thead class="">
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="text-center min-w-100px">Actions</th>
                                    <th class="min-w-125px">Kode Tahun Akademik</th>
                                    <th class="min-w-125px">Nama Tahun Akademik</th>
                                    <th class="min-w-125px">Status</th>
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
    @include('admin.tahun_akademik.show')
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
    <script>
        function showModal(element) {
            let data = JSON.parse($(element).attr('data-row'));
            $('#show_id_tahun_akademik').val(data.id_tahun_akademik || '-');
            $('#show_nama').val(data.nama || '-');
            let statusText = data.is_active ? 'Aktif' : 'Nonaktif';
            $('#show_status').val(statusText);
            $('#form_show').modal('show');
        }

        $(document).ready(function() {
            var table = $('#table-tahun-akademik').DataTable({
                processing: false,
                serverSide: true,
                responsive: true,
                lengthMenu: [
                    [10, 15, 20, 25],
                    [10, 15, 20, 25]
                ],
                searchHighlight: true,
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
                        title: 'Data Tahun Akademik',
                        className: 'btn btn-sm btn-primary mt-2 rounded-2'
                    },
                    {
                        extend: 'excel',
                        titleAttr: 'Excel',
                        title: 'Data Tahun Akademik',
                        className: 'btn btn-sm btn-primary mt-2 rounded-2'
                    }
                ],
                ajax: '{{ route('tahun-akademik.datatable') }}',
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'id_tahun_akademik',
                        name: 'id_tahun_akademik'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'status',
                        name: 'is_active',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function() {
                    $('#table-tahun-akademik [data-bs-toggle="tooltip"]').tooltip();
                }
            });

            $('#btn_sync_tahun_akademik').click(function() {
                Swal.fire({
                    title: "Sinkronisasi Tahun Akademik?",
                    text: "Proses ini akan mengambil data dari API SSO dan memperbarui database.",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Sinkronkan!",
                    cancelButtonText: "Batal",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('tahun-akademik.sync') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Menyinkronkan...',
                                    icon: 'info',
                                    text: 'Mohon tunggu sebentar...',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                });
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        text: response.message,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                    table.ajax.reload(null, false);
                                } else {
                                    Swal.fire("Gagal!", response.message, "error");
                                }
                            },
                            error: function(xhr) {
                                let msg = "Terjadi kesalahan saat menyinkronkan data.";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    msg = xhr.responseJSON.message;
                                }
                                Swal.fire("Error!", msg, "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
