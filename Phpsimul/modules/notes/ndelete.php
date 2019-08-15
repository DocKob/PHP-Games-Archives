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

if(@$_GET['suppr'] == "OUI")
{

$sql->query("DELETE FROM phpsim_note WHERE id='".$_GET['note']."' and iduser='".$userrow['id']."' ");

$error = 1; // Permet de definir l'erreur pour l'affficher
$tpl->value('error', 'Votre note a bien été supprimée.<br><br>');

include('modules/notes/note.php');
}

elseif(@$_GET['suppr'] == "NON")
{
$error = 1; // Permet de definir l'erreur pour l'affficher
$tpl->value('error', 'Vous n\'avez pas supprimé la note.<br><br>');

include('modules/notes/note.php');
}

else // Dans le cas ou le joueur n'a pas encore tenté une confirmation on affiche le formulaire
{

$note = $sql->select1('select sujet from phpsim_note where id="'.$_GET['note'].'" and iduser="'.$userrow['id'].'" '); 

// Permet de redirigé lorsqu le joueur a voulu tenter du hack
if($note == '') { die('<script>document.location="?mod=notes/note"</script>'); }


$tpl->value('sujet_note', $note);
$tpl->value('idnote', $_GET['note']);

$delete = $tpl->construire('notes/ndelete');

$error = 1; // Permet de definir l'erreur pour l'affficher
$tpl->value('error', $delete);

include('modules/notes/note.php');

}



?>
