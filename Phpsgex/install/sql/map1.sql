-- sql for map system 1 --

ALTER TABLE `%PREFIX%city` ADD `x` INT( 15 ) NOT NULL DEFAULT '0',
ADD `y` INT( 15 ) NOT NULL DEFAULT '0',
ADD `z` INT( 15 ) NOT NULL DEFAULT '0',
ADD `img` VARCHAR( 35 ) NOT NULL DEFAULT 'null.gif';

ALTER TABLE `%PREFIX%city` ADD UNIQUE( `x`, `y`, `z` );