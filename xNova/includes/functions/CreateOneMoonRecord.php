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

	function CreateOneMoonRecord($Galaxy, $System, $Planet, $Universe, $Owner, $MoonID, $MoonName, $Chance, $Size = 0)
	{
		global $LNG, $USER, $db;

		$SQL  = "SELECT id_luna,planet_type,id,name,temp_max,temp_min FROM ".PLANETS." ";
		$SQL .= "WHERE ";
		$SQL .= "`universe` = '".$Universe."' AND ";
		$SQL .= "`galaxy` = '".$Galaxy."' AND ";
		$SQL .= "`system` = '".$System."' AND ";
		$SQL .= "`planet` = '".$Planet."' AND ";
		$SQL .= "`planet_type` = '1';";
		$MoonPlanet = $db->uniquequery($SQL);

		if ($MoonPlanet['id_luna'] != 0)
			return false;

		if($Size == 0) {
			$size	= floor(pow(mt_rand(10, 20) + 3 * $Chance, 0.5) * 1000); 
		} else {
			$size	= $Size;
		}
		
		$maxtemp    = $MoonPlanet['temp_max'] - mt_rand(10, 45);
		$mintemp    = $MoonPlanet['temp_min'] - mt_rand(10, 45);

		$SQL  = "INSERT INTO ".PLANETS." SET ";
		#$SQL .= "`name` = '".( ($MoonName == '') ? $LNG['fcm_moon'] : $MoonName )."', ";
		$SQL .= "`name` = '".$LNG['fcm_moon']."', ";
		$SQL .= "`id_owner` = '".$Owner."', ";
		$SQL .= "`universe` = '".$Universe."', ";
		$SQL .= "`galaxy` = '".$Galaxy."', ";
		$SQL .= "`system` = '".$System."', ";
		$SQL .= "`planet` = '".$Planet."', ";
		$SQL .= "`last_update` = '".TIMESTAMP."', ";
		$SQL .= "`planet_type` = '3', ";
		$SQL .= "`image` = 'mond', ";
		$SQL .= "`diameter` = '".$size."', ";
		$SQL .= "`field_max` = '1', ";
		$SQL .= "`temp_min` = '".$mintemp."', ";
		$SQL .= "`temp_max` = '".$maxtemp."', ";
		$SQL .= "`metal` = '0', ";
		$SQL .= "`metal_perhour` = '0', ";
		$SQL .= "`metal_max` = '".BASE_STORAGE_SIZE."', ";
		$SQL .= "`crystal` = '0', ";
		$SQL .= "`crystal_perhour` = '0', ";
		$SQL .= "`crystal_max` = '".BASE_STORAGE_SIZE."', ";
		$SQL .= "`deuterium` = '0', ";
		$SQL .= "`deuterium_perhour` = '0', ";
		$SQL .= "`deuterium_max` = '".BASE_STORAGE_SIZE."',";
		$SQL .= "`norio` = '0', ";
		$SQL .= "`norio_perhour` = '0', ";
		$SQL .= "`norio_max` = '".BASE_STORAGE_SIZE."'; ";
		$db->query($SQL);
				
		$SQL  = "UPDATE ".PLANETS." SET ";
		$SQL .= "`id_luna` = '".$db->GetInsertID()."' ";
		$SQL .= "WHERE ";
		$SQL .= "`universe` = '".$Universe."' AND ";
		$SQL .= "`galaxy` = '".$Galaxy."' AND ";
		$SQL .= "`system` = '".$System."' AND ";
		$SQL .= "`planet` = '".$Planet."' AND ";
		$SQL .= "`planet_type` = '1';";				
		$db->query($SQL);

		return $MoonPlanet['name'];
	}

?>