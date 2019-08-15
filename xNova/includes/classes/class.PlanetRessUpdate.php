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

class ResourceUpdate
{
	function __construct($Build = true, $Tech = true)
	{
		$this->Builded					= array();	
		$this->Build					= $Build;
		$this->Tech						= $Tech;
		$this->USER						= array();
		$this->PLANET					= array();
		$this->DEBUG					= FirePHP::getInstance(true);
	}
	
	public function ReturnVars() {
		if($this->GLOBALS)
		{
			$GLOBALS['USER']	= $this->USER;
			$GLOBALS['PLANET']	= $this->PLANET;
			return true;
		} else {
			return array($this->USER, $this->PLANET);
		}
	}
	
	public function CalcResource($USER = NULL, $PLANET = NULL, $SAVE = false, $TIME = NULL)
	{
		$this->GLOBALS	= !isset($USER, $PLANET) ? true : false;
		$this->USER		= $this->GLOBALS ? $GLOBALS['USER'] : $USER;
		$this->PLANET	= $this->GLOBALS ? $GLOBALS['PLANET'] : $PLANET;
		$this->TIME		= is_null($TIME) ? TIMESTAMP : $TIME;
			
		if($this->USER['urlaubs_modus'] == 1)
			return $this->ReturnVars();
			
		if($this->Build)
		{
				
			$this->ShipyardQueue();
			if($this->Tech == true && $this->USER['b_tech'] != 0 && $this->USER['b_tech'] < $this->TIME)
				$this->ResearchQueue();
			if($this->PLANET['b_building'] != 0)
				$this->BuildingQueue();
		}	

		$this->UpdateRessource();
		if($SAVE === true)
			$this->SavePlanetToDB($this->USER, $this->PLANET);
			
		return $this->ReturnVars();
	}
	
	private function UpdateRessource()
	{
		global $ProdGrid, $resource, $reslist, $CONF, $db;
				
		$this->PLANET['metal_max']			= floor(2.5 * pow(1.8331954764, $this->PLANET[$resource[22]])) * 3000  * $CONF['resource_multiplier'] * STORAGE_FACTOR;
		$this->PLANET['crystal_max']		= floor(2.5 * pow(1.8331954764, $this->PLANET[$resource[23]])) * 3000  * $CONF['resource_multiplier'] * STORAGE_FACTOR;
		$this->PLANET['deuterium_max']		= floor(2.5 * pow(1.8331954764, $this->PLANET[$resource[24]])) * 3000  * $CONF['resource_multiplier'] * STORAGE_FACTOR;
		$this->PLANET['norio_max']		    = floor(2.5 * pow(1.8331954764, $this->PLANET[$resource[25]])) * 3000  * $CONF['resource_multiplier'] * STORAGE_FACTOR;
		
		$MaxMetalStorage                	= $this->PLANET['metal_max']     * MAX_OVERFLOW;
		$MaxCristalStorage              	= $this->PLANET['crystal_max']   * MAX_OVERFLOW;
		$MaxDeuteriumStorage     		    = $this->PLANET['deuterium_max'] * MAX_OVERFLOW;
		$MaxNorioStorage     		        = $this->PLANET['norio_max']     * MAX_OVERFLOW;
		$this->ProductionTime    			= ($this->TIME - $this->PLANET['last_update']);
		$this->DEBUG->log("Inicio de la Actualizacion de Recurso en el Planeta(ID: ".$this->PLANET['id']."): ".date("H:i:s", $this->PLANET['last_update'])." en ".date("H:i:s", $this->TIME)." (".pretty_number($this->ProductionTime)."s)");
		$this->DEBUG->log("Almacenamiento: Metal: ".pretty_number($this->PLANET['metal_max'])." Cristal: ".pretty_number($this->PLANET['crystal_max'])." Deuterio: ".pretty_number($this->PLANET['deuterium_max'])." Norio: ".pretty_number($this->PLANET['norio_max']));

		$this->PLANET['last_update']   		= $this->TIME;

		if ($this->PLANET['planet_type'] == 3)
		{
			$CONF['metal_basic_income']     	= 0;
			$CONF['crystal_basic_income']   	= 0;
			$CONF['deuterium_basic_income'] 	= 0;
			$CONF['norio_basic_income'] 	    = 0;
			$this->PLANET['metal_perhour']      = 0;
			$this->PLANET['crystal_perhour']    = 0;
			$this->PLANET['deuterium_perhour']  = 0;
			$this->PLANET['norio_perhour']      = 0;
			$this->PLANET['energy_used']        = 0;
			$this->PLANET['metal_proc']                     = array(0);
            $this->PLANET['crystal_proc']                   = array(0);
            $this->PLANET['deuterium_proc']                 = array(0);
            $this->PLANET['deuterium_userd_proc']   = array(0);
			$this->PLANET['norio_proc']                 = array(0);
            $this->PLANET['energy_used_proc']               = array(0);
            if($this->PLANET[$resource[212]] == 0) {
                $this->PLANET['energy_max_proc']                = array(0);
                $this->PLANET['energy_max']             = 0;
            } else {
                $BuildTemp      = $this->PLANET['temp_max'];
                $BuildLevelFactor                                               = $this->PLANET[$resource[212].'_porcent'];
                $BuildLevel                                                     = $this->PLANET[$resource[212]];
                $this->PLANET['energy_max_proc'][212]   = round(eval($ProdGrid[212]['formule']['energy']) * ($this->CONF['resource_multiplier']));
				$this->PLANET['energy_max']             = $this->PLANET['energy_max_proc'][212];
            }
		}
		else
		{
			$Caps           = array();
			$BuildTemp      = $this->PLANET['temp_max'];
			$BuildEnergy	= $this->USER[$resource[113]];
			$BuildProcMetal     = $this->USER[$resource[131]];
			$BuildProcCrystal   = $this->USER[$resource[132]];
			$BuildProcDeuterium = $this->USER[$resource[133]];
			$BuildProcNorium    = $this->USER[$resource[135]];
			$Caps['metal_perhour'] = $Caps['crystal_perhour'] = $Caps['deuterium_perhour'] = $Caps['norio_perhour'] = $Caps['energy_used'] = $Caps['energy_max'] = $Caps['deuterium_used'] = 0;

			foreach($reslist['prod'] as $id => $ProdID)
			{
				$BuildLevelFactor	= $this->PLANET[$resource[$ProdID]."_porcent" ];
				$BuildLevel 		= $this->PLANET[$resource[$ProdID]];
				$Caps['metal_perhour'] += floor(eval($ProdGrid[$ProdID]['formule']['metal'])  *  $CONF['resource_multiplier']);
				$Caps['crystal_perhour']	+= floor(eval($ProdGrid[$ProdID]['formule']['crystal']) * $CONF['resource_multiplier']);
				$Caps['norio_perhour']	+= floor(eval($ProdGrid[$ProdID]['formule']['norio'])  * $CONF['resource_multiplier']);
			
				if ($ProdID < 4 or $ProdID == 7) {
					$Caps['deuterium_perhour'] 	+= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * $CONF['resource_multiplier']);
					$Caps['energy_used']   		+= floor(eval($ProdGrid[$ProdID]['formule']['energy']) * $CONF['resource_multiplier']);

				} else {
					if($ProdID == 12 && $this->PLANET['deuterium'] == 0)
						continue;

					$Caps['deuterium_used'] 	+= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($CONF['resource_multiplier']));
					$Caps['energy_max']			+= floor(eval($ProdGrid[$ProdID]['formule']['energy']) * ($CONF['resource_multiplier']));
				}
			}
			
			if ($Caps['energy_max'] == 0)
			{
				$this->PLANET['metal_perhour']     = $CONF['metal_basic_income'];
				$this->PLANET['crystal_perhour']   = $CONF['crystal_basic_income'];
				$this->PLANET['deuterium_perhour'] = $CONF['deuterium_basic_income'];
				$this->PLANET['norio_perhour']     = $CONF['norio_basic_income'];
				$LEVEL = 0;
			}
			elseif ($Caps['energy_max'] >= abs($Caps['energy_used']))
				$LEVEL = 100;
			else
			{
            if($Caps['energy_max'] == 0 || $Caps['energy_used'] == 0)
               $LEVEL = 0;
            else
               $LEVEL =  floor($Caps['energy_max'] / abs($Caps['energy_used']) * 70);
			}
				
			if($LEVEL > 100)
				$LEVEL = 100;
			elseif ($LEVEL < 0)
				$LEVEL = 0;				
			
			if($USER['geologe'] >= 1 xor $USER['raza'] == 0){
			$metal_produccion = $Caps['metal_perhour'] * (0.01 * $LEVEL);
			$porcentaje = $metal_produccion * 10 / 100;
			$this->PLANET['metal_perhour']  = $porcentaje + $metal_produccion;
			} elseif($USER['geologe'] >= 1 and $USER['raza'] == 0) {
			$metal_produccion = $Caps['metal_perhour'] * (0.01 * $LEVEL);
			$porcentaje = $metal_produccion * 20 / 100;
			$this->PLANET['metal_perhour']  = $porcentaje + $metal_produccion;
			} else {
			$this->PLANET['metal_perhour'] = $Caps['metal_perhour'] * (0.01 * $LEVEL);
			}
				
			if($USER['geologe'] >= 1 xor $USER['raza'] == 0){
			$cristal_produccion = $Caps['crystal_perhour'] * (0.01 * $LEVEL);
			$porcentaje = $cristal_produccion * 10 / 100;
			$this->PLANET['crystal_perhour']      = $porcentaje + $cristal_produccion;
			} elseif($USER['geologe'] >= 1 and $USER['raza'] == 0) {
			$cristal_produccion = $Caps['crystal_perhour'] * (0.01 * $LEVEL);
			$porcentaje = $cristal_produccion * 20 / 100;
			$this->PLANET['crystal_perhour']      = $porcentaje + $cristal_produccion;
			} else {
			$this->PLANET['crystal_perhour'] = $Caps['crystal_perhour'] * (0.01 * $LEVEL);
			}
			
			if($USER['geologe'] >= 1 xor $USER['raza'] == 0){
			$deuterio_produccion = $Caps['deuterium_perhour'] * (0.01 * $LEVEL) + $Caps['deuterium_used'];
			$porcentaje = $deuterio_produccion * 10 / 100;
			$this->PLANET['deuterium_perhour']      = $porcentaje + $deuterio_produccion;
			} elseif($USER['geologe'] >= 1 and $USER['raza'] == 0) {
			$deuterio_produccion = $Caps['deuterium_perhour'] * (0.01 * $LEVEL) + $Caps['deuterium_used'];
			$porcentaje = $deuterio_produccion * 20 / 100;
			$this->PLANET['deuterium_perhour']      = $porcentaje + $deuterio_produccion;
			} else {			
			$this->PLANET['deuterium_perhour']    = $Caps['deuterium_perhour'] * (0.01 * $LEVEL) + $Caps['deuterium_used'] ;
			}
			
			if($USER['geologe'] >= 1 xor $USER['raza'] == 0){
			$norio_produccion = $Caps['norio_perhour']* (0.01 * $LEVEL);
			$porcentaje = $norio_produccion * 10 / 100;
			$this->PLANET['norio_perhour']    = $norio_produccion + $porcentaje ;
			} elseif($USER['geologe'] >= 1 and $USER['raza'] == 0) {
			$norio_produccion = $Caps['norio_perhour']* (0.01 * $LEVEL);
			$porcentaje = $norio_produccion * 20 / 100;
			$this->PLANET['norio_perhour']    = $norio_produccion + $porcentaje ;
			} else {
			$this->PLANET['norio_perhour']    = $Caps['norio_perhour']* (0.01 * $LEVEL) ;
			}
			
			if($this->USER['engineer'] >= 1) {
			$porcentaje = $Caps['energy_used'] * 10 / 100;
			$this->PLANET['energy_used']          = $Caps['energy_used'] - $porcentaje;	
			} else {
			$this->PLANET['energy_used']          = $Caps['energy_used'] - $porcentaje;	
			}
			$this->PLANET['energy_max']           = $Caps['energy_max'];

			#ADDED 
			$MetalTheorical		= 0;
            $CristalTheorical	= 0;
			$DeuteriumTheorical	= 0;
			$NorioTheorical  	= 0;
			
			if ($this->PLANET['metal'] <= $MaxMetalStorage)
			{
				$MetalTheorical 		= ($this->ProductionTime * (($CONF['metal_basic_income'] * $CONF['resource_multiplier']) + $this->PLANET['metal_perhour']) / 3600);
				$this->PLANET['metal']  		= min($this->PLANET['metal'] + $MetalTheorical, $MaxMetalStorage);
			}
			
			if ($this->PLANET['crystal'] <= $MaxCristalStorage)
			{
				$CristalTheorical  		= ($this->ProductionTime * (($CONF['crystal_basic_income'] * $CONF['resource_multiplier']) + $this->PLANET['crystal_perhour']) / 3600);
				$this->PLANET['crystal']  	= min($this->PLANET['crystal'] + $CristalTheorical, $MaxCristalStorage);
			}
			
			if ($this->PLANET['deuterium'] <= $MaxDeuteriumStorage || $this->PLANET['deuterium_perhour'] < 0)
			{
				$DeuteriumTheorical		= ($this->ProductionTime * (($CONF['deuterium_basic_income'] * $CONF['resource_multiplier']) + $this->PLANET['deuterium_perhour']) / 3600);
				$this->PLANET['deuterium']	= min($this->PLANET['deuterium'] + $DeuteriumTheorical, $MaxDeuteriumStorage);
			}
			
			if ($this->PLANET['norio'] <= $MaxNorioStorage)
			{
				$NorioTheorical		    = ($this->ProductionTime * (($CONF['norio_basic_income'] * $CONF['resource_multiplier']) + $this->PLANET['norio_perhour']) / 3600);
				$this->PLANET['norio']	= min($this->PLANET['norio'] + $NorioTheorical, $MaxNorioStorage);
			}
		}
		
		$this->DEBUG->log("Agrega: Metal: ".pretty_number($MetalTheorical)." Cristal: ".pretty_number($CristalTheorical)." Deuterio: ".pretty_number($DeuteriumTheorical)." Norio: ".pretty_number($NorioTheorical));
		
		$this->PLANET['metal']		= max($this->PLANET['metal'], 0);
		$this->PLANET['crystal']	= max($this->PLANET['crystal'], 0);
		$this->PLANET['deuterium']	= max($this->PLANET['deuterium'], 0);
		$this->PLANET['norio']	    = max($this->PLANET['norio'], 0);
		
	  #OFICIALES
$hoy=date("d-m-o G:i:s");
$hoytime = strtotime($hoy);
if ( $this->USER['commander_time'] <= $hoytime AND $this->USER['commander'] == 1) {
		$db->query("UPDATE ".USERS." SET `commander`= '0' WHERE id=".$this->USER['id'].""); }
		  
if ( $this->USER['admiral_time'] <= $hoytime AND $this->USER['admiral'] == 1 ) {
		$db->query("UPDATE ".USERS." SET `admiral`= '0' WHERE id=".$this->USER['id'].""); }
		  
if ( $this->USER['engineer_time'] <= $hoytime AND $this->USER['engineer'] == 1) {
		$db->query("UPDATE ".USERS." SET `engineer`= '0' WHERE id=".$this->USER['id'].""); }
		  
if ( $this->USER['geologe_time'] <= $hoytime AND $this->USER['geologe'] == 1) {
		$db->query("UPDATE ".USERS." SET `geologe`= '0' WHERE id=".$this->USER['id'].""); }
		  
if ( $this->USER['technocratic_time'] <= $hoytime AND $this->USER['technocratic'] == 1) {
		$db->query("UPDATE ".USERS." SET `technocratic`= '0' WHERE id=".$this->USER['id']."");
		$db->query("UPDATE ".USERS." SET spy_tech=spy_tech-2 WHERE id=".$this->USER['id']."");}

     #OFICIALES
	}
	
	private function ShipyardQueue()
	{
		global $resource;

		if (empty($this->PLANET['b_hangar_id'])) {
			$this->PLANET['b_hangar'] = 0;
			return false;
		}
			
		$BuildQueue                 = unserialize($this->PLANET['b_hangar_id']);
		$AcumTime					= 0;
		$this->PLANET['b_hangar'] 	+= ($this->TIME - $this->PLANET['last_update']);
		$BuildArray = array();
		foreach($BuildQueue as $Item)
		{
			$AcumTime		   += GetBuildingTime($this->USER, $this->PLANET, $Item[0]);
			$BuildArray[] 		= array($Item[0], $Item[1], $AcumTime);
		}

		$NewQueue	= array();
		$Done		= false;
		foreach($BuildArray as $Item)
		{
                       $Element   = $Item[0];
					   $Count     = $Item[1];
					   
					   if($Done == false) {
                                $BuildTime = $Item[2];
                                $Element   = (int)$Element;
                                if($BuildTime == 0) {
                                        $this->Builded[$Element]                        += $Count;
                                        $this->PLANET[$resource[$Element]]      += $Count;
                                        continue;                                       
                                }
                                
								$Build			= max(min(floor($this->PLANET['b_hangar'] / $BuildTime), $Count), 0);
								
								if($Build == 0) {
										$NewQueue[]	= array($Element, $Count);
										$Done		= true;
                                        continue;
                                }
                                
                                $this->DEBUG->log("Done(Ship[ID:".$Element."]): ".pretty_number($Build));
								
								if(!isset($this->Builded[$Element]))
									$this->Builded[$Element] = 0;	

								$this->Builded[$Element]			+= $Build;
								$this->PLANET['b_hangar']			-= $Build * $BuildTime;
								$this->PLANET[$resource[$Element]]	+= $Build;
								$Count								-= $Build;
                                
                                if ($Count == 0)
                                        continue;
                                else
                                        $Done   = true;
                        }   
					$NewQueue[]	= array($Element, $Count);
		}	
	$this->PLANET['b_hangar_id']	= !empty($NewQueue) ? serialize($NewQueue) : '';		
	$this->DEBUG->log("Cola(Hangar): ".$this->PLANET['b_hangar_id']);
	}
	
	private function BuildingQueue() 
	{
		while($this->CheckPlanetBuildingQueue())
			$this->SetNextQueueElementOnTop();
	}
	
	private function CheckPlanetBuildingQueue()
	{
		global $resource, $db;
		
		if (empty($this->PLANET['b_building_id']) || $this->PLANET['b_building'] > $this->TIME)
			return false;
		
		$CurrentQueue	= unserialize($this->PLANET['b_building_id']);
		
		$Element      	= $CurrentQueue[0][0];
		$Level      	= $CurrentQueue[0][1];
		$BuildEndTime 	= $CurrentQueue[0][3];
		$BuildMode    	= $CurrentQueue[0][4];
		
		if ($BuildMode == 'build')
		{
			$this->PLANET['field_current']		+= 1;
			$this->PLANET[$resource[$Element]]	+= 1;
			$this->Builded[$Element]			+= 1;
		}
		else
		{
			$this->PLANET['field_current'] 		-= 1;
			$this->PLANET[$resource[$Element]] 	-= 1;
			$this->Builded[$Element]			-= 1;
		}
	
		$this->DEBUG->log("Done: Ship(ID:".$Element."): ".($this->PLANET[$resource[$Element]] - ($BuildMode == 'build' ? 1 : -1))." -> ".$this->PLANET[$resource[$Element]]);	
		if(is_array($CurrentQueue)) {
		array_shift($CurrentQueue);		
		}
		$this->UpdateRessource($BuildEndTime);			
			
		if (count($CurrentQueue) == 0) {
			$this->PLANET['b_building']    	= 0;
			$this->PLANET['b_building_id'] 	= '';
			$this->DEBUG->log("Cola(Edificios): ".$this->PLANET['b_building_id']);
			return false;
		} else {
			$this->PLANET['b_building_id'] 	= serialize($CurrentQueue);
			return true;
		}
	}	
	
	public function SetNextQueueElementOnTop()
	{
		global $resource, $db, $LNG;

		if (empty($this->PLANET['b_building_id'])) {
			$this->PLANET['b_building']    = 0;
			$this->PLANET['b_building_id'] = '';
			return false;
		}

		$CurrentQueue 	= unserialize($this->PLANET['b_building_id']);
		$Loop       	= true;
		while ($Loop == true)
		{
			$ListIDArray         = $CurrentQueue[0];
			$Element             = $ListIDArray[0];
			$Level               = $ListIDArray[1];
			$BuildMode           = $ListIDArray[4];
			$ForDestroy 		 = ($BuildMode == 'destroy') ? true : false;
			$BuildTime  	     = GetBuildingTime($this->USER, $this->PLANET, $Element, $ForDestroy);
			$BuildEndTime        = $this->PLANET['b_building'] + $BuildTime;
			$CurrentQueue[0]	 = array($Element, $Level, $BuildTime, $BuildEndTime, $BuildMode);
			$HaveNoMoreLevel     = false;
								
			$HaveRessources 	 = IsElementBuyable($this->USER, $this->PLANET, $Element, true, $ForDestroy);
				
			if($ForDestroy && $this->PLANET[$resource[$Element]] == 0) {
				$HaveRessources  = false;
				$HaveNoMoreLevel = true;
			}

			if($HaveRessources == true) {
				$Needed                 	= GetBuildingPrice ($this->USER, $this->PLANET, $Element, true, $ForDestroy);
				$this->PLANET['metal']      -= $Needed['metal'];
				$this->PLANET['crystal']    -= $Needed['crystal'];
				$this->PLANET['deuterium']  -= $Needed['deuterium'];
				$this->USER['darkmatter']   -= $Needed['darkmatter'];
				$this->PLANET['norio']      -= $Needed['norio'];
				$NewQueue               	= serialize($CurrentQueue);
				$Loop                  		= false;
			} else {
				if($this->USER['hof'] == 1){
					if ($ForDestroy || $HaveNoMoreLevel)
						$Message     = sprintf($LNG['sys_nomore_level'], $LNG['tech'][$Element]);
					else
					{
						$Needed      = GetBuildingPrice($this->USER, $this->PLANET, $Element, true, $ForDestroy);
						$Message     = sprintf($LNG['sys_notenough_money'], $this->PLANET['name'], $this->PLANET['id'], $this->PLANET['galaxy'], $this->PLANET['system'], $this->PLANET['planet'], $LNG['tech'][$Element], pretty_number ($this->PLANET['metal']), $LNG['Metal'], pretty_number ($this->PLANET['crystal']), $LNG['Crystal'], pretty_number ($this->PLANET['deuterium']), $LNG['Deuterium'], pretty_number ($this->PLANET['norio']), $LNG['Norio'], pretty_number ($Needed['metal']), $LNG['Metal'], pretty_number ($Needed['crystal']), $LNG['Crystal'], pretty_number ($Needed['deuterium']), $LNG['Deuterium'], pretty_number ($Needed['norio']), $LNG['Norio']);
					}
					SendSimpleMessage($this->USER['id'], '', $this->TIME, 99, $LNG['sys_buildlist'], $LNG['sys_buildlist_fail'], $Message);				
				}

				array_shift($CurrentQueue);
				
				if (count($CurrentQueue) == 0) {
					$BuildEndTime  = 0;
					$NewQueue      = '';
					$Loop          = false;
				} else {
						$BaseTime			= $BuildEndTime - $BuildTime;
						$NewQueue			= array();
						foreach($CurrentQueue as $ListIDArray)
					{
						$ListIDArray[2]		= GetBuildingTime($this->USER, $this->PLANET, $ListIDArray[0], $ListIDArray[4] == 'destroy');
						$BaseTime			+= $ListIDArray[2];
						$ListIDArray[3]		= $BaseTime;
						$NewQueue[]			= $ListIDArray;
					}
					$CurrentQueue	= $NewQueue;
				}
			}
		}
			
		$this->PLANET['b_building']    = $BuildEndTime;
		$this->PLANET['b_building_id'] = $NewQueue;
		$this->DEBUG->log("Queue(Builds): ".$this->PLANET['b_building_id']);
	}
		
	private function ResearchQueue()
	{
		while($this->CheckUserTechQueue())
			$this->SetNextQueueTechOnTop();
	}
	
	private function CheckUserTechQueue()
	{
		global $resource, $db;
		
		if (empty($this->USER['b_tech_id']) || $this->USER['b_tech'] > $this->TIME)
			return false;
		
		if(!isset($this->Builded[$this->USER['b_tech_id']]))
			$this->Builded[$this->USER['b_tech_id']]	= 0;
			
		$this->Builded[$this->USER['b_tech_id']]            += 1;	
		$this->USER[$resource[$this->USER['b_tech_id']]]	+= 1;
		$this->DEBUG->log("Hecho: Naves(ID:".$Element."): ".($this->USER[$resource[$this->USER['b_tech_id']]] - 1)." -> ".$this->USER[$resource[$this->USER['b_tech_id']]]);
	
		$CurrentQueue	= unserialize($this->USER['b_tech_queue']);
		array_shift($CurrentQueue);		
				
		$this->USER['b_tech_id']		= 0;
		if (count($CurrentQueue) == 0) {
			$this->USER['b_tech'] 			= 0;
			$this->USER['b_tech_id']		= 0;
			$this->USER['b_tech_planet']	= 0;
			$this->USER['b_tech_queue']		= '';
			$this->DEBUG->log("Cola(Tecnologias): ".$this->USER['b_tech_queue']);
			return false;
		} else {
			$this->USER['b_tech_queue'] 	= serialize(array_values($CurrentQueue));
			return true;
		}
	}	
	
	public function SetNextQueueTechOnTop()
	{
		global $resource, $db, $LNG;

		if (empty($this->USER['b_tech_queue'])) {
			$this->USER['b_tech'] 			= 0;
			$this->USER['b_tech_id']		= 0;
			$this->USER['b_tech_planet']	= 0;
			$this->USER['b_tech_queue']		= '';
			return false;
		}

		$CurrentQueue 	= unserialize($this->USER['b_tech_queue']);
		$Loop       	= true;
		while ($Loop == true)
		{
			$ListIDArray        = $CurrentQueue[0];
			if($ListIDArray[4] != $this->PLANET['id']) {
				$PLANET				= $db->uniquequery("SELECT * FROM ".PLANETS." WHERE `id` = '".$ListIDArray[4]."';");
				list(, $PLANET['factor'])	= getFactors($this->USER, $PLANET);
			} else {
				$PLANET				= $this->PLANET;
			}
			
			$PLANET[$resource[31].'_inter']	= $this->CheckAndGetLabLevel($this->USER, $PLANET);
			
			$Element            = $ListIDArray[0];
			$Level              = $ListIDArray[1];
			$BuildTime  	    = GetBuildingTime($this->USER, $PLANET, $Element);
			$BuildEndTime       = $this->USER['b_tech'] + $BuildTime;
			$CurrentQueue[0]	= array($Element, $Level, $BuildTime, $BuildEndTime, $PLANET['id']);
			$HaveRessources 	= IsElementBuyable($this->USER, $this->PLANET, $Element, true, false);
			
			if($PLANET['id'] != $this->PLANET['id']) {
			$RPLANET  = new ResourceUpdate(true, false);
			list(, $PLANET)	= $RPLANET->CalcResource($this->USER, $PLANET, false, $BuildEndTime);
			}
			if($HaveRessources == true) {
				$Needed							= GetBuildingPrice($this->USER, $PLANET, $Element);
				$this->PLANET['metal']				-= $Needed['metal'];
				$this->PLANET['crystal']				-= $Needed['crystal'];
				$this->PLANET['deuterium']			-= $Needed['deuterium'];
				$this->PLANET['norio']				-= $Needed['norio'];
				$this->USER['darkmatter']		-= $Needed['darkmatter'];
				$this->USER['b_tech_id']		= $Element;
				$this->USER['b_tech']      		= $BuildEndTime;
				$this->USER['b_tech_planet']	= $PLANET['id'];
				$this->USER['b_tech_queue'] 	= serialize($CurrentQueue);
				
				$Loop                  			= false;
				
				if($ListIDArray[4] != $this->PLANET['id']) {
					$RPLANET->SavePlanetToDB($this->USER, $PLANET);
				} else {
					$this->PLANET		= $PLANET;
				}	
		} else {
				if($this->USER['hof'] == 1){
					$Needed      = GetBuildingPrice($this->USER, $RPLANET->PLANET, $Element, true, $ForDestroy);
					$Message     = sprintf($LNG['sys_notenough_money'], $PLANET['name'], $PLANET['id'], $PLANET['galaxy'], $PLANET['system'], $PLANET['planet'], $LNG['tech'][$Element], pretty_number($RPLANET->PLANET['metal']), $LNG['Metal'], pretty_number($RPLANET->PLANET['crystal']), $LNG['Crystal'], pretty_number($RPLANET->PLANET['deuterium']), $LNG['Deuterium'], pretty_number($RPLANET->PLANET['norio']), $LNG['Norio'], pretty_number ($Needed['metal']), $LNG['Metal'], pretty_number ($Needed['crystal']), $LNG['Crystal'], pretty_number ($Needed['deuterium']), $LNG['Deuterium'], pretty_number ($Needed['norio']), $LNG['Norio']);	
				}

				array_shift($CurrentQueue);
					
				if (count($CurrentQueue) == 0) {
					$this->USER['b_tech'] 			= 0;
					$this->USER['b_tech_id']		= 0;
					$this->USER['b_tech_planet']	= 0;
					$this->USER['b_tech_queue']		= '';
					
					$Loop                  			= false;
				} else {
					$BaseTime						= $BuildEndTime - $BuildTime;
					$NewQueue						= array();
					foreach($CurrentQueue as $ListIDArray) {
						$ListIDArray[2]		= GetBuildingTime($this->USER, $Planet, $ListIDArray[0]);
						$BaseTime			+= $ListIDArray[2];
						$ListIDArray[3]		= $BaseTime;
						$NewQueue[]			= $ListIDArray;
					}
					$CurrentQueue	= $NewQueue;
				}
			}
		}
	   $this->DEBUG->log("Cola(Tecnologias): ".$this->USER['b_tech_queue']);
	}
	
	public function CheckAndGetLabLevel()
	{
		global $resource, $db, $USER, $PLANET;

		if($USER[$resource[123]] == 0)
			$lablevel = $PLANET[$resource[31]];
		else {
			$LevelRow = $db->query("SELECT ".$resource[31]." FROM ".PLANETS." WHERE `id` != '".$PLANET['id']."' AND `id_owner` = '".$USER['id']."' AND `destruyed` = 0 ORDER BY ".$resource[31]." DESC LIMIT ".($USER[$resource[123]]).";");
			$lablevel[]	= $PLANET[$resource[31]];
			while($Levels = $db->fetch_array($LevelRow))
			{
				$lablevel[]	= $Levels[$resource[31]];
			}
			$db->free_result($LevelRow);
		}
		return $lablevel;
	}
	
	public function SavePlanetToDB($USER = NULL, $PLANET = NULL)
	{
		global $resource, $db, $reslist;
		
		if(is_null($USER))
			global $USER;
			
		if(is_null($PLANET))
			global $PLANET;
			
		$Qry	= "LOCK TABLE ".PLANETS." as p WRITE, ".USERS." as u WRITE, ".SESSION." as s WRITE;
				   UPDATE ".PLANETS." as p, ".USERS." as u, ".SESSION." as s SET
				   `p`.`metal` = '".floattostring($PLANET['metal'])."',
				   `p`.`crystal` = '".floattostring($PLANET['crystal'])."',
				   `p`.`deuterium` = '".floattostring($PLANET['deuterium'])."',
				   `p`.`norio` = '".floattostring($PLANET['norio'])."',
				   `p`.`last_update` = '".$PLANET['last_update']."',
				   `p`.`b_building` = '".$PLANET['b_building']."',
				   `p`.`b_building_id` = '".$PLANET['b_building_id']."',
				   `p`.`field_current` = '".$PLANET['field_current']."',
				   `p`.`b_hangar_id` = '".$PLANET['b_hangar_id']."',
				   `p`.`metal_perhour` = '".$PLANET['metal_perhour']."',
				   `p`.`crystal_perhour` = '".$PLANET['crystal_perhour']."',
				   `p`.`deuterium_perhour` = '".$PLANET['deuterium_perhour']."',
				   `p`.`norio_perhour` = '".$PLANET['norio_perhour']."',
				   `p`.`metal_max` = '".$PLANET['metal_max']."',
				   `p`.`crystal_max` = '".$PLANET['crystal_max']."',
				   `p`.`deuterium_max` = '".$PLANET['deuterium_max']."',
				   `p`.`norio_max` = '".$PLANET['norio_max']."',
				   `p`.`energy_used` = '".$PLANET['energy_used']."',
				   `p`.`energy_max` = '".$PLANET['energy_max']."',
				   `p`.`b_hangar` = '". $PLANET['b_hangar'] ."', ";
		if (!empty($this->Builded))
		{
			foreach($this->Builded as $Element => $Count)
			{
				$Element	= (int)$Element;
				if(empty($resource[$Element]) || empty($Count))
					continue;
				
				if(in_array($Element, $reslist['one']))
					$Qry	.= "`p`.`".$resource[$Element]."` = '1', ";					
				elseif(isset($PLANET[$resource[$Element]]))
					$Qry	.= "`p`.`".$resource[$Element]."` = `p`.`".$resource[$Element]."` + '".$Count."', ";
				elseif(isset($USER[$resource[$Element]]))
					$Qry	.= "`u`.`".$resource[$Element]."` = `u`.`".$resource[$Element]."` + '".$Count."', ";
			}
		}
		$Qry	.= "`u`.`darkmatter` = '".$USER['darkmatter']."',
					`u`.`b_tech` = '".$USER['b_tech']."',
					`u`.`b_tech_id` = '".$USER['b_tech_id']."',
					`u`.`b_tech_planet` = '".$USER['b_tech_planet']."',
					`u`.`b_tech_queue` = '".$USER['b_tech_queue']."'
					WHERE
					`p`.`id` = '". $PLANET['id'] ."' AND
					`u`.`id` = '".$USER['id']."' AND 
					`s`.`sess_id` = '".session_id()."';
					UNLOCK TABLES;";
		$db->multi_query($Qry);
		$this->Builded	= array();
		
		$this->DEBUG->log("Total: Metal: ".pretty_number($PLANET['metal'])." Cristal: ".pretty_number($PLANET['crystal'])." Deuterio: ".pretty_number($PLANET['deuterium'])." Norio: ".pretty_number($PLANET['norio']));
		return array($USER, $PLANET);
	}
}
?>