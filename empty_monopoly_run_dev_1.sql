-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 01, 2020 at 09:53 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monopoly_run`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `points_deduct` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `spaces`
--

DROP TABLE IF EXISTS `spaces`;
CREATE TABLE IF NOT EXISTS `spaces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `colour` varchar(15) NOT NULL,
  `value` int(11) NOT NULL,
  `question` text NOT NULL,
  `q_bonus` int(11) NOT NULL,
  `correct_ans` text NOT NULL,
  `lat` double(8,6) NOT NULL,
  `lng` double(8,6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `colour` (`colour`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `space_colours`
--

DROP TABLE IF EXISTS `space_colours`;
CREATE TABLE IF NOT EXISTS `space_colours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `colour` varchar(15) NOT NULL,
  `set_bonus` int(11) NOT NULL,
  `set_spaces` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `colour` (`colour`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `space_colours`
--

INSERT INTO `space_colours` (`id`, `colour`, `set_bonus`, `set_spaces`) VALUES
(1, 'brown', 0, 2),
(2, 'light-blue', 0, 3),
(3, 'pink', 0, 3),
(4, 'orange', 0, 3),
(5, 'red', 0, 3),
(6, 'yellow', 0, 3),
(7, 'green', 0, 3),
(8, 'blue', 0, 2),
(9, 'chance', 0, 3),
(10, 'chest', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `group_name` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `answer` text NOT NULL,
  `img_name` varchar(255) NOT NULL,
  `checked` int(11) NOT NULL DEFAULT '0',
  `question_correct` tinyint(1) NOT NULL DEFAULT '0',
  `comment` varchar(255) DEFAULT 'No Comment',
  PRIMARY KEY (`id`),
  KEY `group_name` (`group_name`),
  KEY `location` (`location`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `confirmed_user` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `spaces`
--
ALTER TABLE `spaces`
  ADD CONSTRAINT `spaces_ibfk_1` FOREIGN KEY (`colour`) REFERENCES `space_colours` (`colour`);

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`group_name`) REFERENCES `groups` (`group_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uploads_ibfk_2` FOREIGN KEY (`location`) REFERENCES `spaces` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
