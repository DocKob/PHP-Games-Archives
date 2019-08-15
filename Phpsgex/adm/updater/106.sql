CREATE TABLE `t_unt_req_research` (
  `unit` int(11) unsigned NOT NULL,
  `reqresearch` int(11) unsigned NOT NULL,
  `lev` int(3) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `t_unt_req_research` ADD PRIMARY KEY ( `unit`, `reqresearch` );
UPDATE `conf` SET `sge_ver` = '107' WHERE `sge_ver` = '106';