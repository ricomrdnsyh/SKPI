-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2026 at 05:26 AM
-- Server version: 8.0.46
-- PHP Version: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbskpi`
--

-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

CREATE TABLE `approvals` (
  `id_approval` bigint UNSIGNED NOT NULL,
  `approvable_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `approvable_id` bigint UNSIGNED NOT NULL,
  `role` enum('baak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `status` enum('approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approvals`
--

INSERT INTO `approvals` (`id_approval`, `approvable_type`, `approvable_id`, `role`, `user_id`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'prestasi', 1, 'baak', 4, 'approved', NULL, '2026-07-09 03:00:38', '2026-07-09 03:00:38'),
(2, 'organisasi', 1, 'baak', 4, 'approved', NULL, '2026-07-09 03:09:54', '2026-07-09 03:09:54'),
(3, 'sertifikat', 1, 'baak', 4, 'approved', NULL, '2026-07-09 03:10:11', '2026-07-09 03:10:11'),
(4, 'magang', 1, 'baak', 4, 'approved', NULL, '2026-07-09 03:10:13', '2026-07-09 03:10:13'),
(5, 'tugas_akhir', 2, 'baak', 4, 'approved', NULL, '2026-07-09 03:10:16', '2026-07-09 03:10:16'),
(6, 'pengajuan_skpi', 1, 'baak', 4, 'rejected', 'Pembatalan Cetak: salah', '2026-07-09 03:45:49', '2026-07-09 03:45:49'),
(7, 'pengajuan_skpi', 1, 'baak', 4, 'rejected', 'Pembatalan Cetak: Cek lagi berkasnya', '2026-07-09 03:53:50', '2026-07-09 03:53:50'),
(8, 'pengajuan_skpi', 1, 'baak', 4, 'rejected', 'Pembatalan Cetak: Salah', '2026-07-09 03:57:12', '2026-07-09 03:57:12'),
(9, 'pengajuan_skpi', 1, 'baak', 4, 'rejected', 'Pembatalan Cetak: Salah', '2026-07-09 04:16:38', '2026-07-09 04:16:38');

-- --------------------------------------------------------

--
-- Table structure for table `checklist_verifikasi_skpi`
--

CREATE TABLE `checklist_verifikasi_skpi` (
  `id_checklist` int UNSIGNED NOT NULL,
  `id_pengajuan` int UNSIGNED NOT NULL,
  `cek_identitas_mahasiswa` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Nama, TTL, NIM, NIM Ijazah',
  `cek_identitas_prodi` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'SK akreditasi, gelar, jenjang, dll',
  `cek_cpl` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Capaian Pembelajaran Lulusan sudah terisi',
  `cek_prestasi` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Prestasi/penghargaan sudah diverifikasi',
  `cek_organisasi` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Keikutsertaan organisasi sudah diverifikasi',
  `cek_sertifikat` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Sertifikat keahlian sudah diverifikasi',
  `cek_magang` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Data magang/kerja praktik sudah diverifikasi',
  `cek_tugas_akhir` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Judul TA dan nama pembimbing sudah benar',
  `cek_sistem_penilaian` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Konversi nilai sudah sesuai',
  `hasil_verifikasi` enum('lulus','perlu_revisi','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'perlu_revisi',
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Catatan khusus dari BAK untuk mahasiswa',
  `diverifikasi_oleh` int UNSIGNED NOT NULL,
  `tanggal_verifikasi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cpl_prodi`
--

CREATE TABLE `cpl_prodi` (
  `id_cpl` int UNSIGNED NOT NULL,
  `id_prodi` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kurikulum` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori` tinyint UNSIGNED NOT NULL,
  `kode_cpl` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_cpl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` smallint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cpl_prodi`
--

INSERT INTO `cpl_prodi` (`id_cpl`, `id_prodi`, `id_kurikulum`, `id_kategori`, `kode_cpl`, `deskripsi_cpl`, `urutan`) VALUES
(1, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 1, 'S1', 'Bertakwa kepada Tuhan Yang Maha Esa dan mampu menunjukkan sikap religius.', 1),
(2, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 1, 'S2', 'Menjunjung tinggi nilai kemanusiaan dalam menjalankan tugas berdasarkan agama, moral, dan etika.', 2),
(3, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 1, 'S3', 'Berkontribusi dalam peningkatan mutu kehidupan bermasyarakat, berbangsa, bernegara, dan kemajuan peradaban berdasarkan Pancasila.', 3),
(4, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 1, 'S4', 'Berperan sebagai warga negara yang bangga dan cinta tanah air, memiliki nasionalisme serta rasa tanggungjawab pada negara dan bangsa.', 4),
(5, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 1, 'S5', 'Menghargai keanekaragaman budaya, pandangan, agama, dan kepercayaan, serta pendapat atau temuan orisinal orang lain.', 5),
(6, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 1, 'S6', 'Bekerja sama dan memiliki kepekaan sosial serta kepedulian terhadap masyarakat dan lingkungan.', 6),
(7, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 2, 'P1', 'Menguasai konsep teoritis bidang pengetahuan secara umum dan mendalam sesuai standar KKNI.', 1),
(8, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 2, 'P2', 'Menguasai prinsip dan teknik perancangan sistem dan/atau rekayasa perangkat lunak.', 2),
(9, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 2, 'P3', 'Menguasai pengetahuan tentang teknologi terkini yang sedang berkembang dalam bidang informatika dan ilmu komputer.', 3),
(10, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 2, 'P4', 'Menguasai konsep dan algoritma dasar dalam pemecahan masalah komputasi secara efektif dan efisien.', 4),
(11, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 2, 'P5', 'Menguasai arsitektur sistem komputer, jaringan komputer, dan keamanan sistem informasi.', 5),
(12, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 2, 'P6', 'Menguasai prinsip-prinsip kecerdasan buatan, sains data, dan penerapannya dalam berbagai domain.', 6),
(13, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 3, 'KU1', 'Mampu menerapkan pemikiran logis, kritis, sistematis, dan inovatif dalam konteks pengembangan atau implementasi ilmu pengetahuan dan teknologi.', 1),
(14, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 3, 'KU2', 'Mampu menunjukkan kinerja mandiri, bermutu, dan terukur.', 2),
(15, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 3, 'KU3', 'Mampu mengambil keputusan secara tepat dalam konteks penyelesaian masalah di bidang keahliannya, berdasarkan hasil analisis informasi dan data.', 3),
(16, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 3, 'KU4', 'Mampu menyusun deskripsi saintifik hasil kajian tersebut dalam bentuk skripsi atau laporan tugas akhir, dan mengunggahnya dalam laman perguruan tinggi.', 4),
(17, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 3, 'KU5', 'Mampu memelihara dan mengembangkan jaringan kerja dengan pembimbing, kolega, sejawat baik di dalam maupun di luar lembaganya.', 5),
(18, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 3, 'KU6', 'Mampu bertanggungjawab atas pencapaian hasil kerja kelompok dan melakukan supervisi dan evaluasi terhadap penyelesaian pekerjaan yang ditugaskan.', 6),
(19, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 4, 'KK1', 'Mampu merancang dan mengembangkan algoritma untuk menyelesaikan masalah secara efektif dan efisien.', 1),
(20, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 4, 'KK2', 'Mampu merancang, membangun, dan memelihara perangkat lunak dengan menggunakan metode, teknik, dan alat bantu pengembangan perangkat lunak (Software Engineering).', 2),
(21, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 4, 'KK3', 'Mampu menerapkan konsep keamanan sistem informasi dan melindungi data dari ancaman siber.', 3),
(22, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 4, 'KK4', 'Mampu mengelola database relasional maupun non-relasional serta melakukan optimasi query pada sistem berskala besar.', 4),
(23, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 4, 'KK5', 'Mampu merancang infrastruktur jaringan komputer dan menerapkan solusi cloud computing secara aman dan terukur.', 5),
(24, '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 4, 'KK6', 'Mampu menerapkan teknik machine learning dan data mining untuk mengekstraksi wawasan berharga dari data berskala besar.', 6);

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `id_fakultas` tinyint UNSIGNED NOT NULL,
  `nama_fakultas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_fakultas` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telepon` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dekan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nidn_dekan` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','nonaktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id_fakultas`, `nama_fakultas`, `kode_fakultas`, `no_telepon`, `dekan`, `nidn_dekan`, `status`) VALUES
(1, 'Agama Islam', 'FAI', '0888 30 78899', 'Dr. AHMAD FAWAID, M.Th.I', '2104108901', 'aktif'),
(2, 'Teknik', 'FT', '081313559926', 'ZAINAL ARIFIN, M.Kom.', '0730038602', 'aktif'),
(3, 'Kesehatan', 'FKES', '0888 30 77077', 'Dr. SRI ASTUTIK ANDAYANI, S.Kep., Ns., M.Kes.', '070101860', 'aktif'),
(4, 'Sosial dan Humaniora', 'SOSHUM', '0888 30 77077', 'Dr. H. CHUSNUL MUALI, M.Pd.', '2101127701', 'aktif'),
(5, 'Pascasarjana', 'PASCA', '0888 30 77077', 'Dr. H. AKMAL MUNDIRI, M.Pd.', '0727038403', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_cpl`
--

CREATE TABLE `kategori_cpl` (
  `id_kategori` tinyint UNSIGNED NOT NULL,
  `kode_kategori` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` tinyint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_cpl`
--

INSERT INTO `kategori_cpl` (`id_kategori`, `kode_kategori`, `nama_kategori`, `urutan`) VALUES
(1, 'S', 'Sikap', 1),
(2, 'P', 'Penguasaan Pengetahuan', 2),
(3, 'KU', 'Keterampilan Umum', 3),
(4, 'KK', 'Keterampilan Khusus', 4);

-- --------------------------------------------------------

--
-- Table structure for table `kurikulum`
--

CREATE TABLE `kurikulum` (
  `id_kurikulum` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_prodi` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kurikulum` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kurikulum`
--

INSERT INTO `kurikulum` (`id_kurikulum`, `id_prodi`, `nama_kurikulum`, `created_at`, `updated_at`) VALUES
('1', '003dd606-a40d-4953-ba4c-aa98bf2ff1bb', 'PBI 2017', NULL, NULL),
('2', '003dd606-a40d-4953-ba4c-aa98bf2ff1bb', 'PBI 2018', NULL, NULL),
('3', '003dd606-a40d-4953-ba4c-aa98bf2ff1bb', 'PBI 2019', NULL, NULL),
('4', '003dd606-a40d-4953-ba4c-aa98bf2ff1bb', 'PBI 2020', NULL, NULL),
('5', '003dd606-a40d-4953-ba4c-aa98bf2ff1bb', 'PBI 2021', NULL, NULL),
('6', '003dd606-a40d-4953-ba4c-aa98bf2ff1bb', 'PBI 2022', NULL, NULL),
('7', '003dd606-a40d-4953-ba4c-aa98bf2ff1bb', 'PBI 2024', NULL, NULL),
('8', '01efb76b-f9b2-4b26-ae06-de90b0daff10', 'KEB 2018', NULL, NULL),
('9', '01efb76b-f9b2-4b26-ae06-de90b0daff10', 'KEB 2019', NULL, NULL),
('10', '01efb76b-f9b2-4b26-ae06-de90b0daff10', 'KEB 2020', NULL, NULL),
('11', '01efb76b-f9b2-4b26-ae06-de90b0daff10', 'KEB 2021', NULL, NULL),
('12', '01efb76b-f9b2-4b26-ae06-de90b0daff10', 'KEB 2022', NULL, NULL),
('13', '01efb76b-f9b2-4b26-ae06-de90b0daff10', 'KEB 2024', NULL, NULL),
('14', '07182d28-d2a0-44e8-a731-74bea57161f7', 'HK (AS) 2017', NULL, NULL),
('15', '07182d28-d2a0-44e8-a731-74bea57161f7', 'HK (AS) 2018', NULL, NULL),
('16', '07182d28-d2a0-44e8-a731-74bea57161f7', 'HK (AS) 2019', NULL, NULL),
('17', '07182d28-d2a0-44e8-a731-74bea57161f7', 'HK (AS) 2020', NULL, NULL),
('18', '07182d28-d2a0-44e8-a731-74bea57161f7', 'HK (AS) 2021', NULL, NULL),
('19', '07182d28-d2a0-44e8-a731-74bea57161f7', 'HK (AS) 2022', NULL, NULL),
('20', '07182d28-d2a0-44e8-a731-74bea57161f7', 'HK (AS) 2024', NULL, NULL),
('21', '0dfc4a93-87e0-414e-809c-10c380ebe3af', 'PAI S2 20182', NULL, NULL),
('22', '0dfc4a93-87e0-414e-809c-10c380ebe3af', 'PAI S2 2019', NULL, NULL),
('23', '0dfc4a93-87e0-414e-809c-10c380ebe3af', 'PAI S2 2020', NULL, NULL),
('24', '0dfc4a93-87e0-414e-809c-10c380ebe3af', 'PAI S2 2021', NULL, NULL),
('25', '0dfc4a93-87e0-414e-809c-10c380ebe3af', 'PAI S2 2022', NULL, NULL),
('26', '0dfc4a93-87e0-414e-809c-10c380ebe3af', 'PAI S2 2024', NULL, NULL),
('27', '0dfc4a93-87e0-414e-809c-10c380ebe3af', 'PAI-S2 20172', NULL, NULL),
('28', '0f6bb17f-efdd-493c-8939-30c215bd9fb1', 'TE 2017', NULL, NULL),
('29', '0f6bb17f-efdd-493c-8939-30c215bd9fb1', 'TE 2018', NULL, NULL),
('30', '0f6bb17f-efdd-493c-8939-30c215bd9fb1', 'TE 2019', NULL, NULL),
('31', '0f6bb17f-efdd-493c-8939-30c215bd9fb1', 'TE 2020', NULL, NULL),
('32', '0f6bb17f-efdd-493c-8939-30c215bd9fb1', 'TE 2021', NULL, NULL),
('33', '0f6bb17f-efdd-493c-8939-30c215bd9fb1', 'TE OBE 2023', NULL, NULL),
('34', '0f6bb17f-efdd-493c-8939-30c215bd9fb1', 'TE OBE 2024', NULL, NULL),
('35', '1319bfef-2188-4240-b7a3-7a507bec2e64', 'IF 2017', NULL, NULL),
('36', '1319bfef-2188-4240-b7a3-7a507bec2e64', 'IF 2018', NULL, NULL),
('37', '1319bfef-2188-4240-b7a3-7a507bec2e64', 'IF 2019', NULL, NULL),
('38', '1319bfef-2188-4240-b7a3-7a507bec2e64', 'IF 2020', NULL, NULL),
('39', '1319bfef-2188-4240-b7a3-7a507bec2e64', 'IF 2021', NULL, NULL),
('40', '1319bfef-2188-4240-b7a3-7a507bec2e64', 'IF OBE 2023', NULL, NULL),
('41', '1319bfef-2188-4240-b7a3-7a507bec2e64', 'IF OBE 2024', NULL, NULL),
('42', '2e564765-2859-4dd5-ad2a-74264481767f', 'SI S3 2025', NULL, NULL),
('43', '33c03a4c-855d-4fac-880a-3872f14a23b7', 'MPI S2 2017', NULL, NULL),
('44', '33c03a4c-855d-4fac-880a-3872f14a23b7', 'MPI S2 2018', NULL, NULL),
('45', '33c03a4c-855d-4fac-880a-3872f14a23b7', 'MPI S2 2019', NULL, NULL),
('46', '33c03a4c-855d-4fac-880a-3872f14a23b7', 'MPI S2 2020', NULL, NULL),
('47', '33c03a4c-855d-4fac-880a-3872f14a23b7', 'MPI S2 2021', NULL, NULL),
('48', '33c03a4c-855d-4fac-880a-3872f14a23b7', 'MPI S2 2022', NULL, NULL),
('49', '33c03a4c-855d-4fac-880a-3872f14a23b7', 'MPI S2 2024', NULL, NULL),
('50', '361d0099-39ba-41d3-b8d8-e4093fa8781b', 'MPI 2017', NULL, NULL),
('51', '361d0099-39ba-41d3-b8d8-e4093fa8781b', 'MPI 2018', NULL, NULL),
('52', '361d0099-39ba-41d3-b8d8-e4093fa8781b', 'MPI 2019', NULL, NULL),
('53', '361d0099-39ba-41d3-b8d8-e4093fa8781b', 'MPI 2020', NULL, NULL),
('54', '361d0099-39ba-41d3-b8d8-e4093fa8781b', 'MPI 2021', NULL, NULL),
('55', '361d0099-39ba-41d3-b8d8-e4093fa8781b', 'MPI 2022', NULL, NULL),
('56', '361d0099-39ba-41d3-b8d8-e4093fa8781b', 'MPI 2024', NULL, NULL),
('57', '3a987a0a-9336-4aee-986a-298e2e2a1470', 'PAI 2017', NULL, NULL),
('58', '3a987a0a-9336-4aee-986a-298e2e2a1470', 'PAI 2018', NULL, NULL),
('59', '3a987a0a-9336-4aee-986a-298e2e2a1470', 'PAI 2019', NULL, NULL),
('60', '3a987a0a-9336-4aee-986a-298e2e2a1470', 'PAI 2020', NULL, NULL),
('61', '3a987a0a-9336-4aee-986a-298e2e2a1470', 'PAI 2021', NULL, NULL),
('62', '3a987a0a-9336-4aee-986a-298e2e2a1470', 'PAI 2022', NULL, NULL),
('63', '3a987a0a-9336-4aee-986a-298e2e2a1470', 'PAI 2024', NULL, NULL),
('64', '423716ff-d094-41ef-99e6-02cbd05c72d1', 'NERS 2020', NULL, NULL),
('65', '423716ff-d094-41ef-99e6-02cbd05c72d1', 'NERS 2021', NULL, NULL),
('66', '423716ff-d094-41ef-99e6-02cbd05c72d1', 'NERS 2022', NULL, NULL),
('67', '423716ff-d094-41ef-99e6-02cbd05c72d1', 'NERS 2023', NULL, NULL),
('68', '423716ff-d094-41ef-99e6-02cbd05c72d1', 'NERS 2024', NULL, NULL),
('69', '423716ff-d094-41ef-99e6-02cbd05c72d1', 'NERS 2025', NULL, NULL),
('70', '6bb7c485-08a3-465c-b549-e5223c2affe2', 'TI 2018', NULL, NULL),
('71', '6bb7c485-08a3-465c-b549-e5223c2affe2', 'TI 2019', NULL, NULL),
('72', '6bb7c485-08a3-465c-b549-e5223c2affe2', 'TI 2020', NULL, NULL),
('73', '6bb7c485-08a3-465c-b549-e5223c2affe2', 'TI 2021', NULL, NULL),
('74', '6bb7c485-08a3-465c-b549-e5223c2affe2', 'TI OBE 2023', NULL, NULL),
('75', '6bb7c485-08a3-465c-b549-e5223c2affe2', 'TI OBE 2024', NULL, NULL),
('76', '7fc4e88b-872b-4a3d-b022-25eacb6a5d82', 'KEP 2017', NULL, NULL),
('77', '7fc4e88b-872b-4a3d-b022-25eacb6a5d82', 'KEP 2018', NULL, NULL),
('78', '7fc4e88b-872b-4a3d-b022-25eacb6a5d82', 'KEP 2019', NULL, NULL),
('79', '7fc4e88b-872b-4a3d-b022-25eacb6a5d82', 'KEP 2020', NULL, NULL),
('80', '7fc4e88b-872b-4a3d-b022-25eacb6a5d82', 'KEP 2020 B', NULL, NULL),
('81', '7fc4e88b-872b-4a3d-b022-25eacb6a5d82', 'KEP 2021', NULL, NULL),
('82', '7fc4e88b-872b-4a3d-b022-25eacb6a5d82', 'KEP 2022', NULL, NULL),
('83', '7fc4e88b-872b-4a3d-b022-25eacb6a5d82', 'KEP 2024', NULL, NULL),
('84', '81cba784-728f-40e6-8fc4-5629cd83e742', 'EKN 2018', NULL, NULL),
('85', '81cba784-728f-40e6-8fc4-5629cd83e742', 'EKN 2019', NULL, NULL),
('86', '81cba784-728f-40e6-8fc4-5629cd83e742', 'EKN 2020', NULL, NULL),
('87', '81cba784-728f-40e6-8fc4-5629cd83e742', 'EKN 2021', NULL, NULL),
('88', '81cba784-728f-40e6-8fc4-5629cd83e742', 'EKN 2022', NULL, NULL),
('89', '81cba784-728f-40e6-8fc4-5629cd83e742', 'EKN 2023', NULL, NULL),
('90', '81cba784-728f-40e6-8fc4-5629cd83e742', 'EKN 2024', NULL, NULL),
('91', '9155f632-5e5a-4b21-a44e-20b43d9f08da', 'PS 20171', NULL, NULL),
('92', '9155f632-5e5a-4b21-a44e-20b43d9f08da', 'PS 2018', NULL, NULL),
('93', '9155f632-5e5a-4b21-a44e-20b43d9f08da', 'PS 2019', NULL, NULL),
('94', '9155f632-5e5a-4b21-a44e-20b43d9f08da', 'PS 2020', NULL, NULL),
('95', '9155f632-5e5a-4b21-a44e-20b43d9f08da', 'PS 2021', NULL, NULL),
('96', '9155f632-5e5a-4b21-a44e-20b43d9f08da', 'PS 2022', NULL, NULL),
('97', '9155f632-5e5a-4b21-a44e-20b43d9f08da', 'PS 2024', NULL, NULL),
('98', '9207a610-30ea-46f1-9a27-0ccf429cddaf', 'MAT 2018', NULL, NULL),
('99', '9207a610-30ea-46f1-9a27-0ccf429cddaf', 'MAT 2019', NULL, NULL),
('100', '9207a610-30ea-46f1-9a27-0ccf429cddaf', 'MAT 2020', NULL, NULL),
('101', '9207a610-30ea-46f1-9a27-0ccf429cddaf', 'MAT 2021', NULL, NULL),
('102', '9207a610-30ea-46f1-9a27-0ccf429cddaf', 'MAT 2022', NULL, NULL),
('103', '9207a610-30ea-46f1-9a27-0ccf429cddaf', 'PMAT 2024', NULL, NULL),
('104', '95f0ed5a-0fb9-4c9d-898c-d2b4b313850d', 'ES 2017', NULL, NULL),
('105', '95f0ed5a-0fb9-4c9d-898c-d2b4b313850d', 'ES 2018', NULL, NULL),
('106', '95f0ed5a-0fb9-4c9d-898c-d2b4b313850d', 'ES 2019', NULL, NULL),
('107', '95f0ed5a-0fb9-4c9d-898c-d2b4b313850d', 'ES 2020', NULL, NULL),
('108', '95f0ed5a-0fb9-4c9d-898c-d2b4b313850d', 'ES 2021', NULL, NULL),
('109', '95f0ed5a-0fb9-4c9d-898c-d2b4b313850d', 'ES 2022', NULL, NULL),
('110', '95f0ed5a-0fb9-4c9d-898c-d2b4b313850d', 'ES 2024', NULL, NULL),
('111', 'af4cfc27-cd33-4b79-b637-bdc2c090dd76', 'PBA 2017', NULL, NULL),
('112', 'af4cfc27-cd33-4b79-b637-bdc2c090dd76', 'PBA 2018', NULL, NULL),
('113', 'af4cfc27-cd33-4b79-b637-bdc2c090dd76', 'PBA 2019', NULL, NULL),
('114', 'af4cfc27-cd33-4b79-b637-bdc2c090dd76', 'PBA 2020', NULL, NULL),
('115', 'af4cfc27-cd33-4b79-b637-bdc2c090dd76', 'PBA 2021', NULL, NULL),
('116', 'af4cfc27-cd33-4b79-b637-bdc2c090dd76', 'PBA 2022', NULL, NULL),
('117', 'af4cfc27-cd33-4b79-b637-bdc2c090dd76', 'PBA 2024', NULL, NULL),
('118', 'bef4580c-48da-4537-aeb7-9ab3d69b9dc6', 'KPI 2017', NULL, NULL),
('119', 'bef4580c-48da-4537-aeb7-9ab3d69b9dc6', 'KPI 2018', NULL, NULL),
('120', 'bef4580c-48da-4537-aeb7-9ab3d69b9dc6', 'KPI 2019', NULL, NULL),
('121', 'bef4580c-48da-4537-aeb7-9ab3d69b9dc6', 'KPI 2020', NULL, NULL),
('122', 'bef4580c-48da-4537-aeb7-9ab3d69b9dc6', 'KPI 2021', NULL, NULL),
('123', 'bef4580c-48da-4537-aeb7-9ab3d69b9dc6', 'KPI 2022', NULL, NULL),
('124', 'bef4580c-48da-4537-aeb7-9ab3d69b9dc6', 'KPI 2024', NULL, NULL),
('125', 'c7f21e09-b3fb-4b58-86fd-4e8db797a73e', 'PGMI 2017', NULL, NULL),
('126', 'c7f21e09-b3fb-4b58-86fd-4e8db797a73e', 'PGMI 2018', NULL, NULL),
('127', 'c7f21e09-b3fb-4b58-86fd-4e8db797a73e', 'PGMI 2019', NULL, NULL),
('128', 'c7f21e09-b3fb-4b58-86fd-4e8db797a73e', 'PGMI 2020', NULL, NULL),
('129', 'c7f21e09-b3fb-4b58-86fd-4e8db797a73e', 'PGMI 2021', NULL, NULL),
('130', 'c7f21e09-b3fb-4b58-86fd-4e8db797a73e', 'PGMI 2022', NULL, NULL),
('131', 'c7f21e09-b3fb-4b58-86fd-4e8db797a73e', 'PGMI 2024', NULL, NULL),
('132', 'dd735a4f-7a0f-4e8a-b8d6-42fb82768567', 'SI S2 2025', NULL, NULL),
('133', 'ec1fe213-c51d-4c40-b60e-adbf44decda7', 'IAT 2022', NULL, NULL),
('134', 'ec1fe213-c51d-4c40-b60e-adbf44decda7', 'IAT 2024', NULL, NULL),
('135', 'ec1fe213-c51d-4c40-b60e-adbf44decda7', 'IQT 2017', NULL, NULL),
('136', 'ec1fe213-c51d-4c40-b60e-adbf44decda7', 'IQT 2018', NULL, NULL),
('137', 'ec1fe213-c51d-4c40-b60e-adbf44decda7', 'IQT 2019', NULL, NULL),
('138', 'ec1fe213-c51d-4c40-b60e-adbf44decda7', 'IQT 2020', NULL, NULL),
('139', 'ec1fe213-c51d-4c40-b60e-adbf44decda7', 'IQT 2021', NULL, NULL),
('140', 'f208b4c5-39ce-46bf-a2a6-488ce6ec69ac', 'HK 2018', NULL, NULL),
('141', 'f208b4c5-39ce-46bf-a2a6-488ce6ec69ac', 'HK 2019', NULL, NULL),
('142', 'f208b4c5-39ce-46bf-a2a6-488ce6ec69ac', 'HK 2020', NULL, NULL),
('143', 'f208b4c5-39ce-46bf-a2a6-488ce6ec69ac', 'HK 2021', NULL, NULL),
('144', 'f208b4c5-39ce-46bf-a2a6-488ce6ec69ac', 'HK 2022', NULL, NULL),
('145', 'f208b4c5-39ce-46bf-a2a6-488ce6ec69ac', 'HK 2023', NULL, NULL),
('146', 'f208b4c5-39ce-46bf-a2a6-488ce6ec69ac', 'HK 2024', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `magang_mahasiswa`
--

CREATE TABLE `magang_mahasiswa` (
  `id_magang` int UNSIGNED NOT NULL,
  `nim` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_magang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posisi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `file_bukti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` int UNSIGNED DEFAULT NULL COMMENT 'FK users (role: bak_fakultas)',
  `approved_at` datetime DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `magang_mahasiswa`
--

INSERT INTO `magang_mahasiswa` (`id_magang`, `nim`, `tempat_magang`, `posisi`, `tanggal_mulai`, `tanggal_selesai`, `status`, `file_bukti`, `approved_by`, `approved_at`, `keterangan`, `created_at`) VALUES
(1, '2121400147', 'PT Mencari Cinta Sejati', 'Teknisi', '2026-07-08', '2026-07-08', 'approved', 'bukti_magang/9dAATj9cyaDesoZJOBH12OFsqLgw4A2VSOgPIBI9.pdf', 4, '2026-07-09 10:10:13', NULL, '2026-07-08 03:38:52');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_prodi` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kurikulum` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `tahun_masuk` year DEFAULT NULL,
  `tahun_lulus` year DEFAULT NULL,
  `tanggal_lulus` date DEFAULT NULL,
  `status` enum('Aktif','Lulus') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `ipk` decimal(4,2) DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `id_prodi`, `id_kurikulum`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `tahun_masuk`, `tahun_lulus`, `tanggal_lulus`, `status`, `ipk`, `foto`, `email`, `nomor_telepon`, `password`) VALUES
('2121400147', '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 'Ahmad Rico Mardiansyah', 'Probolinggo', '2002-01-27', NULL, NULL, NULL, 'Aktif', NULL, NULL, NULL, NULL, '$2y$12$udFTJ./rIwh7uYeRyV8RzOd/7F1gdqYr4ZZFJuyIhJwreVhFlzheC'),
('2121400148', '1319bfef-2188-4240-b7a3-7a507bec2e64', '40', 'Ahmad As\'ad', 'Probolinggo', '2000-10-20', NULL, NULL, NULL, 'Aktif', NULL, NULL, NULL, NULL, '$2y$12$yn8U7leE8Zh4MotvdQlIu.Xki8QXj4CZxXL6S50DYR5sh81Yi1R.e');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_06_01_000001_create_fakultas_table', 1),
(2, '2026_06_01_000002_create_program_studi_table', 1),
(3, '2026_06_01_000003_create_dosen_table', 1),
(4, '2026_06_01_000004_create_kurikulum_table', 1),
(5, '2026_06_01_000005_create_kategori_cpl_table', 1),
(6, '2026_06_01_000006_create_cpl_prodi_table', 1),
(7, '2026_06_01_000007_create_mahasiswa_table', 1),
(8, '2026_06_01_000008_create_tempat_magang_table', 1),
(9, '2026_06_01_000009_create_users_table', 1),
(10, '2026_06_01_000010_create_prestasi_mahasiswa_table', 1),
(11, '2026_06_01_000011_create_organisasi_mahasiswa_table', 1),
(12, '2026_06_01_000012_create_sertifikat_mahasiswa_table', 1),
(13, '2026_06_01_000013_create_magang_mahasiswa_table', 1),
(14, '2026_06_01_000014_create_tugas_akhir_table', 1),
(15, '2026_06_01_000015_create_pembimbing_tugas_akhir_table', 1),
(16, '2026_06_01_000016_create_pengajuan_skpi_table', 1),
(17, '2026_06_01_000017_create_checklist_verifikasi_skpi_table', 1),
(18, '2026_06_01_000018_create_skpi_table', 1),
(19, '2026_06_01_000019_create_approvals_table', 1),
(20, '2026_06_01_000020_create_sistem_penilaian_table', 1),
(21, '2026_06_01_000021_create_notifications_table', 1),
(22, '2026_06_05_100000_add_performance_indexes', 1),
(23, '2026_06_14_035258_drop_old_approval_columns_from_pengajuan_skpi_and_related_tables', 1),
(24, '2026_06_15_000000_make_magang_manual_input', 1),
(25, '2026_06_15_000001_drop_dosen_wali_from_mahasiswa', 1),
(26, '2026_06_15_000002_make_pembimbing_tugas_akhir_manual_input', 1),
(27, '2026_07_04_113606_make_jenjang_nullable_on_program_studi_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organisasi_mahasiswa`
--

CREATE TABLE `organisasi_mahasiswa` (
  `id_organisasi_mhs` int UNSIGNED NOT NULL,
  `nim` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_organisasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` enum('Internasional','Nasional','Universitas','Fakultas') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_mulai` year DEFAULT NULL,
  `tahun_selesai` year DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `file_bukti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` int UNSIGNED DEFAULT NULL COMMENT 'FK users (role: bak_fakultas)',
  `approved_at` datetime DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organisasi_mahasiswa`
--

INSERT INTO `organisasi_mahasiswa` (`id_organisasi_mhs`, `nim`, `nama_organisasi`, `tingkat`, `jabatan`, `tahun_mulai`, `tahun_selesai`, `status`, `file_bukti`, `approved_by`, `approved_at`, `keterangan`, `created_at`) VALUES
(1, '2121400147', 'Himpunan Mahasiswa', 'Fakultas', 'Ketua', 2026, NULL, 'approved', 'bukti_organisasi/0q86hy5YEJZvPyfaZQ7ouFsVjcvxZZIT6myE7v5v.pdf', 4, '2026-07-09 10:09:54', NULL, '2026-07-08 03:39:08');

-- --------------------------------------------------------

--
-- Table structure for table `pembimbing_tugas_akhir`
--

CREATE TABLE `pembimbing_tugas_akhir` (
  `id_pembimbing_ta` int UNSIGNED NOT NULL,
  `id_tugas_akhir` int UNSIGNED NOT NULL,
  `nama_dosen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan_pembimbing` tinyint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembimbing_tugas_akhir`
--

INSERT INTO `pembimbing_tugas_akhir` (`id_pembimbing_ta`, `id_tugas_akhir`, `nama_dosen`, `urutan_pembimbing`) VALUES
(5, 2, 'Ahmad Halimi,M.Kom', 1),
(6, 2, 'Hindun Sholeh, M.Kom', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_skpi`
--

CREATE TABLE `pengajuan_skpi` (
  `id_pengajuan` int UNSIGNED NOT NULL,
  `nim` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tahun_akademik` int UNSIGNED DEFAULT NULL COMMENT 'FK tahun_akademik',
  `tanggal_pengajuan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Tanggal mahasiswa mengajukan SKPI',
  `status` enum('draft','diajukan','verifikasi','dicetak','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `catatan_mahasiswa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Keterangan tambahan dari mahasiswa saat pengajuan',
  `diverifikasi_oleh` int UNSIGNED DEFAULT NULL COMMENT 'FK users (role: bak_fakultas)',
  `tanggal_verifikasi` datetime DEFAULT NULL,
  `catatan_bak` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Catatan hasil verifikasi dari BAK Fakultas',
  `tanggal_disposisi` datetime DEFAULT NULL,
  `permohonan_cetak` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengajuan_skpi`
--

INSERT INTO `pengajuan_skpi` (`id_pengajuan`, `nim`, `id_tahun_akademik`, `tanggal_pengajuan`, `status`, `catatan_mahasiswa`, `diverifikasi_oleh`, `tanggal_verifikasi`, `catatan_bak`, `tanggal_disposisi`, `permohonan_cetak`, `created_at`, `updated_at`) VALUES
(1, '2121400147', 1, '2026-07-09 11:16:44', 'dicetak', NULL, NULL, NULL, NULL, NULL, 0, '2026-07-08 03:39:38', '2026-07-09 04:17:12');

-- --------------------------------------------------------

--
-- Table structure for table `prestasi_mahasiswa`
--

CREATE TABLE `prestasi_mahasiswa` (
  `id_prestasi` int UNSIGNED NOT NULL,
  `nim` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_prestasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` enum('Internasional','Nasional','Provinsi','Lokal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `peringkat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penyelenggara` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` year DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `file_bukti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` int UNSIGNED DEFAULT NULL COMMENT 'FK users (role: bak_fakultas)',
  `approved_at` datetime DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prestasi_mahasiswa`
--

INSERT INTO `prestasi_mahasiswa` (`id_prestasi`, `nim`, `nama_prestasi`, `tingkat`, `peringkat`, `penyelenggara`, `tahun`, `status`, `file_bukti`, `approved_by`, `approved_at`, `keterangan`, `created_at`) VALUES
(1, '2121400147', 'Juara 1 Lomba Mengaji', 'Lokal', 'Juara 1', 'Universitas Nurul Jadid', 2026, 'approved', 'bukti_prestasi/cnHZW5Fqy9rvpxRHYvb8pFR2MCV1foGwNk1d2Ic7.pdf', 4, '2026-07-09 10:00:38', NULL, '2026-07-08 03:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `program_studi`
--

CREATE TABLE `program_studi` (
  `id_prodi` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fakultas` tinyint UNSIGNED NOT NULL,
  `nama_prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_prodi` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenjang` enum('D3','S1','S2','S3') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gelar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sk_akreditasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_sk_akreditasi` date DEFAULT NULL,
  `masa_berlaku_akreditasi` date DEFAULT NULL,
  `jenjang_kkni` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bahasa_pengantar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indonesia',
  `lama_studi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_pendidikan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_pendidikan_lanjutan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persyaratan_penerimaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `alamat_prodi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `telepon_prodi` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_prodi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_studi`
--

INSERT INTO `program_studi` (`id_prodi`, `id_fakultas`, `nama_prodi`, `kode_prodi`, `jenjang`, `gelar`, `sk_akreditasi`, `tanggal_sk_akreditasi`, `masa_berlaku_akreditasi`, `jenjang_kkni`, `bahasa_pengantar`, `lama_studi`, `jenis_pendidikan`, `jenis_pendidikan_lanjutan`, `persyaratan_penerimaan`, `alamat_prodi`, `telepon_prodi`, `email_prodi`, `password`, `status`) VALUES
('003dd606-a40d-4953-ba4c-aa98bf2ff1bb', 4, 'Pendidikan Bahasa Inggris', 'PBI', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('01efb76b-f9b2-4b26-ae06-de90b0daff10', 3, 'Kebidanan', 'KEB', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('07182d28-d2a0-44e8-a731-74bea57161f7', 1, 'Hukum Keluarga (Ahwal Syakhshiyah)', 'HK (AS)', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('0dfc4a93-87e0-414e-809c-10c380ebe3af', 5, 'Pendidikan Agama Islam (S2)', 'PAI-S2', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('0f6bb17f-efdd-493c-8939-30c215bd9fb1', 2, 'Teknik Elektro', 'TE', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('1319bfef-2188-4240-b7a3-7a507bec2e64', 2, 'Teknik Informatika', 'IF', 'S1', 'S.Kom', '1234/SK/BAN-PT/Ak/S/VII/2025', '2026-07-09', '2030-07-09', 'Level 6', 'Indonesia', '8 Semester (4 Tahun)', 'Akademik', 'Magister Informatika (S2), Magister Ilmu Komputer (M.Kom.)', 'Lulusan SMA/SMK/MA sederajat, lulus seleksi administrasi dan tes masuk Universitas Nurul Jadid', NULL, NULL, NULL, NULL, 'active'),
('2e564765-2859-4dd5-ad2a-74264481767f', 5, 'Studi Islam (S3)', 'SI-S3', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('33c03a4c-855d-4fac-880a-3872f14a23b7', 5, 'Manajemen Pendidikan Islam (S2)', 'MPI-S2', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('361d0099-39ba-41d3-b8d8-e4093fa8781b', 1, 'Manajemen Pendidikan Islam (S1)', 'MPI', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('3a987a0a-9336-4aee-986a-298e2e2a1470', 1, 'Pendidikan Agama Islam (S1)', 'PAI', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('423716ff-d094-41ef-99e6-02cbd05c72d1', 3, 'Pendidikan Profesi Ners', 'NERS', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('6bb7c485-08a3-465c-b549-e5223c2affe2', 2, 'Teknologi Informasi', 'TI', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('6dc3cb7a-fc03-4c1a-a66f-faa4de36d6e8', 2, 'Teknik Industri Pertanian', 'TIP', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('7fc4e88b-872b-4a3d-b022-25eacb6a5d82', 3, 'Ilmu Keperawatan', 'KEP', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('81cba784-728f-40e6-8fc4-5629cd83e742', 4, 'Ekonomi', 'EKN', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('9155f632-5e5a-4b21-a44e-20b43d9f08da', 1, 'Perbankan Syariah', 'PS', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('9207a610-30ea-46f1-9a27-0ccf429cddaf', 4, 'Pendidikan Matematika', 'MAT', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('95f0ed5a-0fb9-4c9d-898c-d2b4b313850d', 1, 'Ekonomi Syari\'ah', 'ES', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('af4cfc27-cd33-4b79-b637-bdc2c090dd76', 1, 'Pendidikan Bahasa Arab', 'PBA', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('bef4580c-48da-4537-aeb7-9ab3d69b9dc6', 1, 'Komunikasi dan Penyiaran Islam', 'KPI', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('c7f21e09-b3fb-4b58-86fd-4e8db797a73e', 1, 'Pendidikan Guru Madrasah Ibtidaiyah', 'PGMI', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('dd735a4f-7a0f-4e8a-b8d6-42fb82768567', 5, 'Studi Islam (S2)', 'SI-S2', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('ec1fe213-c51d-4c40-b60e-adbf44decda7', 1, 'Ilmu Alqur\'an dan Tafsir', 'IAT', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('f208b4c5-39ce-46bf-a2a6-488ce6ec69ac', 4, 'Hukum', 'HK', NULL, NULL, NULL, NULL, NULL, NULL, 'Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `sertifikat_mahasiswa`
--

CREATE TABLE `sertifikat_mahasiswa` (
  `id_sertifikat` int UNSIGNED NOT NULL,
  `nim` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_sertifikat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_sertifikat` enum('Keagamaan','Teknis','Bahasa','Profesional') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penyelenggara` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_terbit` date DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `file_bukti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` int UNSIGNED DEFAULT NULL COMMENT 'FK users (role: bak_fakultas)',
  `approved_at` datetime DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sertifikat_mahasiswa`
--

INSERT INTO `sertifikat_mahasiswa` (`id_sertifikat`, `nim`, `nama_sertifikat`, `jenis_sertifikat`, `bidang`, `penyelenggara`, `tanggal_terbit`, `status`, `file_bukti`, `approved_by`, `approved_at`, `keterangan`, `created_at`) VALUES
(1, '2121400147', 'Furudul Ainiyah', 'Keagamaan', 'Keagamaan', 'Universitas Nurul Jadid', '2026-07-08', 'approved', 'bukti_sertifikat/xSxYu2h8QNtK5FPImJzf0iS4kASKHGhbxyFCrppX.pdf', 4, '2026-07-09 10:10:11', NULL, '2026-07-08 03:38:37');

-- --------------------------------------------------------

--
-- Table structure for table `sistem_penilaian`
--

CREATE TABLE `sistem_penilaian` (
  `id_penilaian` smallint UNSIGNED NOT NULL,
  `nilai_huruf` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_min` decimal(5,2) DEFAULT NULL,
  `nilai_max` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sistem_penilaian`
--

INSERT INTO `sistem_penilaian` (`id_penilaian`, `nilai_huruf`, `nilai_min`, `nilai_max`) VALUES
(5, 'D', '70.00', '75.00'),
(6, 'C', '75.00', '80.00'),
(7, 'B', '80.00', '85.00'),
(8, 'A', '85.00', '100.00');

-- --------------------------------------------------------

--
-- Table structure for table `skpi`
--

CREATE TABLE `skpi` (
  `id_skpi` int UNSIGNED NOT NULL,
  `nomor_skpi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pengajuan` int UNSIGNED DEFAULT NULL COMMENT 'Relasi ke tabel pengajuan_skpi',
  `nim_ijazah` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_terbit` date NOT NULL COMMENT 'Tanggal SKPI diterbitkan oleh BAAK Fakultas',
  `dicetak_oleh` int UNSIGNED DEFAULT NULL COMMENT 'FK users (role: bak_fakultas)',
  `status_profesi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal_ttd_dekan` date DEFAULT NULL COMMENT 'Tanggal ditandatangani oleh Dekan',
  `ditandatangani_oleh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nama Dekan saat TTD (historis, bisa berbeda dari data fakultas)',
  `niy_penandatangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'NIY/NIDN Dekan saat TTD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skpi`
--

INSERT INTO `skpi` (`id_skpi`, `nomor_skpi`, `nim`, `id_pengajuan`, `nim_ijazah`, `tanggal_terbit`, `dicetak_oleh`, `status_profesi`, `tanggal_ttd_dekan`, `ditandatangani_oleh`, `niy_penandatangan`) VALUES
(5, 'NJ-T06/02/0001/SKPI/07.2026', '2121400147', 1, '2121400147', '2026-07-09', 4, 'Belum ada keanggotaan profesi', '2026-07-09', 'ZAINAL ARIFIN, M.Kom.', '0730038602');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_akademik`
--

CREATE TABLE `tahun_akademik` (
  `id_tahun_akademik` int UNSIGNED NOT NULL,
  `nama` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Contoh: 2025/2026 Ganjil',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tahun_akademik`
--

INSERT INTO `tahun_akademik` (`id_tahun_akademik`, `nama`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2025/2026 Genap', 1, '2026-07-08 00:00:00', '2026-07-08 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_akhir`
--

CREATE TABLE `tugas_akhir` (
  `id_tugas_akhir` int UNSIGNED NOT NULL,
  `nim` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_by` int UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tugas_akhir`
--

INSERT INTO `tugas_akhir` (`id_tugas_akhir`, `nim`, `judul`, `status`, `approved_by`, `approved_at`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, '2121400147', 'Sistem Informasi Janda Muda Jawa Timur', 'approved', 4, '2026-07-09 10:10:16', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int UNSIGNED NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','bak_fakultas') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_prodi` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Diisi untuk role bak_fakultas dan kaprodi',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `nama_lengkap`, `role`, `id_prodi`, `email`, `password`, `aktif`, `created_at`) VALUES
(1, 'admin', 'Administrator Utama', 'admin', NULL, 'admin@system.ac.id', '$2y$12$WCJEFVGLXjESgpkLJzr1yOtocQAskaEsvaIly3HotVh9skY8JfkeC', 1, '2026-06-15 15:16:07'),
(4, 'bak_ft', 'Layanan Akademik FT', 'bak_fakultas', '0f6bb17f-efdd-493c-8939-30c215bd9fb1', 'ftresearch@unuja.ac.id', '$2y$12$Af19s70/t5NhlX6jcH7vPuO5gPg1Y5jnuoj0d4ZmXv5RD8LkWdK0G', 1, '2026-06-30 03:55:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`id_approval`),
  ADD KEY `idx_approvals_approvable` (`approvable_type`,`approvable_id`),
  ADD KEY `idx_approvals_role` (`role`),
  ADD KEY `idx_approvals_user` (`user_id`);

--
-- Indexes for table `checklist_verifikasi_skpi`
--
ALTER TABLE `checklist_verifikasi_skpi`
  ADD PRIMARY KEY (`id_checklist`),
  ADD UNIQUE KEY `uq_checklist_pengajuan` (`id_pengajuan`),
  ADD KEY `idx_checklist_verifikasi_oleh` (`diverifikasi_oleh`);

--
-- Indexes for table `cpl_prodi`
--
ALTER TABLE `cpl_prodi`
  ADD PRIMARY KEY (`id_cpl`),
  ADD UNIQUE KEY `uq_cpl_prodi_kode` (`id_prodi`,`id_kurikulum`,`kode_cpl`),
  ADD KEY `idx_cpl_prodi` (`id_prodi`),
  ADD KEY `idx_cpl_kategori` (`id_kategori`),
  ADD KEY `idx_cpl_kurikulum` (`id_kurikulum`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id_fakultas`),
  ADD KEY `idx_fakultas_kode` (`kode_fakultas`);

--
-- Indexes for table `kategori_cpl`
--
ALTER TABLE `kategori_cpl`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `uq_kategori_kode` (`kode_kategori`);

--
-- Indexes for table `kurikulum`
--
ALTER TABLE `kurikulum`
  ADD PRIMARY KEY (`id_kurikulum`),
  ADD KEY `idx_kurikulum_prodi` (`id_prodi`);

--
-- Indexes for table `magang_mahasiswa`
--
ALTER TABLE `magang_mahasiswa`
  ADD PRIMARY KEY (`id_magang`),
  ADD KEY `idx_magang_mahasiswa` (`nim`),
  ADD KEY `idx_magang_status` (`status`),
  ADD KEY `idx_magang_approved_by` (`approved_by`),
  ADD KEY `idx_magang_mhs_status` (`nim`,`status`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`),
  ADD KEY `idx_mahasiswa_prodi` (`id_prodi`),
  ADD KEY `idx_mahasiswa_kurikulum` (`id_kurikulum`),
  ADD KEY `idx_mahasiswa_status` (`status`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `organisasi_mahasiswa`
--
ALTER TABLE `organisasi_mahasiswa`
  ADD PRIMARY KEY (`id_organisasi_mhs`),
  ADD KEY `idx_organisasi_mahasiswa` (`nim`),
  ADD KEY `idx_organisasi_status` (`status`),
  ADD KEY `idx_organisasi_approved_by` (`approved_by`),
  ADD KEY `idx_organisasi_mhs_status` (`nim`,`status`);

--
-- Indexes for table `pembimbing_tugas_akhir`
--
ALTER TABLE `pembimbing_tugas_akhir`
  ADD PRIMARY KEY (`id_pembimbing_ta`),
  ADD UNIQUE KEY `uq_pembimbing_ta_urutan` (`id_tugas_akhir`,`urutan_pembimbing`),
  ADD KEY `idx_pembimbing_ta` (`id_tugas_akhir`);

--
-- Indexes for table `pengajuan_skpi`
--
ALTER TABLE `pengajuan_skpi`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `idx_pengajuan_mahasiswa` (`nim`),
  ADD KEY `idx_pengajuan_status` (`status`),
  ADD KEY `idx_pengajuan_verifikasi_oleh` (`diverifikasi_oleh`),
  ADD KEY `idx_pengajuan_mhs_status` (`nim`,`status`),
  ADD KEY `idx_pengajuan_permohonan` (`permohonan_cetak`,`status`),
  ADD KEY `idx_pengajuan_tahun_akademik` (`id_tahun_akademik`);

--
-- Indexes for table `prestasi_mahasiswa`
--
ALTER TABLE `prestasi_mahasiswa`
  ADD PRIMARY KEY (`id_prestasi`),
  ADD KEY `idx_prestasi_mahasiswa` (`nim`),
  ADD KEY `idx_prestasi_status` (`status`),
  ADD KEY `idx_prestasi_approved_by` (`approved_by`),
  ADD KEY `idx_prestasi_mhs_status` (`nim`,`status`);

--
-- Indexes for table `program_studi`
--
ALTER TABLE `program_studi`
  ADD PRIMARY KEY (`id_prodi`),
  ADD KEY `idx_prodi_fakultas` (`id_fakultas`);

--
-- Indexes for table `sertifikat_mahasiswa`
--
ALTER TABLE `sertifikat_mahasiswa`
  ADD PRIMARY KEY (`id_sertifikat`),
  ADD KEY `idx_sertifikat_mahasiswa` (`nim`),
  ADD KEY `idx_sertifikat_status` (`status`),
  ADD KEY `idx_sertifikat_approved_by` (`approved_by`),
  ADD KEY `idx_sertifikat_mhs_status` (`nim`,`status`);

--
-- Indexes for table `sistem_penilaian`
--
ALTER TABLE `sistem_penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD UNIQUE KEY `uq_penilaian_nilai_huruf` (`nilai_huruf`);

--
-- Indexes for table `skpi`
--
ALTER TABLE `skpi`
  ADD PRIMARY KEY (`id_skpi`),
  ADD UNIQUE KEY `uq_skpi_nomor` (`nomor_skpi`),
  ADD UNIQUE KEY `uq_skpi_mahasiswa` (`nim`),
  ADD KEY `idx_skpi_pengajuan` (`id_pengajuan`),
  ADD KEY `idx_skpi_dicetak_oleh` (`dicetak_oleh`);

--
-- Indexes for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  ADD PRIMARY KEY (`id_tahun_akademik`),
  ADD KEY `idx_tahun_akademik_active` (`is_active`);

--
-- Indexes for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  ADD PRIMARY KEY (`id_tugas_akhir`),
  ADD UNIQUE KEY `uq_ta_mahasiswa` (`nim`),
  ADD KEY `fk_ta_approved_by` (`approved_by`),
  ADD KEY `idx_ta_mhs_status` (`nim`,`status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `uq_users_username` (`username`),
  ADD UNIQUE KEY `uq_users_email` (`email`),
  ADD KEY `idx_users_prodi` (`id_prodi`),
  ADD KEY `idx_users_role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `id_approval` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `checklist_verifikasi_skpi`
--
ALTER TABLE `checklist_verifikasi_skpi`
  MODIFY `id_checklist` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cpl_prodi`
--
ALTER TABLE `cpl_prodi`
  MODIFY `id_cpl` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id_fakultas` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori_cpl`
--
ALTER TABLE `kategori_cpl`
  MODIFY `id_kategori` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `magang_mahasiswa`
--
ALTER TABLE `magang_mahasiswa`
  MODIFY `id_magang` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `organisasi_mahasiswa`
--
ALTER TABLE `organisasi_mahasiswa`
  MODIFY `id_organisasi_mhs` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembimbing_tugas_akhir`
--
ALTER TABLE `pembimbing_tugas_akhir`
  MODIFY `id_pembimbing_ta` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengajuan_skpi`
--
ALTER TABLE `pengajuan_skpi`
  MODIFY `id_pengajuan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prestasi_mahasiswa`
--
ALTER TABLE `prestasi_mahasiswa`
  MODIFY `id_prestasi` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sertifikat_mahasiswa`
--
ALTER TABLE `sertifikat_mahasiswa`
  MODIFY `id_sertifikat` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sistem_penilaian`
--
ALTER TABLE `sistem_penilaian`
  MODIFY `id_penilaian` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `skpi`
--
ALTER TABLE `skpi`
  MODIFY `id_skpi` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  MODIFY `id_tahun_akademik` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  MODIFY `id_tugas_akhir` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approvals`
--
ALTER TABLE `approvals`
  ADD CONSTRAINT `fk_approvals_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `checklist_verifikasi_skpi`
--
ALTER TABLE `checklist_verifikasi_skpi`
  ADD CONSTRAINT `fk_checklist_pengajuan` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_skpi` (`id_pengajuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_checklist_verifikasi_oleh` FOREIGN KEY (`diverifikasi_oleh`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

--
-- Constraints for table `cpl_prodi`
--
ALTER TABLE `cpl_prodi`
  ADD CONSTRAINT `fk_cpl_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_cpl` (`id_kategori`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cpl_kurikulum` FOREIGN KEY (`id_kurikulum`) REFERENCES `kurikulum` (`id_kurikulum`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cpl_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `program_studi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kurikulum`
--
ALTER TABLE `kurikulum`
  ADD CONSTRAINT `fk_kurikulum_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `program_studi` (`id_prodi`) ON UPDATE CASCADE;

--
-- Constraints for table `magang_mahasiswa`
--
ALTER TABLE `magang_mahasiswa`
  ADD CONSTRAINT `fk_magang_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_magang_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `fk_mahasiswa_kurikulum` FOREIGN KEY (`id_kurikulum`) REFERENCES `kurikulum` (`id_kurikulum`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mahasiswa_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `program_studi` (`id_prodi`) ON UPDATE CASCADE;

--
-- Constraints for table `organisasi_mahasiswa`
--
ALTER TABLE `organisasi_mahasiswa`
  ADD CONSTRAINT `fk_organisasi_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_organisasi_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembimbing_tugas_akhir`
--
ALTER TABLE `pembimbing_tugas_akhir`
  ADD CONSTRAINT `fk_pembimbing_ta` FOREIGN KEY (`id_tugas_akhir`) REFERENCES `tugas_akhir` (`id_tugas_akhir`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengajuan_skpi`
--
ALTER TABLE `pengajuan_skpi`
  ADD CONSTRAINT `fk_pengajuan_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengajuan_tahun_akademik` FOREIGN KEY (`id_tahun_akademik`) REFERENCES `tahun_akademik` (`id_tahun_akademik`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengajuan_verifikasi_oleh` FOREIGN KEY (`diverifikasi_oleh`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `prestasi_mahasiswa`
--
ALTER TABLE `prestasi_mahasiswa`
  ADD CONSTRAINT `fk_prestasi_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prestasi_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `program_studi`
--
ALTER TABLE `program_studi`
  ADD CONSTRAINT `fk_prodi_fakultas` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id_fakultas`) ON UPDATE CASCADE;

--
-- Constraints for table `sertifikat_mahasiswa`
--
ALTER TABLE `sertifikat_mahasiswa`
  ADD CONSTRAINT `fk_sertifikat_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sertifikat_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `skpi`
--
ALTER TABLE `skpi`
  ADD CONSTRAINT `fk_skpi_dicetak_oleh` FOREIGN KEY (`dicetak_oleh`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_skpi_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_skpi_pengajuan` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_skpi` (`id_pengajuan`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  ADD CONSTRAINT `fk_ta_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ta_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `program_studi` (`id_prodi`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
