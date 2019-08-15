ALTER TABLE `users` ADD UNIQUE(`username`);
ALTER TABLE `city_builds` DROP `func`;
ALTER TABLE `city_research_que` CHANGE `usr` `city` INT(15) UNSIGNED NOT NULL;
ALTER TABLE `city_research_que` DROP FOREIGN KEY `city_research_que_ibfk_1`;
ALTER TABLE `city_research_que` ADD FOREIGN KEY (`city`) REFERENCES `city`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
ALTER TABLE `ally` ADD `invite_text` varchar(255) NOT NULL DEFAULT 'You are invited in [ally_name]' AFTER `desc`;
ALTER TABLE `market` CHANGE `owner` `city` INT(11) UNSIGNED NOT NULL;
ALTER TABLE `market` DROP FOREIGN KEY `market_ibfk_1`;
ALTER TABLE `market` ADD CONSTRAINT `market_ibfk_1` FOREIGN KEY (`city`) REFERENCES `city`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

UPDATE `conf` SET `sge_ver` = '122' WHERE `sge_ver` = '121';