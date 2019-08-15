ALTER TABLE  `conf` ADD  `Map_max_x` INT( 4 ) UNSIGNED NOT NULL DEFAULT  '300' AFTER  `MG_max_cap` ,
ADD  `Map_max_y` INT( 4 ) UNSIGNED NOT NULL DEFAULT  '300' AFTER  `Map_max_x` ,
ADD  `Map_max_z` INT( 4 ) UNSIGNED NOT NULL DEFAULT  '15' AFTER  `Map_max_y`;
CREATE TABLE `banlist` (
  `usrid` int(11) unsigned NOT NULL,
  `timeout` int(11) NOT NULL COMMENT '-1 = forever',
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`usrid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `users` DROP `banned`;
ALTER TABLE `city` DROP `pop`;
UPDATE `conf` SET `sge_ver` = '115' WHERE `sge_ver` = '114';
INSERT INTO `races` VALUES (2, 'Undead', 'undead people', 'undead.jpg');
INSERT INTO `t_unt` VALUES (6, 'zombie', 2, 'zombie.gif', 40, 8, 8, 2, 5, 15, '', NULL), (7, 'udswordsman', 2, 'udswordsman.gif', 60, 12, 10, 8, 5, 0, '', NULL), (8, 'deathknight', 2, 'deathknight.gif', 130, 27, 21, 20, 5, 0, '', NULL);
INSERT INTO `t_unt_resourcecost` VALUES (6, 1, 15),(7, 1, 40),(7, 2, 6),(8, 1, 170),(8, 2, 90);
INSERT INTO `t_unt_reqbuild` VALUES (7, 1, 5),(8, 1, 11);