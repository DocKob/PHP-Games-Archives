<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
	die('Erreur 404 - Le fichier n\'a pas �t� trouv�');
}

/* 

PHPsimul : Cr�ez votre jeu de simulation en PHP
Copyright (�) - 2007 - CAPARROS S�bastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

$lang["pasacces"] = "Vous ne pouvez pas acc�der � cette page. Il vous faut les batiments suivants :";
$lang["niveau"] = "niveau";
$lang["nbmaxatteint"] = "Nombre maximal atteint";
$lang["ilvousmanque"] = "Il vous manque :";
$lang["ress"] = "Ressources";
$lang["tps"] = "Temps";
$lang["enconstruction"] = "en cours de construction :";
$lang["tprestant"] = "Temps restant :";


?>