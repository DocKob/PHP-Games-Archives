ALTER TABLE `conf` ADD `max_build_que` INT(2) UNSIGNED DEFAULT '0' AFTER `baru_tmdl`;
ALTER TABLE `conf` ADD `max_research_que` INT(2) UNSIGNED DEFAULT '0' AFTER `baru_tmdl`;
ALTER TABLE `conf` ADD `max_unit_que` INT(2) UNSIGNED DEFAULT '0' AFTER `baru_tmdl`;

UPDATE `conf` SET `sge_ver` = '123' WHERE `sge_ver` = '122';