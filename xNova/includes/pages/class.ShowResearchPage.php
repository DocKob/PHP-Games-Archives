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

class ShowResearchPage
{
	public function CheckLabSettingsInQueue()
	{
		global $PLANET;
		if ($PLANET['b_building'] == 0)
			return true;
			
			$CurrentQueue		= unserialize($PLANET['b_building_id']);
			foreach($CurrentQueue as $ListIDArray) {
			if($ListIDArray[0] == 6 || $ListIDArray[0] == 31)
				return false;
		}

		return true;
	}
	
	public function GetRestPrice($Element)
	{
		global $USER, $PLANET, $pricelist, $resource, $LNG, $dpath;

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
			if (empty($pricelist[$Element][$ResType]))
				continue;

			$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $USER[$resource[$Element]]));

			$restprice[$ResTitle] = pretty_number(max($cost - (($PLANET[$ResType]) ? $PLANET[$ResType] : $USER[$ResType]), 0));
		}

		return $restprice;
	}
	
	public function CancelBuildingFromQueue($PlanetRess)
	{
		global $PLANET, $USER, $db, $resource;
		$CurrentQueue  = unserialize($USER['b_tech_queue']);
		if (empty($CurrentQueue) || empty($USER['b_tech']))
		{
			$USER['b_tech_queue']	= '';
			$USER['b_tech_planet']	= 0;
			$USER['b_tech_id']		= 0;
			$USER['b_tech']			= 0;
			FirePHP::getInstance(true)->log("Queue(Tech): ".$USER['b_tech_queue']);
			return false;
		}
		$Element						= $USER['b_tech_id'];
		$costs							= GetBuildingPrice($USER, $PLANET, $USER['b_tech_id']);
		if($PLANET['id'] == $USER['b_tech_planet'])
		{
			$PLANET['metal']      		+= $costs['metal'];
			$PLANET['crystal']    		+= $costs['crystal'];
			$PLANET['deuterium'] 		+= $costs['deuterium'];	
			$PLANET['norio'] 		+= $costs['norio'];	
		} else {
			$db->query("UPDATE ".PLANETS." SET `metal` = `metal` + '".$costs['metal']."', `crystal` = `crystal` + '".$costs['crystal']."', `deuterium` = `deuterium` + '".$costs['deuterium']."',`norio` = `norio` + '".$costs['norio']."' WHERE `id` = '".$USER['b_tech_planet']."';");
		}
		
		$USER['darkmatter']			+= $costs['darkmatter'];
		$USER['b_tech_id']			= 0;
		$USER['b_tech']      		= 0;
		$USER['b_tech_planet']		= 0;

		array_shift($CurrentQueue);
		if (count($CurrentQueue) == 0) {
			$USER['b_tech_queue']	= '';
			$USER['b_tech_planet']	= 0;
			$USER['b_tech_id']		= 0;
			$USER['b_tech']			= 0;
		} else {
			$BuildEndTime	= TIMESTAMP;
			$NewCurrentQueue	= array();
			foreach($CurrentQueue as $ListIDArray)
			{
				if($Element == $ListIDArray[0] || empty($ListIDArray[0]))
					continue;
					
				if($ListIDArray[4] != $PLANET['id'])
					$CPLANET		= $db->uniquequery("SELECT `".$resource[6]."`, `".$resource[31]."` FROM ".PLANETS." WHERE `id` = '".$ListIDArray[4]."';");
				else
					$CPLANET		= $PLANET;
				
				$CPLANET[$resource[31].'_inter']	= $PlanetRess->CheckAndGetLabLevel($USER, $CPLANET);
				$BuildEndTime       += GetBuildingTime($USER, $CPLANET, $ListIDArray[0]);
				$ListIDArray[3]		= $BuildEndTime;
				$NewCurrentQueue[]	= $ListIDArray;				
			}
			if(!empty($NewCurrentQueue)) {
				$USER['b_tech']    			= TIMESTAMP;
				$USER['b_tech_queue'] 		= serialize($NewCurrentQueue);
				$PlanetRess->USER			= $USER;
				$PlanetRess->PLANET			= $PLANET;
				$PlanetRess->SetNextQueueTechOnTop();
				$USER						= $PlanetRess->USER;
				$PLANET						= $PlanetRess->PLANET;
			} else {
				$USER['b_tech']    			= 0;
				$USER['b_tech_queue'] 		= '';
				FirePHP::getInstance(true)->log("Queue(Tech): ".$USER['b_tech_queue']);
			}
		}
	}

	public function RemoveBuildingFromQueue($QueueID, $PlanetRess)
	{
		global $USER, $PLANET, $db;
		
		$CurrentQueue  = unserialize($USER['b_tech_queue']);
		if ($QueueID <= 1 || empty($CurrentQueue))
			return;
			
		$ActualCount   = count($CurrentQueue);
		if ($ActualCount <= 1)
			return $this->CancelBuildingFromQueue($PlanetRess);

		if(!isset($CurrentQueue[$QueueID - 2]))
		return;
		
		 $Element       = $CurrentQueue[$QueueID - 2][0];
      $BuildEndTime   = $CurrentQueue[$QueueID - 2][3];
      $Resses                  = GetBuildingPrice($USER, $PLANET, $CurrentQueue[$QueueID - 1][0]);

      if($PLANET['id'] == $USER['b_tech_planet'])
      {
         $PLANET['metal']         += $Resses['metal'];
         $PLANET['crystal']         += $Resses['crystal'];
         $PLANET['deuterium']      += $Resses['deuterium'];
         $PLANET['norio']          += $Resses['norio'];
      }
      else {
         $db->query("UPDATE ".PLANETS." SET `metal` = `metal` + '".$Resses['metal']."', `crystal` = `crystal` + '".$Resses['crystal']."', `deuterium` = `deuterium` + '".$Resses['deuterium']."',`norio` = `norio` + '".$Resses['norio']."' WHERE `id` = '".$USER['b_tech_planet']."';");
      }
      $USER['darkmatter']         += $Resses['darkmatter'];
      
      unset($CurrentQueue[$QueueID - 1]);
		$NewCurrentQueue	= array();
		foreach($CurrentQueue as $ID => $ListIDArray)
		{				
			if ($ID < $QueueID - 1) {
				$NewCurrentQueue[]	= $ListIDArray;
			} else {
				if($Element == $ListIDArray[0])
					continue;
					
				if($ListIDArray[4] != $PLANET['id'])
					$CPLANET				= $db->uniquequery("SELECT `".$resource[6]."`, `".$resource[31]."` FROM ".PLANETS." WHERE `id` = '".$ListIDArray[4].";");
				else
					$CPLANET				= $PLANET;
				
				$CPLANET[$resource[31].'_inter']	= $PlanetRess->CheckAndGetLabLevel($USER, $CPLANET);
				
				$BuildEndTime       += GetBuildingTime($USER, $CPLANET, $ListIDArray[0]);
				$ListIDArray[3]		= $BuildEndTime;
				$NewCurrentQueue[]	= $ListIDArray;				
			}
		}
		
		if(!empty($NewCurrentQueue))
			$USER['b_tech_queue'] = serialize($NewCurrentQueue);
		else
			$USER['b_tech_queue'] = "";
			
		FirePHP::getInstance(true)->log("Queue(Tech): ".$USER['b_tech_queue']);
	}

	public function AddBuildingToQueue($Element, $AddMode = true)
	{
		global $PLANET, $USER, $resource,$db;
			
		$CurrentQueue  		= unserialize($USER['b_tech_queue']);

		if (!empty($CurrentQueue)) {
			$ActualCount   	= count($CurrentQueue);
		} else {
			$CurrentQueue  	= array();
			$ActualCount   	= 0;
		}
		
		if($ActualCount >= 1 and $USER['commander'] <= 0) {
			die(header("location:game.php?page=buildings&mode=research"));  
		}
				
		if(MAX_RESEACH_QUEUE_SIZE <= $ActualCount)
			return false;
			
		$BuildLevel					= $USER[$resource[$Element]] + 1;
		if($ActualCount == 0)
		{	
			if(!IsElementBuyable($USER, $PLANET, $Element))
				return;

			$Resses						= GetBuildingPrice($USER, $PLANET, $Element);
			$BuildTime   				= GetBuildingTime($USER, $PLANET, $Element);	
					
			$PLANET['metal']			-= $Resses['metal'];
			$PLANET['crystal']			-= $Resses['crystal'];
			$PLANET['deuterium']		-= $Resses['deuterium'];
			$PLANET['norio']		    -= $Resses['norio'];
			$USER['darkmatter']			-= $Resses['darkmatter'];
			$BuildEndTime				= TIMESTAMP + $BuildTime;
			$USER['b_tech_queue']		= serialize(array(array($Element, $BuildLevel, $BuildTime, $BuildEndTime, $PLANET['id'])));
			$USER['b_tech']				= $BuildEndTime;
			$USER['b_tech_id']			= $Element;
			$USER['b_tech_planet']		= $PLANET['id'];
		} else {
			$InArray = 0;
			foreach($CurrentQueue as $QueueSubArray) {
            if($QueueSubArray[0] == $Element)
               $InArray++;
         }
         $Resses                  = GetBuildingPrice($USER, $PLANET, $Element);

         if(!IsElementBuyable($USER, $PLANET, $Element))
            return;
         
         if($PLANET['id'] == $USER['b_tech_planet'])
         {
            $PLANET['metal']         -= $Resses['metal'];
            $PLANET['crystal']         -= $Resses['crystal'];
            $PLANET['deuterium']      -= $Resses['deuterium'];
            $PLANET['norio']          -= $Resses['norio'];
         }
         else {
            $db->query("UPDATE ".PLANETS." SET `metal` = `metal` - '".$Resses['metal']."', `crystal` = `crystal` - '".$Resses['crystal']."', `deuterium` = `deuterium` - '".$Resses['deuterium']."',`norio` = `norio` - '".$Resses['norio']."' WHERE `id` = '".$USER['b_tech_planet']."';");
         }
         $USER['darkmatter']         -= $Resses['darkmatter'];
         $USER[$resource[$Element]] += $InArray;
			$BuildTime  				= GetBuildingTime($USER, $PLANET, $Element);
			$USER[$resource[$Element]] -= $InArray;
			$BuildEndTime				= $CurrentQueue[$ActualCount - 1][3] + $BuildTime;
			$BuildLevel					+= $InArray;
			$CurrentQueue[]				= array($Element, $BuildLevel, $BuildTime, $BuildEndTime, $PLANET['id']);
			$USER['b_tech_queue']		= serialize($CurrentQueue);
		}
	FirePHP::getInstance(true)->log("Cola(Tecnologias): ".$USER['b_tech_queue']);
	}

	public function ShowTechQueue()
	{
		global $LNG, $CONF, $PLANET, $USER, $db;
		
		if ($USER['b_tech'] == 0)
			return array();
		
		$CurrentQueue   = unserialize($USER['b_tech_queue']);

		$ListIDRow		= "";
		$ScriptData		= array();
		
		if (is_array($CurrentQueue)) {	
		foreach($CurrentQueue as $BuildArray) {
			if ($BuildArray[3] < TIMESTAMP)
				continue;
			
			if($BuildArray[4] != $PLANET['id'])
				$PlanetName	= $db->countquery("SELECT `name` FROM ".PLANETS." WHERE `id` = '".$BuildArray[4]."';");
			else
				$PlanetName	= '';
				
			$ScriptData[] = array('element' => $BuildArray[0], 'level' => $BuildArray[1], 'time' => $BuildArray[2], 'name' => $LNG['tech'][$BuildArray[0]], 'planet' => $PlanetName, 'endtime' => $BuildArray[3], 'reload' => in_array($BuildArray[0], array(123)));
		}
		return $ScriptData;
	}
	}

	public function __construct()
	{
		global $PLANET, $USER, $LNG, $resource, $reslist, $CONF, $db, $pricelist;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');
		
		$template	= new template();			
		
		$PlanetRess 	= new ResourceUpdate();
		$PlanetRess->CalcResource();
		if ($PLANET[$resource[31]] == 0)
		{
			$PlanetRess->SavePlanetToDB();
			$template->message($LNG['bd_lab_required']);
			exit;
		}
		
		$bContinue		= $this->CheckLabSettingsInQueue($PLANET) ? true : false;
			
		$TheCommand		= request_var('cmd','');
		$Element     	= request_var('tech', 0);
		$ListID     	= request_var('listid', 0);
		$PLANET[$resource[31].'_inter']	= $PlanetRess->CheckAndGetLabLevel($USER, $PLANET);	

		if(!empty($Element) && $bContinue && $USER['urlaubs_modus'] == 0 && ($USER[$resource[$Element]] < $pricelist[$Element]['max'] && IsTechnologieAccessible($USER, $PLANET, $Element) && in_array($Element, $reslist['tech'])) || $TheCommand == "cancel" || $TheCommand == "remove")
		{
			switch($TheCommand)
			{
				case 'cancel':
					$this->CancelBuildingFromQueue($PlanetRess);
				break;
				case 'remove':
					$this->RemoveBuildingFromQueue($ListID, $PlanetRess);
				break;
				case 'insert':
					$this->AddBuildingToQueue($Element, true);
				break;
				case 'destroy':
					$this->AddBuildingToQueue($Element, false);
				break;
			}
		}
		
		$PlanetRess->SavePlanetToDB();
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			header('HTTP/1.0 204 No Content');
			exit;
		}
		$ScriptInfo	= array();
		$TechQueue	= $this->ShowTechQueue();
		foreach($reslist['tech'] as $ID => $Element)
		{
			if (!IsTechnologieAccessible($USER, $PLANET, $Element))
				continue;
				
			$CanBeDone               = IsElementBuyable($USER, $PLANET, $Element);
		
				if($USER['raza'] == 0) {
		$skin_raza = "gultra";
		} elseif ($USER['raza'] == 1) {
		$skin_raza = "voltra";
		} 
					
			if(isset($pricelist[$Element]['max']) && $USER[$resource[$Element]] >= $pricelist[$Element]['max']) {
				$TechnoLink  =	'<img class="tooltip" name="<table><td>'.$LNG['bd_maxlevel'].'</td></table>" src="styles/theme/' .$skin_raza .'/imagenes/navegacion/construir_red.gif" />';
			} elseif(MAX_RESEACH_QUEUE_SIZE > 1) {
				$LevelToDo 	= 1 + $USER[$resource[$Element]];
				$TechnoLink = $CanBeDone && $bContinue && MAX_RESEACH_QUEUE_SIZE != count($TechQueue) ? '<a href="game.php?page=buildings&amp;mode=research&amp;cmd=insert&amp;tech='.$Element.'"><img class="tooltip" name="<table><td>'.(($USER['b_tech_id'] != 0) ? $LNG['bd_add_to_list'] : $LNG['bd_research'].(($LevelToDo == 1) ? '' : ' '.$LNG['bd_lvl'].' '.$LevelToDo)).'</td></table>" src="styles/theme/' .$skin_raza .'/imagenes/navegacion/construir.gif" /></a>' : '<img class="tooltip" name="<table><td>'.$LNG['bd_research'].(($LevelToDo == 1) ? '' : ' '.$LNG['bd_lvl'].' '.$LevelToDo).'</td></table>" src="styles/theme/' .$skin_raza .'/imagenes/navegacion/construir_red.gif" />';
				
				if($USER['b_tech_id'] != 0) {
					$template->loadscript('researchlist.js');
					$template->execscript('ReBuildView();Techlist();');
					$ScriptInfo	= array('bd_cancel' => $LNG['bd_cancel'], 'bd_continue' => $LNG['bd_continue'], 'bd_finished' => $LNG['bd_finished'], 'build' => $TechQueue, 'nivel' => $LNG['bd_lvl'], 'raza_skin' => $skin_raza );
				}
			} else {
				if ($USER['b_tech_id'] == 0) {
					$LevelToDo = 1 + $USER[$resource[$Element]];
					
					$TechnoLink = $CanBeDone && $bContinue ? '<a href="game.php?page=buildings&amp;mode=research&amp;cmd=insert&amp;tech='.$Element.'"><img class="tooltip" name="<table><td>'.$LNG['bd_research'].(($LevelToDo == 1) ? '' : ' '.$LNG['bd_lvl'].' '.$LevelToDo).'</td></table>" src="styles/theme/' .$skin_raza .'/imagenes/navegacion/construir.gif" /></a>' : '<img class="tooltip" name="<table><td>'.$LNG['bd_research'].(($LevelToDo == 1) ? '' : ' '.$LNG['bd_lvl'].' '.$LevelToDo).'</td></table>" src="styles/theme/' .$skin_raza .'/imagenes/navegacion/construir_red.gif" />';
		
				} else {
					if ($USER['b_tech_id'] == $Element) {
						$template->loadscript('research.js');
						if ($USER['b_tech_planet'] == $PLANET['id']) {
							$ScriptInfo	= array(
								'tech_time'		=> $USER['b_tech'],
								'tech_name'		=> '',
								'game_name'		=> $CONF['game_name'],
								'tech_lang'		=> $LNG['tech'][$USER['b_tech_id']],
								'tech_home'		=> $USER['b_tech_planet'],
								'tech_id'		=> $USER['b_tech_id'],					
								'bd_cancel'		=> $LNG['bd_cancel'],
								'bd_ready'		=> $LNG['bd_ready'],
								'bd_continue'	=> $LNG['bd_continue'],
							);
						} else {
							$ScriptInfo	= array(
								'tech_time'		=> $USER['b_tech'],
								'tech_name'		=> $LNG['bd_on'].'<br>'.$TechQueue['planet'],
								'tech_home'		=> $USER['b_tech_planet'],
								'tech_id'		=> $USER['b_tech_id'],
								'game_name'		=> $CONF['game_name'],
								'tech_lang'		=> $LNG['tech'][$USER['b_tech_id']],
								'bd_cancel'		=> $LNG['bd_cancel'],
								'bd_ready'		=> $LNG['bd_ready'],
								'bd_continue'	=> $LNG['bd_continue'],
							);
						}

						$TechnoLink  = '<div id="research"></div>';
					}
					else
						$TechnoLink  = '-';
				}
			}
			
			if (count($TechQueue) >= 1 and $USER['commander'] <= 0) {
			$TechnoLink  =	'<img class="tooltip" name="<table><td>'.$LNG['bd_commander'].'</td></table>" src="styles/theme/' .$skin_raza .'/imagenes/navegacion/construir_red.gif" />';
			}
			
			if($USER['technocratic'] >= 1) {
				$irv = "<font color=\"lime\">(+2)</font>";
			} else {
				$irv = "";
			}
			
			$ResearchList[] = array(
				'id'		=> $Element,
				'maxinfo'	=> (isset($pricelist[$Element]['max']) && $pricelist[$Element]['max'] != 255) ? sprintf($LNG['bd_max_lvl'], $pricelist[$Element]['max']):'',
				'name'  	=> $LNG['tech'][$Element],
				'descr'  	=> $LNG['res']['descriptions'][$Element],
				'price'  	=> GetElementPrice($USER, $PLANET, $Element),					
				'time' 		=> pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
				'restprice'	=> $this->GetRestPrice($Element),
				'elvl'		=> ($Element == 106),
				'lvl'		=> $USER[$resource[$Element]],
				'link'  	=> $TechnoLink,
				'irv' => $irv,
				'oldlink'  	=> MAX_RESEACH_QUEUE_SIZE == 1,
				'queue'  	=> $TechQueue,
			);
		}
		$template->assign_vars(array(
			'ResearchList'			=> $ResearchList,
			'IsLabinBuild'			=> !$bContinue,
			'ScriptInfo'			=> json_encode($ScriptInfo),
			'bd_building_lab'		=> $LNG['bd_building_lab'],
			'bd_remaining'			=> $LNG['bd_remaining'],			
			'bd_lvl'				=> $LNG['bd_lvl'],			
			'fgf_time'				=> $LNG['fgf_time'],
		));
		
		$template->show('construibles/buildings_research.tpl');
	}
}