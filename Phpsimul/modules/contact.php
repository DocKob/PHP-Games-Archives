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

// On defnit le nom de la table contact
$table_contact = "phpsim_contact_admin";

$page = '';


$pseudo = $userrow["nom"];


/*********************************************************************************************/
/*********************************************************************************************/
/*********************************************************************************************/
/*********************************************************************************************/
/*********************************************************************************************/

if(@$_POST['formcontact'] == "formcontact") // Si le formulaire a été envoyer
{ // debut if si form envoyé


// On extrait ce que contient le tableau $_POST pour ne pas a avoir a rajouté quelque ligne de plus

extract($_POST);

// On transforme les " & ' en caracteres standard

$pseudo = mysql_real_escape_string($pseudo);
$mail = mysql_real_escape_string($mail);
$message = mysql_real_escape_string($message);


// On teste les champs savoir si c'est bon ou pas

if(empty($pseudo) or empty($mail) or empty($message) ) // Si un des champ n'est pas valide, il faut prevenir et renvoyer le formulaire
                                                     // Je connait pas de meilleurs moyen
{
if(empty($pseudo) ) $page .= '<h2><font color="FF0000">Merci d\'indiquez votre Pseudo</font></h2>';
if(empty($mail) ) $page .= '<h2><font color="FF0000">Merci d\'indiquez votre E-Mail</font></h2>';
elseif(!ereg("^.+@.+\\..+$",$mail))  $page .= '<h2><font color="FF0000">Votre e-mail n\'est pas valide</font></h2>';  // On test que l'email soit dans un format correct
if(empty($message) ) $page .= '<h2><font color="FF0000">Merci d\'indiquez votre Message</font></h2>';

AfficherForm();

}
elseif(!ereg("^.+@.+\\..+$",$mail))  // On test que l'email soit dans un format correct
{
$page .= '<h2><font color="FF0000">Votre e-mail n\'est pas valide</font></h2>';

AfficherForm();

unset($page_a_voir);
}
else // Si tous les champ sont rempli et correct on envoye le message dans la BDD
{
$new_message = "INSERT INTO ".$table_contact." (Id,Pseudo,Mail,Message)
                VALUES ('','".$pseudo."','".$mail."','".$message."')
               ";
               
mysql_query($new_message) or die('<h1><font color="FF0000">Erreur d\'envoye, Rééssayer plus tard<br>Merci</font></h1>');

$page .='<h2><font color="FF0000">Message envoyé</font></h2>';

unset($_POST);
AfficherForm();


}


} // fin if si form envoyé

else // Si le form n'a pas encore été envoyé
{
AfficherForm();
}


/*********************************************************************************************/
/*********************************************************************************************/
/*********************************************************************************************/
/*********************************************************************************************/
/*********************************************************************************************/


##### On met le formulaire dans une fonctions pour pouvoir le reaficher en cas d'erreur #####

Function AfficherForm()
{ // debut fonction afficher form

@extract($_POST); 

global $page;
global $pseudo;
global $tpl;

$tpl->value('pseudo', @$pseudo);
$tpl->value('mail', @$mail);
$tpl->value('message', @$message);

$page .= $tpl->construire('contact');

} // Fin fonction afficher form














?>


