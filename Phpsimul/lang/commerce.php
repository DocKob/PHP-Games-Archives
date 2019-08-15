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

$lang["cbacheter"] = "Combien de ressources voulez vous acheter ?";
$lang["pasassezcredits"] = "Vous n'avez pas assez de crédits.";
$lang["retour"] = "Retour";
$lang["achatbieneffectue"] = "L'achat a bien été effectué. Vous ne pourrez plus effectuer d'achat avant le";
$lang["cbvendre"] = "Combien de ressources voulez vous vendre ?";
$lang["credits"] = "crédits";
$lang["ventebieneffectuee"] = "La vente a bien été effectuée. Vous ne pourrez plus effectuer de vente avant le";
$lang["commerceaccueil"] = "Bienvenue dans le module commerce. Ici, vous pourrez vendre vos ressources à la banque centrale<br>en échange de crédits et racheter des ressources grâce à ces memes crédits.";
$lang["quefaire"] = "Que voulez vous faire ?";
$lang["vouspossedez"] = "Vous possédez";
$lang["vendreress"] = "Vendre des ressources";
$lang["pasassezattendupourvendre"] = "Vous n'avez pas assez attendu pour refaire une vente. Vous devez attendre le";
$lang["acheterress"] = "Acheter des ressources";
$lang["pasassezattendupouracheter"] = "Vous n'avez pas assez attendu pour refaire un achat. Vous devez attendre le";

?>