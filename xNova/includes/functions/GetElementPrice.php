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

function GetElementPrice ($USER, $PLANET, $Element, $USERfactor = true, $level = false)
	{
		global $pricelist, $resource, $LNG, $dpath;

		//if ($USERfactor) // OLD CODE
		if ($USERfactor && ($level === false)) // FIX BY JSTAR
			$level = ($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];

		$is_buyeable = true;

		$array = array(
			'metal'      => $LNG['Metal'],
			'crystal'    => $LNG['Crystal'],
			'deuterium'  => $LNG['Deuterium'],
			'norio'      => $LNG['Norio'],
			'energy_max' => $LNG['Energy'],
		    'darkmatter' => $LNG['Darkmatter'],
		);
				if($USER['raza'] == 0) {
                    $skin_raza = "gultra";
                } elseif ($USER['raza'] == 1) {
						$skin_raza = "voltra";
                }
     $text = "";  
	foreach ($array as $ResType => $ResTitle) {
         if ($pricelist[$Element][$ResType] != 0) { 
             if ($USERfactor) { 
				if($USER['geologe'] >= 1) {
					$coste =  floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)); 
					$porcentaje = $coste * 20 / 100;
					$cost = $coste - $porcentaje;
                } else {
					$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)); 
				}
             } else { 
                $coste =  floor($pricelist[$Element][$ResType]); 
				$porcentaje = $coste * 20 / 100;
				$cost = floor($pricelist[$Element][$ResType]); 
             } 
			
			if ($cost > $PLANET[$ResType])
            {
				if($USER['geologe'] >= 1) {
					$coste = "<b style=color:red;>" . pretty_number ($cost) . " (-20%)</b>";
				} else {
					$coste = "<b style=color:red;>" . pretty_number ($cost) . "</b>";
				}
               $is_buyeable = false;
            }	else {
				if($USER['geologe'] >= 1) {
					$coste = "<b style=color:lime;>" . pretty_number($cost) . " (-20%)</b> ";
				} else {
					$coste = "<b style=color:lime;>" . pretty_number($cost) . "</b> ";
				}
			}
			} 
         if ($pricelist[$Element][$ResType] != 0) {
       $text .= "<img style=\"padding-left:2px;padding-bottom:1px;padding-top:2px;float:left;\" src=styles/theme/" .$skin_raza ."/adds/" .$ResType .".jpg class=\"tooltip\" name=\"" .$ResTitle .": " .$coste ."\" width=\"30\" height=\"20\" />";					
         } 
     }
	 $text .= "";
     return $text; 
 }  
 
?>