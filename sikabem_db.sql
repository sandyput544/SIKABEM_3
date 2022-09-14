/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.24-MariaDB : Database - sikabem_1
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sikabem_1` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `sikabem_1`;

/*Table structure for table `archives` */

DROP TABLE IF EXISTS `archives`;

CREATE TABLE `archives` (
  `kd_arsip` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kd_kategori` int(3) NOT NULL,
  `nomor_arsip` varchar(15) NOT NULL,
  `nama_arsip` varchar(128) NOT NULL,
  `nama_file` varchar(128) NOT NULL,
  `ukuran_file` varchar(15) NOT NULL,
  `mime` varchar(255) NOT NULL,
  `tgl_buat` date NOT NULL,
  `nama_pembuat` varchar(128) NOT NULL,
  `id_uploader` int(11) NOT NULL,
  `id_contributor` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`kd_arsip`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `archives` */

insert  into `archives`(`kd_arsip`,`kd_kategori`,`nomor_arsip`,`nama_arsip`,`nama_file`,`ukuran_file`,`mime`,`tgl_buat`,`nama_pembuat`,`id_uploader`,`id_contributor`,`created_at`,`updated_at`,`deleted_at`) values (13,2,'001/LPJ/XI/2022','LPJ Open Recruitment','1663055419_c71079d87661487137e1.pdf','0.161','application/pdf','2022-10-27','Pembuat Arsip',8,6,'2022-09-13 02:50:19','2022-09-13 02:50:19',NULL),(14,2,'002/LPJ/XI/2022','LPJ Makrab 2022','1663058934_e971b414153c1e007203.pdf','0.146','application/pdf','2022-12-03','Pembuat A',8,6,'2022-09-13 03:48:55','2022-09-13 04:45:52',NULL);

/*Table structure for table `archives_access` */

DROP TABLE IF EXISTS `archives_access`;

CREATE TABLE `archives_access` (
  `kd_akses` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kd_arsip` int(11) NOT NULL,
  `kd_user` int(11) NOT NULL,
  `tgl_akses` datetime NOT NULL,
  `keterangan` varchar(128) NOT NULL,
  PRIMARY KEY (`kd_akses`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `archives_access` */

insert  into `archives_access`(`kd_akses`,`kd_arsip`,`kd_user`,`tgl_akses`,`keterangan`) values (1,13,6,'2022-09-13 05:00:29','Lihat'),(2,13,6,'2022-09-13 05:01:45','Lihat'),(3,13,8,'2022-09-13 05:03:37','Lihat'),(4,13,8,'2022-09-13 05:03:45','Unduh'),(5,14,8,'2022-09-13 05:04:09','Lihat');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `kd_kategori` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kat` varchar(128) NOT NULL,
  `singkatan_kat` varchar(20) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`kd_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

insert  into `categories`(`kd_kategori`,`nama_kat`,`singkatan_kat`,`slug`,`created_at`,`updated_at`,`deleted_at`) values (2,'Laporan Pertanggungjawaban','LPJ','laporan-pertanggungjawaban','2022-08-25 17:26:22','2022-09-06 06:18:57',NULL),(5,'Surat Keputusan','SK','surat-keputusan','2022-08-25 17:34:11','2022-09-06 06:18:57',NULL),(7,'Notulensi','NOT','notulensi','2022-09-06 06:02:42','2022-09-12 11:57:28',NULL),(8,'Anggaran Dasar dan Anggaran Rumah Tangga','AD ART','anggaran-dasar-dan-anggaran-rumah-tangga','2022-09-12 12:48:12','2022-09-12 13:03:05',NULL);

/*Table structure for table `mail_type` */

DROP TABLE IF EXISTS `mail_type`;

CREATE TABLE `mail_type` (
  `kd_jenissurat` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `kode_surat` varchar(10) NOT NULL,
  `nama_jenis` varchar(30) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`kd_jenissurat`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `mail_type` */

insert  into `mail_type`(`kd_jenissurat`,`kode_surat`,`nama_jenis`,`created_at`,`updated_at`,`deleted_at`) values (4,'SK','Surat Keputusan','2022-09-03 06:37:12','2022-09-03 06:37:12',NULL),(5,'SP','Surat Peringatan','2022-09-03 06:37:34','2022-09-03 06:37:34',NULL),(6,'P','Surat Pengumuman','2022-09-03 07:04:16','2022-09-03 07:04:16',NULL);

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `kd_menu` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(128) NOT NULL,
  `url_menu` varchar(128) NOT NULL,
  `ikon_menu` varchar(30) NOT NULL,
  `menu_active` int(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`kd_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `menus` */

insert  into `menus`(`kd_menu`,`nama_menu`,`url_menu`,`ikon_menu`,`menu_active`,`created_at`,`updated_at`,`deleted_at`) values (1,'Dashboard','dashboard','bi-speedometer',1,'2022-09-13 19:31:10','2022-09-13 19:31:10',NULL),(2,'Master User','user','bi-people-fill',1,'2022-09-13 19:32:58','2022-09-13 19:32:58',NULL),(3,'Master Jabatan','jabatan','bi-diagram-2-fill',1,'2022-09-13 19:35:29','2022-09-13 19:35:29',NULL),(4,'Master Menu','menu','bi-menu-button-wide-fill',1,'2022-09-13 19:46:50','2022-09-13 19:46:50',NULL),(5,'Master Kategori','kategori','bi-bookmarks-fill',1,'2022-09-13 19:47:53','2022-09-13 19:47:53',NULL),(6,'Master Arsip','arsip','bi-archive-fill',1,'2022-09-13 19:49:06','2022-09-13 19:49:42',NULL),(7,'Surat Keluar','surat','bi-send-fill',1,'2022-09-13 19:51:32','2022-09-13 19:51:32',NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`version`,`class`,`group`,`namespace`,`time`,`batch`) values (1,'2022-07-13-100340','App\\Database\\Migrations\\Users','default','App',1661439597,1),(2,'2022-07-14-002222','App\\Database\\Migrations\\Positions','default','App',1661439598,1),(3,'2022-07-14-052222','App\\Database\\Migrations\\Menus','default','App',1661439598,1),(4,'2022-07-14-060420','App\\Database\\Migrations\\PositionMenu','default','App',1661439598,1),(5,'2022-07-14-063013','App\\Database\\Migrations\\Categories','default','App',1661439599,1),(6,'2022-07-14-072703','App\\Database\\Migrations\\Archives','default','App',1661439600,1),(7,'2022-08-25-124145','App\\Database\\Migrations\\ArchivesAccess','default','App',1661439676,2),(8,'2022-08-25-124221','App\\Database\\Migrations\\MailType','default','App',1661439676,2),(9,'2022-08-25-124234','App\\Database\\Migrations\\OutgoingMail','default','App',1661439677,2);

/*Table structure for table `outgoing_mail` */

DROP TABLE IF EXISTS `outgoing_mail`;

CREATE TABLE `outgoing_mail` (
  `kd_suratkeluar` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kd_jenissurat` int(3) NOT NULL,
  `nomor_surat` varchar(15) NOT NULL,
  `kd_user` int(11) NOT NULL,
  `tgl_buat` varchar(25) NOT NULL,
  `tgl_ttd` varchar(25) NOT NULL,
  `perihal` varchar(15) NOT NULL,
  `lampiran` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`kd_suratkeluar`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `outgoing_mail` */

insert  into `outgoing_mail`(`kd_suratkeluar`,`kd_jenissurat`,`nomor_surat`,`kd_user`,`tgl_buat`,`tgl_ttd`,`perihal`,`lampiran`,`created_at`,`updated_at`,`deleted_at`) values (3,5,'002/BEM/XI/2022',0,'2022-09-05','','','0','2022-09-05 04:07:47','2022-09-13 05:08:58','2022-09-13 05:08:58'),(5,4,'001/BEM/XI/2022',0,'','','','0','2022-09-06 04:49:42','2022-09-13 05:09:04','2022-09-13 05:09:04'),(6,4,'004/BEM/XI/2022',0,'','','','','2022-09-06 04:53:49','2022-09-13 05:09:11','2022-09-13 05:09:11'),(7,4,'005/BEM/XI/2022',0,'','','','','2022-09-06 04:55:05','2022-09-13 05:09:18','2022-09-13 05:09:18'),(8,5,'005/BEM/XII/202',0,'2022-12-07','','','0','2022-09-13 04:20:23','2022-09-13 05:09:25','2022-09-13 05:09:25'),(9,4,'001/BEM/I/2022',8,'2022-02-01','','Surat Keputusan','0','2022-09-13 05:10:30','2022-09-13 05:10:30',NULL),(10,4,'002/BEM/I/2022',8,'2022-01-04','','','','2022-09-13 07:32:46','2022-09-13 07:32:46',NULL),(11,4,'003/BEM/I/2022',8,'','','','','2022-09-13 07:34:01','2022-09-13 07:34:01',NULL),(12,4,'004/BEM/I/2022',8,'','','','','2022-09-13 07:35:56','2022-09-13 07:35:56',NULL),(13,4,'005/BEM/I/2022',8,'2022-01-06','','','','2022-09-13 07:37:47','2022-09-13 07:37:47',NULL);

/*Table structure for table `position_menu` */

DROP TABLE IF EXISTS `position_menu`;

CREATE TABLE `position_menu` (
  `kd_jabatan` int(2) NOT NULL,
  `kd_menu` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `position_menu` */

insert  into `position_menu`(`kd_jabatan`,`kd_menu`) values (9,1),(9,2),(9,3),(9,4),(9,5),(9,6),(9,7),(8,1),(8,6),(8,7),(7,7),(7,1),(7,6),(13,6),(13,1),(13,7),(13,5),(14,1),(14,6),(14,7);

/*Table structure for table `positions` */

DROP TABLE IF EXISTS `positions`;

CREATE TABLE `positions` (
  `kd_jabatan` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `nama_jbt` varchar(128) NOT NULL,
  `singkatan_jbt` varchar(30) NOT NULL,
  `jml_kursi` int(3) NOT NULL,
  `jbt_active` int(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`kd_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `positions` */

insert  into `positions`(`kd_jabatan`,`nama_jbt`,`singkatan_jbt`,`jml_kursi`,`jbt_active`,`created_at`,`updated_at`,`deleted_at`) values (6,'Pembina','Pembina',0,1,'2022-08-25 16:40:28','2022-09-12 14:53:31',NULL),(7,'Ketua','Ketua',0,1,'2022-08-25 16:40:57','2022-09-12 14:53:08',NULL),(8,'Wakil Ketua','Wakil',1,1,'2022-08-25 16:41:18','2022-09-06 19:37:24',NULL),(9,'Sekretaris Jenderal','Sekjend',0,1,'2022-08-25 16:41:41','2022-09-12 14:53:59',NULL),(13,'Kepala Departemen Administrasi dan Kesekretariatan','Ka Dept. ADKES',1,1,'2022-09-12 13:36:18','2022-09-12 13:36:18',NULL),(14,'Deputi Persidangan','Dept Persidangan',1,1,'2022-09-12 13:37:05','2022-09-12 13:37:05',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `kd_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kd_jabatan` int(2) NOT NULL,
  `nama_user` varchar(128) NOT NULL,
  `tmp_lahir` varchar(80) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jk` enum('Pria','Wanita') NOT NULL,
  `agama` enum('Buddha','Hindhu','Islam','Katholik','Konghucu','Kristen Protestan') NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `password_hash` varchar(128) NOT NULL,
  `foto` varchar(128) DEFAULT NULL,
  `user_active` int(1) NOT NULL,
  `is_login` int(1) NOT NULL,
  `log_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`kd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`kd_user`,`kd_jabatan`,`nama_user`,`tmp_lahir`,`tgl_lahir`,`jk`,`agama`,`no_hp`,`alamat`,`email`,`password`,`password_hash`,`foto`,`user_active`,`is_login`,`log_date`,`created_at`,`updated_at`,`deleted_at`) values (6,6,'User Pembina',NULL,NULL,'Pria','Buddha','',NULL,'user_pembina@mail.com','12345678','$2y$10$SJMM3A5Iqhd3P6LfywmIDumo2ZCaJ1k14teD5hl3BmzGW.dAneFBi','default.svg',1,0,NULL,'2022-09-12 13:33:58','2022-09-13 05:01:54',NULL),(7,7,'User Ketua',NULL,NULL,'Wanita','Buddha','',NULL,'user_ketua@mail.com','12345678','$2y$10$tv7BKFxyMh9LyPE0pOhoW.8vXKMyzBiMhT6TkXAhB3tfPoOe/JN2K','default.svg',1,0,NULL,'2022-09-12 13:34:44','2022-09-13 18:52:04',NULL),(8,9,'User Sekjend','Cilacap','2000-07-13','Pria','Islam','081211114343','Jl. Kemerdekaan No. 12 RT 04 RW 04','user_sekjend@mail.com','11111','$2y$10$7HSTbCIOIRXg.YvFGsmm1uOZTXzT4Klz6a3n1colNi1EHIYdLvkyi','1663044354_f511c31a7864a1ded97c.png',1,1,'2022-09-13 23:03:11','2022-09-12 13:35:25','2022-09-13 23:03:11',NULL),(10,0,'',NULL,NULL,'Pria','Buddha','',NULL,'','','',NULL,0,0,NULL,'2022-09-13 15:33:55','2022-09-13 15:33:55',NULL),(11,0,'',NULL,NULL,'Pria','Buddha','',NULL,'','','',NULL,0,0,NULL,'2022-09-13 15:33:55','2022-09-13 15:33:55',NULL),(12,0,'',NULL,NULL,'Pria','Buddha','',NULL,'','','',NULL,0,0,NULL,'2022-09-13 16:15:51','2022-09-13 16:15:51',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
