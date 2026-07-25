<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formImport = document.getElementById('form_import_cpl');
        if (!formImport) return;

        let submitButtonImport = formImport.querySelector('[type="submit"]');

        formImport.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!formImport.checkValidity()) {
                e.stopPropagation();
                formImport.classList.add('was-validated');
                return;
            }

            if (submitButtonImport) {
                submitButtonImport.disabled = true;
                const label = submitButtonImport.querySelector('.indicator-label');
                const progress = submitButtonImport.querySelector('.indicator-progress');
                if (label) label.style.display = 'none';
                if (progress) progress.style.display = 'inline-block';
            }

            let formData = new FormData(formImport);

            $.ajax({
                url: formImport.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#form_import').modal('hide');
                    Swal.fire({
                        text: response.message || "Data berhasil diimport.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    $('#table-cpl').DataTable().ajax.reload(null, false);
                    formImport.reset();
                    formImport.classList.remove('was-validated');
                    $(formImport).find('select').val('').trigger('change');
                },
                error: function(xhr) {
                    let message = "Terjadi kesalahan sistem.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        html: message,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
                },
                complete: function() {
                    if (submitButtonImport) {
                        submitButtonImport.disabled = false;
                        const label = submitButtonImport.querySelector('.indicator-label');
                        const progress = submitButtonImport.querySelector('.indicator-progress');
                        if (label) label.style.display = 'inline-block';
                        if (progress) progress.style.display = 'none';
                    }
                }
            });
        });
        
        const modalEl = document.getElementById('form_import');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                formImport.classList.remove('was-validated');
                formImport.reset();
                $(formImport).find('select').val('').trigger('change');
            });
        }
    });
</script>
