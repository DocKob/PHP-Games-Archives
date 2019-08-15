CREATE TABLE `%PREFIX%plugins` (
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('bridge','map','city','battle','index') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `%PREFIX%conf` ADD `FLAG_SHOWUSRMAIL` BOOLEAN NOT NULL DEFAULT TRUE AFTER `FLAG_RESLABEL`;
ALTER TABLE `%PREFIX%conf` ADD `registration_email` TEXT NOT NULL AFTER `news1`;
UPDATE `%PREFIX%conf` SET `registration_email` = 'Welcome to [game_name]<div>Your Username is: [your_name]</div>' WHERE 1;

UPDATE `%PREFIX%conf` SET `sge_ver` = '124' WHERE `sge_ver` = '123';