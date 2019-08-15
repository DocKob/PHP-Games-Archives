<?php
/* --------------------------------------------------------------------------------------
                                      MAIN INDEX PAGE
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: raffa50 26.05.2015
   Comments        : switch city works
-------------------------------------------------------------------------------------- */

if ( !file_exists("config.php") ){
    header ("Location: ./install/index.php");
    exit;
}

require_once("config.php");
require_once("version.php");
require_once("include/common.php");
require_once("include/User.php");
require_once("include/City.php");
require_once("include/Ally.php");
require_once("include/BuildingData.php");
require_once("include/ResearchData.php");
require_once("plugins/plugin.php");

session_start();
$secure= true;
$head=""; $body=""; $blol="";

include("adm/updater/updater.php");
updateDB();

//Plugin::Load();

global $pg;
if( isset($_GET['pg']) ) $pg= $_GET["pg"];

//language options
if( isset($_GET['lang']) ){ include ("./lang/".$_GET['lang'].".php");
	$glang=$_GET['lang'];
	$lkrl="?lang=".$_GET['lang'];
} else { 
	if( isset($_SESSION['lang']) ) include("./lang/".$_SESSION['lang'].".php");
	else include ("./lang/".LANG.".php"); $glang=LANG; 
}

if( isset($_GET['bridge']) && isset($_GET['action']) ){
    $plugins= Plugin::GetLoadedPlugins();
    switch( $_GET['action'] ) {
        case "login":{
            foreach ($plugins as $p) {
                /** @var Plugin $p */
                if ($p->name != $_GET['bridge']) continue;

                try {
                    $p->Content(array("login"));
                } catch (LoginException $e) {
                    $pg = "register";
                }
                break;
            }
        }
    }
}

if( isset( $_REQUEST['auth'] ) ){
    require_once("include/Auth.php");

    switch( $_REQUEST['auth'] ){
        case "login":
            if( !isset($_POST['auth']) ) break;
            $userName= CleanString( $_POST['username'] );
            $pass= CleanString( $_POST['password'] );
            try{
                $user_id = Auth::Login($userName, $pass); //TODO add try catch
                $_SESSION['user_id']= $user_id;
            } catch (LoginException $e){
                $errMsg= $e->getMessage();
            }
            break;


        case "register":
            if( !isset($_POST['auth']) ) break;
            $userName= CleanString($_POST['username']);
            $password= $_POST['password'];
            $email= CleanString($_POST['email']);
            $cityName= CleanString($_POST['cityname']);
            $race= (int)$_POST['race'];
            $language= CleanString($_POST['language']);
            try {
                Auth::Register($userName, $email, $password, $race, $language, $cityName);
            } catch (RegistrationException $e){
                $errMsg= $e->getMessage();
            }
            break;

        case "logout":
            session_destroy();
            session_start();
            break;
    }
}

//request to recover user's password
if( isset($_POST['recoverpass']) && isset($_POST['email']) ){
    require_once("include/Auth.php");
    $mail= CleanString($_POST['email']);
    try {
        Auth::RecoverPassword($mail);
    } catch (Exception $e){
        $errMsg= $e->getMessage();
    }
}

//reset the password
if( isset($_POST['resetpass']) && isset($_POST['newpass']) && isset($_POST['uid']) && isset($_GET['hash']) ){
    require_once("include/Auth.php");
	Auth::ResetPassword( (int)$_POST['uid'], $_POST['newpass'], CleanString($_POST['hash']) );
}

if( isset($_SESSION['user_id']) ) {
	if( !isset($pg) ) $pg="main";

    $user= new LoggedUser($_SESSION['user_id']); /** @var LoggedUser $user */
    $_SESSION['lang']= $user->language;

    if( isset($_REQUEST['changecity']) ){
        try {
            $user->SwitchCity((int)$_REQUEST['changecity']);
        } catch( Exception $e ){
            $errMsg= "Invalid city";
        }
    }

    $currentCity= $user->GetCurrentCity(); /** @var City $currentCity */
    $currentCity->DoResourceProduction();
    $currentCity->FetchAllQueue();

	//Query from other pages

    if( isset( $_REQUEST['ajax'] ) ){
        switch( $_REQUEST['ajax'] ){
            case "getresources":
                require_once("templates/sgex/tmpdc.php");
                Template::print_resources( $currentCity );
                break;
        }
        exit;
    }

	if( isset($_POST['atkcity']) ){
        $attackedCity= City::LoadCity( (int)$_POST['atkcity'] );
		$qrtunt= $DB->query("SELECT * FROM ".TB_PREFIX."t_unt");
		while( $row= $qrtunt->fetch_array() ){
			if( isset( $_POST[ 'tuid'.$row['id'] ] ) ){
				$movunt= (int)$_POST[ 'tuid'.$row['id'] ];
                if( $movunt <= 0 ) continue;
				$qryourunt= $DB->query("SELECT * FROM `".TB_PREFIX."units` WHERE `owner_id`= {$user->id} AND `where`= {$currentCity->id} AND id_unt =".$row['id']);
				if( $qryourunt->num_rows >0 ){
					$ayu= $qryourunt->fetch_array();

                    $myunt= $ayu['uqnt'] -$movunt;
                    if( $myunt < 0 ){
                        $myunt= 0;
                        $movunt= $ayu['uqnt'];
                    }

                    $travelTime= $currentCity->mapPosition->GetDistance( $attackedCity->mapPosition );

					$DB->query("INSERT INTO `".TB_PREFIX."units` (`id`, `id_unt`, `uqnt`, `owner_id`, `from`, `to`, `where`, `time`, `action`)
                    VALUES (NULL, {$row['id']}, $movunt, {$user->id}, {$currentCity->id}, {$attackedCity->id}, NULL, ".( GetTimeStamp() +(int)$travelTime ).", 1);");
					$DB->query("UPDATE `".TB_PREFIX."units` SET `uqnt`= $myunt WHERE `id`= ".$ayu['id']);
				}
			}
		}
	}
	
	if( isset($_POST['colonize']) && isset($_POST['map_x']) && isset($_POST['map_y']) ){
		$x = (int)$_POST['map_x'];
		$y = (int)$_POST['map_y'];
		if( MAP_SYS == 1 ) $z = (int)$_POST['map_z'];
        //else $z = 0;
		/*print_r($_POST);
		echo "$x $y $z<br>";*/

        if( $x < 0 || $x > $config["Map_max_x"] ||
            $y < 0 || $y > $config["Map_max_y"]
            || $z < 0 || $z > $config["Map_max_z"]
        ) $errMsg= "Error, invalid map cordinates $x $y $z";
        else {
            try {
                if (MAP_SYS == 1) City::CreateCity($user->id, new MapCoordinates($x, $y, $z), "new city");
                else City::CreateCity($user->id, new MapCoordinates($x, $y), "new city");
            } catch (Exception $e){
                $errMsg= $e->getMessage();
            }
        }
	}
	
	//---
	//private messages
	if( !isset($_GET['mtp']) ) $usermessage= $DB->query("SELECT * FROM `".TB_PREFIX."user_message` WHERE `to` =".$user->id);
	else $usermessage= $DB->query("SELECT * FROM `".TB_PREFIX."user_message` WHERE `to` =".$user->id. " AND mtype =".(int)$_GET['mtp']);
	
	$msgunreaded= $DB->query("SELECT * FROM `".TB_PREFIX."user_message` WHERE `to` =".$user->id." AND `read` =0");
	$nummsg= $msgunreaded->num_rows;

    //$_SESSION['user']= serialize( $user );
}

if( file_exists("templates/".$config['template']."/tmpdc.php") ) require_once("templates/".$config['template']."/tmpdc.php"); //include template definition for style used by corepages
else require_once("templates/sgex/tmpdc.php");

if( $pg == "dbcheck" ){
	include("adm/dbcheck.php");
	include("templates/".$config['template']."/body.php");
} else {
	if( !isset($user) and $pg!="register" and $pg!="credits" ) $pg= "index";
	if( isset($user) and isset($pg) and $pg!="index" ){ //logged in
		if( $user->IsBanned() ){
			session_destroy();
			session_start();
			header("Location: index.php?msg=You%20where%20banned!");
			exit;	
		}

        if( file_exists("core-pages/$pg.php") ) require_once("core-pages/$pg.php");
        else if( $pg == 'map2' ) require_once("templates/".$config['template']."/map2.php");
        else require_once("templates/{$config['template']}/main.php");

		/*$pgbd=""; //plugin TODO
		include("plugins/tut.php");
		$body= $pgbd . $body;*/

		require_once("templates/{$config['template']}/body.php");
	} else {
		$tuq= $DB->query("SELECT username FROM ".TB_PREFIX."users ORDER BY `id` DESC");
		$tusr= $tuq->num_rows;
		if( $tusr > 0 ) $lastreg= $tuq->fetch_array();
        else $lastreg['username']= "none";

		if( $pg != "index" ){
			if( $pg != "credits" ) require_once("templates/{$config['template']}/$pg.php");
			else require_once("core-pages/credits.php");
		}
		
		if( isset($_GET['msg']) ) $errMsg= $_GET['msg'];
        if( isset($errMsg) ) $blol = "onload=\"javascript:alert('$errMsg');\"";
		if( !isset($_SESSION['user_id']) ) require_once("templates/{$config['template']}/index.php");
	}
}
?>