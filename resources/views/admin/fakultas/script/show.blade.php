<script>
    function showModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        
        $('#show_nama_fakultas').val(data.nama_fakultas || '-');
        $('#show_kode_fakultas').val(data.kode_fakultas || '-');
        $('#show_dekan').val(data.dekan || '-');
        $('#show_nidn_dekan').val(data.nidn_dekan || '-');
        $('#show_no_telepon').val(data.no_telepon || '-');
        
        let statusText = data.status === 'aktif' ? 'Aktif' : (data.status === 'nonaktif' ? 'Nonaktif' : '-');
        $('#show_status').val(statusText);

        $('#form_show').modal('show');
    }
</script>
