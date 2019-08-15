<?php
//paramettres de session//
session_start();
if( !session_is_registered("pseudo") || !session_is_registered("sexe") ||!session_is_registered("race") ||!session_is_registered("portrait") ||!session_is_registered("alliance") )
{
	exit();
}
$pseudo = $_SESSION['pseudo'];
$sexe = $_SESSION['sexe'];
$race = $_SESSION['race'];
$portrait = $_SESSION['portrait'];
$alliance = $_SESSION['alliance'];
$tps = $_SESSION['tps'];
if($sexe == "z")
{
	$admin = true;
}
else
{
	$admin = false;
}
//importations
require("../race/".$race.".php");
require("../functions.php");

db_connexion();

$motivation = $_POST['motivation'];
$roi = $_POST['roi'];

$motivation = trim( htmlentities($motivation) );

if(!empty($motivation) )
{
	$message = "Demande d'adh&eacute;sion &agrave; la confr&eacute;rie\n".$motivation;
	sms($pseudo,$roi,$motivation);
	
	exut("confrerie","Votre message de motivation vient d'être envoyé");
}

exut("confrerie","Une erreure s'est produite");
?>