CREATE TABLE IF NOT EXISTS `xuser` (
  `username` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `kode_unit` varchar(4) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `level` set('0','1','2','3','4','5','6','7','8','9') COLLATE latin1_general_ci NOT NULL,
  `register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit` datetime NOT NULL,
  `lastmodified` datetime NOT NULL,
  `modifiedby` varchar(40) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`username`),
  FOREIGN KEY (`kode_unit`) REFERENCES `unit` (`kode`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `xuser`
--

INSERT INTO `xuser` (`username`, `kode_unit`, `password`, `level`, `register`, `lastvisit`, `lastmodified`, `modifiedby`) VALUES
('abrarhedar', '3400', 'd5fd6db532f25211a42390aa664ea31e', '0', '2010-10-20 09:50:14', '2013-08-20 08:17:49', '2013-06-27 10:27:28', 'abrarhedar');


 ALTER TABLE `xuser` ADD FOREIGN KEY ( `kode_unit` ) REFERENCES `khaira`.`unit` (
`kode`
) ON DELETE SET NULL ON UPDATE CASCADE ;

CREATE TABLE IF NOT EXISTS `xmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `type` set('left','top','sub') COLLATE latin1_general_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `published` enum('0','1') COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `level` set('0','1','2','3','4','5','6','7','8','9') COLLATE latin1_general_ci NOT NULL,
  `action` enum('','ed','del') COLLATE latin1_general_ci NOT NULL,
  `src` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '1',
  `dateinserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastmodified` datetime NOT NULL,
  `modifiedby` varchar(40) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=108 ;

--
-- Dumping data for table `xmenu`
--

INSERT INTO `xmenu` (`id`, `name`, `title`, `type`, `parent`, `published`, `level`, `action`, `src`, `ordering`, `dateinserted`, `lastmodified`, `modifiedby`) VALUES
(1, 'Home', 'Home', 'top', 0, '1', '0,1,2,3,4,5,6,7,8,9', '', 'includes/home.php', 1, '2010-10-20 02:45:30', '2010-10-20 16:45:30', ''),
(2, 'System', 'System', 'left,top', 0, '1', '0', '', '', 99, '2010-10-20 02:45:30', '2010-12-23 14:21:35', 'abrarhedar'),
(3, 'Menu Manager', 'Menu Manager', 'left,top', 2, '1', '0', '', 'menus/system/menu.php', 1, '2010-10-20 02:47:44', '2010-12-22 15:51:01', 'abrarhedar'),
(4, 'List', 'Menu Manager', 'sub', 3, '1', '0', '', 'menus/system/menu.php', 1, '2010-10-20 02:49:34', '2010-12-22 15:51:13', 'abrarhedar'),
(5, 'New', 'Menu', 'sub', 3, '1', '0', 'ed', 'menus/system/menu_ed.php', 2, '2010-10-20 02:49:34', '2010-12-23 09:53:19', 'abrarhedar'),
(6, 'Level Manager', 'Level Manager', 'left,top', 2, '1', '0', '', 'menus/system/level.php', 2, '2010-10-24 18:54:37', '2010-12-23 14:21:44', 'abrarhedar'),
(7, 'List', 'Level Manager', 'sub', 6, '1', '0', '', 'menus/system/level.php', 1, '2010-10-24 18:55:47', '2010-12-22 15:51:43', 'abrarhedar'),
(8, 'New', 'Level', 'sub', 6, '1', '0', 'ed', 'menus/system/level_ed.php', 2, '2010-10-24 18:56:24', '2010-12-23 09:54:00', 'abrarhedar'),
(9, 'Menu Delete', 'Menu Delete', 'sub', 3, '0', '0', 'del', 'menus/system/menu_del.php', 3, '2010-10-24 18:58:06', '2010-12-23 09:53:27', 'abrarhedar'),
(10, 'Level Delete', 'Level Delete', 'sub', 6, '0', '0', 'del', 'menus/system/level_del.php', 3, '2010-10-24 18:58:41', '2010-12-23 09:54:06', 'abrarhedar'),
(11, 'Manajemen Pengguna', 'Manajemen Pengguna', 'left,top', 2, '1', '0', '', 'menus/system/user.php', 3, '2010-10-24 19:04:35', '2013-06-04 22:23:13', 'abrarhedar'),
(12, 'List', 'User Manager', 'sub', 11, '1', '0', '', 'menus/system/user.php', 1, '2010-10-24 19:05:57', '2010-12-22 15:52:22', 'abrarhedar'),
(13, 'New', 'User', 'sub', 11, '1', '0', 'ed', 'menus/system/user_ed.php', 2, '2010-10-24 19:06:33', '2010-12-23 09:54:14', 'abrarhedar'),
(14, 'User Delete', 'User Delete', 'sub', 11, '0', '0', 'del', 'menus/system/user_del.php', 3, '2010-10-24 19:07:07', '2010-12-23 09:54:20', 'abrarhedar'),
(15, 'JS & CSS Manager', 'Javascript & CSS Manager', 'left,top', 2, '1', '0', '', 'menus/system/header.php', 4, '2010-10-24 20:04:13', '2010-12-22 15:53:23', 'abrarhedar'),
(16, 'List', 'Javascript & CSS Manager', 'sub', 15, '1', '0', '', 'menus/system/header.php', 1, '2010-10-24 20:23:21', '2010-12-22 15:53:36', 'abrarhedar'),
(17, 'New', 'Javascript & CSS', 'sub', 15, '1', '0', 'ed', 'menus/system/header_ed.php', 2, '2010-10-24 20:24:22', '2010-12-23 09:54:32', 'abrarhedar'),
(18, 'JS & CSS Delete', 'JS & CSS Delete', 'sub', 15, '0', '0', 'del', 'menus/system/header_del.php', 3, '2010-10-24 20:24:55', '2010-12-23 09:54:38', 'abrarhedar'),
(19, 'Modul Manager', 'Modul Manager', 'left,top', 2, '1', '0', '', 'menus/system/modul.php', 5, '2010-10-24 20:33:02', '2010-12-22 15:53:58', 'abrarhedar'),
(20, 'List', 'Modul Manager', 'sub', 19, '1', '0', '', 'menus/system/modul.php', 1, '2010-10-24 21:33:11', '2010-12-22 15:54:07', 'abrarhedar'),
(21, 'New', 'Modul', 'sub', 19, '1', '0', 'ed', 'menus/system/modul_ed.php', 2, '2010-10-24 21:33:52', '2010-12-23 09:54:49', 'abrarhedar'),
(22, 'Modul Delete', 'Modul Delete', 'sub', 19, '0', '0', 'del', 'menus/system/modul_del.php', 3, '2010-10-24 21:34:35', '2010-12-23 09:54:58', 'abrarhedar'),
(23, 'Ubah Password', 'Ubah Password', 'left,top', 2, '1', '0', '', 'menus/system/password_ed.php', 7, '2010-10-27 01:16:41', '2010-12-28 08:44:15', 'abrarhedar'),
(24, 'Configuration', 'Configuration', 'left,top', 2, '1', '0', '', 'menus/system/config.php', 6, '2010-12-27 18:43:38', '2010-12-28 08:44:02', 'abrarhedar'),
(25, 'List', 'Configuration', 'sub', 24, '1', '0', '', 'menus/system/config.php', 1, '2010-12-27 18:59:15', '2010-12-28 09:03:04', 'abrarhedar'),
(26, 'New', 'Configuration', 'sub', 24, '1', '0', 'ed', 'menus/system/config_ed.php', 2, '2010-12-27 19:02:08', '2010-12-28 09:02:32', 'abrarhedar'),
(27, 'Delete', 'Configuration', 'sub', 24, '0', '0', 'del', 'menus/system/config_del.php', 3, '2010-12-27 19:04:20', '2010-12-28 09:04:44', 'abrarhedar'),
(28, 'Presensi', 'Administrasi Presensi', 'left,top', 0, '1', '0,1,2,3,4,5,6', '', '', 2, '2010-12-29 18:56:03', '2012-04-16 09:31:29', 'abrarhedar'),
(29, 'Presensi Pegawai', 'Presensi Pegawai', 'left,top', 28, '1', '0,1,2,3,4,5,6', '', 'menus/siapp/presensi/presensi.php', 2, '2010-12-29 18:58:24', '2013-07-12 22:27:37', 'abrarhedar'),
(30, 'Import Data Presensi', 'Import Data Presensi', 'left,top', 28, '1', '0,1', 'ed', 'menus/siapp/presensi/import.php', 1, '2010-12-29 19:00:26', '2013-07-03 09:15:34', 'abrarhedar'),
(31, 'Rekapitulasi Presensi', 'Rekapitulasi Presensi', 'left,top', 28, '1', '0,1,2,3,4,5', '', 'menus/siapp/presensi/rekapitulasi.php', 5, '2011-01-03 19:19:18', '2013-07-12 22:27:54', 'abrarhedar'),
(37, 'Setup', '', 'left,top', 0, '1', '0', '', '', 98, '2011-01-23 21:24:59', '2011-01-31 10:39:15', 'abrarhedar'),
(38, 'Import Data Pegawai', 'Import Data Pegawai', 'left,top', 37, '1', '0', '', 'menus/siapp/setup/pegawai.php', 1, '2011-01-23 21:28:46', '2011-01-28 09:25:49', 'abrarhedar'),
(39, 'Import Data Presensi', 'Import Data Presensi', 'left,top', 37, '1', '0', '', 'menus/siapp/setup/presensi.php', 2, '2011-01-23 21:29:36', '2011-01-28 09:26:10', 'abrarhedar'),
(40, 'Referensi', 'Referensi', 'left,top', 0, '1', '0,1,2,3,4,5,6', '', '', 4, '2011-01-26 18:03:34', '2013-07-16 17:43:24', 'abrarhedar'),
(41, 'Pegawai', 'Pegawai', 'left,top', 40, '1', '0,1,2', '', 'menus/siapp/referensi/pegawai.php', 1, '2011-01-26 18:06:06', '2011-04-14 11:15:00', 'abrarhedar'),
(42, 'Hari Libur/Cuti Bersama', 'Hari Libur/Cuti Bersama', 'left,top', 40, '1', '0,1,2', '', 'menus/siapp/referensi/libur.php', 2, '2011-01-26 18:07:31', '2011-04-14 11:15:49', 'abrarhedar'),
(44, 'Jenis Absensi', 'Jenis Absensi', 'left,top', 40, '0', '0,1,2', '', 'menus/siapp/referensi/alasan.php', 5, '2011-01-26 18:10:29', '2013-06-26 11:09:39', 'abrarhedar'),
(45, 'Unit Kerja', 'Unit Kerja', 'left,top', 40, '0', '0,1,2', '', 'menus/siapp/referensi/unit.php', 6, '2011-01-26 18:12:05', '2013-06-26 11:09:51', 'abrarhedar'),
(46, 'Bidang', 'Bidang', 'left,top', 40, '0', '0,1,2', '', 'menus/siapp/referensi/bidang.php', 7, '2011-01-26 18:12:37', '2013-06-26 11:10:05', 'abrarhedar'),
(47, 'Daftar Pengguna', 'Daftar Pengguna', 'left,top', 55, '1', '0', '', 'menus/siapp/pengguna/user.php', 1, '2011-01-26 18:15:35', '2011-04-14 11:17:26', 'abrarhedar'),
(48, 'Ubah Password', 'Ubah Password', 'left,top', 55, '1', '0,1,2,3,4,5,6', '', 'menus/siapp/pengguna/password_ed.php', 2, '2011-01-26 19:16:03', '2012-04-16 09:32:18', 'abrarhedar'),
(49, 'List', 'Pengguna', 'sub', 47, '1', '0', '', 'menus/siapp/pengguna/user.php', 1, '2011-01-26 19:26:11', '2011-04-14 11:17:49', 'abrarhedar'),
(50, 'New', 'Pengguna', 'sub', 47, '1', '0', 'ed', 'menus/siapp/pengguna/user_ed.php', 2, '2011-01-26 19:27:35', '2011-04-14 11:17:59', 'abrarhedar'),
(51, 'Delete', 'Pengguna', 'sub', 47, '0', '0', 'del', 'menus/siapp/pengguna/user_del.php', 3, '2011-01-26 19:30:07', '2011-04-14 11:18:07', 'abrarhedar'),
(54, 'Delete', 'Pegawai', 'sub', 41, '0', '0,1,2', 'del', 'menus/siapp/referensi/pegawai_del.php', 2, '2011-01-26 20:42:18', '2013-04-18 19:07:05', 'abrarhedar'),
(55, 'Pengguna', 'Pengguna', 'left,top', 0, '1', '0,1,2,3,4,5,6', '', '', 5, '2011-01-27 19:23:08', '2013-06-26 11:03:41', 'abrarhedar'),
(59, 'Absensi Pegawai', 'Absensi Pegawai', 'left,top', 28, '1', '0,1,2', '', 'menus/siapp/presensi/absensi.php', 9, '2011-02-01 19:32:16', '2013-02-25 13:33:48', 'abrarhedar'),
(63, 'Setting Unit Kerja', 'Setting Unit Kerja', 'left,top', 37, '1', '0', '', 'menus/siapp/setup/setting_unit.php', 3, '2011-02-09 19:22:18', '2011-02-10 09:22:42', 'abrarhedar'),
(64, 'Split Presensi', 'Split Presensi', 'left,top', 37, '1', '0', '', 'menus/siapp/setup/split_presensi.php', 4, '2011-04-13 00:25:27', '2011-04-13 15:25:27', 'abrarhedar'),
(65, 'Hapus Hari Libur', 'Hapus Hari Libur', 'left,top', 37, '1', '0', '', 'menus/siapp/setup/sabtu_minggu.php', 5, '2011-04-13 21:08:26', '2011-04-14 12:08:26', 'abrarhedar'),
(66, 'Golongan', 'Golongan', 'left,top', 37, '1', '0', '', 'menus/siapp/setup/golongan.php', 6, '2011-04-24 21:12:55', '2011-04-25 12:12:55', 'abrarhedar'),
(67, 'Rekapitulasi Presensi', 'Rekapitulasi Presensi', 'left,top', 28, '1', '6', '', 'menus/siapp/presensi/rekapitulasi_staf.php', 7, '2012-03-27 19:04:51', '2013-02-25 13:32:46', 'abrarhedar'),
(68, 'Presensi Pegawai', 'Presensi Pegawai', 'left,top', 28, '0', '0', '', 'menus/siapp/presensi/presensi_staf.php', 4, '2012-03-27 19:05:39', '2013-07-12 22:27:22', 'abrarhedar'),
(70, 'Rekapitulasi Presensi', 'Rekapitulasi Presensi', 'left,top', 28, '0', '0', '', 'menus/siapp/presensi/rekapitulasi_struktural.php', 6, '2012-04-15 19:46:25', '2013-07-12 22:28:17', 'abrarhedar'),
(71, 'Presensi Pegawai', 'Presensi Pegawai', 'left,top', 28, '0', '0', '', 'menus/siapp/presensi/presensi_struktural.php', 3, '2012-04-15 19:55:02', '2013-07-12 22:25:01', 'abrarhedar'),
(72, 'Tunjangan Kinerja', 'Tunjangan Kinerja', 'left,top', 28, '1', '0,1,2', '', 'menus/siapp/presensi/tunjangan_kinerja.php', 8, '2012-09-10 20:55:30', '2013-03-05 16:40:23', 'abrarhedar'),
(73, 'Pemeliharaan', 'Pemeliharaan', 'left,top', 0, '1', '0', '', '', 6, '2012-11-12 08:17:36', '2013-06-26 11:03:03', 'abrarhedar'),
(74, 'Data kosong double', 'Penghapusan data kosong double', 'left,top', 73, '1', '0', '', 'menus/siapp/pemeliharaan/data_double.php', 0, '2012-11-12 08:18:30', '2012-11-12 22:18:30', 'budipras'),
(75, 'Kekurangan Waktu', 'Kekurangan Waktu', 'left,top', 73, '1', '0', '', 'menus/siapp/pemeliharaan/kekurangan_waktu.php', 1, '2012-11-12 09:19:24', '2012-11-13 09:49:33', 'budipras'),
(76, 'Kehadiran', 'Kehadiran', 'left,top', 73, '1', '0', '', 'menus/siapp/pemeliharaan/kehadiran.php', 2, '2012-11-12 19:50:19', '2012-11-13 09:50:19', 'budipras'),
(77, 'Tambah Pegawai', 'Pegawai', 'sub', 41, '0', '0,1,2', 'ed', 'menus/siapp/referensi/pegawai_ed.php', 1, '2013-01-07 01:17:06', '2013-01-07 15:17:06', 'abrarhedar'),
(78, 'Cuti Tahunan', 'Cuti Tahunan', 'left,top', 40, '1', '0,1,2,3,4,5,6', '', 'menus/siapp/referensi/cuti.php', 3, '2013-02-24 23:36:43', '2013-07-16 17:43:43', 'abrarhedar'),
(79, 'Pegawai SIK', 'Pegawai SIK', 'left,top', 40, '1', '0', '', 'menus/siapp/referensi/pegawai_sik.php', 4, '2013-03-19 02:44:49', '2013-06-26 11:06:31', 'abrarhedar'),
(80, 'Keluar Sementara', 'Keluar Sementara', 'left,top', 28, '1', '0,1,2', '', 'menus/siapp/presensi/keluar_sementara.php', 10, '2013-04-04 04:47:08', '2013-06-26 11:01:47', 'abrarhedar'),
(81, 'Keluar Sementara', 'Keluar Sementara', 'sub', 80, '0', '0,1,2', 'ed', 'menus/siapp/presensi/keluar_sementara_add.php', 1, '2013-04-04 04:48:47', '2013-04-04 18:48:47', 'abrarhedar'),
(82, 'Upacara Bendera', 'Upacara Bendera', 'left,top', 28, '1', '0,1,2', '', 'menus/siapp/presensi/upacara.php', 11, '2013-04-09 04:36:48', '2013-06-26 11:02:10', 'abrarhedar'),
(83, 'Pegawai Tidak Mengikuti Upacara Bendera', 'Pegawai Tidak Mengikuti Upacara Bendera', 'sub', 82, '0', '0,1,2', 'ed', 'menus/siapp/presensi/tidak_hadir_upacara.php', 1, '2013-04-09 04:38:54', '2013-04-09 18:38:54', 'abrarhedar'),
(84, 'Cek Data Trible', 'Cek Data Trible', 'left,top', 73, '1', '0', '', 'menus/siapp/pemeliharaan/cek_data_trible.php', 4, '2013-05-22 07:08:31', '2013-05-22 21:14:22', 'abrarhedar'),
(96, 'Jenis Shift', 'Jenis Shift', 'left,top', 107, '1', '0', '', 'menus/siapp/shift/jenis_shift.php', 1, '2013-06-07 03:00:38', '2013-06-26 11:07:03', 'abrarhedar'),
(97, 'Jadwal Shift', 'Jadwal Shift', 'left,top', 107, '1', '0,1,2', '', 'menus/siapp/shift/jadwal_shift.php', 5, '2013-06-07 03:03:10', '2013-06-27 10:39:01', 'abrarhedar'),
(101, 'edit form', 'edit form', 'sub', 55, '0', '0,1,2', 'ed', 'menus/siapp/referensi/jadwal_shift_ed_form.php', 4, '2013-06-10 03:48:48', '2013-06-10 17:49:58', 'tes'),
(102, 'Jam Kerja Shift', 'Jam Kerja Shift', 'left,top', 107, '1', '0', '', 'menus/siapp/shift/jam_kerja_shift.php', 2, '2013-06-10 07:46:02', '2013-06-26 11:07:32', 'abrarhedar'),
(103, 'Pegawai Shift', 'Pegawai Shift', 'left,top', 107, '1', '0,1,2', '', 'menus/siapp/shift/pegawai_shift.php', 4, '2013-06-11 04:16:26', '2013-06-27 10:38:46', 'abrarhedar'),
(104, 'Kelompok/Regu Shift', 'Kelompok/Regu Shift', 'left,top', 107, '1', '0', '', 'menus/siapp/shift/regu_shift.php', 3, '2013-06-13 23:53:12', '2013-06-26 11:08:15', 'abrarhedar'),
(105, 'Jadwal Shift', 'Ubah Jadwal Shift', 'sub', 97, '0', '0,1,2', '', 'menus/siapp/shift/jadwal_shift_ed.php', 1, '2013-06-23 21:53:25', '2013-06-27 10:39:42', 'abrarhedar'),
(106, 'Jadwal Shift', 'Hapus Jadwal Shift', 'sub', 97, '0', '0,1,2', 'del', 'menus/siapp/shift/jadwal_shift_del.php', 2, '2013-06-25 00:31:40', '2013-06-27 10:39:53', 'abrarhedar'),
(107, 'Shift', 'Shift', 'left,top', 0, '1', '0,1,2', '', '', 3, '2013-06-26 04:05:12', '2013-06-27 10:39:12', 'abrarhedar');

INSERT INTO `xmenu` (`id`, `name`, `title`, `type`, `parent`, `published`, `action`, `src`, `ordering`) VALUES
(1, 'Home', 'Home', 'top', NULL, '1', '', 'includes/home.php', 1),
(2, 'System', 'System', 'left,top', NULL, '1', '', '', 99),
(3, 'Menu Manager', 'Menu Manager', 'left,top', 2, '1', '', 'menus/system/menu.php', 1),
(4, 'New', 'Menu', 'sub', 3, '1', 'ed', 'menus/system/menu_ed.php', 2),
(5, 'Menu Delete', 'Menu Delete', 'sub', 3, '0', 'del', 'menus/system/menu_del.php', 3)

(6, 'Level Manager', 'Level Manager', 'left,top', 2, '1', '0', '', 'menus/system/level.php', 2, '2010-10-24 18:54:37', '2010-12-23 14:21:44', 'abrarhedar'),
(7, 'List', 'Level Manager', 'sub', 6, '1', '0', '', 'menus/system/level.php', 1, '2010-10-24 18:55:47', '2010-12-22 15:51:43', 'abrarhedar'),
(8, 'New', 'Level', 'sub', 6, '1', '0', 'ed', 'menus/system/level_ed.php', 2, '2010-10-24 18:56:24', '2010-12-23 09:54:00', 'abrarhedar'),
(9, 'Menu Delete', 'Menu Delete', 'sub', 3, '0', '0', 'del', 'menus/system/menu_del.php', 3, '2010-10-24 18:58:06', '2010-12-23 09:53:27', 'abrarhedar'),
(10, 'Level Delete', 'Level Delete', 'sub', 6, '0', '0', 'del', 'menus/system/level_del.php', 3, '2010-10-24 18:58:41', '2010-12-23 09:54:06', 'abrarhedar'),
(11, 'Manajemen Pengguna', 'Manajemen Pengguna', 'left,top', 2, '1', '0', '', 'menus/system/user.php', 3, '2010-10-24 19:04:35', '2013-06-04 22:23:13', 'abrarhedar'),
(12, 'List', 'User Manager', 'sub', 11, '1', '0', '', 'menus/system/user.php', 1, '2010-10-24 19:05:57', '2010-12-22 15:52:22', 'abrarhedar'),
(13, 'New', 'User', 'sub', 11, '1', '0', 'ed', 'menus/system/user_ed.php', 2, '2010-10-24 19:06:33', '2010-12-23 09:54:14', 'abrarhedar'),
(14, 'User Delete', 'User Delete', 'sub', 11, '0', '0', 'del', 'menus/system/user_del.php', 3, '2010-10-24 19:07:07', '2010-12-23 09:54:20', 'abrarhedar'),
(15, 'JS & CSS Manager', 'Javascript & CSS Manager', 'left,top', 2, '1', '0', '', 'menus/system/header.php', 4, '2010-10-24 20:04:13', '2010-12-22 15:53:23', 'abrarhedar'),
(16, 'List', 'Javascript & CSS Manager', 'sub', 15, '1', '0', '', 'menus/system/header.php', 1, '2010-10-24 20:23:21', '2010-12-22 15:53:36', 'abrarhedar'),
(17, 'New', 'Javascript & CSS', 'sub', 15, '1', '0', 'ed', 'menus/system/header_ed.php', 2, '2010-10-24 20:24:22', '2010-12-23 09:54:32', 'abrarhedar'),
(18, 'JS & CSS Delete', 'JS & CSS Delete', 'sub', 15, '0', '0', 'del', 'menus/system/header_del.php', 3, '2010-10-24 20:24:55', '2010-12-23 09:54:38', 'abrarhedar'),
(19, 'Modul Manager', 'Modul Manager', 'left,top', 2, '1', '0', '', 'menus/system/modul.php', 5, '2010-10-24 20:33:02', '2010-12-22 15:53:58', 'abrarhedar'),
(20, 'List', 'Modul Manager', 'sub', 19, '1', '0', '', 'menus/system/modul.php', 1, '2010-10-24 21:33:11', '2010-12-22 15:54:07', 'abrarhedar'),
(21, 'New', 'Modul', 'sub', 19, '1', '0', 'ed', 'menus/system/modul_ed.php', 2, '2010-10-24 21:33:52', '2010-12-23 09:54:49', 'abrarhedar'),
(22, 'Modul Delete', 'Modul Delete', 'sub', 19, '0', '0', 'del', 'menus/system/modul_del.php', 3, '2010-10-24 21:34:35', '2010-12-23 09:54:58', 'abrarhedar'),
(23, 'Ubah Password', 'Ubah Password', 'left,top', 2, '1', '0', '', 'menus/system/password_ed.php', 7, '2010-10-27 01:16:41', '2010-12-28 08:44:15', 'abrarhedar'),
(24, 'Configuration', 'Configuration', 'left,top', 2, '1', '0', '', 'menus/system/config.php', 6, '2010-12-27 18:43:38', '2010-12-28 08:44:02', 'abrarhedar'),
(25, 'List', 'Configuration', 'sub', 24, '1', '0', '', 'menus/system/config.php', 1, '2010-12-27 18:59:15', '2010-12-28 09:03:04', 'abrarhedar'),
(26, 'New', 'Configuration', 'sub', 24, '1', '0', 'ed', 'menus/system/config_ed.php', 2, '2010-12-27 19:02:08', '2010-12-28 09:02:32', 'abrarhedar'),
(27, 'Delete', 'Configuration', 'sub', 24, '0', '0', 'del', 'menus/system/config_del.php', 3, '2010-12-27 19:04:20', '2010-12-28 09:04:44', 'abrarhedar')