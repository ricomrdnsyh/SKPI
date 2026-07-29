<script>
    function showModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        $('#show_nim').val(data.nim || '-');
        $('#show_nama_lengkap').val(data.nama_lengkap || '-');
        $('#show_prodi').val(data.prodi_nama || '-');
        $('#show_status').val(data.status || 'Aktif');
        $('#show_tempat_lahir').val(data.tempat_lahir || '-');
        $('#show_tanggal_lahir').val(data.tanggal_lahir || '');
        $('#show_email').val(data.email || '-');
        $('#show_nomor_telepon').val(data.nomor_telepon || '-');
        $('#show_tahun_masuk').val(data.tahun_masuk || '-');
        $('#show_tahun_lulus').val(data.tahun_lulus || '');
        $('#form_show').modal('show');
    }
</script>
