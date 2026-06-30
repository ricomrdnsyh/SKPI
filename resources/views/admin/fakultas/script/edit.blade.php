<script>
    function editModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        let form = document.getElementById('form_edit_fakultas');
        
        // Auto-populate inputs based on data keys
        for (let key in data) {
            let input = form.querySelector('[name="' + key + '"]');
            if (input) {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    if(input.value == data[key]) input.checked = true;
                } else {
                    input.value = data[key];
                }
            }
        }

        // Handle specific logic like Select2 triggers
        $(form).find('select').trigger('change');

        // Set form action
        form.action = '/akademik/fakultas/' + data.id_fakultas;

        $('#form_edit').modal('show');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const formEdit = document.getElementById('form_edit_fakultas');
        if (!formEdit) return;
        
        let submitButtonEdit = formEdit.querySelector('[type="submit"]');
        if (!submitButtonEdit) {
             const ind = formEdit.querySelector('.indicator-label');
             if(ind) submitButtonEdit = ind.closest('button');
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
                if(label) label.style.display = 'none';
                if(progress) progress.style.display = 'inline-block';
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
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                    if ($.fn.DataTable.isDataTable('#table-fakultas')) {
                        $('#table-fakultas').DataTable().ajax.reload(null, false);
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
