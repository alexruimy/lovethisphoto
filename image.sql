-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 12, 2014 at 01:31 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ratings`
--

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(128) NOT NULL,
  `votesUp` int(11) NOT NULL,
  `votesDown` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_2` (`file`),
  KEY `file` (`file`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `file`, `votesUp`, `votesDown`) VALUES
(1, '00Y0Y_dO0zz5AcVfj_600x450.jpg', 41, 25),
(2, '0AUPhB1.jpg', 39, 34),
(3, '0F2Sy.jpg', 33, 28),
(4, '0fRz7.jpg', 40, 39),
(5, '0hsql.jpg', 31, 36),
(6, '0MZZP.jpg', 25, 37),
(7, '0oHmG.jpg', 35, 31),
(8, '0Qixm.jpg', 23, 39),
(9, '0WRJb.jpg', 30, 32),
(10, '1hd3y.jpg', 32, 40),
(11, '1ofnU.jpg', 40, 38),
(12, '1P01e.jpg', 42, 30),
(13, '1pFPi.jpg', 30, 29),
(14, 'Otter eats watermen.jpg', 27, 35),
(15, '_63160145_cows.jpg', 32, 28);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
