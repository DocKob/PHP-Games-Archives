<?php
/**
 * This file is part of Wootook
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://wootook.org/
 *
 * Copyright (c) 2009-Present, Wootook Support Team <http://wootook.org>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing Wootook.
 *
 */

define('INSIDE' , true);
define('INSTALL' , false);
require_once dirname(__FILE__) .'/application/bootstrap.php';

// ----------------------------------------------------------------------------------------------------------
// Creation de la Liste de flotte disponible sur la lune
//
function BuildFleetListRows ( $CurrentPlanet ) {
	global $resource, $lang;

	$RowsTPL  = gettemplate('gate_fleet_rows');
	$CurrIdx  = 1;
	$Result   = "";
	for ($Ship = 300; $Ship > 200; $Ship-- ) {
		if ($resource[$Ship] != "") {
			if ($CurrentPlanet[$resource[$Ship]] > 0) {
				$bloc['idx']             = $CurrIdx;
				$bloc['fleet_id']        = $Ship;
				$bloc['fleet_name']      = $lang['tech'][$Ship];
				$bloc['fleet_max']       = pretty_number ( $CurrentPlanet[$resource[$Ship]] );
				$bloc['gate_ship_dispo'] = $lang['gate_ship_dispo'];
				$Result                 .= parsetemplate ( $RowsTPL, $bloc );
				$CurrIdx++;
			}
		}
	}
	return $Result;
}

// ----------------------------------------------------------------------------------------------------------
// Creation de la combo de selection de Lune d'arrivé
//
function BuildJumpableMoonCombo ( $CurrentUser, $CurrentPlanet ) {
	global $resource;
	$QrySelectMoons  = "SELECT * FROM {{table}} WHERE `planet_type` = '3' AND `id_owner` = '". $CurrentUser['id'] ."';";
	$MoonList        = doquery ( $QrySelectMoons, 'planets');
	$Combo           = "";
	while ( $CurMoon = mysql_fetch_assoc($MoonList) ) {
		if ( $CurMoon['id'] != $CurrentPlanet['id'] ) {
			$RestString = GetNextJumpWaitTime ( $CurMoon );
			if ( $CurMoon[$resource[43]] >= 1) {
				$Combo .= "<option value=\"". $CurMoon['id'] ."\">[". $CurMoon['galaxy'] .":". $CurMoon['system'] .":". $CurMoon['planet'] ."] ". $CurMoon['name'] . $RestString['string'] ."</option>\n";
			}
		}
	}
	return $Combo;
}

// ----------------------------------------------------------------------------------------------------------
// Creation du tableau de production de ressources
// Tient compte du parametrage de la planete (si la production n'est pas affectée a 100% par exemple
// Tient compte aussi du multiplicateur de ressources
//
function ShowProductionTable ($CurrentUser, $CurrentPlanet, $BuildID, $Template) {
	global $ProdGrid, $resource;

	$BuildLevelFactor = $CurrentPlanet[ $resource[$BuildID]."_porcent" ];
	$BuildTemp        = $CurrentPlanet[ 'temp_max' ];
	$CurrentBuildtLvl = $CurrentPlanet[ $resource[$BuildID] ];

	$BuildLevel       = ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;
	$multiplier = Wootook::getGameConfig('game/resource/multiplier');
	$Prod[1]          = (floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $multiplier));
	$Prod[2]          = (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $multiplier));
	$Prod[3]          = (floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $multiplier));
	$Prod[4]          = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $multiplier));
	$BuildLevel       = "";

	$ActualProd       = floor($Prod[$BuildID]);
	if ($BuildID != 12) {
		$ActualNeed       = floor($Prod[4]);
	} else {
		$ActualNeed       = floor($Prod[3]);
	}

	$BuildStartLvl    = $CurrentBuildtLvl - 2;
	if ($BuildStartLvl < 1) {
		$BuildStartLvl = 1;
	}
	$Table     = "";
	$ProdFirst = 0;
	for ( $BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 10; $BuildLevel++ ) {
		if ($BuildID != 42) {
			$Prod[1] = (floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $multiplier));
			$Prod[2] = (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $multiplier));
			$Prod[3] = (floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $multiplier));
			$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $multiplier));

			$bloc['build_lvl']       = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">".$BuildLevel."</font>" : $BuildLevel;
			if ($ProdFirst > 0) {
				if ($BuildID != 12) {
					$bloc['build_gain']      = "<font color=\"lime\">(". pretty_number(floor($Prod[$BuildID] - $ProdFirst)) .")</font>";
				} else {
					$bloc['build_gain']      = "<font color=\"lime\">(". pretty_number(floor($Prod[4] - $ProdFirst)) .")</font>";
				}
			} else {
				$bloc['build_gain']      = "";
			}
			if ($BuildID != 12) {
				$bloc['build_prod']      = pretty_number(floor($Prod[$BuildID]));
				$bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[$BuildID] - $ActualProd)) );
				$bloc['build_need']      = colorNumber( pretty_number(floor($Prod[4])) );
				$bloc['build_need_diff'] = colorNumber( pretty_number(floor($Prod[4] - $ActualNeed)) );
			} else {
				$bloc['build_prod']      = pretty_number(floor($Prod[4]));
				$bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[4] - $ActualProd)) );
				$bloc['build_need']      = colorNumber( pretty_number(floor($Prod[3])) );
				$bloc['build_need_diff'] = colorNumber( pretty_number(floor($Prod[3] - $ActualNeed)) );
			}
			if ($ProdFirst == 0) {
				if ($BuildID != 12) {
					$ProdFirst = floor($Prod[$BuildID]);
				} else {
					$ProdFirst = floor($Prod[4]);
				}
			}
		} else {
			// Cas particulier de la phalange
			$bloc['build_lvl']       = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">".$BuildLevel."</font>" : $BuildLevel;
			$bloc['build_range']     = ($BuildLevel * $BuildLevel) - 1;
		}
		$Table    .= parsetemplate($Template, $bloc);
	}

	return $Table;
}

// ----------------------------------------------------------------------------------------------------------
// Creation de l'information des RapidFire contre ...
//
function ShowRapidFireTo ($BuildID) {
	global $lang, $CombatCaps;
	$ResultString = "";
	for ($Type = 200; $Type < 500; $Type++) {
		if ($CombatCaps[$BuildID]['sd'][$Type] > 1) {
			$ResultString .= $lang['nfo_rf_again']. " ". $lang['tech'][$Type] ." <font color=\"#00ff00\">".$CombatCaps[$BuildID]['sd'][$Type]."</font><br>";
		}
	}
	return $ResultString;
}

// ----------------------------------------------------------------------------------------------------------
// Creation de l'information des RapidFire de ...
//
function ShowRapidFireFrom ($BuildID) {
	global $lang, $CombatCaps;

	$ResultString = "";
	for ($Type = 200; $Type < 500; $Type++) {
		if ($CombatCaps[$Type]['sd'][$BuildID] > 1) {
			$ResultString .= $lang['nfo_rf_from']. " ". $lang['tech'][$Type] ." <font color=\"#ff0000\">".$CombatCaps[$Type]['sd'][$BuildID]."</font><br>";
		}
	}
	return $ResultString;
}

// ----------------------------------------------------------------------------------------------------------
// Construit la page par rapport a l'information demandée ...
// Permet de faire la differance entre les divers types et les pages speciales
//
function ShowBuildingInfoPage ($CurrentUser, $CurrentPlanet, $BuildID) {
	global $dpath, $lang, $resource, $pricelist, $CombatCaps;

	includeLang('infos');

	$GateTPL              = '';
	$DestroyTPL           = '';
	$TableHeadTPL         = '';

	$parse                = $lang;
	// Données de base
	$parse['dpath']       = $dpath;
	$parse['name']        = $lang['info'][$BuildID]['name'];
	$parse['image']       = $BuildID;
	$parse['description'] = $lang['info'][$BuildID]['description'];


	if       ($BuildID >=   1 && $BuildID <=   3) {
		// Cas des mines
		$PageTPL              = gettemplate('info_buildings_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_p_hour}</td><td class=\"c\">{nfo_difference}</td><td class=\"c\">{nfo_used_energy}</td><td class=\"c\">{nfo_difference}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th><th>{build_need}</th><th>{build_need_diff}</th></tr>";
	} elseif ($BuildID ==   4) {
		// Centrale Solaire
		$PageTPL              = gettemplate('info_buildings_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_energy}</td><td class=\"c\">{nfo_difference}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th></tr>";
	} elseif ($BuildID ==  12) {
		// Centrale Fusion
		$PageTPL              = gettemplate('info_buildings_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_energy}</td><td class=\"c\">{nfo_difference}</td><td class=\"c\">{nfo_used_deuter}</td><td class=\"c\">{nfo_difference}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th><th>{build_need}</th><th>{build_need_diff}</th></tr>";
	} elseif ($BuildID >=  14 && $BuildID <=  32) {
		// Batiments Generaux
		$PageTPL              = gettemplate('info_buildings_general');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  33) {
		// Batiments Terraformer
		$PageTPL              = gettemplate('info_buildings_general');
	} elseif ($BuildID ==  34) {
		// Dépot d'alliance
		$PageTPL              = gettemplate('info_buildings_general');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  44) {
		// Silo de missiles
		$PageTPL              = gettemplate('info_buildings_general');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  41) {
		// Batiments lunaires
		$PageTPL              = gettemplate('info_buildings_general');
	} elseif ($BuildID ==  42) {
		// Phalange
		$PageTPL              = gettemplate('info_buildings_table');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_range}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_range}</th></tr>";
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  43) {
		// Porte de Saut
		$PageTPL              = gettemplate('info_buildings_general');
		$GateTPL              = gettemplate('gate_fleet_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID >= 106 && $BuildID <= 199) {
		// Laboratoire
		$PageTPL              = gettemplate('info_buildings_general');
	} elseif ($BuildID >= 202 && $BuildID <= 216) {
		// Flotte
		$PageTPL              = gettemplate('info_buildings_fleet');
		$parse['element_typ'] = $lang['tech'][200];
		$parse['rf_info_to']  = ShowRapidFireTo ($BuildID);   // Rapid Fire vers
		$parse['rf_info_fr']  = ShowRapidFireFrom ($BuildID); // Rapid Fire de
		$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']); // Points de Structure
		$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);  // Points de Bouclier
		$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);  // Points d'Attaque
		$parse['capacity_pt'] = pretty_number ($pricelist[$BuildID]['capacity']); // Capacitée de fret
		$parse['base_speed']  = pretty_number ($pricelist[$BuildID]['speed']);    // Vitesse de base
		$parse['base_conso']  = pretty_number ($pricelist[$BuildID]['consumption']);  // Consommation de base
		if ($BuildID == 202) {
			$parse['upd_speed']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['speed2']) .")</font>";       // Vitesse rééquipée
			$parse['upd_conso']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['consumption2']) .")</font>"; // Consommation apres rééquipement
		} elseif ($BuildID == 211) {
			$parse['upd_speed']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['speed2']) .")</font>";       // Vitesse rééquipée
		}
	} elseif ($BuildID >= 401 && $BuildID <= 408) {
		// Defenses
		$PageTPL              = gettemplate('info_buildings_defense');
		$parse['element_typ'] = $lang['tech'][400];

		$parse['rf_info_to']  = ShowRapidFireTo ($BuildID);   // Rapid Fire vers
		$parse['rf_info_fr']  = ShowRapidFireFrom ($BuildID); // Rapid Fire de
		$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']); // Points de Structure
		$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);  // Points de Bouclier
		$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);  // Points d'Attaque
	} elseif ($BuildID >= 502 && $BuildID <= 503) {
		// Misilles
		$PageTPL              = gettemplate('info_buildings_defense');
		$parse['element_typ'] = $lang['tech'][400];
		$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']); // Points de Structure
		$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);  // Points de Bouclier
		$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);  // Points d'Attaque
	} elseif ($BuildID >= 601 && $BuildID <= 615) {
		// Officiers
		$PageTPL              = gettemplate('info_officiers_general');
	}

	// ---- Tableau d'evolution
	if ($TableHeadTPL != '') {
		$parse['table_head']  = parsetemplate ($TableHeadTPL, $lang);
		$parse['table_data']  = ShowProductionTable ($CurrentUser, $CurrentPlanet, $BuildID, $TableTPL);
	}

	// La page principale
	$page  = parsetemplate($PageTPL, $parse);
	if ($GateTPL != '') {
		if ($CurrentPlanet[$resource[$BuildID]] > 0) {
			$RestString               = GetNextJumpWaitTime ( $CurrentPlanet );
			$parse['gate_start_link'] = BuildPlanetAdressLink ( $CurrentPlanet );
			if ($RestString['value'] != 0) {
				$parse['gate_time_script'] = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], true );
				$parse['gate_wait_time']   = "<div id=\"bxx". "Gate" . "1" ."\"></div>";
				$parse['gate_script_go']   = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], false );
			} else {
				$parse['gate_time_script'] = "";
				$parse['gate_wait_time']   = "";
				$parse['gate_script_go']   = "";
			}
			$parse['gate_dest_moons'] = BuildJumpableMoonCombo ( $CurrentUser, $CurrentPlanet );
			$parse['gate_fleet_rows'] = BuildFleetListRows ( $CurrentPlanet );
			$page .= parsetemplate($GateTPL, $parse);
		}
	}

	if ($DestroyTPL != '') {
		if ($CurrentPlanet[$resource[$BuildID]] > 0) {
			// ---- Destruction
			$NeededRessources     = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $BuildID, true, true);
			$DestroyTime          = GetBuildingTime  ($CurrentUser, $CurrentPlanet, $BuildID) / 2;
			$parse['destroyurl']  = Wootook::getUrl('empire/buildings/destroy', array('id' => $BuildID)); // Non balisé les balises sont dans le tpl
			$parse['levelvalue']  = $CurrentPlanet[$resource[$BuildID]]; // Niveau du batiment a detruire
			$parse['nfo_metal']   = $lang['Metal'];
			$parse['nfo_crysta']  = $lang['Crystal'];
			$parse['nfo_deuter']  = $lang['Deuterium'];
			$parse['metal']       = pretty_number ($NeededRessources['metal']);     // Cout en metal de la destruction
			$parse['crystal']     = pretty_number ($NeededRessources['crystal']);   // Cout en cristal de la destruction
			$parse['deuterium']   = pretty_number ($NeededRessources['deuterium']); // Cout en deuterium de la destruction
			$parse['destroytime'] = pretty_time   ($DestroyTime);                   // Durée de la destruction
			// L'insert de destruction
			$page .= parsetemplate($DestroyTPL, $parse);
		}
	}

	return $page;
}

// ----------------------------------------------------------------------------------------------------------
// Appel de la page ...
// Tout le reste ne sert qu'a la calculer :)
//

	$gid  = $_GET['gid'];
	$page = ShowBuildingInfoPage ($user, $planetrow, $gid);

	display ($page, $lang['nfo_page_title']);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Réécriture (réinventation de l'eau tiède)
// 1.1 - Ajout JumpGate pour la porte de saut comme la présente OGame ... Enfin un peu mieux quand meme !
?>
