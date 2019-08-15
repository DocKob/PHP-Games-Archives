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

lang("races");

$nbrace = $mod[1];

@$page .= '
<a href="javascript:history.back();">Retour</a><br><br>
<font size="+1"><b>'.$lang["descrace"].' '.$controlrow["race_".$nbrace.""].'</b></font>
<br><br>
'.nl2br($controlrow["race_".$nbrace."_infos"]).'

';






?>