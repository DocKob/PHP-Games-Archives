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

$lang["retour"] = "Retour";
$lang["pasdestinataire"] = "Vous n'avez pas écrit de destinataire !";
$lang["pastitre"] = "Vous n'avez pas écrit de titre !";
$lang["pasmessage"] = "Vous n'avez pas écrit de message !";
$lang["nomexistepas"] = "Ce nom d'utilisateur n'existe pas !";
$lang["bienenvoye"] = "Le message à bien été envoyé !";
$lang["appartientpas"] = "Erreur : Ce message ne vous appartient pas.";
$lang["sys"] = "Système"; //nom de l'expéditeur lorsqu'un message est envoyé par le système (rapports...)
$lang["supprimer"] = "Supprimer";
$lang["repondre"] = "Répondre";
$lang["redigermsg"] = "Rédiger un message";
$lang["nomsg"] = "Aucun message";
$lang["delselection"] = "SUPPRIMER LES MESSAGES SELECTIONNÉS";
$lang["dellus"] = "SUPPRIMER LUS";
$lang["titre"] = "Titre";
$lang["emetteur"] = "Emetteur";


?>