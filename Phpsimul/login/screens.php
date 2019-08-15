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


$query = $sql->query('SELECT * FROM phpsim_screens ORDER BY id DESC LIMIT '.$controlrow['maxscreens']);


$nbligne = 0; // On créer la variable et on la met a 0
$affscreens = ''; // On demarre la variable pour ne pas generer une erreur

while ($screens = mysql_fetch_array($query) ) 
{

if($nbligne == $controlrow["screensparligne"]) // On change de ligne quand o arrive au max de screens par ligne defini
{
$ligne = '</tr><tr>'; // On met les ligne pour le template
$nbligne = 0;
}
else // Dans le cas ou on est pas arrivé encore au max de screens par ligne, alors on defini pour cacher la valeur dans le template
{
$ligne = '';
}

$tpl->value('ligne', $ligne);
$tpl->value('screennumero', $screens["numero"]);
$tpl->value('width', $controlrow["screenswidth"]);
$tpl->value('height', $controlrow["screensheight"]);

$affscreens .= $tpl->construire('login/screens_affscreens');

$nbligne++;
    
}

$tpl->value('affichage_screens', $affscreens);
$page = $tpl->construire('login/screens');


?>