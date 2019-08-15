-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 15, 2011 at 03:01 PM
-- Server version: 5.1.52
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `verdiste_cloudRealms`
--

-- --------------------------------------------------------

--
-- Table structure for table `battle_logs`
--

CREATE TABLE IF NOT EXISTS `battle_logs` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `unique_code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `enemy1` int(250) NOT NULL,
  `enemy2` int(250) NOT NULL,
  `enemy3` int(250) NOT NULL,
  `enemy4` int(250) NOT NULL,
  `enemy5` int(250) NOT NULL,
  `enemy1_hp` int(250) NOT NULL,
  `enemy2_hp` int(250) NOT NULL,
  `enemy3_hp` int(250) NOT NULL,
  `enemy4_hp` int(250) NOT NULL,
  `enemy5_hp` int(250) NOT NULL,
  `end` int(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_code` (`unique_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `battle_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `bazaar`
--

CREATE TABLE IF NOT EXISTS `bazaar` (
  `id` int(250) NOT NULL,
  `item` int(250) NOT NULL,
  `char` int(250) NOT NULL,
  `sell_value` int(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bazaar`
--


-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(100) NOT NULL,
  `money` int(100) NOT NULL,
  `skill_points` int(250) NOT NULL,
  `exp` int(100) NOT NULL,
  `max_exp` int(250) NOT NULL,
  `max_hp` int(11) NOT NULL,
  `max_mp` int(11) NOT NULL,
  `hp` int(250) NOT NULL,
  `mp` int(250) NOT NULL,
  `tp` int(250) NOT NULL,
  `attack` int(250) NOT NULL,
  `defense` int(250) NOT NULL,
  `age` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `zodiac` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `combat_avatar` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `martial` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `class` int(100) NOT NULL,
  `gender` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `inventoryID` int(100) NOT NULL,
  `userID` int(100) NOT NULL,
  `questPanel` int(100) NOT NULL,
  `home` int(100) NOT NULL,
  `party` int(100) NOT NULL,
  `current_battle` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `current_target` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `row` int(250) NOT NULL,
  `col` int(250) NOT NULL,
  `location` int(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`inventoryID`,`userID`),
  UNIQUE KEY `name_2` (`name`),
  UNIQUE KEY `inventoryID` (`inventoryID`,`userID`,`questPanel`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `characters`
--


-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_name` varchar(64) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `chat`
--


-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `class_desc` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `enemy` int(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `classes`
--


-- --------------------------------------------------------

--
-- Table structure for table `completed_quests`
--

CREATE TABLE IF NOT EXISTS `completed_quests` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `quest_id` int(250) NOT NULL,
  `char_id` int(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `completed_quests`
--


-- --------------------------------------------------------

--
-- Table structure for table `enemy`
--

CREATE TABLE IF NOT EXISTS `enemy` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `bust` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `combat_avatar` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(250) NOT NULL,
  `attack` int(250) NOT NULL,
  `defense` int(250) NOT NULL,
  `hp` int(250) NOT NULL,
  `exp` int(250) NOT NULL,
  `type` int(250) NOT NULL,
  `greeting1` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `greeting2` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `drop1` int(250) NOT NULL,
  `drop2` int(250) NOT NULL,
  `drop3` int(250) NOT NULL,
  `drop4` int(250) NOT NULL,
  `location` int(250) NOT NULL,
  `row` int(250) NOT NULL,
  `col` int(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `enemy`
--


-- --------------------------------------------------------

--
-- Table structure for table `enemy_types`
--

CREATE TABLE IF NOT EXISTS `enemy_types` (
  `id` int(250) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `eclass` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `species` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `edesc` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `emblem` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `enemy_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE IF NOT EXISTS `friendships` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `friend_a` int(13) NOT NULL,
  `friend_b` int(13) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `friendships`
--


-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `expansion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `canvas_width` int(150) NOT NULL,
  `canvas_height` int(150) NOT NULL,
  `tile_width` int(250) NOT NULL,
  `tile_height` int(250) NOT NULL,
  `fullscreen` int(250) NOT NULL,
  `mp3_theme` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `ogg_theme` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `game`
--


-- --------------------------------------------------------

--
-- Table structure for table `homes`
--

CREATE TABLE IF NOT EXISTS `homes` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `background` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `bgcolor` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `charID` int(200) NOT NULL,
  `setup` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `homes`
--


-- --------------------------------------------------------

--
-- Table structure for table `im`
--

CREATE TABLE IF NOT EXISTS `im` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `to` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `im`
--


-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `char_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slot0` int(250) NOT NULL,
  `slot1` int(100) NOT NULL,
  `slot2` int(100) NOT NULL,
  `slot3` int(100) NOT NULL,
  `slot4` int(100) NOT NULL,
  `slot5` int(100) NOT NULL,
  `slot6` int(100) NOT NULL,
  `slot7` int(100) NOT NULL,
  `slot8` int(100) NOT NULL,
  `slot9` int(100) NOT NULL,
  `slot10` int(100) NOT NULL,
  `slot11` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `char` (`char_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `inventory`
--


-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mp` int(11) NOT NULL,
  `hp` int(11) NOT NULL,
  `tp` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `spell` int(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `items`
--


-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `north` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `south` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `east` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `west` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `default_tile_color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `background` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `mp3` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `ogg` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `battle_mp3` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `battle_ogg` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `locations`
--


-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `unique_code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(64) DEFAULT NULL,
  `message` text,
  `post_time` datetime DEFAULT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `message`
--


-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `message` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `message_type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `user` int(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `notifications`
--


-- --------------------------------------------------------

--
-- Table structure for table `npc`
--

CREATE TABLE IF NOT EXISTS `npc` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `bust` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(250) NOT NULL,
  `greeting1` varchar(260) COLLATE utf8_unicode_ci NOT NULL,
  `greeting2` varchar(260) COLLATE utf8_unicode_ci NOT NULL,
  `greeting3` varchar(260) COLLATE utf8_unicode_ci NOT NULL,
  `location` int(11) NOT NULL,
  `col` int(250) NOT NULL,
  `row` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `npc`
--


-- --------------------------------------------------------

--
-- Table structure for table `objects`
--

CREATE TABLE IF NOT EXISTS `objects` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `location` int(250) NOT NULL,
  `row` int(250) NOT NULL,
  `col` int(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `objects`
--


-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE IF NOT EXISTS `party` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `leader` int(250) NOT NULL,
  `member1` int(250) NOT NULL,
  `member2` int(250) NOT NULL,
  `member3` int(250) NOT NULL,
  `member4` int(250) NOT NULL,
  `party_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `battleid` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `party`
--


-- --------------------------------------------------------

--
-- Table structure for table `pm`
--

CREATE TABLE IF NOT EXISTS `pm` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `pmto` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `pmfrom` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `pmsubject` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pm`
--


-- --------------------------------------------------------

--
-- Table structure for table `quests`
--

CREATE TABLE IF NOT EXISTS `quests` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `quest_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `info` varchar(260) COLLATE utf8_unicode_ci NOT NULL,
  `npc1` int(100) NOT NULL,
  `npc2` int(100) NOT NULL,
  `npc3` int(100) NOT NULL,
  `npc4` int(100) NOT NULL,
  `npc5` int(100) NOT NULL,
  `loc1` int(100) NOT NULL,
  `loc2` int(100) NOT NULL,
  `loc3` int(100) NOT NULL,
  `loc4` int(100) NOT NULL,
  `loc5` int(100) NOT NULL,
  `condition1` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `condition2` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `condition3` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `condition4` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `condition5` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `scene1` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `scene2` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `scene3` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `scene4` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `scene5` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `reward1` int(100) NOT NULL,
  `reward2` int(100) NOT NULL,
  `reward3` int(100) NOT NULL,
  `reward4` int(100) NOT NULL,
  `reward5` int(100) NOT NULL,
  `exp` int(100) NOT NULL,
  `level_required` int(150) NOT NULL,
  `quest_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `party` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `complex1` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `complex2` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `complex3` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `complex4` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `completion_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `end_condition` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `quests`
--


-- --------------------------------------------------------

--
-- Table structure for table `quest_panel`
--

CREATE TABLE IF NOT EXISTS `quest_panel` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `activeQuest` int(100) NOT NULL,
  `quest2` int(100) NOT NULL,
  `quest3` int(100) NOT NULL,
  `quest4` int(100) NOT NULL,
  `completion1` int(100) NOT NULL,
  `completion2` int(100) NOT NULL,
  `completion3` int(100) NOT NULL,
  `completion4` int(100) NOT NULL,
  `completion5` int(100) NOT NULL,
  `charID` int(100) NOT NULL,
  `start_time` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `quest_panel`
--


-- --------------------------------------------------------

--
-- Table structure for table `relationships`
--

CREATE TABLE IF NOT EXISTS `relationships` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `partner_a` int(14) NOT NULL,
  `partner_b` int(14) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `relationships`
--


-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_to` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `request_from` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `request_type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `requests`
--


-- --------------------------------------------------------

--
-- Table structure for table `scrolls`
--

CREATE TABLE IF NOT EXISTS `scrolls` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `mp_cost` int(11) NOT NULL,
  `dmg` int(250) NOT NULL,
  `type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `affect` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `plus` int(250) NOT NULL,
  `class1` int(250) NOT NULL,
  `class2` int(250) NOT NULL,
  `class3` int(250) NOT NULL,
  `level` int(250) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `scrolls`
--


-- --------------------------------------------------------

--
-- Table structure for table `scroll_types`
--

CREATE TABLE IF NOT EXISTS `scroll_types` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `scroll_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE IF NOT EXISTS `shop` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `npc` int(15) NOT NULL,
  `location` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `shop`
--


-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `points` int(250) NOT NULL,
  `charid` int(250) NOT NULL,
  `skill` int(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `skills`
--


-- --------------------------------------------------------

--
-- Table structure for table `skill_sets`
--

CREATE TABLE IF NOT EXISTS `skill_sets` (
  `id` int(240) NOT NULL AUTO_INCREMENT,
  `name` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `skill_sets`
--


-- --------------------------------------------------------

--
-- Table structure for table `spells`
--

CREATE TABLE IF NOT EXISTS `spells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scroll` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `spells`
--


-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `user` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `statuses`
--


-- --------------------------------------------------------

--
-- Table structure for table `tiles`
--

CREATE TABLE IF NOT EXISTS `tiles` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `bg` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `row` int(250) NOT NULL,
  `col` int(250) NOT NULL,
  `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `portal` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tiles`
--


-- --------------------------------------------------------

--
-- Table structure for table `trading_queue`
--

CREATE TABLE IF NOT EXISTS `trading_queue` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `tradeid` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `itemid` int(111) NOT NULL,
  `slot` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `trading_queue`
--


-- --------------------------------------------------------

--
-- Table structure for table `useronline`
--

CREATE TABLE IF NOT EXISTS `useronline` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `useronline`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `blurb` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `characterID` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`,`characterID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--

