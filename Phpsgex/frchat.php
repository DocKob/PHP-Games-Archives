<?php

/* --------------------------------------------------------------------------------------
                                     CHAT SYSTEM
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: Fhizban 07.07.2013
   Comments        : No changes
-------------------------------------------------------------------------------------- */

require_once("config.php");
require_once("include/common.php");
require_once("include/User.php");
session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
if( isset($_GET['v']) ){
	require_once("version.php");
	echo SGEXVER;
}

if( isset($_SESSION['user_id']) && isset($_REQUEST['act']) ){
	if($_REQUEST['act']=="chat_rel"){
		$query= $DB->query("SELECT * FROM `".TB_PREFIX."chat` ORDER BY `id` DESC");	
		while( $lsm= $query->fetch_array() ){
			$usr= new User( $lsm['usrid'] );
			echo "<a href='?pg=profile&usr=".$usr->id."' target='_blank'>".$usr->name."</a> : ".$lsm['msg']."<br>";
		}
	}	
	
	if($_REQUEST['act']=="chat_sendm"){
		$msg= trim( CleanString( $_REQUEST['msg'] ) );
        $user_id= $_SESSION['user_id'];
		$DB->query("INSERT INTO `".TB_PREFIX."chat` (`id` ,`usrid` ,`msg` ,`sent_on`) VALUES (NULL, $user_id, '$msg', CURRENT_TIMESTAMP);");
	}
}

?>