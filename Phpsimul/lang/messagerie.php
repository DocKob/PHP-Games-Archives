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

$lang["retour"] = "Retour";
$lang["pasdestinataire"] = "Vous n'avez pas �crit de destinataire !";
$lang["pastitre"] = "Vous n'avez pas �crit de titre !";
$lang["pasmessage"] = "Vous n'avez pas �crit de message !";
$lang["nomexistepas"] = "Ce nom d'utilisateur n'existe pas !";
$lang["bienenvoye"] = "Le message � bien �t� envoy� !";
$lang["appartientpas"] = "Erreur : Ce message ne vous appartient pas.";
$lang["sys"] = "Syst�me"; //nom de l'exp�diteur lorsqu'un message est envoy� par le syst�me (rapports...)
$lang["supprimer"] = "Supprimer";
$lang["repondre"] = "R�pondre";
$lang["redigermsg"] = "R�diger un message";
$lang["nomsg"] = "Aucun message";
$lang["delselection"] = "SUPPRIMER LES MESSAGES SELECTIONN�S";
$lang["dellus"] = "SUPPRIMER LUS";
$lang["titre"] = "Titre";
$lang["emetteur"] = "Emetteur";


?>