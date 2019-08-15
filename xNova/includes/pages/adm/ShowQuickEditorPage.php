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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowQuickEditorPage()
{
	global $USER, $LNG, $db, $reslist, $resource;
	$action	= request_var('action', '');
	$edit	= request_var('edit', '');
	$id 	= request_var('id', 0);

	switch($edit)
	{
		case 'planet':
			$DataIDs	= array_merge($reslist['fleet'], $reslist['build'], $reslist['defense']);
			foreach($DataIDs as $ID)
			{
				$SpecifyItemsPQ	.= "`".$resource[$ID]."`,";
			}
			$PlanetData	= $db->uniquequery("SELECT ".$SpecifyItemsPQ." `name`, `id_owner`, `planet_type`, `galaxy`, `system`, `planet`, `destruyed`, `diameter`, `field_current`, `field_current`, `field_max`, `temp_min`, `temp_max`, `metal`, `crystal`, `deuterium`, `norio` FROM ".PLANETS." WHERE `id` = '".$id."';");
			
			$reslist['build']	= $reslist['allow'][$PlanetData['planet_type']];
			
			if($action == 'send'){
				$SQL	= "UPDATE ".PLANETS." SET ";
				foreach($DataIDs as $ID)
				{
					$SQL	.= "`".$resource[$ID]."` = '".request_outofint($resource[$ID])."', ";
				}
				$SQL	.= "`metal` = '".request_outofint('metal')."', ";
				$SQL	.= "`crystal` = '".request_outofint('crystal')."', ";
				$SQL	.= "`deuterium` = '".request_outofint('deuterium')."', ";
				$SQL	.= "`norio` = '".request_outofint('norio')."', ";				
				$SQL	.= "`field_max` = '".request_var('field_max', 0)."', ";
				$SQL	.= "`name` = '".$db->sql_escape(request_var('name', '', UTF8_SUPPORT))."' ";
				$SQL	.= "WHERE `id` = '".$id."' AND `universe` = '".$_SESSION['adminuni']."';";
				
				$db->query($SQL);
				exit(sprintf($LNG['qe_edit_planet_sucess'], $PlanetData['name'], $PlanetData['galaxy'], $PlanetData['system'], $PlanetData['planet']));
			}
			$UserInfo				= $db->uniquequery("SELECT `username` FROM ".USERS." WHERE `id` = '".$PlanetData['id_owner']."' AND `universe` = '".$_SESSION['adminuni']."';");

			$build = $defense = $fleet	= array();
			
			foreach($reslist['build'] as $ID)
			{
				$build[]	= array(
					'type'	=> $resource[$ID],
					'name'	=> $LNG['tech'][$ID],
					'count'	=> pretty_number($PlanetData[$resource[$ID]]),
					'input'	=> $PlanetData[$resource[$ID]]
				);
			}
			
			foreach($reslist['fleet'] as $ID)
			{
				$fleet[]	= array(
					'type'	=> $resource[$ID],
					'name'	=> $LNG['tech'][$ID],
					'count'	=> pretty_number($PlanetData[$resource[$ID]]),
					'input'	=> $PlanetData[$resource[$ID]]
				);
			}
			
			foreach($reslist['defense'] as $ID)
			{
				$defense[]	= array(
					'type'	=> $resource[$ID],
					'name'	=> $LNG['tech'][$ID],
					'count'	=> pretty_number($PlanetData[$resource[$ID]]),
					'input'	=> $PlanetData[$resource[$ID]]
				);
			}

			$template	= new template();
			$template->assign_vars(array(	
				'qe_resources'	=> $LNG['qe_resources'],
				'Metal'			=> $LNG['Metal'],
				'Crystal'		=> $LNG['Crystal'],
				'Deuterium'		=> $LNG['Deuterium'],
				'Norio'			=> $LNG['Norio'],				
				'qe_defensive'	=> $LNG['qe_defensive'],
				'qe_fleet'		=> $LNG['qe_fleet'],
				'qe_build'		=> $LNG['qe_build'],
				'qe_input'		=> $LNG['qe_input'],
				'qe_count'		=> $LNG['qe_count'],
				'qe_level'		=> $LNG['qe_level'],
				'qe_name'		=> $LNG['qe_name'],
				'qe_reset'		=> $LNG['qe_reset'],
				'qe_send'		=> $LNG['qe_send'],
				'qe_temp'		=> $LNG['qe_temp'],
				'qe_fields'		=> $LNG['qe_fields'],
				'qe_owner'		=> $LNG['qe_owner'],
				'qe_coords'		=> $LNG['qe_coords'],
				'qe_id'			=> $LNG['qe_id'],
				'qe_info'		=> $LNG['qe_info'],
				'build'			=> $build,
				'fleet'			=> $fleet,
				'defense'		=> $defense,
				'id'			=> $id,
				'ownerid'		=> $PlanetData['id_owner'],
				'ownername'		=> $UserInfo['username'],
				'name'			=> $PlanetData['name'],
				'galaxy'		=> $PlanetData['galaxy'],
				'system'		=> $PlanetData['system'],
				'planet'		=> $PlanetData['planet'],
				'field_min'		=> $PlanetData['field_current'],
				'field_max'		=> $PlanetData['field_max'],
				'temp_min'		=> $PlanetData['temp_min'],
				'temp_max'		=> $PlanetData['temp_max'],
				'metal'			=> floattostring($PlanetData['metal']),
				'crystal'		=> floattostring($PlanetData['crystal']),
				'deuterium'		=> floattostring($PlanetData['deuterium']),
				'norio'			=> floattostring($PlanetData['norio']),				
				'metal_c'		=> pretty_number($PlanetData['metal']),
				'crystal_c'		=> pretty_number($PlanetData['crystal']),
				'deuterium_c'	=> pretty_number($PlanetData['deuterium']),
				'norio_c'		=> pretty_number($PlanetData['norio']),				
			));
			$template->show('adm/QuickEditorPlanet.tpl');
		break;
		case 'player':
			foreach($reslist['tech'] as $ID)
			{
				$SpecifyItemsPQ	.= "`".$resource[$ID]."`,";
			}
			$UserData	= $db->uniquequery("SELECT ".$SpecifyItemsPQ." `username`, `authlevel`, `galaxy`, `system`, `planet`, `id_planet`, `darkmatter`, `authattack`, `authlevel` FROM ".USERS." WHERE `id` = '".$id."';");
			$ChangePW	= $USER['id'] == ROOT_USER || ($id != ROOT_USER && $USER['authlevel'] > $UserData['authlevel']);
		
			if($action == 'send'){
				$SQL	= "UPDATE ".USERS." SET ";
				foreach($reslist['tech'] as $ID)
				{
					$SQL	.= "`".$resource[$ID]."` = '".abs(request_var($resource[$ID], 0))."', ";
				}
				$SQL	.= "`darkmatter` = '".max(request_var('darkmatter', 0), 0)."', ";
				if(!empty($_POST['password']) && $ChangePW)
					$SQL	.= "`password` = '".md5(request_var('password', '', true))."', ";
				$SQL	.= "`username` = '".$db->sql_escape(request_var('name', '', UTF8_SUPPORT))."', ";
				$SQL	.= "`authattack` = '".($UserData['authlevel'] != AUTH_USR && request_var('authattack', '') == 'on' ? $UserData['authlevel'] : 0)."' ";
				$SQL	.= "WHERE `id` = '".$id."' AND `universe` = '".$_SESSION['adminuni']."';";
				$db->query($SQL);
				
				
				exit(sprintf($LNG['qe_edit_player_sucess'], $UserData['username'], $id));
			}
			$PlanetInfo				= $db->uniquequery("SELECT `name` FROM ".PLANETS." WHERE `id` = '".$UserData['id_planet']."' AND `universe` = '".$_SESSION['adminuni']."';");

			$tech	= array();
			
			foreach($reslist['tech'] as $ID)
			{
				$tech[]	= array(
					'type'	=> $resource[$ID],
					'name'	=> $LNG['tech'][$ID],
					'count'	=> pretty_number($UserData[$resource[$ID]]),
					'input'	=> $UserData[$resource[$ID]]
				);
			}

			$template	= new template();
			$template->assign_vars(array(	
				'qe_resources'	=> $LNG['qe_resources'],
				'Darkmatter'	=> $LNG['Darkmatter'],
				'qe_tech'		=> $LNG['qe_tech'],
				'qe_input'		=> $LNG['qe_input'],
				'qe_level'		=> $LNG['qe_level'],
				'qe_name'		=> $LNG['qe_name'],
				'qe_reset'		=> $LNG['qe_reset'],
				'qe_send'		=> $LNG['qe_send'],
				'qe_password'	=> $LNG['qe_password'],
				'qe_owner'		=> $LNG['qe_owner'],
				'qe_hpcoords'	=> $LNG['qe_hpcoords'],
				'qe_id'			=> $LNG['qe_id'],
				'qe_info'		=> $LNG['qe_info'],
				'qe_change'		=> $LNG['qe_change'],
				'qe_authattack'	=> $LNG['qe_authattack'],
				'tech'			=> $tech,
				'id'			=> $id,
				'planetid'		=> $UserData['id_planet'],
				'planetname'	=> $PlanetInfo['name'],
				'name'			=> $UserData['username'],
				'galaxy'		=> $UserData['galaxy'],
				'system'		=> $UserData['system'],
				'planet'		=> $UserData['planet'],
				'authlevel'		=> $UserData['authlevel'],
				'authattack'	=> $UserData['authattack'],
				'ChangePW'		=> $ChangePW,
				'darkmatter'	=> floattostring($UserData['darkmatter']),
				'darkmatter_c'	=> pretty_number($UserData['darkmatter']),
			));
			$template->show('adm/QuickEditorUser.tpl');
		break;
	}
}
?>