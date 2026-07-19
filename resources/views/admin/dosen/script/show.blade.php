<script>
    $(document).on('click', '.btn-detail', function() {
        let id = $(this).data('id');
        $.ajax({
            url: '/akademik/dosen/' + id,
            type: 'GET',
            success: function(response) {
                $('#show_id_penduduk').val(response.id_penduduk || '-');
                $('#show_nidn').val(response.nidn || '-');
                $('#show_nama_dosen').val(response.nama_dosen || '-');
                let jk = response.jenis_kelamin;
                $('#show_jenis_kelamin').val(jk === 'L' ? 'Laki-laki' : (jk === 'P' ? 'Perempuan' : '-'));
                $('#show_email').val(response.email || '-');
                $('#show_no_hp').val(response.no_hp || '-');
                $('#show_fakultas').val(response.fakultas ? response.fakultas.nama_fakultas : '-');
                $('#show_prodi').val(response.program_studi ? response.program_studi.nama_prodi : '-');
                $('#modal_show').modal('show');
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Gagal mengambil data detail.', 'error');
            }
        });
    });
</script>
