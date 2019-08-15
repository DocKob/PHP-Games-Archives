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

function GetTeamspeakData()
{
	global $CONF, $USER, $LNG;
	if ($CONF['ts_modon'] == 0)
		return false;
	elseif(!file_exists(ROOT_PATH.'cache/teamspeak_cache.php'))
		return $LNG['ov_teamspeak_not_online'];
	
	$Data		= unserialize(file_get_contents(ROOT_PATH.'cache/teamspeak_cache.php'));
	if(!is_array($Data))
		return $LNG['ov_teamspeak_not_online'];
		
	$Teamspeak 	= '';			

	if($CONF['ts_version'] == 2) {
		$trafges 	= pretty_number($Data[1]['total_bytessend'] / 1048576 + $Data[1]['total_bytesreceived'] / 1048576);
		$Teamspeak	= sprintf($LNG['ov_teamspeak_v2'], $CONF['ts_server'], $CONF['ts_udpport'], $USER['username'], $Data[0]["server_currentusers"], $Data[0]["server_maxusers"], $Data[0]["server_currentchannels"], $trafges);
	} elseif($CONF['ts_version'] == 3){
		$trafges 	= pretty_number($Data['data']['connection_bytes_received_total'] / 1048576 + $Data['data']['connection_bytes_sent_total'] / 1048576);
		$Teamspeak	= sprintf($LNG['ov_teamspeak_v3'], $CONF['ts_server'], $CONF['ts_tcpport'], $USER['username'], $Data['data']['virtualserver_password'], ($Data['data']['virtualserver_clientsonline'] - 1), $Data['data']['virtualserver_maxclients'], $Data['data']['virtualserver_channelsonline'], $trafges);
	}
	return $Teamspeak;
}

function ShowOverviewPage()
{
	global $CONF, $LNG, $PLANET, $USER, $db, $resource, $UNI, $dpath;
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();
	
	$template	= new template();	
	$template->getplanets();
	$AdminsOnline = $AllPlanets = $Moon = array();
	$Buildtime	= 0;
	
		if($USER['raza'] == 0) {
		$skin_raza = "gultra";
		$img_raza = "styles/theme/gultra/imagenes/gultra.png";
		} elseif ($USER['raza'] == 1) {
		$skin_raza = "voltra";
		$img_raza = "styles/theme/voltra/imagenes/voltra.png";
		} 
	
	foreach($template->UserPlanets as $ID => $CPLANET)
	{		
		if ($ID == $_SESSION['planet'] || $CPLANET['planet_type'] == 3)
			continue;

		if (!empty($CPLANET['b_building']) && $CPLANET['b_building'] > TIMESTAMP) {
		$Queue				= unserialize($CPLANET['b_building_id']);
		$BuildPlanet		= "<img src=\"styles/theme/" .$skin_raza ."/gebaeude/" .$Queue[0][0] ."png\" width=\"140\" height=\"140\" /><br />" .$LNG['tech'][$Queue[0][0]]." (".$Queue[0][1].")<br /><span style=\"color:#7F7F7F;\"><b>(".pretty_time($Queue[0][3] - TIMESTAMP).")</b></span>";
		} else {
			$BuildPlanet     = $LNG['ov_free'];
		}
		
		$AllPlanets[] = array(
			'id'	=> $CPLANET['id'],
			'name'	=> $CPLANET['name'],
			'image'	=> $CPLANET['image'],
			'build'	=> $BuildPlanet,
		);
	}
		
	if ($PLANET['id_luna'] != 0)
	{
		$Moon = $db->uniquequery("SELECT `id`, `name` FROM ".PLANETS." WHERE `id` = '".$PLANET['id_luna']."';");
	}

	if (!empty($PLANET['b_building'])) {
		$Queue		= unserialize($PLANET['b_building_id']);
		$Build		= "<a href=\"?page=buildings\" class=\"tooltip\" name=\"" .$LNG['tech'][$Queue[0][0]]  ."\"><img src=\"styles/theme/" .$skin_raza ."/gebaeude/" .$Queue[0][0] .".png\"  width=\"140\" height=\"140\" /></a><br /><b>" .$LNG['ov_subiendo'] ." " .$Queue[0][1] ."</b>";
		$Buildtime	= $PLANET['b_building'] - TIMESTAMP;
	}
	else
	{
		$Build 		= "<center>" .$LNG['ov_free_estructuras'] ."</center>";
	}
	
	if (!empty($PLANET['b_hangar'])) {
		$Queue2		= unserialize($PLANET['b_hangar_id']);
		$Build_h	= "<a href=\"?page=buildings&mode=fleet\" class=\"tooltip\" name=\"" .$LNG['tech'][$Queue2[0][0]] ."\"><img src=\"styles/theme/" .$skin_raza ."/gebaeude/" .$Queue2[0][0] .".png\"  width=\"140\" height=\"140\"  /></a><br /><b>" .sprintf($LNG['ov_cantidad'], $Queue2[0][1])."</b>" ;
	}
	else
	{
		$Build_h	= "<center>" .$LNG['ov_free_hangar'] ."</center>";
	}
	$OnlineAdmins 	= $db->query("SELECT `id`,`username` FROM ".USERS." WHERE `universe` = '".$UNI."' AND `onlinetime` >= '".(TIMESTAMP-10*60)."' AND `authlevel` > '".AUTH_USR."';");
	
	while ($AdminRow = $db->fetch_array($OnlineAdmins)) {
		$AdminsOnline[$AdminRow['id']]	= $AdminRow['username'];
	}

	if($PLANET['der_metal']  > 0 or $PLANET['der_crystal'] > 0) {
		$escombros = "<img class=\"tooltip\" name=\"" .$LNG['Metal'] .": " .$PLANET['der_metal'] ."<br />" .$LNG['Crystal'] .": " .$PLANET['der_crystal']  ."\" src=\"styles/theme/" .$skin_raza ."/imagenes/escombro.png\" />";
	} else {
		$escombros = "<img src=\"styles/theme/" .$skin_raza ."/imagenes/escombro_o.png\" />";
	}
		
	if ($USER['total_points'] >= 0 and $USER['total_points'] < 1000) {
		$nivel = $LNG['rang_1'] ;
		$rango = 1;
	} elseif ($USER['total_points'] > 1000 and $USER['total_points'] < 10000) {
		$nivel = $LNG['rang_2'] ;
		$rango = 2;
	} elseif ($USER['total_points'] > 10000 and $USER['total_points'] < 100000) {
		$nivel = $LNG['rang_3'] ;
		$rango = 3;
	}  elseif ($USER['total_points'] > 100000 and $USER['total_points'] < 1000000) {
		$nivel = $LNG['rang_4'] ;
		$rango = 4;
	}  elseif ($USER['total_points'] > 1000000 and $USER['total_points'] < 10000000) {
		$nivel = $LNG['rang_5'] ;
		$rango = 5;
	}  elseif ($USER['total_points'] > 10000000 and $USER['total_points'] < 100000000) {
		$nivel = $LNG['rang_6'] ;
		$rango = 6;
	}  elseif ($USER['total_points'] > 100000000 and $USER['total_points'] < 1000000000) {
		$nivel = $LNG['rang_7'] ;
		$rango = 7;
	}  elseif ($USER['total_points'] > 1000000000 and $USER['total_points'] < 10000000000) {
		$nivel = $LNG['rang_8'] ;
		$rango = 8;
	}  elseif ($USER['total_points'] > 10000000000) {
		$nivel = $LNG['rang_9'] ;
		$rango = 9;
	} 
	

	$frgg =  pretty_number($PLANET['small_ship_cargo'] + $PLANET['big_ship_cargo'] + $PLANET['recycler'] + $PLANET['ev_transporter'] + $PLANET['giga_recykler']);
	$czz = pretty_number($PLANET['light_hunter'] + $PLANET['heavy_hunter']);
	$cvvl = pretty_number($PLANET['colonizer'] + $PLANET['solar_satelit'] + $PLANET['spy_sonde'] + $PLANET['dm_ship']);
	$crcc = pretty_number($PLANET['crusher'] + $PLANET['battle_ship']);
	$ibsg = pretty_number($PLANET['bomber_ship'] + $PLANET['destructor'] + $PLANET['battleship']);
	$asd =  pretty_number($PLANET['dearth_star'] + $PLANET['lune_noir'] + $PLANET['star_crasher']);
	$fragata = "<font color=\"#FFFFFF\">" .$LNG['ov_fragatas'] ."</font>" . $frgg;
	$cazador = "<font color=\"#FFFFFF\">" .$LNG['ov_cazador'] ."</font>" . $czz;
	$civil = "<font color=\"#FFFFFF\">" .$LNG['ov_civil'] ."</font>" . $cvvl;
	$crucero = "<font color=\"#FFFFFF\">" .$LNG['ov_cruceros'] ."</font>" . $crcc;
	$insignia = "<font color=\"#FFFFFF\">" .$LNG['ov_insignia']."</font>"  . $ibsg;
	$capital = "<font color=\"#FFFFFF\">" .$LNG['ov_capital']."</font>"  . $asd;
	
	$db->free_result($OnlineAdmins);
	
	$template->loadscript('overview.js');
	$template->execscript('GetFleets(true);');
		
	$template->assign_vars(array(
		'civil' => $civil,
		'fragata' => $fragata,
		'cazador' => $cazador,
		'crucero' => $crucero,
		'insignia' => $insignia,
		'capital' => $capital,
		'user_rank'					=> sprintf($LNG['ov_userrank_info'], pretty_number($USER['total_points']), $LNG['ov_place'], $USER['total_rank'], $USER['total_rank'], $LNG['ov_of'], $CONF['users_amount']),
		'is_news'					=> $CONF['OverviewNewsFrame'],
		'news'						=> makebr($CONF['OverviewNewsText']),
		'planetname'				=> $PLANET['name'],
		'planetimage'				=> $PLANET['image'],
		'nivel'					=> $nivel,
		'rango'				 => $rango,
		'escombros' 		=> $escombros,
		'lvl_rg' => $LNG['bd_lvl'],
		'galaxy'					=> $PLANET['galaxy'],
		'system'					=> $PLANET['system'],
		'planet'					=> $PLANET['planet'],
		'buildtime'					=> $Buildtime,
		'userid'					=> $USER['id'],
		'username'					=> $USER['username'],
		'build'						=> $Build,
		'build_h'					=> $Build_h,
		'Moon'						=> $Moon,
		'AllPlanets'				=> $AllPlanets,
		'AdminsOnline'				=> $AdminsOnline,
		'Teamspeak'					=> GetTeamspeakData(),
		'messages'						=> ($USER['new_message'] > 0) ? (($USER['new_message'] == 1) ? $LNG['ov_have_new_message'] : sprintf($LNG['ov_have_new_messages'], pretty_number($USER['new_message']))): false,
		'planet_diameter'			=> pretty_number($PLANET['diameter']),
		'planet_field_current' 		=> $PLANET['field_current'],
		'planet_field_max' 			=> CalculateMaxPlanetFields($PLANET),
		'planet_temp_min' 			=> $PLANET['temp_min'],
		'planet_temp_max' 			=> $PLANET['temp_max'],
		'ov_news'					=> $LNG['ov_news'],
		'fcm_moon'					=> $LNG['fcm_moon'],
		'ov_server_time'			=> $LNG['ov_server_time'],
		'ov_planet'					=> $LNG['ov_planet'],
		'ov_planetmenu'				=> $LNG['ov_planetmenu'],
		'ov_diameter'				=> $LNG['ov_diameter'],
		'ov_distance_unit'			=> $LNG['ov_distance_unit'],
		'ov_developed_fields'		=> $LNG['ov_developed_fields'],
		'ov_max_developed_fields'	=> $LNG['ov_max_developed_fields'],
		'ov_fields'					=> $LNG['ov_fields'],
		'ov_temperature'			=> $LNG['ov_temperature'],
		'ov_aprox'					=> $LNG['ov_aprox'	], 
		'ov_temp_unit'				=> $LNG['ov_temp_unit'],
		'ov_to'						=> $LNG['ov_to'],
		'ov_position'				=> $LNG['ov_position'],
		'ov_points'					=> $LNG['ov_points'],
		'ov_events'					=> $LNG['ov_events'],
		'ov_admins_online'			=> $LNG['ov_admins_online'],
		'ov_no_admins_online'		=> $LNG['ov_no_admins_online'],
		'ov_userbanner'				=> $LNG['ov_userbanner'],
		'ov_teamspeak'				=> $LNG['ov_teamspeak'],
		'ov_your_planet'			=> $LNG['ov_your_planet'],
		'ov_coords'					=> $LNG['ov_coords'],
		'ov_planet_name'			=> $LNG['ov_planet_name'],
		'ov_actions'				=> $LNG['ov_actions'],
		'ov_abandon_planet'			=> $LNG['ov_abandon_planet'],
		'ov_password'				=> $LNG['ov_password'],
		'ov_planet_rename'			=> $LNG['ov_planet_rename'],
		'ov_rename_label'			=> $LNG['ov_rename_label'],
		'estructuras_construccion'	=> $LNG['ov_estructuras_construccion'],
		'ov_security_confirm'		=> sprintf($LNG['ov_security_confirm'], $PLANET['name']),
		'ov_security_request'		=> $LNG['ov_security_request'],
		'ov_delete_planet'			=> $LNG['ov_delete_planet'],
		'ov_raza_img' => $img_raza,
		'ov_planet_abandoned'		=> $LNG['ov_planet_abandoned'],
		'path'						=> PROTOCOL.$_SERVER['HTTP_HOST'].HTTP_ROOT,
	));
			
	$template->show("vision_general/overview_body.tpl");
	
}
?>