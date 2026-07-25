<div class="modal fade" id="form_import" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data CPL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_import_cpl" action="{{ route('cpl.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Attractive Download Template Section -->
                    <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                        <i class="fas fa-file-excel fs-2tx text-primary me-4 mt-1"></i>
                        <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                            <div class="mb-3 mb-md-0 fw-bold">
                                <h4 class="text-gray-900 fw-bolder">Template Excel Import CPL</h4>
                                <div class="fs-6 text-gray-700 pe-7">Gunakan template ini untuk memastikan format data
                                    sesuai dengan sistem. Pastikan kolom <b class="text-dark">Kode Kategori</b> pada
                                    Excel diisi dengan kode yang valid (misal: S, P, KU, KK).</div>
                            </div>
                            <a href="{{ route('cpl.import.template') }}"
                                class="btn btn-sm btn-primary fw-bolder flex-shrink-0" target="_blank">
                                <i class="fas fa-download me-2"></i>Download Template
                            </a>
                        </div>
                    </div>

                    <div class="fv-row mb-6">
                        <label for="import_id_prodi" class="form-label required fw-bolder text-dark">Program
                            Studi</label>
                        <select name="id_prodi" id="import_id_prodi" required class="form-select form-select-sm"
                            data-control="select2" data-dropdown-parent="#form_import" data-placeholder="Pilih Prodi">
                            <option value="">-- Pilih Prodi --</option>
                            @foreach ($prodi as $p)
                                <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label for="import_id_kurikulum"
                            class="form-label required fw-bolder text-dark">Kurikulum</label>
                        <select name="id_kurikulum" id="import_id_kurikulum" required class="form-select form-select-sm"
                            data-control="select2" data-dropdown-parent="#form_import"
                            data-placeholder="Pilih Kurikulum">
                            <option value="">-- Pilih Kurikulum --</option>
                            @foreach ($kurikulums as $kur)
                                <option value="{{ $kur->id_kurikulum }}">{{ $kur->nama_kurikulum }} -
                                    {{ $kur->prodi_nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fv-row mb-6">
                        <label class="form-label required fw-bolder text-dark">File Excel (.xlsx, .xls)</label>
                        <div class="position-relative d-flex flex-column align-items-center justify-content-center border border-gray-400 border-dashed rounded p-6 mt-2"
                            style="border-color: #a1a5b7; background-color: #fdfdfd; transition: all 0.3s ease;">
                            <input type="file" name="file_excel" id="file_excel" required
                                class="position-absolute top-0 start-0 w-100 h-100 skip-global-validation"
                                style="opacity: 0; cursor: pointer; z-index: 10;" accept=".xlsx,.xls,.csv"
                                onchange="
                                if(this.files[0]) {
                                    let file = this.files[0];
                                    let validExts = ['.xlsx', '.xls', '.csv'];
                                    let fileExt = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();
                                    
                                    if (!validExts.includes(fileExt)) {
                                        this.value = '';
                                        Swal.fire({text: 'Format file tidak sesuai! Hanya izinkan file Excel (.xlsx, .xls) atau CSV.', icon: 'error', confirmButtonText: 'OK', customClass: {confirmButton: 'btn btn-danger'}});
                                        document.getElementById('upload_icon').classList.replace('fa-file-excel', 'fa-file-upload');
                                        document.getElementById('upload_icon').classList.replace('text-success', 'text-muted');
                                        document.getElementById('upload_title').textContent = 'Klik untuk unggah file';
                                        document.getElementById('upload_subtitle').textContent = 'Format XLSX, XLS (Maks. 5MB)';
                                        return;
                                    }
                                    
                                    if (file.size > 5 * 1024 * 1024) {
                                        this.value = '';
                                        Swal.fire({text: 'Ukuran file terlalu besar! Maksimal 5MB.', icon: 'error', confirmButtonText: 'OK', customClass: {confirmButton: 'btn btn-danger'}});
                                        return;
                                    }

                                    document.getElementById('upload_icon').classList.replace('fa-file-upload', 'fa-file-excel');
                                    document.getElementById('upload_icon').classList.replace('text-muted', 'text-success');
                                    document.getElementById('upload_title').textContent = file.name;
                                    document.getElementById('upload_subtitle').textContent = 'File siap diunggah';
                                } else {
                                    document.getElementById('upload_icon').classList.replace('fa-file-excel', 'fa-file-upload');
                                    document.getElementById('upload_icon').classList.replace('text-success', 'text-muted');
                                    document.getElementById('upload_title').textContent = 'Klik untuk unggah file';
                                    document.getElementById('upload_subtitle').textContent = 'Format XLSX, XLS (Maks. 5MB)';
                                }
                            ">
                            <i id="upload_icon" class="fas fa-file-upload fs-2x text-muted mb-2"></i>
                            <div id="upload_title" class="fw-bolder fs-6 text-dark mb-1">Klik untuk unggah file</div>
                            <div id="upload_subtitle" class="fs-8 fw-bold text-muted">Format XLSX, XLS (Maks. 5MB)</div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" data-kt-contacts-type="submit" class="btn btn-sm btn-primary">
                        <span class="indicator-label">Import</span>
                        <span class="indicator-progress" style="display: none;">
                            Tunggu sebentar...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
