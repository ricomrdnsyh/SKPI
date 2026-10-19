<script>
    $(document).ready(function() {
        let table = $('#table-cpl').DataTable({
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
                        action: newexportaction,
                    titleAttr: 'Csv',
                    title: 'Data SKPI',
                    className: 'btn btn-sm btn-primary mt-2 rounded-2'
                },
                {
                    extend: 'excel',
                        action: newexportaction,
                    titleAttr: 'Excel',
                    title: 'Data SKPI',
                    className: 'btn btn-sm btn-primary mt-2 rounded-2'
                }
            ],
            ajax: {
                url: '{{ route('cpl.datatable') }}',
                data: function(d) {
                    d.id_prodi = $('#filter-prodi').val();
                    d.id_kurikulum = $('#filter-kurikulum').val();
                    if ($('#filter-fakultas').length) {
                        d.id_fakultas = $('#filter-fakultas').val();
                    }
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
                    data: 'kurikulum'
                },
                {
                    data: 'kategori'
                },
                {
                    data: 'kode_cpl'
                },
                {
                    data: 'deskripsi'
                },
                {
                    data: 'urutan'
                }
            ],
            drawCallback: function() {
                $('#table-cpl [data-bs-toggle="tooltip"]').tooltip();
            }
        });
        table.on('draw', function() {
            $('#table-cpl [data-bs-toggle="tooltip"]').tooltip();
        });
        let originalProdiOptions = $('#filter-prodi option').clone();
        let originalKurikulumOptions = $('#filter-kurikulum option').clone();
        
        $('#filter-fakultas').on('change', function() {
            let selectedFakultas = $(this).val();
            let prodiSelect = $('#filter-prodi');
            let currentSelected = prodiSelect.val();
            
            prodiSelect.empty();
            
            originalProdiOptions.each(function() {
                let fakId = $(this).data('fakultas');
                if (!selectedFakultas || fakId == selectedFakultas || !$(this).val()) {
                    prodiSelect.append($(this).clone());
                }
            });
            
            if (prodiSelect.find('option[value="' + currentSelected + '"]').length) {
                prodiSelect.val(currentSelected);
            } else {
                prodiSelect.val('');
            }
            
            prodiSelect.trigger('change.select2');
            $('#filter-prodi').trigger('change');
        });

        $('#filter-prodi').on('change', function() {
            let selectedProdi = $(this).val();
            let kurikulumSelect = $('#filter-kurikulum');
            let currentSelected = kurikulumSelect.val();
            
            kurikulumSelect.empty();
            
            originalKurikulumOptions.each(function() {
                let prodiId = $(this).data('prodi');
                if (!selectedProdi || prodiId == selectedProdi || !$(this).val()) {
                    kurikulumSelect.append($(this).clone());
                }
            });
            
            if (kurikulumSelect.find('option[value="' + currentSelected + '"]').length) {
                kurikulumSelect.val(currentSelected);
            } else {
                kurikulumSelect.val('');
            }
            
            kurikulumSelect.trigger('change.select2');
            table.ajax.reload(null, false);
        });

        function checkBulkDeleteButton() {
            let prodiVal = $('#filter-prodi').val();
            let kurikulumVal = $('#filter-kurikulum').val();
            if (prodiVal && kurikulumVal) {
                $('#btn-bulk-delete-cpl').fadeIn(200);
            } else {
                $('#btn-bulk-delete-cpl').fadeOut(200);
            }
        }

        $('#filter-kurikulum').on('change', function() {
            checkBulkDeleteButton();
            table.ajax.reload(null, false);
        });

        $('#filter-prodi').on('change', function() {
            checkBulkDeleteButton();
        });

        $('#btn-bulk-delete-cpl').on('click', function() {
            let prodiVal = $('#filter-prodi').val();
            let kurikulumVal = $('#filter-kurikulum').val();
            let prodiName = $('#filter-prodi option:selected').text();
            let kurikulumName = $('#filter-kurikulum option:selected').text();

            if (!prodiVal || !kurikulumVal) {
                Swal.fire('Perhatian', 'Silakan pilih Program Studi dan Kurikulum terlebih dahulu.', 'warning');
                return;
            }

            Swal.fire({
                title: "Hapus CPL Kurikulum Ini?",
                html: `Apakah Anda yakin ingin menghapus <b>SEMUA</b> CPL untuk:<br><b>Prodi:</b> ${prodiName}<br><b>Kurikulum:</b> ${kurikulumName}?<br><br><span class="text-danger fw-bold">Tindakan ini tidak dapat dibatalkan!</span>`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus Semua!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('cpl.bulk_delete') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_prodi: prodiVal,
                            id_kurikulum: kurikulumVal
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Menghapus Data CPL...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                        },
                        success: function(response) {
                            Swal.fire({
                                text: response.message || "Data CPL berhasil dihapus.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                            $('#table-cpl').DataTable().ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            var msg = xhr.responseJSON?.message || "Terjadi kesalahan saat menghapus data CPL.";
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
                    url: '{{ url('akademik/cpl') }}/' + id,
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
                        $('#table-cpl').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        var msg = xhr.responseJSON?.message || "Terjadi kesalahan saat menghapus data.";
                        Swal.fire("Error!", msg, "error");
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
