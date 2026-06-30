<script>
    function showModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        
        $('#show_nilai_huruf').val(data.nilai_huruf || '-');
        $('#show_nilai_min').val(data.nilai_min || '-');
        $('#show_nilai_max').val(data.nilai_max || '-');

        $('#form_show').modal('show');
    }
</script>
