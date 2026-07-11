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

        $('#filter-kurikulum').on('change', function() {
            table.ajax.reload(null, false);
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
                    url: '/admin/cpl/' + id,
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
