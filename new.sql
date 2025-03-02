-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2025 at 05:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simply_wear_fashion`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`) VALUES
(2, 'super@gmail.com', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` enum('S','M','L','XL') DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','shipped','completed','cancelled','rejected','delivered','approved') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `status`, `created_at`, `modified_by`, `modified_at`) VALUES
(19, 14, 2400.00, 'approved', '2025-02-23 21:27:43', NULL, NULL),
(20, 14, 4000.00, 'rejected', '2025-02-23 21:28:08', NULL, NULL),
(21, 36, 1000.00, 'approved', '2025-02-23 23:11:34', NULL, NULL),
(22, 14, 2000.00, 'shipped', '2025-02-26 19:47:04', 2, '2025-02-26 15:23:29'),
(23, 14, 1000.00, 'pending', '2025-03-01 19:54:07', NULL, NULL),
(24, 37, 1200.00, 'pending', '2025-03-02 16:04:33', NULL, NULL),
(25, 14, 1000.00, 'pending', '2025-03-02 16:19:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `prod_id`, `product_name`, `price`, `size`, `quantity`, `created_at`) VALUES
(17, 19, 18, 'Pant', 1200.00, 'XL', 1, '2025-02-23 21:27:43'),
(18, 19, 18, 'Pant', 1200.00, 'L', 1, '2025-02-23 21:27:43'),
(19, 20, 20, 'Hawaii Tshirt', 2000.00, 'XL', 1, '2025-02-23 21:28:08'),
(20, 20, 20, 'Hawaii Tshirt', 2000.00, 'L', 1, '2025-02-23 21:28:08'),
(21, 21, 19, 'Flower T-shirt', 1000.00, 'M', 1, '2025-02-23 23:11:34'),
(22, 22, 20, 'Hawaii Tshirt', 2000.00, 'M', 1, '2025-02-26 19:47:04'),
(23, 23, 19, 'Flower T-shirt', 1000.00, 'L', 1, '2025-03-01 19:54:07'),
(24, 24, 18, 'Pant', 1200.00, 'L', 1, '2025-03-02 16:04:33'),
(25, 25, 19, 'Flower T-shirt', 1000.00, 'XL', 1, '2025-03-02 16:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `productdetails`
--

CREATE TABLE `productdetails` (
  `prod_id` int(11) NOT NULL,
  `prodname` varchar(100) NOT NULL,
  `prod_desc` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `f_stat` tinyint(1) DEFAULT 0,
  `na_stat` tinyint(1) DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productdetails`
--

INSERT INTO `productdetails` (`prod_id`, `prodname`, `prod_desc`, `image`, `price`, `quantity`, `f_stat`, `na_stat`, `created_by`, `created_at`, `modified_by`, `modified_at`) VALUES
(18, 'Pant', 'Size S, M, L, XL', 'f7.jpg', 1200.00, 100, 1, 1, 4, '2024-12-12 13:41:39', 4, '2025-03-01 13:26:19'),
(19, 'Flower T-shirt', 'Size S, M, L, XL', 'f3.jpg', 1000.00, 500, 1, 1, 4, '2024-12-19 08:41:05', 4, '2024-12-19 12:33:09'),
(20, 'Hawaii Tshirt', 'Size S, M, L, XL', 'f1.jpg', 2000.00, 100, 0, 0, 4, '2024-12-19 12:32:04', NULL, NULL),
(22, 'Gray Half Pant', 'Size S, M, L, XL', 'n6.jpg', 1500.00, 100, 1, 1, 4, '2025-03-02 11:40:28', NULL, NULL),
(23, 'Black T-Shirt', 'Size S, M, L, XL', 'n8.jpg', 1400.00, 50, 1, 0, 4, '2025-03-02 11:41:45', NULL, NULL),
(24, 'Lavish Shirt', 'Size S, M, L, XL', 'f6.jpg', 1800.00, 90, 0, 1, 4, '2025-03-02 11:43:46', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seller_credentials`
--

CREATE TABLE `seller_credentials` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('pending','active') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_credentials`
--

INSERT INTO `seller_credentials` (`id`, `username`, `email`, `phone_number`, `address`, `password`, `status`) VALUES
(4, 'Nirajan', 'seller@gmail.com', '9843989292', 'balkhu', '$2y$10$jeyp0v1PdqRkH5U8.HHqtuHSiIs7GbRZ75xnPHZiJGacdZu3iCW6K', 'active'),
(5, 'gobanesudi', 'pranish1316@gmail.com', '9812121212', 'Sunt dicta hic nemo ', '$2y$10$81pIltA561gcTDXciuPJIOc9X6DdoZKAE4tNCtZc6ZVEl1TMJOGpa', 'active'),
(6, 'kexedyf', 'pra123@gmail.com', '9812312312', 'Unde autem fuga Sim', '$2y$10$K4CG4Y6MP7VcHAe0MnCJlOkApXMdWATtZHc.ErBPwswczF5M9Ysc.', 'active'),
(7, 'sujina', 'seller101@gmail.com', '9843989211', 'Patan Multiple Campus', '$2y$10$JzHXSo7DSB8QwscfNLtCfu3SOliX7w4UmoTN8/WWkcx1QYnMWkvLG', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `user_credentials`
--

CREATE TABLE `user_credentials` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_credentials`
--

INSERT INTO `user_credentials` (`id`, `username`, `email`, `mobile`, `password`, `Address`) VALUES
(14, 'Sujin', 'sujin09818610719@gmail.com', '9806810788', '$2y$10$6FXMUGBvhpK7gEmr/AuqNOyf58ZUIVx6BXWr0t.4RCiEv7Te94182', 'enter valod address'),
(36, 'wau', 'wau@gmail.com', '9812121212', '$2y$10$9zlzDON3ufQ8/zje6lZaDe6eTwjo/1LmrMzZogkFor1Amaq.yXcIS', 'Balkhu Kumari Club'),
(37, 'Healer', 'pra123@gmail.com', '9843121212', '$2y$10$r3ZOiF4Vj8vKw.FBD60lU.I2qKPgv9kloumStEyHTS5qfaLdEB13W', 'Kathmandu Blue');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `orders_mdfk_1` (`modified_by`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `productdetails`
--
ALTER TABLE `productdetails`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `modified_by` (`modified_by`);

--
-- Indexes for table `seller_credentials`
--
ALTER TABLE `seller_credentials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- Indexes for table `user_credentials`
--
ALTER TABLE `user_credentials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `productdetails`
--
ALTER TABLE `productdetails`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `seller_credentials`
--
ALTER TABLE `seller_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_credentials`
--
ALTER TABLE `user_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_credentials` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `productdetails` (`prod_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_credentials` (`id`),
  ADD CONSTRAINT `orders_mdfk_1` FOREIGN KEY (`modified_by`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `productdetails` (`prod_id`);

--
-- Constraints for table `productdetails`
--
ALTER TABLE `productdetails`
  ADD CONSTRAINT `productdetails_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `seller_credentials` (`id`),
  ADD CONSTRAINT `productdetails_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `seller_credentials` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
