-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2026 at 04:07 PM
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
-- Database: `f1_ticket_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `race_id` int(11) NOT NULL,
  `ticket_type_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `race_id`, `ticket_type_id`, `quantity`, `total_amount`, `status`, `booking_date`, `payment_method`, `payment_status`, `created_at`, `updated_at`) VALUES
(30, 11, 28, 95, 2, 24000.00, 'confirmed', '2025-10-09 16:41:28', NULL, 'pending', '2025-10-09 16:41:28', '2025-10-09 16:41:28'),
(31, 11, 29, 101, 1, 5000.00, 'confirmed', '2025-10-27 07:18:10', NULL, 'pending', '2025-10-27 07:18:10', '2025-10-27 07:18:10'),
(32, 11, 30, 104, 1, 2500.00, 'confirmed', '2025-10-27 07:18:23', NULL, 'pending', '2025-10-27 07:18:23', '2025-10-27 07:18:23'),
(33, 11, 28, 94, 1, 5000.00, 'confirmed', '2025-10-27 07:38:27', NULL, 'pending', '2025-10-27 07:38:27', '2025-10-27 07:38:27'),
(34, 11, 29, 100, 1, 2500.00, 'confirmed', '2025-10-29 09:15:54', NULL, 'pending', '2025-10-29 09:15:54', '2025-10-29 09:15:54'),
(35, 11, 28, 98, 5, 12500.00, 'confirmed', '2025-10-29 09:19:18', NULL, 'pending', '2025-10-29 09:19:18', '2025-10-29 09:19:18'),
(36, 14, 29, 100, 5, 12500.00, 'confirmed', '2025-10-29 09:20:28', NULL, 'pending', '2025-10-29 09:20:28', '2025-10-29 09:20:28'),
(37, 14, 30, 105, 2, 20000.00, 'confirmed', '2025-10-29 09:23:07', NULL, 'pending', '2025-10-29 09:23:07', '2025-10-29 09:23:07'),
(38, 16, 28, 98, 1, 2500.00, 'confirmed', '2025-11-21 03:16:48', NULL, 'pending', '2025-11-21 03:16:48', '2025-11-21 03:16:48'),
(39, 16, 29, 101, 1, 5000.00, 'confirmed', '2025-11-21 03:16:57', NULL, 'pending', '2025-11-21 03:16:57', '2025-11-21 03:16:57'),
(40, 16, 30, 105, 1, 10000.00, 'confirmed', '2025-11-21 03:17:08', NULL, 'pending', '2025-11-21 03:17:08', '2025-11-21 03:17:08'),
(41, 16, 28, 98, 5, 12500.00, 'confirmed', '2025-11-21 03:22:45', NULL, 'pending', '2025-11-21 03:22:45', '2025-11-21 03:22:45'),
(42, 11, 28, 98, 1, 2500.00, 'confirmed', '2026-01-28 14:50:20', NULL, 'pending', '2026-01-28 14:50:20', '2026-01-28 14:50:20');

-- --------------------------------------------------------

--
-- Stand-in structure for view `booking_details`
-- (See below for the actual view)
--
CREATE TABLE `booking_details` (
`booking_id` int(11)
,`quantity` int(11)
,`total_amount` decimal(10,2)
,`booking_status` enum('pending','confirmed','cancelled')
,`booking_date` timestamp
,`payment_method` varchar(50)
,`payment_status` enum('pending','completed','failed')
,`user_id` int(11)
,`full_name` varchar(100)
,`email` varchar(100)
,`phone` varchar(20)
,`race_id` int(11)
,`race_name` varchar(100)
,`track_name` varchar(100)
,`location` varchar(100)
,`race_date` date
,`race_time` time
,`ticket_type` varchar(50)
,`unit_price` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `races`
--

CREATE TABLE `races` (
  `id` int(11) NOT NULL,
  `race_name` varchar(100) NOT NULL,
  `track_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `race_date` date NOT NULL,
  `race_time` time NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','cancelled') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `race_track` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `races`
--

INSERT INTO `races` (`id`, `race_name`, `track_name`, `location`, `race_date`, `race_time`, `description`, `status`, `created_at`, `updated_at`, `image`, `race_track`) VALUES
(28, 'Monaco Grand Prix', 'Circuit de Monaco', 'Monte Carlo, Monaco	', '2025-11-27', '15:45:00', 'The Monaco Grand Prix is a prestigious annual Formula 1 motor race held on the narrow, winding streets of the Principality of Monaco.', 'active', '2025-10-09 16:22:34', '2025-10-09 16:22:34', '1760026954_gettyimages-2154750112-612x612.jpg', NULL),
(29, 'Abu Dhabi Grand Prix', 'Yas Marina Circuit', 'Abu Dhabi, UAE', '2025-11-30', '13:56:00', 'The Abu Dhabi Grand Prix is an annual Formula 1 motor race held at the Yas Marina Circuit on Yas Island, United Arab Emirates, since 2009', 'active', '2025-10-10 07:29:18', '2025-10-27 07:35:00', '1761550460_formul 1 stadium copy250618095246985~.png', NULL),
(30, 'Qatar Grand Prix', 'Losail International Circuit', 'Lusail, Qatar', '2025-12-23', '16:00:00', 'The Qatar Grand Prix is an annual Formula 1 night race held at the Lusail International Circuit, which is located north of Doha, Qatar', 'active', '2025-10-10 07:33:16', '2025-10-10 07:33:16', '1760081596_images2.jpeg', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `race_statistics`
-- (See below for the actual view)
--
CREATE TABLE `race_statistics` (
`id` int(11)
,`race_name` varchar(100)
,`track_name` varchar(100)
,`location` varchar(100)
,`race_date` date
,`race_time` time
,`total_bookings` bigint(21)
,`total_revenue` decimal(32,2)
,`confirmed_bookings` bigint(21)
,`pending_bookings` bigint(21)
,`cancelled_bookings` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `reachout`
--

CREATE TABLE `reachout` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reachout`
--

INSERT INTO `reachout` (`id`, `name`, `email`, `message`, `status`, `created_at`) VALUES
(2, 'Maria Rodriguez', 'maria.r@email.com', 'The Monaco Grand Prix was incredible! Best seats in the house. Thank you for the excellent service and quick booking confirmation.', 'new', '2024-02-25 08:50:00'),
(3, 'James Wilson', 'james.w@email.com', 'Had an issue with payment but customer support was very helpful. Got it resolved quickly and enjoyed the British Grand Prix.', 'new', '2024-03-05 05:45:00'),
(4, 'Sophie Chen', 'sophie.c@email.com', 'Amazing experience at Silverstone! The grandstand tickets provided perfect views of the action. Will definitely book again next year.', 'new', '2024-03-12 11:15:00'),
(7, 'khodu', NULL, 'this is a good web site i ever seen', 'new', '2025-10-29 09:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_types`
--

CREATE TABLE `ticket_types` (
  `id` int(11) NOT NULL,
  `ticket_type` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `race_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `available_quantity` int(11) NOT NULL DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_types`
--

INSERT INTO `ticket_types` (`id`, `ticket_type`, `price`, `description`, `race_id`, `created_at`, `available_quantity`) VALUES
(94, 'Grandstand', 5000.00, 'Premium seating with an excellent view of the start/finish line.', 28, '2025-10-09 16:36:32', 1999),
(95, 'VIP', 12000.00, 'Exclusive access to pit lane, paddock', 28, '2025-10-09 16:36:32', 498),
(98, 'General ', 2500.00, 'Access to open areas and fan zones around the track.', 28, '2025-10-09 16:38:20', 9988),
(100, 'General ', 2500.00, 'Access to open areas and fan zones around the track.', 29, '2025-10-10 07:39:35', 9994),
(101, 'Grandstand', 5000.00, 'Premium seating with an excellent view of the start/finish line.', 29, '2025-10-10 07:42:39', 1998),
(102, 'VIP', 10000.00, 'Exclusive access to pit lane, paddock', 29, '2025-10-10 07:42:39', 500),
(103, 'Grandstand', 5000.00, 'Premium seating with an excellent view of the start/finish line.', 30, '2025-10-27 07:11:39', 100),
(104, 'General ', 2500.00, 'Access to open areas and fan zones around the track.', 30, '2025-10-27 07:15:34', 9999),
(105, 'VIP', 10000.00, 'Exclusive access to pit lane, paddock', 30, '2025-10-27 07:16:38', 497);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(11, 'pal', 'pal@gamil.com', '$2y$10$Q4FMsJdK4mvgezsC1W8g2OY8vbNf8qupH9D3RDDWMWTfd3BsSys2W', 'pal gajera', '6356497821', 'active', '2025-07-25 15:31:46', '2025-07-25 17:00:58'),
(12, 'jon', 'jond2574@gmail.com', '$2y$10$JwehkGmDntGm1olxHzbZ8.OhYEsTuVReAofWfBi0l87GS9WGaPg8O', 'jondon', '99999999999', 'inactive', '2025-08-20 14:49:55', '2025-09-10 12:36:22'),
(13, 'jonny', 'jonny2574@gmail.com', '$2y$10$j.BrMm5JaJBeU04ybfFkW.MV/kf8w0zzA/vnujmsiUZ9jO/OGUoz.', 'jonnydon', '98645412', 'inactive', '2025-09-10 12:38:25', '2025-09-10 12:38:43'),
(14, 'vishvash', 'vishvaash7@gamil.com', '$2y$10$.juhptzsqLso2KFj3L941eNoVIEAKmKAmq/vhvnKJWz6b.2bFDlX.', 'vishvash', '8456213', 'active', '2025-10-29 09:19:59', '2025-10-29 09:19:59'),
(15, 'khodu', 'khodu@gmil.com', '$2y$10$6bkNN3YJJWDUi0t4t6jTf.XRWP8u9dRNRctXpI5kpJZDJMElLFSJu', 'khodu', '97456213', 'active', '2025-10-29 09:27:36', '2025-10-29 09:27:36'),
(16, 'yug', 'yug@gamil.com', '$2y$10$.JhGblodf8.fTc5BC6zZce7zoewJSMzOF.ANzFr//4UAZb4pM8JYi', 'yug kyada', '894512', 'active', '2025-11-21 03:16:28', '2025-11-21 03:16:28');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_statistics`
-- (See below for the actual view)
--
CREATE TABLE `user_statistics` (
`id` int(11)
,`username` varchar(50)
,`full_name` varchar(100)
,`email` varchar(100)
,`phone` varchar(20)
,`status` enum('active','inactive')
,`created_at` timestamp
,`total_bookings` bigint(21)
,`total_spent` decimal(32,2)
,`confirmed_bookings` bigint(21)
,`pending_bookings` bigint(21)
,`cancelled_bookings` bigint(21)
,`last_booking_date` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `booking_details`
--
DROP TABLE IF EXISTS `booking_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `booking_details`  AS SELECT `b`.`id` AS `booking_id`, `b`.`quantity` AS `quantity`, `b`.`total_amount` AS `total_amount`, `b`.`status` AS `booking_status`, `b`.`booking_date` AS `booking_date`, `b`.`payment_method` AS `payment_method`, `b`.`payment_status` AS `payment_status`, `u`.`id` AS `user_id`, `u`.`full_name` AS `full_name`, `u`.`email` AS `email`, `u`.`phone` AS `phone`, `r`.`id` AS `race_id`, `r`.`race_name` AS `race_name`, `r`.`track_name` AS `track_name`, `r`.`location` AS `location`, `r`.`race_date` AS `race_date`, `r`.`race_time` AS `race_time`, `tt`.`ticket_type` AS `ticket_type`, `tt`.`price` AS `unit_price` FROM (((`bookings` `b` join `users` `u` on(`b`.`user_id` = `u`.`id`)) join `races` `r` on(`b`.`race_id` = `r`.`id`)) join `ticket_types` `tt` on(`b`.`ticket_type_id` = `tt`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `race_statistics`
--
DROP TABLE IF EXISTS `race_statistics`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `race_statistics`  AS SELECT `r`.`id` AS `id`, `r`.`race_name` AS `race_name`, `r`.`track_name` AS `track_name`, `r`.`location` AS `location`, `r`.`race_date` AS `race_date`, `r`.`race_time` AS `race_time`, count(`b`.`id`) AS `total_bookings`, coalesce(sum(`b`.`total_amount`),0) AS `total_revenue`, count(case when `b`.`status` = 'confirmed' then 1 end) AS `confirmed_bookings`, count(case when `b`.`status` = 'pending' then 1 end) AS `pending_bookings`, count(case when `b`.`status` = 'cancelled' then 1 end) AS `cancelled_bookings` FROM (`races` `r` left join `bookings` `b` on(`r`.`id` = `b`.`race_id`)) GROUP BY `r`.`id`, `r`.`race_name`, `r`.`track_name`, `r`.`location`, `r`.`race_date`, `r`.`race_time` ;

-- --------------------------------------------------------

--
-- Structure for view `user_statistics`
--
DROP TABLE IF EXISTS `user_statistics`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_statistics`  AS SELECT `u`.`id` AS `id`, `u`.`username` AS `username`, `u`.`full_name` AS `full_name`, `u`.`email` AS `email`, `u`.`phone` AS `phone`, `u`.`status` AS `status`, `u`.`created_at` AS `created_at`, count(`b`.`id`) AS `total_bookings`, coalesce(sum(`b`.`total_amount`),0) AS `total_spent`, count(case when `b`.`status` = 'confirmed' then 1 end) AS `confirmed_bookings`, count(case when `b`.`status` = 'pending' then 1 end) AS `pending_bookings`, count(case when `b`.`status` = 'cancelled' then 1 end) AS `cancelled_bookings`, max(`b`.`booking_date`) AS `last_booking_date` FROM (`users` `u` left join `bookings` `b` on(`u`.`id` = `b`.`user_id`)) GROUP BY `u`.`id`, `u`.`username`, `u`.`full_name`, `u`.`email`, `u`.`phone`, `u`.`status`, `u`.`created_at` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_type_id` (`ticket_type_id`),
  ADD KEY `idx_bookings_user_id` (`user_id`),
  ADD KEY `idx_bookings_race_id` (`race_id`),
  ADD KEY `idx_bookings_status` (`status`),
  ADD KEY `idx_bookings_date` (`booking_date`);

--
-- Indexes for table `races`
--
ALTER TABLE `races`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_races_date` (`race_date`);

--
-- Indexes for table `reachout`
--
ALTER TABLE `reachout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_types`
--
ALTER TABLE `ticket_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ticket_types_race_id` (`race_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `races`
--
ALTER TABLE `races`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `reachout`
--
ALTER TABLE `reachout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ticket_types`
--
ALTER TABLE `ticket_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`race_id`) REFERENCES `races` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`ticket_type_id`) REFERENCES `ticket_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_types`
--
ALTER TABLE `ticket_types`
  ADD CONSTRAINT `ticket_types_ibfk_1` FOREIGN KEY (`race_id`) REFERENCES `races` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
