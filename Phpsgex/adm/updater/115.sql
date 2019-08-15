CREATE TABLE `t_build_req_research` (
  `build` int(11) unsigned NOT NULL,
  `reqresearch` int(11) unsigned NOT NULL,
  `lev` int(3) unsigned NOT NULL,
  PRIMARY KEY (`build`,`reqresearch`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `t_research_req_research` (
  `research` int(11) unsigned NOT NULL,
  `reqresearch` int(11) unsigned NOT NULL,
  `lev` int(3) unsigned NOT NULL,
  PRIMARY KEY (`research`,`reqresearch`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
UPDATE `conf` SET `sge_ver` = '116' WHERE `sge_ver` = '115';