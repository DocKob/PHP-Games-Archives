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



ModTechno

Créer par Nummi - Recoder par Max485 - Pour PHPSimul

Pour mettres des couleur dans les texte, voici le CSS

// Si la construction est realisé
.deja_construit { }

// Si fautobtenir la construction
.a_obtenir { }

// Pour les textes B ou T qui s'affiche devant pour savoir si c'est un bat ou une recherche
.color_requierement { }

*/

lang("listeconstructions");

$page = $cache->chercher($userrow['id'],"technos_joueurs",1);

if($page == 1) {

$page = "
<!-- Debut d'affichage des objets construction requis pour les batiments -->
<b><u><font size='+2'>".$lang["listec"]."</font></u></b>
<br><br><br>
";

//------------------------------------------------------------ AFFICHE LES BATIMENTS

$page.="
<table border='2' width='600'>
<tr><th colspan='2'>".$lang["batiments"]."</th></tr>
<tr><th><i>Nom</th><th><i>".$lang["necessite"]."</th></tr>";

$batquery = sql::query("SELECT * FROM phpsim_batiments WHERE race_".$userrow["race"]."='1' ORDER BY ordre");
while ($batrow = mysql_fetch_array($batquery)) {

$necessaires = explode(",", $batrow["batiments"]);
$necessaires2 = explode(",", $batrow["recherches"]);
$rchiffre = 0;
$rchiffre2 = 0;
$texte = "";
$nivbatiments = explode(",", "0," . $baserow["batiments"]);
$nivrecherches = explode(",", "0," . $userrow['recherches']);

while (isset($necessaires[$rchiffre])) {
	 $accesb = 1;
    $test = explode("-", $necessaires[$rchiffre]);
    if (@$nivbatiments[@$test[0]] < @$test[1]) { $accesb = 0; }
    if(!empty($test[0]) ) {
        $nbat = sql::select("SELECT nom FROM phpsim_batiments WHERE id='" . $test[0] . "'");
        $texte .= "- <a title='".$lang["rbat"]."'><span class='color_requierement'>[B]</span></a> 
                  <span class='".(($accesb == 0)?'a_obtenir':'deja_construit')."'>" . $nbat["nom"] . " (".$lang["niveau"]." " . $test[1] . ")<br></span>";
    } else { $texte.="<center>*</center>"; }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre = $rchiffre + 1;
}

while (isset($necessaires2[$rchiffre2])) {
	 $accesb = 1;
    $test = explode("-", $necessaires2[$rchiffre2]);
    if (@$nivrecherches[@$test[0]] < @$test[1]) {
        $accesb = 0;
        $nbat = sql::select("SELECT nom FROM phpsim_recherches WHERE id='" . $test[0] . "'");
        $texte .= "- <a title='".$lang["rtech"]."'><span class='color_requierement'>[T]</span></a>
                   <span class='".(($accesb == 0)?'a_obtenir':'deja_construit')."'> " . $nbat["nom"] . " (".$lang["niveau"]." " . $test[1] . ")<br></span>";
    }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre2 = $rchiffre2 + 1;
}

$batrow["batiments"] = implode(",", $necessaires);
$batrow["recherches"] = implode(",", $necessaires2);

$page.="<tr><td valign='top'>".$batrow["nom"]."</td><td>".$texte."</td></tr>";
}

$page.='</table>'."\n".'<!-- Fin d\'affichage des objet construction requis pour les batiments -->';




//------------------------------------------------------------AFFICHE LES RECHERCHES
$page.="
<br><br>
<table border='2' width='600'>
<tr><th colspan='2'>".$lang["technos"]."</th></tr>
<tr><th><i>Nom</th><th><i>".$lang["necessite"]."</th></tr>";

$batquery = sql::query("SELECT * FROM phpsim_recherches WHERE race_".$userrow["race"]."='1' ORDER BY ordre");
while ($batrow = mysql_fetch_array($batquery)) {

$necessaires = explode(",", $batrow["batiments"]);
$necessaires2 = explode(",", $batrow["recherches"]);
$rchiffre = 0;
$rchiffre2 = 0;
$texte = "";
$accesb = 1;
$nivbatiments = explode(",", "0," . $baserow["batiments"]);
$nivrecherches = explode(",", "0," . $userrow['recherches']);

while (isset($necessaires[$rchiffre])) {
	 $accesb = 1;
    $test = explode("-", $necessaires[$rchiffre]);
    if (@$nivbatiments[@$test[0]] < @$test[1]) { $accesb = 0; }
    if(!empty($test[0]) ) {
        $nbat = sql::select("SELECT nom FROM phpsim_batiments WHERE id='" . $test[0] . "'");
        $texte .= "- <a title='".$lang["rbat"]."'><span class='color_requierement'>[B]</span></a> 
                   <span class='".(($accesb == 0)?'a_obtenir':'deja_construit')."'>" . $nbat["nom"] . " (".$lang["niveau"]." " . $test[1] . ")<br></span>";
    } else { $texte.="<center>*</center>"; }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre = $rchiffre + 1;
}

while (isset($necessaires2[$rchiffre2])) {
	 $accesb = 1;
    $test = explode("-", $necessaires2[$rchiffre2]);
    if (@$nivrecherches[@$test[0]] < @$test[1]) {
        $accesb = 0;
        $nbat = sql::select("SELECT nom FROM phpsim_recherches WHERE id='" . $test[0] . "'");
        $texte .= "- <a title='".$lang["rtech"]."'><span class='color_requierement'>[T]</span></a> 
                   <span class='".(($accesb == 0)?'a_obtenir':'deja_construit')."'>" . $nbat["nom"] . " (".$lang["niveau"]." " . $test[1] . ")<br></span>";
    }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre2 = $rchiffre2 + 1;
}

$batrow["batiments"] = implode(",", $necessaires);
$batrow["recherches"] = implode(",", $necessaires2);

$page.="<tr><td valign='top'>".$batrow["nom"]."</td><td>".$texte."</td></tr>";
}

$page.='</table>'."\n".'<!-- Fin d\'affichage des objet construction requis pour les batiments -->';









//------------------------------------------------------------ AFFICHE LES UNITES
$page.="
<br><br>
<table border='2' width='600'>
<tr><th colspan='2'>".$lang["chantier"]."</th></tr>
<tr><th><i>Nom</th><th><i>".$lang["necessite"]."</th></tr>";

$batquery = sql::query("SELECT * FROM phpsim_chantier WHERE race_".$userrow["race"]."='1' ORDER BY ordre");
while ($batrow = mysql_fetch_array($batquery)) {

$necessaires = explode(",", $batrow["batiments"]);
$necessaires2 = explode(",", $batrow["recherches"]);
$rchiffre = 0;
$rchiffre2 = 0;
$texte = "";
$accesb = 1;
$nivbatiments = explode(",", "0," . $baserow["batiments"]);
$nivrecherches = explode(",", "0," . $userrow['recherches']);

while (isset($necessaires[$rchiffre])) {
	 $accesb = 1;
    $test = explode("-", $necessaires[$rchiffre]);
    if (@$nivbatiments[@$test[0]] < @$test[1]) { $accesb = 0; }
    if(!empty($test[0]) ) {
        $nbat = sql::select("SELECT nom FROM phpsim_batiments WHERE id='" . $test[0] . "'");
        $texte .= "- <a title='".$lang["rbat"]."'><span class='color_requierement'>[B]</span></a> 
                   <span class='".(($accesb == 0)?'a_obtenir':'deja_construit')."'>" . $nbat["nom"] . " (".$lang["niveau"]." " . $test[1] . ")<br></span>";
    } else { $texte.="<center>*</center>"; }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre = $rchiffre + 1;
}

while (isset($necessaires2[$rchiffre2])) {
	 $accesb = 1;
    $test = explode("-", $necessaires2[$rchiffre2]);
    if (@$nivrecherches[@$test[0]] < @$test[1]) {
        $accesb = 0;
        $nbat = sql::select("SELECT nom FROM phpsim_recherches WHERE id='" . $test[0] . "'");
        $texte .= "- <a title='".$lang["rtech"]."'><span class='color_requierement'>[T]</span></a>
                   <span class='".(($accesb == 0)?'a_obtenir':'deja_construit')."'> " . $nbat["nom"] . " (".$lang["niveau"]." " . $test[1] . ")<br></span>";
    }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre2 = $rchiffre2 + 1;
}

$batrow["batiments"] = implode(",", $necessaires);
$batrow["recherches"] = implode(",", $necessaires2);

$page.="<tr><td valign='top'>".$batrow["nom"]."</td><td>".$texte."</td></tr>";
}

$page.='</table>'."\n".'<!-- Fin d\'affichage des objet construction requis pour les batiments -->';










//------------------------------------------------------------ AFFICHE LES DEFENSES
$page.="
<br><br>
<table border='2' width='600'>
<tr><th colspan='2'>".$lang["def"]."</th></tr>
<tr><th><i>Nom</th><th><i>".$lang["necessite"]."</th></tr>";

$batquery = sql::query("SELECT * FROM phpsim_defenses WHERE race_".$userrow["race"]."='1' ORDER BY ordre");
while ($batrow = mysql_fetch_array($batquery)) {

$necessaires = explode(",", $batrow["batiments"]);
$necessaires2 = explode(",", $batrow["recherches"]);
$rchiffre = 0;
$rchiffre2 = 0;
$texte = "";
$nivbatiments = explode(",", "0," . $baserow["batiments"]);
$nivrecherches = explode(",", "0," . $userrow['recherches']);

while (isset($necessaires[$rchiffre])) {
	 $accesb = 1;
    $test = explode("-", $necessaires[$rchiffre]);
    if (@$nivbatiments[@$test[0]] < @$test[1]) { $accesb = 0; }
    if(!empty($test[0]) ) {
        $nbat = sql::select("SELECT nom FROM phpsim_batiments WHERE id='" . $test[0] . "'");
        $texte .= "- <a title='".$lang["rbat"]."'><span class='color_requierement'>[B]</span></a> 
                   <span class='".(($accesb == 0)?'a_obtenir':'deja_construit')."'>" . $nbat["nom"] . " (".$lang["niveau"]." " . $test[1] . ")<br></span>";
    } else { $texte.="<center>*</center>"; }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre = $rchiffre + 1;
$accesb = 1; 
}

while (isset($necessaires2[$rchiffre2])) {
	 $accesb = 1;
    $test = explode("-", $necessaires2[$rchiffre2]);
    if (@$nivrecherches[@$test[0]] < @$test[1]) {
        $accesb = 0;
        $nbat = sql::select("SELECT nom FROM phpsim_recherches WHERE id='" . $test[0] . "'");
        $texte .= "- <a title='".$lang["rtech"]."'><span class='color_requierement'>[T]</span></a>
                   <span class='".(($accesb == 0)?'a_obtenir':'deja_construit')."'> " . $nbat["nom"] . " (".$lang["niveau"]." " . $test[1] . ")<br></span>";
    }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre2 = $rchiffre2 + 1;
}

$batrow["batiments"] = implode(",", $necessaires);
$batrow["recherches"] = implode(",", $necessaires2);

$page.="<tr><td valign='top'>".$batrow["nom"]."</td><td>".$texte."</td></tr>";
}

$page.='</table><br>'."\n".'<!-- Fin d\'affichage des objets construction requis pour les batiments -->';







$cache->save($page, $userrow['id'],"technos_joueurs",1);

}


?>