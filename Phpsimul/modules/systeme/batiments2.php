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

include('classes/templates2.class.php');
$tpl2 = new Tpl;

lang("batiments");

echo '<div id="curseur" class="infobulle"></div>';

include("classes/batiments.class.php");

$bat = new batiment;

$basebatiments = $baserow["batiments"];
$userrecherches = $userrow["recherches"];

$niv2 = explode(",", $baserow["batiments"]);

$baserow["batiments"] = "0," . $baserow["batiments"];
$niv = explode(",", $baserow["batiments"]);
$basebatimentencours = $baserow["batimentencours"];

$case = explode(",", $baserow["map"]);

######################################################################################################
if(!empty($baserow["batimentencours"])) // Si il y a un batiment en cours
{

	$maj = explode("_", $basebatimentencours);
	$tempsecoule = time() - $maj[3];
	$tempsrestant = $maj[2] - $tempsecoule;

	###############################################
	if ($tempsrestant <= 0 && $maj[3] != "") // Si la construction est terminé
	{
	    $row = sql::select("SELECT * FROM phpsim_batiments WHERE id='" . $maj[0] . "'");
	    $nbre2 = $maj[0] - 1;
	    $niv2[$nbre2] = $niv2[$nbre2] + 1;

	    $consoenplus = $bat->calculer_ajout_energie($niv[$row["id"]], $row["consommation"], $row["consommation_evo"]);
	    $prodeneenplus = $bat->calculer_ajout_energie($niv[$row["id"]], $row["production_energie"], $row["production_energie_evo"]);

	    $prodenplus = $bat->calculer_ajout_ressources($niv[$row["id"]], $row["production"], $row["production_evo"]);

	    $prodactuelle = $bat->modif_ressources($baserow["productions"], "+", $prodenplus);

	    $stkenplus = $bat->calculer_ajout_ressources($niv[$row["id"]], $row["stockage"], $row["stockage_evo"]);

	    $stkactuel = $bat->modif_ressources($baserow["stockage"], "+", $stkenplus);

	    if ($baserow["temps_diminution"] == 0) 
	    {
	        $temps_diminution = $row["temps_diminution"];
	    } else 
	    {
	        $temps_diminution = $baserow["temps_diminution"] * (1 + ($row["temps_diminution"] / 100));
	    }

	    if($niv2[$nbre2] <= 1) 
	    {

		    //case

		    $case[$maj[4] - 1] = $maj[0];

		    // fin case

	    }

	    $baserow["energie"] = $baserow["energie"] + $consoenplus;
	    $baserow["energie_max"] = $baserow["energie_max"] + $prodeneenplus;
	    $baserow["production"] = $prodactuelle;
	    $baserow["batimentencours"] = "";
	    $baserow["batiments"] = implode(",", $niv2);
	    $baserow["cases"] = $baserow['cases'] + $row['cases'];
	    $baserow["stockage"] = $stkactuel;
	    $baserow["cases_max"] = $baserow["cases_max"] + $row["cases_en_plus"] ;

	    $case2 = implode(",", $case);

	    sql::update("UPDATE phpsim_bases SET cases='".$baserow["cases"]."', cases_max='".$baserow["cases_max"]."', 
	                 productions='" . $baserow["production"] . "', energie='" . $baserow["energie"] . "', 
	                 energie_max='" . $baserow["energie_max"] . "', batimentencours='" . $baserow["batimentencours"] . "', 
	                 batiments='" . $baserow["batiments"] . "', temps_diminution='" . $temps_diminution . "', 
	                 stockage='".$baserow["stockage"]."', map='".$case2."' WHERE id='" . $baserow["id"] . "'");
	                 
	    //die("<script>window.location.replace('index.php?mod=batiments'); </script>");
	} 
	###############################################
	elseif ($tempsrestant > 0 && $maj[3] != "") // Si il reste du temps avant la fin
	{
	    $baserow["batimentencours"] = $maj[0] . "_" . $maj[1] . "_" . $tempsrestant . "_" . time() . "_" . $maj[4];
	    sql::update("UPDATE phpsim_bases SET batimentencours='" . $baserow["batimentencours"] . "' WHERE id='" . $baserow["id"] . "'");
	}
}

######################################################################################################
if (!empty($mod[1])) 
{ // si cliqué sur lien pour construire (format du champ : id_ressources_tempsrestant_dernieremiseajour_case)
    $row = sql::select("SELECT * FROM phpsim_batiments WHERE id='" . $mod[1] . "' LIMIT 1");

	if( ($row["niveau_max"] <= $niv[$mod[1]]) && ($row["niveau_max"] != 0) ) 
	{
		die('<script>document.location.href="index.php?mod=batiments"</script>');
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

	while (isset($necessaires[$rchiffre])) 
	{
	    $test = explode("-", $necessaires[$rchiffre]);
	    if (@$nivbatiments[$test[0]] < @$test[1]) 
		{
	        $accesb = 0;
	    }
	    $necessaires[$rchiffre] = implode("-", $test);
	    $rchiffre = $rchiffre + 1;
	}

	while (isset($necessaires2[$rchiffre2])) 
	{
	    $test = explode("-", $necessaires2[$rchiffre2]);
	    if (@$nivrecherches[$test[0]] < @$test[1]) 
		{
	        $accesb = 0;
	    }
	    $necessaires[$rchiffre] = implode("-", $test);
	    $rchiffre2 = $rchiffre2 + 1;
	}

	if($accesb == 0) 
	{ 		
		die('<script>document.location.href="index.php?mod=batiments"</script>');
	}

	// FIN FONCTION PERMETTANT DE SAVOIR SI LES RECHERCHES ET BATIMENTS NECCESSAIRE SONT BIEN PRESENTES
	######################################################################################################

    $aajouter = $bat->calculer_ressources($niv[$mod[1]], $row["ressources"], $row["ressources_evo"]);

    $baseressources = $bat->modif_ressources($baserow["ressources"], "-", $aajouter);

    $temps = $bat->calculer_temps($niv[$mod[1]], $row["tps"], $row["tps_evo"]);

    $timestamp = time();
    $txt = $mod[1] . "_" . $aajouter . "_" . $temps . "_" . $timestamp . "_" . $_GET["casec"];
    $baserow["batimentencours"] = $txt;

    //case

    if($niv[$mod[1]] < 1) 
	{

	    $case[$_GET["casec"] - 1] = -2;

	    // fin case

    }

    $case2 = implode(",", $case);

    sql::update("UPDATE phpsim_bases SET batimentencours='" . $txt . "', ressources='" . $baseressources . "', map='".$case2."' WHERE id='" . $baserow["id"] . "'");
    echo "<script>window.location.replace('index.php?mod=batiments'); </script>";
}

##############################################################################################################"
/*
Début de l'affichage des batiments

0 -> rien
-1 -> arbre
-2 -> construction en cours
$nb > 0 -> id du batiment installé

get : 
- case (pour construire), 
- voir (encours pour en construction / id batiment pour voir
*/

##############################################################################################################"
if(isset($_GET["case"])) // Si il a cliqué un endoirt ou il n'y a pas de batiment, on lui montre la liste
{

	$baserow["batiments"] = "0," . $baserow["batiments"];

	$batimentsrow = explode(",", $baserow["batiments"]);

	$batquery = sql::query("SELECT * FROM phpsim_batiments WHERE race_".$userrow["race"]."='1' ORDER BY ordre");

	$nombrelignes = 0; // Permet de dire qu'il ny a plus de batiment a ajouté, si tel est le cas

	$page = "<table border='1' width='100%'>";

	$tpl2->fichier('templates/'.$userrow['template'].'/batiments.html');

$tplid = Array();
$tpltheme = Array();
$tplimage = Array();
$tplnom = Array();
$tplniveau = Array();
$tpldescription = Array();
$tplressources = Array();
$tpltemps = Array();
$tpllien = Array();
$tpltemps_avant_dispo = Array();


	while ($batrow = mysql_fetch_array($batquery)) 
	{

		if($niv[$batrow["id"]] == 0 || empty($niv[$batrow["id"]]) ) // Dans le cas ou le batiment n'a ecore pas été construit
		{

			    if ($niv[$batrow["id"]] == "" || $niv[$batrow["id"]] == 0) 
				{
			        $niveau = " ";
			    } 
				else 
				{
			        $niveau = "( niveau " . $niv[$batrow["id"]] . " )";
			    }



			// On demande la fonction permettant de calculé le nombres de ressources manquantes
			$rm = $bat->ressources_manquantes($batrow);
			$temps_avant_dispo = $rm['ressources_manquantes'] ;
			$construction_impossible= $rm['construction_impossible'] ;



			$ressourcespage = $bat->afficher_ressources($batrow["ressources"], $batrow["ressources_evo"]);

			$temps = $bat->calculer_temps($niv[$batrow["id"]], $batrow["tps"], $batrow["tps_evo"]);

			$temps = $bat->afficher_temps($temps);

			$batimentencours = explode("_", $baserow["batimentencours"]);

			$lien = "&nbsp;";

			if ($baserow["batimentencours"] == "") 
			{
			
				$niveauaconstruire = $niv[$batrow["id"]] + 1;

				if ($niv[$batrow["id"]] >= $batrow["niveau_max"] && $batrow["niveau_max"] != 0) 
				{
					$lien = "<font color='red'>".$lang["nivmaxbatatteint"]."</font>";
				}
				elseif(ereg("[1]",$construction_impossible) ) { // si construction impossible contient un 1 alors on n'a pas les ressources suffisantes 
				  $lien ="<font color='red'>".$lang["ressmanquantes"]."</font>";
				}  
				elseif ($niv[$batrow["id"]] < $batrow["niveau_max"] || $batrow["niveau_max"] == 0) {
					$lien = "<a href='index.php?mod=batiments|" . $batrow["id"] . "&casec=".$_GET["case"]."'>
					<font color='green'>".$lang["construireniv"] . $niveauaconstruire . "</font></a>";
				} 
				
			} 
			elseif ($batimentencours[0] == $batrow["id"]) 
			{

				$lien = "<div id='construction'></div><script>construire('".$batimentencours[2]."'); </script>";

			}


			$necessaires = explode(",", $batrow["batiments"]);
			$necessaires2 = explode(",", $batrow["recherches"]);
			$rchiffre = 0;
			$rchiffre2 = 0;
			$texte = "<b>".$lang["ilvousmanque"]."</b><br>";
			$accesb = 1;
			$nivbatiments = explode(",", "0," . $basebatiments);
			$nivrecherches = explode(",", "0," . $userrecherches);

			while (isset($necessaires[$rchiffre])) 
			{
			    $test = explode("-", $necessaires[$rchiffre]);
			    if (@$nivbatiments[$test[0]] < @$test[1]) 
				{
			        $accesb = 0;
			        $nbat = sql::select("SELECT nom FROM phpsim_batiments WHERE id='" . $test[0] . "'");
			        $texte .= "&nbsp;&nbsp;&nbsp;- " . $nbat["nom"] . $lang["niveau"] . $test[1] . ";<br>";
			    }
			    $necessaires[$rchiffre] = implode("-", $test);
			    $rchiffre = $rchiffre + 1;
			}

			while (isset($necessaires2[$rchiffre2])) 
			{
			    $test = explode("-", $necessaires2[$rchiffre2]);
			    if (@$nivrecherches[$test[0]] < @$test[1]) 
				{
			        $accesb = 0;
			        $nbat = sql::select("SELECT nom FROM phpsim_recherches WHERE id='" . $test[0] . "'");
			        $texte .= "&nbsp;&nbsp;&nbsp;- " . $nbat["nom"] . $lang["niveau"] . $test[1] . ";<br>";
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
	    $tplressources[] = "<u>Ressources</u> : <br>".$ressourcespage;
	    $tpltemps[] = "<u>Temps</u> : <br>".$temps;
	    $tpllien[] = $lien;
	    $tpltemps_avant_dispo[] = $temps_avant_dispo;
	    
	    $nombrelignes++;

	}
	elseif($accesb == 0 && $controlrow['voir_batiments_inaccessibles'] == 1) {

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
	    
	    $nombrelignes++;

	}







		}



	}



$global = array('id' => $tplid, 'theme' => $tpltheme, 'image' => $tplimage, 'nom' => $tplnom,
 'niveau' => $tplniveau, 'description' => $tpldescription, 'ressources' => $tplressources,
 'temps' => $tpltemps, 'lien' => $tpllien, 'temps_avant_dispo' => $tpltemps_avant_dispo); 

$tpl2->assigntag('BALISE', 1, $global); 
 
$page .= $tpl2->recuptpl();
	if($nombrelignes <= 0) // Si il n'y a aucun batiments 
	{

		$page = $lang["plusdebatimentsaajouter"]."<br><br><a href='index.php?mod=batiments'>".$lang["retour"]."</a><br><br>";

	}

}
##############################################################################################################"
else
{
	if(@$_GET["voir"] == "encours") // On affiche les batiments en cours 
	{

		// Protection dans le cas ou un joueur demande a voir un batiment inexistant, on le redirige sur l'index des batiments
		if(empty($baserow["batimentencours"]) ) 
		{ 
			die('<script>document.location.href="index.php?mod=batiments"</script>'); 
		}


		$tps = explode(",", $baserow["batimentencours"]);
		$voirbat = sql::select("SELECT * FROM phpsim_batiments WHERE id='" . $tps[0] . "'");
		$baserow["batimentencours"] = implode(",", $tps);


		// On demande la fonction permettant de calculé le nombres de ressources manquantes
		$rm = $bat->ressources_manquantes($voirbat);
		$temps_avant_dispo = $rm['ressources_manquantes'] ;
		$construction_impossible= $rm['construction_impossible'] ;



		$ressourcespage = $bat->afficher_ressources($voirbat["ressources"], $voirbat["ressources_evo"]);

		$temps = $bat->calculer_temps($niv[$voirbat["id"]], $voirbat["tps"], $voirbat["tps_evo"]);

		$temps = $bat->afficher_temps($temps);

		$batimentencours = explode("_", $baserow["batimentencours"]);

		$lien = "&nbsp;";

		if ($baserow["batimentencours"] == "") 
		{
			
			$niveauaconstruire = $niv[$voirbat["id"]] + 1;

			if ($niv[$voirbat["id"]] >= $voirbat["niveau_max"] && $voirbat["niveau_max"] != 0) 
			{
				$lien = "<font color='red'>".$lang["nivmaxbatatteint"]."</font>";
			}
			elseif(ereg("[1]",$construction_impossible) ) 
			{ // si construction impossible contient un 1 alors on n'a pas les ressources suffisantes 
				$lien ="<font color='red'>".$lang["ressmanquantes"]."</font>";
			}
			elseif ($niv[$voirbat["id"]] < $voirbat["niveau_max"] || $voirbat["niveau_max"] == 0) 
			{
				$lien = "<a href='index.php?mod=batiments|" . $voirbat["id"] . "&casec=".$_GET["casec"]."'>
						 <font color='green'>".$lang["construireniv"] . $niveauaconstruire . "</font></a>";
			} 
		
		} 
		elseif ($batimentencours[0] == $voirbat["id"]) 
		{

			$lien = "<div id='construction'></div><script>construire('".$batimentencours[2]."'); </script>";

		}




		$tpl->value("id", $batrow["id"]);
		$tpl->value("nom", stripslashes(nl2br($voirbat["nom"])));
		$tpl->value("niveau", $niv[$voirbat["id"]]);
		$tpl->value("theme", $userrow["template"]);
		$tpl->value("image", $voirbat["image"]);
		$tpl->value("description", stripslashes(nl2br($voirbat["description"])));
		$tpl->value("temps_avant_dispo", @$voirbat["temps_avant_dispo"]);
		$tpl->value("ressources", "<u>Ressources</u> : <br>".$ressourcespage);
		$tpl->value("temps", "<u>Temps</u> : ".$temps);
		$tpl->value("lien", $lien);
		$tpl->value("temps_avant_dispo", $temps_avant_dispo);

		$page = $tpl->construire("voirbatiment");

	} 
	##############################################################################################################"
	elseif(@$_GET["voir"] > 0) // Si le joueur demande de voir un batiment
	{

		$voirbat = $sql->select("SELECT * FROM phpsim_batiments WHERE id='".$_GET["voir"]."' LIMIT 1");

		// Protection dans le cas ou un joueur demande a voir un batiment inexistant, on le redirige sur l'index des batiments
		if(empty($voirbat) ) 
		{
			die('<script>document.location.href="index.php?mod=batiments"</script>'); 
		}


		// On demande la fonction permettant de calculé le nombres de ressources manquantes
		$rm = $bat->ressources_manquantes($voirbat);
		$temps_avant_dispo = $rm['ressources_manquantes'] ;
		$construction_impossible= $rm['construction_impossible'] ;


		$ressourcespage = $bat->afficher_ressources($voirbat["ressources"], $voirbat["ressources_evo"]);

		$temps = $bat->calculer_temps($niv[$voirbat["id"]], $voirbat["tps"], $voirbat["tps_evo"]);

		$temps = $bat->afficher_temps($temps);

		$batimentencours = explode("_", $baserow["batimentencours"]);

		$lien = "&nbsp;";

		if ($baserow["batimentencours"] == "") 
		{
		
			$niveauaconstruire = $niv[$voirbat["id"]] + 1;

			if ($niv[$voirbat["id"]] >= $voirbat["niveau_max"] && $voirbat["niveau_max"] != 0) 
			{
				$lien = "<font color='red'>".$lang["nivmaxbatatteint"]."</font>";
			}
			elseif(ereg("[1]",$construction_impossible) ) 
			{ // si construction impossible contient un 1 alors on n'a pas les ressources suffisantes 
			  $lien ="<font color='red'>".$lang["ressmanquantes"]."</font>";
			}
			elseif ($niv[$voirbat["id"]] < $voirbat["niveau_max"] || $voirbat["niveau_max"] == 0) 
			{
				$lien = "<a href='index.php?mod=batiments|" . $voirbat["id"] . "&casec=".@$_GET["casec"]."'>
						 <font color='green'>".$lang["construireniv"] . $niveauaconstruire . "</font></a>";
			} 

		} 
		elseif ($batimentencours[0] == $voirbat["id"]) 
		{

			$lien = "<div id='construction'></div><script>construire('".$batimentencours[2]."'); </script>";

		}




		$tpl->value("id", $batrow["id"]);
		$tpl->value("nom", stripslashes(nl2br($voirbat["nom"])));
		$tpl->value("niveau", $niv[$voirbat["id"]]);
		$tpl->value("theme", $userrow["template"]);
		$tpl->value("image", $voirbat["image"]);
		$tpl->value("description", stripslashes(nl2br($voirbat["description"])));
		$tpl->value("ressources", $ressourcespage);
		$tpl->value("temps", $temps);
		$tpl->value("lien", $lien);
		$tpl->value("temps_avant_dispo", $temps_avant_dispo);

		$page = $tpl->construire("voirbatiment");

	} 
	##############################################################################################################"
	else // Si rien n'est demandé on affiche la carte
	{

		$casenb = 0;
		while($casenb < 81) 
		{
			$casenb = $casenb + 1;

			if($case[$casenb - 1] == 0 && empty($baserow["batimentencours"])) 
			{
				$tpl->value($casenb, "<a href='index.php?mod=batiments&case=".$casenb."'><img src='templates/".$userrow["template"]."/images/carte/".$baserow["ordre_3"]."/fond.gif' border='0' width='64' height='64'></a>");
			}
			elseif($case[$casenb - 1] == 0 && !empty($baserow["batimentencours"])) 
			{
				$tpl->value($casenb, "<img src='templates/".$userrow["template"]."/images/carte/".$baserow["ordre_3"]."/fond.gif' border='0' width='64' height='64'>");
			}
			elseif($case[$casenb - 1] == -1) 
			{
				$tpl->value($casenb, "<img src='templates/".$userrow["template"]."/images/carte/".$baserow["ordre_3"]."/arbre.gif' border='0' width='64' height='64'>");
			}
			elseif($case[$casenb - 1] == -2) 
			{
				$tpl->value($casenb, "<a href='index.php?mod=batiments&voir=encours'><img src='templates/".$userrow["template"]."/images/carte/".$baserow["ordre_3"]."/construction.gif' border='0' width='64' height='64'></a>");
			}
			elseif($case[$casenb - 1] > 0) 
			{

				$bati = $sql->select("SELECT id,image,nom FROM phpsim_batiments WHERE id='".$case[$casenb - 1]."' LIMIT 1");

				$tpl->value($casenb, "<a href='index.php?mod=batiments&voir=".$bati["id"]."'>
				                      <img src='templates/".$userrow["template"]."/images/batiments/".$bati["image"].
				                      ".gif' border='0' width='64' height='64' onmouseover='montre(\"
				                      ".$bati["nom"]."\");' onmouseout='cache();'></a>");

				$tpl->value("theme", $userrow["template"]);

				$tpl->value("ordre_3", $baserow["ordre_3"]);
			}

			$page = $tpl->construire("carte");

		} 
	}

}






?>