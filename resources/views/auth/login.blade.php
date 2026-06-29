<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login SKPI Universitas Nurul Jadid">
    <title>Masuk - SKPI UNUJA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .login-bg {
            background: linear-gradient(135deg, #0d1b38 0%, #1a3266 40%, #0d1b38 100%);
            position: relative;
            overflow: hidden;
        }
        .login-bg::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: rgba(78, 114, 189, 0.15);
            filter: blur(120px);
            top: -20%;
            left: -10%;
        }
        .login-bg::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(107, 138, 201, 0.1);
            filter: blur(100px);
            bottom: -10%;
            right: -5%;
        }
        .login-card {
            animation: slideUp 0.5s ease-out both;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .brand-glow {
            box-shadow: 0 8px 32px rgba(58, 90, 158, 0.3);
        }
        .input-icon { transition: all 0.2s ease; }
        .input-group:focus-within .input-icon { color: #4e72bd; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .bg-dots {
            background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="login-bg bg-dots min-h-screen flex items-center justify-center p-4 md:p-6">

    <div class="login-card relative bg-white/97 w-full max-w-sm px-8 py-10 rounded-3xl shadow-2xl shadow-black/20 border border-white/20">
        {{-- Brand --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 flex items-center justify-center text-white text-2xl font-black mx-auto mb-5 bg-linear-to-br from-unuja-500 to-unuja-800 rounded-2xl brand-glow animate-float">U</div>
            <h1 class="text-xl font-black text-gray-900 tracking-tight">SKPI UNUJA</h1>
            <p class="text-sm text-gray-400 font-medium mt-1.5">Masuk ke sistem informasi SKPI</p>
        </div>

        {{-- Error messages --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-200/60 p-3.5 mb-5 rounded-2xl flex items-start gap-2.5 text-sm text-red-700 font-medium animate-slide-down">
                <i class="fa-solid fa-circle-xmark mt-0.5 shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200/60 p-3.5 mb-5 rounded-2xl text-sm text-red-700 font-medium animate-slide-down">
                <div class="flex items-start gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0"></i>
                    <ul class="m-0 ps-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('login') }}" method="POST" data-validate>
            @csrf
            <div class="mb-4">
                <label for="username" class="form-label">Username / NIM</label>
                <div class="input-group relative">
                    <span class="input-icon absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"><i class="fa-regular fa-user"></i></span>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="Username atau NIM" required autocomplete="username" autofocus
                        class="form-input form-input-with-icon-left">
                </div>
            </div>
            <div class="mb-6">
                <label for="password" class="form-label">Password</label>
                <div class="input-group relative">
                    <span class="input-icon absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" placeholder="Masukkan password" required autocomplete="current-password"
                        class="form-input form-input-with-icon-both">
                    <button type="button" id="toggle-password" tabindex="-1"
                        class="absolute right-0 top-0 h-11 w-11 flex items-center justify-center text-gray-400 cursor-pointer border-0 bg-transparent text-sm hover:text-gray-600 transition">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-full h-12 text-sm font-bold cursor-pointer mt-1 shadow-lg shadow-unuja-600/25 hover:shadow-xl hover:shadow-unuja-600/30 transition-all duration-200">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk
            </button>
        </form>

        <div class="text-center text-[10px] text-gray-400 font-medium mt-8 pt-6 border-t border-gray-100">
            &copy; {{ date('Y') }} SKPI UNUJA &mdash; Universitas Nurul Jadid
        </div>
    </div>

    <script>
        document.getElementById('toggle-password')?.addEventListener('click', function() {
            const input = document.getElementById('password');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>