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

/**
 *
 * @deprecated
 * @param unknown_type $FleetRow
 */
function MissionCaseExpedition ( $FleetRow ) {
	global $lang, $resource, $pricelist;

	$FleetOwner = $FleetRow['fleet_owner'];
	$MessSender = $lang['sys_mess_qg'];
	$MessTitle  = $lang['sys_expe_report'];

	if ($FleetRow['fleet_mess'] == 0) {
		// Flotte en vol aller
		if ($FleetRow['fleet_end_stay'] < time()) {
			// La Flotte vient de finir son exploration
			// Table de ratio de points par type de vaisseau
			$PointsFlotte = array(
				202 => 1.0,  // 'Petit transporteur'
				203 => 1.5,  // 'Grand transporteur'
				204 => 0.5,  // 'Chasseur léger'
				205 => 1.5,  // 'Chasseur lourd'
				206 => 2.0,  // 'Croiseur'
				207 => 2.5,  // 'Vaisseau de bataille'
				208 => 0.5,  // 'Vaisseau de colonisation'
				209 => 1.0,  // 'Recycleur'
				210 => 0.01, // 'Sonde espionnage'
				211 => 3.0,  // 'Bombardier'
				212 => 0.0,  // 'Satellite solaire'
				213 => 3.5,  // 'Destructeur'
				214 => 5.0,  // 'Etoile de la mort'
				215 => 3.2,  // 'Traqueur'
			);

			// Table de ratio de gains en nombre par type de vaisseau
			$RatioGain = array (
				202 => 0.1,     // 'Petit transporteur'
				203 => 0.1,     // 'Grand transporteur'
				204 => 0.1,     // 'Chasseur léger'
				205 => 0.5,     // 'Chasseur lourd'
				206 => 0.25,    // 'Croiseur'
				207 => 0.125,   // 'Vaisseau de bataille'
				208 => 0.5,     // 'Vaisseau de colonisation'
				209 => 0.1,     // 'Recycleur'
				210 => 0.1,     // 'Sonde espionnage'
				211 => 0.0625,  // 'Bombardier'
				212 => 0.0,     // 'Satellite solaire'
				213 => 0.0625,  // 'Destructeur'
				214 => 0.03125, // 'Etoile de la mort'
				215 => 0.0625,  // 'Traqueur'
			);

			$FleetStayDuration = ($FleetRow['fleet_end_stay'] - $FleetRow['fleet_start_time']) / 3600;

			// Initialisation du contenu de la Flotte
			$farray = explode(";", $FleetRow['fleet_array']);
			foreach ($farray as $Item => $Group) {
				if ($Group != '') {
					$Class = explode (",", $Group);
					$TypeVaisseau = $Class[0];
					$NbreVaisseau = $Class[1];

					$LaFlotte[$TypeVaisseau] = $NbreVaisseau;

					//On calcul les ressources maximum qui peuvent être récupéré
					$FleetCapacity += $pricelist[$TypeVaisseau]['capacity'];
					// Maintenant on calcul en points toute la flotte
					$FleetPoints   += ($NbreVaisseau * $PointsFlotte[$TypeVaisseau]);
				}
			}

			// Espace deja occupé dans les soutes si ce devait etre le cas
			$FleetUsedCapacity  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'];
			$FleetCapacity     -= $FleetUsedCapacity;

			//On récupère le nombre total de vaisseaux
			$FleetCount = $FleetRow['fleet_amount'];

			// Bon on les mange comment ces explorateurs ???
			$Hasard = rand(0, 10);

			$MessSender = $lang['sys_mess_qg']. "(".$Hasard.")";

			if ($Hasard < 3) {
				// Pas de bol, on les mange tout crus
				$Hasard     += 1;
				$LostAmount  = (($Hasard * 33) + 1) / 100;

				// Message pour annoncer la bonne mauvaise nouvelle
				if ($LostAmount == 100) {
					// Supprimer effectivement la flotte
					SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_2'] );
					doquery ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				} else {
					foreach ($LaFlotte as $Ship => $Count) {
						$LostShips[$Ship] = intval($Count * $LostAmount);
						$NewFleetArray   .= $Ship.",". ($Count - $LostShips[$Ship]) .";";
					}

					$QryUpdateFleet  = "UPDATE {{table}} SET ";
					$QryUpdateFleet .= "`fleet_array` = '". $NewFleetArray ."', ";
					$QryUpdateFleet .= "`fleet_mess` = '1'  ";
					$QryUpdateFleet .= "WHERE ";
					$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
					doquery( $QryUpdateFleet, 'fleets');
					SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_1'] );
				}

			} elseif ($Hasard == 3) {
				// Ah un tour pour rien
				doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_1'] );
			} elseif ($Hasard >= 4 && $Hasard < 7) {
				// Gains de ressources
				if ($FleetCapacity > 5000) {
					$MinCapacity = $FleetCapacity - 5000;
					$MaxCapacity = $FleetCapacity;
					$FoundGoods  = rand($MinCapacity, $MaxCapacity);
					$FoundMetal  = intval($FoundGoods / 2);
					$FoundCrist  = intval($FoundGoods / 4);
					$FoundDeute  = intval($FoundGoods / 6);

					$QryUpdateFleet  = "UPDATE {{table}} SET ";
					$QryUpdateFleet .= "`fleet_resource_metal` = `fleet_resource_metal` + '". $FoundMetal ."', ";
					$QryUpdateFleet .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '". $FoundCrist ."', ";
					$QryUpdateFleet .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '". $FoundDeute ."', ";
					$QryUpdateFleet .= "`fleet_mess` = '1'  ";
					$QryUpdateFleet .= "WHERE ";
					$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
					doquery( $QryUpdateFleet, 'fleets');
					$Message = sprintf($lang['sys_expe_found_goods'],
						pretty_number($FoundMetal), $lang['Metal'],
						pretty_number($FoundCrist), $lang['Crystal'],
						pretty_number($FoundDeute), $lang['Deuterium']);
					SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message );
				}
			} elseif ($Hasard == 7) {
				// Ah un tour pour rien
				doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_2'] );
			} elseif ($Hasard >= 8 && $Hasard < 11) {
				// Gain de vaisseaux
				$FoundChance = $FleetPoints / $FleetCount;
				for ($Ship = 202; $Ship < 216; $Ship++) {
					if ($LaFlotte[$Ship] != 0) {
						$FoundShip[$Ship] = round($LaFlotte[$Ship] * $RatioGain[$Ship]);
						if ($FoundShip[$Ship] > 0) {
							$LaFlotte[$Ship] += $FoundShip[$Ship];
						}
					}
				}
				$NewFleetArray = "";
				$FoundShipMess = "";
				foreach ($LaFlotte as $Ship => $Count) {
					if ($Count > 0) {
						$NewFleetArray   .= $Ship.",". $Count .";";
					}
				}
				foreach ($FoundShip as $Ship => $Count) {
					if ($Count != 0) {
						$FoundShipMess   .= $Count." ".$lang['tech'][$Ship].",";
					}
				}

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_array` = '". $NewFleetArray ."', ";
				$QryUpdateFleet .= "`fleet_mess` = '1'  ";
				$QryUpdateFleet .= "WHERE ";
				$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
				doquery( $QryUpdateFleet, 'fleets');
				$Message = $lang['sys_expe_found_ships']. $FoundShipMess . "";
				SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message );
			}

		}
	} else {
		// La Flotte est de retour a quai
		if ($FleetRow['fleet_end_time'] < time()) {
			// Reintegration de ce qui se ballade avec la flotte
			$farray = explode(";", $FleetRow['fleet_array']);
			foreach ($farray as $Item => $Group) {
				if ($Group != '') {
					$Class = explode (",", $Group);
					$FleetAutoQuery .= "`". $resource[$Class[0]]. "` = `". $resource[$Class[0]] ."` + ". $Class[1] .", ";
				}
			}
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= $FleetAutoQuery;
			$QryUpdatePlanet .= "`metal` = `metal` + ". $FleetRow['fleet_resource_metal'] .", ";
			$QryUpdatePlanet .= "`crystal` = `crystal` + ". $FleetRow['fleet_resource_crystal'] .", ";
			$QryUpdatePlanet .= "`deuterium` = `deuterium` + ". $FleetRow['fleet_resource_deuterium'] ." ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
			$QryUpdatePlanet .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
			$QryUpdatePlanet .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
			$QryUpdatePlanet .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."' ";
			$QryUpdatePlanet .= "LIMIT 1 ;";
			doquery( $QryUpdatePlanet, 'planets');

			// Message pour annoncer le retour de flotte
			SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_time'], 15, $MessSender, $MessTitle, $lang['sys_expe_back_home'] );

			// Suppression de la flotte
			doquery ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
		}
	}
}

?>