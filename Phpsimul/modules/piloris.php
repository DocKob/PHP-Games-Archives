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

@$page.="<center><h2><u>Liste des joueurs bannis</u></h2>";

$c = mysql_query("SELECT * FROM phpsim_users WHERE banni='1' and (time_bannis='0' or time_bannis>".time().") ") ;
if(mysql_num_rows($c) > 0) // on test si une ligne est renvoy� sinon on marque que personne n'est bannis
{
$page .= "
<table border='1' width='450'><tr><th>Pseudo</th><th>Motif</th><th>Fin du blocage</th></tr>";

while ($d = mysql_fetch_array ($c)) {

$temps = ($d['time_bannis'] == 0)?'Banni � vie':date('d/m/Y \� H \H i',$d['time_bannis']) ;

$page.= "<td><center>".$d['nom']."</td><td><center>".$d['motifbanni']."</td><td><center>".$temps."</td></tr>";
}
$page .= " </table></center>" ;

}
else // aucun ligne renvoy� personne n'est bannis
{
@$page.="<h4>Personne n'a �t� banni.</h4>";
}
?>