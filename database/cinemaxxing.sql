-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 08:14 PM
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
(4, 'Weekend in Taipei', NULL, NULL, NULL, 'A former DEA agent and a former undercover operative revisit their romance during a fateful weekend in Taipei, unaware of the dangerous consequences of their past.', 'weekend_in_taipei_wp.jpg', 'weekend_in_taipei_poster.png', '2024', NULL, 5.70, '1h 40m', 1, 0, 'active', '2024-12-10 18:07:21', '2024-12-10 18:49:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
