-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 04:11 PM
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
-- Database: `itso_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_item`
--

CREATE TABLE `borrowed_item` (
  `id` int(11) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `borrow_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `return_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_item`
--

INSERT INTO `borrowed_item` (`id`, `item_id`, `email`, `borrow_date`, `return_date`) VALUES
(50, 'ASS VVBK-002', 'mitagof177@luxyss.com', '2024-12-01 14:17:27', '2024-11-30 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `current`
--

CREATE TABLE `current` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `current`
--

INSERT INTO `current` (`id`, `user_id`, `first_name`, `last_name`, `email`) VALUES
(1, 54, 'Yshie Mykaela', 'Lima', 'mitagof177@luxyss.com');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('Active','Defective','Stock') NOT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `item_id`, `name`, `status`, `category`) VALUES
(333, 'ASS VVBK-001', 'Asus Vivobook', 'Defective', 'LAPTOP'),
(334, 'ASS VVBK-002', 'Asus Zenbook', 'Stock', 'LAPTOP'),
(335, 'RM 12 LBRTRY-001', 'Room 12 Laboratory', 'Stock', 'LAB ROOM KEY'),
(336, 'PRJCT-001', 'Project', 'Stock', 'PROJECTOR REMOTE'),
(337, 'WCM INTS PR PN-001', 'Wacom Intuos Pro Pen', 'Defective', 'PEN'),
(338, 'WCM INTS PR PN-002', 'Wacom Intuos Pro Pen', 'Defective', 'WACOM TABLET'),
(339, 'JBL-001', 'JBL', 'Stock', 'SPEAKER SET'),
(340, 'EXTNSN CRD 5M-001', 'Extension Cord 5m', 'Stock', 'EXTENSION CORD'),
(341, 'MGC MS-001', 'Magic Mouse', 'Stock', 'MOUSE'),
(342, 'MGC MS-002', 'Magic Mouse', 'Stock', 'MOUSE'),
(343, 'APPL LGHTNNG CBL-001', 'Apple Lightning Cable', 'Stock', 'LIGHTNING CABLE'),
(344, 'APPL LGHTNNG CBL-002', 'Apple Lightning Cable', 'Stock', 'LIGHTNING CABLE'),
(345, 'MGC KYBRD-001', 'Magic Keyboard', 'Stock', 'KEYBOARD'),
(346, 'MGC KYBRD-002', 'Magic Keyboard', 'Stock', 'KEYBOARD'),
(347, 'CBL CRMPNG TL-001', 'Cable Crimping Tool', 'Stock', 'CABLE CRIMPING TOOL'),
(348, 'CBL CRMPNG TL-002', 'Cable Crimping Tool', 'Stock', 'CABLE CRIMPING TOOL'),
(349, 'CBL CRMPNG TL-003', 'Cable Crimping Tool', 'Stock', 'CABLE CRIMPING TOOL'),
(350, 'CBL TSTR-001', 'Cable Tester', 'Stock', 'CABLE TESTER'),
(351, 'CBL TSTR-002', 'Cable Tester', 'Stock', 'CABLE TESTER'),
(352, 'CBL TSTR-003', 'Cable Tester', 'Defective', 'CABLE TESTER'),
(353, 'VGA CABLE-001', 'VGA CABLE', 'Stock', 'VGA CABLE'),
(354, 'VGA CABLE-002', 'VGA CABLE', 'Stock', 'VGA CABLE'),
(355, 'VGA CABLE-003', 'VGA CABLE', 'Stock', 'VGA CABLE'),
(356, 'VGA CABLE-004', 'VGA CABLE', 'Stock', 'VGA CABLE'),
(357, 'VGA CABLE-005', 'VGA CABLE', 'Stock', 'VGA CABLE'),
(358, 'VGA CABLE-006', 'VGA CABLE', 'Stock', 'VGA CABLE'),
(359, 'VGA CABLE-007', 'VGA CABLE', 'Stock', 'VGA CABLE'),
(360, 'VGA CABLE-008', 'VGA CABLE', 'Stock', 'VGA CABLE'),
(361, 'VGA CABLE-009', 'VGA CABLE', 'Stock', 'VGA CABLE'),
(362, 'VGA CABLE-010', 'VGA CABLE', 'Stock', 'VGA CABLE'),
(363, 'VGA CABLE-011', 'VGA CABLE', 'Stock', 'VGA CABLE'),
(364, 'VGA CABLE-012', 'VGA CABLE', 'Defective', 'VGA CABLE'),
(365, 'WBCM-001', 'Webcam', 'Stock', 'WEBCAM'),
(366, 'WBCM-002', 'Webcam', 'Stock', 'WEBCAM'),
(367, 'WBCM-003', 'Webcam', 'Defective', 'WEBCAM'),
(368, 'WBCM-004', 'Webcam', 'Stock', 'WEBCAM'),
(369, 'WBCM-005', 'Webcam', 'Defective', 'WEBCAM');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `reservation_date` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `email`, `item_id`, `reservation_date`, `created_at`, `updated_at`) VALUES
(4, 'mitagof177@luxyss.com', 'JBL-001', '2024-12-05', '2024-12-01 15:06:33', '2024-12-01 15:06:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `school_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('ITSO_Personnel','Associate','Student') NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `activation_code` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `school_id`, `first_name`, `last_name`, `email`, `password`, `user_type`, `status`, `activation_code`, `created_at`) VALUES
(49, '202210168', 'ITSO', 'ADMIN 2', 'ctorno30@gmail.com', '$2y$10$UmrXP6wq6lrIrBayNLZFC.TJ4PA8G/1wqbcAz/bQjoXCRzVn3P.7q', 'ITSO_Personnel', 1, '', '2024-12-01 04:40:42'),
(54, '202210130', 'Yshie Mykaela', 'Lima', 'mitagof177@luxyss.com', '$2y$10$VuFlM5WzHU7klYxwHJ5OquWkIaVBUc146CTcgsuNrJZdUNjlgmmZS', 'Associate', 1, '', '2024-12-01 14:14:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrowed_item`
--
ALTER TABLE `borrowed_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `current`
--
ALTER TABLE `current`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_id` (`item_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school_id` (`school_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrowed_item`
--
ALTER TABLE `borrowed_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `current`
--
ALTER TABLE `current`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=370;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowed_item`
--
ALTER TABLE `borrowed_item`
  ADD CONSTRAINT `borrowed_item_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `equipment` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
