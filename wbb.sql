-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2025 at 12:18 PM
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
-- Database: `wbb`
--

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

CREATE TABLE `analytics` (
  `id` int(11) NOT NULL,
  `user_ip` varchar(45) NOT NULL,
  `page` varchar(255) NOT NULL,
  `visit_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `analytics`
--

INSERT INTO `analytics` (`id`, `user_ip`, `page`, `visit_time`) VALUES
(1, '::1', '/wanna%20be%20booking/reports.php?export=pdf', '2025-02-15 20:18:12'),
(2, '::1', '/wanna%20be%20booking/reports.php', '2025-02-15 20:18:14'),
(3, '::1', '/wanna%20be%20booking/admin_privileges.php', '2025-02-15 20:18:16'),
(4, '::1', '/wanna%20be%20booking/index.php', '2025-02-15 20:18:17'),
(5, '::1', '/wanna%20be%20booking/admin_privileges.php', '2025-02-15 20:18:21'),
(6, '::1', '/wanna%20be%20booking/analytics.php', '2025-02-15 20:18:22'),
(7, '::1', '/wanna%20be%20booking/analytics.php', '2025-02-15 20:19:01'),
(8, '::1', '/wanna%20be%20booking/analytics.php', '2025-02-15 20:20:23'),
(9, '::1', '/wanna%20be%20booking/contact.php', '2025-02-15 20:20:46'),
(10, '::1', '/wanna%20be%20booking/admin_privileges.php', '2025-02-15 20:20:50'),
(11, '::1', '/wanna%20be%20booking/admin_privileges.php', '2025-02-15 20:35:23'),
(12, '::1', '/wanna%20be%20booking/admin_privileges.php', '2025-02-15 20:36:29'),
(13, '::1', '/wanna%20be%20booking/admin_privileges.php', '2025-02-15 20:41:29'),
(14, '::1', '/wanna%20be%20booking/confirm_reservations.php', '2025-02-15 20:41:30'),
(15, '::1', '/wanna%20be%20booking/confirm_reservations.php', '2025-02-15 20:42:08'),
(16, '::1', '/wanna%20be%20booking/confirm_reservations.php', '2025-02-15 20:42:08'),
(17, '::1', '/wanna%20be%20booking/confirm_reservations.php', '2025-02-15 20:47:43'),
(18, '::1', '/wanna%20be%20booking/confirm_reservations.php', '2025-02-15 20:47:45'),
(19, '::1', '/wanna%20be%20booking/admin_privileges.php', '2025-02-15 20:47:46'),
(20, '::1', '/wanna%20be%20booking/', '2025-02-15 20:47:49'),
(21, '::1', '/wanna%20be%20booking/', '2025-02-15 20:52:31'),
(22, '::1', '/wanna%20be%20booking/rooms.php', '2025-02-15 20:52:32'),
(23, '::1', '/wanna%20be%20booking/', '2025-02-15 20:53:09'),
(24, '::1', '/wanna%20be%20booking/your_reservations.php', '2025-02-15 20:53:11'),
(25, '::1', '/wanna%20be%20booking/index.php', '2025-02-15 20:53:17'),
(26, '::1', '/wanna%20be%20booking/index.php', '2025-02-15 21:02:30'),
(27, '::1', '/wanna%20be%20booking/rooms.php', '2025-02-15 21:02:32'),
(28, '::1', '/wanna%20be%20booking/details.php?room_id=1', '2025-02-15 21:02:34'),
(29, '::1', '/wanna%20be%20booking/details.php?room_id=2', '2025-02-15 21:02:45'),
(30, '::1', '/wanna%20be%20booking/details.php?room_id=2', '2025-02-15 21:04:11'),
(31, '::1', '/wanna%20be%20booking/rooms.php', '2025-02-15 21:06:46'),
(32, '::1', '/wanna%20be%20booking/details.php?room_id=1', '2025-02-15 21:06:48'),
(33, '::1', '/wanna%20be%20booking/details.php?room_id=7', '2025-02-15 21:07:11'),
(34, '::1', '/wanna%20be%20booking/index.php', '2025-02-15 21:07:25'),
(35, '::1', '/wanna%20be%20booking/index.php', '2025-02-15 21:21:56'),
(36, '::1', '/wanna%20be%20booking/rooms.php', '2025-02-15 21:22:05'),
(37, '::1', '/wanna%20be%20booking/your_reservations.php', '2025-02-15 21:22:09'),
(38, '::1', '/wanna%20be%20booking/admin_privileges.php', '2025-02-15 21:22:14'),
(39, '::1', '/wanna%20be%20booking/reports.php', '2025-02-15 21:22:16'),
(40, '::1', '/wanna%20be%20booking/analytics.php', '2025-02-15 21:22:20'),
(41, '::1', '/wanna%20be%20booking/modify.php', '2025-02-15 21:22:25'),
(42, '::1', '/wanna%20be%20booking/modify.php?table=reservations', '2025-02-15 21:22:28'),
(43, '::1', '/wanna%20be%20booking/confirm_reservations.php', '2025-02-15 21:22:39'),
(44, '::1', '/wanna%20be%20booking/confirm_reservations.php', '2025-02-15 21:22:44'),
(45, '::1', '/wanna%20be%20booking/confirm_reservations.php', '2025-02-15 21:22:44');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL CHECK (`rating` >= 0 and `rating` <= 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `location`, `description`, `rating`, `created_at`) VALUES
(1, 'Hotel Transilvania', 'Cluj-Napoca, Romania', 'Un hotel modern în inima Transilvaniei', 4.1, '2025-02-15 14:15:52'),
(2, 'Hotel Belvedere', 'Brasov, Romania', 'Un hotel luxos cu o istorie bogată.', 4.8, '2025-02-15 14:15:52'),
(3, 'Ara di Marte', 'Rome, Italy', 'Unul din cele male mai recunoscute hoteluri din capitala Italiei.', 4.9, '2025-02-15 14:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `room_id`, `check_in`, `check_out`, `status`, `created_at`) VALUES
(1, 2, 1, '2025-02-20', '2025-02-22', 'confirmed', '2025-02-15 14:50:36'),
(2, 2, 2, '2025-02-23', '2025-02-25', 'confirmed', '2025-02-15 14:50:36'),
(3, 2, 3, '2025-02-26', '2025-02-28', 'confirmed', '2025-02-15 14:50:36'),
(4, 3, 4, '2025-02-15', '2025-02-18', 'confirmed', '2025-02-15 14:50:36'),
(5, 3, 5, '2025-03-01', '2025-03-05', 'pending', '2025-02-15 14:50:36'),
(6, 3, 6, '2025-03-10', '2025-03-12', 'confirmed', '2025-02-15 14:50:36'),
(7, 2, 7, '2025-03-20', '2025-03-22', 'confirmed', '2025-02-15 14:50:36'),
(8, 2, 8, '2025-04-01', '2025-04-05', 'pending', '2025-02-15 14:50:36'),
(9, 3, 9, '2025-04-10', '2025-04-12', 'confirmed', '2025-02-15 14:50:36'),
(10, 1, 1, '2025-02-04', '2025-02-18', 'cancelled', '2025-02-15 19:07:17'),
(11, 3, 1, '2025-03-27', '2025-03-28', 'pending', '2025-02-15 19:51:02');

--
-- Triggers `reservations`
--
DELIMITER $$
CREATE TRIGGER `before_insert_reservation_date_check` BEFORE INSERT ON `reservations` FOR EACH ROW BEGIN
    -- Verificăm dacă data de check-in este anterioară datei curente
    IF NEW.check_in < CURRENT_DATE THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Data de check-in nu poate fi anterioară datei curente.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `check_dates_before_insert` BEFORE INSERT ON `reservations` FOR EACH ROW BEGIN
    -- Verifică dacă data de check-out este mai mare cu cel puțin 1 zi față de check-in
    IF DATEDIFF(NEW.check_out, NEW.check_in) < 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Check-out date must be at least one day after check-in date';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `check_room_availability` BEFORE INSERT ON `reservations` FOR EACH ROW BEGIN
    -- Verifică dacă există o rezervare confirmată pe aceeași cameră în perioada dorită
    IF EXISTS (
        SELECT 1 
        FROM reservations
        WHERE room_id = NEW.room_id
        AND status = 'confirmed'  -- Verifică doar rezervările confirmate
        AND (
            (NEW.check_in BETWEEN check_in AND check_out) 
            OR (NEW.check_out BETWEEN check_in AND check_out)
            OR (check_in BETWEEN NEW.check_in AND NEW.check_out)
            OR (check_out BETWEEN NEW.check_in AND NEW.check_out)
        )
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'The room is already booked for this period.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `room_type` enum('single','double','suite') NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `hotel_id`, `room_type`, `price`) VALUES
(1, 1, 'single', 240.00),
(2, 1, 'double', 350.00),
(3, 1, 'suite', 550.00),
(4, 2, 'single', 150.00),
(5, 2, 'double', 200.00),
(6, 2, 'suite', 400.00),
(7, 3, 'single', 300.00),
(8, 3, 'double', 450.00),
(9, 3, 'suite', 700.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','client') NOT NULL DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'Martin', '$2y$12$7lUq0KMhkBhihNJ/fuNNlerzN3sTMOp4G9oZSty6eq8FcoXnYcJLe', 'martin.sandro@example.com', 'client', '2025-02-15 14:06:14'),
(2, 'Sara', '$2y$12$sxz39.zqnWYoFYGTabrdZOYEb931R.0S/Pc9dKyXxsgEEPUK7nk2a', 'sara.brown@example.com', 'client', '2025-02-15 14:06:14'),
(3, 'Toma_David_Admin', '$2y$12$AAUALnYxW/0qTo2vc1kkZ.jhtmJas842pzbHIRwNbsuBy27BZuT1e', 'tomadavid2004@yahoo.com', 'admin', '2025-02-15 14:06:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analytics`
--
ALTER TABLE `analytics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analytics`
--
ALTER TABLE `analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
