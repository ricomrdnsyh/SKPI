<script>
    $(document).ready(function() {
        let table = $('#table-kurikulum').DataTable({
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
                },
                {
                    targets: 1,
                    orderable: false,
                    searchable: false
                }
            ],
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
            ajax: {
                url: '{{ route('kurikulum.datatable') }}',
                data: function(d) {
                    d.id_prodi = $('#filter-prodi').val();
                }
            },
            columns: [{
                    data: null,
                    defaultContent: '',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'prodi'
                },
                {
                    data: 'nama_kurikulum'
                }
            ],
            drawCallback: function() {
                $('#table-kurikulum [data-bs-toggle="tooltip"]').tooltip();
            }
        });

        table.on('draw', function() {
            $('#table-kurikulum [data-bs-toggle="tooltip"]').tooltip();
        });

        $('#filter-prodi').on('change', function() {
            table.ajax.reload(null, false);
        });

        $('#btn_sync_kurikulum').on('click', function() {
            Swal.fire({
                title: "Sinkronisasi Kurikulum?",
                text: "Proses ini akan mengambil data dari API SSO dan memperbarui database lokal.",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Ya, Sinkronkan!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-info",
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('kurikulum.sync') }}',
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
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data akan dihapus permanen.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/akademik/kurikulum/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Tunggu Sebentar..',
                            icon: 'info',
                            text: 'Sedang memproses...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success: function(response) {
                        Swal.fire({
                            text: response.message || "Data berhasil dihapus.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        $('#table-kurikulum').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        Swal.fire("Error!", "Terjadi kesalahan saat menghapus data.", "error");
                    }
                });
            }
        })
    }
</script>
@if ($message = Session::get('success'))
    <script>
        Swal.fire({
            text: "{{ $message }}",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    </script>
@endif
@if ($message = Session::get('failed') || ($message = Session::get('error')))
    <script>
        Swal.fire({
            text: "{{ Session::get('failed') ?? Session::get('error') }}",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-danger"
            }
        });
    </script>
@endif
