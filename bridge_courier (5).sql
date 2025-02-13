-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 04:28 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bridge_courier`
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
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` enum('S','M','L','XL') NOT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` > 0),
  `total` decimal(10,2) GENERATED ALWAYS AS (`price` * `quantity`) STORED,
  `order_status` enum('Pending','Sent') NOT NULL DEFAULT 'Pending',
  `user_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_name`, `price`, `size`, `quantity`, `order_status`, `user_id`, `image`) VALUES
(3, 'Flower T-shirt', 1000.00, 'M', 1, 'Pending', 14, 'f3.jpg');

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
(18, 'Pant', 'Size S, M, L, XL', 'f7.jpg', 1200.00, 400, 1, 1, 4, '2024-12-12 13:41:39', 4, '2024-12-19 12:24:46'),
(19, 'Flower T-shirt', 'Size S, M, L, XL', 'f3.jpg', 1000.00, 500, 1, 1, 4, '2024-12-19 08:41:05', 4, '2024-12-19 12:33:09'),
(20, 'Hawaii Tshirt', 'Size S, M, L, XL', 'f1.jpg', 2000.00, 100, 0, 0, 4, '2024-12-19 12:32:04', NULL, NULL);

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
(1, 'wedugu', 'wixazyn@mailinator.com', '9843982211', 'dasda', '$2y$10$gdfZ30.9Y0tUeprCFWdQl.s0y4WkHH6VEe2wuwDWgpLfRvBEjpVUy', 'active'),
(3, 'kebupah', 'sujin098@gmail.com', '9843989271', 'Kumari Club', '$2y$10$zv3c/jA9LQSGzyC8i5jzau1P/Lv.l3ggFMU8sUKi9PXSmZhaai7uq', 'pending'),
(4, 'Nirajan', 'seller@gmail.com', '9843989292', 'balkhu', '$2y$10$jeyp0v1PdqRkH5U8.HHqtuHSiIs7GbRZ75xnPHZiJGacdZu3iCW6K', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_credentials`
--

CREATE TABLE `user_credentials` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_credentials`
--

INSERT INTO `user_credentials` (`id`, `username`, `email`, `mobile`, `password`) VALUES
(13, 'bebalylada', 'saqit@mailinator.com', '9843123123', '$2y$10$JDtvH1U5ZL5qSmYgNqKw2udY6/VdcsXOUELq29Yt6GyBhpSsDa3QW'),
(14, 'Sujin', 'sujin09818610719@gmail.com', '9806810788', '$2y$10$6FXMUGBvhpK7gEmr/AuqNOyf58ZUIVx6BXWr0t.4RCiEv7Te94182'),
(15, 'giguxu', 'duhoheg@mailinator.com', '9843989277', '$2y$10$bhuu00mR3STYM8D4k3msM.7kwDcFy4se04MJnk8x/jz.eumAOHbK.'),
(16, 'zaneku', 'zewuholazi@mailinator.com', '9843989270', '$2y$10$dCWB.Oms31LeJ0JDYh0Vu.Z9q4SAqfKcmeOIIf7tL27ZQZcIzyW.a'),
(17, 'xufuk', 'woqehyxivi@mailinator.com', '9811111111', '$2y$10$jxc1jhbsg3IaIZyIWaGekuJql9d6tgEKMX2n2dTPUkxwyXcj5aHQC');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `productdetails`
--
ALTER TABLE `productdetails`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `seller_credentials`
--
ALTER TABLE `seller_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_credentials`
--
ALTER TABLE `user_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user_credentials` (`id`) ON DELETE CASCADE;

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
