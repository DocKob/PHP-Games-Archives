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

lang("messagerie");

if (empty($_POST["destinataire"])) {
    die($lang["pasdestinataire"]." <br><a href='javascript:history.back()'>".$lang["retour"]."</a>");
} elseif (empty($_POST["titre"])) {
    die($lang["pastitre"]." <br><a href='javascript:history.back()'>".$lang["retour"]."</a>");
}
if (empty($_POST["message"])) {
    die($lang["pasmessage"]." <br><a href='javascript:history.back()'>".$lang["retour"]."</a>");
} else {
    $query = mysql_query("SELECT id FROM phpsim_users WHERE nom='" . $_POST["destinataire"] . "'");
    if (mysql_num_rows($query) == 0) {
        die($lang["nomexistepas"]." <br><a href='javascript:history.back()'>".$lang["retour"]."</a>");
    }
    $row = mysql_fetch_array($query);
    $time = time();
    mysql_query("INSERT INTO phpsim_messagerie SET id='', titre='" . $_POST["titre"] . "', message='" . $_POST["message"] . "', date='" . $time . "', emetteur='" . $userrow["id"] . "', destinataire='" . $row["id"] . "'");
    include("modules/messagerie.php");
    $page = $lang["bienenvoye"]."<br><br>" . $page;
}

?>