-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2025 at 08:00 AM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_region`
--
ALTER TABLE `tbl_region`
  ADD PRIMARY KEY (`region_id`),
  ADD UNIQUE KEY `region_name` (`region_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_region`
--
ALTER TABLE `tbl_region`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
