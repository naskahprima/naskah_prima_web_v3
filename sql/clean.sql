-- Clean SQL dump for naskah_prima database - COMPLETE VERSION
-- All data included: 46 journals, 113 schedules, 3 clients, 3 manuscripts

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- ===================================================================
-- TABLE: users
-- ===================================================================
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Naskah Prima', 'admin@naskahprima.com', '2025-11-07 01:44:24', '$2y$12$wQJPxPTLrDRVvhIyQtxtbuILJG.xrm/AZJtpHO1HP.jM9Y6oaqbyi', NULL, '2025-11-07 01:44:24', '2025-11-07 01:44:24');

-- ===================================================================
-- TABLE: clients
-- ===================================================================
INSERT INTO `clients` (`id`, `nama_lengkap`, `email`, `no_whatsapp`, `institusi`, `catatan_khusus`, `created_at`, `updated_at`) VALUES
(2, 'Ilhan Firmansyah', 'ilhanajahhh@gmail.com', '+62 858-9347-6228', 'Universitas Bina Sarana Informatika Depok', NULL, '2025-11-08 03:06:50', '2025-11-08 03:06:50'),
(3, 'Dipo Yudhis Rana', 'dipoyudhisrana@gmail.com', '+62 858-9347-6228', 'Universitas Bina Sarana Informatika', 'teman dari Ilhan Firmansyah', '2025-11-28 16:45:24', '2025-11-28 16:45:24'),
(4, 'Renaldi Putra Roris', '15230287@bsi.ac.id', '+62 858-9347-6228', 'Universitas Bina Sarana Informatika', 'Teman Ilham FIrmansyah', '2025-11-28 16:47:36', '2025-11-28 16:47:36');

-- ===================================================================
-- TABLE: mitra_jurnals - ALL 46 JOURNALS
-- ===================================================================
INSERT INTO `mitra_jurnals` (`id`, `nama_jurnal`, `kategori_sinta`, `jenis_bidang`, `link_jurnal`, `contact_person`, `no_contact`, `biaya_publikasi`, `estimasi_proses_bulan`, `frekuensi_terbit`, `status_kerjasama`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'JIRE - Jurnal Informatika dan Rekayasa Elektronik', 'Sinta 4', 'Teknologi', 'https://e-journal.stmiklombok.ac.id/index.php/jire', 'Muhamad Rodi, S.Kom.,M.Kom', '+62 87877419837', 400000.00, 1, 'Bulanan', 'Menunggu Respons', 'fastrack 300.000, publis biasa 400.000 total 1 jt :")', '2025-11-07 01:55:49', '2025-11-08 03:01:57'),
(2, 'JUTIK - Jurnal Teknologi Informasi dan Komputer', 'Sinta 6', 'Teknologi', 'https://jurnal.undhirabali.ac.id/index.php/jutik/index', 'Prastyadi Wibawa Rahayu, S.Kom., M.Kom', '0822-3310-5003', 100000.00, 1, 'Bulanan', 'Aktif', 'Publikasi Artikel: 100.000.00 (IDR)', '2025-11-07 02:00:41', '2025-11-10 02:44:29'),
(3, 'Jurnal Ilmiah Intech', 'Sinta 4', 'Teknologi', 'https://jurnal.umus.ac.id/index.php/intech', 'andiyulianto@gmail.com', NULL, NULL, 1, 'Bulanan', 'Menunggu Respons', NULL, '2025-11-07 02:12:30', '2025-11-08 02:58:27'),
(4, 'Jurnal SINTA: Sistem Informasi dan Teknologi Komputasi', 'Sinta 4', 'Teknologi', 'https://jurnalsinta.id/index.php/sinta/terbitan', 'editor@jurnalsinta.id', NULL, NULL, NULL, 'Triwulan', 'Menunggu Respons', 'Jurnal SINTA menerbitkan 4x setahun', '2025-11-07 02:17:15', '2025-11-09 22:50:04'),
(5, 'Jurnal Media Informatika', 'Sinta 5', 'Teknologi', 'https://ejournal.sisfokomtek.org/index.php/jumin', 'Sigit Namoramandailing', '+62 818-0557-1651', 449999.00, 1, 'Bulanan', 'Aktif', 'Frekuensi terbitan 2 Bulanan', '2025-11-07 02:23:15', '2025-11-09 22:46:35'),
(6, 'Jurnal Inovasi Pendidikan dan Teknologi Informasi (JIPTI)', 'Sinta 5', 'Teknologi', 'https://ejournal.ummuba.ac.id/index.php/JIPTI', 'Assist. Prof. Yogi Irdes Putra, S.Pd., M.Pd.T', '+62 852-7375-4788', 350000.00, 1, 'Bulanan', 'Aktif', '350k oke sih recomended', '2025-11-07 02:26:54', '2025-11-09 22:47:47'),
(7, 'SKANIKA: Sistem Komputer dan Teknik Informatika', 'Sinta 4', 'Teknologi', 'https://jom.fti.budiluhur.ac.id/index.php/SKANIKA/', 'Dr. Indra, S.Kom, M.T.I', '081280538101', 500000.00, 0, 'Bulanan', 'Aktif', NULL, '2025-11-07 02:33:10', '2025-11-26 18:26:04'),
(8, 'Antivirus: Jurnal Ilmiah Teknik Informatika', 'Sinta 5', 'Teknologi', 'https://ejournal.unisbablitar.ac.id/index.php/antivirus/issue/archive', 'Sri Lestanti', '085785426347', 200000.00, 1, 'Bulanan', 'Aktif', NULL, '2025-11-07 02:46:16', '2025-11-29 00:52:21'),
(9, 'Jurnal INTEK', 'Sinta 5', 'Teknologi', 'https://jurnal.umpwr.ac.id/intek', 'Wahju Tjahjo Saputro', NULL, 300000.00, 1, 'Bulanan', 'Menunggu Respons', NULL, '2025-11-07 02:53:49', '2025-11-08 02:58:53'),
(10, 'Jurnal Sistem Informasi (JUST-SI)', 'Sinta 5', 'Teknologi', 'https://just-si.ub.ac.id', 'Redaksi JUST-SI', '+62-341-577911', 200000.00, 1, 'Semesteran', 'Menunggu Respons', 'best recoment 200k', '2025-11-07 04:57:35', '2025-11-08 02:56:53'),
(11, 'JATI (Jurnal Mahasiswa Teknik Informatika)', 'Sinta 4', 'Teknologi', 'http://ejournal.itn.ac.id/index.php/jati', 'Joseph Dedy Irawan', '0811367463', 250000.00, 1, 'Bulanan', 'Aktif', 'publis pada: Februari, April, Juni, Agustus, Oktober, Desember', '2025-11-07 05:05:05', '2025-11-10 02:45:10'),
(12, 'Jurnal Pendidikan Teknologi Informasi dan Vokasional (JPTIV)', 'Sinta 5', 'Teknologi', 'https://jptiv.fkip.unila.ac.id/v2/index', 'Rangga Firdaus', NULL, NULL, 1, 'Bulanan', 'Menunggu Respons', NULL, '2025-11-07 05:48:30', '2025-11-09 22:32:05'),
(13, 'Jurnal Teknologi Informasi (JURTI)', 'Sinta 5', 'Teknologi', 'https://jurnal.una.ac.id/index.php/jurti', 'Muhammad Yasin Simargolang., M.Kom', '081268777854', -1.00, 1, 'Semesteran', 'Menunggu Respons', NULL, '2025-11-07 06:49:26', '2025-11-12 16:30:58'),
(14, 'Jurnal Informatika dan Bisnis', 'Sinta 5', 'Teknologi', 'https://jurnal.kwikkiangie.ac.id/index.php/JIB', 'joko.susilo@kwikkiangie.ac.id', '(021) 65307062', NULL, 1, 'Bulanan', 'Menunggu Respons', NULL, '2025-11-07 06:57:13', '2025-11-08 02:57:54'),
(15, 'Jurnal Teknik dan Sistem Komputer', 'Sinta 5', 'Teknologi', 'https://jim.teknokrat.ac.id/index.php/jtikom', 'jtikom@teknokrat.ac.id', NULL, 300000.00, 1, 'Semesteran', 'Menunggu Respons', NULL, '2025-11-09 04:08:57', '2025-11-12 16:25:09'),
(16, 'Format : Jurnal Ilmiah Teknik Informatika', 'Sinta 5', 'Teknologi', 'https://publikasi.mercubuana.ac.id/index.php/format', 'bagus.priambodo@mercubuana.ac.id', NULL, 250000.00, NULL, 'Semesteran', 'Aktif', NULL, '2025-11-09 04:13:18', '2025-11-13 00:05:42'),
(17, 'Jurnal Teknologi Informasi', 'Sinta 5', 'Teknologi', 'https://ejournal.urindo.ac.id/index.php/TI', 'Hadid Ushama Ilham', '0857-8029-7051', NULL, NULL, 'Semesteran', 'Aktif', NULL, '2025-11-09 04:18:25', '2025-11-09 22:27:30'),
(18, 'NJCA (Nusantara Journal of Computers)', 'Sinta 4', 'Teknologi', 'https://journal.csnu.or.id/index.php/njca/issue/archive', 'Moh. Ainol Yaqin', '+62 823-3216-5817', 249998.00, 1, 'Semesteran', 'Menunggu Respons', NULL, '2025-11-09 06:09:28', '2025-11-12 16:17:01'),
(19, 'Computatio: Journal of Computer Science', 'Sinta 4', 'Teknologi', 'https://journal.untar.ac.id/index.php/computatio/about', 'computatio@fti.untar.ac.id', NULL, 350000.00, NULL, 'Bulanan', 'Menunggu Respons', NULL, '2025-11-09 06:18:50', '2025-11-09 22:02:38'),
(20, 'Computer Engineering and Applications Journal', 'Sinta 4', 'Teknologi', 'https://comengapp.unsri.ac.id/index.php/comengapp/issue/view/48', 'comengappsupport@unsri.ac.id', NULL, 0.00, NULL, 'Semesteran', 'Tidak Aktif', NULL, '2025-11-09 06:27:41', '2025-11-09 21:57:43'),
(21, 'Journal of Computer System and Informatics (JoSYC)', 'Sinta 5', 'Teknologi', 'https://ejurnal.seminar-id.com/index.php/josyc/about/contact', 'seminar.id2020@gmail.com', NULL, 400000.00, NULL, 'Semesteran', 'Menunggu Respons', NULL, '2025-11-09 06:30:16', '2025-11-09 21:54:59'),
(22, 'Conten : Computer and Network Technology', 'Sinta 5', 'Teknologi', 'https://jurnal.bsi.ac.id/index.php/conten', 'suleman.sln@bsi.ac.id', '0895320266479', 400000.00, NULL, 'Semesteran', 'Menunggu Respons', NULL, '2025-11-09 06:34:00', '2025-11-09 21:53:41'),
(23, 'Informatics and Computer Engineering Journal', 'Sinta 5', 'Teknologi', 'https://jurnal.bsi.ac.id/index.php/ijec/issue/view/286', 'Nuzul Imam Fadlilah', '+62 822-2646-9795', 200000.00, NULL, 'Semesteran', 'Menunggu Respons', NULL, '2025-11-09 06:53:55', '2025-11-09 21:52:42'),
(24, 'Journal Computer Science and Information Systems : J-Cosys', 'Sinta 5', 'Teknologi', 'https://e-jurnal.dharmawacana.ac.id/index.php/JCO', 'M. Adie Syaputra', '6281272756181', 350000.00, 1, 'Semesteran', 'Menunggu Respons', NULL, '2025-11-09 06:58:06', '2025-11-09 21:51:17'),
(25, 'Journal of Students Research in Computer Science (JSRCS)', 'Sinta 5', 'Teknologi', 'https://ejurnal.ubharajaya.ac.id/index.php/JSRCS/about', 'Dr. Herlawati, S.Si., M.M., M.Kom', '08159805004', 300000.00, 1, 'Semesteran', 'Menunggu Respons', NULL, '2025-11-09 07:00:08', '2025-11-09 19:11:35'),
(26, 'JICTE (Journal of Information and Computer Education)', 'Sinta 5', 'Teknologi', 'https://jicte.umsida.ac.id/index.php/jicte', 'jicte@umsida.ac.id', NULL, 450000.00, NULL, 'Semesteran', 'Tidak Aktif', NULL, '2025-11-09 07:06:36', '2025-11-11 20:05:08'),
(27, 'JATISI (Jurnal Teknik Informatika dan Sistem Informasi)', 'Sinta 5', 'Teknologi', 'https://jurnal.mdp.ac.id/index.php/jatisi/index', 'jatisi@mdp.ac.id', '083149151537', 0.00, NULL, 'Triwulan', 'Aktif', NULL, '2025-11-12 17:24:00', '2025-11-26 18:30:10'),
(28, 'Jurnal Nasional Komputasi dan Teknologi Informasi(JNKTI)', 'Sinta 5', 'Teknologi', 'https://ojs.serambimekkah.ac.id/jnkti/index', 'Zulfan S.T., M.T', '081360353540', 399999.00, NULL, 'Bulanan', 'Aktif', NULL, '2025-11-12 17:29:16', '2025-11-13 00:04:32'),
(29, 'The Explore IT: Jurnal Keilmuan & Aplikasi Teknik Informatika', 'Sinta 5', 'Teknologi', 'https://jurnal.yudharta.ac.id/v2/index.php/EXPLORE-IT/about', 'Bapak Moch. Lutfi', '0816555065', 200000.00, NULL, 'Semesteran', 'Menunggu Respons', NULL, '2025-11-12 17:37:06', '2025-11-12 19:30:14'),
(30, 'Krea-TIF: Jurnal Teknik Informatika', 'Sinta 5', 'Teknologi', 'https://ejournal.uika-bogor.ac.id/index.php/krea-tif/index', 'Gibtha Fitri Laxmi', NULL, NULL, NULL, 'Semesteran', 'Menunggu Respons', NULL, '2025-11-12 17:42:41', '2025-11-12 19:27:31'),
(31, 'Jurnal Manajemen Informatika (JUMISTIK)', 'Sinta 5', 'Teknologi', 'https://ojs.amiklps.ac.id/index.php/home', 'admin@amiklps.ac.id', '+6281 340 048 615', 400000.00, 1, 'Semesteran', 'Menunggu Respons', 'caari di pee autohr pun ada wa dari kontak', '2025-11-12 17:53:20', '2025-11-12 19:26:08'),
(32, 'KERNEL: Jurnal Riset Inovasi Bidang Informatika', 'Sinta 5', 'Teknologi', 'https://ejurnal.itats.ac.id/kernel/index', 'muchamad.kurniawan@itats.ac.id', NULL, 350001.00, 1, 'Semesteran', 'Aktif', NULL, '2025-11-12 18:01:11', '2025-11-13 00:03:42'),
(33, 'Jurnal ilmiah Sistem Informasi dan Ilmu Komputer', 'Sinta 5', 'Teknologi', 'https://journal.sinov.id/index.php/juisik', 'Suwandi, S.E.,M.M', '083108502368', 500000.00, 0, 'Triwulan', 'Prospek', NULL, '2025-11-16 17:20:27', '2025-11-16 17:20:27'),
(34, 'Jurnal Ilmiah Teknik Informatika dan Komunikasi', 'Sinta 5', 'Teknologi', 'https://journal.sinov.id/index.php/juitik/index', 'Suwandi, S.E.,M.M', '083108502368', 500000.00, NULL, 'Bulanan', 'Menunggu Respons', NULL, '2025-11-16 17:26:23', '2025-11-16 21:53:22'),
(35, 'Jekin- Jurnal Teknik Informatika', 'Sinta 5', 'Teknologi', 'https://rumahjurnal.or.id/index.php/JEKIN', 'Debi Setiawan', '+6281297409136', 500000.00, 1, 'Bulanan', 'Menunggu Respons', NULL, '2025-11-16 17:30:56', '2025-11-16 21:53:02'),
(36, 'Journal Automation Computer Information System (JACIS)', 'Sinta 5', 'Teknologi', 'https://jacis.pubmedia.id/index.php/jacis', 'R. M. Herdian Bhakti', '6281990251989', 300000.00, 1, 'Bulanan', 'Aktif', NULL, '2025-11-16 19:05:55', '2025-11-17 17:03:47'),
(37, 'Jurnal Manajemen dan Teknologi Informasi(JMTI)', 'Sinta 5', 'Teknologi', 'https://ojs.mahadewa.ac.id/index.php/jmti', 'Gde Iwan Setiawan', '081338179550', 250.00, NULL, 'Bulanan', 'Menunggu Respons', NULL, '2025-11-16 19:08:53', '2025-11-16 21:52:06'),
(38, 'Jayakarta Journal of Informatics Management', 'Sinta 5', 'Teknologi', 'https://journal.stmikjayakarta.ac.id/index.php/JMIJayakarta', 'Rumadi Hartawan S.T.,M.Kom', NULL, NULL, NULL, 'Triwulan', 'Menunggu Respons', NULL, '2025-11-16 19:11:54', '2025-11-16 21:51:43'),
(39, 'JUISI: Jurnal Ilmiah Sistem Informasi', 'Sinta 5', 'Teknologi', 'https://ejurnal.provisi.ac.id/index.php/JUISI', 'Azeda', '+6287802003303', 250002.00, NULL, 'Triwulan', 'Aktif', 'fasatrack : Rp. 450.000', '2025-11-16 19:17:31', '2025-11-26 18:29:08'),
(40, 'Jurnal Informatika Dan Rekayasa Komputer (JAKAKOM)', 'Sinta 5', 'Teknologi', 'https://ejournal.unama.ac.id/index.php/jakakom', 'Despita Meisak, S.Kom, MSI', '082351654474', 350000.00, NULL, 'Semesteran', 'Aktif', NULL, '2025-11-16 20:29:55', '2025-11-26 18:30:56'),
(41, 'Impression: Jurnal Teknologi dan Informasi', 'Sinta 5', 'Teknologi', 'https://jurnal.risetilmiah.ac.id/index.php/jti', 'Dewi Sholeha, ST., M.T', '085361555506', 500000.00, NULL, 'Semesteran', 'Aktif', NULL, '2025-11-16 20:32:18', '2025-11-17 17:04:18'),
(42, 'Journal of Information System and Technology (JOINT)', 'Sinta 5', 'Teknologi', 'https://journal.uib.ac.id/index.php/joint', 'Hendi Sama', '+62811698280', NULL, NULL, 'Triwulan', 'Aktif', 'kontak 2 : +6282285005770', '2025-11-16 20:35:03', '2025-11-29 00:53:03'),
(43, 'IKRA-ITH INFORMATIKA', 'Sinta 5', 'Teknologi', 'https://journals.upi-yai.ac.id/index.php/ikraith-informatika/index', 'Sularso Budilaksono', '081218501558', NULL, NULL, 'Bulanan', 'Menunggu Respons', NULL, '2025-11-16 20:48:52', '2025-11-16 21:49:04'),
(44, 'JURNAL TEKNIK INFORMATIKA UNIS', 'Sinta 5', 'Teknologi', 'https://ejournal.unis.ac.id/index.php/jutis/index', 'Vina Septiana Windyasari', '081296010871', 0.00, 1, 'Semesteran', 'Menunggu Respons', NULL, '2025-11-16 20:54:52', '2025-11-16 21:46:28'),
(45, 'Jurnal Teknik Informatika dan Teknologi Informasi (JUTITI)', 'Sinta 5', 'Teknologi', 'https://journalshub.org/index.php/jutiti', NULL, NULL, 499997.00, NULL, 'Bulanan', 'Aktif', NULL, '2025-11-17 17:08:00', '2025-11-17 17:08:08'),
(46, 'Jurnal Teknik dan Sistem Komputer (JTIKOM)', 'Sinta 5', 'Teknologi', 'https://publikasi.teknokrat.ac.id/index.php/jtikom/authorfees', 'Mahendra Dewantoro, S.Kom.', NULL, 300000.00, NULL, 'Semesteran', 'Prospek', NULL, '2025-11-26 19:54:49', '2025-11-26 19:54:49');

-- ===================================================================
-- TABLE: jadwal_terbits - ALL 113 SCHEDULES
-- ===================================================================
INSERT INTO `jadwal_terbits` (`id`, `mitra_jurnal_id`, `bulan`, `volume_issue`, `catatan`, `created_at`, `updated_at`) VALUES
(1,1,'April',NULL,NULL,'2025-11-07 01:55:49','2025-11-07 01:55:49'),
(2,1,'November',NULL,NULL,'2025-11-07 01:55:49','2025-11-07 01:55:49'),
(3,2,'April',NULL,NULL,'2025-11-07 02:00:41','2025-11-07 02:00:41'),
(4,2,'Oktober',NULL,NULL,'2025-11-07 02:00:41','2025-11-07 02:00:41'),
(5,3,'November',NULL,'PENGIRIMAN ARTIKEL - 1 - 31 OKTOBER 2025','2025-11-07 02:12:30','2025-11-07 02:12:30'),
(6,4,'Januari',NULL,NULL,'2025-11-07 02:17:15','2025-11-07 02:17:15'),
(7,4,'April',NULL,NULL,'2025-11-07 02:17:15','2025-11-07 02:17:15'),
(8,4,'Juli',NULL,NULL,'2025-11-07 02:17:15','2025-11-07 02:17:15'),
(9,4,'Oktober',NULL,NULL,'2025-11-07 02:17:15','2025-11-07 02:17:15'),
(10,6,'April',NULL,NULL,'2025-11-07 02:26:54','2025-11-07 02:26:54'),
(11,6,'November',NULL,NULL,'2025-11-07 02:26:54','2025-11-07 02:26:54'),
(12,7,'Januari',NULL,NULL,'2025-11-07 02:33:10','2025-11-07 02:33:10'),
(13,7,'Juli',NULL,NULL,'2025-11-07 02:33:10','2025-11-07 02:33:10'),
(14,8,'Mei',NULL,NULL,'2025-11-07 02:46:16','2025-11-07 02:46:16'),
(15,8,'November',NULL,NULL,'2025-11-07 02:46:16','2025-11-07 02:46:16'),
(16,9,'Mei',NULL,NULL,'2025-11-07 02:53:49','2025-11-07 02:53:49'),
(17,9,'November',NULL,NULL,'2025-11-07 02:53:49','2025-11-07 02:53:49'),
(18,10,'Juli',NULL,NULL,'2025-11-07 04:57:35','2025-11-07 04:57:35'),
(19,10,'Desember',NULL,NULL,'2025-11-07 04:57:35','2025-11-07 04:57:35'),
(20,11,'Februari',NULL,NULL,'2025-11-07 05:05:05','2025-11-07 05:05:05'),
(21,11,'April',NULL,NULL,'2025-11-07 05:05:05','2025-11-07 05:05:05'),
(22,11,'Juni',NULL,NULL,'2025-11-07 05:05:05','2025-11-07 05:05:05'),
(23,11,'Agustus',NULL,NULL,'2025-11-07 05:05:05','2025-11-07 05:05:05'),
(24,11,'Oktober',NULL,NULL,'2025-11-07 05:05:05','2025-11-07 05:05:05'),
(25,11,'September',NULL,NULL,'2025-11-07 05:05:05','2025-11-07 05:05:05'),
(26,12,'Juli',NULL,NULL,'2025-11-07 05:48:30','2025-11-07 05:48:30'),
(27,12,'Desember',NULL,NULL,'2025-11-07 05:48:30','2025-11-07 05:48:30'),
(28,13,'Juni',NULL,NULL,'2025-11-07 06:49:26','2025-11-07 06:49:26'),
(29,13,'Desember',NULL,NULL,'2025-11-07 06:49:26','2025-11-07 06:49:26'),
(30,14,'Juni',NULL,NULL,'2025-11-07 06:57:13','2025-11-07 06:57:13'),
(31,14,'Desember',NULL,NULL,'2025-11-07 06:57:13','2025-11-07 06:57:13'),
(32,15,'Desember',NULL,NULL,'2025-11-09 04:08:57','2025-11-09 04:08:57'),
(33,15,'Juli',NULL,NULL,'2025-11-09 04:08:57','2025-11-09 04:08:57'),
(34,16,'Januari',NULL,NULL,'2025-11-09 04:13:18','2025-11-09 04:13:18'),
(35,16,'Juli',NULL,NULL,'2025-11-09 04:13:18','2025-11-09 04:13:18'),
(36,17,'Juni',NULL,NULL,'2025-11-09 04:18:25','2025-11-09 04:18:25'),
(37,17,'Desember',NULL,NULL,'2025-11-09 04:18:26','2025-11-09 04:18:26'),
(38,18,'Juni',NULL,NULL,'2025-11-09 06:09:28','2025-11-09 06:09:28'),
(39,18,'Desember',NULL,NULL,'2025-11-09 06:09:28','2025-11-09 06:09:28'),
(40,19,'April',NULL,NULL,'2025-11-09 06:18:50','2025-11-09 06:18:50'),
(41,19,'Oktober',NULL,NULL,'2025-11-09 06:18:50','2025-11-09 06:18:50'),
(42,20,'Februari',NULL,NULL,'2025-11-09 06:27:41','2025-11-09 06:27:41'),
(43,20,'Juni',NULL,NULL,'2025-11-09 06:27:41','2025-11-09 06:27:41'),
(44,20,'Oktober',NULL,NULL,'2025-11-09 06:27:41','2025-11-09 06:27:41'),
(45,21,'Februari',NULL,NULL,'2025-11-09 06:30:16','2025-11-09 06:30:16'),
(46,21,'Mei',NULL,NULL,'2025-11-09 06:30:16','2025-11-09 06:30:16'),
(47,21,'Agustus',NULL,NULL,'2025-11-09 06:30:16','2025-11-09 06:30:16'),
(48,22,'Juni',NULL,NULL,'2025-11-09 06:34:00','2025-11-09 06:34:00'),
(49,22,'Desember',NULL,NULL,'2025-11-09 06:34:00','2025-11-09 06:34:00'),
(50,23,'Februari',NULL,NULL,'2025-11-09 06:53:55','2025-11-09 06:53:55'),
(51,23,'Agustus',NULL,NULL,'2025-11-09 06:53:55','2025-11-09 06:53:55'),
(52,24,'Maret',NULL,NULL,'2025-11-09 06:58:06','2025-11-09 06:58:06'),
(53,24,'September',NULL,NULL,'2025-11-09 06:58:06','2025-11-09 06:58:06'),
(54,25,'Mei',NULL,NULL,'2025-11-09 07:00:08','2025-11-09 07:00:08'),
(55,25,'November',NULL,NULL,'2025-11-09 07:00:08','2025-11-09 07:00:08'),
(56,26,'April',NULL,NULL,'2025-11-09 07:06:36','2025-11-09 07:06:36'),
(57,26,'Oktober',NULL,NULL,'2025-11-09 07:06:36','2025-11-09 07:06:36'),
(58,27,'Maret',NULL,NULL,'2025-11-12 17:24:00','2025-11-12 17:24:00'),
(59,27,'Juni',NULL,NULL,'2025-11-12 17:24:00','2025-11-12 17:24:00'),
(60,27,'September',NULL,NULL,'2025-11-12 17:24:00','2025-11-12 17:24:00'),
(61,27,'Desember',NULL,NULL,'2025-11-12 17:24:00','2025-11-12 17:24:00'),
(62,28,'Februari',NULL,NULL,'2025-11-12 17:29:16','2025-11-12 17:29:16'),
(63,28,'April',NULL,NULL,'2025-11-12 17:29:16','2025-11-12 17:29:16'),
(64,28,'Juni',NULL,NULL,'2025-11-12 17:29:16','2025-11-12 17:29:16'),
(65,28,'Agustus',NULL,NULL,'2025-11-12 17:29:16','2025-11-12 17:29:16'),
(66,28,'Oktober',NULL,NULL,'2025-11-12 17:29:16','2025-11-12 17:29:16'),
(67,28,'Desember',NULL,NULL,'2025-11-12 17:29:16','2025-11-12 17:29:16'),
(68,29,'Juni',NULL,NULL,'2025-11-12 17:37:06','2025-11-12 17:37:06'),
(69,29,'Desember',NULL,NULL,'2025-11-12 17:37:06','2025-11-12 17:37:06'),
(70,30,'Mei',NULL,NULL,'2025-11-12 17:42:41','2025-11-12 17:42:41'),
(71,30,'November',NULL,NULL,'2025-11-12 17:42:41','2025-11-12 17:42:41'),
(72,31,'Juni',NULL,NULL,'2025-11-12 17:53:20','2025-11-12 17:53:20'),
(73,31,'Desember',NULL,NULL,'2025-11-12 17:53:20','2025-11-12 17:53:20'),
(74,32,'Juli',NULL,NULL,'2025-11-12 18:01:11','2025-11-12 18:01:11'),
(75,32,'Desember',NULL,NULL,'2025-11-12 18:01:11','2025-11-12 18:01:11'),
(76,33,'Maret',NULL,NULL,'2025-11-16 17:20:27','2025-11-16 17:20:27'),
(77,33,'Juli',NULL,NULL,'2025-11-16 17:20:27','2025-11-16 17:20:27'),
(78,33,'November',NULL,NULL,'2025-11-16 17:20:27','2025-11-16 17:20:27'),
(79,34,'Maret',NULL,NULL,'2025-11-16 17:26:23','2025-11-16 17:26:23'),
(80,34,'Juli',NULL,NULL,'2025-11-16 17:26:23','2025-11-16 17:26:23'),
(81,34,'November',NULL,NULL,'2025-11-16 17:26:23','2025-11-16 17:26:23'),
(82,35,'Maret',NULL,NULL,'2025-11-16 17:30:56','2025-11-16 17:30:56'),
(83,35,'Juli',NULL,NULL,'2025-11-16 17:30:56','2025-11-16 17:30:56'),
(84,35,'November',NULL,NULL,'2025-11-16 17:30:56','2025-11-16 17:30:56'),
(85,36,'Juni',NULL,NULL,'2025-11-16 19:05:55','2025-11-16 19:05:55'),
(86,36,'November',NULL,NULL,'2025-11-16 19:05:55','2025-11-16 19:05:55'),
(87,37,'April',NULL,NULL,'2025-11-16 19:08:53','2025-11-16 19:08:53'),
(88,37,'Oktober',NULL,NULL,'2025-11-16 19:08:53','2025-11-16 19:08:53'),
(89,38,'Februari',NULL,NULL,'2025-11-16 19:11:54','2025-11-16 19:11:54'),
(90,38,'April',NULL,NULL,'2025-11-16 19:11:54','2025-11-16 19:11:54'),
(91,38,'September',NULL,NULL,'2025-11-16 19:11:54','2025-11-16 19:11:54'),
(92,38,'November',NULL,NULL,'2025-11-16 19:11:54','2025-11-16 19:11:54'),
(93,39,'Januari',NULL,NULL,'2025-11-16 19:17:31','2025-11-16 19:17:31'),
(94,39,'Mei',NULL,NULL,'2025-11-16 19:17:31','2025-11-16 19:17:31'),
(95,39,'November',NULL,NULL,'2025-11-16 19:17:31','2025-11-16 19:17:31'),
(96,40,'September',NULL,NULL,'2025-11-16 20:29:55','2025-11-16 20:29:55'),
(97,40,'April',NULL,NULL,'2025-11-16 20:29:55','2025-11-16 20:29:55'),
(98,41,'Maret',NULL,NULL,'2025-11-16 20:32:18','2025-11-16 20:32:18'),
(99,41,'Juli',NULL,NULL,'2025-11-16 20:32:18','2025-11-16 20:32:18'),
(100,41,'November',NULL,NULL,'2025-11-16 20:32:18','2025-11-16 20:32:18'),
(101,42,'Maret',NULL,NULL,'2025-11-16 20:35:03','2025-11-16 20:35:03'),
(102,42,'Juli',NULL,NULL,'2025-11-16 20:35:03','2025-11-16 20:35:03'),
(103,42,'November',NULL,NULL,'2025-11-16 20:35:03','2025-11-16 20:35:03'),
(104,43,'Juli',NULL,NULL,'2025-11-16 20:48:52','2025-11-16 20:48:52'),
(105,43,'Maret',NULL,NULL,'2025-11-16 20:48:52','2025-11-16 20:48:52'),
(106,43,'November',NULL,NULL,'2025-11-16 20:48:52','2025-11-16 20:48:52'),
(107,44,'April',NULL,NULL,'2025-11-16 20:54:52','2025-11-16 20:54:52'),
(108,44,'November',NULL,NULL,'2025-11-16 20:54:52','2025-11-16 20:54:52'),
(109,45,'April',NULL,NULL,'2025-11-17 17:08:00','2025-11-17 17:08:00'),
(110,45,'Agustus',NULL,NULL,'2025-11-17 17:08:00','2025-11-17 17:08:00'),
(111,45,'Desember',NULL,NULL,'2025-11-17 17:08:00','2025-11-17 17:08:00'),
(112,46,'Juni',NULL,NULL,'2025-11-26 19:54:49','2025-11-26 19:54:49'),
(113,46,'Desember',NULL,NULL,'2025-11-26 19:54:49','2025-11-26 19:54:49');

-- ===================================================================
-- TABLE: message_templates - ALL 6 TEMPLATES
-- ===================================================================
INSERT INTO `message_templates` (`id`, `name`, `category`, `template_text`, `variables`, `is_default`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Tanya Info Lengkap', 'jurnal', 'Selamat pagi/siang,\n\nSaya Zaky dari NaskahPrima, ingin menanyakan informasi terkait publikasi [nama_jurnal]\n\nMohon informasi mengenai:\n- Apakah masih tersedia slot publikasi untuk edisi dekat ini?\n- Kapan deadline submission untuk edisi tersebut?\n- Tanggal berapa kira-kira jurnal akan terbit?\n- Apakah ada opsi fast track? Jika ada, berapa biayanya?\n- Apakah memungkinkan untuk terbit bulan ini atau bulan depan?\n- Berapa biaya publikasi reguler?\n- Berapa estimasi waktu proses review?\n\nTerima kasih atas waktu dan perhatiannya.\n\nHormat saya,\nZaky\nNaskahPrima', '[\"nama_jurnal\", \"nama_contact\"]', 0, 'Template lengkap untuk tanya info pertama kali', '2025-11-09 18:46:15', '2025-11-16 21:45:13'),
(2, 'Tanya Jadwal Terbit', 'jurnal', 'Selamat pagi/siang, Bapak/Ibu [nama_contact],\n\nPerkenalkan, saya Zaky dari NaskahPrima.\n\nSaya ingin menanyakan jadwal publikasi untuk [nama_jurnal] di tahun ini.\nApakah sudah ada tanggal pasti atau perkiraan waktu terbit untuk edisi terdekat?\nDan, kapan batas akhir pengiriman naskah untuk edisi tersebut?\n\nTerima kasih atas waktu dan responnya.\n\nSalam hormat,\nZaky - NaskahPrima', '[\"nama_jurnal\", \"nama_contact\"]', 1, 'Template khusus tanya jadwal', '2025-11-09 18:46:15', '2025-11-16 21:48:17'),
(3, 'Submit Naskah Baru', 'jurnal', 'Selamat pagi/siang [nama_contact],\n\nSaya Zaky dari NaskahPrima.\n\nSaya ingin submit naskah untuk publikasi di [nama_jurnal].\n\nFile naskah akan saya kirim terpisah. Mohon informasi untuk langkah selanjutnya.\n\nTerima kasih.\n\nHormat saya,\nZaky - NaskahPrima', '[\"nama_jurnal\", \"nama_contact\"]', 0, 'Template untuk submit naskah baru', '2025-11-09 18:46:15', '2025-11-09 18:46:15'),
(4, 'Follow-up Review', 'jurnal', 'Selamat pagi/siang [nama_contact],\n\nSaya Zaky dari NaskahPrima.\n\nSaya ingin follow-up untuk naskah yang sudah kami submit.\n\nBagaimana progress review-nya?\n\nTerima kasih atas perhatiannya.\n\nSalam,\nZaky - NaskahPrima', '[\"nama_jurnal\", \"nama_contact\"]', 0, 'Template untuk follow-up', '2025-11-09 18:46:15', '2025-11-09 18:46:15'),
(6, 'Follow-up Menunggu Respons', 'jurnal', 'Selamat pagi/siang [nama_contact],\n\nSaya Zaky dari NaskahPrima.\n\nSebelumnya saya sudah menghubungi terkait publikasi di [nama_jurnal].\n\nMohon maaf mengganggu, apakah ada kesempatan untuk membahas lebih lanjut?\n\nSaya tunggu kabar baiknya.\n\nTerima kasih.\n\nSalam,\nZaky - NaskahPrima', NULL, 0, 'Template untuk Follow-up Menunggu Respons', '2025-11-09 19:03:01', '2025-11-12 19:15:42');

-- ===================================================================
-- TABLE: naskahs - ALL 3 MANUSCRIPTS
-- ===================================================================
INSERT INTO `naskahs` (`id`, `judul_naskah`, `client_id`, `mitra_jurnal_id`, `bidang_topik`, `tanggal_masuk`, `target_bulan_publish`, `status`, `tanggal_published`, `biaya_dibayar`, `file_naskah`, `catatan_progress`, `created_at`, `updated_at`) VALUES
(2, 'ANALISIS SENTIMEN RESPON PENGGUNA CHAT GPT MENGGUNAKAN ALGORITMA SUPPORT VECTOR MACHINE', 2, 6, 'ALGORITMA SUPPORT VECTOR MACHINE', '2025-11-05', 'desember 2025', 'Published', '2025-11-25', 550000.00, 'naskah-files/01KB6DE8AN3NBGABVSCAK63AK0.docx', 'Done', '2025-11-08 05:11:23', '2025-11-28 16:40:42'),
(3, 'Analisis Sentimen Air Mineral dan Demineral Menggunakan SVM pada Dataset Tidak Seimbang', 3, 36, 'SVM', '2025-11-07', 'november', 'Published', '2025-11-29', 700000.00, 'naskah-files/01KB6E1PJAYFFQASA2BFVASTQ7.doc', 'Done', '2025-11-28 16:51:19', '2025-11-28 16:54:37'),
(4, 'Prediksi ISPU Jakarta Menggunakan Random Forest', 4, 36, 'Random Forest', '2025-11-17', 'november', 'Published', '2025-11-29', 700000.00, 'naskah-files/01KB6FS4KCMWRSJR5P93RE8Z9J.doc', 'done', '2025-11-28 17:21:35', '2025-11-28 17:22:11');

SET FOREIGN_KEY_CHECKS=1;