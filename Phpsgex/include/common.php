<?php
/* --------------------------------------------------------------------------------------
                                      COMMON FUNCTIONS
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: Raffa50 09.04.2014
   Comments        : improved GetAllyPoints
-------------------------------------------------------------------------------------- */

date_default_timezone_set ('UTC');
$DB = new mysqli( SQL_SERVER, SQL_USER, SQL_PASS, SQL_DB );
if( $DB->connect_error ) die('Mysql Connection Error ('.$DB->connect_errno.') '.$DB->connect_error);

//load (once) game config from database
$config= $DB->query("SELECT * FROM ".TB_PREFIX."conf LIMIT 1");
if( $config->num_rows == 0 ){
	echo "<h3>Your installation is corrupt! Please reinstall again or contact support</h3>";
	exit;
}
$config= $config->fetch_array();

function CleanString($str){
	global $DB;
	$r= $DB->escape_string( trim($str) );
	return ( strlen($r) ==0 ) ? null : $r;
}

function CleanArray( Array $array ){
    foreach( $array as $key => $value ){
        $array[$key]= CleanString($value);
    }
}

function sqlc_str($cv){
	if( $cv == null ) return "null";
	return "'$cv'";	
}

function GetTimeStamp(){  //time stamp now
	//data oggi
	$dt=date("j");
	$mt=date("n");
	$yt=date("y");
	//ore oggi
	$timenow=getdate();
	$hn=substr("0" . $timenow["hours"], -2);
	$mih=substr("0" . $timenow["minutes"], -2);
	$sn=substr("0" . $timenow["seconds"], -2);
	$mtimet=mktime($hn,$mih,$sn,$mt,$dt,$yt); //data e ora oggi pronto per le operazioni e per il db!

	return $mtimet;
}

function SecondsToTimeString($sec){
	$s = $sec % 60;
	$m = $sec / 60;
	$h = $m / 60;
	$m = $m % 60;
	
	$r = (int)$h."h ".(int)$m."m ".(int)$s."s ";
	return $r;	
}

function GetResourcesNames(){
	global $DB;
	$qr= $DB->query("SELECT `name` FROM `".TB_PREFIX."resdata`");	
	$i=1;
	while( $row= $qr->fetch_array() ){
		$res[$i] = $row["name"];
		$i++;
	}
	return $res;
}

function ParseBBCodes($_body, User $sender= null, User $receiver= null){
    global $config;

    if( $sender != null ){
		$_body= preg_replace( '/\[my_name\]/', CleanString("<a href='?pg=profile&usr=".$sender->id."'>".$sender->name."</a>"), $_body );
        if( $sender->allyId != null ) {
            $ally = new Ally($sender->allyId);
            $_body = preg_replace('/\[ally_name\]/', CleanString("<a href='?pg=ally&showally=" . $ally->id . "'>" . $ally->name . "</a>"), $_body);
        }
    }
    if( $receiver != null ){
        $_body= preg_replace( '/\[your_name\]/', CleanString("<a href='?pg=profile&usr=".$receiver->id."'>".$receiver->name."</a>"), $_body );
    }
	$_body= preg_replace( '/\[game_name\]/', $config['server_name'], $_body );

    return $_body;
}

function SendMessage( User $from= null, $_to, $_tittle, $_body, $_messageType= 1, Ally $allyInvite= null ){
    global $DB;

    if( $_messageType==1 || $_messageType==3 ){
        if( $from == null ) throw new Exception("$from is null!");
        $fromid= $from->id;
    } else $fromid= "NULL";

    if( $_messageType == 3 ){
        if($allyInvite == null) throw new Exception("Message is an ally invite but ally is null");
        $allyId= $allyInvite->id;
    } else $allyId= "NULL";

    $receiver= new User($_to);
    $_body= ParseBBCodes($_body, $from, $receiver);

    $DB->query("INSERT INTO `".TB_PREFIX."user_message` (`id` ,`from` ,`to` ,`mtit` ,`text` ,`read` ,`mtype` ,`aiid`) VALUES (NULL, $fromid, $_to, '$_tittle', '$_body', 0, $_messageType, $allyId);");
}

function ClassToJson( $class ){
    return json_encode( get_object_vars( $class ) );
}

// -------------------------------- GET_RESOURCE_ICONS -------------------------------- //
function GetResourceIcons(){
	global $DB;
	$qr= $DB->query("SELECT `ico` FROM `".TB_PREFIX."resdata`");	
	$i=1;
	while( $row = $qr->fetch_array() ){
		$res[$i] = $row["ico"];
		$i++;
	}
	return $res;
}

//return PhpSgeX DB version (useful for update the db!)
function DataBaseVersion() {
	global $DB;
	$svqr= $DB->query("SELECT sge_ver FROM ".TB_PREFIX."conf");
	$vvc= $svqr->fetch_array();
	return $vvc['sge_ver'];
}

function bud_func(){ //show buildings func
	$bf= array( "none", "barraks", "reslab", "buildfaster" );
	
	global $config;
	
	if( $config["MG_max_cap"] > 0 ) $bf[]="mag_e";
	if( $config['popres'] != null ) $bf[]="pop_e";
	return $bf;
}

function units_type(){
    return array( "none", "spy" );
}
?>