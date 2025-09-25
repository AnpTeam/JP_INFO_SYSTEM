-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2025 at 08:11 AM
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
-- Database: `jp_info_system`
--
CREATE DATABASE IF NOT EXISTS `jp_info_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `jp_info_system`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attraction`
--

CREATE TABLE `tbl_attraction` (
  `attr_id` int(11) NOT NULL,
  `attr_name` varchar(100) NOT NULL,
  `attr_thumbnail` varchar(200) NOT NULL,
  `attr_desc` varchar(300) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `like_count` int(11) NOT NULL DEFAULT 0,
  `city_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`) VALUES
(7, 'Architectural Attractions'),
(2, 'Cultural Attractions'),
(10, 'Events & Festivals'),
(9, 'Food & Culinary Attractions'),
(1, 'Historical Sites'),
(4, 'Modern Attractions'),
(3, 'Natural Attractions'),
(8, 'Outdoor & Adventure Activities'),
(6, 'Religious Sites'),
(5, 'Theme Parks & Amusement Parks');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `region_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`city_id`, `city_name`, `region_id`) VALUES
(1, 'Sapporo', 7),
(2, 'Sendai', 8),
(3, 'Tokyo', 6),
(4, 'Yokohama', 6),
(5, 'Saitama', 6),
(6, 'Nagoya', 3),
(7, 'Osaka', 1),
(8, 'Kyoto', 1),
(9, 'Kobe', 1),
(10, 'Hiroshima', 4),
(11, 'Fukuoka', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_desc` varchar(300) NOT NULL,
  `attr_id` int(11) NOT NULL,
  `like_count` int(11) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_counter`
--

CREATE TABLE `tbl_counter` (
  `c_id` int(10) NOT NULL,
  `attr_id` int(11) NOT NULL,
  `c_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_region`
--

CREATE TABLE `tbl_region` (
  `region_id` int(11) NOT NULL,
  `region_name` varchar(100) NOT NULL,
  `region_desc` text NOT NULL,
  `region_thumbnail` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_region`
--

INSERT INTO `tbl_region` (`region_id`, `region_name`, `region_desc`, `region_thumbnail`) VALUES
(1, 'Kansai', 'Kansai is a region in Japan known for its rich culture, historic cities like Kyoto, Osaka, and Nara, vibrant food scene, and iconic landmarks such as Osaka Castle and the temples of Kyoto. It blends tradition and modern life.\r\n', 'uploads/region/gbI98ZNoT5zAQFJOm0UDi6fMIHmuuGdcrbtdhBDR.jpg'),
(2, 'Kyushu', 'Kyushu is Japan’s southernmost main island, known for its active volcanoes, hot springs (like Beppu), rich history, and vibrant cities such as Fukuoka, Nagasaki, and Kumamoto. It offers natural beauty, unique cuisine, and deep cultural heritage.\r\n', 'uploads/region/ksaSPl5drWeHCP7pQrfhR6wE3UqsDwoNRI6BLGv5.jpg'),
(3, 'Chubu', 'Chubu is a central region of Japan, home to diverse landscapes from the Japan Alps to coastal areas. It includes cities like Nagoya and Kanazawa, and attractions like Mt. Fuji, historic towns, and traditional crafts. It blends nature, culture, and industry.', 'uploads/region/onHiISVfUhX38Ho4NFGsINFGYKyNnT1OOYibmiiT.jpg'),
(4, 'Chugoku', 'Chugoku is a western region of Japan’s main island, Honshu, known for its scenic beauty, historic sites like Hiroshima and the Itsukushima Shrine, and cultural heritage. It offers quiet countryside, coastal towns, and deep historical significance.\r\n', 'uploads/region/FXeqTmlCcE4VecgxpRTdr3xwkps9oClrEbyWyj9S.jpg'),
(5, 'Shikoku', 'Shikoku is Japan’s smallest main island, known for its 88-temple pilgrimage, beautiful nature, traditional villages, and cultural festivals. It features serene mountains, rivers, and historic cities like Matsuyama and Takamatsu. Peaceful and rich in tradition.\r\n', 'uploads/region/u0J4XRDDqGlT9KJIRfN7Kn0JJbcvR7UtXQU5XhQC.jpg'),
(6, 'Kanto', 'Kanto is Japan’s political and economic center, home to Tokyo and Yokohama. It blends modern cityscapes with cultural sites like temples in Kamakura and Nikko. A dynamic region offering technology, tradition, and vibrant urban life.\r\n', 'uploads/region/2LuAhtts74jwN38F5oemiIzUrJhv1hsktxFpyQZl.jpg'),
(7, 'Hokkaido', 'Hokkaido is Japan’s northernmost island, known for its stunning natural landscapes, ski resorts, hot springs, and seafood. It features vast wilderness, national parks, and seasonal beauty—especially in winter and during summer flower blooms.\r\n', 'uploads/region/GVcnPwiHV1rj85Rr4MjtLPQgO9b8GNaSZ7ikmPP7.jpg'),
(8, 'Tohoku', 'Tohoku is a northeastern region of Japan known for its rugged natural beauty, hot springs, historic castles, and seasonal festivals. It offers serene mountains, rural charm, and rich cultural heritage, with cities like Sendai and scenic spots like Lake Towada.\r\n', 'uploads/region/SHHtSfGzw7UZfGt2HcVTiSYzJnA1V9KvlHaYhTYL.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(10) NOT NULL,
  `user_role` set('user','admin') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_password`, `user_email`, `user_phone`, `user_role`, `date_created`) VALUES
(1, 'PTeam', '$2y$12$oNlCYjPh/lqVeoY0M8Qjh./pVa1ZDkGvz7kQW3F3Wv5Z6hiluI9i.', 'sadasd@1', '4444444444', 'admin', '2025-09-16 17:39:49'),
(2, 'Anupap', '$2y$12$ENRkQoomYQEqjCB/p5FmaeIj.nx2RPUMUOA6CiWH646vFhUKRxsqa', 'Anupap@gmail.com', '4444444444', 'admin', '2025-09-16 17:40:34'),
(3, 'PTeamTissue', '$2y$12$Z.1MVd4XV3k6VUtjI6lLVuc.EsBFjZ63Tk55InSxnwNy5QYG6h6SS', 'KFC@1', '4444444444', 'user', '2025-09-16 17:41:21'),
(4, 'Kusu', '$2y$12$yd/YswThdGKuHCA/cGpGweVNrTKH7rr30vKjw497Zg5S/KUS65C8y', 'Kusu@1', '4444444444', 'admin', '2025-09-16 17:41:51'),
(5, 'ตอกกวาง', '$2y$12$bDWvwiU1AT0LcWiJqFboTeL8LMpNTWXPR319H9VVCiKq83n3SB2Wi', 'Team@1', '4444444444', 'user', '2025-09-16 17:42:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attraction`
--
ALTER TABLE `tbl_attraction`
  ADD PRIMARY KEY (`attr_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`city_id`),
  ADD UNIQUE KEY `city_name` (`city_name`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `tbl_counter`
--
ALTER TABLE `tbl_counter`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `tbl_region`
--
ALTER TABLE `tbl_region`
  ADD PRIMARY KEY (`region_id`),
  ADD UNIQUE KEY `region_name` (`region_name`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_password` (`user_password`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attraction`
--
ALTER TABLE `tbl_attraction`
  MODIFY `attr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_counter`
--
ALTER TABLE `tbl_counter`
  MODIFY `c_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_region`
--
ALTER TABLE `tbl_region`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
