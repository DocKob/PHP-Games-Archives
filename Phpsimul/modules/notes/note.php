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


$nombre = 1 ;
$affnotes = ''; 

$c = mysql_query('SELECT * FROM phpsim_note where iduser="'.$userrow['id'].'" ') ;
while ($d = mysql_fetch_array ($c) ) 
{

$tpl->value('nombre', $nombre);
$tpl->value('sujet', $d['sujet']);
$tpl->value('idnote', $d['id']);

if ($d['priorite'] == "high") {
$tpl->value('priority', 'high');
}
elseif ($d['priorite'] == "medium") {
$tpl->value('priority', 'medium');
}
elseif ($d['priorite'] == "low") {
$tpl->value('priority', 'low');
}

$affnotes .= $tpl->construire('notes/note_aff');

$nombre++;

}

$tpl->value('afficher_notes', $affnotes);
if(empty($error) || @$error != 1) { $tpl->value('error', ''); } // Que dans le cas ou aucune erreur n'a été defini
$page = $tpl->construire('notes/note');










?>
