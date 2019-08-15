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

	function GetBuildingTime ($USER, $PLANET, $Element, $Destroy = false)
	{
		global $pricelist, $resource, $reslist, $requeriments;
		
		$CONF	= getConfig($USER['universe']);
		$level = isset($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];
				
		$Cost   = floor($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level)) + floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
	
		if (in_array($Element, $reslist['build'])) {
			
		if($USER['commander'] >= 1 xor $USER['raza'] == 0) {		
			$tiempo	= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[14]])) * pow(0.5, $PLANET[$resource[15]]);	
			$porcentaje = $tiempo * 10/100;
			$time = $tiempo - $porcentaje;
		} elseif($USER['commander'] >= 1 and $USER['raza'] == 0) {
		$tiempo	= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[14]])) * pow(0.5, $PLANET[$resource[15]]);	
			$porcentaje = $tiempo * 20/100;
			$time = $tiempo - $porcentaje;
		} else {
			$time			= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[14]])) * pow(0.5, $PLANET[$resource[15]]);	
		} } elseif (in_array($Element, $reslist['fleet'])) {
			if($USER['commander'] >= 1 xor $USER['raza'] == 1) {
			@$tiempo			= $Cost / ($CONF['game_speed'] * (1 + ($PLANET[$resource[21]] + $PLANET[$resource[14]]))) * pow(0.5, $PLANET[$resource[15]]);
			$porcentaje = $tiempo * 10/100;
			$time = $tiempo - $porcentaje;
		} elseif($USER['commander'] >= 1 and $USER['raza'] == 1) {
			@$tiempo			= $Cost / ($CONF['game_speed'] * (1 + ($PLANET[$resource[21]] + $PLANET[$resource[14]]))) * pow(0.5, $PLANET[$resource[15]]);
			$porcentaje = $tiempo * 20/100;
			$time = $tiempo - $porcentaje;
		} else {
			@$time			= $Cost / ($CONF['game_speed'] * (1 + ($PLANET[$resource[21]] + $PLANET[$resource[14]]))) * pow(0.5, $PLANET[$resource[15]]);	
		} }elseif (in_array($Element, $reslist['defense'])) {
			if($USER['commander'] >= 1) {
			@$tiempo= $Cost / ($CONF['game_speed'] * (1 + ($PLANET[$resource[21]] + $PLANET[$resource[14]]))) * pow(0.5, $PLANET[$resource[15]]);
			$porcentaje = $tiempo * 10/100;
			$time = $tiempo - $porcentaje;
		} else {
			@$time= $Cost / ($CONF['game_speed'] * (1 + ($PLANET[$resource[21]] + $PLANET[$resource[14]]))) * pow(0.5, $PLANET[$resource[15]]);
		} } elseif (in_array($Element, $reslist['tech']))
		{
			if(is_array($PLANET[$resource[31].'_inter']))
			{
				$Level = 0;
				foreach($PLANET[$resource[31].'_inter'] as $Levels)
				{
					if($Levels >= $requeriments[$Element][31])
						$Level += $Levels;
				}
			} else{
				$Level	= $PLANET[$resource[31]];
			}
			
			if($USER['commander'] >= 1 and $USER['technocratic'] >= 1) {
				#Nuevo valor de prueba, hay que ver si ahora resulta.
				$tiempo			= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[31]])) * pow(0.5, $PLANET[$resource[6]]) + (0.3 - $comandante_tecnos);
				$porcentaje = $tiempo * 35/100;
				$time = $tiempo - $porcentaje;
			} elseif($USER['commander'] >= 1 and $USER['technocratic'] <= 0) {
				$tiempo			= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[31]])) * pow(0.5, $PLANET[$resource[6]]) + (0.3 - $comandante_tecnos);
				$porcentaje = $tiempo * 10/100;
				$time = $tiempo - $porcentaje;
			}elseif($USER['commander'] <= 0 and $USER['technocratic'] >= 1) {
				$tiempo			= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[31]])) * pow(0.5, $PLANET[$resource[6]]) + (0.3 - $comandante_tecnos);
				$porcentaje = $tiempo * 25/100;
				$time = $tiempo - $porcentaje;
			} elseif($USER['commander'] >= 1 and $USER['technocratic'] >= 1 and $USER['raza'] == 1) {
				$tiempo			= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[31]])) * pow(0.5, $PLANET[$resource[6]]) + (0.3 - $comandante_tecnos);
				$porcentaje = $tiempo * 45/100;
				$time = $tiempo - $porcentaje;
			} elseif($USER['commander'] >= 1 and $USER['technocratic'] <= 0 and $USER['raza'] == 1) {
				$tiempo			= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[31]])) * pow(0.5, $PLANET[$resource[6]]) + (0.3 - $comandante_tecnos);
				$porcentaje = $tiempo * 20/100;
				$time = $tiempo - $porcentaje;
			}elseif($USER['commander'] <= 0 and $USER['technocratic'] >= 1 and $USER['raza'] == 1) {
				$tiempo			= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[31]])) * pow(0.5, $PLANET[$resource[6]]) + (0.3 - $comandante_tecnos);
				$porcentaje = $tiempo * 35/100;
				$time = $tiempo - $porcentaje;
			} else { #Nuevo valor de prueba, hay que ver si ahora resulta (Sin comandante).
				$time			= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[31]])) * pow(0.5, $PLANET[$resource[6]]) + (0.3 - $comandante_tecnos);
			}			
        }
		
		if(!$Destroy)
			$time	= floor($time * 3600);
		else
			$time	= floor($time * 1300);
		
		return max($time, $CONF['min_build_time']);
	}

?>