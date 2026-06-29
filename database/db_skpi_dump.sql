-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: db_skpi
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `fakultas`
--

DROP TABLE IF EXISTS `fakultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fakultas` (
  `id_fakultas` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `nama_fakultas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_fakultas` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dekan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nidn_dekan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id_fakultas`),
  KEY `idx_fakultas_kode` (`kode_fakultas`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fakultas`
--

LOCK TABLES `fakultas` WRITE;
/*!40000 ALTER TABLE `fakultas` DISABLE KEYS */;
INSERT INTO `fakultas` VALUES (1,'Fakultas Teknologi Informasi','FTI','Dr. Andi Wijaya, M.T.','0401017801','active'),(2,'Fakultas Teknik','FT','Prof. Dr. Ir. Budi Santoso, M.T.','0402037002','active'),(3,'Fakultas Ekonomi dan Bisnis','FEB','Dra. Sri Wahyuni, M.Si.','0412057503','active');
/*!40000 ALTER TABLE `fakultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_studi`
--

DROP TABLE IF EXISTS `program_studi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_studi` (
  `id_prodi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fakultas` tinyint unsigned NOT NULL,
  `nama_prodi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_prodi` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenjang` enum('D3','S1','S2','S3') COLLATE utf8mb4_unicode_ci NOT NULL,
  `gelar` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sk_akreditasi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_sk_akreditasi` date DEFAULT NULL,
  `masa_berlaku_akreditasi` date DEFAULT NULL,
  `jenjang_kkni` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bahasa_pengantar` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indonesia',
  `lama_studi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_pendidikan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_pendidikan_lanjutan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persyaratan_penerimaan` text COLLATE utf8mb4_unicode_ci,
  `alamat_prodi` text COLLATE utf8mb4_unicode_ci,
  `telepon_prodi` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_prodi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id_prodi`),
  KEY `idx_prodi_fakultas` (`id_fakultas`),
  CONSTRAINT `fk_prodi_fakultas` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id_fakultas`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_studi`
--

LOCK TABLES `program_studi` WRITE;
/*!40000 ALTER TABLE `program_studi` DISABLE KEYS */;
INSERT INTO `program_studi` VALUES ('MAN',3,'Manajemen','MN','S1','S.E.','126/SK/BAN-PT/2023','2023-08-25','2028-08-25','Level 6','Indonesia','8 Semester','Akademik','Program Magister (S2)','Lulusan SMA/SMK/MA sederajat semua jurusan','Gedung D Kampus 2, Jl. Pendidikan No. 5','021-7654322','manajemen@univ.ac.id',NULL,'active'),('SI',1,'Sistem Informasi','SI','S1','S.Kom.','124/SK/BAN-PT/2023','2023-06-15','2028-06-15','Level 6','Indonesia','8 Semester','Akademik','Program Magister (S2)','Lulusan SMA/SMK/MA sederajat semua jurusan','Gedung B Kampus 1, Jl. Raya Utama No. 10','021-1234568','si@univ.ac.id',NULL,'active'),('TIF',1,'Teknik Informatika','IF','S1','S.Kom.','123/SK/BAN-PT/2023','2023-05-10','2028-05-10','Level 6','Indonesia','8 Semester','Akademik','Program Magister (S2)','Lulusan SMA/SMK/MA sederajat jurusan IPA/Teknik','Gedung A Kampus 1, Jl. Raya Utama No. 10','021-1234567','informatika@univ.ac.id',NULL,'active'),('TS',2,'Teknik Sipil','TS','S1','S.T.','125/SK/BAN-PT/2023','2023-07-20','2028-07-20','Level 6','Indonesia','8 Semester','Akademik','Program Magister (S2)','Lulusan SMA/SMK/MA sederajat jurusan IPA/Teknik','Gedung C Kampus 2, Jl. Pendidikan No. 5','021-7654321','sipil@univ.ac.id',NULL,'active');
/*!40000 ALTER TABLE `program_studi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kurikulum`
--

DROP TABLE IF EXISTS `kurikulum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kurikulum` (
  `id_kurikulum` smallint unsigned NOT NULL AUTO_INCREMENT,
  `id_prodi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kurikulum` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kurikulum`),
  KEY `idx_kurikulum_prodi` (`id_prodi`),
  CONSTRAINT `fk_kurikulum_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `program_studi` (`id_prodi`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kurikulum`
--

LOCK TABLES `kurikulum` WRITE;
/*!40000 ALTER TABLE `kurikulum` DISABLE KEYS */;
INSERT INTO `kurikulum` VALUES (1,'TIF','Kurikulum MBKM TIF 2024',2024,NULL,NULL),(2,'SI','Kurikulum MBKM SI 2024',2024,NULL,NULL),(3,'TS','Kurikulum MBKM TS 2024',2024,NULL,NULL),(4,'MAN','Kurikulum MBKM MAN 2024',2024,NULL,NULL);
/*!40000 ALTER TABLE `kurikulum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_cpl`
--

DROP TABLE IF EXISTS `kategori_cpl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori_cpl` (
  `id_kategori` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `kode_kategori` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` tinyint unsigned DEFAULT NULL,
  PRIMARY KEY (`id_kategori`),
  UNIQUE KEY `uq_kategori_kode` (`kode_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_cpl`
--

LOCK TABLES `kategori_cpl` WRITE;
/*!40000 ALTER TABLE `kategori_cpl` DISABLE KEYS */;
INSERT INTO `kategori_cpl` VALUES (1,'S','Sikap',1),(2,'KU','Keterampilan Umum',2),(3,'KK','Keterampilan Khusus',3),(4,'P','Pengetahuan',4);
/*!40000 ALTER TABLE `kategori_cpl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cpl_prodi`
--

DROP TABLE IF EXISTS `cpl_prodi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cpl_prodi` (
  `id_cpl` int unsigned NOT NULL AUTO_INCREMENT,
  `id_prodi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kurikulum` smallint unsigned NOT NULL,
  `id_kategori` tinyint unsigned NOT NULL,
  `kode_cpl` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_cpl` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` smallint unsigned DEFAULT NULL,
  PRIMARY KEY (`id_cpl`),
  UNIQUE KEY `uq_cpl_prodi_kode` (`id_prodi`,`id_kurikulum`,`kode_cpl`),
  KEY `idx_cpl_prodi` (`id_prodi`),
  KEY `idx_cpl_kategori` (`id_kategori`),
  KEY `idx_cpl_kurikulum` (`id_kurikulum`),
  CONSTRAINT `fk_cpl_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_cpl` (`id_kategori`) ON UPDATE CASCADE,
  CONSTRAINT `fk_cpl_kurikulum` FOREIGN KEY (`id_kurikulum`) REFERENCES `kurikulum` (`id_kurikulum`) ON UPDATE CASCADE,
  CONSTRAINT `fk_cpl_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `program_studi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cpl_prodi`
--

LOCK TABLES `cpl_prodi` WRITE;
/*!40000 ALTER TABLE `cpl_prodi` DISABLE KEYS */;
INSERT INTO `cpl_prodi` VALUES (1,'TIF',1,1,'S1','Bertaqwa kepada Tuhan Yang Maha Esa dan mampu menunjukkan sikap religius.',1),(2,'TIF',1,1,'S2','Menjunjung tinggi nilai kemanusiaan dalam menjalankan tugas berdasarkan agama, moral, dan etika.',2),(3,'TIF',1,2,'KU1','Mampu menerapkan pemikiran logis, kritis, sistematis, dan inovatif dalam konteks pengembangan atau implementasi ilmu pengetahuan dan teknologi.',1),(4,'TIF',1,3,'KK1','Mampu merancang dan mengimplementasikan arsitektur sistem komputer, jaringan komputer, dan algoritma kompleks.',1),(5,'TIF',1,3,'KK2','Mampu mengembangkan perangkat lunak berbasis web, mobile, dan desktop menggunakan praktik rekayasa perangkat lunak modern.',2),(6,'TIF',1,4,'P1','Menguasai konsep teoritis ilmu komputer, termasuk struktur data, algoritma, basis data, dan pemrograman.',1),(7,'SI',2,1,'S1','Bertaqwa kepada Tuhan Yang Maha Esa dan mampu menunjukkan sikap religius.',1),(8,'SI',2,2,'KU1','Mampu menerapkan pemikiran logis, kritis, sistematis, dan inovatif dalam konteks pengembangan atau implementasi ilmu pengetahuan dan teknologi.',1),(9,'SI',2,3,'KK1','Mampu menganalisis, merancang, dan mengimplementasikan sistem informasi enterprise yang mendukung strategi bisnis organisasi.',1),(10,'SI',2,4,'P1','Menguasai prinsip integrasi sistem, manajemen proyek TI, dan analisis proses bisnis.',1);
/*!40000 ALTER TABLE `cpl_prodi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_prodi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kurikulum` smallint unsigned NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `tahun_masuk` year DEFAULT NULL,
  `tahun_lulus` year DEFAULT NULL,
  `tanggal_lulus` date DEFAULT NULL,
  `status` enum('Aktif','Lulus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `ipk` decimal(4,2) DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_mahasiswa`),
  UNIQUE KEY `uq_mahasiswa_nim` (`nim`),
  KEY `idx_mahasiswa_prodi` (`id_prodi`),
  KEY `idx_mahasiswa_kurikulum` (`id_kurikulum`),
  KEY `idx_mahasiswa_status` (`status`),
  CONSTRAINT `fk_mahasiswa_kurikulum` FOREIGN KEY (`id_kurikulum`) REFERENCES `kurikulum` (`id_kurikulum`) ON UPDATE CASCADE,
  CONSTRAINT `fk_mahasiswa_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `program_studi` (`id_prodi`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa`
--

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` VALUES (1,'230101001','TIF',1,'Budi Raharjo','Semarang','2004-05-12',2023,NULL,NULL,'Aktif',3.85,NULL,'budi@student.ac.id','081234567890','$2y$12$x08usmLZaxPHkl1ZGSTMs.mBx/MvzmAMMrJotuK0MXP9hkwnvjcHm'),(2,'220101002','TIF',1,'Siti Aminah','Surabaya','2003-08-24',2022,NULL,NULL,'Aktif',3.92,NULL,'siti@student.ac.id','081234567891','$2y$12$BUAk60C91jrqOq9AE6tiP.GXcrqXZL/avvk1ZLi68oY73TRmQTORC'),(3,'230202001','SI',2,'Doni Pratama','Jakarta','2004-11-02',2023,NULL,NULL,'Aktif',3.70,NULL,'doni@student.ac.id','081234567892','$2y$12$cvKc5tLnXsvadIy0RI95G.9/HamAcgrVe26Hhi.2It.mJGU9Pq/fq'),(4,'200202099','SI',2,'Riska Amalia','Bandung','2002-02-15',2020,2024,'2024-03-20','Lulus',3.78,NULL,'riska@student.ac.id','081234567893','$2y$12$3It.4xWZtqzh.3iJuhsImuXg2zSkQBxF3ieMuS9YD1vsK/zlM31y2');
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_user` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','bak_fakultas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_prodi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Diisi untuk role bak_fakultas dan kaprodi',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `uq_users_username` (`username`),
  UNIQUE KEY `uq_users_email` (`email`),
  KEY `idx_users_prodi` (`id_prodi`),
  KEY `idx_users_role` (`role`),
  CONSTRAINT `fk_users_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `program_studi` (`id_prodi`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','Administrator Utama','admin',NULL,'admin@system.ac.id','$2y$12$WCJEFVGLXjESgpkLJzr1yOtocQAskaEsvaIly3HotVh9skY8JfkeC',1,'2026-06-15 15:16:07'),(2,'bak_fti','Layanan Akademik FTI','bak_fakultas','TIF','bak.fti@system.ac.id','$2y$12$4NIrBKiD2rICPDF3oT7Soevw/rrIaXkZR/4Bm3eiGnqDPpLFwB3fK',1,'2026-06-15 15:16:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-15 22:18:07
