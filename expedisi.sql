/*
Navicat MySQL Data Transfer

Source Server         : Dika
Source Server Version : 100414
Source Host           : localhost:3306
Source Database       : expedisi

Target Server Type    : MYSQL
Target Server Version : 100414
File Encoding         : 65001

Date: 2021-05-15 12:40:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for m_biaya
-- ----------------------------
DROP TABLE IF EXISTS `m_biaya`;
CREATE TABLE `m_biaya` (
  `kd_biaya` bigint(20) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_biaya`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_biaya
-- ----------------------------

-- ----------------------------
-- Table structure for m_customer
-- ----------------------------
DROP TABLE IF EXISTS `m_customer`;
CREATE TABLE `m_customer` (
  `kd_customer` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_customer_reff` varchar(255) DEFAULT NULL,
  `kd_kategori` bigint(20) DEFAULT NULL,
  `kd_kabupaten` bigint(20) DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `hp` varchar(255) DEFAULT NULL,
  `limit_kredit` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_customer`),
  KEY `kd_kategori` (`kd_kategori`),
  KEY `kd_kabupaten` (`kd_kabupaten`),
  CONSTRAINT `m_customer_ibfk_1` FOREIGN KEY (`kd_kategori`) REFERENCES `m_customer_kategori` (`kd_kategori`),
  CONSTRAINT `m_customer_ibfk_2` FOREIGN KEY (`kd_kabupaten`) REFERENCES `m_kabupaten` (`kd_kabupaten`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_customer
-- ----------------------------

-- ----------------------------
-- Table structure for m_customer_kategori
-- ----------------------------
DROP TABLE IF EXISTS `m_customer_kategori`;
CREATE TABLE `m_customer_kategori` (
  `kd_kategori` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_kategori_reff` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_customer_kategori
-- ----------------------------

-- ----------------------------
-- Table structure for m_divisi
-- ----------------------------
DROP TABLE IF EXISTS `m_divisi`;
CREATE TABLE `m_divisi` (
  `kd_divisi` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_divisi_reff` varchar(255) DEFAULT NULL,
  `kd_kabupaten` bigint(20) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_divisi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_divisi
-- ----------------------------

-- ----------------------------
-- Table structure for m_jenis_bayar
-- ----------------------------
DROP TABLE IF EXISTS `m_jenis_bayar`;
CREATE TABLE `m_jenis_bayar` (
  `kd_jenis_bayar` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_jenis_bayar_reff` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_jenis_bayar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_jenis_bayar
-- ----------------------------

-- ----------------------------
-- Table structure for m_jenis_kirim
-- ----------------------------
DROP TABLE IF EXISTS `m_jenis_kirim`;
CREATE TABLE `m_jenis_kirim` (
  `kd_jenis` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_jenis_reff` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_jenis_kirim
-- ----------------------------

-- ----------------------------
-- Table structure for m_kabupaten
-- ----------------------------
DROP TABLE IF EXISTS `m_kabupaten`;
CREATE TABLE `m_kabupaten` (
  `kd_kabupaten` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_provinsi` bigint(20) DEFAULT NULL,
  `kd_kabupaten_reff` varchar(255) DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_kabupaten`),
  KEY `kd_provinsi` (`kd_provinsi`),
  CONSTRAINT `m_kabupaten_ibfk_1` FOREIGN KEY (`kd_provinsi`) REFERENCES `m_provinsi` (`kd_provinsi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_kabupaten
-- ----------------------------

-- ----------------------------
-- Table structure for m_kas
-- ----------------------------
DROP TABLE IF EXISTS `m_kas`;
CREATE TABLE `m_kas` (
  `kd_kas` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_kas_reff` varchar(255) DEFAULT NULL,
  `no_rekening` varchar(255) DEFAULT NULL,
  `saldo_awal` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_kas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_kas
-- ----------------------------

-- ----------------------------
-- Table structure for m_kirim
-- ----------------------------
DROP TABLE IF EXISTS `m_kirim`;
CREATE TABLE `m_kirim` (
  `kd_kirim` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_kirim_reff` varchar(255) DEFAULT NULL,
  `kd_kota_asal` bigint(20) DEFAULT NULL,
  `kd_kota_tujuan` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_kirim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_kirim
-- ----------------------------

-- ----------------------------
-- Table structure for m_kirim_detail
-- ----------------------------
DROP TABLE IF EXISTS `m_kirim_detail`;
CREATE TABLE `m_kirim_detail` (
  `kd_kirim_detail` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_kirim_detail_reff` varchar(255) DEFAULT NULL,
  `kd_kirim` bigint(20) DEFAULT NULL,
  `kd_jenis` bigint(20) DEFAULT NULL,
  `kd_layanan` bigint(20) DEFAULT NULL,
  `harga_berat` double DEFAULT NULL,
  `min_berat` double DEFAULT NULL,
  `harga_volume` double DEFAULT NULL,
  `min_volume` double DEFAULT NULL,
  `prediksi_hari` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_kirim_detail`),
  KEY `kd_kirim` (`kd_kirim`),
  KEY `kd_jenis` (`kd_jenis`),
  CONSTRAINT `m_kirim_detail_ibfk_1` FOREIGN KEY (`kd_kirim`) REFERENCES `m_kirim` (`kd_kirim`),
  CONSTRAINT `m_kirim_detail_ibfk_2` FOREIGN KEY (`kd_jenis`) REFERENCES `m_jenis_kirim` (`kd_jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_kirim_detail
-- ----------------------------

-- ----------------------------
-- Table structure for m_layanan
-- ----------------------------
DROP TABLE IF EXISTS `m_layanan`;
CREATE TABLE `m_layanan` (
  `kd_layanan` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_layanan_reff` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_layanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_layanan
-- ----------------------------

-- ----------------------------
-- Table structure for m_lokasi
-- ----------------------------
DROP TABLE IF EXISTS `m_lokasi`;
CREATE TABLE `m_lokasi` (
  `kd_lokasi` bigint(20) DEFAULT NULL,
  `kd_kabupaten` bigint(20) DEFAULT NULL,
  `kd_lokasi_reff` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `kd_area` bigint(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  KEY `kd_kabupaten` (`kd_kabupaten`),
  CONSTRAINT `m_lokasi_ibfk_1` FOREIGN KEY (`kd_kabupaten`) REFERENCES `m_kabupaten` (`kd_kabupaten`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_lokasi
-- ----------------------------

-- ----------------------------
-- Table structure for m_pegawai
-- ----------------------------
DROP TABLE IF EXISTS `m_pegawai`;
CREATE TABLE `m_pegawai` (
  `kd_pegawai` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_kategori` bigint(20) DEFAULT NULL,
  `kd_pegawai_reff` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `hp` varchar(255) DEFAULT NULL,
  `status` tinytext DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_pegawai`),
  KEY `kd_kategori` (`kd_kategori`),
  CONSTRAINT `m_pegawai_ibfk_1` FOREIGN KEY (`kd_kategori`) REFERENCES `m_pegawai_kategori` (`kd_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_pegawai
-- ----------------------------

-- ----------------------------
-- Table structure for m_pegawai_kategori
-- ----------------------------
DROP TABLE IF EXISTS `m_pegawai_kategori`;
CREATE TABLE `m_pegawai_kategori` (
  `kd_kategori` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `diskripsi` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_pegawai_kategori
-- ----------------------------

-- ----------------------------
-- Table structure for m_pendapatan
-- ----------------------------
DROP TABLE IF EXISTS `m_pendapatan`;
CREATE TABLE `m_pendapatan` (
  `kd_pendapatan` bigint(20) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_pendapatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_pendapatan
-- ----------------------------

-- ----------------------------
-- Table structure for m_provinsi
-- ----------------------------
DROP TABLE IF EXISTS `m_provinsi`;
CREATE TABLE `m_provinsi` (
  `kd_provinsi` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_provinsi_reff` varchar(255) DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL DEFAULT '',
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_provinsi
-- ----------------------------
INSERT INTO `m_provinsi` VALUES ('1', null, '1001', 'Nusa Tenggara Barat (NTB)', '-', '2021-05-01 15:23:30', '2021-05-01 15:23:30');
INSERT INTO `m_provinsi` VALUES ('3', null, null, 'Nusa Tenggara Timur (NTT)', '-', '2021-05-01 15:30:27', '2021-05-01 15:30:27');

-- ----------------------------
-- Table structure for m_satuan
-- ----------------------------
DROP TABLE IF EXISTS `m_satuan`;
CREATE TABLE `m_satuan` (
  `kd_satuan` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_satuan_reff` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `STATUS` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_satuan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_satuan
-- ----------------------------

-- ----------------------------
-- Table structure for m_userx
-- ----------------------------
DROP TABLE IF EXISTS `m_userx`;
CREATE TABLE `m_userx` (
  `kd_user` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_group` bigint(20) DEFAULT NULL,
  `kd_user_reff` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_user`),
  KEY `kd_group` (`kd_group`),
  CONSTRAINT `m_userx_ibfk_1` FOREIGN KEY (`kd_group`) REFERENCES `m_user_group` (`kd_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_userx
-- ----------------------------

-- ----------------------------
-- Table structure for m_user_group
-- ----------------------------
DROP TABLE IF EXISTS `m_user_group`;
CREATE TABLE `m_user_group` (
  `kd_group` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_group_reff` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kd_group`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_user_group
-- ----------------------------
INSERT INTO `m_user_group` VALUES ('1', null, '1', '5', '1', 'WhatsApp Image 2021-05-09 at 08.56.49.jpeg', '2021-05-09 10:17:01', '2021-05-10 09:20:39');
INSERT INTO `m_user_group` VALUES ('19', null, 'afg', 'f', '1', 'WhatsApp Image 2021-05-09 at 08.56.49.jpeg', '2021-05-09 15:40:20', '2021-05-10 09:13:20');
INSERT INTO `m_user_group` VALUES ('27', null, '123', '2', '1', 'WhatsApp Image 2021-05-09 at 08.56.49.jpeg', '2021-05-09 18:20:33', '2021-05-09 18:28:03');
INSERT INTO `m_user_group` VALUES ('28', null, '11', '11', '1', 'WhatsApp Image 2021-05-09 at 08.56.49.jpeg', '2021-05-09 18:31:20', '2021-05-09 18:31:20');
INSERT INTO `m_user_group` VALUES ('29', null, 'dsfa', 'asdf', '1', 'WhatsApp Image 2021-05-09 at 08.56.49.jpeg', '2021-05-10 08:58:54', '2021-05-10 08:58:54');
INSERT INTO `m_user_group` VALUES ('30', null, 'asdf', 'sdf', '1', 'WhatsApp Image 2021-05-09 at 08.56.49.jpeg', '2021-05-10 09:19:42', '2021-05-10 09:19:42');
INSERT INTO `m_user_group` VALUES ('31', null, 'werwe', 'ewr', '1', 'WhatsApp Image 2021-05-09 at 08.56.49.jpeg', '2021-05-15 10:32:11', '2021-05-15 10:32:11');

-- ----------------------------
-- Table structure for t_biaya_operasional
-- ----------------------------
DROP TABLE IF EXISTS `t_biaya_operasional`;
CREATE TABLE `t_biaya_operasional` (
  `no_transaksi` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_transaksi_reff` varchar(255) DEFAULT NULL,
  `kd_biaya` bigint(20) DEFAULT NULL,
  `kd_jenis` bigint(20) DEFAULT NULL,
  `kd_kas` bigint(20) DEFAULT NULL,
  `kd_divisi` bigint(20) DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `kd_user` bigint(20) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`no_transaksi`),
  KEY `kd_jenis` (`kd_jenis`),
  KEY `kd_kas` (`kd_kas`),
  KEY `kd_biaya` (`kd_biaya`),
  CONSTRAINT `t_biaya_operasional_ibfk_1` FOREIGN KEY (`kd_jenis`) REFERENCES `m_jenis_kirim` (`kd_jenis`),
  CONSTRAINT `t_biaya_operasional_ibfk_2` FOREIGN KEY (`kd_kas`) REFERENCES `m_kas` (`kd_kas`),
  CONSTRAINT `t_biaya_operasional_ibfk_3` FOREIGN KEY (`kd_biaya`) REFERENCES `m_biaya` (`kd_biaya`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_biaya_operasional
-- ----------------------------

-- ----------------------------
-- Table structure for t_invoice
-- ----------------------------
DROP TABLE IF EXISTS `t_invoice`;
CREATE TABLE `t_invoice` (
  `no_transaksi` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_transaksi_reff` varchar(255) DEFAULT NULL,
  `kd_customer` bigint(20) DEFAULT NULL,
  `kd_divisi` bigint(20) DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `keterangan` varchar(255) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `kd_user` bigint(20) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`no_transaksi`),
  KEY `kd_customer` (`kd_customer`),
  CONSTRAINT `t_invoice_ibfk_1` FOREIGN KEY (`kd_customer`) REFERENCES `m_customer` (`kd_customer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_invoice
-- ----------------------------

-- ----------------------------
-- Table structure for t_invoice_detail
-- ----------------------------
DROP TABLE IF EXISTS `t_invoice_detail`;
CREATE TABLE `t_invoice_detail` (
  `nomor` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_invoice` bigint(20) DEFAULT NULL,
  `no_pengiriman` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`nomor`),
  KEY `no_invoice` (`no_invoice`),
  KEY `no_pengiriman` (`no_pengiriman`),
  CONSTRAINT `t_invoice_detail_ibfk_1` FOREIGN KEY (`no_invoice`) REFERENCES `t_invoice` (`no_transaksi`),
  CONSTRAINT `t_invoice_detail_ibfk_2` FOREIGN KEY (`no_pengiriman`) REFERENCES `t_pengiriman` (`no_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_invoice_detail
-- ----------------------------

-- ----------------------------
-- Table structure for t_manifest
-- ----------------------------
DROP TABLE IF EXISTS `t_manifest`;
CREATE TABLE `t_manifest` (
  `no_transaksi` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_transaksi_reff` varchar(255) DEFAULT NULL,
  `kd_asal` bigint(20) DEFAULT NULL COMMENT 'divisi asal',
  `kd_tujuan` bigint(20) DEFAULT NULL COMMENT 'divisi tujuan',
  `tanggal_berangkat` datetime DEFAULT NULL,
  `tanggal_sampai` datetime DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `kendaraan` varchar(255) DEFAULT NULL,
  `kontak` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kd_user` bigint(20) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`no_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_manifest
-- ----------------------------

-- ----------------------------
-- Table structure for t_manifest_detail
-- ----------------------------
DROP TABLE IF EXISTS `t_manifest_detail`;
CREATE TABLE `t_manifest_detail` (
  `nomor` bigint(20) NOT NULL AUTO_INCREMENT,
  `nomor_reff` varchar(255) DEFAULT NULL,
  `no_manifest` bigint(20) DEFAULT NULL,
  `no_pengiriman` bigint(20) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `tanggal_terima` datetime DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`nomor`),
  KEY `no_manifest` (`no_manifest`),
  KEY `no_pengiriman` (`no_pengiriman`),
  CONSTRAINT `t_manifest_detail_ibfk_1` FOREIGN KEY (`no_manifest`) REFERENCES `t_manifest` (`no_transaksi`),
  CONSTRAINT `t_manifest_detail_ibfk_2` FOREIGN KEY (`no_pengiriman`) REFERENCES `t_pengiriman` (`no_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_manifest_detail
-- ----------------------------

-- ----------------------------
-- Table structure for t_mutasi_kas
-- ----------------------------
DROP TABLE IF EXISTS `t_mutasi_kas`;
CREATE TABLE `t_mutasi_kas` (
  `no_transaksi` bigint(20) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL,
  `kd_kas_sumber` char(6) NOT NULL,
  `kd_kas_tujuan` varchar(10) NOT NULL,
  `nominal` decimal(19,4) NOT NULL,
  `no_bukti_sumber` varchar(20) NOT NULL,
  `no_bukti_tujuan` varchar(20) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `kd_user` bigint(20) NOT NULL,
  `tanggal_server` datetime DEFAULT current_timestamp(),
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`no_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_mutasi_kas
-- ----------------------------

-- ----------------------------
-- Table structure for t_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `t_pembayaran`;
CREATE TABLE `t_pembayaran` (
  `nomor` bigint(20) NOT NULL AUTO_INCREMENT,
  `nomor_reff` varchar(255) DEFAULT NULL,
  `no_pengiriman` bigint(20) DEFAULT NULL,
  `kd_jenis_bayar` bigint(20) DEFAULT NULL,
  `kd_kas` bigint(20) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kd_user` bigint(20) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`nomor`),
  KEY `no_pengiriman` (`no_pengiriman`),
  KEY `kd_jenis_bayar` (`kd_jenis_bayar`),
  KEY `kd_kas` (`kd_kas`),
  CONSTRAINT `t_pembayaran_ibfk_1` FOREIGN KEY (`no_pengiriman`) REFERENCES `t_pengiriman` (`no_transaksi`),
  CONSTRAINT `t_pembayaran_ibfk_2` FOREIGN KEY (`kd_jenis_bayar`) REFERENCES `m_jenis_bayar` (`kd_jenis_bayar`),
  CONSTRAINT `t_pembayaran_ibfk_3` FOREIGN KEY (`kd_kas`) REFERENCES `m_kas` (`kd_kas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_pembayaran
-- ----------------------------

-- ----------------------------
-- Table structure for t_penagihan
-- ----------------------------
DROP TABLE IF EXISTS `t_penagihan`;
CREATE TABLE `t_penagihan` (
  `no_transaksi` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_pegawai` bigint(20) DEFAULT NULL,
  `kd_customer` bigint(20) DEFAULT NULL,
  `kd_divisi` bigint(20) DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `keterangan` varchar(255) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `kd_user` bigint(20) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`no_transaksi`),
  KEY `kd_pegawai` (`kd_pegawai`),
  CONSTRAINT `t_penagihan_ibfk_1` FOREIGN KEY (`kd_pegawai`) REFERENCES `m_pegawai` (`kd_pegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_penagihan
-- ----------------------------
INSERT INTO `t_penagihan` VALUES ('24', '12', '2342', '0', '342', '0000-00-00 00:00:00', '34', 'WhatsApp Image 2021-05-09 at 08.56.49.jpeg', null, null, '2021-05-11 11:06:35', '2021-05-11 11:06:35');
INSERT INTO `t_penagihan` VALUES ('25', '12', '2342', '0', '342', '0000-00-00 00:00:00', '34', 'WhatsApp Image 2021-05-09 at 08.56.49.jpeg', null, null, '2021-05-11 11:07:46', '2021-05-11 11:07:46');
INSERT INTO `t_penagihan` VALUES ('26', '12', '2342', '0', '342', '0000-00-00 00:00:00', '34', 'WhatsApp Image 2021-05-09 at 08.56.49.jpeg', null, null, '2021-05-11 11:10:43', '2021-05-11 11:10:43');
INSERT INTO `t_penagihan` VALUES ('27', '12', '2342', null, '342', '0000-00-00 00:00:00', '34', 'WhatsApp Image 2021-05-09 at 08.56.49.jpeg', null, null, '2021-05-11 11:17:15', '2021-05-11 11:17:15');

-- ----------------------------
-- Table structure for t_penagihan_detail
-- ----------------------------
DROP TABLE IF EXISTS `t_penagihan_detail`;
CREATE TABLE `t_penagihan_detail` (
  `nomor` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_tagihan` bigint(20) DEFAULT NULL,
  `no_pengiriman` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`nomor`),
  KEY `no_tagihan` (`no_tagihan`),
  KEY `no_pengiriman` (`no_pengiriman`),
  CONSTRAINT `t_penagihan_detail_ibfk_1` FOREIGN KEY (`no_tagihan`) REFERENCES `t_penagihan` (`no_transaksi`),
  CONSTRAINT `t_penagihan_detail_ibfk_2` FOREIGN KEY (`no_pengiriman`) REFERENCES `t_pengiriman` (`no_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_penagihan_detail
-- ----------------------------
INSERT INTO `t_penagihan_detail` VALUES ('23', '24', '0', 'SDFS', '0', null, '2021-05-11 11:06:35', '2021-05-11 11:06:35');
INSERT INTO `t_penagihan_detail` VALUES ('24', '25', '0', 'SDFS', '0', null, '2021-05-11 11:07:46', '2021-05-11 11:07:46');
INSERT INTO `t_penagihan_detail` VALUES ('25', '26', '0', 'SDFS', '0', null, '2021-05-11 11:10:43', '2021-05-11 11:10:43');
INSERT INTO `t_penagihan_detail` VALUES ('26', '27', '0', 'SDFS', '0', null, '2021-05-11 11:17:15', '2021-05-11 11:17:15');

-- ----------------------------
-- Table structure for t_pendapatan
-- ----------------------------
DROP TABLE IF EXISTS `t_pendapatan`;
CREATE TABLE `t_pendapatan` (
  `no_transaksi` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_transaksi_reff` varchar(255) DEFAULT NULL,
  `kd_pendapatan` bigint(20) DEFAULT NULL,
  `kd_jenis` bigint(20) DEFAULT NULL,
  `kd_kas` bigint(20) DEFAULT NULL,
  `kd_divisi` bigint(20) DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `kd_user` bigint(20) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`no_transaksi`),
  KEY `kd_jenis` (`kd_jenis`),
  KEY `kd_kas` (`kd_kas`),
  KEY `kd_pendapatan` (`kd_pendapatan`),
  CONSTRAINT `t_pendapatan_ibfk_1` FOREIGN KEY (`kd_jenis`) REFERENCES `m_jenis_kirim` (`kd_jenis`),
  CONSTRAINT `t_pendapatan_ibfk_2` FOREIGN KEY (`kd_kas`) REFERENCES `m_kas` (`kd_kas`),
  CONSTRAINT `t_pendapatan_ibfk_4` FOREIGN KEY (`kd_pendapatan`) REFERENCES `m_pendapatan` (`kd_pendapatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_pendapatan
-- ----------------------------

-- ----------------------------
-- Table structure for t_pengiriman
-- ----------------------------
DROP TABLE IF EXISTS `t_pengiriman`;
CREATE TABLE `t_pengiriman` (
  `no_transaksi` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_transaksi_reff` varchar(255) DEFAULT NULL,
  `kd_customer` bigint(20) DEFAULT NULL,
  `kd_jenis_bayar` bigint(20) DEFAULT NULL,
  `kd_kas` bigint(20) DEFAULT NULL,
  `kd_divisi` bigint(20) DEFAULT NULL,
  `kd_lokasi_asal` bigint(20) DEFAULT NULL,
  `kd_lokasi_tujuan` bigint(20) DEFAULT NULL,
  `kd_layanan` bigint(20) DEFAULT NULL,
  `nama_pengirim` varchar(255) DEFAULT NULL,
  `nama_penerima` varchar(255) DEFAULT NULL,
  `alamat_pengirim` varchar(255) DEFAULT NULL,
  `alamat_penerima` varchar(255) DEFAULT NULL,
  `no_hp_penerima` varchar(255) DEFAULT NULL,
  `no_hp_pengirim` varchar(255) DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `lama_kredit` double DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `kd_user` bigint(20) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`no_transaksi`),
  KEY `kd_customer` (`kd_customer`),
  KEY `kd_jenis_bayar` (`kd_jenis_bayar`),
  KEY `kd_kas` (`kd_kas`),
  KEY `kd_divisi` (`kd_divisi`),
  KEY `kd_layanan` (`kd_layanan`),
  CONSTRAINT `t_pengiriman_ibfk_1` FOREIGN KEY (`kd_customer`) REFERENCES `m_customer` (`kd_customer`),
  CONSTRAINT `t_pengiriman_ibfk_2` FOREIGN KEY (`kd_jenis_bayar`) REFERENCES `m_jenis_bayar` (`kd_jenis_bayar`),
  CONSTRAINT `t_pengiriman_ibfk_3` FOREIGN KEY (`kd_kas`) REFERENCES `m_kas` (`kd_kas`),
  CONSTRAINT `t_pengiriman_ibfk_4` FOREIGN KEY (`kd_divisi`) REFERENCES `m_divisi` (`kd_divisi`),
  CONSTRAINT `t_pengiriman_ibfk_5` FOREIGN KEY (`kd_layanan`) REFERENCES `m_layanan` (`kd_layanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_pengiriman
-- ----------------------------

-- ----------------------------
-- Table structure for t_pengiriman_detail
-- ----------------------------
DROP TABLE IF EXISTS `t_pengiriman_detail`;
CREATE TABLE `t_pengiriman_detail` (
  `nomor` bigint(20) NOT NULL AUTO_INCREMENT,
  `nomor_reff` varchar(255) DEFAULT NULL,
  `no_transaksi` bigint(20) DEFAULT NULL,
  `kd_jenis` bigint(20) DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `jumlah_item` double DEFAULT NULL,
  `jumlah_berat` double DEFAULT NULL,
  `harga_berat` bigint(20) DEFAULT NULL,
  `panjang` double DEFAULT NULL,
  `lebar` double DEFAULT NULL,
  `tinggi` double DEFAULT NULL,
  `harga_volume` double DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT current_timestamp(),
  `date_modif` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`nomor`),
  KEY `no_transaksi` (`no_transaksi`),
  KEY `kd_jenis` (`kd_jenis`),
  CONSTRAINT `t_pengiriman_detail_ibfk_1` FOREIGN KEY (`no_transaksi`) REFERENCES `t_pengiriman` (`no_transaksi`),
  CONSTRAINT `t_pengiriman_detail_ibfk_2` FOREIGN KEY (`kd_jenis`) REFERENCES `m_jenis_kirim` (`kd_jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_pengiriman_detail
-- ----------------------------

-- ----------------------------
-- Table structure for x_token_login
-- ----------------------------
DROP TABLE IF EXISTS `x_token_login`;
CREATE TABLE `x_token_login` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_user` bigint(20) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of x_token_login
-- ----------------------------
