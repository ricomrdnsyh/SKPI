<script>
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        $('#form_edit').attr('action', '/akademik/dosen/' + id);

        $.ajax({
            url: '/akademik/dosen/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#edit_nama_dosen').val(response.nama_dosen);
                $('#edit_nidn').val(response.nidn);
                $('#edit_jenis_kelamin').val(response.jenis_kelamin).trigger('change');
                $('#edit_email').val(response.email);
                $('#edit_no_hp').val(response.no_hp);
                $('#edit_id_fakultas').val(response.id_fakultas).trigger('change');
                $('#edit_id_prodi').val(response.id_prodi).trigger('change');
                $('#modal_edit').modal('show');
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Gagal mengambil data dosen.', 'error');
            }
        });
    });

    $('#form_edit').submit(function(e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let btn = $('#btn_submit_edit');
        
        btn.prop('disabled', true);
        btn.find('.indicator-label').hide();
        btn.find('.indicator-progress').show();

        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    $('#modal_edit').modal('hide');
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    $('#table-dosen').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire("Gagal!", response.message, "error");
                }
            },
            error: function(xhr) {
                let msg = "Terjadi kesalahan saat memperbarui data.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire("Error!", msg, "error");
            },
            complete: function() {
                btn.prop('disabled', false);
                btn.find('.indicator-label').show();
                btn.find('.indicator-progress').hide();
            }
        });
    });
</script>
