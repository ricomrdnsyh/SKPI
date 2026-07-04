<script>
    function showModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        $('#show_kode_kategori').val(data.kode_kategori || '-');
        $('#show_nama_kategori').val(data.nama_kategori || '-');
        $('#show_urutan').val(data.urutan || '-');
        $('#form_show').modal('show');
    }
</script>
