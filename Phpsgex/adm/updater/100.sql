ALTER TABLE `market` ADD PRIMARY KEY ( `id` );
UPDATE `conf` SET `sge_ver` = '101' WHERE `sge_ver` = '100';