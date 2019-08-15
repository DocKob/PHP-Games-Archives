<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |5
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|Core.
 * @author: Copyright (C) 2011 by Brayan Narvaez (Prinick) developer of xNova Revolution
 * @author web: http://www.bnarvaez.com
 * @link: http://www.xnovarev.com

 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/

 * Please do not remove the credits
*/

function calculateSteal($attackFleets, $defenderPlanet, $ForSim = false)
{	
	//Steal-Math by Slaver for 2Moons(http://www.titanspace.org) based on http://www.owiki.de/Beute
	global $pricelist, $db;
	
	$SortFleets = array();
	$Sumcapacity  = '0';
	foreach($attackFleets as $FleetID => $Attacker)
	{
		$SortFleets[$FleetID]		= '0';
		foreach($Attacker['detail'] as $Element => $amount)	
		{
			$SortFleets[$FleetID]		= bcadd($SortFleets[$FleetID], bcmul($pricelist[$Element]['capacity'], floattostring($amount)));
		}
		
		$SortFleets[$FleetID]	= bcsub($SortFleets[$FleetID], $Attacker['fleet']['fleet_resource_metal']);
		$SortFleets[$FleetID]	= bcsub($SortFleets[$FleetID], $Attacker['fleet']['fleet_resource_crystal']);
		$SortFleets[$FleetID]	= bcsub($SortFleets[$FleetID], $Attacker['fleet']['fleet_resource_deuterium']);
		$SortFleets[$FleetID]	= bcsub($SortFleets[$FleetID], $Attacker['fleet']['fleet_resource_norio']);
		$Sumcapacity			= bcadd($Sumcapacity, $SortFleets[$FleetID]);
	}
	
	$AllCapacity		= $Sumcapacity;

	// Step 1
	$booty['metal'] 	= min(bcdiv($Sumcapacity, 3), bcdiv(floattostring($defenderPlanet['metal']), 2));
	$Sumcapacity		= bcsub($Sumcapacity, $booty['metal']);
	 
	// Step 2
	$booty['crystal'] 	= min(bcdiv($Sumcapacity, 2), bcdiv(floattostring($defenderPlanet['crystal']), 2));
	$Sumcapacity		= bcsub($Sumcapacity, $booty['crystal']);
	
	// Step 3
	$booty['norio'] 	= min(bcdiv($Sumcapacity, 2), bcdiv(floattostring($defenderPlanet['norio']), 2));
	$Sumcapacity		= bcsub($Sumcapacity, $booty['norio']);
	
	// Step 4
	$booty['deuterium'] = min($Sumcapacity, bcdiv(floattostring($defenderPlanet['deuterium']), 2));
	$Sumcapacity		= bcsub($Sumcapacity, $booty['deuterium']);
		 
	$oldMetalBooty  	= $booty['metal'];
	$booty['metal'] 	= bcadd($booty['metal'], min(bcdiv($Sumcapacity, 3), max(bcsub(bcdiv(floattostring($defenderPlanet['metal']), 2), $booty['metal']), 0)));
	$Sumcapacity		= bcsub($Sumcapacity, bcsub($booty['metal'], $oldMetalBooty));
		 
	$booty['crystal'] 	= bcadd($booty['crystal'], min($Sumcapacity, max(bcsub(bcdiv(floattostring($defenderPlanet['crystal']), 2), $booty['crystal']), 0)));
				
	if($ForSim) 
		return $booty;

	$Qry	= "";

	
	foreach($SortFleets as $FleetID => $Capacity)
	{
		$Factor			= bcdiv($Capacity, $AllCapacity, 10);
		$Qry .= "UPDATE ".FLEETS." SET ";
		$Qry .= "`fleet_resource_metal` = `fleet_resource_metal` + '".bcmul($booty['metal'], $Factor, 0)."', ";
		$Qry .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '".bcmul($booty['crystal'], $Factor, 0)."', ";
		$Qry .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '".bcmul($booty['deuterium'], $Factor, 0)."', ";
		$Qry .= "`fleet_resource_norio` = `fleet_resource_norio` + '".bcmul($booty['norio'], $Factor, 0)."' ";
		$Qry .= "WHERE fleet_id = '".$FleetID."';";		
	}
	
	$db->multi_query($Qry);
	return $booty;
}
	
?>