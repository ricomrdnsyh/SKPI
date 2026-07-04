<script>
    function showModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        
        $('#show_prodi').val(data.prodi_nama || '-');
        $('#show_nama_kurikulum').val(data.nama_kurikulum || '-');

        $('#form_show').modal('show');
    }
</script>
