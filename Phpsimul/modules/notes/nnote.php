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


if(isset($_POST['envoyer']) )
{ // debut if message posté 

if(isset($_POST['sujet']) )     $sujet=$_POST['sujet'];
else      $sujet="";
if(isset($_POST['Choo']) )      $choo=$_POST['Choo'];
else      $choo="";
if(isset($_POST['mess']) )      $text=$_POST['mess'];
else      $text="";

$correct = 1 ;

} // fin if message posté
###########################################################################################
if(@$correct == 1) // si le message posté est correct on enregistre dans sql
{ // debut if correct
mysql_query("INSERT INTO phpsim_note SET iduser='".$userid."',priorite='".$choo."',message='".addslashes($text)."',
             sujet='".addslashes($sujet)."'") OR die(mysql_error());

$tpl->value('error', 'La note a bien été créer<br><br>');
$page = $tpl->construire('notes/nnote');

} // fin if correct
###########################################################################################
else // si rien a été demandé on affiche la demande de message
{

$tpl->value('error', '');
$page = $tpl->construire('notes/nnote');

}

?>