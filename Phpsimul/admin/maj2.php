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

$query = mysql_query("SELECT maj FROM phpsim_config WHERE id='1' LIMIT 1");
$control = mysql_fetch_array($query);

if(isset($_GET["ajout"])) {

$new = $control["maj"] . "," . $_GET["ajout"];

mysql_query("UPDATE phpsim_config SET maj='".$new."' WHERE id='1'");

}

echo "Mise a jour enregistrée.<br><br><a href='index.php?mod=maj'>Retour</a>";

?>