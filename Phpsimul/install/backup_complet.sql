-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net

--
-- Structure de la table 'phpsim_agenda'
--

DROP TABLE IF EXISTS phpsim_agenda;
CREATE TABLE IF NOT EXISTS phpsim_agenda (
  id int(250) NOT NULL auto_increment,
  `date` datetime NOT NULL,
  `type` tinyint(4) NOT NULL,
  titre varchar(250)  NOT NULL,
  contenu text  NOT NULL,
  date_tache date NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table 'phpsim_agenda'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_alliance'
--

DROP TABLE IF EXISTS phpsim_alliance;
CREATE TABLE IF NOT EXISTS phpsim_alliance (
  id int(11) NOT NULL auto_increment,
  nom varchar(100)  NOT NULL,
  tag varchar(100)  NOT NULL,
  adresse_forum varchar(100)  NOT NULL,
  texte text  NOT NULL,
  logo varchar(1000)  NOT NULL,
  id_rangs_default varchar(10)  default NULL,
  status varchar(750)  default NULL,
  texte_int text ,
  candidature varchar(10000)  default NULL,
  PRIMARY KEY  (id)
)  ;


--
-- Structure de la table 'phpsim_allicand'
--

DROP TABLE IF EXISTS phpsim_allicand;
CREATE TABLE IF NOT EXISTS phpsim_allicand (
  id int(250) NOT NULL auto_increment,
  idalli varchar(500)  NOT NULL,
  idjoueur char(10)  default NULL,
  textejoueurs varchar(10000)  default NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table 'phpsim_allicand'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_allopass'
--

DROP TABLE IF EXISTS phpsim_allopass;
CREATE TABLE IF NOT EXISTS phpsim_allopass (
  `code` varchar(8) NOT NULL,
  PRIMARY KEY  (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table 'phpsim_allopass'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_bases'
--

DROP TABLE IF EXISTS phpsim_bases;
CREATE TABLE IF NOT EXISTS phpsim_bases (
  id int(255) NOT NULL auto_increment,
  nom varchar(10)  NOT NULL default 'Pas de nom',
  utilisateur int(255) NOT NULL default '0',
  ordre_1 tinyint(10) NOT NULL default '0',
  ordre_2 tinyint(10) NOT NULL default '0',
  ordre_3 tinyint(10) NOT NULL default '0',
  ressources varchar(255)  NOT NULL default '',
  batiments varchar(255)  NOT NULL default '0,0,0,0,0',
  batimentencours varchar(255)  NOT NULL default '',
  energie int(255) NOT NULL default '0',
  energie_max int(255) NOT NULL default '0',
  productions varchar(255)  NOT NULL default '',
  derniere_mise_a_jour int(255) NOT NULL default '0',
  cases int(255) NOT NULL default '0',
  cases_max int(255) NOT NULL default '150',
  stockage varchar(255)  NOT NULL default '100000,100000',
  temps_diminution tinyint(5) NOT NULL default '0',
  image int(255) NOT NULL default '0',
  unites text  NOT NULL,
  unitesencours text  NOT NULL,
  map text  NOT NULL,
  defenses text NOT NULL,
  defensesencours text NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Contenu de la table 'phpsim_bases'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_batiments'
--

DROP TABLE IF EXISTS phpsim_batiments;
CREATE TABLE IF NOT EXISTS phpsim_batiments (
  id int(255) NOT NULL auto_increment,
  nom varchar(255)  NOT NULL default '',
  description text  NOT NULL,
  image int(255) NOT NULL default '0',
  tps int(255) NOT NULL default '0',
  tps_evo tinyint(10) NOT NULL default '0',
  ressources varchar(255)  NOT NULL default '',
  ressources_evo tinyint(10) NOT NULL default '0',
  niveau_max int(255) NOT NULL default '0',
  production varchar(255)  NOT NULL default '',
  production_evo tinyint(10) NOT NULL default '0',
  acces_module int(255) NOT NULL default '0',
  temps_diminution tinyint(10) NOT NULL default '0',
  stockageenplus varchar(255)  NOT NULL default '',
  points int(255) NOT NULL default '0',
  points_evo int(5) NOT NULL default '50',
  consommation int(255) NOT NULL default '0',
  consommation_evo tinyint(5) NOT NULL default '0',
  production_energie int(255) NOT NULL default '0',
  production_energie_evo tinyint(5) NOT NULL default '0',
  cases int(255) NOT NULL default '1',
  ordre int(255) NOT NULL,
  stockage varchar(255)  NOT NULL default '0,0',
  stockage_evo mediumint(5) NOT NULL default '0',
  batiments varchar(255)  NOT NULL,
  recherches varchar(255)  NOT NULL,
  race_1 tinyint(1) NOT NULL default '1',
  race_2 tinyint(1) NOT NULL default '1',
  race_3 tinyint(1) NOT NULL default '1',
  race_4 tinyint(1) NOT NULL default '1',
  race_5 tinyint(1) NOT NULL default '1',
  cases_en_plus char(10) default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table 'phpsim_batiments'
--

INSERT INTO phpsim_batiments (id, nom, description, image, tps, tps_evo, ressources, ressources_evo, niveau_max, production, production_evo, acces_module, temps_diminution, stockageenplus, points, points_evo, consommation, consommation_evo, production_energie, production_energie_evo, cases, ordre, stockage, stockage_evo, batiments, recherches, race_1, race_2, race_3, race_4, race_5, cases_en_plus) VALUES
(1, 'Mine de ressource1', 'Ce batiment produit des ressources nommées ressource1. ', 1, 12, 20, '200,100', 30, 25, '30,0', 12, 0, 0, '0', 5, 50, 100, 25, 100, 0, 1, 1, '0,0', 0, '', '', 1, 1, 1, 1, 1, '0'),
(2, 'Mine de ressources2', 'Ce batiment produit des ressources nommées ressources2.', 2, 62, 35, '23,30', 57, 20, '0,32', 56, 0, 52, '', 5, 50, 12, 12, 0, 0, 1, 2, '0,0', 0, '', '', 1, 1, 1, 1, 1, '0'),
(3, 'Producteur d`énergie', 'Ce batiment produit de l`énergie nommée energie1', 3, 234, 53, '12,9', 56, 75, '0,0', 56, 0, 0, '', 5, 50, 0, 0, 50, 32, 1, 3, '0,0', 0, '', '', 1, 1, 1, 1, 1, '0'),
(4, 'Diminueur de temps de construction.', 'Diminue le temps de construction de 50%.', 4, 300, 78, '5,6', 78, 0, '', 0, 0, 50, '', 10, 50, 0, 0, 0, 0, 1, 4, '0,0', 0, '', '', 1, 1, 1, 1, 1, '0'),
(5, 'Laboratoire de recherches', 'Permet l`accès au laboratoire de recherches.', 5, 543, 45, '20,15', 45, 78, '', 0, 3, 0, '', 10, 50, 0, 0, 0, 0, 1, 5, '0,0', 0, '4-2', '', 1, 1, 1, 1, 1, '0'),
(6, 'Chantier', 'Ce batiment permet de construire des unites et des defenses.', 6, 45, 78, '123,14', 42, 20, '0,0', 0, 0, 0, '', 58, 50, 5, 10, 0, 0, 1, 6, '0,0', 0, '5-1', '', 1, 1, 1, 1, 1, '0'),
(7, 'Hangar de ressource1', 'Pour stocker plus de ressource1', 7, 53, 75, '500,0', 0, 20, '', 0, 0, 0, '', 0, 50, 0, 0, 0, 0, 1, 7, '50000,0', 50, '1-1', '1-1', 1, 1, 1, 1, 1, '0'),
(8, 'Hangar de ressource2', 'Pour stocker plus de ressource2.', 8, 53, 75, '0,500', 0, 0, '', 0, 0, 0, '', 0, 50, 0, 0, 0, 0, 1, 8, '0,50000', 50, '7-1,2-1', '2-1', 1, 1, 1, 1, 1, '0'),
(9, 'Case+ Ultime', 'Ce batiment permet de concevoir des robots ultra perfectionner permettant d''agrandir la zone habitable de la planete.\r\n\r\nIl augmente la place disponible de 5 cases a chaque niveau.', 9, 172800, 1, '10000,10000', 1, 100, '0,0', 0, 0, 0, '', 1, 50, 0, 0, 0, 0, 1, 9, '0,0', 0, '4-10,5-10,7-5,1-3', '6-10', 1, 1, 1, 1, 1, '5');

-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_chantier'
--

DROP TABLE IF EXISTS phpsim_chantier;
CREATE TABLE IF NOT EXISTS phpsim_chantier (
  id int(255) NOT NULL auto_increment,
  nom varchar(255)  NOT NULL default '',
  description text  NOT NULL,
  image int(255) NOT NULL default '0',
  tps int(255) NOT NULL default '0',
  ressources varchar(255)  NOT NULL default '',
  niveau_max int(255) NOT NULL default '0',
  points int(255) NOT NULL default '0',
  attaque int(255) NOT NULL default '0',
  defense int(255) NOT NULL default '0',
  ordre int(255) NOT NULL,
  batiments varchar(255)  NOT NULL,
  recherches varchar(255)  NOT NULL,
  race_1 tinyint(1) NOT NULL default '1',
  race_2 tinyint(1) NOT NULL default '1',
  race_3 tinyint(1) NOT NULL default '1',
  race_4 tinyint(1) NOT NULL default '1',
  race_5 tinyint(1) NOT NULL default '1',
  stockage int(255) NOT NULL,
  bouclier int(255) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Contenu de la table 'phpsim_chantier'
--

INSERT INTO phpsim_chantier (id, nom, description, image, tps, ressources, niveau_max, points, attaque, defense, ordre, batiments, recherches, race_1, race_2, race_3, race_4, race_5, stockage, bouclier) VALUES
(1, 'Unité de combat', 'Cette unité permet d''attaquer une autre base. Vous pouvez en avoir jusqu''à 999.', 1, 37, '12,24', 999, 2, 5, 4, 1, '6-2', '', 1, 1, 1, 1, 1, 25, 0),
(2, 'Unité de transport', 'Pour transporter des ressources...', 2, 3, '2,4', 100, 5, 10, 10, 2, '4-1,6-7,7-1,8-1', '1-1,2-1', 1, 1, 1, 1, 1, 25000, 0),
(3, 'Unité d`espionnage', 'Pour espionner les autres joueurs', 3, 10, '1,0', 20, 1, 0, 1, 3, '6-8', '3-2', 1, 1, 1, 1, 1, 1, 0),
(4, 'Unité de l''infini', 'Ce vaisseaux n''a été devloppé que par la Race1\r\n\r\nAucunes autre race ne connait un vaisseaux aussi puissant et destructeur', 6, 604800, '1000000000,100000000', 20, 100, 10000000, 100000000, 4, '1-20,2-20,3-30,4-50,5-20,6-20,8-5', '4-20,5-20', 1, 0, 0, 0, 0, 2147483647, 0);

-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_chat'
--

DROP TABLE IF EXISTS phpsim_chat;
CREATE TABLE IF NOT EXISTS phpsim_chat (
  id int(255) NOT NULL auto_increment,
  posteur int(255) NOT NULL,
  `date` int(255) NOT NULL,
  alliance text,
  message varchar(50) default NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=316 ;

--
-- Contenu de la table 'phpsim_chat'
--

-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_config'
--

DROP TABLE IF EXISTS phpsim_config;
CREATE TABLE IF NOT EXISTS phpsim_config (
  config_name varchar(255) NOT NULL default '',
  config_value varchar(255) default NULL,
  PRIMARY KEY  (config_name)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table 'phpsim_config'
--

INSERT INTO phpsim_config (config_name, config_value) VALUES
('mail', 'Votre e-mail'),
('ouvert', '1'),
('nom', 'PHPSimul'),
('description', 'Voici la description eu jeu\r\n\r\nLe <b><u><i>HTML</b></u></i> et les Saut de lignes sont pris en compte'),
('verifmail', '0'),
('url', 'http:/phpsimul.epic-arena.fr/'),
('log_menu', '1'),
('maxnews', '5'),
('maxscreens', '10'),
('screensparligne', '3'),
('screenswidth', '160'),
('screensheight', '120'),
('reglement', 'Ici se trouvera votre règlement. Vous pourrez y insérer du code HTML\r\n\r\nLes sauts de ligne sont prit en compte'),
('agemin', '10'),
('logo', '1'),
('logo_log', '1'),
('rss', '1'),
('rss_log', '1'),
('icone', '1'),
('menu', '0'),
('menu_width', '15'),
('coordonnees_activees', '1'),
('ordre_1_active', '1'),
('ordre_1_max', '10'),
('ordre_2_max', '500'),
('ordre_3_max', '15'),
('ressourcesdepart', '5000,5000,0,0,0,0'),
('nom_bases', 'Base'),
('nom_cases', 'Cases'),
('cases_default', '65'),
('productiondepart', '100,100,0,0,0,0'),
('stockagedepart', '100000,100000,100000,100000,100000,100000'),
('recherches_necessaire', '5-1,4-1'),
('energies_default', '3-0-0'),
('batiments_default', '0,0,0,0,0,0,0,0,0,0,0,0,0'),
('recherches_default', '0,0,0,0,0,0,0,0,0,0,0,0'),
('energie_nom', 'Energie'),
('energie_activee', '1'),
('energie_default', '0'),
('chantier_necessaire', '6-1'),
('unites_default', '0,0,0,0,0,0,0,0,0,0,0,0'),
('unites_nom', 'Unités'),
('login_template', 'default'),
('temps_voyage', '10'),
('ressources_coloniser', '1000,1000'),
('bases_max', '9'),
('race_1', 'race1'),
('race_2', 'race2'),
('race_3', 'race3'),
('race_4', ''),
('race_5', ''),
('race_1_theme', 'default'),
('race_2_theme', 'default'),
('race_3_theme', 'default'),
('race_4_theme', ''),
('race_5_theme', ''),
('maj', '1,2'),
('titre_lecteur_musique', 'Radio'),
('inscription_total', '1500'),
('vprofil_voirplanetes', '1'),
('vprofil_voirbatiments', '0'),
('vprofil_recherches', '0'),
('vprofil_flottes', '0'),
('vprofil_status', '1'),
('pointalli', '500'),
('race_1_infos', 'Description de la race 1'),
('race_2_infos', 'Description de la race 2'),
('race_3_infos', 'Description de la race 3'),
('race_4_infos', ''),
('race_5_infos', ''),
('tps_ordre_1', '5'),
('tps_ordre_2', '2'),
('carburant', '0,200'),
('points_mini', '100'),
('att_conquerir', '1'),
('cases_minimum_pour_colonisation', '2'),
('cases_maximum_pour_colonisation', '1000'),
('banque', '10000000000,9999925000,0'),
('valeurs', '1000,1500'),
('tps_echanges', '86400'),
('compression', '0'),
('defenses_default', '0,0,0'),
('defenses_necessaire', '6-3'),
('voir_batiments_inaccessibles', '0'),
('upload_avatars_actif', '1'),
('cacher_erreurs', '0'),
('message_bienvenue_actif', '0'),
('message_bienvenue', 'Bienvenue\r\n\rTous est permis !'),
('titre_message_bienvenue', 'Bienvenue nouveau joueur'),
('base_de_depart_choisi_automatiquement', '1'),
('allopass_actif', '1'),
('nom_points_allopass', 'PilouPoints'),
('description_breve', 'Moteur de Jeux en PHP'),
('version', '1.3');

-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_contact_admin'
--

DROP TABLE IF EXISTS phpsim_contact_admin;
CREATE TABLE IF NOT EXISTS phpsim_contact_admin (
  Id int(250) NOT NULL auto_increment,
  Pseudo varchar(20)  NOT NULL,
  Mail varchar(100)  NOT NULL,
  Message varchar(10000)  NOT NULL,
  `time` char(50) default '0',
  PRIMARY KEY  (Id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table 'phpsim_contact_admin'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_defenses'
--

DROP TABLE IF EXISTS phpsim_defenses;
CREATE TABLE IF NOT EXISTS phpsim_defenses (
  id int(255) NOT NULL auto_increment,
  nom varchar(255)  NOT NULL default '',
  description text  NOT NULL,
  image int(255) NOT NULL default '0',
  tps int(255) NOT NULL default '0',
  ressources varchar(255)  NOT NULL default '',
  niveau_max int(255) NOT NULL default '0',
  points int(255) NOT NULL default '0',
  attaque int(255) NOT NULL default '0',
  defense int(255) NOT NULL default '0',
  ordre int(255) NOT NULL,
  batiments varchar(255)  NOT NULL,
  recherches varchar(255)  NOT NULL,
  race_1 tinyint(1) NOT NULL default '1',
  race_2 tinyint(1) NOT NULL default '1',
  race_3 tinyint(1) NOT NULL default '1',
  race_4 tinyint(1) NOT NULL default '1',
  race_5 tinyint(1) NOT NULL default '1',
  bouclier int(255) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table 'phpsim_defenses'
--

INSERT INTO phpsim_defenses (id, nom, description, image, tps, ressources, niveau_max, points, attaque, defense, ordre, batiments, recherches, race_1, race_2, race_3, race_4, race_5, bouclier) VALUES
(1, 'Defense1', 'Défense faible, mais peu couteuse.', 0, 10, '10,12', 10000, 1, 3, 2, 1, '', '', 1, 1, 1, 1, 1, 0),
(2, 'Defense2', 'Défense beaucoup plus puissante, mais également beaucoup plus chère.', 0, 600, '10000,12000', 100, 600, 123, 100, 2, '', '', 1, 1, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_discussions'
--

DROP TABLE IF EXISTS phpsim_discussions;
CREATE TABLE IF NOT EXISTS phpsim_discussions (
  id int(11) NOT NULL auto_increment,
  message text  NOT NULL,
  pseudo varchar(30)  NOT NULL default '',
  titre varchar(30)  NOT NULL default '',
  `date` varchar(25)  NOT NULL default '',
  forum_id int(11) NOT NULL default '0',
  message_id int(11) NOT NULL default '0',
  edit varchar(255)  NOT NULL default '',
  mb_id int(11) NOT NULL default '0',
  mail tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (id),
  KEY mb_id (mb_id),
  KEY message_id (message_id),
  KEY forum_id (forum_id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Contenu de la table 'phpsim_discussions'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_forums'
--

DROP TABLE IF EXISTS phpsim_forums;
CREATE TABLE IF NOT EXISTS phpsim_forums (
  id int(255) NOT NULL default '0',
  nom varchar(255)  NOT NULL default '',
  description varchar(255)  NOT NULL default '',
  dernier varchar(255)  NOT NULL default 'Pas de messages',
  alliance int(255) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table 'phpsim_forums'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_listeamis'
--

DROP TABLE IF EXISTS phpsim_listeamis;
CREATE TABLE IF NOT EXISTS phpsim_listeamis (
  id int(11) NOT NULL auto_increment,
  sender int(11) NOT NULL default '0',
  owner int(11) NOT NULL default '0',
  active tinyint(3) NOT NULL default '0',
  `text` text,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table 'phpsim_listeamis'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_livreor'
--

DROP TABLE IF EXISTS phpsim_livreor;
CREATE TABLE IF NOT EXISTS phpsim_livreor (
  id int(11) NOT NULL auto_increment,
  pseudo varchar(255) NOT NULL,
  message text NOT NULL,
  `date` varchar(10000) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Contenu de la table 'phpsim_livreor'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_menu'
--

DROP TABLE IF EXISTS phpsim_menu;
CREATE TABLE IF NOT EXISTS phpsim_menu (
  id int(2) NOT NULL auto_increment,
  nom varchar(255)  NOT NULL default '',
  module varchar(255)  NOT NULL default '',
  separateur tinyint(1) NOT NULL default '0',
  miseenforme char(1) default '1',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

--
-- Contenu de la table 'phpsim_menu'
--

INSERT INTO phpsim_menu (id, nom, module, separateur, miseenforme) VALUES
(1, 'Accueil', 'accueil', 0, '1'),
(2, 'Batiments', 'batiments', 0, '1'),
(4, 'Recherches', 'recherches', 0, '1'),
(14, 'Messagerie', 'messagerie', 0, '1'),
(17, 'Règlement', 'reglement', 0, '1'),
(27, 'Déconnection', 'logout', 0, '0'),
(21, 'Profil', 'profil', 0, '1'),
(5, 'Chantier Spacial', 'chantier', 0, '1'),
(13, 'Classements', 'classement_joueurs', 0, '1'),
(8, 'Carte', 'map', 0, '1'),
(3, 'Ressources', 'stats_prod', 0, '1'),
(9, 'Alliance', 'alliances/alliance', 0, '1'),
(24, 'Contact', 'contact', 0, '1'),
(12, 'Notes', 'notes/note', 0, '1'),
(16, 'Forum', 'forum', 0, '1'),
(18, 'RecherchesJ', 'search', 0, '1'),
(20, 'Amis', 'listeamis', 0, '1'),
(23, 'Piloris', 'piloris', 0, '1'),
(10, 'Flottes', 'coordonnees', 0, '1'),
(19, 'Techno', 'technologie', 0, '1'),
(22, 'Marchand', 'commerce', 0, '1'),
(11, 'Defenses', 'defenses', 0, '1'),
(26, 'Livre d''or', 'livreor', 0, '1'),
(96, 'Chat', 'chat', 0, '1'),
(103, 'Allopass', 'allopass', 0, '0');

-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_messagerie'
--

DROP TABLE IF EXISTS phpsim_messagerie;
CREATE TABLE IF NOT EXISTS phpsim_messagerie (
  id int(11) NOT NULL auto_increment,
  titre varchar(80)  NOT NULL default '',
  message text  NOT NULL,
  `date` int(255) NOT NULL default '0',
  emetteur int(255) NOT NULL default '0',
  destinataire int(255) NOT NULL default '0',
  statut tinyint(1) NOT NULL default '1',
  systeme tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=197 ;

--
-- Contenu de la table 'phpsim_messagerie'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_musique'
--

DROP TABLE IF EXISTS phpsim_musique;
CREATE TABLE IF NOT EXISTS phpsim_musique (
  id tinyint(4) unsigned NOT NULL auto_increment,
  titre varchar(30)  NOT NULL,
  extension varchar(7)  NOT NULL,
  nom varchar(30)  NOT NULL,
  artiste varchar(30)  NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table 'phpsim_musique'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_news'
--

DROP TABLE IF EXISTS phpsim_news;
CREATE TABLE IF NOT EXISTS phpsim_news (
  id int(255) NOT NULL auto_increment,
  titre varchar(255)  NOT NULL default '',
  texte text  NOT NULL,
  `date` char(50) default NULL,
  rss tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table 'phpsim_news'
--

INSERT INTO phpsim_news (id, titre, texte, date, rss) VALUES
(17, 'PHPSimul - v1.3 - Bienvenue', 'Bienvenue sur la version v1.3 de PHPSimul', '1213599528', 1);

-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_note'
--

DROP TABLE IF EXISTS phpsim_note;
CREATE TABLE IF NOT EXISTS phpsim_note (
  id int(255) unsigned NOT NULL auto_increment,
  iduser int(255) NOT NULL,
  sujet varchar(25)  NOT NULL,
  priorite varchar(10)  NOT NULL,
  message text ,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Contenu de la table 'phpsim_note'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_posts'
--

DROP TABLE IF EXISTS phpsim_posts;
CREATE TABLE IF NOT EXISTS phpsim_posts (
  id int(11) NOT NULL auto_increment,
  pseudo varchar(30)  NOT NULL default '',
  titre varchar(30)  NOT NULL default '',
  `date` varchar(25)  NOT NULL default '',
  forum_id int(11) NOT NULL default '0',
  `type` varchar(11)  NOT NULL default 'N',
  mb_id int(11) NOT NULL default '0',
  rep bigint(14) NOT NULL default '0',
  nbrep int(11) NOT NULL default '0',
  lp_mb_id varchar(11)  NOT NULL default '',
  lp_pseudo varchar(30)  NOT NULL default '',
  lp_titre varchar(30)  NOT NULL default '',
  PRIMARY KEY  (id),
  KEY forum_id (forum_id,mb_id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Contenu de la table 'phpsim_posts'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_rangs'
--

DROP TABLE IF EXISTS phpsim_rangs;
CREATE TABLE IF NOT EXISTS phpsim_rangs (
  id tinyint(4) NOT NULL auto_increment,
  nom varchar(50)  default NULL,
  admin varchar(20)  default NULL,
  idalli varchar(20)  default NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table 'phpsim_rangs'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_recherches'
--

DROP TABLE IF EXISTS phpsim_recherches;
CREATE TABLE IF NOT EXISTS phpsim_recherches (
  id int(255) NOT NULL auto_increment,
  nom varchar(255)  NOT NULL default '',
  description text  NOT NULL,
  image int(255) NOT NULL default '0',
  tps int(255) NOT NULL default '0',
  tps_evo tinyint(10) NOT NULL default '0',
  ressources varchar(255)  NOT NULL default '',
  ressources_evo tinyint(10) NOT NULL default '0',
  niveau_max int(255) NOT NULL default '0',
  points int(255) NOT NULL default '0',
  points_evo int(5) NOT NULL default '50',
  ordre int(255) NOT NULL,
  batiments varchar(255)  NOT NULL,
  recherches varchar(255)  NOT NULL,
  race_1 tinyint(1) NOT NULL default '1',
  race_2 tinyint(1) NOT NULL default '1',
  race_3 tinyint(1) NOT NULL default '1',
  race_4 tinyint(1) NOT NULL default '1',
  race_5 tinyint(1) NOT NULL default '1',
  defense_supplementaire int(5) NOT NULL default '0',
  attaque_supplementaire varchar(5)  NOT NULL default '0',
  bouclier_supplementaire int(5) NOT NULL default '0',
  vitesse_supplementaire int(5) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table 'phpsim_recherches'
--

INSERT INTO phpsim_recherches (id, nom, description, image, tps, tps_evo, ressources, ressources_evo, niveau_max, points, points_evo, ordre, batiments, recherches, race_1, race_2, race_3, race_4, race_5, defense_supplementaire, attaque_supplementaire, bouclier_supplementaire, vitesse_supplementaire) VALUES
(1, 'Recherche1', 'Nécéssaire à la construction du hangar de ressource1', 0, 12, 24, '300,132', 43, 5, 2, 50, 1, '', '', 1, 1, 1, 1, 1, 0, '0', 0, 0),
(2, 'Recherche2', 'Nécéssaire à la construction du hangar de ressource2', 0, 9, 45, '12,56', 75, 5, 20, 50, 2, '', '', 1, 1, 1, 1, 1, 0, '0', 0, 0),
(3, 'Espionnage', 'Pour créer des vaisseaux espion.', 0, 900, 127, '0,0', 0, 2, 0, 50, 3, '4-2,6-1', '', 1, 1, 1, 1, 1, 0, '0', 0, 0),
(4, 'Armement accrue', 'Augmente votre puissance d''attaque de 10% par niveau.', 0, 35, 78, '100,45', 56, 0, 50, 50, 4, '', '', 1, 1, 1, 1, 1, 0, '10', 0, 0),
(5, 'Défense accrue', 'Augmente votre défense de 10% par niveau', 0, 35, 78, '45,100', 56, 0, 50, 50, 5, '1-1', '', 1, 1, 1, 1, 1, 10, '0', 0, 0),
(6, 'Exploitation', 'Cette recherche permet d''exploité des zone inexploré de la planète et permet de libérer des espaces libre supplémentaire.', 0, 10800, 5, '1000,1000', 10, 1, 1, 50, 6, '5-7,4-3', '5-5', 1, 1, 1, 1, 1, 0, '0', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_ressources'
--

DROP TABLE IF EXISTS phpsim_ressources;
CREATE TABLE IF NOT EXISTS phpsim_ressources (
  id int(255) NOT NULL auto_increment,
  nom varchar(255)  NOT NULL default '',
  image int(255) NOT NULL default '0',
  PRIMARY KEY  (id)
)  ;

--
-- Contenu de la table 'phpsim_ressources'
--

INSERT INTO phpsim_ressources (id, nom, image) VALUES
(1, 'Ressource1', 1),
(2, 'Ressource2', 2);

-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_screens'
--

DROP TABLE IF EXISTS phpsim_screens;
CREATE TABLE IF NOT EXISTS phpsim_screens (
  id int(255) NOT NULL auto_increment,
  numero int(255) NOT NULL default '0',
  PRIMARY KEY  (id)
)  ;

--
-- Contenu de la table 'phpsim_screens'
--

INSERT INTO phpsim_screens (id, numero) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_staff'
--

DROP TABLE IF EXISTS phpsim_staff;
CREATE TABLE IF NOT EXISTS phpsim_staff (
  id int(255) NOT NULL auto_increment,
  idjoueur varchar(50) default NULL,
  nom varchar(30) NOT NULL,
  pass varchar(255) NOT NULL,
  fondateur char(1) default '0',
  administrateur tinyint(1) NOT NULL default '0',
  moderateur tinyint(1) NOT NULL default '0',
  ip varchar(15) NOT NULL default '0',
  `time` int(255) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table 'phpsim_staff'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_unites'
--

DROP TABLE IF EXISTS phpsim_unites;
CREATE TABLE IF NOT EXISTS phpsim_unites (
  user_depart int(255) NOT NULL default '0',
  id int(255) NOT NULL auto_increment,
  base_depart int(255) NOT NULL default '0',
  user_arrivee int(255) NOT NULL default '0',
  base_arrivee int(255) NOT NULL default '0',
  base_proprietaire int(255) NOT NULL default '0',
  unites text  NOT NULL,
  attaque int(255) NOT NULL default '0',
  defense int(255) NOT NULL default '0',
  ressources varchar(255)  NOT NULL default '',
  heure_arrivee int(255) NOT NULL default '0',
  tps_total int(255) NOT NULL default '0',
  mission tinyint(1) NOT NULL default '0',
  stockage int(255) NOT NULL,
  bouclier int(255) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Contenu de la table 'phpsim_unites'
--


-- --------------------------------------------------------

--
-- Structure de la table 'phpsim_users'
--

DROP TABLE IF EXISTS phpsim_users;
CREATE TABLE IF NOT EXISTS phpsim_users (
  id int(255) NOT NULL auto_increment,
  nom varchar(30)  NOT NULL default '',
  pass varchar(255)  NOT NULL default '',
  mail varchar(250)  NOT NULL default '',
  onlinetime date NOT NULL default '0000-00-00',
  valide varchar(60)  NOT NULL default '',
  banni tinyint(1) NOT NULL default '0',
  motifbanni varchar(255)  NOT NULL default 'Non banni',
  bases varchar(255)  NOT NULL default '',
  baseactuelle int(255) NOT NULL default '0',
  points double default NULL,
  recherches varchar(255)  NOT NULL default '',
  rechercheencours varchar(255)  NOT NULL default '',
  template varchar(255)  NOT NULL default 'default',
  race tinyint(1) NOT NULL default '1',
  `time` int(255) NOT NULL default '0',
  ip varchar(15)  NOT NULL,
  alli varchar(100)  NOT NULL,
  admin_alli varchar(100)  NOT NULL,
  candidature varchar(100)  NOT NULL,
  avatar varchar(1000)  default NULL,
  defense_supplementaire int(5) NOT NULL default '0',
  attaque_supplementaire int(5) NOT NULL default '0',
  multi varchar(255)  NOT NULL,
  multi2 varchar(255)  NOT NULL,
  signature varchar(255)  NOT NULL,
  messagerie_type tinyint(1) NOT NULL default '1',
  rangs varchar(10)  default '0',
  time_bannis int(11) default '0',
  credits varchar(255) NOT NULL default '0',
  dernier_achat int(255) NOT NULL,
  derniere_vente int(255) NOT NULL,
  dernier_calcul_points int(255) NOT NULL,
  points_bat double default NULL,
  points_rech double default NULL,
  points_unit double default NULL,
  allopass int(255) NOT NULL default '0',
  bouclier_supplementaire int(5) NOT NULL default '0',
  allopass_facteur_production char(2) default NULL,
  allopass_facteur_production_temps char(100) default NULL,
  vitesse_supplementaire int(5) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Contenu de la table 'phpsim_users'
--
