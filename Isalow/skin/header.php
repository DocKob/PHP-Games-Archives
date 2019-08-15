<?php
session_start();
if( !session_is_registered("pseudo") || !session_is_registered("sexe") ||!session_is_registered("race") ||!session_is_registered("portrait") ||!session_is_registered("alliance") )
{
	header("HTTP/1.0 404 Not Found");
	echo("404 Not Found");
	exit;
}
$pseudo = $_SESSION['pseudo']; $sexe = $_SESSION['sexe']; $race = $_SESSION['race']; $portrait = $_SESSION['portrait']; $alliance = $_SESSION['alliance']; $tps = $_SESSION['tps'];

if($sexe == "z") $admin = true;
else             $admin = false;
?>