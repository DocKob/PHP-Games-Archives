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

	function IsElementBuyable ($USER, $PLANET, $Element, $Incremental = true, $ForDestroy = false)
	{
		global $pricelist, $resource;

		include_once(ROOT_PATH . 'includes/functions/IsVacationMode.php');

	    if (IsVacationMode($USER))
	       return false;

		if ($Incremental)
			$level  = isset($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];

		$array    = array('metal', 'crystal', 'deuterium', 'norio', 'energy_max', 'darkmatter');

		foreach ($array as $ResType)
		{
			if (empty($pricelist[$Element][$ResType]))
				continue;
			
			$cost[$ResType] = $Incremental ? floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)) : floor($pricelist[$Element][$ResType]);

			if ($ForDestroy)
				$cost[$ResType]  = floor($cost[$ResType] / 2);

			if ((isset($PLANET[$ResType]) && $cost[$ResType] > $PLANET[$ResType]) || (isset($USER[$ResType]) && $cost[$ResType] > $USER[$ResType]))
				return false;
		}
		return true;
	}

?>