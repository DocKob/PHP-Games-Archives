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

$lang["dejademande"] = "Il existe déjà une demande pour ce joueur";
$lang["demandeamis"] = "Demande d'amis";
$lang["joueur"] = "Joueur";
$lang["msg"] = "Message";
$lang["retour"] = "Retour";
$lang["pastoimeme"] = "Erreur: Tu ne peut pas t'envoyer une candidature a toi même";
$lang["mesdemandes"] = "Mes demandes";
$lang["autresdemandes"] = "Autres demandes";
$lang["listeamis"] = "Liste des amis";
$lang["demandes"] = "Demandes";
$lang["mesdemandes"] = "Mes demandes";
$lang["nom"] = "Nom";
$lang["alli"] = "Alliance";
$lang["coord"] = "Coordonnées";
$lang["pos"] = "Position";
$lang["txt"] = "Texte";
$lang["on"] = "On";
$lang["15min"] = "15 Min";
$lang["off"] = "Off";
$lang["anndem"] = "Annuler la demande";
$lang["accepter"] = "Accepter";
$lang["refuser"] = "Refuser";
$lang["suppr"] = "Supprimer";
$lang["listevide"] = "La liste est vide";


?>