ALTER TABLE `resmov` CHANGE `to` `to` INT(11) UNSIGNED NOT NULL, CHANGE `res_id` `res_id` INT(11) UNSIGNED NOT NULL;
ALTER TABLE `t_builds` CHANGE `produceres` `produceres` SMALLINT(3) UNSIGNED NULL DEFAULT NULL, CHANGE `arac` `arac` SMALLINT(3) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `t_research` CHANGE `arac` `arac` SMALLINT(3) UNSIGNED NULL DEFAULT NULL COMMENT '0-all races';
ALTER TABLE `t_unt` CHANGE `race` `race` SMALLINT(3) UNSIGNED NULL DEFAULT NULL COMMENT '0-all races';
ALTER TABLE `users` CHANGE `race` `race` SMALLINT(3) UNSIGNED NOT NULL, CHANGE `capcity` `capcity` INT(11) UNSIGNED NULL, CHANGE `ally_id` `ally_id` INT(11) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `user_message` CHANGE `from` `from` INT(11) UNSIGNED NULL, CHANGE `to` `to` INT(11) UNSIGNED NOT NULL, CHANGE `aiid` `aiid` INT(11) UNSIGNED NULL DEFAULT NULL COMMENT 'ally id for the invite';
ALTER TABLE `resdata` CHANGE `id` `id` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `city_resources` CHANGE `res_id` `res_id` SMALLINT(3) UNSIGNED NOT NULL;
ALTER TABLE `market` CHANGE `resoff` `resoff` SMALLINT(3) UNSIGNED NOT NULL COMMENT 'id of the offered resource', CHANGE `resreq` `resreq` SMALLINT(3) UNSIGNED NOT NULL COMMENT 'res requested';
ALTER TABLE `resmov` CHANGE `res_id` `res_id` SMALLINT(3) UNSIGNED NOT NULL;
ALTER TABLE `races` CHANGE `id` `id` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `t_build_resourcecost` CHANGE `resource` `resource` SMALLINT(3) UNSIGNED NOT NULL;
ALTER TABLE `t_research_resourcecost` CHANGE `resource` `resource` SMALLINT(3) UNSIGNED NOT NULL;
ALTER TABLE `t_unt_resourcecost` CHANGE `resource` `resource` SMALLINT(3) UNSIGNED NOT NULL;
ALTER TABLE `ally` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;

UPDATE `t_builds` SET `arac` = NULL WHERE `arac` = 0;
UPDATE `t_builds` SET `produceres` = NULL WHERE `produceres` = 0;
UPDATE `t_research` SET `arac` = NULL WHERE `arac` = 0;
UPDATE `t_unt` SET `race` = NULL WHERE `race` = 0;
UPDATE `users` SET `ally_id` = NULL WHERE `ally_id` = 0;

ALTER TABLE `ally` ADD INDEX(`owner`);
alter table ally add foreign key (owner) references users(id) on delete cascade;

ALTER TABLE `ally_pact` ADD INDEX(`ally1`);
alter table ally_pact add foreign key (ally1) references ally(id) on delete cascade;

ALTER TABLE `ally_pact` ADD INDEX(`ally2`);
alter table ally_pact add foreign key (ally2) references ally(id) on delete cascade;

ALTER TABLE `banlist` ADD INDEX(`usrid`);
alter table banlist add foreign key (usrid) references users(id) on delete cascade;

ALTER TABLE `chat` ADD INDEX(`usrid`);
alter table chat add foreign key (usrid) references users(id) on delete cascade;

ALTER TABLE `city` ADD INDEX(`owner`);
alter table city add foreign key (owner) references users(id) on delete cascade;

ALTER TABLE `city_builds` ADD INDEX(`city`);
alter table city_builds add foreign key (city) references city(id) on delete cascade;

ALTER TABLE `city_builds` ADD INDEX(`build`);
alter table city_builds add foreign key (build) references t_builds(id) on delete cascade;

ALTER TABLE `city_build_que` ADD INDEX(`city`);
alter table city_build_que add foreign key (city) references city(id) on delete cascade;

ALTER TABLE `city_build_que` ADD INDEX(`build`);
alter table city_build_que add foreign key (build) references t_builds(id) on delete cascade;

ALTER TABLE `city_research_que` ADD INDEX(`usr`);
alter table city_research_que add foreign key (usr) references users(id) on delete cascade;

ALTER TABLE `city_research_que` ADD INDEX(`res_id`);
alter table city_research_que add foreign key (res_id) references t_research(id) on delete cascade;

ALTER TABLE `city_resources` ADD INDEX(`city_id`);
alter table city_resources add foreign key (city_id) references city(id) on delete cascade;

ALTER TABLE `city_resources` ADD INDEX(`res_id`);
alter table city_resources add foreign key (res_id) references resdata(id) on delete cascade;

ALTER TABLE `market` ADD INDEX(`owner`);
alter table market add foreign key (owner) references users(id) on delete cascade;

ALTER TABLE `market` ADD INDEX(`resoff`);
alter table market add foreign key (resoff) references resdata(id) on delete cascade;

ALTER TABLE `market` ADD INDEX(`resreq`);
alter table market add foreign key (resreq) references resdata(id) on delete cascade;

ALTER TABLE `resmov` ADD INDEX(`to`);
alter table resmov add foreign key (`to`) references city(id) on delete cascade;

ALTER TABLE `resmov` ADD INDEX(`res_id`);
alter table resmov add foreign key (res_id) references resdata(id) on delete cascade;

ALTER TABLE `t_builds` ADD INDEX(`arac`);
ALTER TABLE `t_builds` ADD FOREIGN KEY (`arac`) REFERENCES `races`(`id`) ON DELETE SET NULL;

ALTER TABLE `t_builds` ADD INDEX(`produceres`);
alter table t_builds add foreign key (`produceres`) references resdata(id) on delete set null;

ALTER TABLE `t_build_reqbuild` ADD INDEX(`build`);
alter table t_build_reqbuild add foreign key (`build`) references t_builds(id) on delete cascade;

ALTER TABLE `t_build_reqbuild` ADD INDEX(`reqbuild`);
alter table t_build_reqbuild add foreign key (`reqbuild`) references t_builds(id) on delete cascade;

ALTER TABLE `t_build_req_research` ADD INDEX(`build`);
alter table t_build_req_research add foreign key (`build`) references t_builds(id) on delete cascade;

ALTER TABLE `t_build_req_research` ADD INDEX(`reqresearch`);
alter table t_build_req_research add foreign key (`reqresearch`) references t_research(id) on delete cascade;

ALTER TABLE `t_build_resourcecost` ADD INDEX(`build`);
alter table t_build_resourcecost add foreign key (`build`) references t_builds(id) on delete cascade;

ALTER TABLE `t_build_resourcecost` ADD INDEX(`resource`);
alter table t_build_resourcecost add foreign key (`resource`) references resdata(id) on delete cascade;

ALTER TABLE `t_research` ADD INDEX(`arac`);
ALTER TABLE `t_research` ADD FOREIGN KEY (`arac`) REFERENCES `races`(`id`) ON DELETE SET NULL;

ALTER TABLE `t_research_reqbuild` ADD INDEX(`research`);
alter table `t_research_reqbuild` add foreign key (research) references t_research(id) on delete cascade;

ALTER TABLE `t_research_reqbuild` ADD INDEX(`reqbuild`);
alter table `t_research_reqbuild` add foreign key (reqbuild) references t_builds(id) on delete cascade;

ALTER TABLE `t_research_req_research` ADD INDEX(`research`);
alter table `t_research_req_research` add foreign key (research) references t_research(id) on delete cascade;

ALTER TABLE `t_research_req_research` ADD INDEX(`reqresearch`);
alter table `t_research_req_research` add foreign key (reqresearch) references t_research(id) on delete cascade;

ALTER TABLE `t_research_resourcecost` ADD INDEX(`research`);
alter table `t_research_resourcecost` add foreign key (research) references t_research(id) on delete cascade;

ALTER TABLE `t_research_resourcecost` ADD INDEX(`resource`);
alter table `t_research_resourcecost` add foreign key (`resource`) references resdata(id) on delete cascade;

ALTER TABLE `t_unt` ADD INDEX(`race`);
alter table t_unt add foreign key (race) references races(id) on delete set null;

ALTER TABLE `t_unt_reqbuild` ADD INDEX(`unit`);
alter table t_unt_reqbuild add foreign key (unit) references t_unt(id) on delete cascade;

ALTER TABLE `t_unt_reqbuild` ADD INDEX(`reqbuild`);
alter table t_unt_reqbuild add foreign key (reqbuild) references t_builds(id) on delete cascade;

ALTER TABLE `t_unt_req_research` ADD INDEX(`unit`);
alter table t_unt_req_research add foreign key (unit) references t_unt(id) on delete cascade;

ALTER TABLE `t_unt_req_research` ADD INDEX(`reqresearch`);
alter table t_unt_req_research add foreign key (reqresearch) references t_research(id) on delete cascade;

ALTER TABLE `t_unt_resourcecost` ADD INDEX(`unit`);
alter table t_unt_resourcecost add foreign key (unit) references t_unt(id) on delete cascade;

ALTER TABLE `t_unt_resourcecost` ADD INDEX(`resource`);
alter table t_unt_resourcecost add foreign key (`resource`) references resdata(id) on delete cascade;

ALTER TABLE `units` ADD INDEX(`id_unt`);
alter table units add foreign key (id_unt) references t_unt(id) on delete cascade;

ALTER TABLE `units` ADD INDEX(`owner_id`);
alter table units add foreign key (owner_id) references users(id) on delete cascade;

ALTER TABLE `units` ADD INDEX(`from`);
alter table units add foreign key (`from`) references city(id) on delete cascade;

ALTER TABLE `units` ADD INDEX(`to`);
alter table units add foreign key (`to`) references city(id) on delete cascade;

ALTER TABLE `units` ADD INDEX(`where`);
alter table units add foreign key (`where`) references city(id) on delete cascade;

ALTER TABLE `unit_que` ADD INDEX(`id_unt`);
alter table unit_que add foreign key (id_unt) references t_unt(id) on delete cascade;

ALTER TABLE `unit_que` ADD INDEX(`city`);
alter table unit_que add foreign key (city) references city(id) on delete cascade;

ALTER TABLE `users` ADD INDEX(`race`);
alter table users add foreign key (race) references races(id) on delete cascade;

ALTER TABLE `users` ADD INDEX(`ally_id`);
alter table users add foreign key (ally_id) references ally(id) on delete set null;

ALTER TABLE `user_message` ADD INDEX(`from`);
ALTER TABLE `user_message` ADD INDEX(`to`);
ALTER TABLE `user_message` ADD INDEX(`aiid`);
ALTER TABLE `user_message` ADD FOREIGN KEY (`from`) REFERENCES `users`(`id`) ON DELETE CASCADE; 
ALTER TABLE `user_message` ADD FOREIGN KEY (`to`) REFERENCES `users`(`id`) ON DELETE CASCADE; 
ALTER TABLE `user_message` ADD FOREIGN KEY (`aiid`) REFERENCES `ally`(`id`) ON DELETE CASCADE;

ALTER TABLE `user_passrecover` ADD FOREIGN KEY (`usrid`) REFERENCES `users`(`id`) ON DELETE CASCADE;

ALTER TABLE `user_research` ADD FOREIGN KEY (`id_res`) REFERENCES `t_research`(`id`) ON DELETE CASCADE; 
ALTER TABLE `user_research` ADD FOREIGN KEY (`usr`) REFERENCES `users`(`id`) ON DELETE CASCADE;

UPDATE `conf` SET `sge_ver` = '120' WHERE `sge_ver` = '119';