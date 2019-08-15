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

includeLang('fleet');

	$Mode   = $_GET['mode'];
	$Galaxy = $_GET['g'];
	$System = $_GET['s'];
	$Planet = $_GET['p'];
	$TypePl = $_GET['t'];

	// Cadre liste de flottes ...
	$missiontype = array(
		1 => $lang['type_mission'][1],
		2 => $lang['type_mission'][2],
		3 => $lang['type_mission'][3],
		4 => $lang['type_mission'][4],
		5 => $lang['type_mission'][5],
		6 => $lang['type_mission'][6],
		7 => $lang['type_mission'][7],
		8 => $lang['type_mission'][8],
		9 => $lang['type_mission'][9],
		15 => $lang['type_mission'][15]
		);

	if ($Mode == 8) {
		$QrySelectGalaxy  = "SELECT * FROM {{table}} ";
		$QrySelectGalaxy .= "WHERE ";
		$QrySelectGalaxy .= "`galaxy` = '".$planetrow['galaxy']."' AND ";
		$QrySelectGalaxy .= "`system` = '".$planetrow['system']."' AND ";
		$QrySelectGalaxy .= "`planet` = '".$planetrow['planet']."' ";
		$QrySelectGalaxy .= "LIMIT 1;";
		$TargetGalaxy     = doquery( $QrySelectGalaxy, 'galaxy', true);
		$DebrisSize       = $TargetGalaxy['metal'] + $TargetGalaxy['crystal'];
		$RecyclerNeeded   = floor($DebrisSize / ($pricelist[209]['capacity'])) + 1;
		$RecyclerSpeed    = $pricelist[209]['speed'] + (($pricelist[209]['speed'] * $user['combustion_tech']) * 0.1);

		$RecyclerCount    = $planetrow[$resource[209]];
		if ($RecyclerCount > $RecyclerNeeded) {
			$FleetCount = $RecyclerNeeded;
		} else {
			$FleetCount = $RecyclerCount;
		}
		$FleetArray[209] = $FleetCount;
	}

	$distance      = GetTargetDistance  ( $planetrow['galaxy'], $Galaxy, $planetrow['system'], $System, $planetrow['planet'], $Planet );
	$SpeedFactor   = Wootook::getGameConfig('game/speed/fleet') / 2500;
	$GenFleetSpeed = 10; // a 100%
	$duration      = GetMissionDuration ( $GenFleetSpeed, $RecyclerSpeed, $distance, $SpeedFactor );

	$page .= "<br /><br />";
	$page .= "<center>";
	$page .= "<table width=\"519\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\">";
	$page .= "<tr height=\"20\">";
	$page .= "<td class=\"c\" colspan=\"2\">";
	$page .= "<span class=\"success\">".$lang['fl_fleet_send']."</span>";
	$page .= "</td>";
	$page .= "</tr>";
	$page .= "<tr height=\"20\">";
	$page .= "<th>". $lang['fl_mission'] ."</th>";
	$page .= "<th>". $missiontype[$Mode] ."</th>";
	$page .= "</tr>";
	$page .= "<tr height=\"20\">";
	$page .= "<th>". $lang['fl_dist'] ."</th>";
	$page .= "<th>". $distance ."</th>";
	$page .= "</tr>";
	$page .= "<tr height=\"20\">";
	$page .= "<th>". $lang['fl_fleetspeed'] ."</th>";
	$page .= "<th>28750</th>";
	$page .= "</tr>";
	$page .= "<tr height=\"20\">";
	$page .= "<th>". $lang['fl_deute_need'] ."</th>";
	$page .= "<th>10</th>";
	$page .= "</tr>";
	$page .= "<tr height=\"20\">";
	$page .= "<th>". $lang['fl_from'] ."</th>";
	$page .= "<th>[". $planetrow['galaxy'] .":". $planetrow['system'] .":". $planetrow['planet'] ."]</th>";
	$page .= "</tr>";
	$page .= "<tr height=\"20\">";
	$page .= "<th>". $lang['fl_dest'] ."</th>";
	$page .= "<th>[". $Galaxy .":". $System .":". $Planet ."]</th>";
	$page .= "</tr>";
	$page .= "<tr height=\"20\">";
	$page .= "<th>". $lang['fl_time_go'] ."</th>";
	$page .= "<th>". date("M D d H:i:s",($duration + time())) ."</th>";
	$page .= "</tr>";
	$page .= "<tr height=\"20\">";
	$page .= "<th>". $lang['fl_time_back'] ."</th>";
	$page .= "<th>". date("M D d H:i:s",(($duration * 2) + time())) ."</th>";
	$page .= "</tr>";
	$page .= "<tr height=\"20\">";
	$page .= "<td class=\"c\" colspan=\"2\">". $lang['fl_title'] ."</td>";
	$page .= "</tr>";
	$page .= "<tr height=\"20\">";
	$ShipCount = 0;
	$ShipArray = "";
	foreach ($FleetArray as $Ship => $Count) {
		$page            .= "<th width=\"50%\>". $lang['tech'][$Ship] ."</th>";
		$page            .= "<th>". pretty_number($Count) ."</th>";
		$FleetSubQRY     .= "`".$resource[$Ship] . "` = `" . $resource[$Ship] . "` - " . $Count . " , ";
		$ShipArray       .= $Ship.",".$Count.";";
		$ShipCount       += $Count;
	}
	$page .= "		</tr>";
	$page .= "	</table>";

	$QryInsertFleet  = "INSERT INTO {{table}} SET ";
	$QryInsertFleet .= "`fleet_owner` = '". $user['id'] ."', ";
	$QryInsertFleet .= "`fleet_mission` = '". $Mode ."', ";
	$QryInsertFleet .= "`fleet_amount` = '". $ShipCount ."', ";
	$QryInsertFleet .= "`fleet_array` = '". $ShipArray ."', ";
	$QryInsertFleet .= "`fleet_start_time` = '". ($duration + time()) ."', ";
	$QryInsertFleet .= "`fleet_start_galaxy` = '". $planetrow['galaxy'] ."', ";
	$QryInsertFleet .= "`fleet_start_system` = '". $planetrow['system'] ."', ";
	$QryInsertFleet .= "`fleet_start_planet` = '". $planetrow['planet'] ."', ";
	$QryInsertFleet .= "`fleet_start_type` = '". $planetrow['planet_type'] ."', ";
	$QryInsertFleet .= "`fleet_end_time` = '". (($duration * 2) + time()) ."', ";
	$QryInsertFleet .= "`fleet_end_galaxy` = '". $Galaxy ."', ";
	$QryInsertFleet .= "`fleet_end_system` = '". $System ."', ";
	$QryInsertFleet .= "`fleet_end_planet` = '". $Planet ."', ";
	$QryInsertFleet .= "`fleet_end_type` = '". $TypePl ."', ";
	$QryInsertFleet .= "`start_time` = '". time() ."';";
	doquery( $QryInsertFleet, 'fleets');

	$QryUpdatePlanet  = "UPDATE {{table}} SET ";
	$QryUpdatePlanet .= $FleetSubQRY;
	$QryUpdatePlanet .= "`planet_type` = '".$planetrow['planet_type']."' ";
	$QryUpdatePlanet .= "WHERE ";
	$QryUpdatePlanet .= "`id` = '". $planetrow['id'] ."'";
	doquery ($QryUpdatePlanet, "planets");



	display ( $page, "QuickFleet" );

// Updated by Chlorel Jan 22 2008 (all code just hold the table and the idea)
// Created by Perberos. All rights reversed (C) 2006
?>