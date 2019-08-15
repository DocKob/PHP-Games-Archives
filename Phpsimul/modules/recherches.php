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

error_reporting(0); // On cache les erreurs 

lang("laboratoire");

include("classes/recherches.class.php");

$rech = new recherche;

$basebatiments = $baserow["batiments"];
$userrecherches = $userrow["recherches"];

$niv2 = explode(",", $userrow["recherches"]);

$userrow["recherches"] = "0," . $userrow["recherches"];

$niv = explode(",", $userrow["recherches"]);

$necessaires = explode(",", $controlrow["recherches_necessaire"]);
$rchiffre = 0;
$texte = $lang["pasacces"]." <br><br>";
$acces = 1;
$nivbatiments = explode(",", "0," . $baserow["batiments"]);

include('classes/templates2.class.php');
$tpl2 = new Tpl;

$tpl2->fichier('templates/'.$userrow['template'].'/recherches.html');

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
} 
######################################################################################################
else 
{

if(!empty($userrow["rechercheencours"]))
{

$maj = explode("_", $userrow["rechercheencours"]);
$tempsecoule = time() - $maj[3];
$tempsrestant = $maj[2] - $tempsecoule;

###############################################
    if ($tempsrestant <= 0 && isset($maj[3])) {
        $row = sql::select("SELECT * FROM phpsim_recherches WHERE id='" . $maj[0] . "'");
        $nbre2 = $maj[0] - 1;
        $niv2[$nbre2] = $niv2[$nbre2] + 1;

        $userrow["rechercheencours"] = "";
        $userrow["recherches"] = implode(",", $niv2);

        $userrow["attaque_supplementaire"] = $userrow["attaque_supplementaire"] + $row["attaque_supplementaire"];
        $userrow["defense_supplementaire"] = $userrow["defense_supplementaire"] + $row["defense_supplementaire"];
		$userrow["bouclier_supplementaire"] = $userrow["bouclier_supplementaire"] + $row["bouclier_supplementaire"];
		$userrow["vitesse_supplementaire"] = $userrow["vitesse_supplementaire"] + $row["vitesse_supplementaire"];

        sql::update("UPDATE phpsim_users SET 
					attaque_supplementaire='".$userrow["attaque_supplementaire"]."', 
					defense_supplementaire='".$userrow["defense_supplementaire"]."',
					bouclier_supplementaire='".$userrow["bouclier_supplementaire"]."',
					vitesse_supplementaire='".$userrow["vitesse_supplementaire"]."',
					rechercheencours='" . $userrow["rechercheencours"] . "',
					recherches='" . $userrow["recherches"] . "'
					WHERE id='" . $userrow["id"] . "'");
		  
		  $cache->delete($userrow['id'],"technos_joueurs",1); // On supprime le caches des competences requise pour le remettre a jour

        echo "<script>window.location.replace('index.php?mod=recherches'); </script>";
    } 
###############################################
    elseif ($tempsrestant > 0 && $maj[3] != "") 
    {
        $userrow["rechercheencours"] = $maj[0] . "_" . $maj[1] . "_" . $tempsrestant . "_" . time();
        sql::update("UPDATE phpsim_users SET rechercheencours='" . $userrow["rechercheencours"] . "' WHERE id='" . $userrow["id"] . "'");
    }
    }
###############################################
    if (!empty($mod[1])) { // format du champ : id-ressources-tempsrestant-dernieremiseajour
        $row = sql::select("SELECT * FROM phpsim_recherches WHERE id='" . $mod[1] . "' LIMIT 1");

		if($row["niveau_max"] <= $niv[$mod[1]] && $row["niveau_max"] != 0 ) {
		die('<script>document.location.href="index.php?mod=recherches"</script>');
		}
		

######################################################################################################
// DEBUT FONCTION PERMETTANT DE SAVOIR SI LES RECHERCHES ET BATIMENTS NECCESSAIRE SONT BIEN PRESENTES

$necessaires = explode(",", $row["batiments"]);
$necessaires2 = explode(",", $row["recherches"]);
$rchiffre = 0 ;
$rchiffre2 = 0 ;
$accesb = 1 ;
$nivbatiments = explode(",", "0," . $basebatiments);
$nivrecherches = explode(",", "0," . $userrecherches);

while (isset($necessaires[$rchiffre])) {
    $test = explode("-", $necessaires[$rchiffre]);
    if (@$nivbatiments[$test[0]] < @$test[1]) {
        $accesb = 0;
    }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre = $rchiffre + 1;
}

while (isset($necessaires2[$rchiffre2])) {
    $test = explode("-", $necessaires2[$rchiffre2]);
    if (@$nivrecherches[$test[0]] < @$test[1]) {
        $accesb = 0;
    }
    $necessaires[$rchiffre] = implode("-", $test);
    $rchiffre2 = $rchiffre2 + 1;
}

if($accesb == 0) { 		die('<script>document.location.href="index.php?mod=recherches"</script>'); }

// FIN FONCTION PERMETTANT DE SAVOIR SI LES RECHERCHES ET BATIMENTS NECCESSAIRE SONT BIEN PRESENTES
######################################################################################################




        $aajouter = $rech->calculer_ressources($niv[$mod[1]], $row["ressources"], $row["ressources_evo"]);

        $baseressources = $rech->modif_ressources($baserow["ressources"], "-", $aajouter);

        $temps = $rech->calculer_temps($niv[$mod[1]], $row["tps"], $row["tps_evo"]);

        $timestamp = time();
        $txt = $mod[1] . "_" . $aajouter . "_" . $temps . "_" . $timestamp;
        $userrow["rechercheencours"] = $txt;

        sql::update("UPDATE phpsim_users SET rechercheencours='" . $txt . "' WHERE id='" . $userrow["id"] . "'");
        sql::update("UPDATE phpsim_bases SET ressources='" . $baseressources . "' WHERE id='" . $baserow["id"] . "'");
        echo "<script>window.location.replace('index.php?mod=recherches'); </script>";
    }
######################################################################################################
    $niv = explode(",", $userrow["recherches"]);

    $recherchesrow = explode(",", $userrow["recherches"]);

    $batquery = sql::query("SELECT * FROM phpsim_recherches WHERE race_".$userrow["race"]."='1' ORDER BY ordre");

    while ($batrow = mysql_fetch_array($batquery)) {
        if (!isset($niv[$batrow["id"]]) || $niv[$batrow["id"]] == 0) {
            $niveau = "";
        } else {
            $niveau = "( ".$lang["niveau"]." " . $niv[$batrow["id"]] . " )";
        }



// On demande la fonction permettant de calculé le nombres de ressources manquantes
$rm = $rech->ressources_manquantes($batrow);
$temps_avant_dispo = $rm['ressources_manquantes'] ;
$construction_impossible= $rm['construction_impossible'] ;




        $ressourcespage = $rech->afficher_ressources($batrow["ressources"], $batrow["ressources_evo"]);

        if(!isset($niv[$batrow["id"]]))
        {
		$niv[$batrow["id"]] = 0;
		}

        $temps = $rech->calculer_temps($niv[$batrow["id"]], $batrow["tps"], $batrow["tps_evo"]);

        $temps = $rech->afficher_temps($temps);

        $rechercheencours = explode("_", $userrow["rechercheencours"]);

        $lien = "&nbsp";

        if ($userrow["rechercheencours"] == "") // Si il ny a pas de recherches en cours
        { 
        
            $niveauaconstruire = $niv[$batrow["id"]] + 1;
            
        		if($niv[$batrow["id"]] >= $batrow["niveau_max"] && $batrow["niveau_max"] != 0) 
            {
                $lien = "<font color='red'>".$lang["nivmaxatteint"]."</font>";
            }
       		elseif(ereg("[1]",$construction_impossible) ) 
       		{ // si construction impossible contient un 1 alors on n'a pas les ressources suffisantes 
		  		$lien ="<font color='red'>".$lang["ressmanquantes"]."</font>";
        		}             
        		elseif ($niv[$batrow["id"]] < $batrow["niveau_max"] || $batrow["niveau_max"] == 0) 
            {
                $lien = "<a href='index.php?mod=recherches|" . $batrow["id"] . "'>
                         <font color='green'>".$lang["cniv"]." " . $niveauaconstruire . "</font></a>";
            } 
            


            
            
        } elseif ($rechercheencours[0] == $batrow["id"]) {

           $lien = "<div id='construction'></div><script>construire('".$rechercheencours[2]."'); </script>";

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




if($accesb == 1)
{
    $tplid[] = $batrow["id"];
    $tpltheme[] = $userrow["template"];
    $tplimage[] = $batrow["image"];
    $tplnom[] = stripslashes(nl2br($batrow["nom"]));
    $tplniveau[] = $niveau;
    $tpldescription[] = stripslashes(nl2br($batrow["description"]));
    $tplressources[] = "<u>".$lang["ress"]."</u> : <br>".$ressourcespage;
    $tpltemps[] = "<u>".$lang["tps"]."</u> : ".$temps;
    $tpllien[] = $lien;
    $tpltemps_avant_dispo[] = $temps_avant_dispo;
    
    $nombrelignes = $nombrelignes + 1;

}
elseif($accesb == 0 && $controlrow['voir_batiments_inaccessibles'] == 1) 
{
    $tplid[] = $batrow["id"];
    $tpltheme[] = $userrow["template"];
    $tplimage[] = $batrow["image"];
    $tplnom[] = stripslashes(nl2br($batrow["nom"]));
    $tplniveau[] = $niveau;
    $tpldescription[] = stripslashes(nl2br($batrow["description"]));
    $tplressources[] = $texte;
    $tpltemps[] = '';
    $tpllien[] = '';
    $tpltemps_avant_dispo[] = '';
    
    $nombrelignes = $nombrelignes + 1;

}



}

$global = array('id' => $tplid, 'theme' => $tpltheme, 'image' => $tplimage, 'nom' => $tplnom, 'niveau' => $tplniveau, 
'description' => $tpldescription, 'ressources' => $tplressources, 'temps' => $tpltemps, 'lien' => $tpllien,
'temps_avant_dispo' => $tpltemps_avant_dispo);
$tpl2->assigntag('BALISE', '1', $global);
	
$page = $tpl2->recuptpl();

if($nombrelignes <= 0) // Si il n'y a aucun batiments 
{

$page = "Vous n'avez plus de batiments à ajouter.<br><br><a href='index.php?mod=batiments'>Retour</a><br><br>";

}

  
    
    
}

?>