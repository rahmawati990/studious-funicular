-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2017 at 10:55 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `butikdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kd_barang` char(4) NOT NULL,
  `nm_barang` varchar(200) NOT NULL,
  `harga_beli` int(10) NOT NULL,
  `harga_jual` int(10) NOT NULL,
  `diskon` int(3) NOT NULL,
  `stok` int(3) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `kd_kategori` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kd_barang`, `nm_barang`, `harga_beli`, `harga_jual`, `diskon`, `stok`, `keterangan`, `kd_kategori`) VALUES
('B017', 'ban dalem', 100000, 120000, 5, 10, 'baru', 'K01'),
('B019', 'oli grdan', 35000, 45000, 0, 10, 'baru', 'K02'),
('B026', 'ban michel', 220000, 300000, 0, 0, 'sfsdf', 'K01');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kd_kategori` char(3) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kd_kategori`, `nm_kategori`) VALUES
('K01', 'BAN'),
('K02', 'OLI'),
('K03', 'GEAR');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `no_pembelian` char(7) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `kd_supplier` char(3) NOT NULL,
  `userid` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`no_pembelian`, `tgl_transaksi`, `catatan`, `kd_supplier`, `userid`) VALUES
('BL00001', '2012-09-01', 'lancar', 'S02', 'admin'),
('BL00002', '2012-09-01', 'stok baru', 'S02', 'admin'),
('BL00003', '2012-09-01', 'stok baru', 'S02', 'admin'),
('BL00004', '2012-09-01', 'stok baru', 'S01', 'admin'),
('BL00005', '2012-09-01', 'stok baru', 'S02', 'admin'),
('BL00006', '2017-09-11', '', 'S03', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_item`
--

CREATE TABLE `pembelian_item` (
  `no_pembelian` char(7) NOT NULL,
  `kd_barang` char(4) NOT NULL,
  `harga_beli` int(10) NOT NULL,
  `jumlah` int(3) NOT NULL
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
('BL00005', 'B014', 95000, 10),
('BL00006', 'B017', 1000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `no_penjualan` char(7) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `pelanggan` varchar(60) NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `userid` varchar(20) NOT NULL
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
('JL00006', '2012-09-09', 'harmanto', 'jogja', 'admin'),
('JL00007', '2017-09-11', 'Umum', '', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_item`
--

CREATE TABLE `penjualan_item` (
  `no_penjualan` char(7) NOT NULL,
  `kd_barang` char(4) NOT NULL,
  `harga_jual` int(10) NOT NULL,
  `jumlah` int(3) NOT NULL
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
('JL00006', 'B001', 108000, 1),
('JL00007', 'B025', 15000, 1),
('JL00007', 'B017', 97200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `kd_supplier` char(3) NOT NULL,
  `nm_supplier` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telpon` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`kd_supplier`, `nm_supplier`, `alamat`, `telpon`) VALUES
('S01', 'PT swalau', 'jakarta', '0819123123'),
('S02', 'PT michelin', 'tangerang', '0819123123'),
('S03', 'PT batlax', 'bogor', '08191222231341');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_pembelian`
--

CREATE TABLE `tmp_pembelian` (
  `id` int(3) NOT NULL,
  `kd_barang` char(4) NOT NULL,
  `harga_beli` int(10) NOT NULL,
  `qty` int(3) NOT NULL,
  `userid` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penjualan`
--

CREATE TABLE `tmp_penjualan` (
  `id` int(3) NOT NULL,
  `kd_barang` char(4) NOT NULL,
  `harga_jual` int(10) NOT NULL,
  `qty` int(3) NOT NULL,
  `userid` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id` int(4) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `level` enum('Kasir','Admin') NOT NULL DEFAULT 'Kasir'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id`, `userid`, `password`, `nama`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'dedy teguh ', 'Admin'),
(2, 'kasir', 'c7911af3adbd12a035b289556d96470a', 'juned', 'Kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kd_barang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kd_kategori`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`no_pembelian`),
  ADD KEY `kd_supplier` (`kd_supplier`);

--
-- Indexes for table `pembelian_item`
--
ALTER TABLE `pembelian_item`
  ADD KEY `no_pembelian` (`no_pembelian`,`kd_barang`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`no_penjualan`);

--
-- Indexes for table `penjualan_item`
--
ALTER TABLE `penjualan_item`
  ADD KEY `kd_barang` (`kd_barang`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kd_supplier`);

--
-- Indexes for table `tmp_pembelian`
--
ALTER TABLE `tmp_pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tmp_pembelian`
--
ALTER TABLE `tmp_pembelian`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
