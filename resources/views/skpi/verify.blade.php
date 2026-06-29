<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Verifikasi Keaslian SKPI Universitas Nurul Jadid">
    <title>Verifikasi Keaslian SKPI - Universitas Nurul Jadid</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Outfit'] bg-gray-100 min-h-screen flex flex-col items-center justify-center p-6">

    <div class="w-full max-w-2xl mx-auto">
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center gap-2.5 text-lg font-black tracking-tight text-unuja-700 mb-2">
                <div class="w-8 h-8 flex items-center justify-center text-white text-xs font-bold bg-unuja-600 rounded-xl">U</div>
                UNUJA
            </div>
            <h1 class="text-2xl font-black text-gray-900">Universitas Nurul Jadid</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Sistem Verifikasi Keaslian Dokumen Akademik Resmi</p>
        </div>

        <div class="bg-white p-8 md:p-10 rounded-3xl shadow-xl border border-gray-200/80 animate-slide-up">
            <div class="flex flex-col items-center text-center mb-8">
                <div class="w-20 h-20 flex items-center justify-center text-3xl mb-4 bg-emerald-50 border-2 border-emerald-500 text-emerald-500 rounded-2xl">
                    <i class="fa-solid fa-shield-check"></i>
                </div>
                <h2 class="text-xl font-black text-gray-900">Dokumen Terverifikasi & Asli</h2>
                <div class="text-xs font-bold mt-1.5 px-4 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-300 rounded-full inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-check"></i> Terdaftar Resmi di Sistem UNUJA
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 pb-3 border-b border-gray-200/60">Informasi Dokumen SKPI</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <span class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Nomor SKPI</span>
                        <p class="text-sm font-black text-emerald-600 mt-0.5">{{ $skpi->nomor_skpi }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Tanggal Terbit</span>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">{{ \Carbon\Carbon::parse($skpi->tanggal_terbit)->isoFormat('D MMMM YYYY') }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Penandatangan</span>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $skpi->ditandatangani_oleh }} (Dekan)</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">NIDN Dekan</span>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $skpi->nidn_penandatangan }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 pb-3 border-b border-gray-200/60">Identitas Mahasiswa</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <span class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Nama Lengkap</span>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $mahasiswa->nama_lengkap }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">NIM</span>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $mahasiswa->nim }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Fakultas / Prodi</span>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $fakultas->nama_fakultas }} / {{ $mahasiswa->programStudi->nama_prodi }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">NIM Ijazah</span>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $skpi->nim_ijazah }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 pb-3 border-b border-gray-200/60">Judul Tugas Akhir</h3>
                <div class="p-5 bg-gray-50 border border-gray-200/60 rounded-2xl">
                    <p class="text-sm font-bold text-gray-900 leading-relaxed italic">
                        &ldquo;{{ $tugasAkhir->judul ?? 'Belum ada judul Tugas Akhir' }}&rdquo;
                    </p>
                    @if($tugasAkhir && $tugasAkhir->pembimbingTugasAkhir->isNotEmpty())
                        <p class="text-xs text-gray-500 font-medium mt-2">
                            Pembimbing: 
                            @foreach($tugasAkhir->pembimbingTugasAkhir as $pta)
                                {{ $pta->nama_dosen }}{{ !$loop->last ? ' & ' : '' }}
                            @endforeach
                        </p>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 pb-3 border-b border-gray-200/60">Rekapitulasi Prestasi & Aktivitas</h3>
                <div class="border border-gray-200/80 rounded-2xl overflow-hidden">
                    <table class="w-full border-collapse text-sm text-left">
                        <thead>
                            <tr>
                                <th class="text-[10px] font-bold text-gray-500 uppercase tracking-wider p-3.5 bg-gray-50/80 border-b border-gray-200">Kategori</th>
                                <th class="text-[10px] font-bold text-gray-500 uppercase tracking-wider p-3.5 bg-gray-50/80 border-b border-gray-200">Jumlah Berkas Valid</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="p-3.5 font-bold text-gray-900 border-b border-gray-100 text-sm">Prestasi & Penghargaan</td><td class="p-3.5 font-bold text-emerald-600 border-b border-gray-100 text-sm">{{ $prestasi->count() }} Kegiatan</td></tr>
                            <tr><td class="p-3.5 font-bold text-gray-900 border-b border-gray-100 text-sm">Organisasi Mahasiswa</td><td class="p-3.5 font-bold text-emerald-600 border-b border-gray-100 text-sm">{{ $organisasi->count() }} Organisasi</td></tr>
                            <tr><td class="p-3.5 font-bold text-gray-900 border-b border-gray-100 text-sm">Sertifikat Keahlian</td><td class="p-3.5 font-bold text-emerald-600 border-b border-gray-100 text-sm">{{ $sertifikat->count() }} Sertifikat</td></tr>
                            <tr><td class="p-3.5 font-bold text-gray-900 text-sm">Kerja Praktik / Magang</td><td class="p-3.5 font-bold text-emerald-600 text-sm">{{ $magang->count() }} Kegiatan</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-center mt-8 animate-fade-in">
            <p class="text-xs font-medium text-gray-500">&copy; 2026 Universitas Nurul Jadid. All rights reserved.</p>
            <p class="text-xs font-medium text-gray-500 mt-1">Untuk pertanyaan, hubungi <a href="mailto:info@unuja.ac.id" class="text-unuja-600 hover:underline font-semibold">info@unuja.ac.id</a></p>
        </div>
    </div>

</body>
</html>