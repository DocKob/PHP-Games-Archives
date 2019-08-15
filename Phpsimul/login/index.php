<?php

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

// On demarre les sessions
@session_start();

// Pour bloquer les autres pages lorqu'on passe pas par l'index, evite les hack
define('PHPSIMUL_PAGES', 'PHPSIMULLL');

// Mise en place du systeme de template
include("../classes/templates.class.php");
define('ACTION_EN_COURS', 'login'); // Permet de faire savoir a la classe qu'on se trouve sur le login
$tpl = new templates;

// Connection au SQL
include('../systeme/config.php');
include ("../classes/sql.class.php");
$sql = new sql;
$sql->connect();

// Ouvre la classe des compteurs
include("../classes/compteur.class.php");
$compteurs = new compteur;

// On ouvre la classe des caches
include("../classes/cache.class.php");
$cache = new cache;

// On recupere le nombre d'inscrit
$inscrit_total = $sql->select1("SELECT COUNT(id) FROM phpsim_users ") ;


############################################################################################################
### Ce bout de code permet de mettre en cache le tableau $controlrow ce qui evite une requte SQL en plus###

$controlrow = $cache->cache_config('../cache/controlrow');

############################################################################################################


// Grace a ce code, les erreurs seront cachés, il est possible d'activer/désactiver ce code dans la configuration du jeu
if($controlrow['cacher_erreurs'] == 1) error_reporting(0);

// On commence a créer le template avec les valeurs neccessaire pour faire fonctionner les mod et tous
$tpl->value('theme', $controlrow["login_template"]);


##################################################################
### DEBUT Gestion des mods ###
/* Recupere ce que contient le tableau get mod */

if(isset($_GET['mod'])) 
{
    $mod = explode('|', $_GET['mod']);
} 
else 
{
    $mod[0] = '';
}

/* Test si le fichier demander existe dans quel cas on l'inclue comme mod */
if ($mod[0] != '' && file_exists($mod[0] . '.php')) 
{
    include($mod[0] . '.php');
} else {
    include('default.php'); // Si le fichier n'existe pas ca met le mod par default
}
### FIN Gestion des mods ###
##################################################################

####### Commencement des templates #######


// Construit le menu du jeu
if($controlrow["log_menu"] == 1) // Dans le cas ou le menu est activé
{
$menu = $tpl->construire('login/menu'); // On construit le menu qui se trouve dans le fichier
}
else // Dans le cas ou le menu est desactivé
{
$menu = '';
}
$tpl->value('menu', $menu);

// Ajout du logo de PHPSimul suivant si cela a été activé ou pas dans la config
if ($controlrow['logo'] == 1) { $tpl->value('logo', $tpl->construire('login/logo'));
} else  { $tpl->value('logo', ' '); }

// Met en place la page
$tpl->value('page', $page);
$tpl->value('partenaires', $tpl->construire('login/partenaires'));

$tpl->value('nbconnect', $compteurs->nbconnect());

// Construit la page finale
$pageentiere = $tpl->construire("login/principal");

$sql->close(); // On ferme la connexion SQL


echo $pageentiere;





function inscription_max_atteinte()
{
global $page ;
global $controlrow ;
global $tpl;

$tpl->value('nombre_max_joueurs', $controlrow['inscription_total']);

$page = $tpl->construire('login/inscription_max_atteinte');

}



?>