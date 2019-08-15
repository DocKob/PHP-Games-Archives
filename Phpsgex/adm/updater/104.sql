ALTER TABLE `users` DROP `active`;
UPDATE `conf` SET `sge_ver` = '105' WHERE `sge_ver` = '104';