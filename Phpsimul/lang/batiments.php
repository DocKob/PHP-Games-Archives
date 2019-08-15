<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
	die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* 

PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

$lang["niveaumaxbat"] = "Vous avez atteint le niveau maximal pour ce batiment.";
$lang["nivmaxbatatteint"] = "Le niveau maximal à été atteint.";
$lang["ressmanquantes"] = "Ressources manquantes"; //pour la liste des ressources manquantes à la construction
$lang["construireniv"] = "Construction du niveau "; //suivi d'un espace
$lang["nbrede"] = "Nombre de "; //nombre de (cases), suivi d'un espace ...
$lang["maxiatteint"] = " maximal atteint."; //... maximal atteint
$lang["ilvousmanque"] = "Il vous manque : "; // il vous manque (x ressources)
$lang["niveau"] = " niveau "; //"niveau", encadré d'espaces
$lang["plusdebatimentsaajouter"] = "Vous n'avez plus de batiments à ajouter.";
$lang["retour"] = "Retour";

?>