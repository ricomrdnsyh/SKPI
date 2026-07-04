<script>
    function editModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        let form = document.getElementById('form_edit_kategori_cpl');
        // Auto-populate inputs based on data keys
        for (let key in data) {
            let input = form.querySelector('[name="' + key + '"]');
            if (input) {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    // Handle checkbox/radio if needed
                    if(input.value == data[key]) input.checked = true;
                } else {
                    input.value = data[key];
                }
            }
        }
        // Handle specific logic like Select2 triggers
        $(form).find('select').trigger('change.select2');
        // Set form action
        form.action = '/admin/kategori-cpl/' + data.id_kategori;
        $('#form_edit').modal('show');
    }
    document.addEventListener('DOMContentLoaded', function() {
        const formEdit = document.getElementById('form_edit_kategori_cpl');
        if (!formEdit) return;
        let submitButtonEdit = formEdit.querySelector('[type="submit"]');
        if (!submitButtonEdit) {
             const ind = formEdit.querySelector('.indicator-label');
             if(ind) submitButtonEdit = ind.closest('button');
        }
        formEdit.addEventListener('submit', function(e) {
            if (!formEdit.checkValidity()) {
                e.preventDefault();
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
        });
        const modalEl = document.getElementById('form_edit');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                formEdit.classList.remove('was-validated');
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
