-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2025 at 09:38 AM
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
-- Database: `motor_cycle`
--

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `car_id` int(11) NOT NULL,
  `car_name` varchar(100) NOT NULL,
  `car_status` enum('ว่าง','ถูกเช่า','กำลังซ่อมบำรุง') NOT NULL,
  `car_detail` varchar(255) DEFAULT NULL,
  `car_img` varchar(255) DEFAULT NULL,
  `car_plate` varchar(20) NOT NULL,
  `car_price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`car_id`, `car_name`, `car_status`, `car_detail`, `car_img`, `car_plate`, `car_price`) VALUES
(1, 'Honda Goldwing', '', 'ปกติ', '4bc17e56066cb72409beddf110042882.jpg', 'กข 2756', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cust_id` int(11) NOT NULL,
  `cust_name` varchar(100) NOT NULL,
  `cust_phone` varchar(10) NOT NULL,
  `cust_email` varchar(100) NOT NULL,
  `cust_gender` enum('ชาย','หญิง','อื่นๆ') DEFAULT NULL,
  `cust_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `cust_name`, `cust_phone`, `cust_email`, `cust_gender`, `cust_address`) VALUES
(154, 'tarathep12', '0639547613', 'Tarathep115@gmail.com', 'อื่นๆ', 'gay gay'),
(155, 'tarathep155', '0629547612', 'Tarathep155@gmail.com', 'ชาย', 'gay'),
(1556, 'tarathep1', '0629547613', 'Tarathep125@gmail.com', '', 'god');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `emp_phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `emp_name`, `emp_phone`) VALUES
(1, 'staff1', '0842354769');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paym_id` int(11) NOT NULL,
  `rent_id` int(11) NOT NULL,
  `paym_date` date NOT NULL,
  `paym_total_price` decimal(10,2) NOT NULL,
  `paym_status` enum('รอดำเนินการ','ชำระเงินแล้ว','ชำระเงินไม่สำเร็จ') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental`
--

CREATE TABLE `rental` (
  `rent_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `rent_start_date` date NOT NULL,
  `rent_return_date` date NOT NULL,
  `rent_status` enum('รอดำเนินการ','กำลังดำเนินการ','ดำเนินการเสร็จสิ้น','ยกเลิก') NOT NULL,
  `rent_total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repairment`
--

CREATE TABLE `repairment` (
  `rep_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `rep_status` enum('รอดำเนินการ','กำลังดำเนินการ','ดำเนินการเสร็จสิ้น') NOT NULL,
  `rep_price` decimal(10,2) NOT NULL,
  `rep_detail` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repairment`
--

INSERT INTO `repairment` (`rep_id`, `car_id`, `emp_id`, `rep_status`, `rep_price`, `rep_detail`) VALUES
(1, 1, 1, '', 1.00, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`car_id`),
  ADD UNIQUE KEY `car_plate` (`car_plate`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cust_id`),
  ADD UNIQUE KEY `cust_phone` (`cust_phone`),
  ADD UNIQUE KEY `cust_email` (`cust_email`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `emp_phone` (`emp_phone`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paym_id`),
  ADD KEY `rent_id` (`rent_id`);

--
-- Indexes for table `rental`
--
ALTER TABLE `rental`
  ADD PRIMARY KEY (`rent_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `repairment`
--
ALTER TABLE `repairment`
  ADD PRIMARY KEY (`rep_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1557;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paym_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental`
--
ALTER TABLE `rental`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repairment`
--
ALTER TABLE `repairment`
  MODIFY `rep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`rent_id`) REFERENCES `rental` (`rent_id`);

--
-- Constraints for table `rental`
--
ALTER TABLE `rental`
  ADD CONSTRAINT `rental_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`),
  ADD CONSTRAINT `rental_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `car` (`car_id`),
  ADD CONSTRAINT `rental_ibfk_3` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`);

--
-- Constraints for table `repairment`
--
ALTER TABLE `repairment`
  ADD CONSTRAINT `repairment_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `car` (`car_id`),
  ADD CONSTRAINT `repairment_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
