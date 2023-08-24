-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2023 at 02:16 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventori`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_account`
--

CREATE TABLE `tb_account` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(15000) NOT NULL,
  `type` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_account`
--

INSERT INTO `tb_account` (`id`, `name`, `email`, `username`, `password`, `type`, `date`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin', '$2y$10$2BgUnGCd/E3G3AbMacEoaeMRwPMSc9XvXmgLCtvB349AzsVhnWTe6', 'Admin', '2023-08-08 07:04:55'),
(2, 'Carolus Boromeus', 'carolusboromeus05@gmail.com', 'carolusboromeus05', '$2y$10$vdnHc89JfbkzdO4drjJ09OVYu79J8rXUkKpfbdjS9.w.A7mV1xgUO', 'Gudang', '2023-08-03 10:15:12'),
(4, 'Test', 'test123@gmail.com', 'test123', '$2y$10$5YVX5EBteLv/NTCdCau.lurQNnEkyetniY/2QdM4CBXwOECTSnNCu', 'Gudang', '2023-08-03 11:53:37'),
(5, 'Kasir', 'kasir123@gmail.com', 'kasir123', '$2y$10$dMMyTNkYntq4LBqIu34FXuRLmr/km1ze6LLz..vYHmOMs5HxDYQfa', 'Kasir', '2023-08-03 11:53:05');

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_category`
--

INSERT INTO `tb_category` (`id`, `category`, `date`, `user`) VALUES
(1, 'Buku', '2023-03-15 22:01:01', 1),
(2, 'Alat Tulis', '2023-08-02 23:49:43', 1),
(3, 'Other', '2023-03-15 22:02:07', 1),
(4, 'Kertas', '2023-08-01 01:27:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_incoming_stock`
--

CREATE TABLE `tb_incoming_stock` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` varchar(1500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_incoming_stock`
--

INSERT INTO `tb_incoming_stock` (`id`, `name`, `supplier`, `amount`, `description`, `date`, `user`) VALUES
(2, 3, 1, 10, '', '2023-04-15 13:21:26', 1),
(4, 3, 1, 30, 'Barang Masuk.', '2023-04-15 13:22:10', 1),
(5, 1, 3, 15, 'Barang Masuk.', '2023-04-22 04:56:21', 1),
(7, 2, 3, 55, '', '2023-04-22 05:12:44', 1),
(8, 4, 3, 15, '', '2023-04-22 05:13:34', 1),
(9, 5, 1, 40, 'Barang Masuk.', '2023-07-31 18:44:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_item`
--

CREATE TABLE `tb_item` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` int(11) NOT NULL,
  `description` varchar(1500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_item`
--

INSERT INTO `tb_item` (`id`, `name`, `category`, `description`, `date`, `user`) VALUES
(1, 'Gel Pen Joyko GP-265 ', 2, 'Alat tulis bulpen gel 0.5 mm.', '2023-03-15 16:31:24', 1),
(2, 'Big BOSS Buku Tulis EB 36 Campus', 1, 'Buku Tulis 36 Halaman', '2023-08-08 07:21:20', 1),
(3, 'Kertas HVS AONE A4 70 Gram', 4, 'Kertas HVS A4.', '2023-08-08 07:21:12', 1),
(4, 'SiDU Kertas Fotocopy 75 GSM A4', 4, 'Kertas HVS FotoCopy A4 75 gram. ', '2023-07-31 18:36:48', 1),
(5, 'Loose Leaf Kertas Binder File Note Joyko A5 7020', 4, 'Kertas Binder A5 70 gram, 20 lubang.', '2023-07-31 18:40:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_outstock`
--

CREATE TABLE `tb_outstock` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` varchar(1500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_outstock`
--

INSERT INTO `tb_outstock` (`id`, `name`, `supplier`, `amount`, `description`, `date`, `user`) VALUES
(1, 3, 1, 10, 'Barang Keluar.', '2023-04-15 13:22:30', 1),
(2, 3, 1, 5, '', '2023-04-15 13:25:03', 1),
(3, 5, 1, 10, 'Barang Keluar.', '2023-07-31 18:44:56', 1),
(4, 2, 3, 10, '', '2023-08-08 10:10:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_reset_token`
--

CREATE TABLE `tb_reset_token` (
  `id` int(11) NOT NULL,
  `email` int(11) NOT NULL,
  `token` varchar(250) NOT NULL,
  `expdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_stock`
--

CREATE TABLE `tb_stock` (
  `id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_stock`
--

INSERT INTO `tb_stock` (`id`, `item`, `supplier`, `stock`, `date`, `user`) VALUES
(3, 3, 3, 20, '2023-07-31 13:21:54', 1),
(4, 1, 1, 15, '2023-08-08 10:08:17', 1),
(6, 2, 3, 45, '2023-04-22 04:58:14', 1),
(7, 4, 3, 15, '2023-07-31 13:21:59', 1),
(9, 5, 1, 30, '2023-07-31 18:42:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `telephone` varchar(100) NOT NULL,
  `description` varchar(1500) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`id`, `name`, `address`, `telephone`, `description`, `date`, `user`) VALUES
(1, 'PT Atali Makmur', 'Maspion Plaza, 10th floor, JL. Gunung Sahari Kav 18, Jakarta 14420, Indonesia', '082164701178', 'Perusahaan yang memasok produk buku tulis, dan alat tulis seperti JOYKO dan JOY-ART.', '2023-08-08 08:40:59', 4),
(3, 'PT Pabrik Kertas Tjiwi Kimia', 'Jalan Raya Surabaya - Mojokerto km 44, Desa Kramat Temenggung, Kecamatan Tarik, Sidoarjo, East Java, Indonesia, PO BOX 115 Mojokerto 61265', '08321361552', 'Perusahaan yang bergerak di bidang pembuatan kertas yang menyediakan produk seperti buku tulis, memo, notepad, loose leaf, spiral, amplop, kertas komputer, dan kertas kado.', '2023-08-02 16:48:46', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_account`
--
ALTER TABLE `tb_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `USER` (`user`);

--
-- Indexes for table `tb_incoming_stock`
--
ALTER TABLE `tb_incoming_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NAME` (`name`),
  ADD KEY `USER` (`user`),
  ADD KEY `SUPPLIER` (`supplier`) USING BTREE;

--
-- Indexes for table `tb_item`
--
ALTER TABLE `tb_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `USER` (`user`),
  ADD KEY `CATEGORY` (`category`);

--
-- Indexes for table `tb_outstock`
--
ALTER TABLE `tb_outstock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NAME` (`name`),
  ADD KEY `USER` (`user`) USING BTREE,
  ADD KEY `SUPPLIER` (`supplier`) USING BTREE;

--
-- Indexes for table `tb_reset_token`
--
ALTER TABLE `tb_reset_token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `EMAIL` (`email`);

--
-- Indexes for table `tb_stock`
--
ALTER TABLE `tb_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `SUPPLIER` (`supplier`) USING BTREE,
  ADD KEY `ITEM` (`item`),
  ADD KEY `USER` (`user`) USING BTREE;

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `USER` (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_account`
--
ALTER TABLE `tb_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_incoming_stock`
--
ALTER TABLE `tb_incoming_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_item`
--
ALTER TABLE `tb_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_outstock`
--
ALTER TABLE `tb_outstock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_reset_token`
--
ALTER TABLE `tb_reset_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_stock`
--
ALTER TABLE `tb_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD CONSTRAINT `tb_category_ibfk_1` FOREIGN KEY (`user`) REFERENCES `tb_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_incoming_stock`
--
ALTER TABLE `tb_incoming_stock`
  ADD CONSTRAINT `tb_incoming_stock_ibfk_1` FOREIGN KEY (`name`) REFERENCES `tb_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_incoming_stock_ibfk_2` FOREIGN KEY (`user`) REFERENCES `tb_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_incoming_stock_ibfk_3` FOREIGN KEY (`supplier`) REFERENCES `tb_supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_item`
--
ALTER TABLE `tb_item`
  ADD CONSTRAINT `tb_item_ibfk_1` FOREIGN KEY (`user`) REFERENCES `tb_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_item_ibfk_2` FOREIGN KEY (`category`) REFERENCES `tb_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_outstock`
--
ALTER TABLE `tb_outstock`
  ADD CONSTRAINT `tb_outstock_ibfk_1` FOREIGN KEY (`name`) REFERENCES `tb_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_outstock_ibfk_2` FOREIGN KEY (`user`) REFERENCES `tb_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_outstock_ibfk_3` FOREIGN KEY (`supplier`) REFERENCES `tb_supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_reset_token`
--
ALTER TABLE `tb_reset_token`
  ADD CONSTRAINT `tb_reset_token_ibfk_1` FOREIGN KEY (`email`) REFERENCES `tb_account` (`id`);

--
-- Constraints for table `tb_stock`
--
ALTER TABLE `tb_stock`
  ADD CONSTRAINT `tb_stock_ibfk_1` FOREIGN KEY (`supplier`) REFERENCES `tb_supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_stock_ibfk_3` FOREIGN KEY (`item`) REFERENCES `tb_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_stock_ibfk_4` FOREIGN KEY (`user`) REFERENCES `tb_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD CONSTRAINT `tb_supplier_ibfk_1` FOREIGN KEY (`user`) REFERENCES `tb_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
