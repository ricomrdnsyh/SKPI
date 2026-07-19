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
        $('#show_tahun_lulus').val(data.tahun_lulus || '-');
        $('#show_tanggal_lulus').val(data.tanggal_lulus || '');
        $('#show_ipk').val(data.ipk || '-');
        
        if (data.foto) {
            $('#show_foto_img').attr('src', '/storage/' + data.foto).show();
            $('#show_foto_text').hide();
        } else {
            $('#show_foto_img').hide();
            $('#show_foto_text').show();
        }

        $('#form_show').modal('show');
    }
</script>
