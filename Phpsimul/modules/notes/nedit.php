<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas �t� trouv�');
}

/* 

PHPsimul : Cr�ez votre jeu de simulation en PHP
Copyright (�) - 2007 - CAPARROS S�bastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

// On recupere l'id de la note a voir
$id = $_GET['note'];

// On recupere la note mais seulement si le joueur a demander une note lui appartennant
$d = $sql->select('SELECT * FROM phpsim_note where id="'.$id.'" and iduser="'.$userrow['id'].'" ') ;

// Dans le cas ou rien n'est retourn�, cela veut dire que le joueur a fait une tenta de hack, on redirige
if($d == '') 
{ 
die('<script>document.location="?mod=notes/note"</script>');
} 

$tpl->value('sujet', $d['sujet']);
$tpl->value('message', $d['message']);
$tpl->value('idnote', $d['id']);


// Pour selectionner la priorit� defini
if ($d['priorite'] == "high") {
$tpl->value('high', 'checked');
$tpl->value('medium', '');
$tpl->value('low', '');
}
elseif ($d['priorite'] == "medium") {
$tpl->value('high', '');
$tpl->value('medium', 'checked');
$tpl->value('low', '');
}
elseif ($d['priorite'] == "low") {
$tpl->value('high', '');
$tpl->value('medium', '');
$tpl->value('low', 'checked');
}

$page = $tpl->construire('notes/nedit');



?>