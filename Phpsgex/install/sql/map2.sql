-- sql for map system 2 --

ALTER TABLE `%PREFIX%city` ADD `x` INT( 15 ) NOT NULL DEFAULT '0',
ADD `y` INT( 15 ) NOT NULL DEFAULT '0',
ADD `type` VARCHAR( 15 ) NOT NULL DEFAULT 'null.gif';

ALTER TABLE `%PREFIX%city` ADD UNIQUE( `x`, `y` );