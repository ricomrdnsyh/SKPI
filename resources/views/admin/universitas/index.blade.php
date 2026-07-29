@extends('layout.main')
@section('title', 'Data Universitas')
@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_content" class="app-content flex-column-fluid mt-7">
        <div id="kt_app_content_container" class="app-container container-fluid">

            <div class="card shadow-sm border border-dashed border-dark rounded">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <h3 class="card-title align-items-start flex-column"><span class="card-label fw-bolder fs-3 mb-1">Informasi Universitas</span></h3>
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="card-body pt-0">
                    <form id="form-universitas" action="{{ route('universitas.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-9 mb-8">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">Nama Perguruan Tinggi</label>
                                <input type="text" class="form-control @error('nama_perguruan_tinggi') is-invalid @enderror" name="nama_perguruan_tinggi" value="{{ old('nama_perguruan_tinggi', $universitas->nama_perguruan_tinggi) }}" required />
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">SK Akreditasi Perguruan Tinggi</label>
                                <input type="text" class="form-control @error('sk_akreditasi') is-invalid @enderror" name="sk_akreditasi" value="{{ old('sk_akreditasi', $universitas->sk_akreditasi) }}" />
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Nomor Telepon</label>
                                <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon" value="{{ old('no_telepon', $universitas->no_telepon) }}" />
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $universitas->email) }}" />
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" onclick="confirmSubmit()">
                                <span class="indicator-label">Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    @if($errors->any())
        Swal.fire({
            title: 'Validasi Gagal!',
            html: `
                <ul class="text-start mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
            icon: 'error',
            confirmButtonText: 'Ok, Mengerti',
            customClass: {
                confirmButton: 'btn btn-danger'
            }
        });
    @endif

    function confirmSubmit() {
        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Apakah Anda yakin ingin memperbarui data universitas ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Sedang memproses data...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                document.getElementById('form-universitas').submit();
            }
        });
    }
</script>
@endsection
