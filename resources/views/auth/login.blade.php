<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login SKPI Universitas Nurul Jadid">
    <title>Login - SKPI UNUJA</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/unuja.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style>
        body.bg-grid {
            background-color: #f1f4f8;
            background-image:
                linear-gradient(to right, rgba(206, 206, 206, 0.31) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(206, 206, 206, 0.31) 1px, transparent 1px);
            background-size: 25px 25px;
            position: relative;
        }
        .auth-wrapper {
            min-height: 100vh;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 18px;
            padding: 2.5rem 2.25rem;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.18);
            border: 1px solid rgba(148, 163, 184, 0.5);
            position: relative;
            overflow: hidden;
        }
        .auth-card::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.12), rgba(59, 130, 246, 0.02));
            opacity: 0.9;
            pointer-events: none;
        }
        .auth-card-inner {
            position: relative;
            z-index: 1;
        }
        .auth-title {
            font-weight: 600;
            letter-spacing: 0.02em;
        }
        .auth-subtitle {
            font-size: 0.95rem;
        }
        .auth-card .form-control {
            border-radius: 0.75rem;
        }
        .auth-card .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .auth-card .input-group-text {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        .auth-footer-text {
            font-size: 0.8rem;
        }
        @media (max-width: 576px) {
            .auth-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body id="kt_body" class="bg-body bg-grid">
    <div class="d-flex flex-column flex-root auth-wrapper">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <a href="{{ route('login') }}"
                class="mb-8 d-flex align-items-center justify-content-center text-decoration-none">
                <img alt="Logo" src="{{ asset('assets/media/logos/unuja.png') }}" class="h-60px me-3" />
                <span class="text-dark fw-bold fs-1">SKPI UNUJA</span>
            </a>
            <div class="w-lg-500px mx-auto auth-card">
                <div class="auth-card-inner">
                    <form id="login_form" class="form w-100" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="text-center mb-8">
                            <h1 class="text-dark mb-2 auth-title">Selamat Datang Kembali</h1>
                            <p class="text-muted auth-subtitle">Sistem Informasi SKPI Universitas Nurul Jadid</p>
                        </div>
                        <div class="fv-row mb-3">
                            <label class="form-label fs-6 fw-bolder text-dark">Username / NIM</label>
                            <input class="form-control form-control-sm bg-white" type="text" name="username"
                                value="{{ old('username') }}" required autofocus />
                        </div>
                        <div class="fv-row mb-5">
                            <div class="d-flex flex-stack mb-2">
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                            </div>
                            <div class="input-group">
                                <input class="form-control form-control-sm bg-white" type="password" id="password"
                                    name="password" autocomplete="off" required />
                                <span class="input-group-text bg-white" id="togglePassword" style="cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary btn-md w-100 mb-3">
                                Sign In
                            </button>
                            <div class="text-muted auth-footer-text">
                                &copy; {{ date('Y') }} SKPI UNUJA &mdash; Universitas Nurul Jadid
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script>
        const form = document.getElementById('login_form');
        form.addEventListener('submit', function(event) {
            Swal.fire({
                icon: 'info',
                title: 'Mohon tunggu...',
                text: 'Permintaan anda sedang diproses',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    </script>
    @if (session('error'))
        <script>
            Swal.fire({
                text: "{{ session('error') }}",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-danger"
                }
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            Swal.fire({
                html: "{!! implode('<br>', $errors->all()) !!}",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-danger"
                }
            });
        </script>
    @endif
    @if (session('success'))
        <script>
            Swal.fire({
                text: "{{ session('success') }}",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        </script>
    @endif
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ?
                '<i class="fas fa-eye"></i>' :
                '<i class="fas fa-eye-slash"></i>';
        });
    </script>
</body>
</html>
