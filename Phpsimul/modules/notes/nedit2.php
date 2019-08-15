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

if(isset($_POST['id']))      $id=$_POST['id'];
else      $id="";
if(isset($_POST['sujet']))     $sujet=$_POST['sujet'];
else      $sujet="";
if(isset($_POST['Choo']))      $choo=$_POST['Choo'];
else      $choo="";
if(isset($_POST['mess']))      $text=$_POST['mess'];
else      $text="";


mysql_query("UPDATE phpsim_note SET iduser='".$userid."',priorite='".$choo."',
             message='".addslashes($text)."',sujet='".addslashes($sujet)."' 
             WHERE id='".$id."' and iduser='".$userrow['id']."' ");


$error = 1; // Permet de definir l'erreur pour l'affficher
$tpl->value('error', 'Votre note a bien été mise a jour<br><br>');

include('modules/notes/note.php');

?>