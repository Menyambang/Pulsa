/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.3.32-MariaDB-cll-lve : Database - u1068353_menyambang
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`u1068353_menyambang` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `u1068353_menyambang`;

/*Table structure for table `m_banner` */

DROP TABLE IF EXISTS `m_banner`;

CREATE TABLE `m_banner` (
  `bnrId` int(11) NOT NULL AUTO_INCREMENT,
  `bnrDeskripsi` text DEFAULT NULL,
  `bnrGambar` varchar(40) DEFAULT NULL,
  `bnrUrl` varchar(200) DEFAULT NULL,
  `bnrCreatedAt` datetime DEFAULT current_timestamp(),
  `bnrUpdatedAt` datetime DEFAULT current_timestamp(),
  `bnrDeletedAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`bnrId`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `m_banner` */

insert  into `m_banner`(`bnrId`,`bnrDeskripsi`,`bnrGambar`,`bnrUrl`,`bnrCreatedAt`,`bnrUpdatedAt`,`bnrDeletedAt`) values 
(16,'-','20220119110203.jpg','https://menyambang.id','2022-01-19 22:02:03','2022-01-19 22:02:03',NULL),
(17,'-','20220119110223.jpg','https://menyambang.id','2022-01-19 22:02:23','2022-01-19 22:02:23',NULL),
(18,'-','20220119110238.jpg','https://menyambang.id','2022-01-19 22:02:38','2022-01-19 22:02:38',NULL);

/*Table structure for table `m_kategori` */

DROP TABLE IF EXISTS `m_kategori`;

CREATE TABLE `m_kategori` (
  `ktgId` int(11) NOT NULL AUTO_INCREMENT,
  `ktgNama` varchar(40) DEFAULT NULL,
  `ktgIcon` varchar(40) DEFAULT NULL,
  `ktgCreatedAt` datetime DEFAULT current_timestamp(),
  `ktgUpdatedAt` datetime DEFAULT current_timestamp(),
  `ktgDeletedAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`ktgId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `m_kategori` */

insert  into `m_kategori`(`ktgId`,`ktgNama`,`ktgIcon`,`ktgCreatedAt`,`ktgUpdatedAt`,`ktgDeletedAt`) values 
(7,'Terbaru','20220119105827.png','2022-01-18 20:07:46','2022-01-18 20:07:46',NULL),
(8,'Elektronik','20220119105837.png','2022-01-18 20:08:03','2022-01-18 20:08:03',NULL),
(9,'Smartphone','20220119105845.png','2022-01-18 20:08:16','2022-01-18 20:08:16',NULL),
(11,'Keuangan','20220119105852.png','2022-01-18 20:08:43','2022-01-18 20:08:43',NULL),
(12,'Komputer & Laptop','20220119105901.png','2022-01-18 20:08:56','2022-01-18 20:08:56',NULL),
(13,'Rumah Tangga','20220119105908.png','2022-01-18 20:09:12','2022-01-18 20:09:12',NULL),
(14,'Travel & Entertainment','20220119105916.png','2022-01-18 20:09:28','2022-01-18 20:09:28',NULL);

/*Table structure for table `m_metode_pembayaran` */

DROP TABLE IF EXISTS `m_metode_pembayaran`;

CREATE TABLE `m_metode_pembayaran` (
  `mpbId` int(10) NOT NULL AUTO_INCREMENT,
  `mpbNama` varchar(20) DEFAULT NULL,
  `mpbDeskripsi` varchar(200) DEFAULT NULL,
  `mpbTipe` enum('bank_transfer','echannel','saldo') DEFAULT NULL,
  `mpbGambar` varchar(40) DEFAULT NULL,
  `mpbVaNumber` varchar(20) DEFAULT NULL,
  `mpbBank` enum('bni','bri','permata','bca') DEFAULT NULL,
  `mpbCreatedAt` datetime DEFAULT current_timestamp(),
  `mpbUpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `mpbDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`mpbId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `m_metode_pembayaran` */

insert  into `m_metode_pembayaran`(`mpbId`,`mpbNama`,`mpbDeskripsi`,`mpbTipe`,`mpbGambar`,`mpbVaNumber`,`mpbBank`,`mpbCreatedAt`,`mpbUpdatedAt`,`mpbDeletedAt`) values 
(1,'Menyambang Saldo','Transfer menggunakan saldo menyambang anda','saldo','menyambang.png','11111',NULL,'2022-01-29 10:36:56','2022-01-29 20:47:14',NULL),
(2,'BCA','Transfer ke rekeniing bang VA BCA','bank_transfer','bca.png','111111','bca','2022-01-29 10:28:23','2022-01-29 10:29:13',NULL),
(3,'Mandiri','Pembayaran via mandiri bill payment','echannel','mandiri.png','111111',NULL,'2022-01-29 10:28:23','2022-01-29 20:46:57',NULL),
(4,'BNI','Transfer ke rekeniing bang VA BNI','bank_transfer','bni.png','111111','bni','2022-01-29 10:28:23','2022-01-29 20:47:03',NULL),
(6,'BRI','Transfer ke rekeniing bang VA BRI','bank_transfer','bri.png','111111','bri','2022-01-29 10:28:23','2022-01-29 20:50:27',NULL),
(7,'Permata','Transfer ke rekeniing bang VA Permata','bank_transfer','permata.png',NULL,'permata','2022-01-29 20:49:45','2022-01-29 20:55:19','2022-01-29 21:54:34');

/*Table structure for table `m_notifikasi` */

DROP TABLE IF EXISTS `m_notifikasi`;

CREATE TABLE `m_notifikasi` (
  `noifId` int(11) NOT NULL AUTO_INCREMENT,
  `notifJudul` varchar(40) DEFAULT NULL,
  `notifPesan` text DEFAULT NULL,
  `notifTanggal` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`noifId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_notifikasi` */

/*Table structure for table `m_produk` */

DROP TABLE IF EXISTS `m_produk`;

CREATE TABLE `m_produk` (
  `produkId` varchar(15) NOT NULL,
  `produkNama` varchar(100) DEFAULT NULL,
  `produkDeskripsi` text DEFAULT NULL,
  `produkHarga` int(11) DEFAULT NULL,
  `produkStok` int(11) DEFAULT NULL,
  `produkHargaPer` varchar(10) DEFAULT NULL,
  `produkDiskon` double DEFAULT NULL,
  `produkBerat` double DEFAULT NULL COMMENT 'GRAM',
  `produkDilihat` int(11) DEFAULT NULL,
  `produkKategoriId` int(11) DEFAULT NULL,
  `produkCreatedAt` datetime DEFAULT current_timestamp(),
  `produkUpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `produkDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`produkId`),
  KEY `m_produk_ibfk_1` (`produkKategoriId`),
  CONSTRAINT `m_produk_ibfk_1` FOREIGN KEY (`produkKategoriId`) REFERENCES `m_kategori` (`ktgId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_produk` */

insert  into `m_produk`(`produkId`,`produkNama`,`produkDeskripsi`,`produkHarga`,`produkStok`,`produkHargaPer`,`produkDiskon`,`produkBerat`,`produkDilihat`,`produkKategoriId`,`produkCreatedAt`,`produkUpdatedAt`,`produkDeletedAt`) values 
('K001','L\'Oreal Paris Total Repair 5 Shampoo 620mL + Rapid Reviver Conditioner','Paket terdiri dari:\r\n\r\n1pcs L\'Oreal Paris Total Repair 5 Shampoo 620 mL\r\n1pcs LOreal Paris Elseve Rapid Reviver Treatment Conditioner 150 mL\r\n\r\nL\'Oreal Paris Total Repair 5 Shampoo merupakan shampoo khusus rambut rusak. Diperkaya dengan Ceramide, replika bahan alami rambut, formula Total Repair 5 membantu memperbaiki titik kerusakan dan struktur pada rambut sekaligus merawat kekuatan batang rambut.\r\n\r\nL\'Oreal Paris Total Repair 5 Shampoo membantu melawan 5 tanda kerusakan pada rambut: patah, kering, kusam, rapuh, bercabang.',52,9999,'',68,1000,NULL,7,'2022-01-19 22:10:36','2022-01-27 19:05:50',NULL),
('K002','BREYLEE Step 1 Blackhead Remover Mask - Pembersih Komedo (17ml) - Breylee Step 1','-',32000,77,'/pcs',60,300,NULL,13,'2022-01-26 20:31:10','2022-01-27 19:05:58',NULL),
('K003','Kabel Data Xiaomi Fast Charging Ori USB Original 100% Xiaomi Micro USB','-',10000,99,'',10,3000,NULL,12,'2022-01-27 22:37:28','2022-01-27 22:37:28',NULL),
('K0033','NATUR-E DAILY NOURISHING - MOISTURIZING ','-',10000,99,'',1,100,NULL,7,'2022-01-19 22:06:59','2022-01-27 19:23:39',NULL),
('K007','Aukey Wall Charger PA-F1S 20W Ultra Compact with PD 3.0 - 500723','1',475000,10,'',75,1000,NULL,7,'2022-01-29 08:56:56','2022-01-29 08:56:56',NULL),
('K008','Bowin Masker KN95 4D Design 95% BFE PFE (Masker Kesehatan Model KF94) - KN95 (4D KIDS), PUTIH (5 PCS','-',12000,12,'',0,111,NULL,8,'2022-01-29 09:13:09','2022-01-29 09:14:54',NULL);

/*Table structure for table `m_produk_beranda` */

DROP TABLE IF EXISTS `m_produk_beranda`;

CREATE TABLE `m_produk_beranda` (
  `pbId` int(11) NOT NULL AUTO_INCREMENT,
  `pbBanner` varchar(40) DEFAULT NULL,
  `pbJudul` varchar(100) DEFAULT NULL,
  `pbDeskripsi` text DEFAULT NULL,
  `pbUpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pbDeletedAt` datetime DEFAULT NULL,
  `pbCreatedAt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`pbId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `m_produk_beranda` */

insert  into `m_produk_beranda`(`pbId`,`pbBanner`,`pbJudul`,`pbDeskripsi`,`pbUpdatedAt`,`pbDeletedAt`,`pbCreatedAt`) values 
(1,'20220126101254.jpg','Paket Hadiah','Produk Menarik dari paket hadiah','2022-01-26 21:12:54','2022-01-21 06:00:15','2022-01-21 06:00:09');

/*Table structure for table `m_setting` */

DROP TABLE IF EXISTS `m_setting`;

CREATE TABLE `m_setting` (
  `setKey` varchar(40) NOT NULL,
  `setValue` varchar(300) DEFAULT NULL,
  `setCreatedAt` datetime DEFAULT current_timestamp(),
  `setUpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `setDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`setKey`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_setting` */

insert  into `m_setting`(`setKey`,`setValue`,`setCreatedAt`,`setUpdatedAt`,`setDeletedAt`) values 
('bantuan_link','https://www.sumbupulsa.com/','2022-01-28 21:28:24','2022-01-28 21:28:24',NULL),
('blog_url','https://www.sumbupulsa.com/','2022-01-28 21:28:29','2022-01-28 21:35:31',NULL),
('kebijakan_privasi_url','https://www.sumbupulsa.com/','2022-01-28 21:28:10','2022-01-28 21:34:11',NULL),
('ketentuan_layanan_url','https://app.sandbox.midtrans.com/snap/v2/vtweb/608559e9-170e-4911-917f-aecdaa167231#/order-summary','2022-01-28 21:27:52','2022-01-29 09:27:43',NULL),
('no_cs_url','https://wa.me/+6281251554104','2022-01-28 21:28:29','2022-01-28 21:42:13',NULL),
('playstore_url','https://play.google.com/store/apps/details?id=id.co.aviana.sumbu&hl=en&gl=US','2022-01-28 21:15:10','2022-01-28 21:33:14',NULL);

/*Table structure for table `m_user` */

DROP TABLE IF EXISTS `m_user`;

CREATE TABLE `m_user` (
  `usrEmail` varchar(40) NOT NULL,
  `usrNama` varchar(40) DEFAULT NULL,
  `usrPassword` varchar(40) DEFAULT NULL,
  `usrSaldo` double DEFAULT NULL,
  `usrIsActive` tinyint(4) DEFAULT 0,
  `usrCreatedAt` datetime DEFAULT current_timestamp(),
  `usrUpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usrDeletedAt` datetime DEFAULT NULL,
  `usrFirebaseToken` varchar(200) DEFAULT NULL,
  `usrPin` varchar(40) DEFAULT NULL,
  `usrNoHp` varchar(15) DEFAULT NULL,
  `usrNoWa` varchar(15) DEFAULT NULL,
  `usrActiveCode` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`usrEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_user` */

insert  into `m_user`(`usrEmail`,`usrNama`,`usrPassword`,`usrSaldo`,`usrIsActive`,`usrCreatedAt`,`usrUpdatedAt`,`usrDeletedAt`,`usrFirebaseToken`,`usrPin`,`usrNoHp`,`usrNoWa`,`usrActiveCode`) values 
('ahmad@gmail.com','Juhdi Ahmad','9c4762c1d98353c853f1b13cc1bda8f4',25000,1,'2022-02-08 21:54:23','2022-02-08 22:22:51',NULL,NULL,NULL,'0123','12312',NULL),
('ahmadjuhdi007@gmail.com','Ahmad Juhdi','a64f1fc270735a4c1443c6514131aca6',2460400,1,'2022-01-24 21:36:18','2022-01-30 09:49:43',NULL,NULL,NULL,'081251554104',NULL,NULL),
('ahmadjuhdi007@gmail.comss','Ahmad Juhdis','a64f1fc270735a4c1443c6514131aca6',NULL,0,'2022-02-10 03:06:10','2022-02-10 03:06:10',NULL,NULL,NULL,'11111','11111','39b4e934-f6f3-4c3b-807d-9c04548a2b24'),
('gjuhdi@gmail.com','Ahmad Juhdis','a64f1fc270735a4c1443c6514131aca6',NULL,1,'2022-02-10 03:06:59','2022-02-10 03:16:33',NULL,NULL,NULL,'11111','11111','34f0d86f-add6-4698-a9f1-4b61ff7c56bb');

/*Table structure for table `m_user_alamat` */

DROP TABLE IF EXISTS `m_user_alamat`;

CREATE TABLE `m_user_alamat` (
  `usralId` int(11) NOT NULL AUTO_INCREMENT,
  `usralUsrEmail` varchar(40) DEFAULT NULL,
  `usralNama` varchar(40) DEFAULT NULL,
  `usralCreatedAt` datetime DEFAULT current_timestamp(),
  `usralUpdatedAt` datetime DEFAULT current_timestamp(),
  `usralDeletedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usralLatitude` double DEFAULT NULL,
  `usralLongitude` double DEFAULT NULL,
  `usralKotaId` int(11) DEFAULT NULL,
  `usralKotaNama` varchar(30) DEFAULT NULL,
  `usralKotaTipe` varchar(30) DEFAULT NULL,
  `usralProvinsiId` int(11) DEFAULT NULL,
  `usralProvinsiNama` varchar(30) DEFAULT NULL,
  `usralKecamatanId` int(11) DEFAULT NULL,
  `usralKecamatanNama` varchar(30) DEFAULT NULL,
  `usralIsActive` tinyint(4) DEFAULT 0,
  `usralIsFirst` tinyint(4) DEFAULT 0,
  `usralKeterangan` varchar(100) DEFAULT NULL COMMENT 'Keterangan untuk kurir',
  PRIMARY KEY (`usralId`),
  KEY `usralUsrEmail` (`usralUsrEmail`),
  CONSTRAINT `m_user_alamat_ibfk_1` FOREIGN KEY (`usralUsrEmail`) REFERENCES `m_user` (`usrEmail`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `m_user_alamat` */

insert  into `m_user_alamat`(`usralId`,`usralUsrEmail`,`usralNama`,`usralCreatedAt`,`usralUpdatedAt`,`usralDeletedAt`,`usralLatitude`,`usralLongitude`,`usralKotaId`,`usralKotaNama`,`usralKotaTipe`,`usralProvinsiId`,`usralProvinsiNama`,`usralKecamatanId`,`usralKecamatanNama`,`usralIsActive`,`usralIsFirst`,`usralKeterangan`) values 
(8,'ahmad@gmail.com','Rumah','2022-02-08 21:54:23','2022-02-08 21:54:23','2022-02-08 21:54:23',-3.4483395,114.8430029,8,'Aceh Tengah','Kabupaten',21,'Nanggroe Aceh Darussalam (NAD)',105,'Lut Tawar',1,1,NULL),
(9,'ahmadjuhdi007@gmail.comss','Rumah','2022-02-10 03:06:10','2022-02-10 03:06:10','2022-02-10 03:06:10',11111,11111,11111,'11111','Kecamatan',11111,'11111',1111,'1111',1,1,NULL),
(11,'ahmadjuhdi007@gmail.com','Rumah','2022-02-08 21:54:23','2022-02-08 21:54:23','2022-02-10 03:30:55',-3.4483395,114.8430029,8,'Aceh Tengah','Kabupaten',21,'Nanggroe Aceh Darussalam (NAD)',105,'Lut Tawar',1,1,NULL),
(12,'gjuhdi@gmail.com','Rumah','2022-02-08 21:54:23','2022-02-08 21:54:23','2022-02-10 04:30:35',-3.4483395,114.8430029,8,'Aceh Tengah','Kabupaten',21,'Nanggroe Aceh Darussalam (NAD)',105,'Lut Tawar',1,1,NULL);

/*Table structure for table `m_user_web` */

DROP TABLE IF EXISTS `m_user_web`;

CREATE TABLE `m_user_web` (
  `usrwebUsername` varchar(11) NOT NULL,
  `usrwebNama` varchar(40) DEFAULT NULL,
  `usrwebRole` enum('admin','superadmin') DEFAULT NULL,
  `usrwebPassword` varchar(40) DEFAULT NULL,
  `usrwebCreatedAt` datetime DEFAULT current_timestamp(),
  `usrwebUpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usrwebDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`usrwebUsername`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_user_web` */

insert  into `m_user_web`(`usrwebUsername`,`usrwebNama`,`usrwebRole`,`usrwebPassword`,`usrwebCreatedAt`,`usrwebUpdatedAt`,`usrwebDeletedAt`) values 
('admin','Administrators','superadmin','797d29656521a7dfdea48d0b8038dbf9','2022-01-18 19:42:55','2022-02-03 08:19:41',NULL),
('juhdi','Ahmad Juhdi','superadmin','a64f1fc270735a4c1443c6514131aca6','2022-01-18 19:57:46','2022-01-23 18:43:24',NULL);

/*Table structure for table `t_checkout` */

DROP TABLE IF EXISTS `t_checkout`;

CREATE TABLE `t_checkout` (
  `cktId` int(11) NOT NULL AUTO_INCREMENT,
  `cktStatus` enum('dikemas','belum_bayar','dikirim','selesai','dibatalkan') DEFAULT NULL,
  `cktKurir` varchar(20) DEFAULT NULL,
  `cktNoResiKurir` varchar(40) DEFAULT NULL,
  `cktCatatan` varchar(40) DEFAULT NULL,
  `cktAlamatId` int(11) DEFAULT NULL,
  `cktCreatedAt` datetime DEFAULT current_timestamp(),
  `cktUpdatedAt` datetime DEFAULT current_timestamp(),
  `cktDeletedAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`cktId`),
  KEY `cktAlamatId` (`cktAlamatId`),
  CONSTRAINT `t_checkout_ibfk_1` FOREIGN KEY (`cktAlamatId`) REFERENCES `m_user_alamat` (`usralId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `t_checkout` */

insert  into `t_checkout`(`cktId`,`cktStatus`,`cktKurir`,`cktNoResiKurir`,`cktCatatan`,`cktAlamatId`,`cktCreatedAt`,`cktUpdatedAt`,`cktDeletedAt`) values 
(5,'belum_bayar','jne',NULL,'Di kemas yang rapi',11,'2022-02-13 21:33:28','2022-02-13 21:33:28',NULL),
(6,'belum_bayar','jne',NULL,'Di kemas yang rapi',11,'2022-02-13 21:42:28','2022-02-13 21:42:28',NULL),
(7,'belum_bayar','jne',NULL,'Di kemas yang rapi',11,'2022-02-13 21:42:36','2022-02-13 21:42:36',NULL),
(8,'belum_bayar','jne',NULL,'Di kemas yang rapi',11,'2022-02-13 21:42:56','2022-02-13 21:42:56',NULL),
(9,'belum_bayar','jne',NULL,'Di kemas yang rapi',11,'2022-02-13 21:43:17','2022-02-13 21:43:17',NULL),
(10,'belum_bayar','jne',NULL,'Di kemas yang rapi',11,'2022-02-13 21:43:29','2022-02-13 21:43:29',NULL),
(11,'belum_bayar','jne',NULL,'Di kemas yang rapi',11,'2022-02-13 21:48:02','2022-02-13 21:48:02',NULL);

/*Table structure for table `t_checkout_detail` */

DROP TABLE IF EXISTS `t_checkout_detail`;

CREATE TABLE `t_checkout_detail` (
  `cktdtId` int(11) NOT NULL AUTO_INCREMENT,
  `cktdtCheckoutId` int(11) DEFAULT NULL,
  `cktdtKeterangan` varchar(50) DEFAULT NULL,
  `cktdtBiaya` double DEFAULT NULL,
  `cktdtCreatedAt` datetime DEFAULT current_timestamp(),
  `cktdtUpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cktdtDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`cktdtId`),
  KEY `cktdtCheckoutId` (`cktdtCheckoutId`),
  CONSTRAINT `t_checkout_detail_ibfk_1` FOREIGN KEY (`cktdtCheckoutId`) REFERENCES `t_checkout` (`cktId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `t_checkout_detail` */

insert  into `t_checkout_detail`(`cktdtId`,`cktdtCheckoutId`,`cktdtKeterangan`,`cktdtBiaya`,`cktdtCreatedAt`,`cktdtUpdatedAt`,`cktdtDeletedAt`) values 
(5,5,'Subtotal produk',64083.2,'2022-02-13 21:33:28','2022-02-13 21:33:28',NULL),
(6,5,'Ongkos Kirim',20000,'2022-02-13 21:33:28','2022-02-13 21:33:28',NULL),
(7,6,'Subtotal produk',64083.2,'2022-02-13 21:42:28','2022-02-13 21:42:28',NULL),
(8,6,'Ongkos Kirim',20000,'2022-02-13 21:42:28','2022-02-13 21:42:28',NULL),
(9,7,'Subtotal produk',64083.2,'2022-02-13 21:42:37','2022-02-13 21:42:37',NULL),
(10,7,'Ongkos Kirim',20000,'2022-02-13 21:42:37','2022-02-13 21:42:37',NULL),
(11,8,'Subtotal produk',64083.2,'2022-02-13 21:42:56','2022-02-13 21:42:56',NULL),
(12,8,'Ongkos Kirim',20000,'2022-02-13 21:42:56','2022-02-13 21:42:56',NULL),
(13,9,'Subtotal produk',64083.2,'2022-02-13 21:43:18','2022-02-13 21:43:18',NULL),
(14,9,'Ongkos Kirim',20000,'2022-02-13 21:43:18','2022-02-13 21:43:18',NULL),
(15,10,'Subtotal produk',64083.2,'2022-02-13 21:43:29','2022-02-13 21:43:29',NULL),
(16,10,'Ongkos Kirim',20000,'2022-02-13 21:43:29','2022-02-13 21:43:29',NULL),
(17,11,'Subtotal produk',64083,'2022-02-13 21:48:02','2022-02-13 21:48:02',NULL),
(18,11,'Ongkos Kirim',20000,'2022-02-13 21:48:02','2022-02-13 21:48:02',NULL);

/*Table structure for table `t_keranjang` */

DROP TABLE IF EXISTS `t_keranjang`;

CREATE TABLE `t_keranjang` (
  `krjId` int(11) NOT NULL AUTO_INCREMENT,
  `krjProdukId` varchar(15) DEFAULT NULL,
  `krjQuantity` int(11) DEFAULT NULL,
  `krjPesan` varchar(200) DEFAULT NULL,
  `krjCheckoutId` int(11) DEFAULT NULL,
  `krjCreatedAt` datetime DEFAULT current_timestamp(),
  `krjUpdatedAt` datetime DEFAULT current_timestamp(),
  `krjDeletedAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `krjUserEmail` varchar(40) DEFAULT NULL,
  `krjIsChecked` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`krjId`),
  KEY `krjUserEmail` (`krjUserEmail`),
  KEY `krjProdukId` (`krjProdukId`),
  KEY `t_keranjang_ibfk_3` (`krjCheckoutId`),
  CONSTRAINT `t_keranjang_ibfk_2` FOREIGN KEY (`krjUserEmail`) REFERENCES `m_user` (`usrEmail`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_keranjang_ibfk_3` FOREIGN KEY (`krjCheckoutId`) REFERENCES `t_checkout` (`cktId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_keranjang_ibfk_4` FOREIGN KEY (`krjProdukId`) REFERENCES `m_produk` (`produkId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Data for the table `t_keranjang` */

insert  into `t_keranjang`(`krjId`,`krjProdukId`,`krjQuantity`,`krjPesan`,`krjCheckoutId`,`krjCreatedAt`,`krjUpdatedAt`,`krjDeletedAt`,`krjUserEmail`,`krjIsChecked`) values 
(9,'K0033',2,'asasa',NULL,'2022-01-26 21:47:24','2022-01-26 21:47:24','2022-01-26 21:47:31','ahmadjuhdi007@gmail.com',0),
(10,'K001',5,'asasa',NULL,'2022-01-26 21:47:24','2022-01-26 21:47:24','2022-02-12 12:02:04','ahmadjuhdi007@gmail.com',1),
(11,'K002',5,'asasa',NULL,'2022-01-26 21:47:24','2022-01-26 21:47:24','2022-02-12 12:02:05','ahmadjuhdi007@gmail.com',1),
(13,'K003',3,NULL,NULL,'2022-02-10 04:09:36','2022-02-10 04:09:36','2022-02-12 12:07:26','ahmadjuhdi007@gmail.com',0),
(15,'K003',14,NULL,NULL,'2022-02-10 04:16:04','2022-02-10 04:16:04','2022-02-10 04:16:53','gjuhdi@gmail.com',0),
(19,'K0033',1,NULL,NULL,'2022-02-10 04:33:43','2022-02-10 04:33:43',NULL,'gjuhdi@gmail.com',0),
(20,'K002',1,NULL,NULL,'2022-02-10 05:11:28','2022-02-10 05:11:28',NULL,'gjuhdi@gmail.com',0),
(21,'K001',1,NULL,NULL,'2022-02-10 12:00:00','2022-02-10 12:00:00',NULL,'gjuhdi@gmail.com',0);

/*Table structure for table `t_notifikasi_to` */

DROP TABLE IF EXISTS `t_notifikasi_to`;

CREATE TABLE `t_notifikasi_to` (
  `tnotifId` int(11) NOT NULL AUTO_INCREMENT,
  `tnotifEmail` varchar(40) DEFAULT NULL,
  `tnotifNotifId` int(11) DEFAULT NULL,
  PRIMARY KEY (`tnotifId`),
  KEY `tnotifNotifId` (`tnotifNotifId`),
  CONSTRAINT `t_notifikasi_to_ibfk_1` FOREIGN KEY (`tnotifNotifId`) REFERENCES `m_notifikasi` (`noifId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_notifikasi_to` */

/*Table structure for table `t_pembayaran` */

DROP TABLE IF EXISTS `t_pembayaran`;

CREATE TABLE `t_pembayaran` (
  `pmbId` varchar(50) NOT NULL,
  `pmbCheckoutId` int(11) DEFAULT NULL,
  `pmbPaymentType` enum('echannel','bank_transfer','gopay') DEFAULT NULL,
  `pmbStatus` enum('pending','cancel','settlement','failure','expire') DEFAULT NULL,
  `pmbTime` datetime DEFAULT NULL,
  `pmbSignatureKey` varchar(300) DEFAULT NULL,
  `pmbOrderId` varchar(30) DEFAULT NULL,
  `pmbMerchantId` varchar(15) DEFAULT NULL,
  `pmbGrossAmount` double DEFAULT NULL,
  `pmbCurrency` enum('IDR') DEFAULT 'IDR',
  `pmbVaNumber` varchar(20) DEFAULT NULL COMMENT 'Pembayaran Bank_transfer',
  `pmbBank` enum('bni','bca','permata','bri','mandiri') DEFAULT NULL COMMENT 'Pembayaran Bank_transfer',
  `pmbBillerCode` varchar(10) DEFAULT NULL COMMENT 'Pembayaran Echannel',
  `pmbBillKey` varchar(15) DEFAULT NULL COMMENT 'Pembayaran Echannel',
  `pmbUserEmail` varchar(50) DEFAULT NULL,
  `pmbExpiredDate` datetime DEFAULT NULL,
  PRIMARY KEY (`pmbId`),
  KEY `usalUserEmail` (`pmbUserEmail`),
  KEY `pmbCheckoutId` (`pmbCheckoutId`),
  CONSTRAINT `t_pembayaran_ibfk_1` FOREIGN KEY (`pmbCheckoutId`) REFERENCES `t_checkout` (`cktId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_pembayaran` */

insert  into `t_pembayaran`(`pmbId`,`pmbCheckoutId`,`pmbPaymentType`,`pmbStatus`,`pmbTime`,`pmbSignatureKey`,`pmbOrderId`,`pmbMerchantId`,`pmbGrossAmount`,`pmbCurrency`,`pmbVaNumber`,`pmbBank`,`pmbBillerCode`,`pmbBillKey`,`pmbUserEmail`,`pmbExpiredDate`) values 
('fc83e587-0acb-4e8b-b82b-442687cd2440',11,'echannel','pending','2022-02-13 21:48:03','','ORDER-1644763629','G005407818',84083,'IDR','','','70012','175059187783','ahmadjuhdi007@gmail.com','2022-02-14 21:48:03');

/*Table structure for table `t_produk_beranda` */

DROP TABLE IF EXISTS `t_produk_beranda`;

CREATE TABLE `t_produk_beranda` (
  `tpbId` int(11) NOT NULL AUTO_INCREMENT,
  `tpbProdukId` varchar(15) DEFAULT NULL,
  `tpbPbId` int(11) DEFAULT NULL,
  `tpbUpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tpbDeletedAt` datetime DEFAULT NULL,
  `tpbCreatedAt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`tpbId`),
  KEY `tpbPbId` (`tpbPbId`),
  KEY `tpbProdukId` (`tpbProdukId`),
  CONSTRAINT `t_produk_beranda_ibfk_1` FOREIGN KEY (`tpbPbId`) REFERENCES `m_produk_beranda` (`pbId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_produk_beranda_ibfk_2` FOREIGN KEY (`tpbProdukId`) REFERENCES `m_produk` (`produkId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `t_produk_beranda` */

insert  into `t_produk_beranda`(`tpbId`,`tpbProdukId`,`tpbPbId`,`tpbUpdatedAt`,`tpbDeletedAt`,`tpbCreatedAt`) values 
(9,'K001',1,'2022-01-23 09:48:29',NULL,'2022-01-23 09:48:29'),
(10,'K002',1,'2022-01-26 20:32:00',NULL,'2022-01-26 20:32:00'),
(11,'K003',1,'2022-01-27 22:38:54',NULL,'2022-01-27 22:38:54'),
(12,'K0033',1,'2022-01-27 22:56:57',NULL,'2022-01-27 22:56:57');

/*Table structure for table `t_produk_gambar` */

DROP TABLE IF EXISTS `t_produk_gambar`;

CREATE TABLE `t_produk_gambar` (
  `prdgbrId` int(11) NOT NULL AUTO_INCREMENT,
  `prdgbrProdukId` varchar(15) DEFAULT NULL,
  `prdgbrFile` varchar(40) DEFAULT NULL,
  `prdgbrCreatedAt` datetime DEFAULT current_timestamp(),
  `prdgbrUpdatedAt` datetime DEFAULT current_timestamp(),
  `prdgbrDeletedAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`prdgbrId`),
  KEY `prdgbrProdukId` (`prdgbrProdukId`),
  CONSTRAINT `t_produk_gambar_ibfk_1` FOREIGN KEY (`prdgbrProdukId`) REFERENCES `m_produk` (`produkId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

/*Data for the table `t_produk_gambar` */

insert  into `t_produk_gambar`(`prdgbrId`,`prdgbrProdukId`,`prdgbrFile`,`prdgbrCreatedAt`,`prdgbrUpdatedAt`,`prdgbrDeletedAt`) values 
(62,'K001','1642605036_be30a4ad06d5bc8d19a9.jpg','2022-01-19 22:10:36','2022-01-19 22:10:36',NULL),
(63,'K001','1642605036_af42d0f59295fa64d2de.jpg','2022-01-19 22:10:36','2022-01-19 22:10:36',NULL),
(64,'K001','1642605036_9b48a74be00b9a7e73b5.png','2022-01-19 22:10:36','2022-01-19 22:10:36',NULL),
(70,'K0033','1642779153_f799281ac32003fbef05.jpg','2022-01-21 22:33:09','2022-01-21 22:33:09',NULL),
(75,'K0033','1642834433_6739135f1d8788bc9e78.jpg','2022-01-22 13:54:29','2022-01-22 13:54:29',NULL),
(76,'K002','1643203870_2106b5e60e894c3d951a.jpg','2022-01-26 20:31:10','2022-01-26 20:31:10',NULL),
(77,'K002','1643203870_54f858d742680fb10b9f.jpg','2022-01-26 20:31:10','2022-01-26 20:31:10',NULL),
(78,'K0033','1643291008_e13c22518d246ae58511.jpg','2022-01-27 20:44:08','2022-01-27 20:44:08',NULL),
(82,'K003','1643297891_260c8ba782956212ab24.jpg','2022-01-27 22:38:11','2022-01-27 22:38:11',NULL),
(83,'K003','1643297891_9dd95b769ac42a2154e6.jpg','2022-01-27 22:38:11','2022-01-27 22:38:11',NULL),
(92,'K001','1643334965_1a303e1b0b89b94449ec.jpg','2022-01-28 08:56:05','2022-01-28 08:56:05',NULL),
(93,'K007','1643421416_364587bb9e10a233d5c4.jpg','2022-01-29 08:56:56','2022-01-29 08:56:56',NULL),
(94,'K007','1643421416_757273c4f1f59a0f5036.jpg','2022-01-29 08:56:56','2022-01-29 08:56:56',NULL),
(95,'K007','1643421416_52ae73f3b86f91133f46.jpg','2022-01-29 08:56:56','2022-01-29 08:56:56',NULL),
(96,'K008','1643422389_8f90893424e02fb0f74e.png','2022-01-29 09:13:09','2022-01-29 09:13:09',NULL),
(97,'K008','1643422402_9e788e082057a4631d83.png','2022-01-29 09:13:22','2022-01-29 09:13:22',NULL),
(98,'K008','1643422402_de1dcaa230c8938eea4d.png','2022-01-29 09:13:22','2022-01-29 09:13:22',NULL);

/*Table structure for table `t_user_saldo` */

DROP TABLE IF EXISTS `t_user_saldo`;

CREATE TABLE `t_user_saldo` (
  `usalId` varchar(50) NOT NULL,
  `usalPaymentType` enum('echannel','bank_transfer','gopay') DEFAULT NULL,
  `usalStatus` enum('pending','cancel','settlement','failure','expire') DEFAULT NULL,
  `usalTime` datetime DEFAULT NULL,
  `usalSignatureKey` varchar(300) DEFAULT NULL,
  `usalOrderId` varchar(30) DEFAULT NULL,
  `usalMerchantId` varchar(15) DEFAULT NULL,
  `usalGrossAmount` double DEFAULT NULL,
  `usalCurrency` enum('IDR') DEFAULT 'IDR',
  `usalVaNumber` varchar(20) DEFAULT NULL COMMENT 'Pembayaran Bank_transfer',
  `usalBank` enum('bni','bca','permata','bri','mandiri') DEFAULT NULL COMMENT 'Pembayaran Bank_transfer',
  `usalBillerCode` varchar(10) DEFAULT NULL COMMENT 'Pembayaran Echannel',
  `usalBillKey` varchar(15) DEFAULT NULL COMMENT 'Pembayaran Echannel',
  `usalUserEmail` varchar(50) DEFAULT NULL,
  `usalStatusSaldo` enum('top_up','pengembalian_dana','top_down') DEFAULT NULL,
  `usalExpiredDate` datetime DEFAULT NULL,
  PRIMARY KEY (`usalId`),
  KEY `usalUserEmail` (`usalUserEmail`),
  CONSTRAINT `t_user_saldo_ibfk_1` FOREIGN KEY (`usalUserEmail`) REFERENCES `m_user` (`usrEmail`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_user_saldo` */

insert  into `t_user_saldo`(`usalId`,`usalPaymentType`,`usalStatus`,`usalTime`,`usalSignatureKey`,`usalOrderId`,`usalMerchantId`,`usalGrossAmount`,`usalCurrency`,`usalVaNumber`,`usalBank`,`usalBillerCode`,`usalBillKey`,`usalUserEmail`,`usalStatusSaldo`,`usalExpiredDate`) values 
('0b965cf7-f3cd-40b1-b6ce-b4d38ea12a83','bank_transfer','expire','2022-01-29 20:39:39','cf3143cfa3669b57594fe10378241c7efd162d9c70ce2f2e082d593b8e76ce280b2b73afe0888a60ab3750feb2e8f90ce046ecda822316568bfa8948778e0992','TOPUP-1643463579','G005407818',1000000,'IDR','9880781884126498','bni','','','ahmadjuhdi007@gmail.com','top_up','2022-01-30 20:39:39'),
('22969f77-6cb4-4f6e-aa7a-bd638b15e9e3','bank_transfer','settlement','2022-01-29 20:29:54','f3dfdc4618ee106ac370752449e990c426b5a9849903ae006d13ef8eae5264603f2fe99340210d5100c430dd0ad3551873a3247e95c25ef51271ed677e88fff4','TOPUP-1643462951','G005407818',200100,'IDR','0781812345678','bca','','','ahmadjuhdi007@gmail.com','top_up','2022-01-30 20:29:54'),
('341fb6b4-7fa7-46e5-8b72-3c03248c25fc','bank_transfer','expire','2022-01-30 13:50:29','bad9bd4f4059351a6629125b50c65c07d24f07f4d2172b66cc9a92a3537a97f2d00d87156877b5f8562e5fedd021b1f50df59904dbe71e570bc67228a33f4e31','TOPUP-1643525429','G005407818',500000,'IDR','078187009050860381','bri','','','ahmadjuhdi007@gmail.com','top_up','2022-01-31 13:50:29'),
('3a5b60a5-8b97-457e-a492-1ceb1638acdf','echannel','expire','2022-01-29 20:39:59','f5ef85ba2b023c2bf0e0f2ebcf19541d48ab30566187d32d30d869bd2475c3c0113ae6b2d33c2250439cbd4e460eaa628547fae76115834532bf56131bb31ab0','TOPUP-1643463598','G005407818',10000,'IDR','','','70012','542857199444','ahmadjuhdi007@gmail.com','top_up','2022-01-30 20:39:59'),
('3f550f0d-c3d2-4bd2-9769-52f878828a19','echannel','pending','2022-01-25 20:07:47','6becf22ceb2fabd9b3dd6e9947732d8fc50c5fa77460f2204c93b2551d919ac5dccb781ada69d2ea79610bc95c3a5c542471970b4487fa87b5f9c47ae4a8d1da','TOPUP-1643116022','G005407818',100000,'IDR','','','70012','276151110418','ahmadjuhdi007@gmail.com',NULL,NULL),
('4965bbae-38ce-4607-9fe9-7017d6c18966','bank_transfer','expire','2022-01-31 10:17:18','59f6d7de70f6cbc6c4bec8e7f7d0d8a4471a022042746cce313263ffe32efdc83c3edbfe956d8616c2653977df8d037b8af0d97f5c405a2644c593e903e3429e','TOPUP-1643599038','G005407818',10000,'IDR','07818261722','bca','','','ahmadjuhdi007@gmail.com','top_up','2022-02-01 10:17:18'),
('4d6dee58-d614-49f4-abf6-c89ccfd6eca2','bank_transfer','expire','2022-01-29 20:06:53','b44b61d2a8d663ad8f977ef238a41742931cbc9e16d2017836bd7c5eed0495fa3cee15b22aa6d2ee5d16c10d137201879ce8af2f1a44239fb391babd8a366366','TOPUP-1643461570','G005407818',200100,'IDR','9880781812345678','bni','','','ahmadjuhdi007@gmail.com',NULL,NULL),
('59d7a8d9-718c-409a-9b77-49dd83853469','bank_transfer','expire','2022-01-29 20:54:20','e870cb389d732d3991f9f05b7bbf3227d20d543ca6d9b35f2cbbb377e55c52284daf0307ac2f230c267dd3f219696c5d819b160d4c0510cb652af6b0c2548b83','TOPUP-1643464460','G005407818',50000,'IDR','078180000012345678','','','','ahmadjuhdi007@gmail.com','top_up','2022-01-30 20:54:20'),
('628b6dd6-f8a0-4e0b-902d-e23e83ec345f','bank_transfer','expire','2022-01-29 23:52:37','05cfd10a7c4ebfaf0819287bb4eed523136fc8ed92018323763234f770418ddd5bb5ef1471c6d1c2f50b15361b199f07dc9448ef7f8229d525d76b8eb4b55e62','TOPUP-1643475157','G005407818',25000,'IDR','0781812345678','bca','','','ahmadjuhdi007@gmail.com','top_up','2022-01-30 23:52:37'),
('7b0286c3-5a27-49cf-84bc-0060308b023e','bank_transfer','expire','2022-01-30 21:48:57','f5459e4c828c688ef3a06f901a2f445dbf33ccf0351fdc77a52c743d3cbb482f2f83729de448f8dfa87677261236a0ffc910468dd166f0957e785a7370559e97','TOPUP-1643554137','G005407818',10000,'IDR','9880781812345678','bni','','','ahmadjuhdi007@gmail.com','top_up','2022-01-31 21:48:57'),
('890c4bfc-1ab8-4944-b5b3-246a420fe395','bank_transfer','expire','2022-01-31 08:02:11','be5e9ac07e08b5ee0d84b49210e13948c2c25a1662553bca9a4b6b9d833b8dc2a0d7b060ae54ce31c007e172f204454af4c000ea00f2c26fed23b50edea59faf','TOPUP-1643590931','G005407818',50000,'IDR','0781812345678','bca','','','ahmadjuhdi007@gmail.com','top_up','2022-02-01 08:02:11'),
('a2dc29da-f843-47d8-a94f-064acf9abffd','bank_transfer','cancel','2022-01-30 13:45:28','59f0debf137ffada2c66c124b17d6993e9e199c216b618846fd74355b522cde31ff9a2cae75ae079da3cbcf8a4c0f8dc930c733074fdf5a65eb06b7396eb41e8','TOPUP-1643525128','G005407818',50000,'IDR','078187842072823229','bri','','','ahmadjuhdi007@gmail.com','top_up','2022-01-31 13:45:28'),
('a680815d-8974-4b0e-a7cf-3c171f593f30','bank_transfer','expire','2022-01-25 19:28:15','b30d390b732e2e0e9215ccf065e7d9e042c191dd78cb4c356e36dd15de3a994c538dcf635cdd1f5f2e7f8142fe00481dd916329f3d66976946120a44ffa778f0','TOPUP-1643113655','G005407818',10000,'IDR','9880781833712805','bni','','','ahmadjuhdi007@gmail.com',NULL,NULL),
('ac87def7-5864-4280-b331-e5570b970b6f','echannel','settlement','2022-01-30 09:34:36','4f0ab06eaf82af140a058200cb948604e07383def2b44b9b83a8973569591b746258b02134cebd37f150f5548b2f7f5bba945135ba8933c2967ed7a4d5bca5f8','TOPUP-1643510075','G005407818',50000,'IDR','','','70012','693418726699','ahmadjuhdi007@gmail.com','top_up','2022-01-31 09:34:36'),
('ada1eb68-22f6-46e7-a3d4-26784709ac9d','bank_transfer','settlement','2022-02-08 21:56:23','320cf2ef3a4c77570389fa1ef769a71b94d53f0cc9e5dddd3107f389fba88d3e0e88e165e291672797f0b4a6eef1c49fc3881164e83740b6128cc6bed90c4b0b','TOPUP-1644332183','G005407818',25000,'IDR','078180000012345678','bri','','','ahmad@gmail.com','top_up','2022-02-09 21:56:23'),
('b219fb87-7798-4c18-8e61-5be2f41ccfac','bank_transfer','settlement','2022-01-25 20:48:37','b9f6546e62ed7a86ce619dc3657b4bc896adb24bc237e24f44d0684e4478082e7099ff479157d42b9613884302913d5df072bbe94a7be448cb43161361a25269','TOPUP-1643118477','G005407818',200100,'IDR','9880781847837202','bni','','','ahmadjuhdi007@gmail.com',NULL,NULL),
('b8458690-1a6b-497e-8b97-45cd9d0dc8fa','bank_transfer','settlement','2022-01-25 19:31:05','f209c7460074dabb7d0b0ab6310b115edb40e068c33fdd710af3b8f0ee9af0e5a19125b7cfeb85eb2122619835459005185738752977e3865d31113b35b70af8','TOPUP-1643113825','G005407818',10000,'IDR','9880781806538070','bni','','','ahmadjuhdi007@gmail.com',NULL,NULL),
('cd3d8eba-dd0a-4721-b0b5-c248960d5574','bank_transfer','settlement','2022-01-30 09:49:10','7be9c1a84111d0b5b71c5544ba018661b1b0fef87d505d8a8b6111304f7267c388583a07e75aa921a3bc66ecb6ba221f390457bf43c0fab9d05a02f56050872a','TOPUP-1643510950','G005407818',1000000,'IDR','9880781809596432','bni','','','ahmadjuhdi007@gmail.com','top_up','2022-01-31 09:49:10'),
('ce128e37-94ca-4374-9e20-fc889d977253','bank_transfer','expire','2022-01-29 20:39:01','5930e97b6913ae9bcc87d205c23d13054878cbe4be0e962b82cadd9c78630afe42a447f21c6c4ed6aaeb7ac9737f81cfb3f97b891687f5e6b1c47211d51cf4ae','TOPUP-1643463541','G005407818',1000000,'IDR','9880781835777375','bni','','','ahmadjuhdi007@gmail.com','top_up','2022-01-30 20:39:01'),
('d8e8a3bd-bb35-4187-9fe8-3cfc6ae2618a','bank_transfer','expire','2022-01-30 21:12:36','f7ccecb4871959c09cfd624e91cde8fa4fc85fb80e3158a69b9d6523a08f1da042a85ee25fd461b5adbd1bb04903d6b63cd7371dea8b97526f5b13b841fff8e3','TOPUP-1643551955','G005407818',50000,'IDR','078180000012345678','bri','','','ahmadjuhdi007@gmail.com','top_up','2022-01-31 21:12:36'),
('dfcc5dac-9821-44cc-b4c2-7d65951d31cb','bank_transfer','expire','2022-01-29 20:12:49','427511efae4eff2b456fbfb962a6298515b7ac93f89730bfb4ea6fa59eee619da0ab404a951771d99a71d1868db9e93101a10781c6b36329a9838c9ee7361b90','TOPUP-1643461926','G005407818',200100,'IDR','9880781846908801','bni','','','ahmadjuhdi007@gmail.com','top_up',NULL),
('eb18bba4-3ab7-482f-abbc-376939a63750','bank_transfer','settlement','2022-01-27 22:25:42','7a2509c0ab3b0fc9d8818b189bed14ad1dc51f36a88f48bb50fa694b93ea789ea20798b7be264f5921ff4b3aa8f1a3aab7e9b09af42367f1624516393ab49d5a','TOPUP-1643297100','G005407818',200100,'IDR','9880781812345678','bni','','','ahmadjuhdi007@gmail.com',NULL,NULL),
('f538e79d-cc53-47d5-a146-16d30d5640a8','bank_transfer','expire','2022-01-29 20:14:13','db2d4adb1212cea8629274d3af8468edeaffd60e8a4cf6abd873a1f58c190686f46e9f5ec7a8690185b3842e0ce189ed861f7967e4c1ec005d2ebe5d17ed890f','TOPUP-1643462010','G005407818',200100,'IDR','9880781845237815','bni','','','ahmadjuhdi007@gmail.com','top_up','2022-01-30 20:14:13'),
('f914db33-fab4-4077-8c89-d85ea37207f8','bank_transfer','settlement','2022-01-25 21:15:45','7e5e458ce65658cbd6a972f0d9df08b84dc89d2714c8d8a7f2afb195324cbcc9db141a0546aba098825f609d43dbd6110682acc4a4c8fa1ea6b382b20ce50a35','TOPUP-1643120105','G005407818',200100,'IDR','9880781891531542','bni','','','ahmadjuhdi007@gmail.com',NULL,NULL),
('fa1dabd6-6736-4f08-b98f-d59d320d8aa9','bank_transfer','settlement','2022-01-29 20:42:44','ec6061c8ce22c68f163bd79fd7e74f718923201fb9061fc6c11f5cef6f235e9fbe4fefb63b9dc4879fa929aa274659ba5314540de19131803c8187f679399b16','TOPUP-1643463764','G005407818',500000,'IDR','0781812345678','bca','','','ahmadjuhdi007@gmail.com','top_up','2022-01-30 20:42:44');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
