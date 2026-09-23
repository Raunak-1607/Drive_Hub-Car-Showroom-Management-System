-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2026 at 06:01 PM
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
-- Database: `dh`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `brand` varchar(60) NOT NULL,
  `model` varchar(80) NOT NULL,
  `year` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `fuel_type` varchar(30) NOT NULL,
  `transmission` varchar(30) NOT NULL,
  `engine` varchar(80) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `availability_status` enum('available','sold') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `brand`, `model`, `year`, `price`, `fuel_type`, `transmission`, `engine`, `image`, `availability_status`) VALUES
(1, 'Porsche', '911 Carrera S', 2024, 148500, 'Petrol', 'PDK Automatic', '3.0L Twin-Turbo Flat-Six', 'porshe911.jpg', 'available'),
(2, 'BMW', 'M4 Competition', 2024, 112000, 'Petrol', 'Automatic', '3.0L Twin-Turbo Inline-Six', 'bmwm4.jpg', 'available'),
(3, 'Mercedes-Benz', 'AMG GT 63', 2023, 195000, 'Petrol', 'Automatic', '4.0L Biturbo V8', 'amg.jpg', 'sold'),
(4, 'Audi', 'RS7 Sportback', 2024, 139900, 'Petrol', 'Tiptronic', '4.0L Twin-Turbo V8', 'rs7.jpg', 'available'),
(5, 'Ferrari', 'Roma Spider', 2024, 188000, 'Petrol', 'DCT Automatic', '3.9L Twin-Turbo V8', 'ferrari.jpg', 'available'),
(6, 'Lamborghini', 'Huracan EVO', 2023, 183000, 'Petrol', 'Automatic', '5.2L V10', 'lambo.jpg', 'available'),
(7, 'Range Rover', 'Sport SVR', 2024, 168000, 'Petrol', 'Automatic', '5.0L Supercharged V8', 'rr.jpg', 'available'),
(8, 'Maserati', 'GranTurismo Trofeo', 2024, 223500, 'Petrol', 'Automatic', '3.0L Twin-Turbo V6', 'maserati.jpg', 'sold');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `inquiry_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `employee_response` text DEFAULT NULL,
  `inquiry_status` enum('pending','resolved') DEFAULT 'pending',
  `inquiry_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`inquiry_id`, `customer_id`, `car_id`, `message`, `employee_response`, `inquiry_status`, `inquiry_date`) VALUES
(1, 3, 1, 'Interested in extended warranty and service coverage options for this model. What packages are available?', 'Thanks for reaching out. We offer 3-year and 5-year extended coverage plans. I have noted your interest and will call you to walk through pricing.', 'resolved', '2024-08-09 10:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `sale_status` enum('pending','sold') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `customer_id`, `employee_id`, `car_id`, `sale_price`, `sale_date`, `sale_status`) VALUES
(1, 3, 2, 3, 195000, '2024-08-05', 'sold');

-- --------------------------------------------------------

--
-- Table structure for table `test_drives`
--

CREATE TABLE `test_drives` (
  `testdrive_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `preferred_date` date NOT NULL,
  `preferred_time` time NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_drives`
--

INSERT INTO `test_drives` (`testdrive_id`, `customer_id`, `car_id`, `preferred_date`, `preferred_time`, `status`) VALUES
(1, 3, 1, '2024-08-15', '10:00:00', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','employee','admin') NOT NULL,
  `account_status` enum('active','inactive') DEFAULT 'active',
  `security_question` varchar(150) DEFAULT NULL,
  `security_answer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `phone`, `password`, `role`, `account_status`, `security_question`, `security_answer`) VALUES
(1, 'Admin', 'admin@drivehub.com', '11111111111', '$2y$10$w1/sHgf403vBATl8XVW5BO.oUxzDacOAJCNIOn1OurZYM.1QFQfNi', 'admin', 'active', 'What was the name of your first pet?', '$2y$10$EIY.26HrjA34nvI2UuPU0O6DDZjFIOycZywZwuB62SwF.p5dQt/s6'),
(2, 'Employee', 'employee@drivehub.com', '22222222222', '$2y$10$mh.PY6dv39xwHJ/JoP15A.yyciq4dQ7gG9xj2iYQbCIASwuh21rRa', 'employee', 'active', 'What city were you born in?', '$2y$10$jGqIIeJVXN5cuWw/snBmmOO.RyehoekTcNnzFb447r6MLdIiH8MdW'),
(3, 'Customer', 'customer@drivehub.com', '33333333333', '$2y$10$YEP/30H1tLSYGRx/LVujI.sQksYicq6kXdyZkHGcvsfmWRWnY.eoC', 'customer', 'active', 'What was the name of your first pet?', '$2y$10$d8CvNICQaiS9M45gmMeXdOzKn6XaY0vgWl7kVij76tpywcZcEOMda'),
(4, 'Abrar Kabir', 'akm@a.com', '1111111', '$2y$10$.klClxcRH0vln36SqmPYieoukwrk8L4q02Xbv15T/ja31GpJ7uhfK', 'customer', 'active', 'What was the name of your first pet?', '$2y$10$lE0vsolLdR8rNvSv4PtV7eIugnz1I58sNlnAjdI4xqwi.mzPNSXNy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`inquiry_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `test_drives`
--
ALTER TABLE `test_drives`
  ADD PRIMARY KEY (`testdrive_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `test_drives`
--
ALTER TABLE `test_drives`
  MODIFY `testdrive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `inquiries_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `inquiries_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `test_drives`
--
ALTER TABLE `test_drives`
  ADD CONSTRAINT `test_drives_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `test_drives_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
