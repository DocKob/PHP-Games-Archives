CREATE TABLE `t_research_reqbuild` (
  `research` int(11) unsigned NOT NULL,
  `reqbuild` int(11) unsigned NOT NULL,
  `lev` int(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`research`,`reqbuild`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
UPDATE `conf` SET `sge_ver` = '103' WHERE `sge_ver` = '102';