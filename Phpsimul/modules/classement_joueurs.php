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

// Des erreurs s'affiche du au calcule des points, on cache ses erreurs
error_reporting(0);

if(@$_GET["type"] == "batiments") 
{
	$nomcache = "classement_batiments";
} 
elseif(@$_GET["type"] == "recherches") 
{
	$nomcache = "classement_recherches";
}
elseif(@$_GET["type"] == "unit") 
{
	$nomcache = "classement_unit";
} 
else 
{
	$nomcache = "classement";
}

$page = $cache->chercher($nomcache);

if($page == 1)
{

	if(@$_GET["type"] == "batiments") 
	{
		// On met des valeur template en place pour que le type de classement choisi soit selectionné
		$tpl->value('general', '');
		$tpl->value('batiments', 'selected');
		$tpl->value('recherches', '');
		$tpl->value('unit', '');
		$type = "_bat";
	} 
	elseif(@$_GET["type"] == "recherches") 
	{
		$tpl->value('general', '');
		$tpl->value('batiments', '');
		$tpl->value('recherches', 'selected');
		$tpl->value('unit', '');
		$type = "_rech";
	}
	elseif(@$_GET["type"] == "unit") 
	{
		$tpl->value('general', '');
		$tpl->value('batiments', '');
		$tpl->value('recherches', '');
		$tpl->value('unit', 'selected');
		$type = "_unit";

	} 
	else 
	{
		$tpl->value('general', 'selected');
		$tpl->value('batiments', '');
		$tpl->value('recherches', '');
		$tpl->value('unit', '');
		$type = "";
	}

	$tpl->value('select_joueurs', 'selected'); 
	$tpl->value('select_allis', '');
	$tpl->value('type', '_joueurs'); 
	$page = $tpl->construire('classement_entete');

	$classementj = '';



	$liste = $sql->query("SELECT * FROM phpsim_users WHERE valide='1' ORDER BY points".$type." DESC");

	// On ouvre la classes qui calcule les points
	include('classes/points.class.php');
	$points = new points;

	$time = time();

	while($row = mysql_fetch_array($liste)) {

		$bat = $points->batiments($row['bases']);
		$rech = $points->recherches($row['recherches']);
		$unit = $points->unit($row['bases']);
		
		$sql->update("UPDATE phpsim_users SET 
														points_bat='".$bat."', 
														points_rech='".$rech."', 
														points_unit='".$unit."', 
														points='".($bat+$rech+$unit)."', 
														dernier_calcul_points='".$time."' 
													  WHERE id='".$row['id']."'");

	}

	$liste = $sql->query("SELECT * FROM phpsim_users WHERE valide='1' ORDER BY points".$type." DESC");

	$nombre = 1;

	while ($row = mysql_fetch_array($liste)) 
	{
	    
	    $tpl->value('numero', $nombre);

		if ($row["alli"] == 0 || !isset($row["alli"])) 
		{
			$alli = $tpl->construire('classement_joueur_users_allinon');
		}
		else
		
			$all = mysql_query("SELECT tag FROM phpsim_alliance	WHERE id='".$row["alli"]."' ");
			
			while (@$b = mysql_fetch_array($all) ) 
			{
			$tpl->value('tagalli', $b["tag"]);
			$alli = $tpl->construire('classement_joueur_users_allioui');
		
		}
		$tpl->value("alli", $alli);

	    $tpl->value('nom', $row['nom']);
	    $tpl->value('points', number_format($row['points'.$type], 0, '.', '.') );
	    $tpl->value('race', $row['race']);
	    $tpl->value('race_nom', $controlrow["race_".$row["race"]]);
	    $tpl->value('id', $row['id']);
		$classementj .= $tpl->construire('classement_joueur_users');
	    $nombre = $nombre + 1;
	}


	$tpl->value('affichage_users_classement', $classementj);
	$page .= $tpl->construire('classement_joueur_entete');
	$cache->save($page, $nomcache);
}



?>