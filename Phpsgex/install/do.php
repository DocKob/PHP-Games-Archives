<?php
session_start();
require_once("Installer.php");

if( isset($_SESSION['install']) ){
    $installer= unserialize($_SESSION['install']); /** @var $installer Installer */
	$installer->MakeConfigFile($_SESSION['lang'], (int)$_POST['mnu_map'], (int)$_POST['cts']);

    try {
        $installer->InstallDataBase($_POST['gname'], $_POST['gdesc'], $_POST['mandesc'], $_POST['templ'], (int)$_POST['mnu_map'], (int)$_POST['cts']);
    } catch(Exception $ex){
        move_uploaded_file("../config.php", "../config.err.php");
        throw $ex;
        exit;
    }

    //add your game to phpSGE official list - 	DO NOT REMOVE OR YOUR PHPSGE WILL BE LOCKED!
    if( $_SERVER["HTTP_HOST"] != "localhost" ){
        require_once("../include/Snoopy.php");
        require_once("../version.php");
        $snoopy= new Snoopy();
        $submit_url= "http://rpvg.altervista.org/phpsge/sgexregister.php";
        $submit_vars["game_name"]= $_POST['gname'];
        $submit_vars["host"]= $_SERVER["HTTP_HOST"];
        $submit_vars["path"]= $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];
        $submit_vars["version"]= SGEXVER;
        $snoopy->submit($submit_url,$submit_vars);
    }

    session_destroy();
    header("Refresh: 11; URL=../index.php");
    echo "<html>
	<header><title>PhpSgeX Installation Complete!</title></header>
	<body>
	<b>Installation complete! Redirecting...<br><u>PLEASE WAIT BECAUSE MYSQL IS RUNNING DB INSTALLATION AND IT CAN TAKE SOME TIME TO FINISH <br>IF YOU GET ERRORS AFTER REDIRECTION PLEASE REFRESH LATER</u><b>
	</body></html>";
	
} else echo "<b>Warning! Something went wrong! Turn back and retry!</b>";
?>