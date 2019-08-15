UPDATE `conf` SET `sge_ver` = '110' WHERE `sge_ver` = '109';
ALTER TABLE  `map` ADD PRIMARY KEY ( `city` );
ALTER TABLE  `map` ADD UNIQUE (`x` ,`y`);
ALTER TABLE `map` DROP INDEX Index_1;