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



// On créer la variable pour recuperer la note
$d = $sql->select('SELECT * FROM phpsim_note WHERE id="'.$_GET['note'].'" and iduser="'.$userrow['id'].'" ');

// Permet de redirigé lorsqu le joueur a voulu tenter du hack
if($d == '') { die('<script>document.location="?mod=notes/note"</script>'); }

$tpl->value('sujet', htmlentities(stripcslashes($d['sujet']) ) );
$tpl->value('message', nl2br(htmlentities(stripcslashes($d['message']) ) ) );
$page = $tpl->construire('notes/nvoir');


?>