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

class ShowInfosPage
{
	private function GetNextJumpWaitTime($CurMoon, $ReturnString = false)
	{
		global $resource, $CONF;
		
		$JumpGateLevel  = $CurMoon[$resource[43]];
		$LastJumpTime   = $CurMoon['last_jump_time'];

		$RestWait   = 0;
		$RestString = "";		

		$NextJumpTime   = $LastJumpTime + JUMPGATE_WAIT_TIME;
		
		if ($NextJumpTime >= TIMESTAMP) {
			$RestWait   = $NextJumpTime - TIMESTAMP;
			$RestString = pretty_time($RestWait);
		}

		return $ReturnString ? $RestString : $RestWait;
	}

	private function DoFleetJump()
	{
		global $USER, $PLANET, $resource, $LNG, $db, $reslist;

		$RestString   = $this->GetNextJumpWaitTime($PLANET, true);
		$NextJumpTime = $RestString;
		$JumpTime     = TIMESTAMP;

		if (!empty($NextJumpTime))
			return json_encode(array('message' => $LNG['in_jump_gate_already_used'].' '.pretty_time($LastJumpTime), 'error' => true));
			
		$TargetPlanet = request_var('jmpto', $PLANET['id']);
		$TargetGate   = $db->uniquequery("SELECT `id`, `last_jump_time` FROM ".PLANETS." WHERE `id` = '".$TargetPlanet."' AND `sprungtor` > '0';");

		if (!isset($TargetGate) || $TargetPlanet == $PLANET['id'])
			return json_encode(array('message' =>  $LNG['in_jump_gate_doesnt_have_one'], 'error' => true));
			
		$RestString   = $this->GetNextJumpWaitTime($TargetGate, true);
		
		if (!empty($RestString))
			return json_encode(array('message' =>  $LNG['in_jump_gate_not_ready_target'].' '.$RestString, 'error' => true));
		
		$ShipArray   = array();
		$SubQueryOri = "";
		$SubQueryDes = "";

		foreach($reslist['fleet'] as $Ship)
		{
			$ShipArray[$Ship]	=	min(request_var('ship'.$Ship, 0.0), $PLANET[$resource[$Ship]]);
			if($Ship == 212 || $ShipArray[$Ship] <= 0)
				continue;
				
			$SubQueryOri 		.= "`".$resource[$Ship]."` = `".$resource[$Ship]."` - '". floattostring($ShipArray[$Ship])."', ";
			$SubQueryDes 		.= "`".$resource[$Ship]."` = `".$resource[$Ship]."` + '". floattostring($ShipArray[$Ship])."', ";
			$PLANET[$resource[$Ship]] -= $ShipArray[$Ship];
		}

		if (empty($SubQueryOri))
			return json_encode(array('message' =>  $LNG['in_jump_gate_error_data'], 'error' => true));

		$SQL  = "UPDATE ".PLANETS." SET ";
		$SQL .= $SubQueryOri;
		$SQL .= "`last_jump_time` = '". $JumpTime ."' ";
		$SQL .= "WHERE ";
		$SQL .= "`id` = '". $PLANET['id'] ."';";
		$SQL .= "UPDATE ".PLANETS." SET ";
		$SQL .= $SubQueryDes;
		$SQL .= "`last_jump_time` = '". $JumpTime ."' ";
		$SQL .= "WHERE ";
		$SQL .= "`id` = '".$TargetPlanet."';";
		$db->multi_query($SQL);

		$PLANET['last_jump_time'] 	= $JumpTime;
		return json_encode(array('message' =>  sprintf($LNG['in_jump_gate_done'], $this->GetNextJumpWaitTime($PLANET, true)), 'error' => false));
	}

	private function BuildFleetListRows ($PLANET)
	{
		global $reslist, $resource, $LNG;

		foreach($reslist['fleet'] as $Ship)
		{
			if ($Ship == 212 || $PLANET[$resource[$Ship]] <= 0)
				continue;
			
			$GateFleetList[]	= array(
				'id'        => $Ship,
				'name'      => $LNG['tech'][$Ship],
				'max'       => ($PLANET[$resource[$Ship]]),
			);
		}
		
		return $GateFleetList;
	}

	private function BuildJumpableMoonCombo($USER, $PLANET)
	{
		global $resource, $db;
		$MoonList        = $db->query("SELECT `id`, `galaxy`, `system`, `planet`, `last_jump_time`, `".$resource[43]."` FROM ".PLANETS." WHERE `id` != '".$PLANET['id']."' AND `planet_type` = '3' AND `id_owner` = '". $USER['id'] ."' AND `".$resource[43]."` > '0';");
		$Combo           = array();
		while($CurMoon = $db->fetch_array($MoonList)) {
			$Time	= $this->GetNextJumpWaitTime($CurMoon, true);
			$Selector[$CurMoon['id']]	= '['.$CurMoon['galaxy'].':'.$CurMoon['system'].':'.$CurMoon['planet'].'] '.$CurMoon['name'].(!empty($Time) ? ' ('.$Time.')':'');
		}
		return $Selector;
	}

	public function __construct()
	{
		global $USER, $PLANET, $dpath, $LNG, $resource, $pricelist, $reslist, $CombatCaps, $ProdGrid, $CONF;

		$BuildID 	= request_var('gid', 0);
		
		$template	= new template();
		$template->isDialog(true);
	
		if(in_array($BuildID, $reslist['prod']) && $BuildID != 212)
		{
			$BuildLevelFactor	= 10;
			$BuildTemp       	= $PLANET['temp_max'];
			$CurrentBuildtLvl	= $PLANET[$resource[$BuildID]];
			$BuildEnergy		= $USER[$resource[113]];
			$BuildLevel     	= max($CurrentBuildtLvl, 1);
			$Prod[1]         	= round(eval($ProdGrid[$BuildID]['formule']['metal'])     * $CONF['resource_multiplier']);
			$Prod[2]         	= round(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $CONF['resource_multiplier']);
			$Prod[7]         	= round(eval($ProdGrid[$BuildID]['formule']['norio'])     * $CONF['resource_multiplier']);
			$Prod[3]          	= round(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $CONF['resource_multiplier']);
			$Prod[4] 			= round(eval($ProdGrid[$BuildID]['formule']['energy'])    * $CONF['resource_multiplier']);
			$Prod[12] 			= round(eval($ProdGrid[$BuildID]['formule']['energy'])    * $CONF['resource_multiplier']);
			$BuildStartLvl   	= max($CurrentBuildtLvl - 2, 1);
						
			$ActualProd			= floor($Prod[$BuildID]);
			$ActualNeed			= $BuildID != 12 ? floor($Prod[4]) : floor($Prod[3]);

			$ProdFirst = 0;
			
			for($BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++ )
			{
				$Prod[1]    = round(eval($ProdGrid[$BuildID]['formule']['metal'])     * $CONF['resource_multiplier']);
				$Prod[2]    = round(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $CONF['resource_multiplier']);
				$Prod[3]   	= round(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $CONF['resource_multiplier']);
				$Prod[7]    = round(eval($ProdGrid[$BuildID]['formule']['norio'])     * $CONF['resource_multiplier']);
				$Prod[4] 	= round(eval($ProdGrid[$BuildID]['formule']['energy'])    * $CONF['resource_multiplier']);
				$Prod[12] 	= round(eval($ProdGrid[$BuildID]['formule']['energy'])    * $CONF['resource_multiplier']);
				
				$NeesRess	= $BuildID != 12 ? floor($Prod[4]) : floor($Prod[3]);
				
				$prod		= pretty_number(floor($Prod[$BuildID]));
				$prod_diff	= colorNumber(pretty_number(floor($Prod[$BuildID] - $ActualProd)));
				$need		= colorNumber(pretty_number(floor($NeesRess)));
				$need_diff	= colorNumber(pretty_number(floor($NeesRess - $ActualNeed)));

				if ($ProdFirst == 0)
					$ProdFirst = floor($Prod[$BuildID]);
				
				$ProductionTable[] = array(
					'BuildLevel'		=> $BuildLevel,
					'prod'	     		=> $prod,
					'prod_diff'			=> $prod_diff,
					'need'				=> $need,
					'need_diff'			=> $need_diff,
				);
			}
		}
		elseif(in_array($BuildID, $reslist['fleet']))
		{
			for ($Type = 200; $Type < 500; $Type++)
			{
				if ($CombatCaps[$BuildID]['sd'][$Type] > 1)
					$RapidFire['to'][$LNG['tech'][$Type]] = $CombatCaps[$BuildID]['sd'][$Type];
					
				if ($CombatCaps[$Type]['sd'][$BuildID] > 1)
					$RapidFire['from'][$LNG['tech'][$Type]] = $CombatCaps[$Type]['sd'][$BuildID];
			}

			$FleetInfo[$LNG['in_struct_pt']]		= pretty_number($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal'] + $pricelist[$BuildID]['norio']);
			$FleetInfo[$LNG['in_shield_pt']]		= pretty_number($CombatCaps[$BuildID]['shield']);
			$FleetInfo[$LNG['in_attack_pt']]		= pretty_number($CombatCaps[$BuildID]['attack']);
			$FleetInfo[$LNG['in_capacity']]		= pretty_number($pricelist[$BuildID]['capacity']);
			$FleetInfo[$LNG['in_base_speed']][]	= pretty_number($pricelist[$BuildID]['speed']);
			$FleetInfo[$LNG['in_consumption']][]	= pretty_number($pricelist[$BuildID]['consumption']);
			$FleetInfo[$LNG['in_base_speed']][]	= pretty_number($pricelist[$BuildID]['speed2']);
			$FleetInfo[$LNG['in_consumption']][]	= pretty_number($pricelist[$BuildID]['consumption2']);
		}
		elseif (in_array($BuildID, $reslist['defense']))
		{
			for ($Type = 200; $Type < 500; $Type++)
			{
				if ($CombatCaps[$BuildID]['sd'][$Type] > 1)
					$RapidFire['to'][$LNG['tech'][$Type]] = $CombatCaps[$BuildID]['sd'][$Type];
					
				if ($CombatCaps[$Type]['sd'][$BuildID] > 1)
					$RapidFire['from'][$LNG['tech'][$Type]] = $CombatCaps[$Type]['sd'][$BuildID];
			}

			$FleetInfo[$LNG['in_struct_pt']]		= pretty_number($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal'] + $pricelist[$BuildID]['norio']);
			$FleetInfo[$LNG['in_shield_pt']]		= pretty_number($CombatCaps[$BuildID]['shield']);
			$FleetInfo[$LNG['in_attack_pt']]		= pretty_number($CombatCaps[$BuildID]['attack']);
		}
		elseif($BuildID == 43 && $PLANET[$resource[43]] > 0)
				{
			if($_GET['action'] == 'send')
				exit($this->DoFleetJump());
				$gate_jump = $this->GetNextJumpWaitTime($PLANET);
				include_once(ROOT_PATH . 'includes/functions/InsertJavaScriptChronoApplet.php');
			$template->assign_vars(array(
				'gate_time_script'	=> InsertJavaScriptChronoApplet("Gate", "1", $gate_jump, true),
				'gate_script_go'	=> InsertJavaScriptChronoApplet("Gate", "1", $gate_jump, false),
				'gate_rest_time'	=> $this->GetNextJumpWaitTime($PLANET),
				'gate_start_link'	=> BuildPlanetAdressLink($PLANET),
				'gate_moons'		=> $this->BuildJumpableMoonCombo($USER, $PLANET),
				'gate_fleets'		=> $this->BuildFleetListRows($PLANET),
			));
				
		}
		
		if (in_array($BuildID, $reslist['tech']))
		{
			$description = $OfficerInfo[$BuildID]['info'] ? sprintf($LNG['info'][$BuildID]['description'], ((is_float($OfficerInfo[$BuildID]['info']))? $OfficerInfo[$BuildID]['info'] * 100 : $OfficerInfo[$BuildID]['info']), $pricelist[$BuildID]['max']) : sprintf($LNG['info'][$BuildID]['description'], $pricelist[$BuildID]['max']);
		}
		else
		{
			$description = $LNG['info'][$BuildID]['description'];
		}
	
		if($USER['raza'] == 0) {
		$skin = "gultra";
		} elseif ($USER['raza'] == 1) {
		$skin = "voltra";
		} 
	
		if($BuildID == 202 or $BuildID == 203 or $BuildID == 209 or $BuildID == 217 or $BuildID == 219) {
			$tipo = "<div class=\"imagen_tipo\"><center><img src=\"styles/theme/" .$skin ."/imagenes/otros/fragata.png\" width=\"70\" height=\"69\"/><br /><b>" .$LNG['fragatas'] ."</b></center></div>";
		}
		
		if($BuildID == 204 or $BuildID == 205) {
			$tipo = "<div class=\"imagen_tipo\"><center><img src=\"styles/theme/" .$skin ."/imagenes/otros/cazador.png\" width=\"70\" height=\"64\"/><br /><b>" .$LNG['cazador'] ."</b></center></div>";
		}
		
		if($BuildID == 206 or $BuildID == 207) {
			$tipo = "<div class=\"imagen_tipo\"><center><img src=\"styles/theme/" .$skin ."/imagenes/otros/crucero.png\" width=\"70\" height=\"66\"/><br /><b>" .$LNG['cruceros'] ."</b></center></div>";
		}
		
		if($BuildID == 208 or $BuildID == 212 or $BuildID == 210 or $BuildID == 220) {
			$tipo = "<div class=\"imagen_tipo\"><center><img src=\"styles/theme/" .$skin ."/imagenes/otros/civil.png\" width=\"70\" height=\"69\"/><br /><b>" .$LNG['civil'] ."</b></center></div>";
		}
		
		if($BuildID == 211 or $BuildID == 213 or $BuildID == 215) {
			$tipo = "<div class=\"imagen_tipo\"><center><img src=\"styles/theme/" .$skin ."/imagenes/otros/insignia.png\" width=\"70\" height=\"77\"/><br /><b>" .$LNG['insignia'] ."</b></center></div>";
		}
		
		if($BuildID == 214 or $BuildID == 216 or $BuildID == 218) {
			$tipo = "<div class=\"imagen_tipo\"><center><img src=\"styles/theme/" .$skin ."/imagenes/otros/capital.png\" width=\"70\" height=\"77\"/><br /><b>" .$LNG['capital'] ."</b></center></div>";
		}
		
		$template->assign_vars(array(		
			'id'							=> $BuildID,
			'name'							=> $LNG['info'][$BuildID]['name'],
			'image'							=> $BuildID,
			'tipo_nave'					=> $tipo,
			'description'					=> $description,
			'ProductionTable'				=> $ProductionTable,
			'RapidFire'						=> $RapidFire,
			'Level'							=> $CurrentBuildtLvl,
			'FleetInfo'						=> $FleetInfo,
			'GateFleetList'					=> $GateFleetList,
			'in_jump_gate_jump' 			=> $LNG['in_jump_gate_jump'],
			'gate_ship_dispo' 				=> $LNG['in_jump_gate_available'],
			'in_level'						=> $LNG['in_level'],
			'in_prod_p_hour'				=> $LNG['in_prod_p_hour'],
			'in_difference'					=> $LNG['in_difference'],
			'in_used_energy'				=> $LNG['in_used_energy'],
			'in_prod_energy'				=> $LNG['in_prod_energy'],
			'in_used_deuter'				=> $LNG['in_used_deuter'],
			'in_rf_again'					=> $LNG['in_rf_again'],
			'in_rf_from'					=> $LNG['in_rf_from'],
			'in_jump_gate_select_ships'		=> $LNG['in_jump_gate_select_ships'],
			'in_jump_gate_start_moon'		=> $LNG['in_jump_gate_start_moon'],
			'in_jump_gate_finish_moon'		=> $LNG['in_jump_gate_finish_moon'],
			'in_jump_gate_wait_time'		=> $LNG['in_jump_gate_wait_time'],
			'Raza_skin'		=> $skin,
		));
		
		$template->show('info_overview.tpl');
	}
}
?>