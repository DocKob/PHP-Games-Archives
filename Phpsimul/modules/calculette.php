<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

// Ce mod a été concu par Tereur et optimisé par Max485

/*
Samedi 6 Septembre 2008 => Mod réecrit par Max485 pour l'utilisation du JS
	Permet d'effectuer des calculs sans actualiser la page = evite d'utiliser le serveur pour rien, gain de temps pour le calcule
*/




@$page .= $tpl->construire('calculette');



?>