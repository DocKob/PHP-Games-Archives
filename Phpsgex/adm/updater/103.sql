ALTER TABLE `conf` ADD `buildfast_molt` DOUBLE UNSIGNED NOT NULL DEFAULT '1.25' AFTER `baru_tmdl`;
ALTER TABLE `conf` ADD `researchfast_molt` DOUBLE UNSIGNED NOT NULL DEFAULT '1.25' AFTER `buildfast_molt`;
ALTER TABLE `t_builds` CHANGE `func` `func` VARCHAR(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'none';
UPDATE `conf` SET `sge_ver` = '104' WHERE `sge_ver` = '103';