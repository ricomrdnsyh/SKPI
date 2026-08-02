<script>
    function editModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        let form = document.getElementById('form_edit_users');

        // Trigger dropdown karyawan dulu supaya logic change-nya jalan
        $('#edit_karyawan').val(data.username).trigger('change');

        for (let key in data) {
            if (key === 'password') continue; // Jangan isi password dengan hash
            let input = form.querySelector('[name="' + key + '"]');
            if (input) {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    if (input.value == data[key]) input.checked = true;
                } else {
                    input.value = data[key];
                }
            }
        }
        let pwd = form.querySelector('[name="password"]');
        if (pwd) pwd.value = '';

        // Jangan trigger select all, nanti numpuk. Trigger select spesifik role & fakultas saja.
        $('#edit_role').trigger('change');
        $('#edit_id_fakultas').trigger('change.select2');

        form.action = '/admin/users/' + data.id_user;
        $('#form_edit').modal('show');
    }
    document.addEventListener('DOMContentLoaded', function() {
        const formEdit = document.getElementById('form_edit_users');
        if (!formEdit) return;
        $('#edit_role').on('change', function() {
            if ($(this).val() === 'bak_fakultas') {
                $('#edit_id_fakultas').prop('disabled', false);
                $('#edit_id_fakultas').prop('required', true);
            } else {
                $('#edit_id_fakultas').prop('disabled', true);
                $('#edit_id_fakultas').prop('required', false);
                $('#edit_id_fakultas').val(null).trigger('change.select2');
            }
        });

        $('#edit_karyawan').on('change', function() {
            let selected = $(this).find('option:selected');
            if (selected.val()) {
                $('#edit_username').val(selected.val()).prop('readonly', true);
                $('#edit_nama_lengkap').val(selected.data('nama')).prop('readonly', true);
                if (selected.data('email')) {
                    $('#edit_email').val(selected.data('email'));
                }
            } else {
                $('#edit_username').prop('readonly', false);
                $('#edit_nama_lengkap').prop('readonly', false);
            }
        });
        let submitButtonEdit = formEdit.querySelector('[type="submit"]');
        if (!submitButtonEdit) {
            const ind = formEdit.querySelector('.indicator-label');
            if (ind) submitButtonEdit = ind.closest('button');
        }
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
                if (label) label.style.display = 'none';
                if (progress) progress.style.display = 'inline-block';
            }
            $('.invalid-feedback.d-block').remove();
            $(formEdit).find('.is-invalid').removeClass('is-invalid');
            $.ajax({
                url: formEdit.action,
                type: formEdit.method,
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
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    if ($.fn.DataTable.isDataTable('#table-users')) {
                        $('#table-users').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    if (submitButtonEdit) {
                        submitButtonEdit.disabled = false;
                        const label = submitButtonEdit.querySelector('.indicator-label');
                        const progress = submitButtonEdit.querySelector(
                            '.indicator-progress');
                        if (label) label.style.display = 'inline-block';
                        if (progress) progress.style.display = 'none';
                    }
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            let input = $(formEdit).find('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.parent().append('<div class="invalid-feedback d-block">' +
                                errors[key][0] + '</div>');
                        }
                    } else {
                        Swal.fire({
                            text: "Terjadi kesalahan sistem.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, mengerti!",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                    }
                }
            });
        });
        const modalEl = document.getElementById('form_edit');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function() {
                formEdit.classList.remove('was-validated');
                formEdit.reset();
                $('.invalid-feedback.d-block').remove();
                $(formEdit).find('.is-invalid').removeClass('is-invalid');
                if ($('#edit_karyawan').length) {
                    $('#edit_karyawan').val(null).trigger('change.select2');
                }
                $('#edit_username').prop('readonly', false).removeClass('form-control-solid');
                $('#edit_nama_lengkap').prop('readonly', false);
                if (submitButtonEdit) {
                    submitButtonEdit.disabled = false;
                    const label = submitButtonEdit.querySelector('.indicator-label');
                    const progress = submitButtonEdit.querySelector('.indicator-progress');
                    if (label) label.style.display = 'inline-block';
                    if (progress) progress.style.display = 'none';
                }
            });
        }
    });
</script>
