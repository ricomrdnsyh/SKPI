<script>
    function showModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        $('#show_fakultas').val(data.fakultas_nama || '-');
        $('#show_nama_prodi').val(data.nama_prodi || '-');
        $('#show_kode_prodi').val(data.kode_prodi || '-');
        $('#show_jenjang').val(data.jenjang || '-');
        $('#show_gelar').val(data.gelar || '-');
        $('#show_sk_akreditasi').val(data.sk_akreditasi || '-');
        $('#show_tanggal_sk_akreditasi').val(data.tanggal_sk_akreditasi || '-');
        $('#show_masa_berlaku_akreditasi').val(data.masa_berlaku_akreditasi || '-');
        $('#show_jenjang_kkni').val(data.jenjang_kkni || '-');
        $('#show_bahasa_pengantar').val(data.bahasa_pengantar || '-');
        $('#show_lama_studi').val(data.lama_studi || '-');
        $('#show_jenis_pendidikan').val(data.jenis_pendidikan || '-');
        $('#show_jenis_pendidikan_lanjutan').val(data.jenis_pendidikan_lanjutan || '-');
        $('#show_persyaratan_penerimaan').val(data.persyaratan_penerimaan || '-');
        let statusText = (data.status === 'aktif' || data.status === 'active') ? 'Aktif' : (data.status === 'nonaktif' ? 'Nonaktif' : (data.status || '-'));
        $('#show_status').val(statusText);
        $('#form_show').modal('show');
    }
</script>
