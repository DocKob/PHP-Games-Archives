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

function calculateMIPAttack($TargetDefTech, $OwnerAttTech, $ipm, $TargetDefensive, $pri_target, $adm)
{
	global $pricelist, $reslist, $CombatCaps;
	// Based on http://websim.speedsim.net/ JS-IRak Simulation
	unset($TargetDefensive[503]);
	$GetTargetKeys	= array_keys($TargetDefensive);
	
	$life_fac		= $TargetDefTech / 10 + 1;
	$life_fac_a 	= $CombatCaps[503]['attack'] * ($OwnerAttTech / 10 + 1);
	
	$ipm -= $adm;
	$adm = 0;
	$max_dam = $ipm * $life_fac_a;
	$i = 0;	

	$ship_res = array();
	foreach($TargetDefensive as $Element => $Count)
	{
		if($i == 0)
			$target = $pri_target;
		elseif($Element <= $pri_target)
			$target = $Element - 1;
		else
			$target = $Element;
		
		
		$Dam = $max_dam - ($pricelist[$target]['metal'] + $pricelist[$target]['crystal'] + $pricelist[$target]['norio']) / 10 * $TargetDefensive[$target] * $life_fac;
			
		if($Dam > 0)
		{
			$dest = $TargetDefensive[$target];
			$ship_res[$target] = $dest;
		}
		else
		{
			// not enough damage for all items
			$dest = floor($max_dam / (($pricelist[$target]['metal'] + $pricelist[$target]['crystal'] + $pricelist[$target]['norio']) / 10 * $life_fac));
			$ship_res[$target] = $dest;
		}
		$max_dam -= $dest * round(($pricelist[$target]['metal'] + $pricelist[$target]['crystal'] + $pricelist[$target]['norio']) / 10 * $life_fac);
		$i++;
	}
		
	return $ship_res;
}
	
?>