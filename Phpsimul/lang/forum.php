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

$lang["accforum"] = "Accueil du forum";
$lang["nom"] = "Nom";
$lang["nbsujets"] = "Nb de sujets";
$lang["nbmsg"] = "Nb de messages";
$lang["derniermsg"] = "Dernier message";
$lang["index"] = "Index";
$lang["datesujet"] = "Date du sujet";
$lang["ttmsgauteur"] = "Titre du message, Auteur";
$lang["nbrep"] = "Nb de R�ponses";
$lang["derep"] = "Derni�re r�ponse";
$lang["auteur"] = "Auteur";
$lang["pasmsg"] = "Il n'y a aucun message dans cette section.";
$lang["epingle"] = "Epingl� :";
$lang["par"] = "par :";
$lang["postele"] = "Post� le";
$lang["reponse"] = "r�ponse";
$lang["par2"] = "Par";
$lang["norep"] = "Aucune r�ponse";
$lang["acc"] = "Accueil";
$lang["pasalli"] = "Pas d'alliance";
$lang["alli"] = "Alliance :";
$lang["pts"] = "Points :";
$lang["editer"] = "Editer";
$lang["retour"] = "Retour";
$lang["titre"] = "Titre :";
$lang["msg"] = "Message :";
$lang["bienenregistre"] = "Votre message s'est bien enregistr�.";
$lang["supprimer"] = "Etes vous sur de vouloir supprimer ce message ?";
$lang["pasdroitafficher"] = "Vous n'avez pas le droit d'afficher cette page !";
$lang["editpar"] = "�dit� par";


?>