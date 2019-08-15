<?php
require_once("../version.php");
require_once("Installer.php");

if( isset($_GET['lang']) ) $lng= $_GET['lang'];
else $lng= "en";
require_once("../lang/$lng.php");

if ( file_exists("../config.php") ) header ("Location: ../index.php");
else {
	$secure= true;
	$body="";
	$step="";
	session_start();
	
	if( isset($_GET['lang']) ) $_SESSION['lang']= $_GET['lang'];
	else if( !isset($_REQUEST['step']) ) $_SESSION['lang']="en";
	
	if( isset($_REQUEST['step']) ){
		$step= $_REQUEST['step'];
	
		switch($step){
			case "mysqldone":
				if( !isset($_POST['mhost']) ) die("host not set!");
                $_SESSION['install']= serialize( new Installer( $_POST['mhost'], $_POST['muser'], $_POST['mpass'], $_POST['mdb'], $_POST['table_prefix'] ) );
            break;
		}
	}
	
	if( strlen($step) <= 1 ){
		if (!defined('PHP_VERSION_ID')) {
			$version = explode('.', PHP_VERSION);
			define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
		}

		$body.= $lang['ins_installintro']."	
		<br><div class='box' style='width: 100% !important;'>";
		
		include("../core-pages/credits.php");
		
		$caninstall = true;
		$body.="</div><br>
		<h3><br>PHP version: ".phpversion();
		if( PHP_VERSION_ID >= 50200 ) $body.="&nbsp; OK";
		else {
			$caninstall = false;
			$body.="&nbsp; <span class='Stile3'>Not Supported! Update PHP (to: >= 5.2.0)!</span>";
		}

		if( function_exists('mysqli_connect') ) $body.="<h3>MySqlI Installed!</h3>";
		else {
			$caninstall = false;
			$body.="<span class='Stile3'>Not Supported! MySqlI not installed!</h3>";
		}
		
		 $dir = '../lang';
		 $handle = opendir($dir);
		 $optlangs="";
		 while( $files= readdir($handle) ) {
			if( $files != '.' && $files != '..' && $files != 'index.php' ) {
				$optlangs.= '<option ';
				if( $lng == substr($files,0,-4) ) $optlangs.='selected';
				$optlangs.= '>'.substr($files,0,-4).'</option>';
			}
		 }

		$body.="</h3><br>
		<p>Language / ßçûê 
		<form method='get' action=''>
			<select name='lang' id='lang' onChange='this.form.submit();'>
				$optlangs      
			</select>
		</form></p> <form method='post' action='?step=mysqldone'> <p>&nbsp;</p>";

		$pg= "Mysql Configuration";
		$body.= "<table border='1'> <tr><td>Mysql Host:</td><td><input type='text' name='mhost' placeholder='localhost' required></td></tr>
			<tr><td>Mysql User:</td><td><input type='text' name='muser' placeholder='root' required></td></tr>
			<tr><td>Mysql Pass:</td><td><input type='text' name='mpass'></td></tr>
			<tr><td>Mysql Database:</td><td><input type='text' name='mdb' placeholder='SGEdb' required>
			<tr><td>Table Prefix:</td><td><input type='text' name='table_prefix'>
			<tr><td colspan='2'>";
			
			if( $caninstall )
				$body.= "<input type='submit' value='".$lang['ins_next']."'>";
			else
				$body.="<span class='Stile3'>Can't Install PhpSgeX</span>";
				
			$body.="</td></tr>
			</table></form>";	
	} else if( $step=="mysqldone" ){
		$pg= "Game Configuration";
		$body.="<form method='post' action='do.php'><table border='0'>
		<tr> <td>Game Name</td> <td><input type='text' name='gname' required placeholder='my sge game'></td> </tr>
		<tr> <td>Game Short Desc</td> <td><input type='text' name='gdesc'></td> </tr>
		<tr> <td>Game Main Desc</td> <td><input type='text' name='mandesc'></td> </tr>
		
		<tr> <td>Template</td> <td><select name='templ'>";
		
		$dir= '../templates';
        $handle= opendir($dir);
        while( $files= readdir($handle) ) {
            if ($files != '.' && $files != '..' && $files != 'js' && $files != 'index.php' && !strpos($files, ".") ){  
				$body.= '<option>'.$files.'</option>';
            }
        }
		
		$body.="</select></td> </tr>
		<tr> <td>Map Sys</td> <td><select name='mnu_map'> <option value='1'>Map Sys 1 / Ogame</option>
			<option value='2'>Map Sys 2 / Travian</option> </select></td> </tr>
		<tr> <td>City sys</td> <td><select name='cts'> <option value='1'>City Sys 1 / Ogame</option>
														<option value='2'>City Sys 2 / Travian (BETA)</select>
		</td> </tr>
		
		<tr> <td colspan='2'>";
		
		$body.="<input type='submit' name='inst' value='Install!'> (By pressing next you will acept PhpSgeX license)";
			
		$body.="</td> </tr>
		</table></form>";	
	}
	
	include("../templates/sgex/install.php");
}
?>