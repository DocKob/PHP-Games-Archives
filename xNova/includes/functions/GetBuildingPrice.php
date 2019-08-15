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

if(!defined('INSIDE')) die('Hacking attempt!');

	function GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, $Incremental = true, $ForDestroy = false)
	{
		global $pricelist, $resource;
		
		if ($Incremental)
			$level = (isset($CurrentPlanet[$resource[$Element]])) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];

		$array = array('metal', 'crystal', 'deuterium', 'norio', 'darkmatter', 'energy_max');
		foreach ($array as $ResType)
		{
			
			if ($CurrentUser['geologe'] >= 1) {
			$cost[$ResType] = $Incremental ? floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)) : floor($pricelist[$Element][$ResType]);
			$porcentaje = $cost[$ResType] * 20 / 100;
			$cost[$ResType] = $cost[$ResType] - $porcentaje;
			} else {
			$cost[$ResType] = $Incremental ? floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)) : floor($pricelist[$Element][$ResType]);
			}

			if ($ForDestroy == true)
				$cost[$ResType] /= 2;
		}
		
		return ($cost);
	}
?>