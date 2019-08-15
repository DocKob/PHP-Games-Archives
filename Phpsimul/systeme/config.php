<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr



Configuration des constantes du jeu

*/

// DEBUT CONFIGURATION CONNEXION SQL
	define('BDD_HOST', 'localhost'); // Host du serveur MySQL
	define('BDD_USER', 'nomdutilisateur'); // Nom d'utilisateur pour acceder a MySQL
	define('BDD_PASS', 'motdepasse'); // Mot de passe pour MySQL
	define('BDD_NOM', 'phpsimul'); // Nom de la base de données
// FIN CONFIGURATION CONNEXION SQL


// DEBUT CONFIGURATION TABLES - Ne pas toucher cette partie, vous planterez le jeu
	define('PREFIXE_TABLES', 'phpsim_'); // Prefixe pour la base de données

	define('TABLE_CONFIG', 'config'); // Configuration  Generale

	define('TABLE_USERS', 'users'); //  Joueurs
	define('TABLE_STAFF', 'staff'); //  Base des membres du Staff
	define('TABLE_BASES', 'bases'); // Base des joueurs

	define('TABLE_MENU', 'menu'); // Configuration Menu
	define('TABLE_RESSOURCES', 'ressources'); // Configuration Ressources

	define('TABLE_ALLIANCES', 'alliance'); // Alliances
	define('TABLE_ALLIANCES_CANDIDATURES', 'allicand'); // Candidatures postées
	define('TABLE_RANGS', 'rangs'); // Gestion des rangs a l'interieurs des alliances

	define('TABLE_BATIMENTS', 'batiments'); // Configuration Batiments
	define('TABLE_CHANTIER', 'chantier'); // Configuration Flottes
	define('TABLE_DEFENSES', 'defenses'); // Configuration Defenses
	define('TABLE_RECHERCHES', 'recherches'); // Configuration Recherches

	define('TABLE_AGENDA', 'agenda'); // Agenda Administration

	define('TABLE_MESSAGERIE', 'messagerie'); // Les messages des membres
	define('TABLE_CHAT', 'chat'); // La table des Chat
	define('TABLE_CONTACT', 'contact_admin'); // Les messages posté dans le formulaire de conecta admin
	define('TABLE_LIVREOR', 'livror'); // Le livre d'or

	define('TABLE_FORUMS', 'forums'); // Liste Forums
	define('TABLE_DISCUSSIONS', 'discussions'); // Les discussions dans les differents forum
	define('TABLE_POSTS', 'post'); // Les posts dans les differente discussion

	define('TABLE_SCREENS', 'screens'); // Configuration Screens
	define('TABLE_NEWS', 'news'); // Configurations News
	define('TABLE_MUSIQUE', 'musique'); // Configuration Musique

	define('TABLE_AMIS', 'listeamis'); // Gestion des amis de chaque joueurs
	define('TABLE_NOTES', 'note'); // Notes ecrite par les joueurs

	define('TABLE_UNITES', 'unites'); //  Les flottes en vol
// FIN CONFIGURATION TABLES - Ne pas toucher cette partie, vous planterez le jeu


// Definition des variables utile pour le jeu
define('CODE_CONNEXION_ADMIN', 'phpsimul'); // Lorsqu'un joueur se connecte sur l'administration mais qu'il n'est pas connecté sur le jeu, ce code lui est demander
define('TEMPS_PENDANT_LEQUEL_ON_EST_ACTIF', '120'); // Defini combien de temps un joueur est defini comme actif - En secondes





?>