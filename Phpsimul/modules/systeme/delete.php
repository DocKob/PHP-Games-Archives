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

$sql->query("DELETE FROM phpsim_users WHERE id='".$userrow["id"]."'");

$test = $userrow["bases"];
$test2 = explode(",", $test);

if(isset($test2[1])) {
    $sql->query("DELETE FROM phpsim_bases WHERE id IN (".$userrow["bases"].")");
}
else
{
    $sql->query("DELETE FROM phpsim_bases WHERE id='".$userrow["bases"]."'");
}

?>
