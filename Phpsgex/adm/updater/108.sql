ALTER TABLE  `t_unt` ADD  `health` INT( 5 ) UNSIGNED NOT NULL DEFAULT  '100' AFTER  `img`;
ALTER TABLE  `t_unt` CHANGE  `res_car_cap`  `res_car_cap` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '10' COMMENT 'max quantity of carryable resource (is random resource)',
CHANGE  `etime`  `etime` INT( 10 ) UNSIGNED NOT NULL;
UPDATE `conf` SET `sge_ver` = '109' WHERE `sge_ver` = '108';