-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for 2page
DROP DATABASE IF EXISTS `2page`;
CREATE DATABASE IF NOT EXISTS `2page` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `2page`;

-- Dumping structure for table 2page.click
DROP TABLE IF EXISTS `click`;
CREATE TABLE IF NOT EXISTS `click` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link_id` int(11) NOT NULL,
  `click_date` date NOT NULL,
  `is_real` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table 2page.click: ~34 rows (approximately)
/*!40000 ALTER TABLE `click` DISABLE KEYS */;
REPLACE INTO `click` (`id`, `link_id`, `click_date`, `is_real`) VALUES
	(1, 1, '2019-11-18', 0),
	(2, 2, '2020-02-05', 1),
	(3, 3, '2020-02-07', 1),
	(4, 4, '2020-01-30', 0),
	(5, 5, '2020-02-07', 0),
	(6, 6, '2020-02-07', 0),
	(7, 4, '2020-01-26', 1),
	(8, 5, '2020-02-07', 1),
	(9, 7, '2020-02-07', 1),
	(10, 1, '2020-01-31', 1),
	(11, 1, '2019-02-10', 1),
	(12, 5, '2020-02-07', 1),
	(13, 7, '2020-02-07', 1),
	(14, 5, '2020-02-07', 1),
	(15, 1, '2020-02-07', 1),
	(16, 4, '2020-02-07', 1),
	(17, 4, '2020-01-23', 1),
	(18, 1, '2020-02-01', 0),
	(19, 5, '2020-02-07', 0),
	(20, 3, '2020-02-07', 0),
	(21, 6, '2020-02-07', 0),
	(22, 1, '2020-02-03', 0),
	(23, 1, '2020-02-07', 0),
	(24, 1, '2020-02-07', 0),
	(25, 1, '2020-02-07', 0),
	(26, 4, '2020-02-07', 0),
	(27, 4, '2020-02-07', 0),
	(28, 8, '2020-02-07', 0),
	(29, 8, '2020-02-07', 0),
	(30, 8, '2020-02-07', 0),
	(31, 8, '2020-02-07', 0),
	(32, 2, '2020-02-07', 0),
	(33, 9, '2020-02-07', 0),
	(34, 10, '2020-02-07', 0),
	(48, 9, '2020-02-07', 1),
	(49, 9, '2020-02-07', 1),
	(50, 10, '2020-02-08', 0),
	(51, 8, '2020-02-08', 0);
/*!40000 ALTER TABLE `click` ENABLE KEYS */;

-- Dumping structure for table 2page.link
DROP TABLE IF EXISTS `link`;
CREATE TABLE IF NOT EXISTS `link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` varchar(255) NOT NULL,
  `real_link` varchar(255) NOT NULL,
  `filter_link` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table 2page.link: ~10 rows (approximately)
/*!40000 ALTER TABLE `link` DISABLE KEYS */;
REPLACE INTO `link` (`id`, `campaign_id`, `real_link`, `filter_link`, `state`) VALUES
	(1, 'tiger', 'https://dummy-link.com', 'https://dummy-link.com', 'green'),
	(2, 'lion', 'https://dummy-link.com', 'https://dummy-link.com', 'red'),
	(3, 'monkey', 'https://dummy-link.com', 'https://dummy-link.com', 'yellow'),
	(4, 'elephant', 'https://dummy-link.com', 'https://dummy-link.com', 'green'),
	(5, 'tiger', 'https://dummy-real-link.com', 'https://dummy-filtered-link.com', 'yello'),
	(6, 'monkey', 'https://monkey-link.com', 'https://monkey-filtered-link.com', 'green'),
	(7, 'tiger', 'https://www.tiger-link.com', 'https://www.tiger-link.com', 'green'),
	(8, 'elephant', 'https://www.elephant-link.com', 'https://www.elephant-link.com', 'green'),
	(9, 'lion', 'http://localhost', 'http://localhost', 'green'),
	(10, 'elephant', 'https://www.google.com', 'https://www.google.com', 'green');
/*!40000 ALTER TABLE `link` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
