<script>
    function showModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        
        $('#show_prodi').val(data.prodi_nama || '-');
        $('#show_kurikulum').val(data.kurikulum_nama || '-');
        $('#show_kategori').val(data.kategori_nama || '-');
        $('#show_kode_cpl').val(data.kode_cpl || '-');
        $('#show_urutan').val(data.urutan || '-');
        $('#show_deskripsi_cpl').val(data.deskripsi_cpl || '-');

        $('#form_show').modal('show');
    }
</script>
