-- sql for map city sys2 --

ALTER TABLE `%PREFIX%city_build_que` ADD `field` TINYINT( 2 ) NOT NULL;
ALTER TABLE `%PREFIX%city_builds` ADD `field` TINYINT( 2 ) NOT NULL;
ALTER TABLE `%PREFIX%city_builds` ADD UNIQUE( `city`, `field`);