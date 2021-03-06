ALTER TABLE  `conf` ADD  `server_name` VARCHAR( 30 ) NOT NULL DEFAULT  'sgex' AFTER  `rulers` ,
ADD  `server_desc_sub` VARCHAR( 50 ) NULL DEFAULT  'sgex' AFTER  `server_name` ,
ADD  `server_desc_main` TEXT NULL AFTER  `server_desc_sub` ,
ADD  `template` VARCHAR( 15 ) NOT NULL DEFAULT  'sgex' AFTER  `server_desc_main` ,
ADD  `css` VARCHAR( 30 ) NOT NULL DEFAULT  'style' AFTER  `template` ,
ADD  `MG_max_cap` INT UNSIGNED NOT NULL DEFAULT  '800' AFTER  `css` ,
ADD  `FLAG_SZERORES` BOOLEAN NOT NULL DEFAULT FALSE AFTER  `MG_max_cap` ,
ADD  `FLAG_SUNAVALB` BOOLEAN NOT NULL DEFAULT TRUE AFTER  `FLAG_SZERORES` ,
ADD  `FLAG_RESICONS` BOOLEAN NOT NULL DEFAULT FALSE AFTER  `FLAG_SUNAVALB`,
ADD  `FLAG_RESLABEL` BOOLEAN NOT NULL DEFAULT TRUE AFTER  `FLAG_RESICONS`;
UPDATE `conf` SET `sge_ver` = '108' WHERE `sge_ver` = '107';