<script>
    function showModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        let form = document.getElementById('form_show_magang');
        // Auto-populate inputs based on data keys
        for (let key in data) {
            let input = form.querySelector('[name="' + key + '"]');
            if (input) {
                if (input.type === 'file') {
                    // skip file inputs
                } else if (input.type === 'checkbox' || input.type === 'radio') {
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
                let statusInput = document.getElementById('show_status');
        if (statusInput) statusInput.value = data.status ? data.status.toUpperCase() : '-';
        let ketInput = document.getElementById('show_keterangan');
        if (ketInput) ketInput.value = data.keterangan ? data.keterangan : '-';
        let fileContainer = document.getElementById('show_file_bukti_container');
        if (fileContainer) {
            if (data.file_bukti) {
                let fileUrl = '/storage/' + data.file_bukti;
                fileContainer.innerHTML = '<a href="' + fileUrl + '" target="_blank" class="btn btn-sm btn-light-primary"><i class="fas fa-file-alt"></i> Lihat File Bukti</a>';
            } else {
                fileContainer.innerHTML = '<span class="text-muted"><i>Tidak ada file bukti</i></span>';
            }
        }
        $('#form_show').modal('show');
    }
    document.addEventListener('DOMContentLoaded', function() {
        const formEdit = document.getElementById('form_show_magang');
        if (!formEdit) return;
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
