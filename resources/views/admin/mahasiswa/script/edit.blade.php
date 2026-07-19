<script>
    function editModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        let form = document.getElementById('form_edit_mahasiswa');
        for (let key in data) {
            if (key === 'password' || key === 'foto') continue; // Jangan masukkan hash password atau path foto ke input field
            
            let input = form.querySelector('[name="' + key + '"]');
            if (input) {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    if(input.value == data[key]) input.checked = true;
                } else if (key === 'tanggal_lahir' || key === 'tanggal_lulus') {
                    if (data[key]) {
                        input.value = data[key];
                        if (input._flatpickr) {
                            input._flatpickr.setDate(data[key]);
                        }
                    } else {
                        input.value = '';
                        if (input._flatpickr) {
                            input._flatpickr.clear();
                        }
                    }
                } else {
                    input.value = data[key];
                }
            }
        }
        $(form).find('select').trigger('change.select2');
        form.action = '/akademik/mahasiswa/' + data.nim;
        $('#form_edit').modal('show');
    }
    document.addEventListener('DOMContentLoaded', function() {
        const formEdit = document.getElementById('form_edit_mahasiswa');
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

        $("#edit_tanggal_lahir").flatpickr({
            dateFormat: "Y-m-d"
        });
        
        $("#edit_tanggal_lulus").flatpickr({
            dateFormat: "Y-m-d"
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
