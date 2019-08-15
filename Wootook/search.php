<?php
/**
 * This file is part of Wootook
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://wootook.org/
 *
 * Copyright (c) 2009-Present, Wootook Support Team <http://wootook.org>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing Wootook.
 *
 */

define('INSIDE' , true);
define('INSTALL' , false);
require_once dirname(__FILE__) .'/application/bootstrap.php';

$searchtext = mysql_escape_string($_POST['searchtext']);
$type = $_POST['type'];

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

includeLang('search');
$i = 0;
//creamos la query
$searchtext = mysql_escape_string($_POST["searchtext"]);
switch($type){
	case "playername":
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$search = doquery("SELECT * FROM {{table}} WHERE username LIKE '%{$searchtext}%' LIMIT 30;","users");
	break;
	case "planetname":
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$search = doquery("SELECT * FROM {{table}} WHERE name LIKE '%{$searchtext}%' LIMIT 30",'planets');
	break;
	case "allytag":
		$table = gettemplate('search_ally_table');
		$row = gettemplate('search_ally_row');
		$search = doquery("SELECT * FROM {{table}} WHERE ally_tag LIKE '%{$searchtext}%' LIMIT 30","alliance");
	break;
	case "allyname":
		$table = gettemplate('search_ally_table');
		$row = gettemplate('search_ally_row');
		$search = doquery("SELECT * FROM {{table}} WHERE ally_name LIKE '%{$searchtext}%' LIMIT 30","alliance");
	break;
	default:
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$search = doquery("SELECT * FROM {{table}} WHERE username LIKE '%{$searchtext}%' LIMIT 30","users");
}
/*
  Esta es la tecnica de, "el ahorro de queries".
  Inventada por Perberos :3
  ...pero ahora no... porque tengo sueño ;P
*/
if(isset($searchtext) && isset($type)){

	while($r = $search->fetch(PDO::FETCH_BOTH)){

		if($type=='playername'||$type=='planetname'){
			$s=$r;
			//para obtener el nombre del planeta
			if ($type == "planetname")
			{
			$pquery = doquery("SELECT * FROM {{table}} WHERE id = {$s['id_owner']}","users",true);
/*			$farray = mysql_fetch_array($pquery);*/
			$s['planet_name'] = $s['name'];
			$s['username'] = $pquery['username'];
			$s['ally_name'] = ($pquery['ally_name']!='')?"<a href=\"alliance.php?mode=ainfo&tag={$pquery['ally_name']}\">{$pquery['ally_name']}</a>":'';
			}else{
			$pquery = doquery("SELECT name FROM {{table}} WHERE id = {$s['id_planet']}","planets",true);
			$s['planet_name'] = $pquery['name'];
			$s['ally_name'] = ($aquery['ally_name']!='')?"<a href=\"alliance.php?mode=ainfo&tag={$aquery['ally_name']}\">{$aquery['ally_name']}</a>":'';
			}
			//ahora la alianza
			if($s['ally_id']!=0&&$s['ally_request']==0){
				$aquery = doquery("SELECT ally_name FROM {{table}} WHERE id = {$s['ally_id']}","alliance",true);
			}else{
				$aquery = array();
			}



			$s['position'] = "<a href=\"stat.php?start=".$s['rank']."\">".$s['rank']."</a>";
			$s['dpath'] = $dpath;
			$s['coordinated'] = "{$s['galaxy']}:{$s['system']}:{$s['planet']}";
			$s['buddy_request'] = $lang['buddy_request'];
			$s['write_a_messege'] = $lang['write_a_messege'];
			$result_list .= parsetemplate($row, $s);
		}elseif($type=='allytag'||$type=='allyname'){
			$s=$r;

			$s['ally_points'] = pretty_number($s['ally_points']);

			$s['ally_tag'] = "<a href=\"alliance.php?mode=ainfo&tag={$s['ally_tag']}\">{$s['ally_tag']}</a>";
			$result_list .= parsetemplate($row, $s);
		}
	}
	if($result_list!=''){
		$lang['result_list'] = $result_list;
		$search_results = parsetemplate($table, $lang);
	}
}

//el resto...
$lang['type_playername'] = ($_POST["type"] == "playername") ? " SELECTED" : "";
$lang['type_planetname'] = ($_POST["type"] == "planetname") ? " SELECTED" : "";
$lang['type_allytag'] = ($_POST["type"] == "allytag") ? " SELECTED" : "";
$lang['type_allyname'] = ($_POST["type"] == "allyname") ? " SELECTED" : "";
$lang['searchtext'] = $searchtext;
$lang['search_results'] = $search_results;
//esto es algo repetitivo ... w
$page = parsetemplate(gettemplate('search_body'), $lang);
display($page,$lang['Search']);
?>
