-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 23, 2020 at 02:08 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `disks_db_736`
--

-- --------------------------------------------------------

--
-- Table structure for table `DISKS`
--

CREATE TABLE `DISKS` (
  `id` int(11) NOT NULL,
  `manufacturer` text NOT NULL,
  `model` text NOT NULL,
  `description` text NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `transfer_rate` int(11) NOT NULL,
  `interface` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `DISKS`
--

INSERT INTO `DISKS` (`id`, `manufacturer`, `model`, `description`, `capacity`, `price`, `transfer_rate`, `interface`) VALUES
(1, 'Toshiba', 'P300 [HDWD110EZSTA]', '', 1000, 3300, 173, 'SATA III 3.5\"'),
(2, 'Seagate', '5900 IronWolf [ST1000VN002]', '', 1000, 4600, 180, 'SATA III 3.5\"'),
(3, 'Toshiba', 'P300 [HDWD105UZSVA]', '', 500, 2600, 196, 'SATA III 3.5\"'),
(4, 'Seagate', '7200 BarraCuda [ST1000DM010]', '', 1000, 3100, 210, 'SATA III 3.5\"'),
(5, 'WD', 'Purple [WD20PURZ]', '', 2000, 5500, 145, 'SATA III 3.5\"'),
(6, 'WD', 'Black [WD5003AZEX]', '', 500, 5500, 150, 'SATA III 3.5\"'),
(7, 'Toshiba', 'P300 7200rpm [HDWD130EZSTA]', '', 3000, 5900, 196, 'SATA III 3.5\"'),
(8, 'Toshiba', 'V300 [HDWU130UZSVA]', '', 3000, 6100, 162, 'SATA III 3.5\"'),
(9, 'WD', 'Blue [WD40EZRZ]', '', 4000, 7200, 150, 'SATA III 3.5\"'),
(10, 'Seagate', 'BarraCuda [ST500LM030]', '', 500, 2600, 140, 'SATA III 2.5\"'),
(11, 'WD', 'Black [WD10SPSX]', '', 1000, 4100, 150, 'SATA III 2.5\"'),
(12, 'Toshiba', 'L200 Slim [HDWL110UZSVA]', '', 1000, 3800, 145, 'SATA III 2.5\"'),
(13, 'Toshiba', 'N300 [HDWQ140EZSTA]', '', 4000, 9700, 204, 'SATA III 3.5\"'),
(14, 'Toshiba', 'Enterprise Capacity [MG06ACA600E]', '', 6000, 13000, 230, 'SATA III 3.5\"'),
(15, 'WD', 'Blue [WD60EZAZ]', '', 6000, 12900, 180, 'SATA III 3.5\"'),
(16, 'WD', 'Gold [WD6003FRYZ]', '', 6000, 14400, 255, 'SATA III 3.5\"'),
(17, 'Seagate', 'SkyHawk 8Tb [ST8000VX004]', '', 8000, 18300, 210, 'SATA III 3.5\"'),
(18, 'Toshiba', 'X300 [HDWR11AUZSVA]', '', 10000, 20000, 600, 'SATA III 3.5\"'),
(19, 'Toshiba', 'MG07ACA12TE', '', 12000, 23000, 242, 'SATA III 3.5\"'),
(20, 'WD', 'Ultrastar DC HC550 [0F38459]', '', 18000, 38000, 269, 'SATA III 3.5\"'),
(21, 'WD', 'Red Pro [WD141KFGX]', '', 14000, 44800, 255, 'SATA III 3.5\"');

-- --------------------------------------------------------

--
-- Table structure for table `ORDERS`
--

CREATE TABLE `ORDERS` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `delivery_address` text NOT NULL,
  `additional_info` text NOT NULL,
  `city` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ORDERS`
--

INSERT INTO `ORDERS` (`order_id`, `user_id`, `price`, `delivery_address`, `additional_info`, `city`) VALUES
(1, 4, 407400, 'пр-т Вернадского, 78, А17', '', 'Москва');

-- --------------------------------------------------------

--
-- Table structure for table `ORDER_DETAILS`
--

CREATE TABLE `ORDER_DETAILS` (
  `order_id` int(11) NOT NULL,
  `disk_id` int(11) NOT NULL,
  `disk_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ORDER_DETAILS`
--

INSERT INTO `ORDER_DETAILS` (`order_id`, `disk_id`, `disk_count`) VALUES
(1, 13, 42);

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE `USERS` (
  `id` int(11) NOT NULL,
  `login` varchar(40) NOT NULL,
  `user_name` varchar(80) NOT NULL,
  `salt` varchar(41) NOT NULL,
  `password` varchar(41) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`id`, `login`, `user_name`, `salt`, `password`, `is_admin`) VALUES
(1, 'admin@ky3he4ik.dev', 'Михаил Болотов', 'q2435t5tgfw', 'b0218ee66e61bc8d06db45a7849c43bea0a18ea7', 1),
(2, 'vasya@mail.ru', 'Василий Иванов', 'z5qvbyHkO7xnx1EDCBbu0GrmiJF00NK8kfU+4A==', 'efb3eb41f1b5864004cc41b86223360ddd960e33', 0),
(3, 'timurka.kulikov@gmail.com', 'Куликов Тимур', 'rYvAFXuc/7GlZU6G03GW8BWY9xs8tiL8QYFGyg==', 'f0fd9c34625dda2870a8134ce7b213f294b32b1b', 0),
(4, 'philip_b@ky3he4ik.dev', 'Белозёров Филипп', 'Io3gH101IcuKCdpM4nptodxDwSVo+5PtERxOGw==', '3f1e679ccde2959fd0e4cea6312e0a6d40bf2791', 0),
(5, 'nikita@rambler.ru', 'Лихачёв Никита', '0uQT6/NradNt6T8Z6j/ibms3cqd9zb9hxxT+RA==', 'cb1d10228032191bc59dc5950ef57212eec9fa3e', 0),
(6, 'wild_racer@yandex.ru', 'Ефремов Пётр', 'D1zrjdj3yVKa6zvdV6NegWd7K5FDav2yrK+e/A==', 'd66ce76ab495641eae7f380a3c6770d6d2c7dbb6', 0),
(7, 'simon_pumba@mail.ru', 'Симонов Олег', 'gTQFzS5XJxAaYdwXJ6Oi9mBhJHd8lK38120iIA==', 'c4d0004a2bf920ced22b548e7c5bb646ebc1e067', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `DISKS`
--
ALTER TABLE `DISKS`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ORDERS`
--
ALTER TABLE `ORDERS`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `ORDERS` (`user_id`);

--
-- Indexes for table `ORDER_DETAILS`
--
ALTER TABLE `ORDER_DETAILS`
  ADD KEY `order_details_order` (`order_id`),
  ADD KEY `order_details_disk` (`disk_id`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `DISKS`
--
ALTER TABLE `DISKS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ORDERS`
--
ALTER TABLE `ORDERS`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ORDERS`
--
ALTER TABLE `ORDERS`
  ADD CONSTRAINT `ORDERS` FOREIGN KEY (`user_id`) REFERENCES `USERS` (`id`);

--
-- Constraints for table `ORDER_DETAILS`
--
ALTER TABLE `ORDER_DETAILS`
  ADD CONSTRAINT `order_details_disk` FOREIGN KEY (`disk_id`) REFERENCES `DISKS` (`id`),
  ADD CONSTRAINT `order_details_order` FOREIGN KEY (`order_id`) REFERENCES `ORDERS` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
