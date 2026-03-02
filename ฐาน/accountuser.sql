-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2026 at 05:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accountuser`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountuser`
--

CREATE TABLE `accountuser` (
  `id_account` int(11) NOT NULL,
  `user_account` varchar(40) DEFAULT NULL,
  `email_account` varchar(40) DEFAULT NULL,
  `phonenumber` varchar(15) DEFAULT NULL,
  `password_account` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `nickname` varchar(100) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accountuser`
--

INSERT INTO `accountuser` (`id_account`, `user_account`, `email_account`, `phonenumber`, `password_account`, `role`, `nickname`, `profile_image`) VALUES
(1, 'มามาา วันสยาม', 'gdtft@gmail.com', '09785475214', '$2y$10$cLqTyAfkNHbfHG4GLdyB6.wKCN96xItMqikeX/jVlBFtXQtNI.wbm', 'user', NULL, NULL),
(2, 'admin', 'admin@gmail.com', '0999999999', '$2y$10$3KYiTEMP8B5slk1AZIVjZewF9wb3kSTlFgCiDxFoFINLSdGPH.a5q', 'admin', '', '1772037609_สกรีนช็อต 2026-02-14 194634.png'),
(3, 'ภรณี ขาวทอง', 'paranee11082552@gmail.com', '0987252545', '$2y$10$1c3YPNGwynjpawKwEUkC9ud0soFNrrLK.hDIbzT2kz2M8eSa.pt7m', 'user', NULL, NULL),
(5, 'ธิดากานต์ อธิเกิด', 'GG@gmail.com', '0999999', '$2y$10$8kZPqBiKPwzPn6iHCt6H2edv6E83SjP1urXNgNC8FcPOT1FyHPWJy', 'user', NULL, '1771923771_GO-TALK_Noodle_02.jpg'),
(6, 'ธัชกร สุขศีล', 'th@gmail.com', '0888888', '$2y$10$Smt4UpKADk/bRwLg5NEKcug6uQbi4kppJdHniLWUdG279o5ZV.f2i', 'user', '', '1772033556_thai-flag.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `image`, `created_at`) VALUES
(1, 'อาหารตามสั่ง', NULL, '2026-02-03 09:22:39'),
(2, 'ปิ้งย่าง', NULL, '2026-02-03 09:22:39'),
(3, 'ชาบู', NULL, '2026-02-03 09:22:39'),
(4, 'คาเฟ่', NULL, '2026-02-03 09:22:39'),
(5, 'ซีฟู้ด', NULL, '2026-02-03 09:22:39'),
(6, 'ของหวาน', NULL, '2026-02-03 09:22:39'),
(7, 'ฟาสต์ฟู้ด', NULL, '2026-02-03 09:22:39'),
(8, 'ก๋วยเตี๋ยว', NULL, '2026-02-18 07:50:00'),
(9, 'หมูกระทะ', NULL, '2026-02-18 07:50:00'),
(10, 'สุกี้', NULL, '2026-02-18 07:50:00'),
(11, 'หม่าล่า', NULL, '2026-02-18 07:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `id_account` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `shop_id`, `id_account`, `rating`, `comment`, `created_at`) VALUES
(11, 15, 6, 5, 'อร่อยมากๆ', '2026-02-25 15:32:47'),
(12, 15, 6, 5, 'โครตอร่อย เส้นนุ่มอร่อย\r\n', '2026-02-25 15:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(150) NOT NULL,
  `category_id` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `map_link` text DEFAULT NULL,
  `open_time` varchar(50) DEFAULT NULL,
  `close_time` varchar(50) DEFAULT NULL,
  `price_range` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cover_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `shop_name`, `category_id`, `description`, `address`, `map_link`, `open_time`, `close_time`, `price_range`, `image`, `created_at`, `cover_image`) VALUES
(7, 'ก๋วยเตี๋ยวเฮียวินวินข้างสหไท', '8', 'ก๋วยเตี๋ยวสูตรโบราณ', 'ข้างสหไท', 'https://maps.app.goo.gl/j8NP2knETmVJ372s6', NULL, NULL, NULL, '1771401093_3322.webp', '2026-02-18 07:51:33', NULL),
(14, 'ก๋วยเตี๋ยวเฮียวินวินข้างสหไท', '2', 'iuiu', 'jghg', 'https://maps.app.goo.gl/j8NP2knETmVJ372s6', NULL, NULL, NULL, '1771405994_4466.jpg', '2026-02-18 09:13:14', NULL),
(15, 'ก๋วยเตี๋ยวเฮียวินวินข้างสหไท', '8', 'อยากกินอร่อยอย่ามาร้านนี้', '21121', 'http://www.svc.ac.th/th/', NULL, NULL, NULL, '1771407147_3958.jpg', '2026-02-18 09:32:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shop_images`
--

CREATE TABLE `shop_images` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shop_images`
--

INSERT INTO `shop_images` (`id`, `shop_id`, `image`, `created_at`) VALUES
(1, 15, '1771838175_เล่าถึงความอร่อยของ-ก๋วยเตี๋ยวเรือ-1024x1024.jpg', '2026-02-23 09:16:15'),
(2, 15, '1771838175_image-131-edited.webp', '2026-02-23 09:16:15'),
(3, 15, '1771838175_GO-TALK_Noodle_02.jpg', '2026-02-23 09:16:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountuser`
--
ALTER TABLE `accountuser`
  ADD PRIMARY KEY (`id_account`),
  ADD UNIQUE KEY `phonenumber` (`phonenumber`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_id` (`shop_id`),
  ADD KEY `id_account` (`id_account`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_images`
--
ALTER TABLE `shop_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountuser`
--
ALTER TABLE `accountuser`
  MODIFY `id_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `shop_images`
--
ALTER TABLE `shop_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`id_account`) REFERENCES `accountuser` (`id_account`) ON DELETE CASCADE;

--
-- Constraints for table `shop_images`
--
ALTER TABLE `shop_images`
  ADD CONSTRAINT `shop_images_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
