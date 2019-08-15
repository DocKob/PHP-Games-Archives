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

lang("chantier");

// On met en place la classe pour le chantier
include('classes/chantier.class.php');
$chantier = new chantier;

include('classes/templates2.class.php');
$tpl2 = new Tpl;

$tpl2->fichier('templates/'.$userrow['template'].'/chantier.html');

// On met les valeur du tableau dans des variables, sinon pour une raison inconnu, ca plante
$basebatiments = $baserow['batiments'];
$userrecherches = $userrow['recherches'];

$niv2 = explode(',', $baserow['unites']);

$baseunites = '0,' . $baserow['unites'];

$niv = explode(',', $baseunites);

$necessaires = explode(',', $controlrow['chantier_necessaire']);
$rchiffre = 0;
$texte = $lang["pasacces"].' <br><br>';
$acces = 1;
$nivbatiments = explode(',', '0,' . $baserow['batiments']);


$tpltheme = Array();
$tplimage = Array();
$tplnom = Array();
$tplniveau = Array();
$tpldescription = Array();
$tplressources = Array();
$tpltemps = Array();
$tpllien = Array();
$tplattaque = Array();
$tplcoque = Array();
$tplbouclier = Array();
$tplfret = Array();	


while (isset($necessaires[$rchiffre])) {
    $test = explode('-', $necessaires[$rchiffre]);
    if ($nivbatiments[$test[0]] < $test[1]) {
        $acces = 0;
        $nbat = sql::select('SELECT nom FROM phpsim_batiments WHERE id="' . $test[0] . '"');
        $texte .= '&nbsp;&nbsp;&nbsp;- ' . $nbat['nom'] . ' '.$lang["niveau"].' ' . $test[1] . ';<br>';
    }
    $rchiffre = $rchiffre + 1;
}

if ($acces == 0) {
    $page = $texte;
} else {

    if(!empty($baserow['unitesencours'])) {

        $maj = explode('_', $baserow['unitesencours']);

        $time = time();
        $tempsecoule = $time - $maj[2];

        $tempsrestant = $maj[1] - $tempsecoule;

    if ($tempsrestant <= 0 && !empty($tempsrestant)) {
        $baserow['unites'] = $chantier->fin_unites($baserow['unites'], $maj[0]);

        $baserow['unitesencours'] = '';

        sql::update('UPDATE phpsim_bases SET unitesencours="' . $baserow['unitesencours'] . '", unites="' . $baserow['unites'] . '" WHERE id="' . $baserow['id'] . '"');

        $baseunites = '0,' . $baserow['unites'];

        $niv = explode(',', $baseunites);

        $tempsrestant = 0;
    }
    }

    if (!empty($mod[1]) && !empty($_POST['nombre']) && $_POST['nombre'] != 0) { // Format du champ : unites_temps_timestamp
            $row = sql::select('SELECT ressources,tps FROM phpsim_chantier WHERE id="' . $mod[1] . '" LIMIT 1');

        $nombrerestant = $_POST['nombre'];

        $baseunitesencours = $baserow['unitesencours'];

        $unitesencours = explode('_', $baseunitesencours);

        $unites = $unitesencours[0];

        if(isset($unitesencours[1])) {
            $tempsrestant = $unitesencours[1];
        } else {
            $tempsrestant = 0;
        }

        if ($tempsrestant < 0) {
            $tempsrestant = 0;
        }

        if ($baserow['unitesencours'] == '') {
            $testnombre = 0;
        } else {
            $testnombre = 1;
        } while ($nombrerestant > 0) {
            if ($testnombre == 0) {
                $unites .= $mod[1];
                $testnombre = 1;
            } else {
                $unites .= ',' . $mod[1];
            }

            $baserow['ressources'] = $chantier->modif_ressources($baserow['ressources'], '-', $row['ressources']);

            $tps = $chantier->calculer_temps($row['tps']);

            $temps = $tempsrestant + ($tps * $_POST['nombre']);

            $nombrerestant = $nombrerestant - 1;
        }

        $timestamp = time();
        $txt = $unites . '_' . $temps . '_' . $timestamp;
        $baserow['unitesencours'] = $txt;

        sql::update('UPDATE phpsim_bases SET unitesencours="' . $txt . '", ressources="' . $baserow['ressources'] . '" WHERE id="' . $baserow['id'] . '"');
        echo '<script>window.location.replace("index.php?mod=chantier"); </script>';
    }

    $niv = explode(',', $baseunites);

    $unitesrow = explode(',', $baseunites);

    $batquery = mysql_query('SELECT id, tps, ressources,niveau_max,batiments,recherches,nom,description,image, attaque, defense, stockage, bouclier FROM phpsim_chantier WHERE race_'.$userrow['race'].'="1" ORDER BY ordre');

    while ($batrow = mysql_fetch_array($batquery)) {
        if (!isset($niv[$batrow['id']]) || $niv[$batrow['id']] == 0) {
            $niveau = '';
        } else {
            $niveau = '( ' . $niv[$batrow['id']] . ' disponibles )';
        }

        $ressourcespage = $chantier->afficher_ressources($batrow['ressources'], 0);

        $temps = $chantier->calculer_temps($batrow['tps']);

        $temps = $chantier->afficher_temps($temps);

        $lien = '<form method="post" action="index.php?mod=chantier|' . $batrow['id'] . '"><input type="text" size="8" name="nombre" value="0"><br><input type="submit" value="Envoyer"></form>';

        if (isset($niv[$batrow['id']]) && $niv[$batrow['id']] >= $batrow['niveau_max'] && $batrow['niveau_max'] != 0) {
            $lien = '<font color="red">'.$lang["nbmaxatteint"].'</font>';
        }


$necessaires = explode(',', $batrow['batiments']);
$necessaires2 = explode(',', $batrow['recherches']);
$rchiffre = 0;
$rchiffre2 = 0;
$texte = '<b>'.$lang["ilvousmanque"].' </b><br>';
$accesb = 1;
$nivbatiments = explode(',', '0,' . $basebatiments);
$nivrecherches = explode(',', '0,' . $userrecherches);

while (isset($necessaires[$rchiffre])) {
    $test = explode('-', $necessaires[$rchiffre]);
    if ($nivbatiments[$test[0]] < $test[1]) {
        $accesb = 0;
        $nbat = sql::select('SELECT nom FROM phpsim_batiments WHERE id="' . $test[0] . '"');
        $texte .= '&nbsp;&nbsp;&nbsp;- ' . $nbat['nom'] . ' '.$lang["niveau"].' ' . $test[1] . ';<br>';
    }
    $necessaires[$rchiffre] = implode('-', $test);
    $rchiffre = $rchiffre + 1;
}

while (isset($necessaires2[$rchiffre2])) 
{
	$test = explode('-', $necessaires2[$rchiffre2]);
	if ($nivrecherches[$test[0]] < $test[1]) 
	{
		$accesb = 0;
		$nbat = sql::select('SELECT nom FROM phpsim_recherches WHERE id="' . $test[0] . '"');
		$texte .= '&nbsp;&nbsp;&nbsp;- ' . $nbat['nom'] . ' '.$lang["niveau"].' ' . $test[1] . ';<br>';
	}
	$necessaires[$rchiffre] = implode('-', $test);
	$rchiffre2 = $rchiffre2 + 1;
}

$batrow['batiments'] = implode(',', $necessaires);
$batrow['recherches'] = implode(',', $necessaires2);


        $tpltheme[] = $userrow['template'];
        $tplimage[] = $batrow['image'];
        $tplnom[] = stripslashes(nl2br($batrow['nom']));
        $tplniveau[] = $niveau;
        $tpldescription[] = stripslashes(nl2br($batrow['description']));
		$tplressources[] = '<u>'.$lang["ress"].'</u> : <br>'.$ressourcespage;
		$tpltemps[] = '<u>'.$lang["tps"].'</u> : '.$temps;
        $tpllien[] = $lien;
		$tplattaque[] = $batrow['attaque'];
		$tplcoque[] = $batrow['defense'];
		$tplbouclier[] = $batrow['bouclier'];
		$tplfret[] = $batrow['stockage'];		

	    if($accesb == 0 && $controlrow['voir_batiments_inaccessibles'] == 1) 
		{
        $tpltheme[] = '';
        $tplimage[] = $batrow['image'];
        $tplnom[] = stripslashes(nl2br($batrow['nom']));
        $tplniveau[] = '';
        $tpldescription[] = stripslashes(nl2br($batrow['description']));
		$tplressources[] = $texte;
		$tpltemps[] = '';
        $tpllien[] = '';
		$tplattaque[] = $batrow['attaque'];
		$tplcoque[] = $batrow['defense'];
		$tplbouclier[] = $batrow['bouclier'];
		$tplfret[] = $batrow['stockage'];	
	    }

    }

	$global = array('theme' => $tpltheme, 'image' => $tplimage, 'nom' => $tplnom, 'niveau' => $tplniveau, 'description' => $tpldescription,
	'ressources' => $tplressources, 'temps' => $tpltemps, 'lien' => $tpllien, 'attaque' => $tplattaque, 'coque' => $tplcoque,
	'bouclier' => $tplbouclier, 'fret' => $tplfret);
	$tpl2->assigntag('BALISE', '1', $global);
	
	$page = $tpl2->recuptpl();
	
}

if (!empty($baserow['unitesencours'])) {

    $affichagetemps = '<div id="construction"></div><script>construire("'.$tempsrestant.'"); </script>';

    $page .= '<table><tr><td align="center"><b>' . $controlrow['unites_nom'] . ' '.$lang["enconstruction"].' </b><br><br>'.$lang["tprestant"].' ' . $affichagetemps . '<br><br><select>';

    $affichage = explode(',', $maj[0]);

    $nombre = 0;

    while (isset($affichage[$nombre])) {

        if(empty($afficherrow[$affichage[$nombre]])) {
            $afficherrow[$affichage[$nombre]] = 0;
        }

        $afficherrow[$affichage[$nombre]] = $afficherrow[$affichage[$nombre]] + 1;

        $nombre = $nombre + 1;
    }


    $liste = sql::query('SELECT id,nom FROM phpsim_chantier ORDER BY id');

    while ($row = mysql_fetch_array($liste)) {
        if(isset($afficherrow[$row['id']]) && $afficherrow[$row['id']] > 0) {
        $page .= '<option>' . $row['nom'] . ' : ' . $afficherrow[$row['id']] . '</option>';
        }
    }

    $page .= '</select></td></tr></table></center>';
}

?>