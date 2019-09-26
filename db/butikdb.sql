-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 09, 2012 at 03:42 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `butikdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `kd_barang` char(4) NOT NULL,
  `nm_barang` varchar(200) NOT NULL,
  `harga_beli` int(10) NOT NULL,
  `harga_jual` int(10) NOT NULL,
  `diskon` int(3) NOT NULL,
  `stok` int(3) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `kd_kategori` char(3) NOT NULL,
  PRIMARY KEY (`kd_barang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kd_barang`, `nm_barang`, `harga_beli`, `harga_jual`, `diskon`, `stok`, `keterangan`, `kd_kategori`) VALUES
('B001', 'Bluespurple batik with bolero dress', 80000, 120000, 10, 7, 'Elegan', 'K01'),
('B018', 'Krancang Kebaya Purple', 140000, 185000, 10, 10, 'baru', 'K04'),
('B002', 'Greenpink batik dress with bolero', 80000, 120000, 10, 8, 'Elegan', 'K01'),
('B003', 'Chifon Browngrey batik blouse', 80000, 125000, 10, 10, 'keren', 'K01'),
('B004', 'Brown print Batik dress', 85000, 135000, 10, 7, 'Elegan', 'K01'),
('B005', 'Green Dewi batik dress', 80000, 125000, 10, 10, 'baru', 'K01'),
('B006', 'Shine fuchsia batwing blouse', 85000, 85000, 10, 10, 'baru', 'K01'),
('B007', 'Purple leaves batik dress', 70000, 98000, 10, 10, 'baru', 'K01'),
('B008', 'Batwing white top', 75000, 110000, 10, 10, 'baru', 'K02'),
('B009', 'Black candy sifon', 80000, 120000, 10, 10, 'baru', 'K02'),
('B010', 'Tops Lace flower Red', 75000, 99000, 10, 8, 'baru', 'K02'),
('B011', 'Tops Lace flower Black', 75000, 99000, 10, 10, 'baru', 'K02'),
('B012', 'Tops Lace flower Grey', 75000, 99000, 10, 8, 'baru', 'K02'),
('B013', 'Knit Tunic Grey', 90000, 140000, 10, 9, 'baru', 'K02'),
('B014', 'Fuchsia flowR minidress', 95000, 130000, 10, 10, 'baru', 'K03'),
('B015', 'Blackline jeans minidress', 90000, 120000, 10, 10, 'baru', 'K03'),
('B016', 'Black midi Zipper with belt', 90000, 120000, 10, 10, 'baru', 'K03'),
('B017', 'Orange Polka ribbon minidress', 75000, 108000, 10, 10, 'baru', 'K03'),
('B019', 'Krancang Kebaya Green', 140000, 185000, 10, 10, 'baru', 'K04'),
('B020', 'Krancang Kebaya Bronze', 135000, 185000, 10, 10, 'baru', 'K04'),
('B021', 'Krancang FlowR Line Purple', 135000, 185000, 10, 10, 'baru', 'K04'),
('B022', 'Gamis + Jilbab BlackPurple', 135000, 185000, 10, 0, 'baru', 'K06'),
('B023', 'Gamis + Jilbab BlackRed', 135000, 185000, 10, 0, 'baru', 'K06'),
('B024', 'Gamis + Jilbab BlackBlue', 135000, 185000, 10, 0, 'baru', 'K06');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `kd_kategori` char(3) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_kategori`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kd_kategori`, `nm_kategori`) VALUES
('K01', 'Women Batik'),
('K02', 'Women Blouse'),
('K03', 'Women Dress'),
('K04', 'Busana Muslim'),
('K05', 'Moslem Blues'),
('K06', 'Moslem Gamis');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE IF NOT EXISTS `pembelian` (
  `no_pembelian` char(7) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `kd_supplier` char(3) NOT NULL,
  `userid` varchar(20) NOT NULL,
  PRIMARY KEY (`no_pembelian`),
  KEY `kd_supplier` (`kd_supplier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`no_pembelian`, `tgl_transaksi`, `catatan`, `kd_supplier`, `userid`) VALUES
('BL00001', '2012-09-01', 'lancar', 'S02', 'admin'),
('BL00002', '2012-09-01', 'stok baru', 'S02', 'admin'),
('BL00003', '2012-09-01', 'stok baru', 'S02', 'admin'),
('BL00004', '2012-09-01', 'stok baru', 'S01', 'admin'),
('BL00005', '2012-09-01', 'stok baru', 'S02', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_item`
--

CREATE TABLE IF NOT EXISTS `pembelian_item` (
  `no_pembelian` char(7) NOT NULL,
  `kd_barang` char(4) NOT NULL,
  `harga_beli` int(10) NOT NULL,
  `jumlah` int(3) NOT NULL,
  KEY `no_pembelian` (`no_pembelian`,`kd_barang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian_item`
--

INSERT INTO `pembelian_item` (`no_pembelian`, `kd_barang`, `harga_beli`, `jumlah`) VALUES
('BL00001', 'B004', 85000, 10),
('BL00001', 'B002', 80000, 10),
('BL00001', 'B001', 80000, 10),
('BL00001', 'B003', 80000, 10),
('BL00001', 'B005', 80000, 10),
('BL00002', 'B008', 75000, 10),
('BL00002', 'B007', 70000, 10),
('BL00002', 'B006', 85000, 10),
('BL00003', 'B012', 75000, 10),
('BL00003', 'B011', 75000, 10),
('BL00003', 'B010', 75000, 10),
('BL00003', 'B009', 80000, 10),
('BL00004', 'B021', 135000, 10),
('BL00004', 'B020', 135000, 10),
('BL00004', 'B019', 140000, 10),
('BL00004', 'B018', 140000, 10),
('BL00005', 'B013', 90000, 10),
('BL00005', 'B017', 75000, 10),
('BL00005', 'B016', 90000, 10),
('BL00005', 'B015', 90000, 10),
('BL00005', 'B014', 95000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE IF NOT EXISTS `penjualan` (
  `no_penjualan` char(7) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `pelanggan` varchar(60) NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `userid` varchar(20) NOT NULL,
  PRIMARY KEY (`no_penjualan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`no_penjualan`, `tgl_transaksi`, `pelanggan`, `catatan`, `userid`) VALUES
('JL00001', '2012-09-01', 'Umum', 'pelanggan', 'admin'),
('JL00002', '2012-09-01', 'Umum', 'langganan', 'admin'),
('JL00003', '2012-09-01', 'Umum', 'langganan', 'admin'),
('JL00004', '2012-09-02', 'Umum', 'pelanggan', 'admin'),
('JL00005', '2012-09-03', 'Septi Suhesti', 'Simpang Sribawono', 'admin'),
('JL00006', '2012-09-09', 'harmanto', 'jogja', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_item`
--

CREATE TABLE IF NOT EXISTS `penjualan_item` (
  `no_penjualan` char(7) NOT NULL,
  `kd_barang` char(4) NOT NULL,
  `harga_jual` int(10) NOT NULL,
  `jumlah` int(3) NOT NULL,
  KEY `kd_barang` (`kd_barang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_item`
--

INSERT INTO `penjualan_item` (`no_penjualan`, `kd_barang`, `harga_jual`, `jumlah`) VALUES
('JL00001', 'B004', 121500, 1),
('JL00001', 'B002', 108000, 1),
('JL00001', 'B001', 108000, 1),
('JL00002', 'B010', 89100, 1),
('JL00003', 'B013', 126000, 1),
('JL00004', 'B004', 121500, 1),
('JL00005', 'B012', 89100, 1),
('JL00005', 'B004', 121500, 1),
('JL00006', 'B001', 108000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `kd_supplier` char(3) NOT NULL,
  `nm_supplier` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telpon` varchar(20) NOT NULL,
  PRIMARY KEY (`kd_supplier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`kd_supplier`, `nm_supplier`, `alamat`, `telpon`) VALUES
('S01', 'Indah Taylor', 'Wayabung, TuBa, Lampung', '0819123123'),
('S02', 'Jogja Fashion', 'Way Jepara, Lampung Timur', '0819123123'),
('S03', 'Bunafit Fashion', 'Bantul, Yogyakarta', '08191222231341');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_pembelian`
--

CREATE TABLE IF NOT EXISTS `tmp_pembelian` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `kd_barang` char(4) NOT NULL,
  `harga_beli` int(10) NOT NULL,
  `qty` int(3) NOT NULL,
  `userid` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penjualan`
--

CREATE TABLE IF NOT EXISTS `tmp_penjualan` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `kd_barang` char(4) NOT NULL,
  `harga_jual` int(10) NOT NULL,
  `qty` int(3) NOT NULL,
  `userid` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE IF NOT EXISTS `user_login` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `userid` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `level` enum('Kasir','Admin') NOT NULL DEFAULT 'Kasir',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id`, `userid`, `password`, `nama`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Bunafit Nugroho', 'Admin'),
(2, 'kasir', 'c7911af3adbd12a035b289556d96470a', 'Septi Suhesti', 'Kasir');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
