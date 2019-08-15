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



if($inscrit_total < $controlrow['inscription_total'])
{


$tpl->value('reglement', nl2br(stripslashes($controlrow['reglement']) ) );
$tpl->value('ageminipourjouer', $controlrow['agemin']);
$page = $tpl->construire('login/inscrire1');

}
else // Si le nombre d'inscription a été atteint
{

inscription_max_atteinte() ; // On demarre la fonction qui bloque les inscriptions

}


?>