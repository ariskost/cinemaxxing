-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 09:32 PM
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
-- Database: `cinemaxxing`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `age_restriction_limit` varchar(255) DEFAULT NULL,
  `category` text DEFAULT NULL,
  `room` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `img_wallpaper` text DEFAULT NULL,
  `img_poster` text DEFAULT NULL COMMENT 'Squared , Ratio 1:1',
  `release_year` varchar(255) DEFAULT NULL,
  `price_per_unit` decimal(10,2) DEFAULT NULL,
  `imdb_rating` decimal(10,2) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `is_featured` int(11) DEFAULT 0,
  `is_trending` int(11) DEFAULT 0,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `name`, `age_restriction_limit`, `category`, `room`, `description`, `img_wallpaper`, `img_poster`, `release_year`, `price_per_unit`, `imdb_rating`, `duration`, `is_featured`, `is_trending`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Deadpool & Wolvering', NULL, NULL, NULL, 'Deadpool is offered a place in the Marvel Cinematic Universe by the Time Variance Authority, but instead recruits a variant of Wolverine to save his universe from extinction.', 'dw_wp.webp', 'dw_poster.png', '2024', NULL, 7.70, '2h 08m', 1, 0, 'active', '2024-12-10 18:04:37', '2024-12-10 18:48:57'),
(2, 'Gladiator II', NULL, NULL, NULL, 'After his home is conquered by the tyrannical emperors who now lead Rome, Lucius is forced to enter the Colosseum and must look to his past to find strength to return the glory of Rome to its people.', 'gladiator_2_wp.webp', 'gladiator_2_poster.jpg', '2024', NULL, 6.90, '2h 28m', 1, 0, 'active', '2024-12-10 18:04:37', '2024-12-10 18:49:06'),
(3, 'Heretic', NULL, NULL, NULL, 'Two young religious women are drawn into a game of cat-and-mouse in the house of a strange man.', 'heretic_wp.jpg', 'heretic_poster.png', '2024', NULL, 7.20, '1h 51m', 1, 0, 'active', '2024-12-10 18:07:21', '2024-12-10 18:49:10'),
(4, 'Weekend in Taipei', NULL, NULL, NULL, 'A former DEA agent and a former undercover operative revisit their romance during a fateful weekend in Taipei, unaware of the dangerous consequences of their past.', 'weekend_in_taipei_wp.jpg', 'weekend_in_taipei_poster.png', '2024', NULL, 5.70, '1h 40m', 1, 0, 'active', '2024-12-10 18:07:21', '2024-12-10 18:49:22'),
(5, 'The Best Christmas Pageant Ever', NULL, NULL, NULL, 'Nobody is ready for the mayhem and surprises that ensue when six of the worst youngsters disrupt the town\'s yearly Christmas performance.', 'christmas-pageant.png', 'the-best-christmas-pageant-ever-button-1719830934212.jpg', '2024', NULL, NULL, NULL, 0, 0, 'active', '2024-12-15 16:30:54', '2024-12-15 16:30:54'),
(6, 'The Polar Express', NULL, NULL, NULL, 'On Christmas Eve, a young boy embarks on a magical adventure to the North Pole on the Polar Express, while learning about friendship, bravery, and the spirit of Christmas.', 'polar_express_wp.jpg', 'polar_express_poster.png', '2004', NULL, NULL, NULL, 0, 0, 'active', '2024-12-15 16:36:00', '2024-12-15 16:36:00'),
(7, 'Tarot', NULL, NULL, NULL, 'When a group of friends recklessly violates the sacred rule of Tarot readings, they unknowingly unleash an unspeakable evil trapped within the cursed cards. One by one, they come face to face with fate and end up in a race against death.', 'tarot_wp.jpg', 'tarot_poster.png', '2024', NULL, NULL, NULL, 0, 0, 'active', '2024-12-15 18:11:21', '2024-12-15 18:11:21'),
(8, 'Alien: Romulus', NULL, NULL, NULL, 'While scavenging the deep ends of a derelict space station, a group of young space colonists come face to face with the most terrifying life form in the universe.', 'alien_romulus_wp.png', 'alien_romulus_poster.png', '2024', NULL, NULL, NULL, 0, 0, 'active', '2024-12-15 18:16:23', '2024-12-15 18:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `movie_room`
--

CREATE TABLE `movie_room` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movie_room`
--

INSERT INTO `movie_room` (`id`, `movie_id`, `room_id`) VALUES
(1, 3, 4),
(2, 7, 4),
(3, 8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `number_of_seats` int(11) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `user_id`, `room_id`, `movie_id`, `number_of_seats`, `timezone`, `total_amount`, `status`, `created_at`) VALUES
(1, 2, 4, 3, 2, '21', 16.00, 'pending', '2024-12-15 19:17:36'),
(2, 2, 4, 3, 2, '0', 16.00, 'rejected', '2024-12-15 19:19:11'),
(3, 2, 4, 3, 2, '3', 16.00, 'approved', '2024-12-15 19:23:21'),
(4, 2, 4, 3, 2, '21', 16.00, 'pending', '2024-12-15 19:38:56'),
(5, 2, 4, 3, 2, '0', 16.00, 'pending', '2024-12-15 19:41:34'),
(6, 2, 4, 3, 2, '0', 16.00, 'pending', '2024-12-15 19:43:26'),
(7, 2, 4, 3, 2, '0', 16.00, 'pending', '2024-12-15 19:49:31'),
(8, 2, 4, 3, 2, '0', 16.00, 'pending', '2024-12-15 19:50:30'),
(9, 2, 4, 3, 2, '21', 16.00, 'pending', '2024-12-15 19:52:31'),
(10, 2, 4, 7, 2, '21', 16.00, 'pending', '2024-12-15 19:54:28'),
(11, 2, 4, 7, 2, '21', 16.00, 'pending', '2024-12-15 19:57:17'),
(12, 2, 4, 7, 2, '21', 16.00, 'pending', '2024-12-15 19:59:04'),
(13, 2, 4, 7, 2, '21', 16.00, 'pending', '2024-12-15 20:00:51'),
(14, 2, 4, 7, 3, '21', 24.00, 'pending', '2024-12-15 20:01:37'),
(15, 2, 4, 7, 2, '21:00-23:45', 16.00, 'pending', '2024-12-15 20:03:00'),
(16, 2, 4, 8, 2, '21:00-23:45', 16.00, 'pending', '2024-12-15 20:11:39'),
(17, 2, 4, 8, 2, '21:00-23:45', 16.00, 'pending', '2024-12-15 20:12:20'),
(18, 2, 4, 8, 3, '03:30-06:15', 24.00, 'pending', '2024-12-15 20:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `seats` int(11) DEFAULT NULL,
  `timezone` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`timezone`)),
  `price_per_seat` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `seats`, `timezone`, `price_per_seat`) VALUES
(1, 'Room A', 50, '[\"09:00-11:45\", \"12:30-14:15\", \"15:00-17:45\"]', 7.00),
(2, 'Room B', 75, '[\"10:00-12:45\", \"13:30-15:15\", \"16:00-18:45\"]', 9.00),
(3, 'Comfort', 30, '[\"09:00-11:30\", \"12:00-14:00\", \"15:00-17:00\"]', 13.50),
(4, 'Horror', 40, '[\"21:00-23:45\",\"00:15-03:00\",\"03:30-06:15\"]', 8.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `username`, `email`, `age`, `type`, `password`, `created_at`, `updated_at`) VALUES
(1, 'aris kostidis', 'ariskost', 'aristeidis.kostidis@gmail.com', 29, 'client', '$2y$10$GuDuLYRsBdYtntcqcurTiefFI3tHu/.nMN5adEnq9521q30c2Loqi', '2024-12-12 20:15:26', '2024-12-12 20:15:26'),
(2, 'Aristeidis Kostidis', 'admin', 'aristeidis.kostidis@gmail.com', 29, 'employee', '$2y$10$iqN7N.Z4QUGcYnSr1x0VBOoZoO2YM5Jg2jIFXuLs1.aY.IV68RH0C', '2024-12-15 11:49:39', '2024-12-15 11:49:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_room`
--
ALTER TABLE `movie_room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `movie_room`
--
ALTER TABLE `movie_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movie_room`
--
ALTER TABLE `movie_room`
  ADD CONSTRAINT `movie_room_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_room_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
