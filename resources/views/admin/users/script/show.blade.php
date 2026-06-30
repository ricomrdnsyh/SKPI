<script>
    function showModal(element) {
        let data = JSON.parse($(element).attr('data-row'));
        
        $('#show_nama_lengkap').val(data.nama_lengkap || '-');
        $('#show_username').val(data.username || '-');
        $('#show_email').val(data.email || '-');
        
        // Format role
        let role = data.role ? data.role.toLowerCase() : '';
        let roleText = '-';
        if (role === 'admin') {
            roleText = 'Admin';
        } else if (role === 'bak_fakultas') {
            roleText = 'BAK Fakultas';
        } else {
            roleText = data.role || '';
        }
        $('#show_role').val(roleText);
        
        // Format hubungan akademik
        let hubungan = '-';
        if (role === 'bak_fakultas') {
            hubungan = data.fakultas_nama || '-';
        } else if (role === 'admin') {
            hubungan = 'Semua (Admin)';
        }
        $('#show_hubungan').val(hubungan);
        
        // Format status
        let statusText = data.aktif == 1 ? 'Aktif' : 'Nonaktif';
        $('#show_status').val(statusText);

        $('#form_show').modal('show');
    }
</script>
