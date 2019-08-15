-- Backup Version 1.3 de PHPimul

-- ETANT DONNÉE LA NOUVELLE CONFIGURATION DE LA TABLE CONFIG, CES CHAMPS SONT INUTILE
	-- Pour la configuration du message de bienvenue 
		--alter table phpsim_config add message_bienvenue_actif char(2) default "0";
		--alter table phpsim_config add message_bienvenue text;
		--alter table phpsim_config add titre_message_bienvenue varchar(500);

	-- Pour activer/desactiver le choix de la base de depart automatique, Elle est activer par default
		--alter table phpsim_config add base_de_depart_choisi_automatiquement char(2) default "1";

	-- Du au faite que le champ "fondateur" fait maintenant partie de la table phpsim_staff
	-- il n'a plus aucune raison de ce trouver dans la table des configuration
		--alter table phpsim_config drop fondateur;

	-- ajout du champ pour la version dans la config
		--insert into phpsim_config values ('version', '1.3');

-- Pour créer la table des administrateurs et moderateurs
CREATE TABLE phpsim_staff 
( 
	id int(255) NOT NULL auto_increment, 
	idjoueur varchar(50),  
	nom varchar(30) NOT NULL, 
	pass varchar(255) NOT NULL, 
	fondateur char(1) default '0',
	administrateur tinyint(1) NOT NULL default '0', 
	moderateur tinyint(1) NOT NULL default '0', 
	ip varchar(15) NOT NULL default '0', 
	time int(255) NOT NULL, 
	PRIMARY KEY (id) 
);
								  
-- Pour permettre de reconfigurer les admin la premiere fois on configure un compte par default
insert into phpsim_staff SET
						nom="admin",
						pass="21232f297a57a5a743894a0e4a801fc3",
						administrateur="1",
						fondateur="1",
						moderateur="1";

-- On supprime les truc de modo et admin de la table phpsim_users, car il servent plus non plus
alter table phpsim_users drop moderateur, drop administrateur;

-- Pour le champ de mise en forme du menu
alter table phpsim_menu add miseenforme char(1) default '1';
update phpsim_menu set miseenforme='0' where nom='Déconnection';

CREATE TABLE phpsim_chat 
(
	id INT(255) NOT NULL AUTO_INCREMENT,
	posteur INT(255) NOT NULL,
	date INT(255) NOT NULL,
	alliance TEXT,
	message VARCHAR(50),
	PRIMARY KEY (id)
);


-- Insertion des nouvelles entrées dans le menu et mise à jour des liens existants.
INSERT INTO phpsim_menu VALUES('30','Chat','chat',0,'0');
UPDATE phpsim_menu SET module='classement_joueur' WHERE module='classement';
UPDATE phpsim_menu SET module='stats_prod' WHERE module='productions';

-- On rajoute l'heure / jour dans le mod de contact de l'admin
alter table phpsim_contact_admin add time char(50) default '0';

-- on modifie le champ time pour les news
alter table phpsim_news change date date char(50);

-- Ajout du champ contenant le nombre de points allopass de l'utilisateur
ALTER TABLE phpsim_users ADD allopass INT(255) NOT NULL DEFAULT 0;

-- Ajout de la table contenant les codes allopass déjà utilisés. Cette table est nécéssaire pour éviter qu'un code ne puisse être utilisé plusieurs fois.
CREATE TABLE `phpsim_allopass` 
(
	`code` varchar(8) NOT NULL,
	PRIMARY KEY  (`code`)
);

-- Ajout du module allopass au menu
INSERT INTO `phpsim_menu` ( `id` , `nom` , `module` , `separateur` , `miseenforme` ) 
VALUES (
NULL , 'Allopass', 'allopass', '0', '0'
);

--  Ajout des champs pour les boucliers - Merci a Guerrier pour cette modif
alter table phpsim_chantier add bouclier int(255) NOT NULL default '0';
alter table phpsim_defenses add bouclier int(255) NOT NULL default '0';
alter table phpsim_unites add bouclier int(255) NOT NULL default '0';
alter table phpsim_recherches add bouclier_supplementaire int(5) NOT NULL default '0';
alter table phpsim_users add bouclier_supplementaire int(5) NOT NULL default '0';


-- Ajout de l'augmentation dsu facteur de production par allopass
alter table phpsim_users add allopass_facteur_production char(2);
alter table phpsim_users add allopass_facteur_production_temps char(100);


-- Pour l'ajout d'une recherche modifiant la vitesse - Merci Guerrier
alter table phpsim_users add vitesse_supplementaire int(5) NOT NULL default '0';
alter table phpsim_recherches add vitesse_supplementaire int(5) NOT NULL default '0';
