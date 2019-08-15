<?php

/*

Administration du jeu

Le Module v1.1 & v1.2 ont été concu par Stevenson

Nous voici maintenant en v1.3 totalement ré-écrit par Max485 pour une optimisation

Ce panneau permet de gerer les moderateurs et les administrateurs, il ont chacun des droits differents


PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeurs officiel: Camaris & Max485 & Khi3l
http://forum.epic-arena.fr

*/

// On demarre la session pour les connexions
@session_start();

// Desactive la fonction qui met les ' & " de partout
set_magic_quotes_runtime(0);

// On defini la constante permettant de pouvoir ouvrir les pages
define('PHPSIMUL_PAGES', 'PHPSIMULLL');

include('systeme/config.php'); // On inclue le fichier de configuration du jeu
include('classes/sql.class.php'); // On inclue la classes contenant les fonctions SQL
include('admin/fonctions.php'); // On inclue les fonction necessaire au fonctionnement du jeu

$sql = new sql; // On demarre la classe
$sql->connect(); // On se connecte au serveur SQL

// Dans le cas ou le joueur n'est pas connecté on le renvoye sur la page de log
if(empty($_SESSION['idadmin12345678900']) )
{
	include('admin/loginacces.php');
	die();
}

###################################################################

// Recupere les infos de l'admin
$userrow = $sql->select("SELECT nom,administrateur,fondateur, moderateur FROM ".PREFIXE_TABLES.TABLE_STAFF." WHERE id='" . $_SESSION['idadmin12345678900'] . "' ");




##############################################
## On recupere la config generale du jeu
$controlrow = cache_config('cache/controlrow');
##############################################


// On inclue le fichier qui permet de faire la structure HTML
include('admin/TPL_entete.php');

/*****************************************************************/
/* Gestion de l'inclusion des Mods */

@$mod = explode("|", $_GET['mod']); // On extrait les infos contenu dans Mod 

if ($mod[0] != '' && file_exists('admin/'.$mod[0] . '.php') ) 
{
	include('admin/'.$mod[0] . '.php');
} 
else 
{ 
	include('admin/default.php'); // Si aucun Mod n'est demandé on inclue le fichier par default
}
/*****************************************************************/

echo @$page; // On affiche le resultat des Mods

// On inclue le HTML de la fin de page 
include('admin/TPL_footer.php');


$sql->close(); // On ferme la base SQL










/*******************************************************\
Le Mod Administration a été créer a la base par Stevenson 
© PHPSimul - Sous license GPL (Projet de Camaris)
\*******************************************************/







?>

