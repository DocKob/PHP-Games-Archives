<?php
if ( !file_exists("../config.php") ) header ("Location: ../index.php");

session_start();
if( !isset($_SESSION['user_id']) ) header("Location: ../index.php");

require_once("../config.php");
require_once("../version.php");
require_once("../include/common.php");
require_once("../include/User.php");

if( isset($_GET['lang']) ){ include ("../lang/".$_GET['lang'].".php");
	$glang=$_GET['lang'];
	$lkrl="?lang=".$_GET['lang'];
} else { include ("../lang/".LANG.".php"); $glang=LANG; }

$user= new LoggedUser($_SESSION['user_id']); /** @var User $user */
if( $user->rank >1 ){
	if( isset($_GET['pg']) ) $pg= $_GET['pg'];
	else $pg= "main";
	
	$body="";
	$head="";
	$bol="";
	$secure= true;
	
	//query
	if( isset($_POST['clean_chat']) ) $DB->query("TRUNCATE chat");
	//races
	if( isset($_POST['addrace']) ){
		$rnam= CleanString($_POST['rname']);
		$rdesc= CleanString($_POST['rdesc']);
		$img= CleanString($_POST['img']);
		$DB->query("INSERT INTO `".TB_PREFIX."races` (`id`, `rname`, `rdesc`, `img`) VALUES (NULL, '$rnam', '$rdesc', '$img');");
	}
	
	if( isset($_GET['delrac']) ) $DB->query("DELETE FROM `".TB_PREFIX."races` WHERE `id` =".(int)$_GET['delrac']);
	
	if( isset($_POST['editrac']) ){
		$rnam= CleanString($_POST['rname']);
		$rdesc= CleanString($_POST['rdesc']);
		$img= CleanString($_POST['img']);
		$DB->query("UPDATE `".TB_PREFIX."races` SET `rname` = '$rnam', `rdesc` = '$rdesc', `img` = '$img' WHERE `id` =".(int)$_POST['editrac']);
	}
	//resources
	if( isset($_POST['addresource']) ){
		$name= CleanString($_POST['name']);
		$prodrate= (int)$_POST['prodrate'];
		$start= (int)$_POST['start'];
		$img= CleanString($_POST['ico']);
		$DB->query("INSERT INTO `".TB_PREFIX."resdata` (`id` ,`name` ,`prod_rate` ,`start` ,`ico`) VALUES (NULL ,  '$name',  '$prodrate',  '$start',  '$img');");
	}
	
	if( isset($_GET['delresource']) ) $DB->query("DELETE FROM `".TB_PREFIX."resdata` WHERE `id` =".(int)$_GET['delresource']);
	
	if( isset($_POST['editresource']) ){
		$name= CleanString($_POST['name']);
		$prodrate= (int)$_POST['prodrate'];
		$start= (int)$_POST['start'];
		$img= CleanString($_POST['ico']);
		$DB->query("UPDATE `resdata` SET `name` = '$name', `prod_rate` = '$prodrate', `start` = '$start', `ico` = '$img' WHERE `id` =".(int)$_POST['editresource']);	
	}
	//units
	if( isset($_GET['delunt']) ){
		$DB->query("DELETE FROM `".TB_PREFIX."t_unt` WHERE `id` =".(int)$_GET['delunt']);
		//$DB->query("DELETE FROM `t_unt_resourcecost` WHERE `unit` =".(int)$_GET['delunt']);
	}
	
	if( isset($_POST['editunt']) ){
		$id= (int)$_POST['editunt'];
		$name= CleanString($_POST['name']);
		$race= (int)$_POST['race']; if( $race == 0 ) $race="null";
		$img= CleanString($_POST['img']);
		$health= (int)$_POST['health'];
		$atk= (int)$_POST['atk'];
		$dif= (int)$_POST['dif'];
		$vel= (int)$_POST['vel'];
		$time= (int)$_POST['time'];
		$desc= CleanString($_POST['desc']);
        $cargo = (int)$_POST['cargo'];
		$DB->query("UPDATE `".TB_PREFIX."t_unt` SET `name` = '$name', `race` = $race, `img` = '$img', `health` = $health, `atk` = $atk, `dif` = $dif, `vel` = $vel, res_car_cap = $cargo, `etime` = $time, `desc` = '$desc' WHERE `id` =$id;");
		
		//edit resource cost
		$qr= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
		while( $row= $qr->fetch_array() ){
			$cost= (int)$_POST["res".$row['id']];
			if( $cost!=0 ) $DB->query("REPLACE INTO `".TB_PREFIX."t_unt_resourcecost` (`unit`, `resource`, `cost`) VALUES
($id, ".$row['id'].", $cost);");	
			else $DB->query("DELETE FROM `".TB_PREFIX."t_unt_resourcecost` WHERE `unit` = $id AND `resource` = ".$row['id']." LIMIT 1;");
		}
		
		//edit requisites (bud)
		for( $i=1; isset($_POST['reqbud'.$i]); $i++ ) {
			$rb= (int)$_POST['reqbud'.$i];
			$rl= (int)$_POST['levbud'.$i];
			if( $rl >0 ) $DB->query("REPLACE INTO `".TB_PREFIX."t_unt_reqbuild` (`unit`, `reqbuild`, `lev`) VALUES ($id, $rb, $rl);");
			else $DB->query("DELETE FROM `".TB_PREFIX."t_unt_reqbuild` WHERE `unit` =$id AND `reqbuild` =$rb LIMIT 1;");
		}
		
		//edit requisites (reserch)
		for( $i=1; isset($_POST['reqresearch'.$i]); $i++ ) {
			$rb= (int)$_POST['reqresearch'.$i];
			$rl= (int)$_POST['levresearch'.$i];
			if( $rl >0 ) $DB->query("REPLACE INTO `".TB_PREFIX."t_unt_req_research` (`unit`, `reqresearch`, `lev`) VALUES ($id, $rb, $rl);");
			else $DB->query("DELETE FROM `".TB_PREFIX."t_unt_req_research` WHERE `unit` =$id AND `reqresearch` =$rb LIMIT 1;");
		}
	}
	
	if( isset($_POST['addunt']) ){
		$aid= $DB->query("SELECT * FROM `".TB_PREFIX."t_unt` ORDER BY `id` DESC LIMIT 1")->fetch_array();
		if( $aid=="" ) $id =0;
		else $id =(int)$aid['id']+1;
		
		$name= CleanString($_POST['name']);
		$race= (int)$_POST['race']; if( $race == 0 ) $race="null";
		$img= CleanString($_POST['img']);
		$health= (int)$_POST['health'];
		$atk= (int)$_POST['atk'];
		$dif= (int)$_POST['dif'];
		$vel= (int)$_POST['vel'];
		$time= (int)$_POST['time'];
        $cargo = (int)$_POST['cargo'];
		$desc= CleanString($_POST['desc']);
		$DB->query("INSERT INTO `".TB_PREFIX."t_unt` (`id`, `name`, `race`, `img`, `health`, `atk`, `dif`, `vel`, `res_car_cap`, `etime`, `desc`, `type`) VALUES ($id, '$name', $race, '$img', $health, $atk, $dif, $vel, $cargo, $time, '$desc', NULL);");
		
		//add resource cost
		$qr= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
		while( $row= $qr->fetch_array() ){
			$cost= (int)$_POST["res".$row['id']];
			if( $cost!=0 ) $DB->query("INSERT INTO `".TB_PREFIX."t_unt_resourcecost` (`unit`, `resource`, `cost`) VALUES ($id, ".$row['id'].", $cost);");
		}
	}
	//buildings
	if( isset($_GET['delbuild']) ){ //delete building
		$DB->query("DELETE FROM `".TB_PREFIX."t_builds` WHERE `id` =".(int)$_GET['delbuild']);
		//$DB->query("DELETE FROM `t_build_resourcecost` WHERE `build` =".(int)$_GET['delbuild']);	
	}
	
	if( isset($_POST['editbuild']) ){
		$id= (int)$_POST['editbuild'];
		$name= CleanString($_POST['name']);
		$func= CleanString($_POST['budfunc']);
		$race= (int)$_POST['race']; if( $race == 0 ) $race="null";
		$prod= (int)$_POST['prod'];
		$img= CleanString($_POST['img']);
		$time= (int)$_POST['time'];
		$timempl= (float)$_POST['timempl'];
		$maxlev= (int)$_POST['maxlev'];
		
		$DB->query("UPDATE `".TB_PREFIX."t_builds` SET `name` = '$name', `func` = '$func', `arac` = $race, `produceres` = '$prod', `img` = '$img', `time` = '$time', `time_mpl` = '$timempl', `maxlev` = $maxlev WHERE `id` =".$id);
		
		//edit resource cost
		$qr= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
		while( $row= $qr->fetch_array() ){
			$cost= (int)$_POST["res".$row['id']];
			$mpl= (float)$_POST['rmpl'.$row['id']];
			if( $cost!=0 ) $DB->query("REPLACE INTO `".TB_PREFIX."t_build_resourcecost` (`build`, `resource`, `cost`, `moltiplier`) VALUES ($id, ".$row['id'].", $cost, $mpl);");
			else $DB->query("DELETE FROM `".TB_PREFIX."t_build_resourcecost` WHERE `build` = $id AND `resource` = ".$row['id']." LIMIT 1;");
		}	
	
		//edit requisites (buildings)
		$reqbud= $_POST['reqbud'];
		$levbud= $_POST['levbud'];
		for( $i=0; $i < count($reqbud); $i++ ) {
			$rb= (int)$reqbud[$i];
			$rl= (int)$levbud[$i];
			
			if( $rb == 0 ) continue;
			if( $rl!=0 ) $DB->query("REPLACE INTO `".TB_PREFIX."t_build_reqbuild` (`build`, `reqbuild`, `lev`) VALUES ($id, $rb, $rl);");
			else $DB->query("DELETE FROM `".TB_PREFIX."t_build_reqbuild` WHERE `build`= $id AND `reqbuild`= $rb");
		}
		
		//edit requisites (research)
		$reqresearch= $_POST['reqresearch'];
		$levresearch= $_POST['levresearch'];
		for( $i=0; $i < count($reqresearch); $i++ ) {
			$rb= (int)$reqresearch[$i];
			$rl= (int)$levresearch[$i];
			
			if( $rb == 0 ) continue;
			if( $rl >0 ) $DB->query("REPLACE INTO `".TB_PREFIX."t_build_req_research` (`build`, `reqresearch`, `lev`) VALUES ($id, $rb, $rl);");
			else $DB->query("DELETE FROM `".TB_PREFIX."t_build_req_research` WHERE `build` =$id AND `reqresearch` =$rb");
		}
	}
	
	if( isset($_POST['addbuild']) ) {
		$aid= $DB->query("SELECT * FROM `".TB_PREFIX."t_builds` ORDER BY `id` DESC LIMIT 1")->fetch_array();
		if( $aid=="" ) $id =0;
		else $id =(int)$aid['id']+1;
		
		$name= CleanString($_POST['name']);
		$race= (int)$_POST['race']; if( $race == 0 ) $race="null";
		$prod= (int)$_POST['prod']; if( $prod == 0 ) $prod="null";
		$img= CleanString($_POST['img']);
		$budfunc= CleanString($_POST['budfunc']); if( $budfunc == "none" ) $budfunc="null"; else $budfunc= "'".$budfunc."'";
		$time= (int)$_POST['time'];
		$timempl= (float)$_POST['timempl'];
		$maxlev= (int)$_POST['maxlev'];
		
		$DB->query("INSERT INTO `".TB_PREFIX."t_builds` (`id`, `arac`, `name`, `func`, `produceres`, `img`, `desc`, `time`, `time_mpl`, `gpoints`, `maxlev`) VALUES ($id, $race, '$name', $budfunc, $prod, '$img', NULL, $time, $timempl, 15, $maxlev);");
		
		//add resource cost
		$qr= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
		while( $row= $qr->fetch_array() ){
			$cost= (int)$_POST["res".$row['id']];
			$mpl= (float)$_POST['rmpl'.$row['id']];
			if( $cost!=0 ) $DB->query("INSERT INTO `".TB_PREFIX."t_build_resourcecost` (`build`, `resource`, `cost`, `moltiplier`) VALUES ('$id', '".$row['id']."', '$cost', '$mpl');");
		}
	}

	//research
	if( isset($_GET['delresearch']) ) $DB->query("DELETE FROM `".TB_PREFIX."t_research` WHERE id=".(int)$_GET['delresearch']);
	if( isset($_POST['addresearch']) ){
		$aid= $DB->query("SELECT * FROM `".TB_PREFIX."t_research` ORDER BY `id` DESC LIMIT 1")->fetch_array();
		if( $aid=="" ) $id =0;
		else $id =(int)$aid['id']+1;
		
		$name= CleanString($_POST['name']);
		$img= CleanString($_POST['img']);
		$race= (int)$_POST['race']; if( $race == 0 ) $race="null";
		$time= (int)$_POST['time'];
		$timempl= (float)$_POST['timempl'];
		$maxlev= (int)$_POST['maxlev'];
		
		$DB->query("INSERT INTO `".TB_PREFIX."t_research` (`id`, `name`, `desc`, `arac`, `img`, `time`, `time_mpl`, `gpoints`, `maxlev`) VALUES ($id, '$name', NULL, $race, '$img', $time, $timempl, 0, $maxlev);");
		
		//add resource cost
		$qr= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
		while( $row= $qr->fetch_array() ){
			$cost= (int)$_POST["res".$row['id']];
			$mpl= (float)$_POST['rmpl'.$row['id']];
			if( $cost!=0 ) $DB->query("INSERT INTO `".TB_PREFIX."t_research_resourcecost` (`research`, `resource`, `cost`, `moltiplier`) VALUES ($id, ".$row['id'].", $cost, $mpl);");
			else $DB->query("DELETE FROM `".TB_PREFIX."t_research_resourcecost` WHERE `research`= $id AND `resource`= ".$row['id']." LIMIT 1;");
		}
	}
	if( isset($_POST['editresearch']) ){
		$id= (int)$_POST['editresearch'];
		$name= CleanString($_POST['name']);
		$race= (int)$_POST['race']; if( $race == 0 ) $race="null";
		$img= CleanString($_POST['img']);
		$time= (int)$_POST['time'];
		$timempl= (float)$_POST['timempl'];
		$maxlev= (int)$_POST['maxlev'];
		
		$DB->query("UPDATE `".TB_PREFIX."t_research` SET `name`= '$name', `arac`= $race, `img`= '$img', `time`= '$time', `time_mpl`= '$timempl', `maxlev` = $maxlev WHERE `id` =".$id);
		
		//edit resource cost
		$qr= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
		while( $row= $qr->fetch_array() ){
			$cost= (int)$_POST["res".$row['id']];
			$mpl= (float)$_POST['rmpl'.$row['id']];
			if( $cost!=0 ) $DB->query("REPLACE INTO `".TB_PREFIX."t_research_resourcecost` (`research`, `resource`, `cost`, `moltiplier`) VALUES ($id, ".$row['id'].", $cost, $mpl);");
			else $DB->query("DELETE FROM `".TB_PREFIX."t_research_resourcecost` WHERE `research`= $id AND `resource` = ".$row['id']." LIMIT 1;");
		}
		
		//edit requisites (buildings)
		$reqbud= $_POST['reqbud'];
		$reqbudlev= $_POST['levbud'];
		for( $i=0; $i < count($reqbud); $i++ ) {
			$rb= (int)$reqbud[$i];
			$rl= (int)$reqbudlev[$i];
			
			if( $rb == 0 ) continue;
			if( $rl!=0 ) $DB->query("REPLACE INTO `".TB_PREFIX."t_research_reqbuild` (`research`, `reqbuild`, `lev`) VALUES ($id, $rb, $rl);");
			else $DB->query("DELETE FROM `".TB_PREFIX."t_research_reqbuild` WHERE `research`= $id AND `reqbuild`= $rb");
		}	
		
		//edit requisites (reserch)
		$reqres= $_POST['reqresearch'];
		$reqreslev= $_POST['levresearch'];
		for( $i=0; $i < count($reqres); $i++ ) {
			$rb= (int)$reqres[$i];
			$rl= (int)$reqreslev[$i];
			
			if( $rb == 0 ) continue;
			if( $rl >0 ) $DB->query("REPLACE INTO `".TB_PREFIX."t_research_req_research` (`research`, `reqresearch`, `lev`) VALUES ($id, $rb, $rl);");
			else $DB->query("DELETE FROM `".TB_PREFIX."t_research_req_research` WHERE `research`= $id AND `reqresearch`= $rb LIMIT 1;");
		}	
	}
	
	//delete research
	if( isset( $_GET['deleteresearch'] ) ){
		$DB->query("delete from ".TB_PREFIX."t_research where id= ".(int)$_GET['deleteresearch']);
	}
	
	//moderator
	if( isset($_POST['editct']) ){
		$DB->query("UPDATE `".TB_PREFIX."city` SET `name`= '".$_POST['name']."' WHERE `id`= ".(int)$_POST['editct']);
		
		$resnam= GetResourcesNames();
		for( $i=1; $i <= count($resnam); $i++ ) $DB->query("UPDATE `".TB_PREFIX."city_resources` SET `res_quantity` = '".(int)$_POST['res'.$i]."' WHERE `city_id` =".(int)$_POST['editct']." AND `res_id` =".$i);
	}
	
	if( isset($_GET['ban']) ){
		$DB->query("INSERT INTO `".TB_PREFIX."banlist` VALUES ('".(int)$_GET['ban']."', '".( GetTimeStamp() + $_POST['bantime'] *86400 )."', '');");
	}
	
	if( isset($_GET['pardon']) ){
		$DB->query("DELETE FROM ".TB_PREFIX."banlist WHERE usrid =".(int)$_GET['pardon']);
	}
	
	//edit user
	if( isset($_POST['editusr']) ){
		$DB->query("UPDATE `".TB_PREFIX."users` SET `email` = '".$_POST['email']."', `points` = '".(int)$_POST['points']."', `rank` = '".(int)$_POST['rank']."' WHERE `id` =".(int)$_POST['editusr']);
	}
	
	if( isset($_POST['sendmailtoall']) ){
        $msg= ParseBBCodes($_POST['msg'], $user);

		$qr= $DB->query("SELECT `email` FROM `".TB_PREFIX."users`");
		while( $row= $qr->fetch_array() ){
			mail( $row['email'], $_POST['tittle'], $msg );
		}
	}
	//---
	
	require($pg.".php");
	include("../templates/sgex/admcp.php");
}
//else header("Location: ../index.php");
?>