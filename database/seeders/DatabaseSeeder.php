<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Models\Kurikulum;
use App\Models\KategoriCpl;
use App\Models\CplProdi;
use App\Models\Mahasiswa;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Fakultas
        $fti = Fakultas::create([
            'nama_fakultas' => 'Fakultas Teknologi Informasi',
            'kode_fakultas' => 'FTI',
            'dekan' => 'Dr. Andi Wijaya, M.T.',
            'nidn_dekan' => '0401017801',
            'status' => 'active'
        ]);

        $ft = Fakultas::create([
            'nama_fakultas' => 'Fakultas Teknik',
            'kode_fakultas' => 'FT',
            'dekan' => 'Prof. Dr. Ir. Budi Santoso, M.T.',
            'nidn_dekan' => '0402037002',
            'status' => 'active'
        ]);

        $feb = Fakultas::create([
            'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis',
            'kode_fakultas' => 'FEB',
            'dekan' => 'Dra. Sri Wahyuni, M.Si.',
            'nidn_dekan' => '0412057503',
            'status' => 'active'
        ]);

        // 2. Seed Program Studi
        $tif = ProgramStudi::create([
            'id_prodi' => 'TIF',
            'id_fakultas' => $fti->id_fakultas,
            'nama_prodi' => 'Teknik Informatika',
            'kode_prodi' => 'IF',
            'jenjang' => 'S1',
            'gelar' => 'S.Kom.',
            'sk_akreditasi' => '123/SK/BAN-PT/2023',
            'tanggal_sk_akreditasi' => '2023-05-10',
            'masa_berlaku_akreditasi' => '2028-05-10',
            'jenjang_kkni' => 'Level 6',
            'bahasa_pengantar' => 'Indonesia',
            'lama_studi' => '8 Semester',
            'jenis_pendidikan' => 'Akademik',
            'jenis_pendidikan_lanjutan' => 'Program Magister (S2)',
            'persyaratan_penerimaan' => 'Lulusan SMA/SMK/MA sederajat jurusan IPA/Teknik',
            'alamat_prodi' => 'Gedung A Kampus 1, Jl. Raya Utama No. 10',
            'telepon_prodi' => '021-1234567',
            'email_prodi' => 'informatika@univ.ac.id',
            'status' => 'active'
        ]);

        $si = ProgramStudi::create([
            'id_prodi' => 'SI',
            'id_fakultas' => $fti->id_fakultas,
            'nama_prodi' => 'Sistem Informasi',
            'kode_prodi' => 'SI',
            'jenjang' => 'S1',
            'gelar' => 'S.Kom.',
            'sk_akreditasi' => '124/SK/BAN-PT/2023',
            'tanggal_sk_akreditasi' => '2023-06-15',
            'masa_berlaku_akreditasi' => '2028-06-15',
            'jenjang_kkni' => 'Level 6',
            'bahasa_pengantar' => 'Indonesia',
            'lama_studi' => '8 Semester',
            'jenis_pendidikan' => 'Akademik',
            'jenis_pendidikan_lanjutan' => 'Program Magister (S2)',
            'persyaratan_penerimaan' => 'Lulusan SMA/SMK/MA sederajat semua jurusan',
            'alamat_prodi' => 'Gedung B Kampus 1, Jl. Raya Utama No. 10',
            'telepon_prodi' => '021-1234568',
            'email_prodi' => 'si@univ.ac.id',
            'status' => 'active'
        ]);

        $ts = ProgramStudi::create([
            'id_prodi' => 'TS',
            'id_fakultas' => $ft->id_fakultas,
            'nama_prodi' => 'Teknik Sipil',
            'kode_prodi' => 'TS',
            'jenjang' => 'S1',
            'gelar' => 'S.T.',
            'sk_akreditasi' => '125/SK/BAN-PT/2023',
            'tanggal_sk_akreditasi' => '2023-07-20',
            'masa_berlaku_akreditasi' => '2028-07-20',
            'jenjang_kkni' => 'Level 6',
            'bahasa_pengantar' => 'Indonesia',
            'lama_studi' => '8 Semester',
            'jenis_pendidikan' => 'Akademik',
            'jenis_pendidikan_lanjutan' => 'Program Magister (S2)',
            'persyaratan_penerimaan' => 'Lulusan SMA/SMK/MA sederajat jurusan IPA/Teknik',
            'alamat_prodi' => 'Gedung C Kampus 2, Jl. Pendidikan No. 5',
            'telepon_prodi' => '021-7654321',
            'email_prodi' => 'sipil@univ.ac.id',
            'status' => 'active'
        ]);

        $man = ProgramStudi::create([
            'id_prodi' => 'MAN',
            'id_fakultas' => $feb->id_fakultas,
            'nama_prodi' => 'Manajemen',
            'kode_prodi' => 'MN',
            'jenjang' => 'S1',
            'gelar' => 'S.E.',
            'sk_akreditasi' => '126/SK/BAN-PT/2023',
            'tanggal_sk_akreditasi' => '2023-08-25',
            'masa_berlaku_akreditasi' => '2028-08-25',
            'jenjang_kkni' => 'Level 6',
            'bahasa_pengantar' => 'Indonesia',
            'lama_studi' => '8 Semester',
            'jenis_pendidikan' => 'Akademik',
            'jenis_pendidikan_lanjutan' => 'Program Magister (S2)',
            'persyaratan_penerimaan' => 'Lulusan SMA/SMK/MA sederajat semua jurusan',
            'alamat_prodi' => 'Gedung D Kampus 2, Jl. Pendidikan No. 5',
            'telepon_prodi' => '021-7654322',
            'email_prodi' => 'manajemen@univ.ac.id',
            'status' => 'active'
        ]);

        // 3. Seed Kurikulum
        $kurikulumTif = Kurikulum::create([
            'id_prodi' => 'TIF',
            'nama_kurikulum' => 'Kurikulum MBKM TIF 2024',
            'tahun' => 2024
        ]);

        $kurikulumSi = Kurikulum::create([
            'id_prodi' => 'SI',
            'nama_kurikulum' => 'Kurikulum MBKM SI 2024',
            'tahun' => 2024
        ]);

        $kurikulumTs = Kurikulum::create([
            'id_prodi' => 'TS',
            'nama_kurikulum' => 'Kurikulum MBKM TS 2024',
            'tahun' => 2024
        ]);

        $kurikulumMan = Kurikulum::create([
            'id_prodi' => 'MAN',
            'nama_kurikulum' => 'Kurikulum MBKM MAN 2024',
            'tahun' => 2024
        ]);

        // 4. Seed Kategori CPL
        $kategoriSikap = KategoriCpl::create([
            'kode_kategori' => 'S',
            'nama_kategori' => 'Sikap',
            'urutan' => 1
        ]);

        $kategoriKU = KategoriCpl::create([
            'kode_kategori' => 'KU',
            'nama_kategori' => 'Keterampilan Umum',
            'urutan' => 2
        ]);

        $kategoriKK = KategoriCpl::create([
            'kode_kategori' => 'KK',
            'nama_kategori' => 'Keterampilan Khusus',
            'urutan' => 3
        ]);

        $kategoriPengetahuan = KategoriCpl::create([
            'kode_kategori' => 'P',
            'nama_kategori' => 'Pengetahuan',
            'urutan' => 4
        ]);

        // 5. Seed CPL Prodi
        // CPL Teknik Informatika (TIF)
        CplProdi::create([
            'id_prodi' => 'TIF',
            'id_kurikulum' => $kurikulumTif->id_kurikulum,
            'id_kategori' => $kategoriSikap->id_kategori,
            'kode_cpl' => 'S1',
            'deskripsi_cpl' => 'Bertaqwa kepada Tuhan Yang Maha Esa dan mampu menunjukkan sikap religius.',
            'urutan' => 1
        ]);
        CplProdi::create([
            'id_prodi' => 'TIF',
            'id_kurikulum' => $kurikulumTif->id_kurikulum,
            'id_kategori' => $kategoriSikap->id_kategori,
            'kode_cpl' => 'S2',
            'deskripsi_cpl' => 'Menjunjung tinggi nilai kemanusiaan dalam menjalankan tugas berdasarkan agama, moral, dan etika.',
            'urutan' => 2
        ]);
        CplProdi::create([
            'id_prodi' => 'TIF',
            'id_kurikulum' => $kurikulumTif->id_kurikulum,
            'id_kategori' => $kategoriKU->id_kategori,
            'kode_cpl' => 'KU1',
            'deskripsi_cpl' => 'Mampu menerapkan pemikiran logis, kritis, sistematis, dan inovatif dalam konteks pengembangan atau implementasi ilmu pengetahuan dan teknologi.',
            'urutan' => 1
        ]);
        CplProdi::create([
            'id_prodi' => 'TIF',
            'id_kurikulum' => $kurikulumTif->id_kurikulum,
            'id_kategori' => $kategoriKK->id_kategori,
            'kode_cpl' => 'KK1',
            'deskripsi_cpl' => 'Mampu merancang dan mengimplementasikan arsitektur sistem komputer, jaringan komputer, dan algoritma kompleks.',
            'urutan' => 1
        ]);
        CplProdi::create([
            'id_prodi' => 'TIF',
            'id_kurikulum' => $kurikulumTif->id_kurikulum,
            'id_kategori' => $kategoriKK->id_kategori,
            'kode_cpl' => 'KK2',
            'deskripsi_cpl' => 'Mampu mengembangkan perangkat lunak berbasis web, mobile, dan desktop menggunakan praktik rekayasa perangkat lunak modern.',
            'urutan' => 2
        ]);
        CplProdi::create([
            'id_prodi' => 'TIF',
            'id_kurikulum' => $kurikulumTif->id_kurikulum,
            'id_kategori' => $kategoriPengetahuan->id_kategori,
            'kode_cpl' => 'P1',
            'deskripsi_cpl' => 'Menguasai konsep teoritis ilmu komputer, termasuk struktur data, algoritma, basis data, dan pemrograman.',
            'urutan' => 1
        ]);

        // CPL Sistem Informasi (SI)
        CplProdi::create([
            'id_prodi' => 'SI',
            'id_kurikulum' => $kurikulumSi->id_kurikulum,
            'id_kategori' => $kategoriSikap->id_kategori,
            'kode_cpl' => 'S1',
            'deskripsi_cpl' => 'Bertaqwa kepada Tuhan Yang Maha Esa dan mampu menunjukkan sikap religius.',
            'urutan' => 1
        ]);
        CplProdi::create([
            'id_prodi' => 'SI',
            'id_kurikulum' => $kurikulumSi->id_kurikulum,
            'id_kategori' => $kategoriKU->id_kategori,
            'kode_cpl' => 'KU1',
            'deskripsi_cpl' => 'Mampu menerapkan pemikiran logis, kritis, sistematis, dan inovatif dalam konteks pengembangan atau implementasi ilmu pengetahuan dan teknologi.',
            'urutan' => 1
        ]);
        CplProdi::create([
            'id_prodi' => 'SI',
            'id_kurikulum' => $kurikulumSi->id_kurikulum,
            'id_kategori' => $kategoriKK->id_kategori,
            'kode_cpl' => 'KK1',
            'deskripsi_cpl' => 'Mampu menganalisis, merancang, dan mengimplementasikan sistem informasi enterprise yang mendukung strategi bisnis organisasi.',
            'urutan' => 1
        ]);
        CplProdi::create([
            'id_prodi' => 'SI',
            'id_kurikulum' => $kurikulumSi->id_kurikulum,
            'id_kategori' => $kategoriPengetahuan->id_kategori,
            'kode_cpl' => 'P1',
            'deskripsi_cpl' => 'Menguasai prinsip integrasi sistem, manajemen proyek TI, dan analisis proses bisnis.',
            'urutan' => 1
        ]);

        // 6. Seed Mahasiswa
        Mahasiswa::create([
            'nim' => '230101001',
            'id_prodi' => 'TIF',
            'id_kurikulum' => $kurikulumTif->id_kurikulum,
            'nama_lengkap' => 'Budi Raharjo',
            'tempat_lahir' => 'Semarang',
            'tanggal_lahir' => '2004-05-12',
            'tahun_masuk' => 2023,
            'status' => 'Aktif',
            'ipk' => 3.85,
            'email' => 'budi@student.ac.id',
            'nomor_telepon' => '081234567890',
            'password' => 'mahasiswa123' // model casts hashed automatically
        ]);

        Mahasiswa::create([
            'nim' => '220101002',
            'id_prodi' => 'TIF',
            'id_kurikulum' => $kurikulumTif->id_kurikulum,
            'nama_lengkap' => 'Siti Aminah',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2003-08-24',
            'tahun_masuk' => 2022,
            'status' => 'Aktif',
            'ipk' => 3.92,
            'email' => 'siti@student.ac.id',
            'nomor_telepon' => '081234567891',
            'password' => 'password'
        ]);

        Mahasiswa::create([
            'nim' => '230202001',
            'id_prodi' => 'SI',
            'id_kurikulum' => $kurikulumSi->id_kurikulum,
            'nama_lengkap' => 'Doni Pratama',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2004-11-02',
            'tahun_masuk' => 2023,
            'status' => 'Aktif',
            'ipk' => 3.70,
            'email' => 'doni@student.ac.id',
            'nomor_telepon' => '081234567892',
            'password' => 'password'
        ]);

        Mahasiswa::create([
            'nim' => '200202099',
            'id_prodi' => 'SI',
            'id_kurikulum' => $kurikulumSi->id_kurikulum,
            'nama_lengkap' => 'Riska Amalia',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2002-02-15',
            'tahun_masuk' => 2020,
            'tahun_lulus' => 2024,
            'tanggal_lulus' => '2024-03-20',
            'status' => 'Lulus',
            'ipk' => 3.78,
            'email' => 'riska@student.ac.id',
            'nomor_telepon' => '081234567893',
            'password' => 'password'
        ]);

        // 7. Seed Users
        User::create([
            'username' => 'admin',
            'nama_lengkap' => 'Administrator Utama',
            'role' => 'admin',
            'id_prodi' => null,
            'email' => 'admin@system.ac.id',
            'password' => 'admin123', // model casts hashed automatically
            'aktif' => true
        ]);

        User::create([
            'username' => 'bak_fti',
            'nama_lengkap' => 'Layanan Akademik FTI',
            'role' => 'bak_fakultas',
            'id_prodi' => 'TIF',
            'email' => 'bak.fti@system.ac.id',
            'password' => 'bak123',
            'aktif' => true
        ]);
    }
}
