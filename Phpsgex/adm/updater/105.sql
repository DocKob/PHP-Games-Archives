ALTER TABLE  `city` ADD UNIQUE (`galaxy`, `system`, `pos`);
UPDATE `conf` SET `sge_ver` = '106' WHERE `sge_ver` = '105';