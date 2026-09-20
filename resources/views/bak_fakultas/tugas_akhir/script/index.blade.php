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
                    title: 'Data Tugas Akhir',
                    className: 'btn btn-sm btn-primary mt-2 rounded-2'
                },
                {
                    extend: 'excel',
                        action: newexportaction,
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
                { data: 'action', orderable: false, searchable: false, className: 'text-center' },
                { data: 'nim', name: 'mahasiswa.nim' },
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

    function showTugasAkhir(id, data) {
        $('#detail_nim').text(data.nim);
        $('#detail_mahasiswa').text(data.nama_mahasiswa);
        $('#detail_judul').text(data.judul);
        $('#detail_pembimbing_1').text(data.pembimbing_1 || '-');
        $('#detail_pembimbing_2').text(data.pembimbing_2 || '-');
        
        const statusMap = {
            'approved': '<span class="badge badge-light-success fw-bold px-4 py-2">Disetujui</span>',
            'rejected': '<span class="badge badge-light-danger fw-bold px-4 py-2">Ditolak</span>',
            'pending': '<span class="badge badge-light-warning fw-bold px-4 py-2">Menunggu</span>'
        };
        const statusBadge = statusMap[data.status] || '<span class="badge badge-light-secondary fw-bold px-4 py-2">' + data.status + '</span>';
        $('#detail_status').html(statusBadge);
        
        $('#modal_detail').modal('show');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const formEdit = document.getElementById('kt_modal_edit_form');
        if (!formEdit) return;
        let submitButtonEdit = formEdit.querySelector('[type="submit"]');
        
        formEdit.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!formEdit.checkValidity()) {
                e.stopPropagation();
                formEdit.classList.add('was-validated');
                return;
            }
            if (submitButtonEdit) {
                submitButtonEdit.disabled = true;
                const label = submitButtonEdit.querySelector('.indicator-label');
                const progress = submitButtonEdit.querySelector('.indicator-progress');
                if(label) label.style.display = 'none';
                if(progress) progress.style.display = 'inline-block';
            }
            $('.invalid-feedback.d-block').remove();
            $(formEdit).find('.is-invalid').removeClass('is-invalid');
            
            $.ajax({
                url: formEdit.action,
                type: 'POST', // It has @method('PUT') so we use POST with data
                data: $(formEdit).serialize(),
                headers: {
                    'Accept': 'application/json'
                },
                success: function(response) {
                    $('#form_edit').modal('hide');
                    Swal.fire({
                        text: response.message || "Data berhasil diperbarui.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, mengerti!",
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                    if ($.fn.DataTable.isDataTable('#table-tugas-akhir')) {
                        $('#table-tugas-akhir').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    if (submitButtonEdit) {
                        submitButtonEdit.disabled = false;
                        const label = submitButtonEdit.querySelector('.indicator-label');
                        const progress = submitButtonEdit.querySelector('.indicator-progress');
                        if(label) label.style.display = 'inline-block';
                        if(progress) progress.style.display = 'none';
                    }
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            let input = $(formEdit).find('[name="'+key+'"]');
                            if (input.length) {
                                input.addClass('is-invalid');
                                input.parent().append('<div class="invalid-feedback d-block">' + errors[key][0] + '</div>');
                            }
                        }
                    } else {
                        Swal.fire({
                            text: xhr.responseJSON?.message || "Terjadi kesalahan sistem.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, mengerti!",
                            customClass: { confirmButton: "btn btn-danger" }
                        });
                    }
                }
            });
        });
        
        const modalEl = document.getElementById('form_edit');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                formEdit.classList.remove('was-validated');
                $('.invalid-feedback.d-block').remove();
                $(formEdit).find('.is-invalid').removeClass('is-invalid');
                if (submitButtonEdit) {
                    submitButtonEdit.disabled = false;
                    const label = submitButtonEdit.querySelector('.indicator-label');
                    const progress = submitButtonEdit.querySelector('.indicator-progress');
                    if(label) label.style.display = 'inline-block';
                    if(progress) progress.style.display = 'none';
                }
            });
        }
    });
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
