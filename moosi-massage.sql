-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2019 at 06:22 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moosi-massage`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_detail`
--

CREATE TABLE `booking_detail` (
  `book_id` int(11) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hm_booking`
--

CREATE TABLE `hm_booking` (
  `book_id` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `book_date` date NOT NULL,
  `book_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `book_detail` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hm_customer`
--

CREATE TABLE `hm_customer` (
  `cus_id` int(11) NOT NULL,
  `cus_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cus_tel` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cus_line` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hm_customer`
--

INSERT INTO `hm_customer` (`cus_id`, `cus_name`, `cus_tel`, `cus_line`) VALUES
(1, 'ลูกค้า', '0982347561', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `hm_product`
--

CREATE TABLE `hm_product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_detail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_price` double NOT NULL,
  `product_unit` int(11) NOT NULL,
  `product_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hm_product`
--

INSERT INTO `hm_product` (`product_id`, `product_name`, `product_detail`, `product_price`, `product_unit`, `product_img`, `user_id`) VALUES
(1, 'Alovera oil', 'เพิ่มความชุ่มชื่นให้กับผิว ทำให้รู้สึกผ่อนคลาย', 200, 100, NULL, 4),
(2, 'อโลเวร่าออยล์', 'ทดสอบ', 150, 200, 'little-cats.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `hm_purchases`
--

CREATE TABLE `hm_purchases` (
  `pur_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `pur_date` date NOT NULL,
  `pur_unit` int(11) NOT NULL,
  `product_price` double NOT NULL,
  `admin_id` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hm_status`
--

CREATE TABLE `hm_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hm_status`
--

INSERT INTO `hm_status` (`status_id`, `status_name`) VALUES
(1, 'ผู้ดูแลระบบ'),
(2, 'หมอนวด');

-- --------------------------------------------------------

--
-- Table structure for table `hm_user`
--

CREATE TABLE `hm_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_tel` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_line` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hm_user`
--

INSERT INTO `hm_user` (`user_id`, `user_name`, `user_user`, `user_pass`, `user_tel`, `user_email`, `user_line`, `user_img`, `user_address`, `status_id`) VALUES
(1, 'Super Admineral', 'administator', '123456789', '0981022851', 'todsob@gmail.com', 'todsob', '', '99/3', 1),
(3, 'slur-dev2', 'user', 'pwd', '0999999993', 'test@gmail.com', 'noline', NULL, '100/2 ', 1),
(4, 'Super premium Massager', 'massager', '1234', '0981022851', 'todsob3@gmail.com', 'todsob3', '22450609_1577218025669344_808377911_o.jpg', '107 / 22', 2),
(6, 'Super premium Massager', 'massager', '1234', '0981022851', 'todsob3@gmail.com', 'todsob3', '22450609_1577218025669344_808377911_o.jpg', '107 / 22', 2),
(7, 'Super Admineral', 'root', 'root', '0981022851', 'todsob@gmail.com', 'todsob', '', '', 1),
(8, 'Super Admineral', 'root', 'root', '0981022851', 'todsob@gmail.com', 'todsob', '', '', 1),
(9, 'Super Admineral', 'root', '1234', '2132132132', 'todsob@gmail.com', 'todsob', 'little-cats.jpg', 'a', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_detail`
--
ALTER TABLE `booking_detail`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `hm_booking`
--
ALTER TABLE `hm_booking`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `hm_customer`
--
ALTER TABLE `hm_customer`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `hm_product`
--
ALTER TABLE `hm_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `hm_purchases`
--
ALTER TABLE `hm_purchases`
  ADD PRIMARY KEY (`pur_id`);

--
-- Indexes for table `hm_status`
--
ALTER TABLE `hm_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `hm_user`
--
ALTER TABLE `hm_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hm_customer`
--
ALTER TABLE `hm_customer`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hm_product`
--
ALTER TABLE `hm_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hm_purchases`
--
ALTER TABLE `hm_purchases`
  MODIFY `pur_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hm_user`
--
ALTER TABLE `hm_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
