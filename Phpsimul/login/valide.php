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


$verifrow = $sql->select1("SELECT valide FROM phpsim_users WHERE id='" . $_GET["id"] . "' LIMIT 1");

    if ($_GET["validecode"] == $verifrow) // On regarde si le code donn�e et bien le code de SQL
    {
        // On passe la code de validation a 1 pour valider le joueur
        $sql->update("UPDATE phpsim_users SET valide='1' WHERE id='" . $_GET["id"] . "'");
        
        // Si l'action s'est derouler avec succes, on connecte le joueur
        $_SESSION['idjoueur98765432100'] = $_GET["id"] ; // On cr�er la session
        header('location: ../index.php'); // On redirige 
        die();
    } 
    else // Le code est incorect
    {
        $page= $tpl->construire('valide_code_incorect');
    }


?>