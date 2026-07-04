<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formCreate = document.getElementById('form_create_users');
        if (!formCreate) return;
        $('#role').on('change', function() {
            if ($(this).val() === 'bak_fakultas') {
                $('#id_fakultas').prop('disabled', false);
                $('#id_fakultas').prop('required', true);
            } else {
                $('#id_fakultas').prop('disabled', true);
                $('#id_fakultas').prop('required', false);
                $('#id_fakultas').val(null).trigger('change.select2');
            }
        });
        // Set initial state
        $('#role').trigger('change');
        let submitButtonCreate = formCreate.querySelector('[type="submit"]');
        if (!submitButtonCreate) {
             // Try to find by indicator class if type="submit" is missing
             const ind = formCreate.querySelector('.indicator-label');
             if(ind) submitButtonCreate = ind.closest('button');
        }
        formCreate.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!formCreate.checkValidity()) {
                e.stopPropagation();
                formCreate.classList.add('was-validated');
                return;
            }
            if (submitButtonCreate) {
                submitButtonCreate.disabled = true;
                const label = submitButtonCreate.querySelector('.indicator-label');
                const progress = submitButtonCreate.querySelector('.indicator-progress');
                if(label) label.style.display = 'none';
                if(progress) progress.style.display = 'inline-block';
            }
            $('.invalid-feedback.d-block').remove();
            $(formCreate).find('.is-invalid').removeClass('is-invalid');
            $.ajax({
                url: formCreate.action,
                type: formCreate.method,
                data: $(formCreate).serialize(),
                headers: {
                    'Accept': 'application/json'
                },
                success: function(response) {
                    $('#form_create').modal('hide');
                    Swal.fire({
                        text: response.message || "Data berhasil disimpan.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, mengerti!",
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                    if ($.fn.DataTable.isDataTable('#table-users')) {
                        $('#table-users').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    if (submitButtonCreate) {
                        submitButtonCreate.disabled = false;
                        const label = submitButtonCreate.querySelector('.indicator-label');
                        const progress = submitButtonCreate.querySelector('.indicator-progress');
                        if(label) label.style.display = 'inline-block';
                        if(progress) progress.style.display = 'none';
                    }
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            let input = $(formCreate).find('[name="'+key+'"]');
                            input.addClass('is-invalid');
                            input.parent().append('<div class="invalid-feedback d-block">' + errors[key][0] + '</div>');
                        }
                    } else {
                        Swal.fire({
                            text: "Terjadi kesalahan sistem.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, mengerti!",
                            customClass: { confirmButton: "btn btn-danger" }
                        });
                    }
                }
            });
        });
        const modalEl = document.getElementById('form_create');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                formCreate.classList.remove('was-validated');
                formCreate.reset();
                $('.invalid-feedback.d-block').remove();
                $(formCreate).find('.is-invalid').removeClass('is-invalid');
                $('#role').trigger('change');
                if (submitButtonCreate) {
                    submitButtonCreate.disabled = false;
                    const label = submitButtonCreate.querySelector('.indicator-label');
                    const progress = submitButtonCreate.querySelector('.indicator-progress');
                    if(label) label.style.display = 'inline-block';
                    if(progress) progress.style.display = 'none';
                }
            });
        }
    });
</script>
