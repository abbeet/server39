-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2013 at 08:11 AM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sitpdik`
--
CREATE DATABASE IF NOT EXISTS `sitpdik` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `sitpdik`;

-- --------------------------------------------------------

--
-- Table structure for table `kawasan`
--

CREATE TABLE IF NOT EXISTS `kawasan` (
  `kode` varchar(1) COLLATE latin1_general_ci NOT NULL,
  `nama` varchar(20) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `kawasan`
--

INSERT INTO `kawasan` (`kode`, `nama`) VALUES
('1', 'Kantor Pusat'),
('2', 'Pasar Jumat'),
('3', 'Serpong'),
('4', 'Bandung'),
('5', 'Yogyakarta');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `kode` varchar(4) COLLATE latin1_general_ci NOT NULL,
  `nama` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `singkatan` varchar(14) COLLATE latin1_general_ci NOT NULL,
  `satker` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `kawasan` varchar(1) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`kode`),
  KEY `kode_kawasan` (`kawasan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`kode`, `nama`, `singkatan`, `satker`, `kawasan`) VALUES
('0000', 'Badan Tenaga Nuklir Nasional', 'BATAN', '', NULL),
('0100', 'Sekretariat Utama', 'SEKUT', '', NULL),
('0200', 'Deputi Kepala Bidang Penelitian Dasar dan Terapan', 'PDT', '', NULL),
('0300', 'Deputi Kepala Bidang Pengembangan Teknologi dan Energi Nuklir', 'PTEN', '', NULL),
('0400', 'Deputi Kepala Bidang Pengembangan Teknologi Daur Bahan Nuklir dan Rekayasa', 'PTDBR', '', NULL),
('0500', 'Deputi Kepala Bidang Pendayagunaan Hasil Litbang & Pemasyarakatan Ilmu Pengetahuan dan Teknologi Nuklir', 'PHLPN', '', NULL),
('0600', 'Inspektorat', 'INSPEKTORAT', '', NULL),
('0700', 'Pusat Standardisasi dan Jaminan Mutu Nuklir', 'PSJMN', '', NULL),
('0800', 'Pusat Pendidikan dan Pelatihan', 'PUSDIKLAT', '', NULL),
('0900', 'Sekolah Tinggi Teknologi Nuklir', 'STTN', '', NULL),
('1100', 'Biro Perencanaan', 'BP', '017279', '1'),
('1110', 'Bagian Perencanaan Program', '', '', NULL),
('1111', 'Subbagian Program Litbangyasa', '', '', NULL),
('1112', 'Subbagian Program Diseminasi', '', '', NULL),
('1113', 'Subbagian Program Manajemen Kelembagaan', '', '', NULL),
('1114', 'Subbagian Tata Usaha', '', '', NULL),
('1120', 'Bagian Penyusunan Anggaran', '', '', NULL),
('1121', 'Subbagian Anggaran Litbangyasa', '', '', NULL),
('1122', 'Subbagian Anggaran Diseminasi', '', '', NULL),
('1123', 'Subbagian Anggaran Manajemen Kelembagaan', '', '', NULL),
('1130', 'Bagian Evaluasi Program', '', '', NULL),
('1131', 'Subbagian Evaluasi Program Litbangyasa', '', '', NULL),
('1132', 'Subbagian Evaluasi Program Diseminasi', '', '', NULL),
('1133', 'Subbagian Evaluasi Program Manajemen Kelembagaan', '', '', NULL),
('1134', 'Subbagian Dokumentasi', '', '', NULL),
('1200', 'Biro Sumber Daya Manusia', 'BSDM', '017279', '1'),
('1210', 'Bagian Perencanaan dan Pengembangan SDM', '', '', NULL),
('1211', 'Subbagian Perencanaan Sumber Daya Manusia', '', '', NULL),
('1212', 'Subbagian Pengembangan Sumber Daya Manusia', '', '', NULL),
('1213', 'Subbagian Data Sumber Daya Manusia', '', '', NULL),
('1220', 'Bagian Mutasi Kepegawaian', '', '', NULL),
('1221', 'Subbagian Mutasi Pegawai I', '', '', NULL),
('1222', 'Subbagian Mutasi Pegawai II', '', '', NULL),
('1223', 'Subbagian Mutasi Jabatan Fungsional I', '', '', NULL),
('1224', 'Subbagian Mutasi Jabatan Fungsional II', '', '', NULL),
('1230', 'Bagian Umum Kepegawaian', '', '', NULL),
('1231', 'Subbagian Tata Persuratan', '', '', NULL),
('1232', 'Subbagian Arsip dan Dokumentasi', '', '', NULL),
('1233', 'Subbagian Kesejahteraan Pegawai', '', '', NULL),
('1234', 'Subbagian Tata Usaha', '', '', NULL),
('1240', 'Bagian Organisasi dan Ketatalaksanaan', '', '', NULL),
('1241', 'Subbagian Organisasi', '', '', NULL),
('1242', 'Subbagian Ketatalaksanaan', '', '', NULL),
('1243', 'Subbagian Pelayanan Kesehatan', '', '', NULL),
('1300', 'Biro Umum', 'BU', '017279', '1'),
('1310', 'Bagian Perlengkapan', '', '', NULL),
('1311', 'Subbagian Pengadaan Sarana', '', '', NULL),
('1312', 'Subbagian Inventarisasi', '', '', NULL),
('1313', 'Subbagian Tata Usaha', '', '', NULL),
('1320', 'Bagian Rumah Tangga', '', '', NULL),
('1321', 'Subbagian Kendaraan', '', '', NULL),
('1322', 'Subbagian Bangunan dan Urusan Dalam', '', '', NULL),
('1323', 'Subbagian Peralatan', '', '', NULL),
('1330', 'Bagian Keuangan', '', '', NULL),
('1331', 'Subbagian Perbendaharaan', '', '', NULL),
('1332', 'Subbagian Penerimaan Negara Bukan Pajak', '', '', NULL),
('1340', 'Bagian Akuntansi dan Pelaporan Keuangan', '', '', NULL),
('1341', 'Subbagian Akuntansi', '', '', NULL),
('1342', 'Subbagian Pelaporan', '', '', NULL),
('1343', 'Subbagian Verifikasi Penerimaan Negara Bukan Pajak', '', '', NULL),
('1350', 'Bagian Pengamanan', '', '', NULL),
('1351', 'Subbagian Pengamanan Instalasi Nuklir', '', '', NULL),
('1352', 'Subbagian Pengamanan Dalam', '', '', NULL),
('1400', 'Biro Kerja Sama Hukum dan Hubungan Masyarakat', 'BKHH', '017279', '1'),
('1410', 'Bagian Perjanjian', '', '', NULL),
('1411', 'Subbagian Perjanjian Dalam Negeri', '', '', NULL),
('1412', 'Subbagian Perjanjian Luar Negeri', '', '', NULL),
('1413', 'Subbagian Tata Usaha', '', '', NULL),
('1420', 'Bagian Pengelolaan Bantuan Teknis', '', '', NULL),
('1421', 'Subbagian Pengelolaan Bantuan Teknis Bilateral dan Regional', '', '', NULL),
('1422', 'Subbagian Pengelolaan Bantuan Teknis Multilateral', '', '', NULL),
('1430', 'Bagian Hukum', '', '', NULL),
('1431', 'Subbagian Penelaahan dan Dokumentasi Hukum', '', '', NULL),
('1432', 'Subbagian Bantuan dan Penyuluhan Hukum', '', '', NULL),
('1440', 'Bagian Hubungan Masyarakat', '', '', NULL),
('1441', 'Subbagian Hubungan Antarlembaga', '', '', NULL),
('1442', 'Subbagian Pers dan Media', '', '', NULL),
('1443', 'Subbagian Protokol', '', '', NULL),
('2100', 'Pusat Teknologi Bahan Industri Nuklir', 'PTBIN', '450262', '3'),
('2110', 'Bagian Tata Usaha', '', '', NULL),
('2111', 'Subbagian Persuratan Kepegawaian dan Dokumentasi Ilmiah', '', '', NULL),
('2112', 'Subbagian Keuangan', '', '', NULL),
('2113', 'Subbagian Perlengkapan', '', '', NULL),
('2120', 'Bidang Bahan Industri Nuklir', '', '', NULL),
('2130', 'Bidang Spektrometri Neutron', '', '', NULL),
('2140', 'Bidang Karakterisasi dan Analisis Nuklir', '', '', NULL),
('2150', 'Bidang Keselamatan dan Instrumentasi', '', '', NULL),
('2151', 'Subbidang Proteksi Radiasi dan Keselamatan Kerja', '', '', NULL),
('2152', 'Subbidang Instrumentasi', '', '', NULL),
('2200', 'Pusat Teknologi Akselerator dan Proses Bahan', 'PTAPB', '017290', '5'),
('2210', 'Bagian Tata Usaha', '', '', NULL),
('2211', 'Subbagian Persuratan dan Kepegawaian', '', '', NULL),
('2212', 'Subbagian Keuangan', '', '', NULL),
('2213', 'Subbagian Perlengkapan', '', '', NULL),
('2214', 'Subbagian Dokumentasi Ilmiah', '', '', NULL),
('2220', 'Bidang Teknologi Akselerator dan Fisika Nuklir', '', '', NULL),
('2221', 'Kelompok Teknologi Akselerator', '', '', NULL),
('2222', 'Kelompok Sistem Instrumentasi dan Kendali Akselerator', '', '', NULL),
('2223', 'Kelompok Teknologi dan Aplikasi Plasma', '', '', NULL),
('2224', 'Kelompok Fisika Nuklir', '', '', NULL),
('2230', 'Bidang Kimia dan Teknologi Proses Bahan', '', '', NULL),
('2231', 'Kelompok Teknologi Pemisahan', '', '', NULL),
('2232', 'Kelompok Teknik Analisis Nuklir Kimia', '', '', NULL),
('2233', 'Kelompok Teknologi Pelapisan', '', '', NULL),
('2234', 'Kelompok Teknologi Proses Bahan Nuklir', '', '', NULL),
('2240', 'Bidang Reaktor', '', '', NULL),
('2241', 'Subbidang Perencanaan Operasi dan Akuntansi Bahan Bakar', '', '', NULL),
('2242', 'Subbidang Operasi dan Perawatan Reaktor', '', '', NULL),
('2250', 'Bidang Keselamatan dan Kesehatan', '', '', NULL),
('2251', 'Subbidang Proteksi Radiasi dan Keselamatan Kerja', '', '', NULL),
('2252', 'Subbidang Pengelolaan Limbah dan Keselamatan Lingkungan', '', '', NULL),
('2253', 'Subbidang Pelayanan Kesehatan', '', '', NULL),
('2260', 'Unit Pengamanan Nuklir*', '', '', NULL),
('2261', 'Unit Pengamanan Nuklir', '', '', NULL),
('2270', 'Balai Elektromekanik', '', '', NULL),
('2271', 'Kelompok Pemeliharaan dan Perbaikan Instrumentasi Nuklir', '', '', NULL),
('2272', 'Kelompok Konstruksi Elektronika dan Instrumentasi', '', '', NULL),
('2273', 'Kelompok Konstruksi dan Pemeliharaan Mekanik', '', '', NULL),
('2300', 'Pusat Teknologi Nuklir Bahan dan Radiometri', 'PTNBR', '017283', '4'),
('2310', 'Bagian Tata Usaha', '', '', NULL),
('2311', 'Subbagian Persuratan dan Kepegawaian', '', '', NULL),
('2312', 'Subbagian Keuangan', '', '', NULL),
('2313', 'Subbagian Perlengkapan', '', '', NULL),
('2314', 'Subbagian Dokumentasi Ilmiah', '', '', NULL),
('2320', 'Bidang Fisika', '', '', NULL),
('2330', 'Bidang Senyawa Bertanda dan Radiometri', '', '', NULL),
('2340', 'Bidang Reaktor', '', '', NULL),
('2341', 'Subbidang Perencanaan Operasi dan Akuntansi Bahan Bakar', '', '', NULL),
('2342', 'Subbidang Operasi dan Perawatan Reaktor', '', '', NULL),
('2350', 'Bidang Keselamatan dan Kesehatan', '', '', NULL),
('2351', 'Subbidang Proteksi Radiasi dan Keselamatan Kerja', '', '', NULL),
('2352', 'Subbidang Pengelolaan Limbah dan Keselamatan Lingkungan', '', '', NULL),
('2353', 'Subbidang Pelayanan Kesehatan', '', '', NULL),
('2360', 'Unit Pengamanan Nuklir', '', '', NULL),
('2361', 'Unit Pengamanan Nuklir', '', '', NULL),
('2370', 'Balai Instrumentasi dan Elektromekanik', '', '', NULL),
('2400', 'Pusat Teknologi Keselamatan dan Metrologi Radiasi', 'PTKMR', '450216', '2'),
('2410', 'Bagian Tata Usaha', '', '', NULL),
('2411', 'Subbagian Persuratan Kepegawaian dan Dokumentasi Ilmiah', '', '', NULL),
('2412', 'Subbagian Keuangan', '', '', NULL),
('2413', 'Subbagian Perlengkapan', '', '', NULL),
('2420', 'Bidang Dosimetri', '', '', NULL),
('2430', 'Bidang Biomedika', '', '', NULL),
('2440', 'Bidang Teknik Nuklir Kedokteran', '', '', NULL),
('2450', 'Bidang Metrologi Radiasi', '', '', NULL),
('2451', 'Subbidang Standardisasi', '', '', NULL),
('2452', 'Subbidang Kalibrasi', '', '', NULL),
('2453', 'Subbidang Instrumentasi', '', '', NULL),
('2460', 'Bidang Keselamatan dan Kesehatan', '', '', NULL),
('2461', 'Subbidang Proteksi Radiasi dan Keselamatan Kerja', '', '', NULL),
('2462', 'Subbidang Pelayanan Kesehatan', '', '', NULL),
('2463', 'Subbidang Keselamatan Lingkungan', '', '', NULL),
('3100', 'Pusat Pengembangan Energi Nuklir', 'PPEN', '535368', '1'),
('3110', 'Bagian Tata Usaha', '', '', NULL),
('3111', 'Subbagian Persuratan dan Kepegawaian', '', '', NULL),
('3112', 'Subbagian Keuangan', '', '', NULL),
('3113', 'Subbagian Perlengkapan', '', '', NULL),
('3114', 'Subbagian Dokumentasi Ilmiah', '', '', NULL),
('3120', 'Bidang Perencanaan Sistem Energi', '', '', NULL),
('3130', 'Bidang Pengembangan Sistem dan Teknologi PLTN', '', '', NULL),
('3140', 'Bidang Pengkajian Kelayakan Tapak PLTN', '', '', NULL),
('3150', 'Bidang Manajemen Persiapan PLTN', '', '', NULL),
('3160', 'Unit Pemantauan Data Tapak dan Lingkungan PLTN', '', '', NULL),
('3161', 'Unit Pemantauan Data Tapak dan Lingkungan PLTN', '', '', NULL),
('3200', 'Pusat Teknologi Reaktor dan Keselamatan Nuklir', 'PTRKN', '450310', '3'),
('3210', 'Bagian Tata Usaha', '', '', NULL),
('3211', 'Subbagian Persuratan dan Kepegawaian', '', '', NULL),
('3212', 'Subbagian Keuangan', '', '', NULL),
('3213', 'Subbagian Perlengkapan', '', '', NULL),
('3214', 'Subbagian Dokumentasi Ilmiah', '', '', NULL),
('3220', 'Bidang Fisika dan Teknologi Reaktor', '', '', NULL),
('3230', 'Bidang Pengkajian Analisis Keselamatan Reaktor', '', '', NULL),
('3240', 'Bidang Pengembangan Reaktor', '', '', NULL),
('3250', 'Bidang Pengembangan Teknologi Keselamatan Nuklir', '', '', NULL),
('3260', 'Bidang Operasi Fasilitas', '', '', NULL),
('3261', 'Subbidang Termohidrolika', '', '', NULL),
('3262', 'Subbidang Instrumentasi', '', '', NULL),
('3263', 'Subbidang Elektromekanik', '', '', NULL),
('3300', 'Pusat Reaktor Serba Guna', 'PRSG', '450247', '3'),
('3310', 'Bagian Tata Usaha', '', '', NULL),
('3311', 'Subbagian PKDI', '', '', NULL),
('3312', 'Subbagian Keuangan', '', '', NULL),
('3313', 'Subbagian Perlengkapan', '', '', NULL),
('3320', 'Bidang Operasi Reaktor', '', '', NULL),
('3321', 'Subbidang Perencanaan Operasi', '', '', NULL),
('3322', 'Subbidang Pelaksanaan Operasi', '', '', NULL),
('3323', 'Subbidang Pelayanan Iradiasi', '', '', NULL),
('3324', 'Subbidang Akuntansi Bahan Nuklir', '', '', NULL),
('3330', 'Bidang Sistem Reaktor', '', '', NULL),
('3331', 'Subbidang Sistem Mekanik', '', '', NULL),
('3332', 'Subbidang Sistem Elektrik', '', '', NULL),
('3333', 'Subbidang Sistem Inst. & Kendali', '', '', NULL),
('3340', 'Bidang Keselamatan', '', '', NULL),
('3341', 'Subbidang Peng. Daerah Kerja', '', '', NULL),
('3342', 'Subbidang Pengendalian Personil', '', '', NULL),
('3343', 'Subbidang Keselamatan Operasi', '', '', NULL),
('3350', 'Unit Jaminan Mutu', '', '', NULL),
('3351', 'Unit Jaminan Mutu', '', '', NULL),
('3360', 'Unit Pengamanan Nuklir', '', '', NULL),
('3361', 'Unit Pengamanan Nuklir', '', '', NULL),
('3400', 'Pusat Pengembangan Informatika Nuklir', 'PPIN', '450304', '3'),
('3410', 'Bagian Tata Usaha', '', '', NULL),
('3411', 'Subbagian Persuratan dan Kepegawaian', '', '', NULL),
('3412', 'Subbagian Keuangan', '', '', NULL),
('3413', 'Subbagian Perlengkapan', '', '', NULL),
('3420', 'Bidang Sistem Informasi', '', '', NULL),
('3430', 'Bidang Komputasi', '', '', NULL),
('3440', 'Bidang Dokumentasi dan Informasi Ilmiah', '', '', NULL),
('3441', 'Subbidang Perpustakaan', '', '', NULL),
('3442', 'Subbidang Informasi dan Pengetahuan Nuklir', '', '', NULL),
('3450', 'Bidang Sistem dan Jaringan Komputer', '', '', NULL),
('3451', 'Subbidang Sistem Komputer', '', '', NULL),
('3452', 'Subbidang Komunikasi Data', '', '', NULL),
('3453', 'Subbidang Pengelolaan Website dan Multimedia', '', '', NULL),
('4100', 'Pusat Pengembangan Geologi Nuklir', 'PPGN', '017262', '2'),
('4110', 'Bagian Tata Usaha', '', '', NULL),
('4111', 'Subbagian Persuratan Kepegawaian dan Dokumentasi Ilmiah', '', '', NULL),
('4112', 'Subbagian Keuangan', '', '', NULL),
('4113', 'Subbagian Perlengkapan', '', '', NULL),
('4120', 'Bidang Geologi dan Pertambangan Bahan Galian Nuklir', '', '', NULL),
('4130', 'Bidang Eksplorasi', '', '', NULL),
('4131', 'Subbidang Pemetaan', '', '', NULL),
('4132', 'Subbidang Eksplorasi Geokimia', '', '', NULL),
('4133', 'Subbidang Eksplorasi Geofisika', '', '', NULL),
('4134', 'Subbidang Mineral', '', '', NULL),
('4140', 'Bidang Evaluasi dan Teknik Penambangan', '', '', NULL),
('4141', 'Subbidang Evaluasi Cadangan', '', '', NULL),
('4142', 'Subbidang Teknik Penambangan', '', '', NULL),
('4143', 'Subbidang Pemboran dan Diagrafi Nuklir', '', '', NULL),
('4144', 'Subbidang Peralatan Elektromekanik', '', '', NULL),
('4150', 'Bidang Keselamatan dan Lingkungan', '', '', NULL),
('4151', 'Subbidang Proteksi Radiasi dan Keselamatan Kerja', '', '', NULL),
('4152', 'Subbidang Pengelolaan Limbah dan Keselamatan Lingkungan', '', '', NULL),
('4160', 'Unit Pengamanan Nuklir', '', '', NULL),
('4161', 'Unit Pengamanan Nuklir', '', '', NULL),
('4200', 'Pusat Teknologi Bahan Bakar Nuklir', 'PTBN', '450253', '3'),
('4210', 'Bagian Tata Usaha', '', '', NULL),
('4211', 'Subbagian Persuratan Kepegawaian dan Dokumentasi Ilmiah', '', '', NULL),
('4212', 'Subbagian Keuangan', '', '', NULL),
('4213', 'Subbagian Perlengkapan', '', '', NULL),
('4220', 'Bidang Bahan Bakar Nuklir', '', '', NULL),
('4230', 'Bidang Pengembangan Radiometalurgi', '', '', NULL),
('4240', 'Bidang Operasi Sarana Penunjang', '', '', NULL),
('4241', 'Subbidang Operasi Sarana Dukung Fasilitas Elemen Bakar', '', '', NULL),
('4242', 'Subbidang Operasi Sarana Dukung Fasilitas Radiometalurgi', '', '', NULL),
('4243', 'Subbidang Pemeliharaan dan Perawatan', '', '', NULL),
('4250', 'Bidang Keselamatan', '', '', NULL),
('4251', 'Subbidang Pengendalian Daerah Kerja', '', '', NULL),
('4252', 'Subbidang Pengendalian Personil', '', '', NULL),
('4253', 'Subbidang Akuntansi Bahan Nuklir dan Pengelolaan Limbah', '', '', NULL),
('4260', 'Unit Jaminan Mutu', '', '', NULL),
('4261', 'Unit Jaminan Mutu', '', '', NULL),
('4270', 'Unit Pengamanan Nuklir*', '', '', NULL),
('4271', 'Unit Pengamanan Nuklir', '', '', NULL),
('4300', 'Pusat Teknologi Limbah Radioaktif', 'PTLR', '450290', '3'),
('4310', 'Bagian Tata Usaha', '', '', NULL),
('4311', 'Subbagian Persuratan Kepegawaian dan Dokumentasi Ilmiah', '', '', NULL),
('4312', 'Subbagian Keuangan', '', '', NULL),
('4313', 'Subbagian Perlengkapan', '', '', NULL),
('4320', 'Bidang Teknologi Penyimpanan Lestari', '', '', NULL),
('4330', 'Bidang Teknologi Pengolahan Limbah Dekontaminasi dan Dekomisioning', '', '', NULL),
('4340', 'Bidang Radioekologi Kelautan', '', '', NULL),
('4350', 'Bidang Operasi Sarana Penunjang', '', '', NULL),
('4351', 'Subbidang Operasi Sistem Penyedia Media dan Energi', '', '', NULL),
('4352', 'Subbidang Perawatan dan Perbaikan Peralatan', '', '', NULL),
('4360', 'Bidang Pengolahan Limbah', '', '', NULL),
('4361', 'Subbidang Preparasi dan Analisis', '', '', NULL),
('4362', 'Subbidang Pengolahan Limbah Cair', '', '', NULL),
('4363', 'Subbidang Pengelohan Limbah Padat', '', '', NULL),
('4364', 'Subbidang Pengangkutan dan Penyimpanan Sementara', '', '', NULL),
('4370', 'Bidang Keselamatan dan Lingkungan', '', '', NULL),
('4371', 'Subbidang Pengendalian Daerah Kerja', '', '', NULL),
('4372', 'Subbidang Pengendalian Personil', '', '', NULL),
('4373', 'Subbidang Analisis Dampak Lingkungan', '', '', NULL),
('4380', 'Unit Jaminan Mutu', '', '', NULL),
('4381', 'Unit Jaminan Mutu', '', '', NULL),
('4390', 'Unit Pengamanan Nuklir', '', '', NULL),
('4391', 'Unit Pengamanan Nuklir', '', '', NULL),
('4400', 'Pusat Rekayasa Perangkat Nuklir', 'PRPN', '450278', '3'),
('4410', 'Bagian Tata Usaha', '', '', NULL),
('4411', 'Subbagian Persuratan Kepegawaian dan Dokumentasi Ilmiah', '', '', NULL),
('4412', 'Subbagian Keuangan', '', '', NULL),
('4413', 'Subbagian Perlengkapan', '', '', NULL),
('4420', 'Bidang Rekayasa Elektromekanik dan Struktur', '', '', NULL),
('4430', 'Bidang Instrumentasi Reaktor dan Industri', '', '', NULL),
('4440', 'Bidang Instrumentasi Kesehatan dan Keselamatan', '', '', NULL),
('4450', 'Bidang Perawatan dan Perbengkelan', '', '', NULL),
('4451', 'Subbidang Perawatan Elektronik', '', '', NULL),
('4452', 'Subbidang Sarana Penunjang', '', '', NULL),
('4453', 'Subbidang Konstruksi dan Perbengkelan', '', '', NULL),
('5100', 'Pusat Radioisotop dan Radiofarmaka', 'PRR', '450284', '3'),
('5110', 'Bagian Tata Usaha', '', '', NULL),
('5111', 'Subbagian Persuratan Kepegawaian dan Dokumentasi Ilmiah', '', '', NULL),
('5112', 'Subbagian Keuangan', '', '', NULL),
('5113', 'Subbagian Perlengkapan', '', '', NULL),
('5120', 'Bidang Radioisotop', '', '', NULL),
('5130', 'Bidang Radiofarmaka', '', '', NULL),
('5140', 'Bidang Siklotron', '', '', NULL),
('5150', 'Bidang Sarana Penunjang dan Proses', '', '', NULL),
('5151', 'Subbidang Pengelolaan Sarana', '', '', NULL),
('5152', 'Subbidang Proses', '', '', NULL),
('5160', 'Bidang Keselamatan', '', '', NULL),
('5161', 'Subbidang Pengendalian Daerah Kerja', '', '', NULL),
('5162', 'Subbidang Pengendalian Personil', '', '', NULL),
('5163', 'Subbidang Pengelolaan Limbah', '', '', NULL),
('5200', 'Pusat Aplikasi Teknologi Isotop dan Radiasi', 'PATIR', '017258', '2'),
('5210', 'Bagian Tata Usaha', '', '', NULL),
('5211', 'Subbagian Persuratan dan Kepegawaian', '', '', NULL),
('5212', 'Subbagian Keuangan', '', '', NULL),
('5213', 'Subbagian Perlengkapan', '', '', NULL),
('5214', 'Subbagian Dokumentasi Ilmiah', '', '', NULL),
('5220', 'Bidang Kebumian dan Lingkungan', '', '', NULL),
('5230', 'Bidang Proses Radiasi', '', '', NULL),
('5240', 'Bidang Pertanian', '', '', NULL),
('5250', 'Bidang Keselamatan', '', '', NULL),
('5251', 'Subbidang Proteksi Radiasi dan Keselamatan Kerja', '', '', NULL),
('5252', 'Subbidang Pengelolaan Limbah', '', '', NULL),
('5260', 'Unit Pengamanan Nuklir Kawasan', '', '', NULL),
('5261', 'Unit Pengamanan Nuklir Kawasan', '', '', NULL),
('5270', 'Balai Iradiasi Elektromekanik dan Instrumentasi', '', '', NULL),
('5300', 'Pusat Diseminasi Iptek Nuklir', 'PDIN', '614858', '2'),
('5310', 'Bagian Tata Usaha', '', '', NULL),
('5311', 'Subbagian Persuratan dan Kepegawaian', '', '', NULL),
('5312', 'Subbagian Keuangan', '', '', NULL),
('5313', 'Subbagian Perlengkapan', '', '', NULL),
('5320', 'Bidang Diseminasi', '', '', NULL),
('5321', 'Subbidang Diseminasi Iptek Nuklir Energi', '', '', NULL),
('5322', 'Subbidang Diseminasi Iptek Nuklir Non Energi', '', '', NULL),
('5330', 'Bidang Promosi', '', '', NULL),
('5331', 'Subbidang Perencanaan Promosi', '', '', NULL),
('5332', 'Subbidang Pelaksanaan Promosi', '', '', NULL),
('5340', 'Bidang Evaluasi dan Dokumentasi', '', '', NULL),
('5341', 'Subbidang Evaluasi', '', '', NULL),
('5342', 'Subbidang Dokumentasi', '', '', NULL),
('5350', 'Unit Jaminan Mutu*', '', '', NULL),
('5351', 'Unit Jaminan Mutu', '', '', NULL),
('5400', 'Pusat Kemitraan Teknologi Nuklir', 'PKTN', '450222', '3'),
('5410', 'Bagian Tata Usaha', '', '', NULL),
('5411', 'Subbagian Persuratan dan Kepegawaian', '', '', NULL),
('5412', 'Subbagian Keuangan', '', '', NULL),
('5413', 'Subbagian Perlengkapan', '', '', NULL),
('5420', 'Bidang Pendayagunaan Hasil Penelitian dan Pengembangan', '', '', NULL),
('5430', 'Bidang Kemitraan', '', '', NULL),
('5431', 'Subbidang Agroindustri', '', '', NULL),
('5432', 'Subbidang Perangkat Medik', '', '', NULL),
('5433', 'Subbidang Industri', '', '', NULL),
('5440', 'Bidang Pengelolaan Kawasan Nuklir Serpong', '', '', NULL),
('5441', 'Subbidang Perawatan Prasarana', '', '', NULL),
('5442', 'Subbidang Dokumentasi', '', '', NULL),
('5443', 'Subbidang Pelayanan Kesehatan', '', '', NULL),
('5450', 'Unit Jaminan Mutu', '', '', NULL),
('5451', 'Unit Jaminan Mutu', '', '', NULL),
('5460', 'Unit Pengamanan Nuklir', '', '', NULL),
('5461', 'Unit Pengamanan Nuklir', '', '', NULL),
('6100', 'Inspektorat', 'INSPEKTORAT', '614837', '1'),
('6110', 'Bagian Tata Usaha', '', '', NULL),
('6111', 'Subbagian Tata Usaha', '', '', NULL),
('6120', 'Kelompok Jabatan Fungsional Auditor', '', '', NULL),
('7100', 'Pusat Standardisasi dan Jaminan Mutu Nuklir', 'PSJMN', '614879', '3'),
('7110', 'Bagian Tata Usaha', '', '', NULL),
('7111', 'Subbagian Tata Usaha', '', '', NULL),
('7120', 'Bidang Standardisasi Radiasi dan Nuklir', '', '', NULL),
('7121', 'Subbidang Standar Keselamatan', '', '', NULL),
('7122', 'Subbidang Standar Mutu Bahan dan Peralatan Nuklir', '', '', NULL),
('7130', 'Bidang Akreditasi dan Sertifikasi', '', '', NULL),
('7131', 'Subbidang Akreditasi', '', '', NULL),
('7132', 'Subbidang Sertifikasi', '', '', NULL),
('7140', 'Bidang Jaminan Mutu', '', '', NULL),
('7141', 'Subbidang Program', '', '', NULL),
('7142', 'Subbidang Audit dan Pemantauan', '', '', NULL),
('8100', 'Pusat Pendidikan dan Pelatihan', 'PUSDIKLAT', '450231', '2'),
('8110', 'Bagian Tata Usaha', '', '', NULL),
('8111', 'Subbagian Persuratan dan Kepegawaian', '', '', NULL),
('8112', 'Subbagian Keuangan', '', '', NULL),
('8113', 'Subbagian Perlengkapan', '', '', NULL),
('8120', 'Bidang Perencanaan', '', '', NULL),
('8121', 'Subbidang Program', '', '', NULL),
('8122', 'Subbidang Kurikulum dan Modul', '', '', NULL),
('8130', 'Bidang Penyelenggaraan', '', '', NULL),
('8131', 'Subbidang Pendidikan dan Pelatihan Teknis', '', '', NULL),
('8132', 'Subbidang Pendidikan dan Pelatihan Struktural dan Fungsional', '', '', NULL),
('8133', 'Subbidang Sarana Laboratorium', '', '', NULL),
('8140', 'Bidang Evaluasi', '', '', NULL),
('8141', 'Subbidang Evaluasi Pendidikan dan Pelatihan', '', '', NULL),
('8142', 'Subbidang Informasi dan Dokumentasi', '', '', NULL),
('8150', 'Kelompok Jabatan Fungsional Widyaiswara', '', '', NULL),
('9100', 'Sekolah Tinggi Teknologi Nuklir', 'STTN', '524334', '5'),
('9101', 'Pembantu Ketua I', '', '', NULL),
('9102', 'Pembantu Ketua II', '', '', NULL),
('9103', 'Pembantu Ketua III', '', '', NULL),
('9110', 'Bagian Administrasi Akademik dan Kemahasiswaan', '', '', NULL),
('9111', 'Subbagian Perencanaan dan Kerja Sama', '', '', NULL),
('9112', 'Subbagian Akademik dan Pengajaran', '', '', NULL),
('9113', 'Subbagian Kemahasiswaan dan Alumni', '', '', NULL),
('9120', 'Bagian Administrasi Umum', '', '', NULL),
('9121', 'Subbagian Persuratan dan Kepegawaian', '', '', NULL),
('9122', 'Subbagian Keuangan', '', '', NULL),
('9123', 'Subbagian Perlengkapan', '', '', NULL),
('9130', 'Kelompok Dosen', '', '', NULL),
('9131', 'Jurusan Teknofisika Nuklir', '', '', NULL),
('9132', 'Jurusan Teknokimia Nuklir', '', '', NULL),
('9140', 'Unit Penunjang', '', '', NULL),
('9141', 'Unit PPM', '', '', NULL),
('9142', 'Unit Komputer', '', '', NULL),
('9143', 'Unit Perpustakaan', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xconfig`
--

CREATE TABLE IF NOT EXISTS `xconfig` (
  `name` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `content` varchar(40) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `xconfig`
--

INSERT INTO `xconfig` (`name`, `content`) VALUES
('copyright', 'PPIN - BATAN Â© 2010 '),
('title', 'SI Administrasi Presensi Pegawai'),
('version', 'v2.1');

-- --------------------------------------------------------

--
-- Table structure for table `xhead`
--

CREATE TABLE IF NOT EXISTS `xhead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('js','css') COLLATE latin1_general_ci NOT NULL,
  `src` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `xhead`
--

INSERT INTO `xhead` (`id`, `type`, `src`) VALUES
(1, 'css', 'css/mediamanager.css'),
(3, 'css', 'css/system.css'),
(5, 'css', 'css/rounded.css'),
(6, 'js', 'lib/menu/menu.js'),
(8, 'css', 'lib/menu/menu.css'),
(9, 'js', 'lib/dtree/dtree.js'),
(10, 'css', 'lib/dtree/dtree.css'),
(11, 'js', 'js/global.js'),
(12, 'css', 'lib/calendar/skins/aqua/theme.css'),
(13, 'js', 'lib/calendar/calendar.js'),
(14, 'js', 'lib/calendar/lang/calendar-in.js'),
(15, 'js', 'lib/calendar/calendar-setup.js'),
(19, 'css', 'css/template.css');

-- --------------------------------------------------------

--
-- Table structure for table `xlevel`
--

CREATE TABLE IF NOT EXISTS `xlevel` (
  `kode` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(40) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `xlevel`
--

INSERT INTO `xlevel` (`kode`, `name`) VALUES
('ADM', 'Administrator'),
('DEV', 'Developer'),
('DIRJEN', 'Direktorat Jendral'),
('DIT', 'Direktorat'),
('OPR', 'Operator'),
('SEKSI', 'Seksi'),
('STAF', 'Staf'),
('SUBDIT', 'Sub Direktorat'),
('SUBSEKSI', 'Sub Seksi'),
('UPT', 'UPT'),
('WAMEN', 'Wakil Menteri');

-- --------------------------------------------------------

--
-- Table structure for table `xlog`
--

CREATE TABLE IF NOT EXISTS `xlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `type` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `modifiedby` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `ipaddress` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `success` enum('0','1') COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `modifiedby` (`modifiedby`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=62 ;

--
-- Dumping data for table `xlog`
--

INSERT INTO `xlog` (`id`, `date`, `description`, `type`, `modifiedby`, `ipaddress`, `success`) VALUES
(1, '2013-10-03 03:41:18', 'Input Menu success, id = 18. Input Menu Type success, id = 11. Input Menu Level success, id = 19.', 'xmenu', 'abrarhedar', '::1', '1'),
(2, '2013-10-03 06:18:54', 'Login success', 'xlogin', 'abrarhedar', '::1', '1'),
(3, '2013-10-03 06:24:12', 'Input Menu failed, error = Cannot add or update a child row: a foreign key constraint fails (`khaira`.`xmenu`, CONSTRAINT `xmenu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `xmenu` (`id`) ON UPDATE CASCADE).', 'xmenu', 'abrarhedar', '::1', '0'),
(4, '2013-10-03 06:25:41', 'Input Menu success, id = 20. Input Menu Type success, id = 12. Input Menu Level success, id = 20.', 'xmenu', 'abrarhedar', '::1', '1'),
(5, '2013-10-03 07:00:55', 'Update Menu success, id = 15.', 'xmenu', 'abrarhedar', '::1', '1'),
(6, '2013-10-03 07:03:14', 'Update Menu success, id = 15.', 'xmenu', 'abrarhedar', '::1', '1'),
(7, '2013-10-03 07:05:56', 'Update Menu success, id = 15.', 'xmenu', 'abrarhedar', '::1', '1'),
(8, '2013-10-03 07:07:06', 'Update Menu success, id = 15.', 'xmenu', 'abrarhedar', '::1', '1'),
(9, '2013-10-03 07:09:50', 'Update Menu success, id = 15.', 'xmenu', 'abrarhedar', '::1', '1'),
(10, '2013-10-03 07:10:15', 'Update Menu success, id = 15.', 'xmenu', 'abrarhedar', '::1', '1'),
(11, '2013-10-03 07:11:16', 'Update Menu success, id = 15.', 'xmenu', 'abrarhedar', '::1', '1'),
(12, '2013-10-03 21:01:03', 'Login success', 'xlogin', 'abrarhedar', '::1', '1'),
(13, '2013-10-03 21:01:23', 'Update Menu success, id = 15.', 'xmenu', 'abrarhedar', '::1', '1'),
(14, '2013-10-03 21:07:16', 'Input Menu failed, error = Column ''src'' cannot be null.', 'xmenu', 'abrarhedar', '::1', '0'),
(15, '2013-10-03 21:08:29', 'Input Menu success, id = 23.', 'xmenu', 'abrarhedar', '::1', '1'),
(16, '2013-10-03 21:09:10', 'Input Menu success, id = 24.', 'xmenu', 'abrarhedar', '::1', '1'),
(17, '2013-10-03 21:10:15', 'Input Menu success, id = 25.', 'xmenu', 'abrarhedar', '::1', '1'),
(18, '2013-10-03 21:11:52', 'Update Menu success, id = 2.', 'xmenu', 'abrarhedar', '::1', '1'),
(19, '2013-10-03 21:12:33', 'Update Menu success, id = 2.', 'xmenu', 'abrarhedar', '::1', '1'),
(20, '2013-10-03 21:15:02', 'Input Menu success, id = 26.', 'xmenu', 'abrarhedar', '::1', '1'),
(21, '2013-10-03 21:15:52', 'Input Menu success, id = 27.', 'xmenu', 'abrarhedar', '::1', '1'),
(22, '2013-10-03 21:16:13', 'Input Menu success, id = 28.', 'xmenu', 'abrarhedar', '::1', '1'),
(23, '2013-10-03 21:16:38', 'Input Menu success, id = 29.', 'xmenu', 'abrarhedar', '::1', '1'),
(24, '2013-10-03 21:17:09', 'Input Menu success, id = 30.', 'xmenu', 'abrarhedar', '::1', '1'),
(25, '2013-10-03 21:17:45', 'Input Menu success, id = 31.', 'xmenu', 'abrarhedar', '::1', '1'),
(26, '2013-10-03 21:18:03', 'Input Menu success, id = 32.', 'xmenu', 'abrarhedar', '::1', '1'),
(27, '2013-10-03 21:18:32', 'Input Menu success, id = 33.', 'xmenu', 'abrarhedar', '::1', '1'),
(28, '2013-10-03 21:19:00', 'Input Menu success, id = 34.', 'xmenu', 'abrarhedar', '::1', '1'),
(29, '2013-10-03 21:19:33', 'Input Menu success, id = 35.', 'xmenu', 'abrarhedar', '::1', '1'),
(30, '2013-10-03 21:19:58', 'Input Menu success, id = 36.', 'xmenu', 'abrarhedar', '::1', '1'),
(31, '2013-10-03 21:20:22', 'Input Menu success, id = 37.', 'xmenu', 'abrarhedar', '::1', '1'),
(32, '2013-10-03 21:20:53', 'Input Menu success, id = 38.', 'xmenu', 'abrarhedar', '::1', '1'),
(33, '2013-10-03 21:21:18', 'Input Menu success, id = 39.', 'xmenu', 'abrarhedar', '::1', '1'),
(34, '2013-10-03 21:21:49', 'Input Menu success, id = 40.', 'xmenu', 'abrarhedar', '::1', '1'),
(35, '2013-10-03 21:26:03', 'Input Menu success, id = 41.', 'xmenu', 'abrarhedar', '::1', '1'),
(36, '2013-10-03 21:26:38', 'Input Menu success, id = 42.', 'xmenu', 'abrarhedar', '::1', '1'),
(37, '2013-10-03 21:27:03', 'Input Menu success, id = 43.', 'xmenu', 'abrarhedar', '::1', '1'),
(38, '2013-10-03 21:27:34', 'Input Menu success, id = 44.', 'xmenu', 'abrarhedar', '::1', '1'),
(39, '2013-10-03 21:38:09', 'Update Menu success, id = 2. Update Menu Type failed, error = .', 'xmenu', 'abrarhedar', '::1', '1'),
(40, '2013-10-03 21:39:00', 'Update Menu success, id = 2.', 'xmenu', 'abrarhedar', '::1', '1'),
(41, '2013-10-03 21:39:44', 'Update Menu success, id = 2.', 'xmenu', 'abrarhedar', '::1', '1'),
(42, '2013-10-03 21:39:53', 'Update Menu success, id = 2.', 'xmenu', 'abrarhedar', '::1', '1'),
(43, '2013-10-03 21:44:09', 'Update Menu success, id = 3.', 'xmenu', 'abrarhedar', '::1', '1'),
(44, '2013-10-03 23:04:37', 'Update Menu success, id = 23.', 'xmenu', 'abrarhedar', '::1', '1'),
(45, '2013-10-03 23:04:49', 'Update Menu success, id = 41.', 'xmenu', 'abrarhedar', '::1', '1'),
(46, '2013-10-03 23:05:14', 'Update Menu success, id = 25.', 'xmenu', 'abrarhedar', '::1', '1'),
(47, '2013-10-03 23:27:29', 'Input Menu success, id = 45.', 'xmenu', 'abrarhedar', '::1', '1'),
(48, '2013-10-03 23:28:01', 'Input Menu success, id = 46.', 'xmenu', 'abrarhedar', '::1', '1'),
(49, '2013-10-03 23:30:56', 'Update Menu success, id = 27.', 'xmenu', 'abrarhedar', '::1', '1'),
(50, '2013-10-03 23:33:21', 'Update Menu success, id = 28.', 'xmenu', 'abrarhedar', '::1', '1'),
(51, '2013-10-03 23:36:09', 'Update Menu success, id = 29.', 'xmenu', 'abrarhedar', '::1', '1'),
(52, '2013-10-03 23:36:42', 'Update Menu success, id = 28.', 'xmenu', 'abrarhedar', '::1', '1'),
(53, '2013-10-03 23:37:06', 'Update Menu success, id = 29.', 'xmenu', 'abrarhedar', '::1', '1'),
(54, '2013-10-03 23:37:13', 'Update Menu success, id = 29.', 'xmenu', 'abrarhedar', '::1', '1'),
(55, '2013-10-03 23:37:20', 'Update Menu success, id = 28.', 'xmenu', 'abrarhedar', '::1', '1'),
(56, '2013-10-03 23:37:51', 'Input Menu success, id = 47.', 'xmenu', 'abrarhedar', '::1', '1'),
(57, '2013-10-03 23:39:13', 'Update Menu success, id = 30.', 'xmenu', 'abrarhedar', '::1', '1'),
(58, '2013-10-03 23:39:42', 'Update Menu success, id = 31.', 'xmenu', 'abrarhedar', '::1', '1'),
(59, '2013-10-03 23:40:25', 'Update Menu success, id = 32.', 'xmenu', 'abrarhedar', '::1', '1'),
(60, '2013-10-03 23:40:39', 'Update Menu success, id = 33.', 'xmenu', 'abrarhedar', '::1', '1'),
(61, '2013-10-03 23:40:48', 'Update Menu success, id = 34.', 'xmenu', 'abrarhedar', '::1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `xmenu`
--

CREATE TABLE IF NOT EXISTS `xmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `published` enum('0','1') COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `src` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=48 ;

--
-- Dumping data for table `xmenu`
--

INSERT INTO `xmenu` (`id`, `name`, `title`, `parent`, `published`, `src`, `ordering`) VALUES
(1, 'Home', 'Home', NULL, '1', 'includes/home.php', 1),
(2, 'System', 'System', NULL, '1', NULL, 99),
(3, 'Pengaturan Menu', 'Pengaturan Menu', 2, '1', 'menus/system/menu.php', 1),
(4, 'New', 'Menu', 3, '1', 'menus/system/menu_ed.php', 2),
(5, 'Menu Delete', 'Menu Delete', 3, '0', 'menus/system/menu_del.php', 3),
(21, 'Surat Masuk', 'Surat Masuk', NULL, '1', '', 2),
(22, 'Surat Keluar', 'Surat Keluar', NULL, '1', '', 3),
(23, 'Template', 'Template', NULL, '0', NULL, 4),
(24, 'PLH', 'PLH', NULL, '1', NULL, 5),
(25, 'Kalendar', 'Kalendar', NULL, '0', NULL, 6),
(26, 'Buku Alamat', 'Buku Alamat', NULL, '1', NULL, 7),
(27, 'Kotak Surat', 'Kotak Surat', 21, '1', NULL, 1),
(28, 'Pencatatan Surat Masuk', 'Pencatatan Surat Masuk', 21, '1', NULL, 2),
(29, 'Pencarian Surat Masuk', 'Pencarian Surat Masuk', 21, '1', NULL, 3),
(30, 'Pencatatan Surat Keluar', 'Pencatatan Surat Keluar', 22, '1', NULL, 1),
(31, 'Pencarian Surat Keluar', 'Pencarian Surat Keluar', 22, '1', NULL, 2),
(32, 'Laporan Surat Keluar', 'Laporan Surat Keluar', 22, '1', NULL, 3),
(33, 'Buat Surat', 'Buat Surat', 22, '0', NULL, 4),
(34, 'Disposisi Keluar', 'Disposisi Keluar', 22, '0', NULL, 5),
(35, 'Template', 'Template', 23, '1', NULL, 1),
(36, 'PLH', 'PLH', 24, '1', NULL, 1),
(37, 'Kalendar', 'Kalendar', 25, '1', NULL, 1),
(38, 'Daftar Kontak', 'Daftar Kontak', 26, '1', NULL, 1),
(39, 'Daftar Tunggu', 'Daftar Tunggu', 26, '1', NULL, 2),
(40, 'Daftar Periksa', 'Daftar Periksa', 26, '1', NULL, 3),
(41, 'Agenda', 'Agenda', NULL, '0', NULL, 5),
(42, 'Agenda', 'Agenda', 41, '1', NULL, 1),
(43, 'Agenda Keluar', 'Agenda Keluar', 41, '1', NULL, 2),
(44, 'Surat Manual', 'Surat Manual', 41, '1', NULL, 3),
(45, 'Pengguna', 'Pengguna', NULL, '1', NULL, 6),
(46, 'Pengguna', 'Pengguna', 45, '1', NULL, 1),
(47, 'Laporan Surat Masuk', 'Laporan Surat Masuk', 21, '1', NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `xmenulevel`
--

CREATE TABLE IF NOT EXISTS `xmenulevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` int(11) DEFAULT NULL,
  `level` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `menu` (`menu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=50 ;

--
-- Dumping data for table `xmenulevel`
--

INSERT INTO `xmenulevel` (`id`, `menu`, `level`) VALUES
(1, 1, 'DEV'),
(2, 1, 'ADM'),
(3, 1, 'OPR'),
(4, 1, 'DIT'),
(5, 1, 'SUBDIT'),
(6, 1, 'SEKSI'),
(7, 2, 'DEV'),
(8, 3, 'DEV'),
(9, 4, 'DEV'),
(10, 5, 'DEV'),
(11, 1, 'STAF'),
(22, 21, 'DEV'),
(23, 22, 'DEV'),
(24, 23, 'DEV'),
(25, 24, 'DEV'),
(26, 25, 'DEV'),
(27, 26, 'DEV'),
(28, 27, 'DEV'),
(29, 28, 'DEV'),
(30, 29, 'DEV'),
(31, 30, 'DEV'),
(32, 31, 'DEV'),
(33, 32, 'DEV'),
(34, 33, 'DEV'),
(35, 34, 'DEV'),
(36, 35, 'DEV'),
(37, 36, 'DEV'),
(38, 37, 'DEV'),
(39, 38, 'DEV'),
(40, 39, 'DEV'),
(41, 40, 'DEV'),
(42, 41, 'DEV'),
(43, 42, 'DEV'),
(44, 43, 'DEV'),
(45, 44, 'DEV'),
(47, 45, 'DEV'),
(48, 46, 'DEV'),
(49, 47, 'DEV');

-- --------------------------------------------------------

--
-- Table structure for table `xmenutype`
--

CREATE TABLE IF NOT EXISTS `xmenutype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` int(11) NOT NULL,
  `type` varchar(40) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu` (`menu`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=44 ;

--
-- Dumping data for table `xmenutype`
--

INSERT INTO `xmenutype` (`id`, `menu`, `type`) VALUES
(1, 1, 'topmenu'),
(4, 3, 'topmenu'),
(6, 4, 'submenu'),
(7, 5, 'submenu'),
(15, 21, 'topmenu'),
(16, 22, 'topmenu'),
(17, 23, 'topmenu'),
(18, 24, 'topmenu'),
(19, 25, 'topmenu'),
(20, 2, 'topmenu'),
(21, 26, 'topmenu'),
(22, 27, 'topmenu'),
(23, 28, 'topmenu'),
(24, 29, 'topmenu'),
(25, 30, 'topmenu'),
(26, 31, 'topmenu'),
(27, 32, 'topmenu'),
(28, 33, 'topmenu'),
(29, 34, 'topmenu'),
(30, 35, 'topmenu'),
(31, 36, 'topmenu'),
(32, 37, 'topmenu'),
(33, 38, 'topmenu'),
(34, 39, 'topmenu'),
(35, 40, 'topmenu'),
(36, 41, 'topmenu'),
(37, 42, 'topmenu'),
(38, 43, 'topmenu'),
(39, 44, 'topmenu'),
(41, 45, 'topmenu'),
(42, 46, 'topmenu'),
(43, 47, 'topmenu');

-- --------------------------------------------------------

--
-- Table structure for table `xposition`
--

CREATE TABLE IF NOT EXISTS `xposition` (
  `kode` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `published` enum('0','1') COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `xposition`
--

INSERT INTO `xposition` (`kode`, `name`, `published`) VALUES
('leftmenu', 'Left Menu', '0'),
('submenu', 'Sub Menu', '1'),
('topmenu', 'Top Menu', '1');

-- --------------------------------------------------------

--
-- Table structure for table `xuser`
--

CREATE TABLE IF NOT EXISTS `xuser` (
  `username` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `unit` varchar(4) COLLATE latin1_general_ci DEFAULT NULL,
  `password` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `lastlogin` datetime NOT NULL,
  PRIMARY KEY (`username`),
  KEY `unit` (`unit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `xuser`
--

INSERT INTO `xuser` (`username`, `unit`, `password`, `lastlogin`) VALUES
('abrarhedar', '3400', 'd5fd6db532f25211a42390aa664ea31e', '2013-10-04 04:01:03');

-- --------------------------------------------------------

--
-- Table structure for table `xuserlevel`
--

CREATE TABLE IF NOT EXISTS `xuserlevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `level` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xuserlevel`
--

INSERT INTO `xuserlevel` (`id`, `username`, `level`) VALUES
(1, 'abrarhedar', 'DEV');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
