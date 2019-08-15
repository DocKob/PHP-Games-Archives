ALTER TABLE `conf` ADD `popres` INT( 3 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `css`;
ALTER TABLE `conf` ADD `popaddpl` INT( 5 ) UNSIGNED NOT NULL DEFAULT '10' AFTER `popres`;
UPDATE `conf` SET `FLAG_SZERORES` = '1' WHERE `sge_ver` = '113';
UPDATE `conf` SET `sge_ver` = '114' WHERE `sge_ver` = '113';