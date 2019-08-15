<?php

// Pour bloquer les autres pages lorqu'on passe pas par l'index, evite les hack
define('PHPSIMUL_PAGES', 'PHPSIMULLL');

include("systeme/config_allopass.php");

echo $controlrow["allopass_securite"];

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
define('PHPSIMUL_PAGES', 'PHPSIMULLL');

// On inclue les fichier utile au jeu et on demarres les classes associés
include('systeme/config.php'); // Configurations SQL et autres
include ('systeme/functions.php'); // Fonctions diverses

include('classes/templates.class.php'); // Pour les affichage des templates
define('ACTION_EN_COURS', 'jeu'); // Permet de faire savoir a la classe qu'on se trouve sur le jeu
$tpl = new templates; // Classes des templates

include('classes/cache.class.php'); // Pour permettre de faire des caches
$cache = new cache(); // Demarre la classes des caches

include ('classes/sql.class.php'); // Pour les actions SQL
$sql = new sql; // Classes pour le SQL
$sql->connect(); // Se connect au serveur SQL

include ('classes/compteur.class.php'); // Pour effectuer certains calcules
$compteurs = new compteur; // Demarre la classes des compteurs

$lang = array();

function lang($nom, $fichier = '.') 
{

	global $lang;

	include($fichier.'/lang/'.$nom.'.php');

}

$mt1 = microTime(); // Permet de definir le temps de chargement d'une page

############################################################################################################
### Ce bout de code permet de mettre en cache le tableau $controlrow ce qui evite une requte SQL en plus###

$controlrow = $cache->cache_config('cache/controlrow');

############################################################################################################

// Grace a ce code, les erreurs seront cachés, il est possible d'activer/désactiver ce code dans la configuration du jeu
if ($controlrow['cacher_erreurs'] == 1) error_reporting(0);

if (empty($_SESSION['idjoueur98765432100'])) // Si la session est vide ou prend les cookies
{
	include('systeme/cookies.php'); // Le fichier contenant les fonction pour recuperer les cookies
	$userrow = checkcookies(); // La fonction renvoye le tableauSQL contenant toutes les infos du joueur

	$userid = $userrow["id"]; // On defini l'userid qui peut etre utile a certains endroit, qui date d'un ancien systeme de fonctionnement, ca serait bien de le virer, mais certains mod s'en servent
	$_SESSION['idjoueur98765432100'] = $userid ; // On defini la session
	$bases = explode(',', $userrow['bases']); // On extraits les bases du joueur
	$sql->update('UPDATE phpsim_users SET baseactuelle="'.$bases[0].'" WHERE id="'.$userid.'" '); // A la premiere connexion on remet la base de depart
}
elseif (isset($_SESSION['idjoueur98765432100']) && eregi('[0-9]', $_SESSION['idjoueur98765432100'])) // Si la session est defini on passe par la session
{
	$userid = $_SESSION['idjoueur98765432100'];
	$userrow = $sql->select('SELECT * FROM phpsim_users WHERE id="'.$userid.'" ');
}
else // Si il n'existe ni de cookies ni de session (on devrait jamais arrivé a cette endroit vu comment le code est fait, mais une protection en plus ca mange pas de pain
{
##########
	header('location: login/index.php');
###########
}

// Enregistre dans les infos du joueurs son IP ainsi que l'heure de connexion
$sql->update('UPDATE phpsim_users SET time="'.time().'", ip="'.$_SERVER['REMOTE_ADDR'].'" WHERE id="'.$userrow['id'].'"');

// Fonction qui verifie si le jeu est ouvert et les infos du joueur 
tout_verifier();

// On inclue les fichier qui necessite que les infos du joueurs soit presentes avants
include('modules/systeme/unites_arrivee.php'); // Inclue la classes des unites pour les calcul de combat lorsque les unites arrive
include('classes/base.class.php'); // Fichier permettant la gestion des bases du joueur
$bases = new base; // Demarre la classe des bases

##################################################
# On met en place tous ce qui conserne les bases #
$bases->select_base();
$baserow = $bases->maj();
##################################################


// On met en place certaines partie du template ici pour ne pas causer de bug
$tpl->value('theme', $userrow['template']);

##################################################################













//DEBUT PARTIE ALLOPASS

$RECALL = $_GET["RECALL"];

if( trim($RECALL) == "" )
{
	echo "<script>window.location.replace('index.php?mod=allopass&erreur=codeinvalide'); </script>";
	exit(1);
}

$RECALL = urlencode( $RECALL );
$AUTH = urlencode( $controlrow["allopass_identifiant"] );
$r = @file( "http://www.allopass.com/check/vf.php4?CODE=$RECALL&AUTH=$AUTH" );

if( substr( $r[0],0,2 ) != "OK" ) 
{
	echo "<script>window.location.replace('index.php?mod=allopass&erreur=codeinvalide'); </script>";
	exit(1);
}

$derreq = mysql_query("SELECT code FROM phpsim_allopass WHERE code='".$_GET["RECALL"]."'");

if(mysql_num_rows($derreq) > 0)
{
	die("Ce code à déjà été utilisé.");
} 
else 
{
	mysql_query("INSERT INTO phpsim_allopass SET code='".$_GET["RECALL"]."'");
}

mysql_query("UPDATE phpsim_users SET allopass='".($userrow["allopass"] + $controlrow["allopass_points_par_achat"])."' WHERE id='".$userrow["id"]."'") OR die("Une erreur est survenue lors de l'ajout de vos points allopass Veuillez contacter l'administrateur au plus vite et lui indiquer l'ereu suivante : <br><br>".mysql_error());


$page =  "Votre achat à été réalisé avec succès. ";



//FIN PARTIE ALLOPASS










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
$tpl->value('src_frame', $adressepage); 
/* $tpl->value('points_allopass', $userrow['points_allopass']); */

// On crée les valeurs pour afficher les bases
$tpl->value('baseimage', $baserow['image']);
$tpl->value('formactionbases', $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
$tpl->value('selectbases',$bases->afficher_bases() );

if(@$_GET["miseenforme"] != 1)
{ // debut if miseenforme
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

	// Pour le calcule du temps de chargement
	$mt2 = microTime(); // permet de calculer le temps de chargement de la page
	$time = DiffTime($mt1, $mt2); // Le temps de chargement de la page est calculé grace a cette formule
	$tpl->value('temps_gen', round($time, 4) );

	$tpl->value('nbconnect', $compteurs->nbconnect() );
	$tpl->value('requetes_effectuees', $sql->compter() );

        $tpl->value('version', $controlrow["version"]);

	// Construit la page finale
	$page = $tpl->construire('principal');

} // fin if miseenforme

$sql->close(); // Ferme la connexion SQL

// Compresse la page dans le cas ou la fonction est activé
if($controlrow['compression'] == 1) 
{
	ob_start('ob_gzhandler');
}

// Permet d'afficher ce que contient la variable page autrement dit, la page en elle meme
echo $page;

?>