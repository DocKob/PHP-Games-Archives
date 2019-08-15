ALTER TABLE  `t_research` ADD  `time_mpl` DOUBLE NOT NULL DEFAULT  '0.5' AFTER  `time`;
UPDATE `conf` SET `sge_ver` = '102' WHERE `sge_ver` = '101';