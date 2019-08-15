-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2013 at 05:21 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `devana`
--
CREATE DATABASE IF NOT EXISTS `devana` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `devana`;

-- --------------------------------------------------------

--
-- Table structure for table `activations`
--

CREATE TABLE IF NOT EXISTS `activations` (
  `user` int(10) unsigned NOT NULL,
  `code` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `alliances`
--

CREATE TABLE IF NOT EXISTS `alliances` (
  `id` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `blacklist`
--

CREATE TABLE IF NOT EXISTS `blacklist` (
  `type` varchar(16) COLLATE utf8_bin NOT NULL,
  `value` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`type`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `blocklist`
--

CREATE TABLE IF NOT EXISTS `blocklist` (
  `recipient` int(10) unsigned NOT NULL,
  `sender` int(10) unsigned NOT NULL,
  PRIMARY KEY (`recipient`,`sender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `build`
--

CREATE TABLE IF NOT EXISTS `build` (
  `node` int(10) unsigned NOT NULL,
  `slot` int(10) unsigned NOT NULL,
  `module` int(10) unsigned NOT NULL,
  `start` datetime NOT NULL,
  `duration` float unsigned NOT NULL,
  PRIMARY KEY (`node`,`slot`),
  KEY `start` (`start`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `combat`
--

CREATE TABLE IF NOT EXISTS `combat` (
  `id` int(10) unsigned NOT NULL,
  `sender` int(10) unsigned NOT NULL,
  `recipient` int(10) unsigned NOT NULL,
  `focus` varchar(16) COLLATE utf8_bin NOT NULL,
  `stage` tinyint(3) unsigned NOT NULL,
  `start` datetime NOT NULL,
  `duration` float unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `start` (`start`),
  KEY `sender` (`sender`,`stage`),
  KEY `recipient` (`recipient`,`stage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `combat_units`
--

CREATE TABLE IF NOT EXISTS `combat_units` (
  `combat` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`combat`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE IF NOT EXISTS `components` (
  `node` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`node`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `craft`
--

CREATE TABLE IF NOT EXISTS `craft` (
  `id` int(10) unsigned NOT NULL,
  `node` int(10) unsigned NOT NULL,
  `component` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `stage` tinyint(3) unsigned NOT NULL,
  `start` datetime NOT NULL,
  `duration` float unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `start` (`start`),
  KEY `nodeComponent` (`node`,`component`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `flags`
--

CREATE TABLE IF NOT EXISTS `flags` (
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  `value` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `flags`
--

INSERT INTO `flags` (`name`, `value`) VALUES
('activation', '0'),
('build', '1'),
('combat', '1'),
('craft', '1'),
('login', '1'),
('messages', '1'),
('register', '1'),
('research', '1'),
('trade', '1'),
('train', '1');

-- --------------------------------------------------------

--
-- Table structure for table `free_ids`
--

CREATE TABLE IF NOT EXISTS `free_ids` (
  `id` int(10) unsigned NOT NULL,
  `type` varchar(16) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `grid`
--

CREATE TABLE IF NOT EXISTS `grid` (
  `x` int(10) unsigned NOT NULL,
  `y` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`x`,`y`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

CREATE TABLE IF NOT EXISTS `invitations` (
  `alliance` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  PRIMARY KEY (`alliance`,`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL,
  `sender` int(10) unsigned NOT NULL,
  `recipient` int(10) unsigned NOT NULL,
  `subject` varchar(64) COLLATE utf8_bin NOT NULL,
  `body` text COLLATE utf8_bin NOT NULL,
  `sent` datetime NOT NULL,
  `viewed` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`),
  KEY `recipient` (`recipient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `node` int(10) unsigned NOT NULL,
  `slot` int(10) unsigned NOT NULL,
  `module` int(10) NOT NULL,
  `input` int(10) unsigned NOT NULL,
  PRIMARY KEY (`node`,`slot`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `id` int(10) unsigned NOT NULL,
  `faction` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  `focus` varchar(16) COLLATE utf8_bin NOT NULL,
  `lastCheck` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `user` int(10) unsigned NOT NULL,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  `value` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`user`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `research`
--

CREATE TABLE IF NOT EXISTS `research` (
  `node` int(10) unsigned NOT NULL,
  `technology` int(10) unsigned NOT NULL,
  `start` datetime NOT NULL,
  `duration` float unsigned NOT NULL,
  PRIMARY KEY (`node`,`technology`),
  KEY `start` (`start`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `node` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `value` float unsigned NOT NULL,
  PRIMARY KEY (`node`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `technologies`
--

CREATE TABLE IF NOT EXISTS `technologies` (
  `node` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`node`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `trade`
--

CREATE TABLE IF NOT EXISTS `trade` (
  `id` int(10) unsigned NOT NULL,
  `distance` int(10) unsigned NOT NULL,
  `node` int(10) unsigned NOT NULL,
  `seller` int(10) unsigned NOT NULL,
  `sellIdentifier` int(10) unsigned NOT NULL,
  `sellQuantity` int(10) unsigned NOT NULL,
  `buyer` int(10) unsigned NOT NULL,
  `buyIdentifier` int(10) unsigned NOT NULL,
  `buyQuantity` int(10) unsigned NOT NULL,
  `start` datetime NOT NULL,
  `duration` float unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sell` (`sellIdentifier`),
  UNIQUE KEY `buy` (`buyIdentifier`),
  KEY `node` (`node`),
  KEY `start` (`start`),
  KEY `seller` (`seller`),
  KEY `buyer` (`buyer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `train`
--

CREATE TABLE IF NOT EXISTS `train` (
  `id` int(10) unsigned NOT NULL,
  `node` int(10) unsigned NOT NULL,
  `unit` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `stage` tinyint(3) unsigned NOT NULL,
  `start` datetime NOT NULL,
  `duration` float unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `start` (`start`),
  KEY `nodeUnit` (`node`,`unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE IF NOT EXISTS `units` (
  `node` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`node`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` varchar(128) COLLATE utf8_bin NOT NULL,
  `email` varchar(32) COLLATE utf8_bin NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  `joined` date NOT NULL,
  `lastVisit` datetime NOT NULL,
  `ip` varchar(23) COLLATE utf8_bin NOT NULL,
  `alliance` int(10) unsigned NOT NULL,
  `template` varchar(32) COLLATE utf8_bin NOT NULL,
  `locale` varchar(32) COLLATE utf8_bin NOT NULL,
  `sitter` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `wars`
--

CREATE TABLE IF NOT EXISTS `wars` (
  `type` tinyint(3) unsigned NOT NULL,
  `sender` int(10) unsigned NOT NULL,
  `recipient` int(10) unsigned NOT NULL,
  PRIMARY KEY (`type`,`sender`,`recipient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
