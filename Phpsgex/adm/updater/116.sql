alter table ally DROP `points`;
alter table `city_builds` ADD UNIQUE (`city`, `build`);
alter table `city_build_que` CHANGE `city` `city` INT( 15 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `users` ADD UNIQUE (`email`);
ALTER TABLE `t_research_resourcecost` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `t_unt_resourcecost` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `user_passrecover` (
  `usrid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `until` int(20) unsigned NOT NULL,
  PRIMARY KEY (`usrid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

UPDATE `conf` SET `sge_ver` = '117' WHERE `sge_ver` = '116';