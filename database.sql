#
# TABLE STRUCTURE FOR: customers
#

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL COMMENT 'Phone Number',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `customers` (`id`, `name`, `address`, `contact`, `created_at`, `updated_at`) VALUES ('603fa97b0a810', 'Ucok', 'Ciparay', '02222', '2021-03-03 22:21:31', '2021-03-03 22:21:31');
INSERT INTO `customers` (`id`, `name`, `address`, `contact`, `created_at`, `updated_at`) VALUES ('60604ce8db05f', 'bebas', 'bebas            ', '123', '2021-03-28 16:31:20', '2021-03-28 16:31:20');
INSERT INTO `customers` (`id`, `name`, `address`, `contact`, `created_at`, `updated_at`) VALUES ('60ec62ec943b8', 'asep', 'majalaya            ', '8989', '2021-07-12 22:42:36', '2021-07-12 22:42:36');
INSERT INTO `customers` (`id`, `name`, `address`, `contact`, `created_at`, `updated_at`) VALUES ('612fdd7e1121c', 'ujang', 'ciparay            ', '085159000758', '2021-09-02 03:07:26', '2021-09-04 16:16:03');

#
# TABLE STRUCTURE FOR: products
#

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `ownership` varchar(100) DEFAULT NULL,
  `denomination` varchar(100) DEFAULT NULL,
  `denomination_detail` varchar(100) DEFAULT NULL,
  `selling_price` int(11) DEFAULT NULL,
  `batch_number_product` varchar(100) DEFAULT NULL,
  `expired_date` datetime DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_un` (`name`),
  FULLTEXT KEY `products_name_IDX` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `products` (`id`, `name`, `price`, `product_barcode`, `created_at`, `updated_at`, `type`, `ownership`, `denomination`, `denomination_detail`, `selling_price`, `batch_number_product`, `expired_date`, `stock`) VALUES ('615d1a0c3c833', 'vipcol syrup', NULL, '', '2021-10-06 05:37:48', '2021-10-06 10:47:58', '60fcff88bda14', 'sendiri', NULL, NULL, NULL, '252511', NULL, -5);
INSERT INTO `products` (`id`, `name`, `price`, `product_barcode`, `created_at`, `updated_at`, `type`, `ownership`, `denomination`, `denomination_detail`, `selling_price`, `batch_number_product`, `expired_date`, `stock`) VALUES ('615d1a8049664', 'bodrex tab', NULL, '', '2021-10-06 05:39:44', '2021-10-06 05:39:44', '60fcff88bda14', 'sendiri', NULL, NULL, NULL, '', NULL, 0);
INSERT INTO `products` (`id`, `name`, `price`, `product_barcode`, `created_at`, `updated_at`, `type`, `ownership`, `denomination`, `denomination_detail`, `selling_price`, `batch_number_product`, `expired_date`, `stock`) VALUES ('615d1af7d0b71', 'obh itrasal', NULL, '', '2021-10-06 05:41:43', '2021-10-06 10:47:58', '60fcff88bda14', 'sendiri', NULL, NULL, NULL, '2556564', NULL, -5);
INSERT INTO `products` (`id`, `name`, `price`, `product_barcode`, `created_at`, `updated_at`, `type`, `ownership`, `denomination`, `denomination_detail`, `selling_price`, `batch_number_product`, `expired_date`, `stock`) VALUES ('615e5cbec4b42', 'mucos syrup', NULL, '', '2021-10-07 04:34:38', '2021-10-07 09:43:13', '612fe022c924c', 'sendiri', NULL, NULL, NULL, '', NULL, -7);
INSERT INTO `products` (`id`, `name`, `price`, `product_barcode`, `created_at`, `updated_at`, `type`, `ownership`, `denomination`, `denomination_detail`, `selling_price`, `batch_number_product`, `expired_date`, `stock`) VALUES ('615e5ce9c212e', 'mucos drop', NULL, '', '2021-10-07 04:35:21', '2021-10-07 09:43:13', '612fe022c924c', 'sendiri', NULL, NULL, NULL, '', NULL, -1);

#
# TABLE STRUCTURE FOR: denominations
#

DROP TABLE IF EXISTS `denominations`;

CREATE TABLE `denominations` (
  `id` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `size` enum('besar','kecil') DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `denominations` (`id`, `name`, `size`, `priority`, `created_at`, `updated_at`) VALUES ('60f1f0f03633d', 'dus', 'besar', 2, '2021-07-17 03:49:52', '2021-08-15 13:58:02');
INSERT INTO `denominations` (`id`, `name`, `size`, `priority`, `created_at`, `updated_at`) VALUES ('60f1f10dc2e78', 'strip', 'kecil', 1, '2021-07-17 03:50:21', '2021-08-15 13:57:54');
INSERT INTO `denominations` (`id`, `name`, `size`, `priority`, `created_at`, `updated_at`) VALUES ('60f26c2c6af61', 'box', 'besar', 3, '2021-07-17 12:35:40', '2021-08-15 13:58:07');
INSERT INTO `denominations` (`id`, `name`, `size`, `priority`, `created_at`, `updated_at`) VALUES ('612fde8830a55', 'tablet', 'kecil', 1, '2021-09-02 03:11:52', '2021-09-02 03:14:22');
INSERT INTO `denominations` (`id`, `name`, `size`, `priority`, `created_at`, `updated_at`) VALUES ('615e5c251662d', 'Botol', 'kecil', 1, '2021-10-07 09:32:05', '2021-10-07 09:32:05');

#
# TABLE STRUCTURE FOR: denomination_conversions
#

DROP TABLE IF EXISTS `denomination_conversions`;

CREATE TABLE `denomination_conversions` (
  `id` varchar(100) NOT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `denomination_id` varchar(100) DEFAULT NULL,
  `denomination_conversion_id` varchar(100) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `denomination_conversions_FK` (`denomination_id`),
  KEY `denomination_conversions_FK_1` (`denomination_conversion_id`),
  KEY `denomination_conversions_FK_2` (`product_id`),
  CONSTRAINT `denomination_conversions_FK` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `denomination_conversions_FK_1` FOREIGN KEY (`denomination_conversion_id`) REFERENCES `denominations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `denomination_conversions_FK_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `denomination_conversions` (`id`, `product_id`, `denomination_id`, `denomination_conversion_id`, `count`, `created_at`, `updated_at`) VALUES ('612d452cb2365', NULL, '60f1f0f03633d', '60f1f10dc2e78', 10, '2021-08-31 03:53:00', '2021-08-31 03:53:00');




#
# TABLE STRUCTURE FOR: log_activities
#

DROP TABLE IF EXISTS `log_activities`;

CREATE TABLE `log_activities` (
  `id` varchar(255) NOT NULL,
  `user` varchar(100) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('611d6cb62d0af', 'admin', 'login', NULL, '2021-08-19 03:25:26', '2021-08-19 03:25:26');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e915f11de0', NULL, 'logout', NULL, '2021-09-01 03:30:23', '2021-09-01 03:30:23');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e916528104', 'fulanah', 'login', NULL, '2021-09-01 03:30:29', '2021-09-01 03:30:29');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e919259b3d', NULL, 'logout', NULL, '2021-09-01 03:31:14', '2021-09-01 03:31:14');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e91946d9dc', 'admin', 'login', NULL, '2021-09-01 03:31:16', '2021-09-01 03:31:16');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e92254c998', 'admin', 'logout', NULL, '2021-09-01 03:33:41', '2021-09-01 03:33:41');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e922758a20', 'admin', 'login', NULL, '2021-09-01 03:33:43', '2021-09-01 03:33:43');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e94a3de794', NULL, 'tambah pembelian', NULL, '2021-09-01 03:44:19', '2021-09-01 03:44:19');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e9514b4f26', 'admin', 'logout', NULL, '2021-09-01 03:46:12', '2021-09-01 03:46:12');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e9516733c2', 'admin', 'login', NULL, '2021-09-01 03:46:14', '2021-09-01 03:46:14');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e95499c8ed', 'admin', 'tambah pembelian', NULL, '2021-09-01 03:47:05', '2021-09-01 03:47:05');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e96c943366', 'admin', 'tambah retur pembelian', NULL, '2021-09-01 03:53:29', '2021-09-01 03:53:29');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e97f336746', 'admin', 'tambah penjualan', NULL, '2021-09-01 03:58:27', '2021-09-01 03:58:27');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e98677b0ab', 'admin', 'tambah retur penjualan', NULL, '2021-09-01 04:00:23', '2021-09-01 04:00:23');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e9992d6624', 'admin', 'tambah barang', NULL, '2021-09-01 04:05:22', '2021-09-01 04:05:22');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612e99c00a1e3', 'admin', 'update barang', NULL, '2021-09-01 04:06:08', '2021-09-01 04:06:08');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612fd94f5e7f9', 'admin', 'login', NULL, '2021-09-02 02:49:35', '2021-09-02 02:49:35');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612fdc593db76', 'admin', 'tambah supplier', NULL, '2021-09-02 03:02:33', '2021-09-02 03:02:33');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612fdd7e13a88', 'admin', 'tambah pelanggan', NULL, '2021-09-02 03:07:26', '2021-09-02 03:07:26');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612fde883108f', 'admin', 'tambah satuan', NULL, '2021-09-02 03:11:52', '2021-09-02 03:11:52');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612fded896ad2', 'admin', 'tambah satuan', NULL, '2021-09-02 03:13:12', '2021-09-02 03:13:12');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612fdf1eb5f98', 'admin', 'update supplier', NULL, '2021-09-02 03:14:22', '2021-09-02 03:14:22');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612fe022c97e9', 'admin', 'tambah golongan', NULL, '2021-09-02 03:18:42', '2021-09-02 03:18:42');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612fe1a92f37f', 'admin', 'tambah pembelian', NULL, '2021-09-02 03:25:13', '2021-09-02 03:25:13');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('612fe469eb4ed', 'admin', 'tambah pembelian', NULL, '2021-09-02 03:36:57', '2021-09-02 03:36:57');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('613141f60b27e', 'admin', 'login', NULL, '2021-09-03 04:28:22', '2021-09-03 04:28:22');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('613204ee2d3c0', 'admin', 'login', NULL, '2021-09-03 18:20:14', '2021-09-03 18:20:14');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('613281130d7b7', 'admin', 'login', NULL, '2021-09-04 03:09:55', '2021-09-04 03:09:55');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61328a24f0a14', 'admin', 'update supplier', NULL, '2021-09-04 03:48:36', '2021-09-04 03:48:36');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61328a377b5e7', 'admin', 'update supplier', NULL, '2021-09-04 03:48:55', '2021-09-04 03:48:55');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61329285dc48e', 'admin', 'delete supplier', NULL, '2021-09-04 04:24:21', '2021-09-04 04:24:21');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('613334d53f4bb', 'admin', 'login', NULL, '2021-09-04 15:56:53', '2021-09-04 15:56:53');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61333953c0461', 'admin', 'update pelanggan', NULL, '2021-09-04 16:16:03', '2021-09-04 16:16:03');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61333a158d509', 'admin', 'delete pelanggan', NULL, '2021-09-04 16:19:17', '2021-09-04 16:19:17');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6136837b94fa6', 'admin', 'login', NULL, '2021-09-07 04:09:15', '2021-09-07 04:09:15');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6136b4b4c091e', 'admin', 'login', NULL, '2021-09-07 07:39:16', '2021-09-07 07:39:16');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('613800ffda1a2', 'admin', 'login', NULL, '2021-09-08 07:17:03', '2021-09-08 07:17:03');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('613809cb33d08', 'admin', 'delete satuan', NULL, '2021-09-08 07:54:35', '2021-09-08 07:54:35');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61380a4dd620d', 'admin', 'delete satuan', NULL, '2021-09-08 07:56:45', '2021-09-08 07:56:45');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61380ac5eb7fe', 'admin', 'delete satuan', NULL, '2021-09-08 07:58:45', '2021-09-08 07:58:45');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('613faa0bc1bf7', 'admin', 'login', NULL, '2021-09-14 02:44:11', '2021-09-14 02:44:11');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('613facfe1d4a7', 'admin', 'delete golongan', NULL, '2021-09-14 02:56:46', '2021-09-14 02:56:46');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('613fad96be593', 'admin', 'delete golongan', NULL, '2021-09-14 02:59:18', '2021-09-14 02:59:18');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('613fae5a00d0a', 'admin', 'update golongan', NULL, '2021-09-14 03:02:34', '2021-09-14 03:02:34');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6141280ac348e', 'admin', 'login', NULL, '2021-09-15 05:54:02', '2021-09-15 05:54:02');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61412ec31dfd0', 'admin', 'logout', NULL, '2021-09-15 06:22:43', '2021-09-15 06:22:43');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61412ec531417', 'admin', 'login', NULL, '2021-09-15 06:22:45', '2021-09-15 06:22:45');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61429130139cf', 'admin', 'login', NULL, '2021-09-16 07:34:56', '2021-09-16 07:34:56');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614295a882668', 'admin', 'logout', NULL, '2021-09-16 07:54:00', '2021-09-16 07:54:00');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614295aa176da', 'admin', 'login', NULL, '2021-09-16 07:54:02', '2021-09-16 07:54:02');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614295b0cc784', 'admin', 'logout', NULL, '2021-09-16 07:54:08', '2021-09-16 07:54:08');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614295b34f07e', 'admin', 'login', NULL, '2021-09-16 07:54:11', '2021-09-16 07:54:11');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6142960c9ad6f', 'admin', 'logout', NULL, '2021-09-16 07:55:40', '2021-09-16 07:55:40');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6142966da5972', 'admin', 'logout', NULL, '2021-09-16 07:57:17', '2021-09-16 07:57:17');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6142969eb7b85', 'admin', 'logout', NULL, '2021-09-16 07:58:06', '2021-09-16 07:58:06');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614296a01b891', 'admin', 'login', NULL, '2021-09-16 07:58:08', '2021-09-16 07:58:08');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614296af3d75a', 'admin', 'logout', NULL, '2021-09-16 07:58:23', '2021-09-16 07:58:23');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614296db7f7cd', 'admin', 'logout', NULL, '2021-09-16 07:59:07', '2021-09-16 07:59:07');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61429770ea6f5', 'admin', 'logout', NULL, '2021-09-16 08:01:36', '2021-09-16 08:01:36');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6142978b4c609', 'admin', 'logout', NULL, '2021-09-16 08:02:03', '2021-09-16 08:02:03');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6142979f6c9d6', 'admin', 'logout', NULL, '2021-09-16 08:02:23', '2021-09-16 08:02:23');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61429805a7f33', 'admin', 'logout', NULL, '2021-09-16 08:04:05', '2021-09-16 08:04:05');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614298287071a', 'admin', 'login', NULL, '2021-09-16 08:04:40', '2021-09-16 08:04:40');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6142986fc32db', 'admin', 'logout', NULL, '2021-09-16 08:05:51', '2021-09-16 08:05:51');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61433df3d314e', 'admin', 'login', NULL, '2021-09-16 19:52:03', '2021-09-16 19:52:03');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61433df8ed579', 'admin', 'logout', NULL, '2021-09-16 19:52:08', '2021-09-16 19:52:08');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61433e138410a', 'admin', 'login', NULL, '2021-09-16 19:52:35', '2021-09-16 19:52:35');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61433e1eaf619', 'admin', 'logout', NULL, '2021-09-16 19:52:46', '2021-09-16 19:52:46');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61433fdb9dd95', 'admin', 'login', NULL, '2021-09-16 20:00:11', '2021-09-16 20:00:11');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143a97d127a9', 'admin', 'login', NULL, '2021-09-17 03:30:53', '2021-09-17 03:30:53');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143d4146bc50', 'admin', 'login', NULL, '2021-09-17 06:32:36', '2021-09-17 06:32:36');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143d59bbb9c7', 'admin', 'logout', NULL, '2021-09-17 06:39:07', '2021-09-17 06:39:07');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143d59d82aaa', 'admin', 'login', NULL, '2021-09-17 06:39:09', '2021-09-17 06:39:09');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143d7d7983e5', 'admin', 'logout', NULL, '2021-09-17 06:48:39', '2021-09-17 06:48:39');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143d7d935c5f', 'admin', 'login', NULL, '2021-09-17 06:48:41', '2021-09-17 06:48:41');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143d88a76268', 'admin', 'logout', NULL, '2021-09-17 06:51:38', '2021-09-17 06:51:38');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143d88c6c3bd', 'admin', 'login', NULL, '2021-09-17 06:51:40', '2021-09-17 06:51:40');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143d8a56c0ba', 'admin', 'logout', NULL, '2021-09-17 06:52:05', '2021-09-17 06:52:05');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143d8a6b4902', 'admin', 'login', NULL, '2021-09-17 06:52:06', '2021-09-17 06:52:06');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143d9a56c88d', 'admin', 'logout', NULL, '2021-09-17 06:56:21', '2021-09-17 06:56:21');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143d9a71d21c', 'admin', 'login', NULL, '2021-09-17 06:56:23', '2021-09-17 06:56:23');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143db43c1430', 'admin', 'logout', NULL, '2021-09-17 07:03:15', '2021-09-17 07:03:15');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143db459f990', 'admin', 'login', NULL, '2021-09-17 07:03:17', '2021-09-17 07:03:17');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143db798e83f', 'admin', 'logout', NULL, '2021-09-17 07:04:09', '2021-09-17 07:04:09');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143db7b42bac', 'admin', 'login', NULL, '2021-09-17 07:04:11', '2021-09-17 07:04:11');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143dbb19c852', 'admin', 'logout', NULL, '2021-09-17 07:05:05', '2021-09-17 07:05:05');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143dbb2e84c3', 'admin', 'login', NULL, '2021-09-17 07:05:06', '2021-09-17 07:05:06');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143dcff73072', 'admin', 'logout', NULL, '2021-09-17 07:10:39', '2021-09-17 07:10:39');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143dd014a71e', 'admin', 'login', NULL, '2021-09-17 07:10:41', '2021-09-17 07:10:41');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143dd51b0096', 'admin', 'login', NULL, '2021-09-17 07:12:01', '2021-09-17 07:12:01');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143de899966e', 'admin', 'logout', NULL, '2021-09-17 07:17:13', '2021-09-17 07:17:13');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143de8b453ef', 'admin', 'login', NULL, '2021-09-17 07:17:15', '2021-09-17 07:17:15');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143e0547cf11', 'admin', 'logout', NULL, '2021-09-17 07:24:52', '2021-09-17 07:24:52');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143e05620f7b', 'admin', 'login', NULL, '2021-09-17 07:24:54', '2021-09-17 07:24:54');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143e404d0602', 'admin', 'logout', NULL, '2021-09-17 07:40:36', '2021-09-17 07:40:36');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143e406d30da', 'admin', 'login', NULL, '2021-09-17 07:40:38', '2021-09-17 07:40:38');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143e462cd9a4', 'admin', 'logout', NULL, '2021-09-17 07:42:10', '2021-09-17 07:42:10');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6143e4649c4e8', 'admin', 'login', NULL, '2021-09-17 07:42:12', '2021-09-17 07:42:12');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6144eef4198fa', 'admin', 'login', NULL, '2021-09-18 02:39:32', '2021-09-18 02:39:32');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61452d8d41da0', 'admin', 'login', NULL, '2021-09-18 07:06:37', '2021-09-18 07:06:37');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61458b4673e5c', 'admin', 'login', NULL, '2021-09-18 13:46:30', '2021-09-18 13:46:30');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6148eb7c7f159', 'admin', 'login', NULL, '2021-09-21 03:13:48', '2021-09-21 03:13:48');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6149290bf19fd', 'admin', 'login', NULL, '2021-09-21 07:36:27', '2021-09-21 07:36:28');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614b8e4e18f3d', 'admin', 'login', NULL, '2021-09-23 03:13:02', '2021-09-23 03:13:02');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614ce3e34690d', 'admin', 'login', NULL, '2021-09-24 03:30:27', '2021-09-24 03:30:27');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614d1f572ba08', 'admin', 'login', NULL, '2021-09-24 07:44:07', '2021-09-24 07:44:07');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614e26924afc7', 'admin', 'login', NULL, '2021-09-25 02:27:14', '2021-09-25 02:27:14');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614e37b676e8e', 'admin', 'logout', NULL, '2021-09-25 03:40:22', '2021-09-25 03:40:22');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614e37c1afe20', 'admin', 'login', NULL, '2021-09-25 03:40:33', '2021-09-25 03:40:33');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614e381c19d47', 'admin', 'logout', NULL, '2021-09-25 03:42:04', '2021-09-25 03:42:04');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614e381db349b', 'admin', 'login', NULL, '2021-09-25 03:42:05', '2021-09-25 03:42:05');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614ea449b2972', 'admin', 'login', NULL, '2021-09-25 11:23:37', '2021-09-25 11:23:37');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614ee3b034bf0', 'admin', 'login', NULL, '2021-09-25 15:54:08', '2021-09-25 15:54:08');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f1d0555ab0', 'admin', 'login', NULL, '2021-09-25 19:58:45', '2021-09-25 19:58:45');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f75ef8ce74', 'admin', 'login', NULL, '2021-09-26 02:18:07', '2021-09-26 02:18:07');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f7cd208cc6', 'admin', 'tambah pembelian', NULL, '2021-09-26 02:47:30', '2021-09-26 02:47:30');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f7e026ddc7', 'admin', 'tambah pembelian', NULL, '2021-09-26 02:52:34', '2021-09-26 02:52:34');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f7f16ddb41', 'admin', 'tambah pembelian', NULL, '2021-09-26 02:57:10', '2021-09-26 02:57:10');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f81f15a3a6', 'admin', 'tambah pembelian', NULL, '2021-09-26 03:09:21', '2021-09-26 03:09:21');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f82b5e0119', 'admin', 'tambah pembelian', NULL, '2021-09-26 03:12:37', '2021-09-26 03:12:37');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f85380c61c', 'admin', 'tambah pembelian', NULL, '2021-09-26 03:23:20', '2021-09-26 03:23:20');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f859479f6a', 'admin', 'tambah pembelian', NULL, '2021-09-26 03:24:52', '2021-09-26 03:24:52');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f8b892d685', 'admin', 'tambah pembelian', NULL, '2021-09-26 03:50:17', '2021-09-26 03:50:17');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f8bba91d30', 'admin', 'logout', NULL, '2021-09-26 03:51:06', '2021-09-26 03:51:06');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614f8bbc7d362', 'admin', 'login', NULL, '2021-09-26 03:51:08', '2021-09-26 03:51:08');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('614faf27b42fa', 'admin', 'login', NULL, '2021-09-26 06:22:15', '2021-09-26 06:22:15');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615013d847ac0', 'admin', 'tambah pembelian', NULL, '2021-09-26 13:31:52', '2021-09-26 13:31:52');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615015df0bb46', 'admin', 'logout', NULL, '2021-09-26 13:40:31', '2021-09-26 13:40:31');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615015e2554f3', 'kasir', 'login', NULL, '2021-09-26 13:40:34', '2021-09-26 13:40:34');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615015e9788d3', 'kasir', 'logout', NULL, '2021-09-26 13:40:41', '2021-09-26 13:40:41');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615015f161799', 'admin', 'login', NULL, '2021-09-26 13:40:49', '2021-09-26 13:40:49');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6150162208a2e', 'admin', 'tambah/update menu role', NULL, '2021-09-26 13:41:38', '2021-09-26 13:41:38');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6150162d58fcd', 'kasir', 'login', NULL, '2021-09-26 13:41:49', '2021-09-26 13:41:49');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61501633e8621', 'kasir', 'logout', NULL, '2021-09-26 13:41:55', '2021-09-26 13:41:55');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61501a5dcd720', 'admin', 'tambah/update menu role', NULL, '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61501f0d92fbf', 'admin', 'logout', NULL, '2021-09-26 14:19:41', '2021-09-26 14:19:41');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6150471113f04', 'admin', 'login', NULL, '2021-09-26 17:10:25', '2021-09-26 17:10:25');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6150c922ee2ef', 'admin', 'login', NULL, '2021-09-27 02:25:22', '2021-09-27 02:25:23');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6150d694f0896', 'admin', 'tambah pembelian', NULL, '2021-09-27 03:22:44', '2021-09-27 03:22:44');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6152263552f98', 'admin', 'login', NULL, '2021-09-28 03:14:45', '2021-09-28 03:14:45');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('61539914292dd', 'admin', 'login', NULL, '2021-09-29 05:37:08', '2021-09-29 05:37:08');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6153b08e39bc8', 'admin', 'tambah penjualan', NULL, '2021-09-29 07:17:18', '2021-09-29 07:17:18');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6153b7d6a7ae0', 'admin', 'tambah penjualan', NULL, '2021-09-29 07:48:22', '2021-09-29 07:48:22');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6154fb5325e07', 'admin', 'login', NULL, '2021-09-30 06:48:35', '2021-09-30 06:48:35');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('6155a57bb90e4', 'admin', 'login', NULL, '2021-09-30 13:54:35', '2021-09-30 13:54:35');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615d19c107cf3', 'admin', 'login', NULL, '2021-10-06 05:36:33', '2021-10-06 05:36:33');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615d1a0c79a9a', 'admin', 'tambah barang', NULL, '2021-10-06 05:37:48', '2021-10-06 05:37:48');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615d1a557ac7f', 'admin', 'tambah barang', NULL, '2021-10-06 05:39:01', '2021-10-06 05:39:01');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615d1a8065d69', 'admin', 'tambah barang', NULL, '2021-10-06 05:39:44', '2021-10-06 05:39:44');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615d1af7df3a7', 'admin', 'tambah barang', NULL, '2021-10-06 05:41:43', '2021-10-06 05:41:43');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615d1bbb869a4', 'admin', 'tambah pembelian', NULL, '2021-10-06 10:44:59', '2021-10-06 10:44:59');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615d1c6ee8503', 'admin', 'tambah penjualan', NULL, '2021-10-06 10:47:58', '2021-10-06 10:47:58');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615e5be7ed8be', 'admin', 'login', NULL, '2021-10-07 04:31:03', '2021-10-07 04:31:04');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615e5c254299f', 'admin', 'tambah satuan', NULL, '2021-10-07 09:32:05', '2021-10-07 09:32:05');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615e5cbf3cd19', 'admin', 'tambah barang', NULL, '2021-10-07 04:34:39', '2021-10-07 04:34:39');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615e5cea01eb1', 'admin', 'tambah barang', NULL, '2021-10-07 04:35:22', '2021-10-07 04:35:22');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615e5ec204a9f', 'admin', 'tambah penjualan', NULL, '2021-10-07 09:43:14', '2021-10-07 09:43:14');
INSERT INTO `log_activities` (`id`, `user`, `activity`, `description`, `created_at`, `updated_at`) VALUES ('615e64abb4a23', 'admin', 'login', NULL, '2021-10-07 05:08:27', '2021-10-07 05:08:27');


#
# TABLE STRUCTURE FOR: roles
#

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_un` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES ('5f63cbae56378', 'admin', '2021-07-11 11:59:20', '2021-07-11 11:59:20');
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES ('60ea7aae3d98f', 'kasir', '2021-07-11 11:59:26', '2021-07-11 11:59:26');

#
# TABLE STRUCTURE FOR: menu_roles
#

DROP TABLE IF EXISTS `menu_roles`;

CREATE TABLE `menu_roles` (
  `id` varchar(255) NOT NULL,
  `role_id` varchar(100) DEFAULT NULL,
  `menu_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `menu_roles_FK` (`role_id`),
  CONSTRAINT `menu_roles_FK` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('6150162204ee2', '60ea7aae3d98f', '610e635e2f301', '2021-09-26 13:41:38', '2021-09-26 13:41:38');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('6150162204f58', '60ea7aae3d98f', '610f528cef01f', '2021-09-26 13:41:38', '2021-09-26 13:41:38');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('6150162204f76', '60ea7aae3d98f', '610e635e2f301', '2021-09-26 13:41:38', '2021-09-26 13:41:38');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('6150162204f95', '60ea7aae3d98f', '610f528cef01f', '2021-09-26 13:41:38', '2021-09-26 13:41:38');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('6150162204fb2', '60ea7aae3d98f', '610f70cdf09ef', '2021-09-26 13:41:38', '2021-09-26 13:41:38');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('6150162204fcf', '60ea7aae3d98f', '610f71f28558f', '2021-09-26 13:41:38', '2021-09-26 13:41:38');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('6150162204feb', '60ea7aae3d98f', '610f6fe56b7e9', '2021-09-26 13:41:38', '2021-09-26 13:41:38');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('615016220500a', '60ea7aae3d98f', '610f70b600934', '2021-09-26 13:41:38', '2021-09-26 13:41:38');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('6150162205029', '60ea7aae3d98f', '6143db345f801', '2021-09-26 13:41:38', '2021-09-26 13:41:38');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc77ce', '5f63cbae56378', '610e635e2f301', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7831', '5f63cbae56378', '610f528cef01f', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc784e', '5f63cbae56378', '610f52dba8925', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7869', '5f63cbae56378', '610f6eedbccc2', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7885', '5f63cbae56378', '610f6f4ee9a50', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc78a1', '5f63cbae56378', '610f6eb3598e5', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc78bc', '5f63cbae56378', '610f6fe56b7e9', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc78d8', '5f63cbae56378', '610f70b600934', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc78f3', '5f63cbae56378', '610f70cdf09ef', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc790f', '5f63cbae56378', '610f71f28558f', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc792b', '5f63cbae56378', '610f7aa519251', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7946', '5f63cbae56378', '610f7ab91f0b6', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7962', '5f63cbae56378', '610f7ad64ac97', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc797e', '5f63cbae56378', '610f7af97f690', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc799c', '5f63cbae56378', '610f7b26b3fe3', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc79c2', '5f63cbae56378', '610f7b40c36fe', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc79eb', '5f63cbae56378', '610f7b5c09769', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7a14', '5f63cbae56378', '610f7cdb927f7', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7a40', '5f63cbae56378', '610f7cf4e3573', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7a5d', '5f63cbae56378', '610f7d0c747a1', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7a7b', '5f63cbae56378', '610f7d421998e', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7a99', '5f63cbae56378', '6143db345f801', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7ab6', '5f63cbae56378', '61459517bc158', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7ad3', '5f63cbae56378', '610e635e2f301', '2021-09-26 13:59:41', '2021-09-26 13:59:41');
INSERT INTO `menu_roles` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES ('61501a5dc7af1', '5f63cbae56378', '61501a5039342', '2021-09-26 13:59:41', '2021-09-26 13:59:41');


#
# TABLE STRUCTURE FOR: menus
#

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` varchar(255) NOT NULL,
  `order_number` int(10) unsigned NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610e635e2f301', 1, 'Dashboard', 'dashboard', NULL, 'fa-dashboard', '2021-08-08 10:56:19', '2021-08-08 10:56:19');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f528cef01f', 3, 'Penjualan', NULL, NULL, 'fa-shopping-cart', '2021-08-08 10:56:19', '2021-09-16 07:52:34');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f52dba8925', 4, 'Laporan', 'laporan', NULL, 'fa-bar-chart', '2021-08-08 10:56:19', '2021-08-08 12:42:55');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f6eb3598e5', 5, 'Data Master', NULL, NULL, 'fa-cubes', '2021-08-08 12:42:11', '2021-08-08 12:42:11');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f6eedbccc2', 6, 'Kartu Stok', 'kartu_stok', NULL, 'fa-credit-card', '2021-08-08 12:43:09', '2021-09-27 03:11:33');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f6f4ee9a50', 8, 'Setting', NULL, NULL, 'fa-gears', '2021-08-08 12:44:46', '2021-09-27 03:01:08');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f6fe56b7e9', 2, 'Pembelian', NULL, NULL, 'fa-cart-plus', '2021-08-08 12:47:17', '2021-09-16 20:10:18');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f70b600934', 2, 'Retur Pembelian', 'retur_pembelian', '610f6fe56b7e9', NULL, '2021-08-08 12:50:46', '2021-09-15 07:55:32');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f70cdf09ef', 1, 'Penjualan', 'penjualan', '610f528cef01f', NULL, '2021-08-08 12:51:09', '2021-08-08 12:51:09');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f71f28558f', 2, 'Retur Penjualan', 'retur_penjualan', '610f528cef01f', NULL, '2021-08-08 12:56:02', '2021-08-08 12:56:02');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f7aa519251', 1, 'Hutang', 'hutang', '610f52dba8925', NULL, '2021-08-08 13:33:09', '2021-08-08 13:33:09');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f7ab91f0b6', 2, 'Piutang', 'piutang', '610f52dba8925', NULL, '2021-08-08 13:33:29', '2021-08-08 13:33:29');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f7ad64ac97', 1, 'Barang', 'master_barang', '610f6eb3598e5', NULL, '2021-08-08 13:33:58', '2021-08-08 13:33:58');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f7af97f690', 2, 'Supplier', 'master_supplier', '610f6eb3598e5', NULL, '2021-08-08 13:34:33', '2021-08-08 13:34:33');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f7b26b3fe3', 3, 'Pelanggan', 'master_pelanggan', '610f6eb3598e5', NULL, '2021-08-08 13:35:18', '2021-08-08 13:35:18');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f7b40c36fe', 4, 'Satuan', 'master_satuan', '610f6eb3598e5', NULL, '2021-08-08 13:35:44', '2021-08-08 13:35:44');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f7b5c09769', 5, 'Golongan', 'master_golongan', '610f6eb3598e5', NULL, '2021-08-08 13:36:12', '2021-08-08 13:36:12');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f7cdb927f7', 1, 'Pengguna', 'users', '610f6f4ee9a50', NULL, '2021-08-08 13:42:35', '2021-08-08 13:42:35');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f7cf4e3573', 2, 'Role', 'roles', '610f6f4ee9a50', NULL, '2021-08-08 13:43:00', '2021-08-08 13:43:00');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f7d0c747a1', 3, 'Backup Database', 'backup', '610f6f4ee9a50', NULL, '2021-08-08 13:43:24', '2021-08-08 13:43:24');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('610f7d421998e', 4, 'Menu', 'menus', '610f6f4ee9a50', 'fa-menu', '2021-08-08 13:44:18', '2021-09-16 07:44:45');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('6143db345f801', 1, 'Pembelian', 'pembelian', '610f6fe56b7e9', '', '2021-09-17 07:03:00', '2021-09-17 07:03:00');
INSERT INTO `menus` (`id`, `order_number`, `name`, `link`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES ('61501a5039342', 7, 'Opname', 'opname', NULL, 'fa-credit-card', '2021-09-26 13:59:28', '2021-09-27 03:01:19');


#
# TABLE STRUCTURE FOR: opnames
#

DROP TABLE IF EXISTS `opnames`;

CREATE TABLE `opnames` (
  `id` varchar(100) NOT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `stock_current` int(11) DEFAULT NULL,
  `stock_real_current` int(11) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `opnames_FK` (`product_id`),
  CONSTRAINT `opnames_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: payment_credits
#

DROP TABLE IF EXISTS `payment_credits`;

CREATE TABLE `payment_credits` (
  `id` varchar(100) NOT NULL,
  `selling_id` varchar(100) DEFAULT NULL,
  `installment` int(11) DEFAULT NULL,
  `rest` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `payment_credits` (`id`, `selling_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('606814750b609', '6067f030d7adc', 100000, 100000, '2021-04-03 14:08:37', '2021-04-03 14:08:37');
INSERT INTO `payment_credits` (`id`, `selling_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('606814a3f2390', '6067f030d7adc', 100000, 0, '2021-04-03 14:09:23', '2021-04-03 14:09:23');
INSERT INTO `payment_credits` (`id`, `selling_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('60683c83c2983', '6067f030d7adc', 200000, 0, '2021-04-03 16:59:31', '2021-04-03 16:59:31');


#
# TABLE STRUCTURE FOR: payment_debts
#

DROP TABLE IF EXISTS `payment_debts`;

CREATE TABLE `payment_debts` (
  `id` varchar(100) NOT NULL,
  `purchase_id` varchar(100) DEFAULT NULL,
  `installment` int(11) DEFAULT NULL,
  `rest` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `payment_debts` (`id`, `purchase_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('6067dec65286f', '606630366c7cc', 20000, 100000, '2021-04-03 10:19:34', '2021-04-03 10:19:34');
INSERT INTO `payment_debts` (`id`, `purchase_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('6067e1464478c', '606630366c7cc', 20000, 80000, '2021-04-03 10:30:14', '2021-04-03 10:30:14');
INSERT INTO `payment_debts` (`id`, `purchase_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('6067e6201b4fd', '606630366c7cc', 80000, 0, '2021-04-03 10:50:56', '2021-04-03 10:50:56');
INSERT INTO `payment_debts` (`id`, `purchase_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('6067ec6d825b4', '606631c6342ca', 240000, 0, '2021-04-03 11:17:49', '2021-04-03 11:17:49');
INSERT INTO `payment_debts` (`id`, `purchase_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('60683bc64504f', '6068377f17bb9', 20000, 70000, '2021-04-03 16:56:22', '2021-04-03 16:56:22');
INSERT INTO `payment_debts` (`id`, `purchase_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('60683bd194f2c', '6068377f17bb9', 70000, 0, '2021-04-03 16:56:33', '2021-04-03 16:56:33');
INSERT INTO `payment_debts` (`id`, `purchase_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('612fe7dcb21ae', '612fe1a92e1f4', 500000, 100000, '2021-09-02 03:51:40', '2021-09-02 03:51:40');
INSERT INTO `payment_debts` (`id`, `purchase_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('612fe8592c754', '612fe1a92e1f4', 50000, 50000, '2021-09-02 03:53:45', '2021-09-02 03:53:45');
INSERT INTO `payment_debts` (`id`, `purchase_id`, `installment`, `rest`, `created_at`, `updated_at`) VALUES ('612feabdf3c57', '612fe1a92e1f4', 50000, 0, '2021-09-02 04:03:57', '2021-09-02 04:03:57');


#
# TABLE STRUCTURE FOR: product_prices
#

DROP TABLE IF EXISTS `product_prices`;

CREATE TABLE `product_prices` (
  `id` varchar(100) NOT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `denomination_id` varchar(100) DEFAULT NULL,
  `selling_price` int(11) DEFAULT NULL,
  `buying_price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_denomination_FK` (`product_id`),
  KEY `product_denomination_FK_1` (`denomination_id`),
  CONSTRAINT `product_denomination_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_denomination_FK_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `product_prices` (`id`, `product_id`, `denomination_id`, `selling_price`, `buying_price`, `created_at`, `updated_at`) VALUES ('612d452caf1cb', NULL, '60f1f0f03633d', 0, 0, '2021-08-31 03:53:00', '2021-08-31 03:53:00');
INSERT INTO `product_prices` (`id`, `product_id`, `denomination_id`, `selling_price`, `buying_price`, `created_at`, `updated_at`) VALUES ('612d452cb2012', NULL, '60f1f10dc2e78', 0, 0, '2021-08-31 03:53:00', '2021-08-31 03:53:00');
INSERT INTO `product_prices` (`id`, `product_id`, `denomination_id`, `selling_price`, `buying_price`, `created_at`, `updated_at`) VALUES ('612d45493e28f', NULL, '60f1f10dc2e78', 0, 0, '2021-08-31 03:53:29', '2021-08-31 03:53:29');
INSERT INTO `product_prices` (`id`, `product_id`, `denomination_id`, `selling_price`, `buying_price`, `created_at`, `updated_at`) VALUES ('612d45608b571', NULL, '60f1f0f03633d', 0, 0, '2021-08-31 03:53:52', '2021-08-31 03:53:52');
INSERT INTO `product_prices` (`id`, `product_id`, `denomination_id`, `selling_price`, `buying_price`, `created_at`, `updated_at`) VALUES ('612d4578276d5', NULL, '60f1f0f03633d', 0, 0, '2021-08-31 03:54:16', '2021-08-31 03:54:16');
INSERT INTO `product_prices` (`id`, `product_id`, `denomination_id`, `selling_price`, `buying_price`, `created_at`, `updated_at`) VALUES ('615d1a0c5befe', '615d1a0c3c833', '60f1f10dc2e78', 7000, 5000, '2021-10-06 05:37:48', '2021-10-06 05:37:48');
INSERT INTO `product_prices` (`id`, `product_id`, `denomination_id`, `selling_price`, `buying_price`, `created_at`, `updated_at`) VALUES ('615d1a805032f', '615d1a8049664', '60f1f10dc2e78', 5000, 3000, '2021-10-06 05:39:44', '2021-10-06 05:39:44');
INSERT INTO `product_prices` (`id`, `product_id`, `denomination_id`, `selling_price`, `buying_price`, `created_at`, `updated_at`) VALUES ('615d1af7d4dc6', '615d1af7d0b71', '60f1f10dc2e78', 4000, 2000, '2021-10-06 05:41:43', '2021-10-06 05:41:43');
INSERT INTO `product_prices` (`id`, `product_id`, `denomination_id`, `selling_price`, `buying_price`, `created_at`, `updated_at`) VALUES ('615e5cbeeb292', '615e5cbec4b42', '615e5c251662d', 15000, 10000, '2021-10-07 04:34:38', '2021-10-07 04:34:38');
INSERT INTO `product_prices` (`id`, `product_id`, `denomination_id`, `selling_price`, `buying_price`, `created_at`, `updated_at`) VALUES ('615e5ce9d4495', '615e5ce9c212e', '615e5c251662d', 20000, 15000, '2021-10-07 04:35:21', '2021-10-07 04:35:21');


#
# TABLE STRUCTURE FOR: purchases
#

DROP TABLE IF EXISTS `purchases`;

CREATE TABLE `purchases` (
  `id` varchar(100) NOT NULL,
  `purchase_code` varchar(100) DEFAULT NULL,
  `supplier_id` varchar(100) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `payment` varchar(100) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `total` int(11) DEFAULT 0,
  `fully_pay` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchases_un` (`purchase_code`),
  KEY `purchase_FK` (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `purchases` (`id`, `purchase_code`, `supplier_id`, `invoice_number`, `payment`, `due_date`, `created_at`, `updated_at`, `total`, `fully_pay`) VALUES ('615d1bbb4ed6b', '21100001', '60ec5e7e715af', '06102021', 'kredit', '2021-11-06', '2021-10-06 10:44:59', '2021-10-06 10:44:59', 90000, 0);



#
# TABLE STRUCTURE FOR: purchase_details
#

DROP TABLE IF EXISTS `purchase_details`;

CREATE TABLE `purchase_details` (
  `id` varchar(100) NOT NULL,
  `purchase_id` varchar(100) NOT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `batch_number` varchar(100) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `quantity` varchar(100) DEFAULT NULL,
  `current_stock` int(10) unsigned DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `purchase_return` tinyint(1) NOT NULL DEFAULT 0,
  KEY `purchase_details_FK` (`purchase_id`),
  KEY `fk_purchase_detail_products` (`product_id`),
  CONSTRAINT `fk_purchase_detail_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `purchase_details_FK` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `purchase_details` (`id`, `purchase_id`, `product_id`, `batch_number`, `expired_date`, `quantity`, `current_stock`, `price`, `created_at`, `updated_at`, `purchase_return`) VALUES ('615d1bbb64592', '615d1bbb4ed6b', '615d1a0c3c833', '252511', '2022-04-13', '10', 10, '5000', '2021-10-06 10:44:59', '2021-10-06 10:44:59', 0);
INSERT INTO `purchase_details` (`id`, `purchase_id`, `product_id`, `batch_number`, `expired_date`, `quantity`, `current_stock`, `price`, `created_at`, `updated_at`, `purchase_return`) VALUES ('615d1bbb72f32', '615d1bbb4ed6b', '615d1af7d0b71', '2556564', '2022-04-15', '20', 20, '2000', '2021-10-06 10:44:59', '2021-10-06 10:44:59', 0);


#
# TABLE STRUCTURE FOR: purchase_returns
#

DROP TABLE IF EXISTS `purchase_returns`;

CREATE TABLE `purchase_returns` (
  `id` varchar(100) NOT NULL,
  `purchase_return_code` varchar(100) DEFAULT NULL,
  `purchase_detail_id` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('60f26a5926126', '21070001', '60f269d437e7f', 3, '2021-07-17 12:27:53', '2021-07-17 12:27:53');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('60f26a6b060d8', '21070002', '60f269d437e7f', 1, '2021-07-17 12:28:11', '2021-07-17 12:28:11');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('6106689be2469', '21080001', '61066318752d7', 3, '2021-08-01 16:25:47', '2021-08-01 16:25:47');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('610669a22e1a9', '21080002', '61066318752d7', 1, '2021-08-01 16:30:10', '2021-08-01 16:30:10');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('610669bcd5e39', '21080003', '60f269d437e7f', 1, '2021-08-01 16:30:36', '2021-08-01 16:30:36');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('610669cbc3a7f', '21080004', '60f269d43e135', 1, '2021-08-01 16:30:51', '2021-08-01 16:30:51');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('61066b116c9d1', '21080005', '60fb01e8a765b', 1, '2021-08-01 16:36:17', '2021-08-01 16:36:17');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('61066d2a5ff4a', '21080006', '6101cb6392302', 18, '2021-08-01 16:45:14', '2021-08-01 16:45:14');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('61066de9109c0', '21080007', '6101cb6392302', 18, '2021-08-01 16:48:25', '2021-08-01 16:48:25');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('6106702cbb787', '21080008', '6101c65bc6c51', 3, '2021-08-01 16:58:04', '2021-08-01 16:58:04');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('610955dac8e52', '21080009', '610955b8ee2f9', 2, '2021-08-03 21:42:34', '2021-08-03 21:42:34');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('610955f3c5dd8', '21080010', '610955b8ed8d0', 5, '2021-08-03 21:42:59', '2021-08-03 21:42:59');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('61095927ac034', '21080011', '610957eb220f7', 2, '2021-08-03 21:56:39', '2021-08-03 21:56:39');
INSERT INTO `purchase_returns` (`id`, `purchase_return_code`, `purchase_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('612e96c942d07', '21090001', '612e954994108', 5, '2021-09-01 03:53:29', '2021-09-01 03:53:29');

#
# TABLE STRUCTURE FOR: sellings
#

DROP TABLE IF EXISTS `sellings`;

CREATE TABLE `sellings` (
  `id` varchar(100) NOT NULL,
  `selling_code` varchar(100) DEFAULT NULL,
  `customer_id` varchar(100) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `payment` varchar(100) DEFAULT NULL,
  `total` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `fully_pay` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `selling_FK` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `sellings` (`id`, `selling_code`, `customer_id`, `invoice_number`, `payment`, `total`, `created_at`, `updated_at`, `fully_pay`) VALUES ('615d1c6ec971a', '21100001', '60604ce8db05f', NULL, 'tunai', 55000, '2021-10-06 10:47:58', '2021-10-06 10:47:58', 1);
INSERT INTO `sellings` (`id`, `selling_code`, `customer_id`, `invoice_number`, `payment`, `total`, `created_at`, `updated_at`, `fully_pay`) VALUES ('615e5ec1874f3', '21100002', '60604ce8db05f', NULL, 'tunai', 125000, '2021-10-07 09:43:13', '2021-10-07 09:43:13', 1);


#
# TABLE STRUCTURE FOR: selling_details
#

DROP TABLE IF EXISTS `selling_details`;

CREATE TABLE `selling_details` (
  `id` varchar(100) NOT NULL,
  `selling_id` varchar(100) NOT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `product_barcode` varchar(100) NOT NULL,
  `batch_number` varchar(100) DEFAULT NULL,
  `quantity` varchar(100) DEFAULT NULL,
  `return_quantity` int(11) DEFAULT 0,
  `price` varchar(100) DEFAULT NULL,
  `selling_return` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `selling_details_FK_1` (`product_id`),
  KEY `selling_details_FK` (`selling_id`),
  CONSTRAINT `selling_details_FK` FOREIGN KEY (`selling_id`) REFERENCES `sellings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `selling_details_FK_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `selling_details` (`id`, `selling_id`, `product_id`, `product_barcode`, `batch_number`, `quantity`, `return_quantity`, `price`, `selling_return`, `created_at`, `updated_at`) VALUES ('615d1c6ed5e9b', '615d1c6ec971a', '615d1a0c3c833', '', '252511', '5', 0, '7000', 0, '2021-10-06 10:47:58', '2021-10-06 10:47:58');
INSERT INTO `selling_details` (`id`, `selling_id`, `product_id`, `product_barcode`, `batch_number`, `quantity`, `return_quantity`, `price`, `selling_return`, `created_at`, `updated_at`) VALUES ('615d1c6eda418', '615d1c6ec971a', '615d1af7d0b71', '', '2556564', '5', 0, '4000', 0, '2021-10-06 10:47:58', '2021-10-06 10:47:58');
INSERT INTO `selling_details` (`id`, `selling_id`, `product_id`, `product_barcode`, `batch_number`, `quantity`, `return_quantity`, `price`, `selling_return`, `created_at`, `updated_at`) VALUES ('615e5ec19236f', '615e5ec1874f3', '615e5cbec4b42', '', '0', '6', 0, '15000', 0, '2021-10-07 09:43:13', '2021-10-07 09:43:13');
INSERT INTO `selling_details` (`id`, `selling_id`, `product_id`, `product_barcode`, `batch_number`, `quantity`, `return_quantity`, `price`, `selling_return`, `created_at`, `updated_at`) VALUES ('615e5ec1be5f9', '615e5ec1874f3', '615e5cbec4b42', '', '0', '1', 0, '15000', 0, '2021-10-07 09:43:13', '2021-10-07 09:43:13');
INSERT INTO `selling_details` (`id`, `selling_id`, `product_id`, `product_barcode`, `batch_number`, `quantity`, `return_quantity`, `price`, `selling_return`, `created_at`, `updated_at`) VALUES ('615e5ec1e2fd8', '615e5ec1874f3', '615e5ce9c212e', '', '0', '1', 0, '20000', 0, '2021-10-07 09:43:13', '2021-10-07 09:43:13');


#
# TABLE STRUCTURE FOR: selling_returns
#

DROP TABLE IF EXISTS `selling_returns`;

CREATE TABLE `selling_returns` (
  `id` varchar(100) NOT NULL,
  `selling_return_code` varchar(100) DEFAULT NULL,
  `selling_detail_id` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `selling_returns` (`id`, `selling_return_code`, `selling_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('610c515ba2b6c', '21080001', '610c4f295f9d7', 2, '2021-08-06 04:00:11', '2021-08-06 04:00:11');
INSERT INTO `selling_returns` (`id`, `selling_return_code`, `selling_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES ('612e98677ab57', '21090001', '612e97f331bae', 1, '2021-09-01 04:00:23', '2021-09-01 04:00:23');



#
# TABLE STRUCTURE FOR: suppliers
#

DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `id` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL COMMENT 'Phone Number',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `suppliers` (`id`, `name`, `address`, `contact`, `created_at`, `updated_at`) VALUES ('603fa74899ff0', 'pt angin ribut', 'ciparay              ', '0222323232', '2021-03-03 22:12:08', '2021-03-03 22:12:08');
INSERT INTO `suppliers` (`id`, `name`, `address`, `contact`, `created_at`, `updated_at`) VALUES ('603fa7ad60a7c', 'pt dordar gelap', 'rancaekek              ', '023232', '2021-03-03 22:13:49', '2021-03-03 22:13:49');
INSERT INTO `suppliers` (`id`, `name`, `address`, `contact`, `created_at`, `updated_at`) VALUES ('60eaa877c71d7', 'test suplier', 'fdf', '0222323232', '2021-07-11 15:14:47', '2021-07-11 15:14:47');
INSERT INTO `suppliers` (`id`, `name`, `address`, `contact`, `created_at`, `updated_at`) VALUES ('60ec5e7e715af', 'pt global', 'dfdfd', '909090', '2021-07-12 22:23:42', '2021-07-12 22:23:42');
INSERT INTO `suppliers` (`id`, `name`, `address`, `contact`, `created_at`, `updated_at`) VALUES ('60ec60772987a', 'pt hujan badai', 'ciparay', '89899', '2021-07-12 22:32:07', '2021-07-12 22:32:07');
INSERT INTO `suppliers` (`id`, `name`, `address`, `contact`, `created_at`, `updated_at`) VALUES ('60ec60cf79b74', 'pt angin ribut', 'pt angin ribut', '898989', '2021-07-12 22:33:35', '2021-07-12 22:33:35');


#
# TABLE STRUCTURE FOR: types
#

DROP TABLE IF EXISTS `types`;

CREATE TABLE `types` (
  `id` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES ('60fcff88bda14', 'OTC', '2021-07-25 13:07:04', '2021-07-25 13:07:04');
INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES ('60fcffa79360e', 'Kosmetik', '2021-07-25 13:07:35', '2021-07-25 13:07:35');
INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES ('60fcffbbdf083', 'Alkes 2', '2021-07-25 13:07:55', '2021-09-14 03:02:33');
INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES ('612fe022c924c', 'Obat Keras', '2021-09-02 03:18:42', '2021-09-02 03:18:42');


#
# TABLE STRUCTURE FOR: users
#

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` varchar(200) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` text NOT NULL,
  `level` enum('admin','user') NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `username`, `password`, `level`, `nama`, `role`, `profile_picture`, `created_at`, `updated_at`) VALUES ('60ea8a8e18c0b', 'fulanah', 'f48d2cbdc9050a55e606dc27be372d636e23e64fb8ac190bb9f83fba6f1411247ddcd1e3a3fdbc0b86ee74daf123ba5304a4e1f6347e1fea0461d98c41e1d9dfA6Vwzq6dhsV6zoUAi4bomHlcFCGLx6QpVJ6Q0OmSRx0=', 'admin', 'Fulanah', '60ea7aae3d98f', '', '2021-07-11 13:07:10', '2021-07-11 13:07:10');
INSERT INTO `users` (`id`, `username`, `password`, `level`, `nama`, `role`, `profile_picture`, `created_at`, `updated_at`) VALUES ('615015da9375c', 'kasir', '921250ed54f72503cafdb98711f4a799735ef2c19e14906b4633ffd39c93d3de885cc29033603302566bb677e709da2621a9054dc02fd9e1c1e8e733ff721082UkF5KYdc1yhsj5bkjLJo3yuwLzmi3PanlY6QBgIFprA=', 'admin', 'kasir', '60ea7aae3d98f', '', '2021-09-26 13:40:26', '2021-09-26 13:40:26');
INSERT INTO `users` (`id`, `username`, `password`, `level`, `nama`, `role`, `profile_picture`, `created_at`, `updated_at`) VALUES ('c0912b81-fdd8-11e8-88db-d46e0e1bc63c', 'admin', '47e631b2878b9a0668deb093a564ef35dff27c69d5812f42dbde2d3276bb4d81d55390d1dfc88b12fea42f537d4d5752fa5580b96cae5cf048e228267ea7a2f2+D06aPYOANUSxAbXE5D70NrUYH8y4ZRIAt3WEK6ZHDU=', 'admin', 'Bu IIn', '5f63cbae56378', '', '2021-07-11 13:07:05', '2021-07-13 22:13:23');


