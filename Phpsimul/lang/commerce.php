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

$lang["cbacheter"] = "Combien de ressources voulez vous acheter ?";
$lang["pasassezcredits"] = "Vous n'avez pas assez de cr�dits.";
$lang["retour"] = "Retour";
$lang["achatbieneffectue"] = "L'achat a bien �t� effectu�. Vous ne pourrez plus effectuer d'achat avant le";
$lang["cbvendre"] = "Combien de ressources voulez vous vendre ?";
$lang["credits"] = "cr�dits";
$lang["ventebieneffectuee"] = "La vente a bien �t� effectu�e. Vous ne pourrez plus effectuer de vente avant le";
$lang["commerceaccueil"] = "Bienvenue dans le module commerce. Ici, vous pourrez vendre vos ressources � la banque centrale<br>en �change de cr�dits et racheter des ressources gr�ce � ces memes cr�dits.";
$lang["quefaire"] = "Que voulez vous faire ?";
$lang["vouspossedez"] = "Vous poss�dez";
$lang["vendreress"] = "Vendre des ressources";
$lang["pasassezattendupourvendre"] = "Vous n'avez pas assez attendu pour refaire une vente. Vous devez attendre le";
$lang["acheterress"] = "Acheter des ressources";
$lang["pasassezattendupouracheter"] = "Vous n'avez pas assez attendu pour refaire un achat. Vous devez attendre le";

?>