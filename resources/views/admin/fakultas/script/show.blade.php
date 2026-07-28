<script>
    function showModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        $('#show_nama_fakultas').val(data.nama_fakultas || '-');
        $('#show_kode_fakultas').val(data.kode_fakultas || '-');
        $('#show_dekan').val(data.dekan || '-');
        $('#show_niy_dekan').val(data.niy_dekan || '-');
        let statusText = data.status === 'aktif' ? 'Aktif' : (data.status === 'nonaktif' ? 'Nonaktif' : '-');
        $('#show_status').val(statusText);
        $('#form_show').modal('show');
    }
</script>
