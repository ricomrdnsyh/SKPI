<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formCreate = document.getElementById('form_create_mahasiswa');
        if (!formCreate) return;
        let submitButtonCreate = formCreate.querySelector('[type="submit"]');
        if (!submitButtonCreate) {
             // Try to find by indicator class if type="submit" is missing
             const ind = formCreate.querySelector('.indicator-label');
             if(ind) submitButtonCreate = ind.closest('button');
        }
        formCreate.addEventListener('submit', function(e) {
            if (!formCreate.checkValidity()) {
                e.preventDefault();
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
        });
        const modalEl = document.getElementById('form_create');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                formCreate.classList.remove('was-validated');
                formCreate.reset();
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
