<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas �t� trouv�');
}

/* PHPsimul : Cr�ez votre jeu de simulation en PHP
Copyright (�) - 2007 - CAPARROS S�bastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

if(file_exists("modules/systeme/batiments2.php") ) // Dans le cas ou le mod batiment carte existe, on s'en sert
{
include("modules/systeme/batiments2.php");
}
else // dans le cas ou il a �t� supprim� depuis l'administration, ben on se sert de la liste
{
include("modules/systeme/batiments.php");
}

?>