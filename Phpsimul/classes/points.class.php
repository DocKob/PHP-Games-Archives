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

class points 
{

	###############################################################################
	/*******************************************************************************************************\
		FONCTION PRIVÉ PERMETTANT DE CALCULER LES POINTS DONNER POUR LE NIVEAU SUIVANT
	\*******************************************************************************************************/
	function evo($niv, $pts, $evo) //niveau a atteindre - points de base - % d'évo par niveau
	{
		$nivencours = 1;
		$total = $pts;
		$precedent = $pts;
		while($nivencours < $niv) 
		{
			$precedent = $precedent * (($evo / 100) + 1);
			$total = $total + $precedent;
			$nivencours = $nivencours + 1;
		}
		if($niv == 0) 
		{ 
			$total = 0; 
		}
		return round($total);
	}

	###############################################################################
    /****************************************************************************************************\
		ON RECUPERES LES POINT GAGNÉ GRACE AU BATIMENTS
	\****************************************************************************************************/
	function batiments($listebases)
	{

		$pointsbatiments = 0;

		$bases = explode(",", $listebases);

		foreach($bases as $base1)
		{ // debut foreach recalcule les points des bases

			$baseatraiter = sql::select('SELECT id,batiments FROM '.PREFIXE_TABLES.TABLE_BASES.' WHERE id="'.$base1.'" ');

			$nivbatbasejoueur = explode(",", $baseatraiter["batiments"]);
			$bat = sql::query("SELECT id,points,points_evo FROM ".PREFIXE_TABLES.TABLE_BATIMENTS." ORDER BY id");

			while($batiment = mysql_fetch_array($bat)) 
			{ 
			$pointsbatiments = $pointsbatiments + $this->evo($nivbatbasejoueur[$batiment["id"] - 1], $batiment["points"], $batiment["points_evo"]);  
			}
		}
		return $pointsbatiments;

	}


	###############################################################################
    /****************************************************************************************************\
		ON RECUPERES LES POINTS GAGNÉ GRACE AU RECHERCHES
	\****************************************************************************************************/
	function recherches($recherches) 
	{
		$niveaujoueur = explode(",", $recherches);
		$recherches1 = sql::query("SELECT id,points,points_evo FROM ".PREFIXE_TABLES.TABLE_RECHERCHES." ORDER BY id");
		$pointsrecherches =0;

		while($recherches = mysql_fetch_array($recherches1) ) 
		{ 
			$pointsrecherches = $pointsrecherches + $this->evo($niveaujoueur[$recherches["id"] - 1], $recherches["points"], $recherches["points_evo"]); 
		}

		return $pointsrecherches;
	}


	###############################################################################
    /****************************************************************************************************\
		PERMET DE SAVOIR LES POINTS DES DEFENSES ET UNITÉS
	\****************************************************************************************************/
	function unit($listebases) 
	{
		$pointsunites = 0;
		$pointsdef = 0;

		$bases = explode(",", $listebases);

		foreach($bases as $basejoueur)
		{ // debut foreach recalcule les points des bases

			$baseatraiter = sql::select('SELECT id,unites,defenses FROM '.PREFIXE_TABLES.TABLE_BASES.' WHERE id="'.$basejoueur.'" ');

			// On recalcules les points des unités
			$niveauunitesjoueur = explode(",", $baseatraiter["unites"]);
			$unit = sql::query("SELECT id,points FROM ".PREFIXE_TABLES.TABLE_CHANTIER." ORDER BY id");

			while($unites = mysql_fetch_array($unit) ) 
			{ 
				$pointsunites = $pointsunites + ($unites["points"] * $niveauunitesjoueur[$unites["id"] - 1]); 
			}

			// On recalcules les point des defenses
			$niveau_def_joueur = explode(",", $baseatraiter["defenses"]);
			$defenses = sql::query("SELECT id,points FROM ".PREFIXE_TABLES.TABLE_DEFENSES." ORDER BY id");

			while($def = mysql_fetch_array($defenses) ) 
			{ 
				$pointsdef = $pointsdef + ($def["points"] * $niveau_def_joueur[$def["id"] - 1]); 
			}

		} 

		$unit = $pointsdef + $pointsunites;

		return $unit;

	}

}

?>