<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Verifikasi Gagal - Universitas Nurul Jadid">
    <title>Verifikasi Gagal - Universitas Nurul Jadid</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Outfit'] bg-gray-100 min-h-screen flex flex-col items-center justify-center p-6">

    <div class="w-full max-w-lg mx-auto">
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center gap-2.5 text-lg font-black tracking-tight text-unuja-700 mb-2">
                <div class="w-8 h-8 flex items-center justify-center text-white text-xs font-bold bg-unuja-600 rounded-xl">U</div>
                UNUJA
            </div>
            <h1 class="text-2xl font-black text-gray-900">Universitas Nurul Jadid</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Sistem Verifikasi Keaslian Dokumen Akademik Resmi</p>
        </div>

        <div class="bg-white p-8 md:p-10 text-center rounded-3xl shadow-xl border border-gray-200/80 animate-slide-up">
            <div class="flex flex-col items-center mb-6">
                <div class="w-20 h-20 flex items-center justify-center text-3xl mb-4 bg-red-50 border-2 border-red-500 text-red-500 rounded-2xl">
                    <i class="fa-solid fa-shield-xmark"></i>
                </div>
                <h2 class="text-xl font-black text-gray-900">Verifikasi Gagal</h2>
                <div class="text-xs font-bold mt-1.5 px-4 py-1.5 bg-red-50 text-red-700 border border-red-300 rounded-full inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-xmark"></i> Data Tidak Ditemukan
                </div>
            </div>

            <div class="p-5 mb-6 text-left text-sm font-medium text-gray-700 leading-relaxed bg-gray-50 border border-gray-200/60 rounded-2xl">
                <p>{{ $message }}</p>
                <p class="mt-2 text-xs text-gray-500">
                    Pastikan Anda memindai kode QR dari dokumen resmi yang diterbitkan oleh Universitas Nurul Jadid. Dokumen palsu atau tidak resmi tidak terdaftar di database kami.
                </p>
            </div>

            <a href="/" class="btn btn-primary inline-flex items-center gap-2 text-sm font-bold px-6 py-3">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>

        <div class="text-center mt-8 animate-fade-in">
            <p class="text-xs font-medium text-gray-500">&copy; 2026 Universitas Nurul Jadid. All rights reserved.</p>
            <p class="text-xs font-medium text-gray-500 mt-1">Hubungi <a href="mailto:info@unuja.ac.id" class="text-unuja-600 hover:underline font-semibold">info@unuja.ac.id</a> jika ada kendala.</p>
        </div>
    </div>

</body>
</html>