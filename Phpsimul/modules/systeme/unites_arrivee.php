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

include("classes/unites_arrivee.class.php");

$fin = new unites_arrivee;

$query = $sql->query("SELECT * FROM phpsim_unites WHERE user_depart='" . $userrow["id"] . "' OR user_arrivee='" . $userrow["id"] . "'");

while ($row = mysql_fetch_array($query)) {
    if ($row["heure_arrivee"] <= time()) {
        if ($row["mission"] == 0) { // attaque
                $fin->mission0($row);
        } elseif ($row["mission"] == 1) { // retour
                $fin->mission1($row);
        } elseif ($row["mission"] == 2) { // coloniser
                $fin->mission2($row);
        } elseif ($row["mission"] == 3) { // transport
                $fin->mission3($row);
        }


    }
}

?>