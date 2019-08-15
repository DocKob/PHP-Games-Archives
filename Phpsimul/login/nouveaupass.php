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

// Si le formulaire a �t� envoy�
if(!empty($_POST['mail']) )
{ // debut if mail envoy�

$mailcount = $sql->select1("SELECT COUNT(id) FROM phpsim_users WHERE mail='" . $_POST['mail'] . "' LIMIT 1");
if ($mailcount < 1) // Dans le cas ou aucune ligne n'a �t� renvoy�
{
// On reaffiche la page en disant qu'il y a une erreur
$tpl->value('erreur' , 'Cet email n\'existe pas dans notre base de donn�es.');
$tpl->value('mail' , $_POST['mail']);
$page = $tpl->construire('login/nouveaupass');
} 
elseif($mailcount == 1) // Dans le cas ou une ligne a �t� renvoy�, on traite la demande
{ // debut elseif traitement mail

    $nouveaupass = rand(1111111111, 9999999999); // On cr�er un pass aleatoire
    $nouveaupass2 = md5($nouveaupass); // On crypte le pass en Md5
    
    // On enregistre le nouveau pass dans la base de donn�es
    $sql->update("UPDATE phpsim_users 
    									SET pass='" . $nouveaupass2 . "' 
    									WHERE mail='" . $_POST["mail"] . "'
    				  ");

// On recupere le login du joueur 
$login = $sql->select1("SELECT nom FROM phpsim_users WHERE mail='" . $_POST["mail"] . "' ");

// On met en place les valeur pour le mail
$to = $_POST["mail"]; // Destinataire du mail
$titre = $controlrow["nom"] . ' - Votre nouveau mot de passe'; // Le titre du mail
// Le message du mail
$message = '
Une op�ration de r�cup�ration de votre mot de passe � �t� lanc�e sur ' . $controlrow["nom"] . '.
Votre mot de passe a donc �t� chang�, voici vos nouveaux identifiants :

Nom d\'utilisateur : '.$login.'

Mot de passe : '.$nouveaupass.'

Nous vous conseillons vivement de changer votre mot de passe dans l\'onglet profil.

Diriger vous sur le site : '.$controlrow["url"].'.

A Bientot sur '.$controlrow['nom'].' Bonne journ�e ;)
';

// On envoye le mail
mail($to, $titre, $message);

$page = $tpl->construire('login/nouveaupass_envoyemail_ok');


} // fin elseif traitement mail



} // fin if form envoy�
else // Si le formulaire n'a pas �t� envoy�
{ 
$tpl->value('erreur' , '');
$tpl->value('mail' , '');
$page = $tpl->construire('login/nouveaupass');
}

?>