CREATE TABLE `%PREFIX%ally` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `desc` longtext COLLATE utf8_unicode_ci NOT NULL,
  `invite_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'You are invited in [ally_name]',
  `owner` int(10) unsigned NOT NULL DEFAULT '0',
  `acess` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 user can join ally, 1 user can make request, 2 only admin sends request',
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%ally_pact` (
  `ally1` int(5) unsigned NOT NULL,
  `ally2` int(5) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0 WAR, 1 NAP, 2 ALLY',
  `status` tinyint(1) NOT NULL COMMENT '0 waiting, 1 confirmed',
  KEY `ally1` (`ally1`),
  KEY `ally2` (`ally2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%banlist` (
  `usrid` int(11) unsigned NOT NULL,
  `timeout` int(11) NOT NULL COMMENT '-1 = forever',
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`usrid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usrid` int(10) unsigned NOT NULL DEFAULT '0',
  `msg` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sent_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usrid` (`usrid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%city` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `owner` int(15) unsigned NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `last_update` int(20) NOT NULL,
  `x` int(15) unsigned NOT NULL DEFAULT '0',
  `y` int(15) unsigned NOT NULL DEFAULT '0',
  `z` int(15) unsigned NOT NULL DEFAULT '0',
  `img` varchar(35) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null.gif',
  PRIMARY KEY (`id`),
  UNIQUE KEY `x` (`x`,`y`,`z`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%city_builds` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `city` int(15) unsigned NOT NULL,
  `build` int(10) unsigned NOT NULL,
  `lev` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city` (`city`,`build`),
  KEY `city_2` (`city`),
  KEY `build` (`build`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%city_build_que` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `city` int(15) unsigned NOT NULL DEFAULT '0',
  `build` int(5) unsigned NOT NULL,
  `end` int(20) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `build` (`build`),
  KEY `city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%city_research_que` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `city` int(15) unsigned NOT NULL,
  `res_id` int(10) unsigned NOT NULL,
  `end` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `res_id` (`res_id`),
  KEY `city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%city_resources` (
  `city_id` int(11) unsigned NOT NULL,
  `res_id` smallint(3) unsigned NOT NULL,
  `res_quantity` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`city_id`,`res_id`),
  KEY `res_id` (`res_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%conf` (
  `news1` longtext COLLATE utf8_unicode_ci,
  `rulers` longtext COLLATE utf8_unicode_ci,
  `server_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sgex',
  `server_desc_sub` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'sgex',
  `server_desc_main` text COLLATE utf8_unicode_ci,
  `template` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sgex',
  `css` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'style',
  `popres` int(3) unsigned NOT NULL DEFAULT '0',
  `popaddpl` int(5) unsigned NOT NULL DEFAULT '10',
  `MG_max_cap` int(10) unsigned NOT NULL DEFAULT '800',
  `Map_max_x` int(4) unsigned NOT NULL DEFAULT '300',
  `Map_max_y` int(4) unsigned NOT NULL DEFAULT '300',
  `Map_max_z` int(4) unsigned NOT NULL DEFAULT '15',
  `FLAG_SZERORES` tinyint(1) NOT NULL DEFAULT '0',
  `FLAG_SUNAVALB` tinyint(1) NOT NULL DEFAULT '1',
  `FLAG_RESICONS` tinyint(1) NOT NULL DEFAULT '0',
  `FLAG_RESLABEL` tinyint(1) NOT NULL DEFAULT '1',
  `cusr_pics` tinyint(1) NOT NULL DEFAULT '0',
  `baru_tmdl` double NOT NULL DEFAULT '0.25' COMMENT 'unit time divider per baraks level (max 1)',
  `max_unit_que` int(2) unsigned DEFAULT '0',
  `max_research_que` int(2) unsigned DEFAULT '0',
  `max_build_que` int(2) unsigned NOT NULL DEFAULT '0',
  `buildfast_molt` double unsigned NOT NULL DEFAULT '1.25',
  `researchfast_molt` double unsigned NOT NULL DEFAULT '1.25',
  `sge_ver` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '100',
  UNIQUE KEY `sge_ver` (`sge_ver`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `conf`
--

INSERT INTO `%PREFIX%conf` (`news1`, `rulers`, `server_name`, `server_desc_sub`, `server_desc_main`, `template`, `css`, `popres`, `popaddpl`, `MG_max_cap`, `Map_max_x`, `Map_max_y`, `Map_max_z`, `FLAG_SZERORES`, `FLAG_SUNAVALB`, `FLAG_RESICONS`, `FLAG_RESLABEL`, `cusr_pics`, `baru_tmdl`, `max_unit_que`, `max_research_que`, `max_build_que`, `buildfast_molt`, `researchfast_molt`, `sge_ver`) VALUES
  ('Your news are here, you can edit them in the admin cp!', 'Your rules here!', 'SgeX Test', 'SgeX Test', 'SgeX Test', 'sgex', '', 0, 10, 0, 500, 500, 12, 0, 1, 0, 1, 1, 0.25, 0, 0, 0, 1, 1, '123');

CREATE TABLE `%PREFIX%market` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city` int(11) unsigned NOT NULL,
  `resoff` smallint(3) unsigned NOT NULL COMMENT 'id of the offered resource',
  `resoqnt` int(15) unsigned NOT NULL COMMENT 'quantity offered',
  `resreq` smallint(3) unsigned NOT NULL COMMENT 'res requested',
  `resrqnt` int(15) unsigned NOT NULL COMMENT 'quantity reqested',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `resoff` (`resoff`),
  KEY `resreq` (`resreq`),
  KEY `market_ibfk_1` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%races` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `rname` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'x',
  `rdesc` longtext COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null.gif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%races` (`id`, `rname`, `rdesc`, `img`) VALUES
(1, 'Archons', 'romans', 'archons.jpg'),
(2, 'Undead', 'undead people', 'undead.jpg');

CREATE TABLE `%PREFIX%resdata` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `prod_rate` double unsigned NOT NULL DEFAULT '1',
  `start` int(6) unsigned NOT NULL DEFAULT '300',
  `ico` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'res ico',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%resdata` (`id`, `name`, `prod_rate`, `start`, `ico`) VALUES
(1, 'Gold', 5, 500, 'gold.png'),
(2, 'Mana', 3, 500, 'mana.png'),
(3, 'Power', 2, 300, 'power.png'),
(4, 'Population', 1, 100, null);

CREATE TABLE `%PREFIX%resmov` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `to` int(11) unsigned NOT NULL,
  `end` int(10) NOT NULL DEFAULT '0',
  `res_id` smallint(3) unsigned NOT NULL,
  `resqnt` int(15) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `res_id` (`res_id`),
  KEY `to` (`to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%tutorial` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `tittle` text COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `next_tut` int(10) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%tutorial` (`id`, `tittle`, `body`, `next_tut`) VALUES
(1, 'Welcome', 'Welcome to phpSGE! This is the tutorrial', 2);

CREATE TABLE `%PREFIX%t_builds` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `arac` smallint(3) unsigned DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Baraks',
  `func` varchar(35) COLLATE utf8_unicode_ci DEFAULT 'none',
  `produceres` smallint(3) unsigned DEFAULT NULL,
  `img` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null.gif',
  `desc` longtext COLLATE utf8_unicode_ci,
  `time` int(30) unsigned NOT NULL DEFAULT '0',
  `time_mpl` double unsigned NOT NULL DEFAULT '0.5' COMMENT 'time moltiplier per level (max 1)',
  `gpoints` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'given points',
  `maxlev` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '0-no max level',
  PRIMARY KEY (`id`),
  UNIQUE KEY `func` (`func`),
  KEY `arac` (`arac`),
  KEY `produceres` (`produceres`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%t_builds` (`id`, `arac`, `name`, `func`, `produceres`, `img`, `desc`, `time`, `time_mpl`, `gpoints`, `maxlev`) VALUES
(1, NULL, 'Baraks', NULL, NULL, 'barraks.gif', 'Baraks', 30, 0.25, 15, 0),
(2, NULL, 'Gold Mine', NULL, 1, 'mine.gif', 'Gold mine', 15, 0.25, 10, 0),
(3, NULL, 'Mana node', NULL, 2, 'node.gif', 'mana pool', 15, 0.25, 10, 0),
(4, NULL, 'Research Lab', 'reslab', NULL, '31.gif', NULL, 55, 0.25, 15, 0),
(5, NULL, 'Widzard Tower', NULL, 3, 'wt.png', NULL, 101, 0.25, 15, 0),
(6, NULL, 'Magazine', 'mag_e', NULL, 'null.gif', NULL, 50, 0.30000000000000004, 15, 0),
(7, NULL, 'Builders Hall', 'buildfaster', NULL, 'buildershall.bmp', 'the higher is the level the less time in building will be requided', 15, 0.7, 15, 0);

CREATE TABLE `%PREFIX%t_build_reqbuild` (
  `build` int(11) unsigned NOT NULL,
  `reqbuild` int(11) unsigned NOT NULL,
  `lev` int(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`build`,`reqbuild`),
  KEY `reqbuild` (`reqbuild`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%t_build_reqbuild` (`build`, `reqbuild`, `lev`) VALUES
(1, 2, 2),
(4, 3, 3);

CREATE TABLE `%PREFIX%t_build_req_research` (
  `build` int(11) unsigned NOT NULL,
  `reqresearch` int(11) unsigned NOT NULL,
  `lev` int(3) unsigned NOT NULL,
  PRIMARY KEY (`build`,`reqresearch`),
  KEY `reqresearch` (`reqresearch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%t_build_resourcecost` (
  `build` int(11) unsigned NOT NULL,
  `resource` smallint(3) unsigned NOT NULL,
  `cost` int(5) unsigned NOT NULL,
  `moltiplier` double NOT NULL,
  PRIMARY KEY (`build`,`resource`),
  KEY `resource` (`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%t_build_resourcecost` (`build`, `resource`, `cost`, `moltiplier`) VALUES
(1, 1, 70, 0),
(1, 2, 10, 0),
(2, 1, 55, 0.25),
(3, 1, 50, 0.25),
(3, 2, 30, 0.25),
(4, 1, 60, 0.25),
(4, 2, 40, 0.25),
(5, 1, 450, 0.5),
(5, 2, 100, 0.3),
(5, 3, 25, 0.3),
(6, 1, 500, 0.2),
(6, 2, 100, 0.15),
(6, 3, 5, 0.21),
(7, 1, 150, 0.3),
(7, 2, 35, 0.5),
(7, 3, 10, 0.25);

CREATE TABLE `%PREFIX%t_research` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `desc` longtext COLLATE utf8_unicode_ci,
  `arac` smallint(3) unsigned DEFAULT NULL COMMENT '0-all races',
  `img` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null.gif',
  `time` int(32) NOT NULL DEFAULT '0',
  `time_mpl` double NOT NULL DEFAULT '0.5',
  `gpoints` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'given points',
  `maxlev` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `arac` (`arac`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%t_research` (`id`, `name`, `desc`, `arac`, `img`, `time`, `time_mpl`, `gpoints`, `maxlev`) VALUES
(1, 'Magic servant', NULL, NULL, 'magicservant.gif', 15, 0.5, 0, 0),
(2, 'Magic Element', NULL, NULL, '', 23, 0.5, 0, 0);

CREATE TABLE `%PREFIX%t_research_reqbuild` (
  `research` int(11) unsigned NOT NULL,
  `reqbuild` int(11) unsigned NOT NULL,
  `lev` int(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`research`,`reqbuild`),
  KEY `reqbuild` (`reqbuild`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%t_research_reqbuild` (`research`, `reqbuild`, `lev`) VALUES
(1, 4, 2),
(2, 4, 6);

CREATE TABLE `%PREFIX%t_research_req_research` (
  `research` int(11) unsigned NOT NULL,
  `reqresearch` int(11) unsigned NOT NULL,
  `lev` int(3) unsigned NOT NULL,
  PRIMARY KEY (`research`,`reqresearch`),
  KEY `reqresearch` (`reqresearch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%t_research_resourcecost` (
  `research` int(11) unsigned NOT NULL,
  `resource` smallint(3) unsigned NOT NULL,
  `cost` int(5) unsigned NOT NULL,
  `moltiplier` double NOT NULL,
  PRIMARY KEY (`research`,`resource`),
  KEY `resource` (`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%t_research_resourcecost` (`research`, `resource`, `cost`, `moltiplier`) VALUES
(1, 1, 70, 0.25),
(1, 2, 10, 0.1),
(2, 1, 50, 0.3),
(2, 2, 50, 0.4);

CREATE TABLE `%PREFIX%t_unt` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `race` smallint(3) unsigned DEFAULT NULL COMMENT '0-all races',
  `img` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null.gif',
  `health` int(5) unsigned NOT NULL DEFAULT '100',
  `atk` int(5) unsigned NOT NULL DEFAULT '5',
  `dif` int(5) unsigned NOT NULL DEFAULT '5',
  `vel` int(5) unsigned NOT NULL DEFAULT '5',
  `res_car_cap` int(10) unsigned NOT NULL DEFAULT '10' COMMENT 'max quantity of carryable resource (is random resource)',
  `etime` int(10) unsigned NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'type of unit: archer etc.',
  PRIMARY KEY (`id`),
  KEY `race` (`race`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%t_unt` (`id`, `name`, `race`, `img`, `health`, `atk`, `dif`, `vel`, `res_car_cap`, `etime`, `desc`, `type`) VALUES
(1, 'Milita', 1, 'milita.gif', 60, 5, 5, 4, 10, 15, 'A simple soldier', NULL),
(2, 'Drago', 1, 'rdragus.gif', 300, 17, 13, 11, 10, 300, 'the powerful dragon! wow!', NULL),
(3, 'Carvan', NULL, 'pioner.gif', 100, 1, 5, 7, 0, 150, 'Colonizator Carvan, you can build a new city', 'column'),
(4, 'Archer', 1, 'archer.gif', 45, 3, 6, 5, 6, 26, 'archer', NULL),
(5, 'Legionary', 1, 'legionary.gif', 80, 7, 7, 6, 5, 41, 'Legionary', NULL),
(6, 'zombie', 2, 'zombie.gif', 40, 8, 8, 2, 5, 15, '', NULL),
(7, 'udswordsman', 2, 'udswordsman.gif', 60, 12, 10, 8, 5, 0, '', NULL),
(8, 'deathknight', 2, 'deathknight.gif', 130, 27, 21, 20, 5, 0, '', NULL);

CREATE TABLE `%PREFIX%t_unt_reqbuild` (
  `unit` int(11) unsigned NOT NULL,
  `reqbuild` int(11) unsigned NOT NULL,
  `lev` int(3) unsigned NOT NULL,
  PRIMARY KEY (`unit`,`reqbuild`),
  KEY `reqbuild` (`reqbuild`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%t_unt_reqbuild` (`unit`, `reqbuild`, `lev`) VALUES
(1, 1, 1),
(2, 1, 12),
(2, 4, 6),
(3, 2, 5),
(4, 1, 3),
(5, 1, 5),
(7, 1, 5),
(8, 1, 11);

CREATE TABLE `%PREFIX%t_unt_req_research` (
  `unit` int(11) unsigned NOT NULL,
  `reqresearch` int(11) unsigned NOT NULL,
  `lev` int(3) unsigned NOT NULL,
  PRIMARY KEY (`unit`,`reqresearch`),
  KEY `reqresearch` (`reqresearch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%t_unt_req_research` (`unit`, `reqresearch`, `lev`) VALUES
(2, 1, 9);

CREATE TABLE `%PREFIX%t_unt_resourcecost` (
  `unit` int(11) unsigned NOT NULL,
  `resource` smallint(3) unsigned NOT NULL,
  `cost` int(5) unsigned NOT NULL,
  PRIMARY KEY (`unit`,`resource`),
  KEY `resource` (`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%t_unt_resourcecost` (`unit`, `resource`, `cost`) VALUES
(1, 1, 20),
(2, 1, 500),
(2, 2, 350),
(3, 1, 1500),
(4, 1, 29),
(4, 2, 5),
(5, 1, 35),
(5, 2, 5),
(6, 1, 15),
(7, 1, 40),
(7, 2, 6),
(8, 1, 170),
(8, 2, 90);

CREATE TABLE `%PREFIX%units` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `id_unt` int(15) unsigned NOT NULL DEFAULT '0' COMMENT 'unit id',
  `uqnt` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'unit quante',
  `owner_id` int(30) unsigned NOT NULL DEFAULT '0',
  `from` int(15) unsigned DEFAULT NULL,
  `to` int(15) unsigned DEFAULT NULL,
  `where` int(15) unsigned DEFAULT NULL,
  `time` int(35) DEFAULT '0',
  `action` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '0 unit in the city | 1 atack | 2 rinforce | 3 return',
  PRIMARY KEY (`id`),
  KEY `id_unt` (`id_unt`),
  KEY `owner_id` (`owner_id`),
  KEY `from` (`from`),
  KEY `to` (`to`),
  KEY `where` (`where`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%unit_que` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `id_unt` int(15) unsigned NOT NULL DEFAULT '0' COMMENT 'id unitÃƒÆ’Ã‚Â ',
  `uqnt` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'quante unitÃƒÆ’Ã‚Â ',
  `city` int(15) unsigned NOT NULL DEFAULT '0',
  `end` int(15) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_unt` (`id_unt`),
  KEY `city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%users` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `race` smallint(3) unsigned NOT NULL,
  `capcity` int(11) unsigned DEFAULT NULL,
  `ally_id` int(11) unsigned DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp_reg` int(11) NOT NULL,
  `points` int(6) unsigned DEFAULT '0',
  `rank` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'max is 3',
  `active` tinyint(1) DEFAULT NULL,
  `last_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tut` tinyint(1) NOT NULL DEFAULT '1',
  `lang` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en' COMMENT 'laguage',
  `ip` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `capcity` (`capcity`),
  KEY `race` (`race`),
  KEY `ally_id` (`ally_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%user_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(11) unsigned DEFAULT NULL,
  `to` int(11) unsigned NOT NULL,
  `mtit` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mtype` tinyint(2) unsigned NOT NULL COMMENT '0 sys msg | 1 msg | 2 repo | 3 ally invite',
  `aiid` int(11) unsigned DEFAULT NULL COMMENT 'ally id for the invite',
  PRIMARY KEY (`id`),
  KEY `from` (`from`),
  KEY `to` (`to`),
  KEY `aiid` (`aiid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%user_passrecover` (
  `usrid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `until` int(20) unsigned NOT NULL,
  PRIMARY KEY (`usrid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%user_research` (
  `id_res` int(5) unsigned NOT NULL DEFAULT '0',
  `usr` int(10) unsigned NOT NULL DEFAULT '0',
  `lev` int(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_res`,`usr`),
  KEY `usr` (`usr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `%PREFIX%warn` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `%PREFIX%ally`
  ADD CONSTRAINT `ally_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `%PREFIX%users` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%ally_pact`
  ADD CONSTRAINT `ally_pact_ibfk_1` FOREIGN KEY (`ally1`) REFERENCES `%PREFIX%ally` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ally_pact_ibfk_2` FOREIGN KEY (`ally2`) REFERENCES `%PREFIX%ally` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%banlist`
  ADD CONSTRAINT `banlist_ibfk_1` FOREIGN KEY (`usrid`) REFERENCES `%PREFIX%users` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`usrid`) REFERENCES `%PREFIX%users` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `%PREFIX%users` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%city_builds`
  ADD CONSTRAINT `city_builds_ibfk_2` FOREIGN KEY (`build`) REFERENCES `%PREFIX%t_builds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `city_builds_ibfk_3` FOREIGN KEY (`city`) REFERENCES `%PREFIX%city` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%city_build_que`
  ADD CONSTRAINT `city_build_que_ibfk_2` FOREIGN KEY (`build`) REFERENCES `%PREFIX%t_builds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `city_build_que_ibfk_3` FOREIGN KEY (`city`) REFERENCES `%PREFIX%city` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%city_research_que`
  ADD CONSTRAINT `city_research_que_ibfk_2` FOREIGN KEY (`res_id`) REFERENCES `%PREFIX%t_research` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `city_research_que_ibfk_3` FOREIGN KEY (`city`) REFERENCES `%PREFIX%city` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%city_resources`
  ADD CONSTRAINT `city_resources_ibfk_2` FOREIGN KEY (`res_id`) REFERENCES `%PREFIX%resdata` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `city_resources_ibfk_3` FOREIGN KEY (`city_id`) REFERENCES `%PREFIX%city` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%market`
  ADD CONSTRAINT `market_ibfk_1` FOREIGN KEY (`city`) REFERENCES `%PREFIX%city` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `market_ibfk_2` FOREIGN KEY (`resoff`) REFERENCES `%PREFIX%resdata` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `market_ibfk_3` FOREIGN KEY (`resreq`) REFERENCES `%PREFIX%resdata` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%resmov`
  ADD CONSTRAINT `resmov_ibfk_2` FOREIGN KEY (`res_id`) REFERENCES `%PREFIX%resdata` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resmov_ibfk_3` FOREIGN KEY (`to`) REFERENCES `%PREFIX%city` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%t_builds`
  ADD CONSTRAINT `t_builds_ibfk_1` FOREIGN KEY (`arac`) REFERENCES `%PREFIX%races` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `t_builds_ibfk_2` FOREIGN KEY (`produceres`) REFERENCES `%PREFIX%resdata` (`id`) ON DELETE SET NULL;

ALTER TABLE `%PREFIX%t_build_reqbuild`
  ADD CONSTRAINT `t_build_reqbuild_ibfk_1` FOREIGN KEY (`build`) REFERENCES `%PREFIX%t_builds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_build_reqbuild_ibfk_2` FOREIGN KEY (`reqbuild`) REFERENCES `%PREFIX%t_builds` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%t_build_req_research`
  ADD CONSTRAINT `t_build_req_research_ibfk_1` FOREIGN KEY (`build`) REFERENCES `%PREFIX%t_builds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_build_req_research_ibfk_2` FOREIGN KEY (`reqresearch`) REFERENCES `%PREFIX%t_research` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%t_build_resourcecost`
  ADD CONSTRAINT `t_build_resourcecost_ibfk_1` FOREIGN KEY (`%PREFIX%build`) REFERENCES `%PREFIX%t_builds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_build_resourcecost_ibfk_2` FOREIGN KEY (`resource`) REFERENCES `%PREFIX%resdata` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%t_research`
  ADD CONSTRAINT `t_research_ibfk_1` FOREIGN KEY (`arac`) REFERENCES `%PREFIX%races` (`id`) ON DELETE SET NULL;

ALTER TABLE `%PREFIX%t_research_reqbuild`
  ADD CONSTRAINT `t_research_reqbuild_ibfk_1` FOREIGN KEY (`research`) REFERENCES `%PREFIX%t_research` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_research_reqbuild_ibfk_2` FOREIGN KEY (`reqbuild`) REFERENCES `%PREFIX%t_builds` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%t_research_req_research`
  ADD CONSTRAINT `t_research_req_research_ibfk_1` FOREIGN KEY (`research`) REFERENCES `%PREFIX%t_research` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_research_req_research_ibfk_2` FOREIGN KEY (`reqresearch`) REFERENCES `%PREFIX%t_research` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%t_research_resourcecost`
  ADD CONSTRAINT `t_research_resourcecost_ibfk_1` FOREIGN KEY (`research`) REFERENCES `%PREFIX%t_research` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_research_resourcecost_ibfk_2` FOREIGN KEY (`resource`) REFERENCES `%PREFIX%resdata` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%t_unt`
  ADD CONSTRAINT `t_unt_ibfk_1` FOREIGN KEY (`race`) REFERENCES `%PREFIX%races` (`id`) ON DELETE SET NULL;

ALTER TABLE `%PREFIX%t_unt_reqbuild`
  ADD CONSTRAINT `t_unt_reqbuild_ibfk_1` FOREIGN KEY (`unit`) REFERENCES `%PREFIX%t_unt` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_unt_reqbuild_ibfk_2` FOREIGN KEY (`reqbuild`) REFERENCES `%PREFIX%t_builds` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%t_unt_req_research`
  ADD CONSTRAINT `t_unt_req_research_ibfk_1` FOREIGN KEY (`unit`) REFERENCES `%PREFIX%t_unt` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_unt_req_research_ibfk_2` FOREIGN KEY (`reqresearch`) REFERENCES `%PREFIX%t_research` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%t_unt_resourcecost`
  ADD CONSTRAINT `t_unt_resourcecost_ibfk_1` FOREIGN KEY (`unit`) REFERENCES `%PREFIX%t_unt` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_unt_resourcecost_ibfk_2` FOREIGN KEY (`resource`) REFERENCES `%PREFIX%resdata` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%units`
  ADD CONSTRAINT `units_ibfk_1` FOREIGN KEY (`id_unt`) REFERENCES `%PREFIX%t_unt` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `units_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `%PREFIX%users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `units_ibfk_3` FOREIGN KEY (`from`) REFERENCES `%PREFIX%city` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `units_ibfk_4` FOREIGN KEY (`to`) REFERENCES `%PREFIX%city` (`id`),
  ADD CONSTRAINT `units_ibfk_5` FOREIGN KEY (`where`) REFERENCES `%PREFIX%city` (`id`);

ALTER TABLE `%PREFIX%unit_que`
  ADD CONSTRAINT `unit_que_ibfk_1` FOREIGN KEY (`id_unt`) REFERENCES `%PREFIX%t_unt` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `unit_que_ibfk_2` FOREIGN KEY (`city`) REFERENCES `%PREFIX%city` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`race`) REFERENCES `%PREFIX%races` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`ally_id`) REFERENCES `%PREFIX%ally` (`id`) ON DELETE SET NULL;

ALTER TABLE `%PREFIX%user_message`
  ADD CONSTRAINT `user_message_ibfk_1` FOREIGN KEY (`from`) REFERENCES `%PREFIX%users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_message_ibfk_2` FOREIGN KEY (`to`) REFERENCES `%PREFIX%users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_message_ibfk_3` FOREIGN KEY (`aiid`) REFERENCES `%PREFIX%ally` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%user_passrecover`
  ADD CONSTRAINT `user_passrecover_ibfk_1` FOREIGN KEY (`usrid`) REFERENCES `%PREFIX%users` (`id`) ON DELETE CASCADE;

ALTER TABLE `%PREFIX%user_research`
  ADD CONSTRAINT `user_research_ibfk_1` FOREIGN KEY (`id_res`) REFERENCES `%PREFIX%t_research` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_research_ibfk_2` FOREIGN KEY (`usr`) REFERENCES `%PREFIX%users` (`id`) ON DELETE CASCADE;