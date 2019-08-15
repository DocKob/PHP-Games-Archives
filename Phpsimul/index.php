<?php

/* PHPsimul : créez votre jeu de simulation en PHP
Copyright (C) 2007 CAPARROS Sébastien (Camaris)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA. */

$mt1 = microTime(); // Permet de definir le temps de chargement d'une page

// On demarre les sessions
@session_start();

// Si un fichier backup.sql existe ou un fichier backup.php on va pour l'executer
// Ou dans le cas d'une installation complete si aucun fichier de configuration existe on va pour le concevoir
if (file_exists('backup.sql') || !file_exists('systeme/config.php') || file_exists('backup.php') ) 
{
	include('install.php') ;
	exit();
}

// Pour bloquer les autres pages lorqu'on passe pas par l'index, evite les hack
define('passageobligerparindex','mrestpassezarindex');
define('PHPSIMUL_PAGES', 'PHPSIMULLL');

// On inclue les fichier utile au jeu et on demarres les classes associés
include('systeme/config.php'); // Configurations SQL et autres
include ('systeme/functions.php'); // Fonctions diverses

// On demarre la classe des templates
include('classes/templates.class.php');
define('ACTION_EN_COURS', 'jeu');
$tpl = new templates;

include('classes/cache.class.php'); // Pour permettre de faire des caches
$cache = new cache(); // Demarre la classes des caches

include ('classes/sql.class.php'); // Pour les actions SQL
$sql = new sql; // Classes pour le SQL
$sql->connect(); // Se connect au serveur SQL

include ('classes/compteur.class.php'); // Pour effectuer certains calcules
$compteurs = new compteur; // Demarre la classes des compteurs

$lang = array(); // On demarre le tableau pour les langues

############################################################################################################
### Ce bout de code permet de mettre en cache le tableau $controlrow ce qui evite une requte SQL en plus###

$controlrow = $cache->cache_config('cache/controlrow');

############################################################################################################

// Grace a ce code, les erreurs seront cachés, il est possible d'activer/désactiver ce code dans la configuration du jeu
if ($controlrow['cacher_erreurs'] == 1) error_reporting(0);


if ( isset($_SESSION['idjoueur']) && eregi('[0-9]', $_SESSION['idjoueur']) ) // Si la session est defini et quelle contient un id valide (= chiffre de 0 a 9)
{
	$userid = $_SESSION['idjoueur'];
	$userrow = $sql->select('SELECT * FROM phpsim_users WHERE id="'.$userid.'" ');
}
else // Si la session est vide alord on redirige pour se conecter
{
	die('<script>location="login/index.php";</script>');
}


// Enregistre dans les infos du joueurs son IP ainsi que l'heure de connexion
$sql->update('UPDATE phpsim_users SET time="'.time().'", ip="'.$_SERVER['REMOTE_ADDR'].'" WHERE id="'.$userrow['id'].'"');

// Fonction qui verifie si le jeu est ouvert et les infos du joueur 
tout_verifier($userrow, $controlrow, @$mod, $sql);

// On inclue les fichier qui necessite que les infos du joueurs soit presentes avants
include('modules/systeme/unites_arrivee.php'); // Inclue la classes des unites pour les calcul de combat lorsque les unites arrive
include('classes/base.class.php'); // Fichier permettant la gestion des bases du joueur
$bases = new base; // Demarre la classe des bases
define('TEMPLATE_USER', $userrow['template']); // On defini le template du joueur

##################################################
# On met en place tous ce qui conserne les bases #
$bases->select_base();
$baserow = $bases->maj();
##################################################


// On met en place certaines partie du template ici pour ne pas causer de bug
$tpl->value('theme', $userrow['template']);
##################################################################
### DEBUT Gestion des mods ###
/* Recupere ce que contient le tableau get mod  si la page est demandée dans la frame*/

$page = "";


	if (isset($_GET['mod']))
	{
		$mod = explode('|', $_GET['mod']);
	}
	else
	{
		$mod[0] = '';
	}

/* Test si le fichier demander existe dans quel cas on l'inclue comme mod */
	if ($mod[0] != '' && file_exists('modules/' . $mod[0] . '.php')) 
	{
		include('modules/' . $mod[0] . '.php');
	}
	else
	{
		include('modules/accueil.php'); // Si le fichier n'existe pas ca met le mod par default
	}

### FIN Gestion des mods ###
##################################################################

####### Commencement des templates #######

$adressepage = "http://".$_SERVER['SERVER_NAME'] .$_SERVER['PHP_SELF']; 
if ($_SERVER['QUERY_STRING'] != "")
{
	$adressepage .= "?".$_SERVER['QUERY_STRING'];
}

// Met en places les données du joueur
$tpl->value('titre_jeu', $controlrow['nom'] );
$tpl->value('ressources', $bases->afficher_ressources() );
$tpl->value('username', $userrow['nom']);
$tpl->value('userrace', $controlrow['race_'.$userrow['race']]);
$tpl->value('credits', $userrow['credits']); 
$tpl->value('allopass', $userrow['allopass']); 
$tpl->value('src_frame', $adressepage); 

// On crée les valeurs pour afficher les bases
$tpl->value('baseimage', $baserow['image']);
$tpl->value('formactionbases', $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
$tpl->value('selectbases',$bases->afficher_bases() );


// Ajout du logo de PHPSimul suivant si cela a été activé ou pas dans la config
if ($controlrow['logo'] == 1)
{
	$tpl->value('logo', $tpl->construire('logo'));
}
else
{
	$tpl->value('logo', ' ');
}

// Verifie si le jeu est ouvert ou pas, et donne un message au admin dans le cas ou il ne l'est pas
if ($controlrow['ouvert'] != 1)
{
	$tpl->value('avertissement', $tpl->construire('avertissement_jeu_fermer'));
}
else
{
	$tpl->value('avertissement', ' ');
}

// Construit le menu du jeu
$menu = menu();
$tpl->value('menu', $menu);

// Met en place la page
$tpl->value('page', $page);
$tpl->value('partenaires', $tpl->construire('partenaires'));


$tpl->value('nbconnect', $compteurs->nbconnect() );
$tpl->value('requetes_effectuees', $sql->compter() );

$tpl->value('version', $controlrow["version"]);



$sql->close(); // Ferme la connexion SQL


// Pour le calcule du temps de chargement
$tpl->value('temps_gen', round( DiffTime($mt1, microTime() ) , 4) );




// Construit la page finale
$page = $tpl->construire('principal');



// Compresse la page dans le cas ou la fonction est activé
if($controlrow['compression'] == 1) 
{
	ob_start('ob_gzhandler');
}



// Permet d'afficher ce que contient la variable page autrement dit, la page en elle meme
echo $page;
?>