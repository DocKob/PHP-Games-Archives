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
 
class ShowShipyardPage
{
	public function GetMaxConstructibleElements($Element)
	{
		global $pricelist, $PLANET, $USER;

		if ($pricelist[$Element]['metal'] != 0)
			$MAX[]				= floor($PLANET['metal'] / $pricelist[$Element]['metal']);

		if ($pricelist[$Element]['crystal'] != 0)
			$MAX[]				= floor($PLANET['crystal'] / $pricelist[$Element]['crystal']);

		if ($pricelist[$Element]['deuterium'] != 0)
			$MAX[]				= floor($PLANET['deuterium'] / $pricelist[$Element]['deuterium']);
				
		if ($pricelist[$Element]['norio'] != 0)
			$MAX[]				= floor($PLANET['norio'] / $pricelist[$Element]['norio']);
				
		if ($pricelist[$Element]['darkmatter'] != 0)
			$MAX[]				= floor($USER['darkmatter'] / $pricelist[$Element]['darkmatter']);

		if ($pricelist[$Element]['energy_max'] != 0)
			$MAX[]				= floor($PLANET['energy_max'] / $pricelist[$Element]['energy_max']);

		return min($MAX);
	}

	public function GetElementRessources($Element, $Count)
	{
		global $pricelist;

		$ResType['metal']     	= ($pricelist[$Element]['metal']     * $Count);
		$ResType['crystal']  	= ($pricelist[$Element]['crystal']   * $Count);
		$ResType['deuterium'] 	= ($pricelist[$Element]['deuterium'] * $Count);
		$ResType['norio'] 	    = ($pricelist[$Element]['norio'] * $Count);
		$ResType['darkmatter'] 	= ($pricelist[$Element]['darkmatter'] * $Count);

		return $ResType;
	}
		
	public function CancelAuftr($CancelArray) 
	{
		global $USER, $PLANET;
		$ElementQueue = unserialize($PLANET['b_hangar_id']);
		foreach ($CancelArray as $ID => $Auftr)
		{
			if($Auftr == 0)
				$PLANET['b_hangar']	= 0;
				
			$ElementQ	= $ElementQueue[$Auftr];
			$Element	= $ElementQ[0];
			$Count		= $ElementQ[1];
				
			$Resses					= $this->GetElementRessources($Element, $Count);	
			$PLANET['metal']		+= $Resses['metal']			* 0.6;
			$PLANET['crystal']		+= $Resses['crystal']		* 0.6;
			$PLANET['deuterium']	+= $Resses['deuterium']		* 0.6;
			$PLANET['norio']	    += $Resses['norio']		    * 0.6;
			$USER['darkmatter']		+= $Resses['darkmatter']	* 0.6;
			unset($ElementQueue[$Auftr]);
		}
		#$PLANET['b_hangar_id']	= serialize(array_values($ElementQueue));
		
		if(empty($ElementQueue))
		$PLANET['b_hangar_id']	= '';
		else
		$PLANET['b_hangar_id']	= serialize(array_values($ElementQueue));
		
		FirePHP::getInstance(true)->log("Cola(Hangar): ".$PLANET['b_hangar_id']);
	}
	
	public function GetRestPrice($Element, $Factor = true)
	{
		global $USER, $PLANET, $pricelist, $resource, $LNG;

		if ($Factor)
			$level = isset($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];

		$array = array(
			'metal'      => $LNG['Metal'],
			'crystal'    => $LNG['Crystal'],
			'deuterium'  => $LNG['Deuterium'],
			'norio'      => $LNG['Norio'],
			'energy_max' => $LNG['Energy'],
			'darkmatter' => $LNG['Darkmatter'],
		);
		
		$restprice	= array();
		foreach ($array as $ResType => $ResTitle)
		{
			if ($pricelist[$Element][$ResType] == 0)
				continue;
			
			$cost = $Factor ? floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)) : floor($pricelist[$Element][$ResType]);
			
			$restprice[$ResTitle] = pretty_number(max($cost - (($PLANET[$ResType]) ? $PLANET[$ResType] : $USER[$ResType]), 0));
		}

		return $restprice;
	}

	public function BuildAuftr($fmenge)
        {
                global $USER, $PLANET, $reslist, $CONF, $resource;               
                
                foreach($fmenge as $Element => $Count)
                {
                        if(empty($Count) || !in_array($Element, array_merge($reslist['fleet'], $reslist['defense'])) || !IsTechnologieAccessible($USER, $PLANET, $Element))
                                continue;
                                
                        $Count                  = is_numeric($Count) ? round($Count) : 0;
                        $Count                  = max(min($Count, MAX_FLEET_OR_DEFS_PER_ROW), 0);
                        $MaxElements    = $this->GetMaxConstructibleElements($Element);
                        $Count                  = min($Count, $MaxElements);
						$BuildArray    	= !empty($PLANET['b_hangar_id']) ? unserialize($PLANET['b_hangar_id']) : array();
						
                        if ($Element == 502 or $Element == 503)
                        {
					
						$Misiles	 		= array();
						$Misiles[502]		= $PLANET[$resource[502]];
						$Misiles[503]		= $PLANET[$resource[503]];
						$SiloSize      		= $PLANET[$resource[44]];
						$MaxMissiles   		= $SiloSize * 10;

						foreach($BuildArray as $ElementArray) {
							if(isset($Misiles[$ElementArray[0]]))
								$Misiles[$ElementArray[0]] += $ElementArray[1];
                        }
                                
                                $ActuMissiles  = $Misiles[502] + (2 * $Misiles[503]);
                                $MissilesSpace = max(0, $MaxMissiles - $ActuMissiles);
                                
                                if($Element == 502)
                                        $Count = min($Count, $MissilesSpace);
                                else
                                        $Count = min($Count, floor($MissilesSpace / 2));

                                $Misiles[$Element] += $Count;
                        } elseif(in_array($Element, $reslist['one'])) {
                               $InBuild	= false;
								foreach($BuildArray as $ElementArray) {		
									if($ElementArray[1] == $Element) {
								$InBuild	= true;		
								break;		
							}
						}
						
						if($Count != 0 && $PLANET[$resource[$Element]] == 0 && $InBuild === false)
						$Count 		=  1;
                    }

                        if(empty($Count))
                                continue;
                                
						$Ressource 	 			= $this->GetElementRessources($Element, $Count);
						$PLANET['metal']	 	-= $Ressource['metal'];
						$PLANET['crystal']   	-= $Ressource['crystal'];
						$PLANET['deuterium'] 	-= $Ressource['deuterium'];
						$PLANET['norio'] 	    -= $Ressource['norio'];
						$USER['darkmatter']  	-= $Ressource['darkmatter'];

                        $BuildArray[]			= array($Element, floattostring($Count));
						$PLANET['b_hangar_id']	= serialize($BuildArray);
						FirePHP::getInstance(true)->log("Cola(Hangar): ".$PLANET['b_hangar_id']);
                }
        }
	
	public function FleetBuildingPage()
	{
		global $PLANET, $USER, $LNG, $resource, $dpath, $db, $reslist;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');
		
		$template	= new template();
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		
		if ($PLANET[$resource[21]] == 0)
		{
			$PlanetRess->SavePlanetToDB();
			$template->message($LNG['bd_shipyard_required']);
			exit;
		}
		
		$fmenge	= $_POST['fmenge'];
		$cancel	= request_var('auftr', range(0, MAX_FLEET_OR_DEFS_IN_BUILD - 1));
		$action	= request_var('action', '');
				
		$NotBuilding = true;

		if (!empty($PLANET['b_building_id']))
		{
			$CurrentQueue 	= unserialize($PLANET['b_building_id']);
			foreach($CurrentQueue as $ElementArray) {
				if($ElementArray[0] == 21 || $ElementArray[0] == 15) {
					$NotBuilding = false;
					break;
				}
			}
		}

		$ElementQueue 	= unserialize($PLANET['b_hangar_id']);
		if(empty($ElementQueue))
			$Count	= 0;	
		else
			$Count	= count($ElementQueue);		
		if($USER['urlaubs_modus'] == 0) {
			if (!empty($fmenge) && $NotBuilding == true) {
				if ($Count >= MAX_FLEET_OR_DEFS_IN_BUILD) {
					$template->message(sprintf($LNG['bd_max_builds'], MAX_FLEET_OR_DEFS_IN_BUILD), "?page=buildings&mode=fleet", 3);
					exit;
				}
				$this->BuildAuftr($fmenge);
			}
			if ($action == "delete" && is_array($cancel))	
				$this->CancelAuftr($cancel);			
		}
		$PlanetRess->SavePlanetToDB();
				
		foreach($reslist['fleet'] as $Element)
		{
			if (IsTechnologieAccessible($USER, $PLANET, $Element))
			{
				$FleetList[]	= array(
					'id'			=> $Element,
					'name'			=> $LNG['tech'][$Element],
					'descriptions'	=> $LNG['res']['descriptions'][$Element],
					'price'			=> GetElementPrice($USER, $PLANET, $Element, false),
					'restprice'		=> $this->GetRestPrice($Element, false),
					'time'			=> pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
					'IsAvailable'	=> IsElementBuyable($USER, $PLANET, $Element, false),
					'GetMaxAmount'	=> floattostring($this->GetMaxConstructibleElements($Element)),
					'Available'		=> pretty_number($PLANET[$resource[$Element]]),
				);
			}
		}
		
		$Buildlist	= array();
		
		if($USER['raza'] == 0) {
		$skin_raza = "gultra";
		} elseif ($USER['raza'] == 1) {
		$skin_raza = "voltra";
		} 
		
		$ElementQueue 	= unserialize($PLANET['b_hangar_id']);		
		if(!empty($ElementQueue)) {
			$Shipyard		= array();
			$QueueTime		= 0;
			foreach($ElementQueue as $Element)
			{
				if (empty($Element))
					continue;
					
				$ElementTime  	= GetBuildingTime($USER, $PLANET, $Element[0]);
				$QueueTime   	+= $ElementTime * $Element[1];
				$Shipyard[]		= array($LNG['tech'][$Element[0]], $Element[1], $ElementTime, $Element[0]);		
			}

			$template->loadscript('bcmath.js');
			$template->loadscript('shipyard.js');
			$template->execscript('ShipyardInit();');
			
			$Buildlist	= array(
				'Queue' 				=> $Shipyard,
				'b_hangar_id_plus' 		=> $PLANET['b_hangar'],
				'skin_raza' 	=> $skin_raza,
				'pretty_time_b_hangar' 	=> pretty_time(max($QueueTime - $PLANET['b_hangar'],0)),
			);
		}
		
		$template->assign_vars(array(
			'FleetList'				=> $FleetList,
			'NotBuilding'			=> $NotBuilding,
			'bd_available'			=> $LNG['bd_available'],
			'bd_remaining'			=> $LNG['bd_remaining'],
			'fgf_time'				=> $LNG['fgf_time'],
			'bd_build_ships'		=> $LNG['bd_build_ships'],
			'bd_building_shipyard'	=> $LNG['bd_building_shipyard'],
			'bd_completed'			=> $LNG['bd_completed'],
			'bd_cancel_warning'		=> $LNG['bd_cancel_warning'],
			'bd_cancel_send'		=> $LNG['bd_cancel_send'],
			'bd_actual_production'	=> $LNG['bd_actual_production'],
			'bd_operating'			=> $LNG['bd_operating'],
			'BuildList'				=> json_encode($Buildlist),
			'USERcommander' => $USER['commander'],
			'maxlength'				=> strlen(MAX_FLEET_OR_DEFS_PER_ROW),
		));
		$template->show("construibles/shipyard_fleet.tpl");
	}

	public function DefensesBuildingPage()
	{
		global $USER, $PLANET, $LNG, $resource, $dpath, $reslist;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');

		$template	= new template();

		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		if ($PLANET[$resource[21]] == 0)
		{
			$PlanetRess->SavePlanetToDB();
			$template->message($LNG['bd_shipyard_required']);
			exit;
		}

		$fmenge	= $_POST['fmenge'];
		$cancel	= request_var('auftr', range(0, MAX_FLEET_OR_DEFS_IN_BUILD - 1));
		$action	= request_var('action', '');
								
		$NotBuilding = true;
		if (!empty($PLANET['b_building_id']))
		{
			$CurrentQueue 	= unserialize($PLANET['b_building_id']);
			foreach($CurrentQueue as $ElementArray) {
				if($ElementArray[0] == 21 || $ElementArray[0] == 15) {
					$NotBuilding = false;
					break;
				}
			}
		}
		
	$ElementQueue 	= unserialize($PLANET['b_hangar_id']);
	if(empty($ElementQueue))
		$Count	= 0;
	else
		$Count	= count($ElementQueue);
	if($USER['urlaubs_modus'] == 0) {
		if (!empty($fmenge) && $NotBuilding == true) {
			if ($Count >= MAX_FLEET_OR_DEFS_IN_BUILD) {
				$template->message(sprintf($LNG['bd_max_builds'], MAX_FLEET_OR_DEFS_IN_BUILD), "?page=buildings&mode=defense", 3);
				exit;
		}
		$this->BuildAuftr($fmenge);
	}
	if ($action == "delete" && is_array($cancel) && $USER['urlaubs_modus'] == 0)
	$this->CancelAuftr($cancel);
}	
		$PlanetRess->SavePlanetToDB();
		if($PLANET['small_protection_shield'] == "1") {
			unset($reslist['defense'][array_search(407,$reslist['defense'])]);
		}
		if($PLANET['big_protection_shield'] == "1") {
			unset($reslist['defense'][array_search(408,$reslist['defense'])]);
		}
		
		foreach($reslist['defense'] as $Element)
		{
			if(!IsTechnologieAccessible($USER, $PLANET, $Element))
				continue;
	
			$DefenseList[]	= array(
				'id'			=> $Element,
				'name'			=> $LNG['tech'][$Element],
				'descriptions'	=> $LNG['res']['descriptions'][$Element],
				'price'			=> GetElementPrice($USER, $PLANET, $Element, false),
				'restprice'		=> $this->GetRestPrice($Element),
				'time'			=> pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
				'IsAvailable'	=> IsElementBuyable($USER, $PLANET, $Element, false),
				'GetMaxAmount'	=> floattostring($this->GetMaxConstructibleElements($Element)),
				'Available'		=> pretty_number($PLANET[$resource[$Element]]),
				'AlreadyBuild'	=> (in_array($Element, $reslist['one']) && (strpos($PLANET['b_hangar_id'], $Element.",") !== false || $PLANET[$resource[$Element]] != 0)) ? true : false,
			);
		}
		
		$ElementQueue 	= unserialize($PLANET['b_hangar_id']);
		
		if($USER['raza'] == 0) {
		$skin_raza = "gultra";
		} elseif ($USER['raza'] == 1) {
		$skin_raza = "voltra";
		} 
		
		$Buildlist		= array();
		if(!empty($ElementQueue)) {
			$Shipyard		= array();
			$QueueTime		= 0;
			foreach($ElementQueue as $Element)
			{
				if (empty($Element))
					continue;
				$ElementTime  	= GetBuildingTime( $USER, $PLANET, $Element[0]);
				$QueueTime   	+= $ElementTime * $Element[1];
				$Shipyard[]		= array($LNG['tech'][$Element[0]], $Element[1], $ElementTime, $Element[0]);		
			}

			$template->loadscript('bcmath.js');
			$template->loadscript('shipyard.js');
			$template->execscript('ShipyardInit();');
			
			$Buildlist	= array(
				'Queue' 				=> $Shipyard,
				'b_hangar_id_plus' 		=> $PLANET['b_hangar'],
				'skin_raza' 	=> $skin_raza,
				'pretty_time_b_hangar' 	=> pretty_time(max($QueueTime - $PLANET['b_hangar'],0)),
			);
		}
				
		$template->assign_vars(array(
			'DefenseList'					=> $DefenseList,
			'NotBuilding'					=> $NotBuilding,
			'bd_available'					=> $LNG['bd_available'],
			'bd_remaining'					=> $LNG['bd_remaining'],
			'fgf_time'						=> $LNG['fgf_time'],
			'bd_build_ships'				=> $LNG['bd_build_ships'],
			'bd_building_shipyard'			=> $LNG['bd_building_shipyard'],
			'bd_protection_shield_only_one'	=> $LNG['bd_protection_shield_only_one'],
			'bd_cancel_warning'				=> $LNG['bd_cancel_warning'],
			'bd_cancel_send'				=> $LNG['bd_cancel_send'],
			'bd_operating'					=> $LNG['bd_operating'],
			'bd_actual_production'			=> $LNG['bd_actual_production'],
			'BuildList'						=> json_encode($Buildlist),
			'USERcommander' => $USER['commander'],
			'maxlength'						=> strlen(MAX_FLEET_OR_DEFS_PER_ROW),
		));
		$template->show("construibles/shipyard_defense.tpl");
	}
}
?>