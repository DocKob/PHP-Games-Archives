CREATE TABLE `%PREFIX%isle` (
  `id` int(15) NOT NULL default '0',
  `x` int(60) NOT NULL default '0',
  `y` int(60) NOT NULL default '0',
  `name` varchar(15) NOT NULL default 'isola',
  `type` int(5) NOT NULL default '1',
  `subtype` int(5) NOT NULL default '0',
  `tep` int(5) NOT NULL default '1',
  `pos_a` int(25) NOT NULL default '0',
  `pos_b` int(25) NOT NULL default '0',
  `pos_c` int(25) NOT NULL default '0',
  `pos_d` int(25) NOT NULL default '0'
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `%PREFIX%isle` VALUES (1, 1, 1, 'isola di raffa', 1, 0, 1, 1, 0, 0, 0);




