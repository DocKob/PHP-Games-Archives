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

$query = mysql_query("SELECT maj, url FROM phpsim_config WHERE id='1' LIMIT 1");
$control = mysql_fetch_array($query);

echo 'Bienvenue dans le module de mise � jour de phpsimul. Lorsque vous voudrez installer une mise � jour, vous devrez copier les fichiers extraits vers votre ftp, en �crasant les existants, puis �x�cuter les requetes du fichier sql.txt.<br><br><IFRAME SRC="http://phpsimul.epic-arena.fr/maj/index.php?sql='.$control["maj"].'&url='.$control["url"].'" NAME="iframe" HEIGHT="500" WIDTH="600"> 
</IFRAME>';

?>