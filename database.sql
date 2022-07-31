-- MySQL dump 10.13  Distrib 5.7.33, for Linux (x86_64)
--
-- Host: localhost    Database: prototype_simlabkal
-- ------------------------------------------------------
-- Server version	5.7.33-0ubuntu0.18.04.1-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `calibrations`
--

DROP TABLE IF EXISTS `calibrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calibrations` (
  `id` varchar(100) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `serial_number` text,
  `calibration_officer` varchar(100) DEFAULT NULL,
  `calibration_completion_date` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `typist` varchar(255) DEFAULT NULL,
  `certificate_date` varchar(255) DEFAULT NULL,
  `pickup_date` datetime DEFAULT NULL,
  `pickup` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `calibration_FK` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calibrations`
--

LOCK TABLES `calibrations` WRITE;
/*!40000 ALTER TABLE `calibrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `calibrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_activities`
--

DROP TABLE IF EXISTS `log_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_activities` (
  `id` varchar(255) NOT NULL,
  `user` varchar(100) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_activities`
--

LOCK TABLES `log_activities` WRITE;
/*!40000 ALTER TABLE `log_activities` DISABLE KEYS */;
INSERT INTO `log_activities` VALUES ('611d6cb62d0af','admin','login',NULL,'2021-08-18 20:25:26','2021-08-18 20:25:26'),('612e915f11de0',NULL,'logout',NULL,'2021-08-31 20:30:23','2021-08-31 20:30:23'),('612e916528104','fulanah','login',NULL,'2021-08-31 20:30:29','2021-08-31 20:30:29'),('612e919259b3d',NULL,'logout',NULL,'2021-08-31 20:31:14','2021-08-31 20:31:14'),('612e91946d9dc','admin','login',NULL,'2021-08-31 20:31:16','2021-08-31 20:31:16'),('612e92254c998','admin','logout',NULL,'2021-08-31 20:33:41','2021-08-31 20:33:41'),('612e922758a20','admin','login',NULL,'2021-08-31 20:33:43','2021-08-31 20:33:43'),('612e94a3de794',NULL,'tambah pembelian',NULL,'2021-08-31 20:44:19','2021-08-31 20:44:19'),('612e9514b4f26','admin','logout',NULL,'2021-08-31 20:46:12','2021-08-31 20:46:12'),('612e9516733c2','admin','login',NULL,'2021-08-31 20:46:14','2021-08-31 20:46:14'),('612e95499c8ed','admin','tambah pembelian',NULL,'2021-08-31 20:47:05','2021-08-31 20:47:05'),('612e96c943366','admin','tambah retur pembelian',NULL,'2021-08-31 20:53:29','2021-08-31 20:53:29'),('612e97f336746','admin','tambah penjualan',NULL,'2021-08-31 20:58:27','2021-08-31 20:58:27'),('612e98677b0ab','admin','tambah retur penjualan',NULL,'2021-08-31 21:00:23','2021-08-31 21:00:23'),('612e9992d6624','admin','tambah barang',NULL,'2021-08-31 21:05:22','2021-08-31 21:05:22'),('612e99c00a1e3','admin','update barang',NULL,'2021-08-31 21:06:08','2021-08-31 21:06:08'),('612fd94f5e7f9','admin','login',NULL,'2021-09-01 19:49:35','2021-09-01 19:49:35'),('612fdc593db76','admin','tambah supplier',NULL,'2021-09-01 20:02:33','2021-09-01 20:02:33'),('612fdd7e13a88','admin','tambah pelanggan',NULL,'2021-09-01 20:07:26','2021-09-01 20:07:26'),('612fde883108f','admin','tambah satuan',NULL,'2021-09-01 20:11:52','2021-09-01 20:11:52'),('612fded896ad2','admin','tambah satuan',NULL,'2021-09-01 20:13:12','2021-09-01 20:13:12'),('612fdf1eb5f98','admin','update supplier',NULL,'2021-09-01 20:14:22','2021-09-01 20:14:22'),('612fe022c97e9','admin','tambah golongan',NULL,'2021-09-01 20:18:42','2021-09-01 20:18:42'),('612fe1a92f37f','admin','tambah pembelian',NULL,'2021-09-01 20:25:13','2021-09-01 20:25:13'),('612fe469eb4ed','admin','tambah pembelian',NULL,'2021-09-01 20:36:57','2021-09-01 20:36:57'),('613141f60b27e','admin','login',NULL,'2021-09-02 21:28:22','2021-09-02 21:28:22'),('613204ee2d3c0','admin','login',NULL,'2021-09-03 11:20:14','2021-09-03 11:20:14'),('613281130d7b7','admin','login',NULL,'2021-09-03 20:09:55','2021-09-03 20:09:55'),('61328a24f0a14','admin','update supplier',NULL,'2021-09-03 20:48:36','2021-09-03 20:48:36'),('61328a377b5e7','admin','update supplier',NULL,'2021-09-03 20:48:55','2021-09-03 20:48:55'),('61329285dc48e','admin','delete supplier',NULL,'2021-09-03 21:24:21','2021-09-03 21:24:21'),('613334d53f4bb','admin','login',NULL,'2021-09-04 08:56:53','2021-09-04 08:56:53'),('61333953c0461','admin','update pelanggan',NULL,'2021-09-04 09:16:03','2021-09-04 09:16:03'),('61333a158d509','admin','delete pelanggan',NULL,'2021-09-04 09:19:17','2021-09-04 09:19:17'),('6136837b94fa6','admin','login',NULL,'2021-09-06 21:09:15','2021-09-06 21:09:15'),('6136b4b4c091e','admin','login',NULL,'2021-09-07 00:39:16','2021-09-07 00:39:16'),('613800ffda1a2','admin','login',NULL,'2021-09-08 00:17:03','2021-09-08 00:17:03'),('613809cb33d08','admin','delete satuan',NULL,'2021-09-08 00:54:35','2021-09-08 00:54:35'),('61380a4dd620d','admin','delete satuan',NULL,'2021-09-08 00:56:45','2021-09-08 00:56:45'),('61380ac5eb7fe','admin','delete satuan',NULL,'2021-09-08 00:58:45','2021-09-08 00:58:45'),('613faa0bc1bf7','admin','login',NULL,'2021-09-13 19:44:11','2021-09-13 19:44:11'),('613facfe1d4a7','admin','delete golongan',NULL,'2021-09-13 19:56:46','2021-09-13 19:56:46'),('613fad96be593','admin','delete golongan',NULL,'2021-09-13 19:59:18','2021-09-13 19:59:18'),('613fae5a00d0a','admin','update golongan',NULL,'2021-09-13 20:02:34','2021-09-13 20:02:34'),('6141280ac348e','admin','login',NULL,'2021-09-14 22:54:02','2021-09-14 22:54:02'),('61412ec31dfd0','admin','logout',NULL,'2021-09-14 23:22:43','2021-09-14 23:22:43'),('61412ec531417','admin','login',NULL,'2021-09-14 23:22:45','2021-09-14 23:22:45'),('61429130139cf','admin','login',NULL,'2021-09-16 00:34:56','2021-09-16 00:34:56'),('614295a882668','admin','logout',NULL,'2021-09-16 00:54:00','2021-09-16 00:54:00'),('614295aa176da','admin','login',NULL,'2021-09-16 00:54:02','2021-09-16 00:54:02'),('614295b0cc784','admin','logout',NULL,'2021-09-16 00:54:08','2021-09-16 00:54:08'),('614295b34f07e','admin','login',NULL,'2021-09-16 00:54:11','2021-09-16 00:54:11'),('6142960c9ad6f','admin','logout',NULL,'2021-09-16 00:55:40','2021-09-16 00:55:40'),('6142966da5972','admin','logout',NULL,'2021-09-16 00:57:17','2021-09-16 00:57:17'),('6142969eb7b85','admin','logout',NULL,'2021-09-16 00:58:06','2021-09-16 00:58:06'),('614296a01b891','admin','login',NULL,'2021-09-16 00:58:08','2021-09-16 00:58:08'),('614296af3d75a','admin','logout',NULL,'2021-09-16 00:58:23','2021-09-16 00:58:23'),('614296db7f7cd','admin','logout',NULL,'2021-09-16 00:59:07','2021-09-16 00:59:07'),('61429770ea6f5','admin','logout',NULL,'2021-09-16 01:01:36','2021-09-16 01:01:36'),('6142978b4c609','admin','logout',NULL,'2021-09-16 01:02:03','2021-09-16 01:02:03'),('6142979f6c9d6','admin','logout',NULL,'2021-09-16 01:02:23','2021-09-16 01:02:23'),('61429805a7f33','admin','logout',NULL,'2021-09-16 01:04:05','2021-09-16 01:04:05'),('614298287071a','admin','login',NULL,'2021-09-16 01:04:40','2021-09-16 01:04:40'),('6142986fc32db','admin','logout',NULL,'2021-09-16 01:05:51','2021-09-16 01:05:51'),('61433df3d314e','admin','login',NULL,'2021-09-16 12:52:03','2021-09-16 12:52:03'),('61433df8ed579','admin','logout',NULL,'2021-09-16 12:52:08','2021-09-16 12:52:08'),('61433e138410a','admin','login',NULL,'2021-09-16 12:52:35','2021-09-16 12:52:35'),('61433e1eaf619','admin','logout',NULL,'2021-09-16 12:52:46','2021-09-16 12:52:46'),('61433fdb9dd95','admin','login',NULL,'2021-09-16 13:00:11','2021-09-16 13:00:11'),('6143a97d127a9','admin','login',NULL,'2021-09-16 20:30:53','2021-09-16 20:30:53'),('6143d4146bc50','admin','login',NULL,'2021-09-16 23:32:36','2021-09-16 23:32:36'),('6143d59bbb9c7','admin','logout',NULL,'2021-09-16 23:39:07','2021-09-16 23:39:07'),('6143d59d82aaa','admin','login',NULL,'2021-09-16 23:39:09','2021-09-16 23:39:09'),('6143d7d7983e5','admin','logout',NULL,'2021-09-16 23:48:39','2021-09-16 23:48:39'),('6143d7d935c5f','admin','login',NULL,'2021-09-16 23:48:41','2021-09-16 23:48:41'),('6143d88a76268','admin','logout',NULL,'2021-09-16 23:51:38','2021-09-16 23:51:38'),('6143d88c6c3bd','admin','login',NULL,'2021-09-16 23:51:40','2021-09-16 23:51:40'),('6143d8a56c0ba','admin','logout',NULL,'2021-09-16 23:52:05','2021-09-16 23:52:05'),('6143d8a6b4902','admin','login',NULL,'2021-09-16 23:52:06','2021-09-16 23:52:06'),('6143d9a56c88d','admin','logout',NULL,'2021-09-16 23:56:21','2021-09-16 23:56:21'),('6143d9a71d21c','admin','login',NULL,'2021-09-16 23:56:23','2021-09-16 23:56:23'),('6143db43c1430','admin','logout',NULL,'2021-09-17 00:03:15','2021-09-17 00:03:15'),('6143db459f990','admin','login',NULL,'2021-09-17 00:03:17','2021-09-17 00:03:17'),('6143db798e83f','admin','logout',NULL,'2021-09-17 00:04:09','2021-09-17 00:04:09'),('6143db7b42bac','admin','login',NULL,'2021-09-17 00:04:11','2021-09-17 00:04:11'),('6143dbb19c852','admin','logout',NULL,'2021-09-17 00:05:05','2021-09-17 00:05:05'),('6143dbb2e84c3','admin','login',NULL,'2021-09-17 00:05:06','2021-09-17 00:05:06'),('6143dcff73072','admin','logout',NULL,'2021-09-17 00:10:39','2021-09-17 00:10:39'),('6143dd014a71e','admin','login',NULL,'2021-09-17 00:10:41','2021-09-17 00:10:41'),('6143dd51b0096','admin','login',NULL,'2021-09-17 00:12:01','2021-09-17 00:12:01'),('6143de899966e','admin','logout',NULL,'2021-09-17 00:17:13','2021-09-17 00:17:13'),('6143de8b453ef','admin','login',NULL,'2021-09-17 00:17:15','2021-09-17 00:17:15'),('6143e0547cf11','admin','logout',NULL,'2021-09-17 00:24:52','2021-09-17 00:24:52'),('6143e05620f7b','admin','login',NULL,'2021-09-17 00:24:54','2021-09-17 00:24:54'),('6143e404d0602','admin','logout',NULL,'2021-09-17 00:40:36','2021-09-17 00:40:36'),('6143e406d30da','admin','login',NULL,'2021-09-17 00:40:38','2021-09-17 00:40:38'),('6143e462cd9a4','admin','logout',NULL,'2021-09-17 00:42:10','2021-09-17 00:42:10'),('6143e4649c4e8','admin','login',NULL,'2021-09-17 00:42:12','2021-09-17 00:42:12'),('6144eef4198fa','admin','login',NULL,'2021-09-17 19:39:32','2021-09-17 19:39:32'),('61452d8d41da0','admin','login',NULL,'2021-09-18 00:06:37','2021-09-18 00:06:37'),('61458b4673e5c','admin','login',NULL,'2021-09-18 06:46:30','2021-09-18 06:46:30'),('6148eb7c7f159','admin','login',NULL,'2021-09-20 20:13:48','2021-09-20 20:13:48'),('6149290bf19fd','admin','login',NULL,'2021-09-21 00:36:27','2021-09-21 00:36:28'),('614b8e4e18f3d','admin','login',NULL,'2021-09-22 20:13:02','2021-09-22 20:13:02'),('614ce3e34690d','admin','login',NULL,'2021-09-23 20:30:27','2021-09-23 20:30:27'),('614d1f572ba08','admin','login',NULL,'2021-09-24 00:44:07','2021-09-24 00:44:07'),('614e26924afc7','admin','login',NULL,'2021-09-24 19:27:14','2021-09-24 19:27:14'),('614e37b676e8e','admin','logout',NULL,'2021-09-24 20:40:22','2021-09-24 20:40:22'),('614e37c1afe20','admin','login',NULL,'2021-09-24 20:40:33','2021-09-24 20:40:33'),('614e381c19d47','admin','logout',NULL,'2021-09-24 20:42:04','2021-09-24 20:42:04'),('614e381db349b','admin','login',NULL,'2021-09-24 20:42:05','2021-09-24 20:42:05'),('614ea449b2972','admin','login',NULL,'2021-09-25 04:23:37','2021-09-25 04:23:37'),('614ee3b034bf0','admin','login',NULL,'2021-09-25 08:54:08','2021-09-25 08:54:08'),('614f1d0555ab0','admin','login',NULL,'2021-09-25 12:58:45','2021-09-25 12:58:45'),('614f75ef8ce74','admin','login',NULL,'2021-09-25 19:18:07','2021-09-25 19:18:07'),('614f7cd208cc6','admin','tambah pembelian',NULL,'2021-09-25 19:47:30','2021-09-25 19:47:30'),('614f7e026ddc7','admin','tambah pembelian',NULL,'2021-09-25 19:52:34','2021-09-25 19:52:34'),('614f7f16ddb41','admin','tambah pembelian',NULL,'2021-09-25 19:57:10','2021-09-25 19:57:10'),('614f81f15a3a6','admin','tambah pembelian',NULL,'2021-09-25 20:09:21','2021-09-25 20:09:21'),('614f82b5e0119','admin','tambah pembelian',NULL,'2021-09-25 20:12:37','2021-09-25 20:12:37'),('614f85380c61c','admin','tambah pembelian',NULL,'2021-09-25 20:23:20','2021-09-25 20:23:20'),('614f859479f6a','admin','tambah pembelian',NULL,'2021-09-25 20:24:52','2021-09-25 20:24:52'),('614f8b892d685','admin','tambah pembelian',NULL,'2021-09-25 20:50:17','2021-09-25 20:50:17'),('614f8bba91d30','admin','logout',NULL,'2021-09-25 20:51:06','2021-09-25 20:51:06'),('614f8bbc7d362','admin','login',NULL,'2021-09-25 20:51:08','2021-09-25 20:51:08'),('614faf27b42fa','admin','login',NULL,'2021-09-25 23:22:15','2021-09-25 23:22:15'),('615013d847ac0','admin','tambah pembelian',NULL,'2021-09-26 06:31:52','2021-09-26 06:31:52'),('615015df0bb46','admin','logout',NULL,'2021-09-26 06:40:31','2021-09-26 06:40:31'),('615015e2554f3','kasir','login',NULL,'2021-09-26 06:40:34','2021-09-26 06:40:34'),('615015e9788d3','kasir','logout',NULL,'2021-09-26 06:40:41','2021-09-26 06:40:41'),('615015f161799','admin','login',NULL,'2021-09-26 06:40:49','2021-09-26 06:40:49'),('6150162208a2e','admin','tambah/update menu role',NULL,'2021-09-26 06:41:38','2021-09-26 06:41:38'),('6150162d58fcd','kasir','login',NULL,'2021-09-26 06:41:49','2021-09-26 06:41:49'),('61501633e8621','kasir','logout',NULL,'2021-09-26 06:41:55','2021-09-26 06:41:55'),('61501a5dcd720','admin','tambah/update menu role',NULL,'2021-09-26 06:59:41','2021-09-26 06:59:41'),('61501f0d92fbf','admin','logout',NULL,'2021-09-26 07:19:41','2021-09-26 07:19:41'),('6150471113f04','admin','login',NULL,'2021-09-26 10:10:25','2021-09-26 10:10:25'),('6150c922ee2ef','admin','login',NULL,'2021-09-26 19:25:22','2021-09-26 19:25:23'),('6150d694f0896','admin','tambah pembelian',NULL,'2021-09-26 20:22:44','2021-09-26 20:22:44'),('6152263552f98','admin','login',NULL,'2021-09-27 20:14:45','2021-09-27 20:14:45'),('61539914292dd','admin','login',NULL,'2021-09-28 22:37:08','2021-09-28 22:37:08'),('6153b08e39bc8','admin','tambah penjualan',NULL,'2021-09-29 00:17:18','2021-09-29 00:17:18'),('6153b7d6a7ae0','admin','tambah penjualan',NULL,'2021-09-29 00:48:22','2021-09-29 00:48:22'),('6154fb5325e07','admin','login',NULL,'2021-09-29 23:48:35','2021-09-29 23:48:35'),('6155a57bb90e4','admin','login',NULL,'2021-09-30 06:54:35','2021-09-30 06:54:35'),('615d19c107cf3','admin','login',NULL,'2021-10-05 22:36:33','2021-10-05 22:36:33'),('615d1a0c79a9a','admin','tambah barang',NULL,'2021-10-05 22:37:48','2021-10-05 22:37:48'),('615d1a557ac7f','admin','tambah barang',NULL,'2021-10-05 22:39:01','2021-10-05 22:39:01'),('615d1a8065d69','admin','tambah barang',NULL,'2021-10-05 22:39:44','2021-10-05 22:39:44'),('615d1af7df3a7','admin','tambah barang',NULL,'2021-10-05 22:41:43','2021-10-05 22:41:43'),('615d1bbb869a4','admin','tambah pembelian',NULL,'2021-10-06 03:44:59','2021-10-06 03:44:59'),('615d1c6ee8503','admin','tambah penjualan',NULL,'2021-10-06 03:47:58','2021-10-06 03:47:58'),('615e5be7ed8be','admin','login',NULL,'2021-10-06 21:31:03','2021-10-06 21:31:04'),('615e5c254299f','admin','tambah satuan',NULL,'2021-10-07 02:32:05','2021-10-07 02:32:05'),('615e5cbf3cd19','admin','tambah barang',NULL,'2021-10-06 21:34:39','2021-10-06 21:34:39'),('615e5cea01eb1','admin','tambah barang',NULL,'2021-10-06 21:35:22','2021-10-06 21:35:22'),('615e5ec204a9f','admin','tambah penjualan',NULL,'2021-10-07 02:43:14','2021-10-07 02:43:14'),('615e64abb4a23','admin','login',NULL,'2021-10-06 22:08:27','2021-10-06 22:08:27'),('62e4dba868cbe','admin','login',NULL,'2022-07-30 07:20:08','2022-07-30 07:20:08'),('62e4dd8fb4b19','admin','hapus menu role',NULL,'2022-07-30 07:28:15','2022-07-30 07:28:15'),('62e4dff803abd','admin','tambah/update role',NULL,'2022-07-30 07:38:32','2022-07-30 07:38:32'),('62e4e00211244','admin','tambah role',NULL,'2022-07-30 07:38:42','2022-07-30 07:38:42'),('62e4e02d78d84','admin','tambah role',NULL,'2022-07-30 07:39:25','2022-07-30 07:39:25'),('62e4e03a848e9','admin','tambah/update role',NULL,'2022-07-30 07:39:38','2022-07-30 07:39:38'),('62e4e0402f212','admin','tambah/update role',NULL,'2022-07-30 07:39:44','2022-07-30 07:39:44'),('62e4e0c738adc','admin','tambah/update role',NULL,'2022-07-30 07:41:59','2022-07-30 07:41:59'),('62e4e0ceb12a6','admin','tambah/update role',NULL,'2022-07-30 07:42:06','2022-07-30 07:42:06'),('62e4e4e86ec6d','admin','tambah/update menu role',NULL,'2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e515eee82','admin','tambah/update menu role',NULL,'2022-07-30 08:00:21','2022-07-30 08:00:21'),('62e4e529aa38a','admin','tambah/update menu role',NULL,'2022-07-30 08:00:41','2022-07-30 08:00:41'),('62e4f17d2903b','finance1','login',NULL,'2022-07-30 08:53:17','2022-07-30 08:53:17'),('62e531e614853','admin','tambah orders',NULL,'2022-07-30 13:28:06','2022-07-30 13:28:06'),('62e550bc4b47a','admin','login',NULL,'2022-07-30 15:39:40','2022-07-30 15:39:40'),('62e5535d23cce','admin','tambah orders',NULL,'2022-07-30 15:50:53','2022-07-30 15:50:53'),('62e5541351637','admin','tambah orders',NULL,'2022-07-30 15:53:55','2022-07-30 15:53:55'),('62e5f88917beb','admin','login',NULL,'2022-07-31 03:35:37','2022-07-31 03:35:37'),('62e6022c31f53','admin','update orders',NULL,'2022-07-31 04:16:44','2022-07-31 04:16:44'),('62e60296093b4','admin','update orders',NULL,'2022-07-31 04:18:30','2022-07-31 04:18:30'),('62e6046b40b0e','admin','update orders',NULL,'2022-07-31 04:26:19','2022-07-31 04:26:19'),('62e604b92f092','admin','update orders',NULL,'2022-07-31 04:27:37','2022-07-31 04:27:37'),('62e6050449a09','admin','update orders',NULL,'2022-07-31 04:28:52','2022-07-31 04:28:52'),('62e6147591146','admin','update orders',NULL,'2022-07-31 05:34:45','2022-07-31 05:34:45');
/*!40000 ALTER TABLE `log_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_roles`
--

DROP TABLE IF EXISTS `menu_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_roles` (
  `id` varchar(255) NOT NULL,
  `role_id` varchar(100) DEFAULT NULL,
  `menu_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `menu_roles_FK` (`role_id`),
  CONSTRAINT `menu_roles_FK` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_roles`
--

LOCK TABLES `menu_roles` WRITE;
/*!40000 ALTER TABLE `menu_roles` DISABLE KEYS */;
INSERT INTO `menu_roles` VALUES ('62e4e4e85fa14','5f63cbae56378','610e635e2f301','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa63','5f63cbae56378','610f528cef01f','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa68','5f63cbae56378','610f52dba8925','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa6c','5f63cbae56378','610f6eedbccc2','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa70','5f63cbae56378','610f6f4ee9a50','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa74','5f63cbae56378','610f6eb3598e5','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa78','5f63cbae56378','610f6fe56b7e9','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa7b','5f63cbae56378','610f70b600934','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa7f','5f63cbae56378','610f70cdf09ef','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa83','5f63cbae56378','610f71f28558f','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa86','5f63cbae56378','610f7aa519251','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa8a','5f63cbae56378','610f7ab91f0b6','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa8e','5f63cbae56378','610f7ad64ac97','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa92','5f63cbae56378','610f7af97f690','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa95','5f63cbae56378','610f7b26b3fe3','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa99','5f63cbae56378','610f7b40c36fe','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fa9d','5f63cbae56378','610f7b5c09769','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85faa1','5f63cbae56378','610f7cdb927f7','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85faa5','5f63cbae56378','610f7cf4e3573','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85faa8','5f63cbae56378','610f7d0c747a1','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85faac','5f63cbae56378','610f7d421998e','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fab0','5f63cbae56378','6143db345f801','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fab3','5f63cbae56378','61459517bc158','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fab7','5f63cbae56378','610e635e2f301','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e4e85fabb','5f63cbae56378','61501a5039342','2022-07-30 07:59:36','2022-07-30 07:59:36'),('62e4e515ebe9f','62e4e0020a686','610e635e2f301','2022-07-30 08:00:21','2022-07-30 08:00:21'),('62e4e515ebee6','62e4e0020a686','61501a5039342','2022-07-30 08:00:21','2022-07-30 08:00:21'),('62e4e529a6cdd','62e4e02d707c6','610e635e2f301','2022-07-30 08:00:41','2022-07-30 08:00:41'),('62e4e529a6d2a','62e4e02d707c6','610f6eedbccc2','2022-07-30 08:00:41','2022-07-30 08:00:41'),('62e4e529a6d2e','62e4e02d707c6','610f70cdf09ef','2022-07-30 08:00:41','2022-07-30 08:00:41');
/*!40000 ALTER TABLE `menu_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` varchar(255) NOT NULL,
  `order_number` int(10) unsigned NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES ('610e635e2f301',1,'Dashboard','dashboard',NULL,'fa-dashboard','2021-08-08 03:56:19','2021-08-08 03:56:19'),('610f6eedbccc2',2,'Pemesanan','orders',NULL,'fa-credit-card','2021-08-08 05:43:09','2022-07-30 09:25:55'),('610f6f4ee9a50',8,'Setting',NULL,NULL,'fa-gears','2021-08-08 05:44:46','2021-09-26 20:01:08'),('610f70cdf09ef',4,'Kalibrasi','calibrations',NULL,'fa-credit-card','2021-08-08 05:51:09','2022-07-31 04:51:58'),('610f7cdb927f7',1,'Pengguna','users','610f6f4ee9a50',NULL,'2021-08-08 06:42:35','2021-08-08 06:42:35'),('610f7cf4e3573',2,'Role','roles','610f6f4ee9a50',NULL,'2021-08-08 06:43:00','2021-08-08 06:43:00'),('610f7d0c747a1',3,'Backup Database','backup','610f6f4ee9a50',NULL,'2021-08-08 06:43:24','2021-08-08 06:43:24'),('610f7d421998e',4,'Menu','menus','610f6f4ee9a50','fa-menu','2021-08-08 06:44:18','2021-09-16 00:44:45'),('61501a5039342',3,'Keuangan','finance',NULL,'fa-credit-card','2021-09-26 06:59:28','2022-07-30 07:45:08');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `order_number` varchar(100) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `address` text,
  `phone_number` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `certificate_address` varchar(255) DEFAULT NULL,
  `certificate_delivery_address` varchar(255) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `npwp_address` varchar(255) DEFAULT NULL,
  `bill_address` varchar(255) DEFAULT NULL,
  `contact_person_for_finance` varchar(255) DEFAULT NULL,
  `status_po` tinyint(1) DEFAULT '0',
  `spm` int(11) DEFAULT NULL,
  `tracking_number` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_un` (`order_number`),
  KEY `order_FK` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES ('62e554134dd87','c0912b81-fdd8-11e8-88db-d46e0e1bc63c','202207C21','2022-07-30','rizqy','02323222','bandung',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,2,'2022-07-30 22:53:55','2022-07-31 12:34:45');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_un` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES ('5f63cbae56378','admin','2021-07-11 04:59:20','2022-07-30 07:38:31'),('62e4e0020a686','finance','2022-07-30 07:38:42','2022-07-30 07:38:42'),('62e4e02d707c6','operator','2022-07-30 07:39:25','2022-07-30 07:42:06');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` varchar(200) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` text NOT NULL,
  `level` enum('admin','user') NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('60ea8a8e18c0b','operator1','b3cf27523841b5088f4c543773bec2e24c8551114acfc56c1543ee8f1e8c253cb21fd1c3be0bd7d132e6c63b2b0477feca4795c30d81e70feaad302f9081bc2cJ5zajgz5JJ4n3ph4+wr5ayS09R+z+cSRRXfaIxpgrLg=','admin','Operator 1','62e4e02d707c6','','2021-07-11 06:07:10','2022-07-30 08:01:44'),('615015da9375c','finance1','8b4cfdf2c0c5e003dd20edebc45066711f83ac61f55695522dcc4cb5cfc6b864b2f9964ce001339d61ea612bc9fd886bc1036fc176d17e3d0b79888022de12ba5VPReV6IL/MpLkDhy7Z78hgvfIpZHfigRkFUFHaVnq8=','admin','Keuangan 1','62e4e0020a686','','2021-09-26 06:40:26','2022-07-30 08:02:12'),('c0912b81-fdd8-11e8-88db-d46e0e1bc63c','admin','4e60fb3509b3abc1f099c66d7400456645331f2672c147d1cc3ec7ebc55e0310a39c2c9e41ddde3ba1f9a6fe2dbd4f490607f2b8a4fead41135a601994277097vq5/wZ3FoRwnn0TdSRTWfkOzy5/AVniWomZE3L1rVYk=','admin','administrator','5f63cbae56378','','2021-07-11 06:07:05','2022-07-30 08:01:05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'prototype_simlabkal'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-31 16:11:48
