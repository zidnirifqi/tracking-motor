/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.8-MariaDB : Database - tracking
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tracking` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `tracking`;

/*Table structure for table `kendaraan` */

DROP TABLE IF EXISTS `kendaraan`;

CREATE TABLE `kendaraan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merk` varchar(20) DEFAULT NULL,
  `plat_nomor` varchar(10) DEFAULT NULL,
  `pengguna` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kendaraan` */

insert  into `kendaraan`(`id`,`merk`,`plat_nomor`,`pengguna`) values 
(1,'Supra 125','AB 1002 NB','Mita'),
(2,'Vario 110','AB 3455 RB','Martin');

/*Table structure for table `lokasi` */

DROP TABLE IF EXISTS `lokasi`;

CREATE TABLE `lokasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kendaraan` int(11) NOT NULL,
  `nama_lokasi` varchar(200) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `batas` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lokasi_ibfk_1` (`id_kendaraan`),
  CONSTRAINT `lokasi_ibfk_1` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `lokasi` */

insert  into `lokasi`(`id`,`id_kendaraan`,`nama_lokasi`,`latitude`,`longitude`,`batas`) values 
(1,1,'Tugu Yogyakarta, Jl. Tugu, Gowongan, Yogyakarta City, Special Region of Yogyakarta, Indonesia','-7.782894799999999','110.3670568',4),
(2,2,'University of Technology Yogyakarta, Jl. Ring Road Utara Jalan Jombor Lor, Mlati Krajan, Sendangadi, Sleman Regency, Special Region of Yogyakarta, Indonesia','-7.747438','110.355399',5),
(5,1,'Trihanggo, Sleman Regency, Special Region of Yogyakarta, Indonesia','-7.753322099999998','110.3457756',5);

/*Table structure for table `riwayat` */

DROP TABLE IF EXISTS `riwayat`;

CREATE TABLE `riwayat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NULL DEFAULT current_timestamp(),
  `id_lokasi` int(11) DEFAULT NULL,
  `latitude_now` varchar(20) DEFAULT NULL,
  `longitude_now` varchar(20) DEFAULT NULL,
  `jarak_now` double DEFAULT NULL,
  `status` enum('Di Izinkan','Di Larang') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_lokasi` (`id_lokasi`),
  CONSTRAINT `riwayat_ibfk_1` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `riwayat` */

insert  into `riwayat`(`id`,`waktu`,`id_lokasi`,`latitude_now`,`longitude_now`,`jarak_now`,`status`) values 
(1,'2020-03-13 20:20:29',1,'-7.749381','110.355452',3.8,'Di Izinkan'),
(2,'2020-03-14 20:20:29',1,'-7.749381','110.3889823',5,'Di Larang'),
(3,'2020-03-13 20:20:29',2,'-7.720245547307145','110.36131698650821',3,'Di Izinkan'),
(4,'2020-03-14 20:20:29',2,'-7.794314600000001','110.3656081',5.5,'Di Larang'),
(5,'2020-03-22 15:30:24',1,'-7.78444444','110.3670568',0.17,'Di Izinkan'),
(6,'2020-03-22 15:30:31',1,'-7.78444444','110.3670568',3,'Di Izinkan');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `roles` enum('admin','pengguna') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`id`,`nama`,`username`,`password`,`roles`) values 
(1,'Administrator','admin','*4ACFE3202A5FF5CF467898FC58AAB1D615029441  ','admin'),
(2,'Satria','satria','*19F7DFBF25337CC120A50A74A7C54DF1850423E1','admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
