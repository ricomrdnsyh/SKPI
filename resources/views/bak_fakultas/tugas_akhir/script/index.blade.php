<script>
    $(document).ready(function() {
        let table = $('#table-tugas-akhir').DataTable({
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
                    title: 'Data Tugas Akhir',
                    className: 'btn btn-sm btn-primary mt-2 rounded-2'
                },
                {
                    extend: 'excel',
                    titleAttr: 'Excel',
                    title: 'Data Tugas Akhir',
                    className: 'btn btn-sm btn-primary mt-2 rounded-2'
                }
            ],
            ajax: {
                url: '{{ route('bak_fakultas.tugas_akhir.datatable') }}',
                data: function(d) {}
            },
            columns: [
                { data: null, defaultContent: '', orderable: false, searchable: false },
                { data: 'action', orderable: false, searchable: false },
                { data: 'nama_mahasiswa', name: 'mahasiswa.nama_lengkap' },
                { data: 'judul' },
                { data: 'pembimbing', orderable: false, searchable: false },
                { data: 'status', orderable: false, searchable: false }
            ],
            drawCallback: function() {
                $('#table-tugas-akhir [data-bs-toggle="tooltip"]').tooltip();
            }
        });
        table.on('draw', function() {
            $('#table-tugas-akhir [data-bs-toggle="tooltip"]').tooltip();
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
                    url: '/bak-fakultas/tugas-akhir/' + id,
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
                            didOpen: () => { Swal.showLoading() }
                        });
                    },
                    success: function(response) {
                        Swal.fire({
                            text: response.message || "Data berhasil dihapus.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn btn-primary" }
                        });
                        $('#table-tugas-akhir').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        Swal.fire("Error!", "Terjadi kesalahan saat menghapus data.", "error");
                    }
                });
            }
        })
    }

    function editTugasAkhir(id, data) {
        $('#kt_modal_edit_form').attr('action', '/bak-fakultas/tugas-akhir/' + id);
        $('#edit_id_tugas_akhir').val(data.id_tugas_akhir);
        $('#edit_nim').val(data.nim).trigger('change');
        $('#edit_judul').val(data.judul);
        $('#edit_pembimbing_1').val(data.pembimbing_1).trigger('change');
        $('#edit_pembimbing_2').val(data.pembimbing_2).trigger('change');
        $('#form_edit').modal('show');
    }
</script>
@if ($message = Session::get('success'))
    <script>
        Swal.fire({
            text: "{{ $message }}",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: { confirmButton: "btn btn-primary" }
        });
    </script>
@endif
@if ($message = Session::get('failed') || $message = Session::get('error'))
    <script>
        Swal.fire({
            text: "{{ Session::get('failed') ?? Session::get('error') }}",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: { confirmButton: "btn btn-danger" }
        });
    </script>
@endif
