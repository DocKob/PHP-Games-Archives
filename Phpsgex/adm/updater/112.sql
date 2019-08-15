ALTER TABLE  `t_research` ADD  `maxlev` INT( 3 ) UNSIGNED NOT NULL DEFAULT  '0';
UPDATE `conf` SET `sge_ver` = '113' WHERE `sge_ver` = '112';