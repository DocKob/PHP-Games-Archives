<?php
//tables                       //columns
$tb[]="ally";                   $cl[]="`id`,`name`,`desc`,`owner`,`acess`";
$tb[]="ally_pact";				$cl[]="`ally1`, `ally2`, `type`, `status`";
$tb[]="banlist";				$cl[]="`usrid`,`timeout`,`reason`";
$tb[]="chat";					$cl[]="`id`, `usrid`, `msg`, `sent_on`";

$tb[]="city";					if( MAP_SYS==1 ) $cl[]="`id`, `owner`, `name`, `last_update`, `x`, `y`, `z`, `img`";
								else $cl[]="`id`, `owner`, `name`, `last_update`, `x`, `y`";
								
$tb[]="city_builds";			if( CITY_SYS ==1 ) $cl[]="`id`, `city`, `build`, `lev`";
								else $cl[]="`id`, `city`, `build`, `lev`, `field`";

$tb[]="city_build_que";			if( CITY_SYS ==1 ) $cl[]="`id` ,  `city` ,  `build` ,  `end`";
								else $cl[]="`id` ,  `city` ,  `build` ,  `end`, `field`";
$tb[]="city_research_que";		$cl[]="`id` ,  `city` ,  `res_id` ,  `end`";
$tb[]="city_resources";			$cl[]="`city_id` ,  `res_id` ,  `res_quantity`";
$tb[]="conf";					$cl[]="`news1`, `rulers`, `server_name`, `server_desc_sub`, `server_desc_main`, `template`, `css`, `MG_max_cap`,  `FLAG_SZERORES`, `FLAG_SUNAVALB`, `FLAG_RESICONS`, `FLAG_RESLABEL`, `baru_tmdl`, `buildfast_molt`, `researchfast_molt`, `sge_ver`";

$tb[]="market";					$cl[]="`id`, `city`, `resoff`, `resoqnt`, `resreq`, `resrqnt`";
$tb[]="plugins";                $cl[]="`name`, `active`, `type`";
$tb[]="races";					$cl[]="`id` ,  `rname` ,  `rdesc` ,  `img`";
$tb[]="resdata";				$cl[]="`id` ,  `name` ,  `prod_rate` ,  `start` ,  `ico`";
$tb[]="resmov";					$cl[]="`id` ,  `to` ,  `end` ,  `res_id` ,  `resqnt`";
$tb[]="tutorial";				$cl[]="`id` ,  `tittle` ,  `body` ,  `next_tut`";
$tb[]="t_builds";				$cl[]="`id` ,  `arac` ,  `name` ,  `func` ,  `produceres` ,  `img` ,  `desc` ,  `time` ,  `time_mpl` ,  `gpoints` ,  `maxlev`";
$tb[]="t_build_reqbuild";		$cl[]="`build` ,  `reqbuild` ,  `lev`";
$tb[]="t_build_req_research";	$cl[]="`build` ,  `reqresearch` ,  `lev`";
$tb[]="t_build_resourcecost";	$cl[]="`build` ,  `resource` ,  `cost` ,  `moltiplier`";
$tb[]="t_research";				$cl[]="`id` , `name` , `desc` , `arac` , `img` , `time` , `time_mpl` , `gpoints` , `maxlev`";
$tb[]="t_research_reqbuild";	$cl[]="`research` ,  `reqbuild` ,  `lev`";
$tb[]="t_research_req_research"; $cl[]="`research` ,  `reqresearch` ,  `lev`";
$tb[]="t_research_resourcecost"; $cl[]="`research` ,  `resource` ,  `cost` ,  `moltiplier`";
$tb[]="t_unt";					$cl[]="`id` ,  `name` ,  `race` ,  `img` ,  `atk` ,  `dif` ,  `vel` ,  `res_car_cap` ,  `etime` ,  `desc` ,  `type`";
$tb[]="t_unt_reqbuild";			$cl[]="`unit` ,  `reqbuild` ,  `lev`";
$tb[]="t_unt_req_research";		$cl[]="`unit` ,  `reqresearch` ,  `lev`";
$tb[]="t_unt_resourcecost";		$cl[]="`unit` ,  `resource` ,  `cost`";
$tb[]="units";					$cl[]="`id` ,  `id_unt` ,  `uqnt` ,  `owner_id` ,  `from` ,  `to` ,  `where` ,  `time` ,  `action`";
$tb[]="unit_que";				$cl[]="`id` ,  `id_unt` ,  `uqnt` ,  `city` ,  `end`";
$tb[]="users";					$cl[]="`id` ,  `username` ,  `password` ,  `race` ,  `capcity` ,  `ally_id` ,  `email` ,  `timestamp_reg` ,  `points` ,  `rank` , `last_log` ,  `tut` ,  `lang` ,  `ip`";
$tb[]="user_message";			$cl[]="`id` ,  `from` ,  `to` ,  `mtit` ,  `text` ,  `read` ,  `mtype` ,  `aiid`";
$tb[]="user_passrecover";		$cl[]="`usrid`, `hash`, `until`";
$tb[]="user_research";			$cl[]="`id_res`, `usr`, `lev`";
$tb[]="warn";					$cl[]="`id`, `text`";
	
if( isset($DB) ){
	for($i=0;$i!=count($tb);$i++){
		if( $DB->query("SELECT ".$cl[$i]." FROM ".TB_PREFIX.$tb[$i]) ){$tbr[$i]="Ok"; $tbc[$i]="#006600";}else{$tbr[$i]=$lang['adm_broken']; $tbc[$i]="#CC0000";}
	}	


	$body="<b>
		Conf version requided: <span class='Stile3'>".CONFVER."</span><br>
		Actual Conf version: <span class='Stile3'>".conf_ver."</span>
		</b><br><br>
		phpSGE requided db version: <span class='Stile3'>".DBVER."</span><br>
		phpSGE db version: <span class='Stile3'>".DataBaseVersion()."</span><br>
		Database: <span class='Stile1'>".SQL_DB."</span><br><br>
	  <table width='419' border='1' cellspacing='0'>
		<tr bgcolor='#000000'>
		  <th width='121'><b>".$lang['adm_table']."</b></th>
		  <th width='63'><b>".$lang['adm_status']."</b></th>
		</tr>";
		
		for($i=0;$i!=count($tb);$i++){
		  $body.= "<tr><td><b>".$tb[$i]."</b></td>";
		  $body.= "<td bgcolor='".$tbc[$i]."'>".$tbr[$i]."</td></tr>";
		}

	  $body.="</table><p>Numers of tables in the db: <b>".count($tb)."</b></p>";
}
?>