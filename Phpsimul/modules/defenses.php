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

lang("defenses");

include("classes/defenses.class.php");

$defenses = new defenses;

$basebatiments = $baserow["batiments"];
$userrecherches = $userrow["recherches"];

$niv2 = explode(",", $baserow["defenses"]);

$basedefenses = "0," . $baserow["defenses"];

$niv = explode(",", $basedefenses);

$necessaires = explode(",", $controlrow["defenses_necessaire"]);
$rchiffre = 0;
$texte = $lang["pasacces"]." <br><br>";
$acces = 1;
$nivbatiments = explode(",", "0," . $baserow["batiments"]);

include('classes/templates2.class.php');
$tpl2 = new Tpl;

$tpl2->fichier('templates/'.$userrow['template'].'/defenses.html');

while (isset($necessaires[$rchiffre])) {
    $test = explode("-", $necessaires[$rchiffre]);
    if ($nivbatiments[$test[0]] < $test[1]) {
        $acces = 0;
        $nbat = sql::select("SELECT nom FROM phpsim_batiments WHERE id='" . $test[0] . "'");
        $texte .= "&nbsp;&nbsp;&nbsp;- " . $nbat["nom"] . " ".$lang["niveau"]." " . $test[1] . ";<br>";
    }
    $rchiffre = $rchiffre + 1;
}

if ($acces == 0) {
    $page = $texte;
} else {

    if(!empty($baserow["defensesencours"])) {

        $maj = explode("_", $baserow["defensesencours"]);

        $time = time();
        $tempsecoule = $time - $maj[2];

        $tempsrestant = $maj[1] - $tempsecoule;

    if ($tempsrestant <= 0 && !empty($tempsrestant)) {
        $baserow["defenses"] = $defenses->fin_defenses($baserow["defenses"], $maj[0]);

        $baserow["defensesencours"] = "";

        sql::update("UPDATE phpsim_bases SET defensesencours='" . $baserow["defensesencours"] . "', defenses='" . $baserow["defenses"] . "' WHERE id='" . $baserow["id"] . "'");

        $basedefenses = "0," . $baserow["defenses"];

        $niv = explode(",", $basedefenses);

        $tempsrestant = 0;
    }
    }

    if (!empty($mod[1]) && !empty($_POST["nombre"]) && $_POST["nombre"] != 0) { // Format du champ : defenses_temps_timestamp
            $row = sql::select("SELECT * FROM phpsim_defenses WHERE id='" . $mod[1] . "' LIMIT 1");

        $nombrerestant = $_POST["nombre"];

        $basedefensesencours = $baserow["defensesencours"];

        $defensesencours = explode("_", $basedefensesencours);

        $defenses = $defensesencours[0];

        if(isset($defensesencours[1])) {
            $tempsrestant = $defensesencours[1];
        } else {
            $tempsrestant = 0;
        }

        if ($tempsrestant < 0) {
            $tempsrestant = 0;
        }

        if ($baserow["defensesencours"] == "") {
            $testnombre = 0;
        } else {
            $testnombre = 1;
        } while ($nombrerestant > 0) {
            if ($testnombre == 0) {
                $defenses .= $mod[1];
                $testnombre = 1;
            } else {
                $defenses .= "," . $mod[1];
            }

            $baserow["ressources"] = defenses::modif_ressources($baserow["ressources"], "-", $row["ressources"]);

            $tps = defenses::calculer_temps($row["tps"]);

            $temps = $tempsrestant + ($tps * $_POST["nombre"]);

            $nombrerestant = $nombrerestant - 1;
        }

        $timestamp = time();
        $txt = $defenses . "_" . $temps . "_" . $timestamp;
        $baserow["defensesencours"] = $txt;

        sql::update("UPDATE phpsim_bases SET defensesencours='" . $txt . "', ressources='" . $baserow["ressources"] . "' WHERE id='" . $baserow["id"] . "'");
        echo "<script>window.location.replace('index.php?mod=defenses'); </script>";
    }

    $niv = explode(",", $basedefenses);

    $defensesrow = explode(",", $basedefenses);

    $batquery = sql::query("SELECT * FROM phpsim_defenses WHERE race_".$userrow["race"]."='1' ORDER BY ordre");

    while ($batrow = mysql_fetch_array($batquery)) {
        if (!isset($niv[$batrow["id"]]) || $niv[$batrow["id"]] == 0) {
            $niveau = "";
        } else {
            $niveau = "( " . $niv[$batrow["id"]] . " disponibles )";
        }

        if(!isset($batrow["ressources_evo"])) {
            $batrow["ressources_evo"] = 0;
        }

        $ressourcespage = $defenses->afficher_ressources($batrow["ressources"], $batrow["ressources_evo"]);

        $temps = $defenses->calculer_temps($batrow["tps"]);

        $temps = $defenses->afficher_temps($temps);

        $lien = "<form method='post' action='index.php?mod=defenses|" . $batrow["id"] . "'><input type='text' size='8' name='nombre' value='0'><br><input type='submit' value='Envoyer'></form>";

        if (isset($niv[$batrow["id"]]) && $niv[$batrow["id"]] >= $batrow["niveau_max"] && $batrow["niveau_max"] != 0) {
            $lien = "<font color='red'>".$lang["nbmaxatteint"]."</font>";
        }


$necessaires = explode(",", $batrow["batiments"]);
$necessaires2 = explode(",", $batrow["recherches"]);
$rchiffre = 0;
$rchiffre2 = 0;
$texte = "<b>".$lang["ilvousmanque"]." </b><br>";
$accesb = 1;
$nivbatiments = explode(",", "0," . $basebatiments);
$nivrecherches = explode(",", "0," . $userrecherches);

while (isset($necessaires[$rchiffre])) {
    $test = explode("-", $necessaires[$rchiffre]);
    if ($nivbatiments[$test[0]] < $test[1]) {
        $accesb = 0;
        $nbat = sql::select("SELECT nom FROM phpsim_batiments WHERE id='" . $test[0] . "'");
        $texte .= "&nbsp;&nbsp;&nbsp;- " . $nbat["nom"] . " ".$lang["niveau"]." " . $test[1] . ";<br>";
    }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre = $rchiffre + 1;
}

while (isset($necessaires2[$rchiffre2])) {
    $test = explode("-", $necessaires2[$rchiffre2]);
    if ($nivrecherches[$test[0]] < $test[1]) {
        $accesb = 0;
        $nbat = sql::select("SELECT nom FROM phpsim_recherches WHERE id='" . $test[0] . "'");
        $texte .= "&nbsp;&nbsp;&nbsp;- " . $nbat["nom"] . " ".$lang["niveau"]." " . $test[1] . ";<br>";
    }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre2 = $rchiffre2 + 1;
}

$batrow["batiments"] = implode(",", $necessaires);
$batrow["recherches"] = implode(",", $necessaires2);



        $tpltheme[] = $userrow["template"];
        $tplimage[] = $batrow["image"];
        $tplnom[] = stripslashes(nl2br($batrow["nom"]));
        $tplniveau[] = $niveau;
        $tpldescription[] = stripslashes(nl2br($batrow["description"]));
		$tplressources[] = "<u>".$lang["ress"]."</u> : <br>".$ressourcespage;
		$tpltemps[] = "<u>".$lang["tps"]."</u> : ".$temps;
        $tpllien[] = $lien;
		$tplattaque[] = $batrow['attaque'];
		$tplcoque[] = $batrow['defense'];
		$tplbouclier[] = $batrow['bouclier'];
		
    if($accesb == 0 && $controlrow['voir_batiments_inaccessibles'] == 1) 
	{
        $tpltheme[] = $userrow["template"];
        $tplimage[] = $batrow["image"];
        $tplnom[] = stripslashes(nl2br($batrow["nom"]));
        $tplniveau[] = '';
        $tpldescription[] = stripslashes(nl2br($batrow["description"]));
		$tplressources[] = $texte;
		$tpltemps[] = '';
        $tpllien[] = '';
		$tplattaque[] = $batrow['attaque'];
		$tplcoque[] = $batrow['defense'];
		$tplbouclier[] = $batrow['bouclier'];
    }

    }

	$global = array('theme' => $tpltheme, 'image' => $tplimage, 'nom' => $tplnom, 'niveau' => $tplniveau, 'description' => $tpldescription,
	'ressources' => $tplressources, 'temps' => $tpltemps, 'lien' => $tpllien, 'attaque' => $tplattaque, 'coque' => $tplcoque,
	'bouclier' => $tplbouclier);
	$tpl2->assigntag('BALISE', '1', $global);
	
	$page = $tpl2->recuptpl();
	
}

if (!empty($baserow["defensesencours"])) {

    $affichagetemps = "<div id='construction'></div><script>construire('".$tempsrestant."'); </script>";

    $page .= "<table><tr><td align='center'><b>".$lang["enconstrucion"]." </b><br><br>".$lang["tprestant"]." " . $affichagetemps . "<br><br><select>";

    $affichage = explode(",", $maj[0]);

    $nombre = 0;

    while (isset($affichage[$nombre])) {

        if(empty($afficherrow[$affichage[$nombre]])) {
            $afficherrow[$affichage[$nombre]] = 0;
        }

        $afficherrow[$affichage[$nombre]] = $afficherrow[$affichage[$nombre]] + 1;

        $nombre = $nombre + 1;
    }


    $liste = sql::query("SELECT id,nom FROM phpsim_defenses ORDER BY id");

    while ($row = mysql_fetch_array($liste)) {
        if(isset($afficherrow[$row["id"]]) && $afficherrow[$row["id"]] > 0) {
        $page .= "<option>" . $row["nom"] . " : " . $afficherrow[$row["id"]] . "</option>";
        }
    }

    $page .= "</select></td></tr></table></center>";
}

?>