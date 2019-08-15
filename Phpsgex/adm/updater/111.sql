ALTER TABLE `chat` DROP `username`;
ALTER TABLE  `t_builds` CHANGE  `maxlev`  `maxlev` INT( 3 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '0-no max level';
UPDATE `conf` SET `sge_ver` = '112' WHERE `sge_ver` = '111';