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

/*********************************************/
$sql = "SELECT * FROM is_user WHERE pseudo='".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

$ressources = array(0,1,2,3,4,5,6);

$ressourceTrad = array(
	0 => "isalox",
	1 => "ors",
	2 => "argent",
	3 => "fer",
	4 => "nourriture",
	5 => "clone",
	6 => "electricite"
	);
$montant = $_POST['montant'];
$ressource = $_POST['ressource'];
$valeur = $_POST['valeur'];
$echange = $_POST['echange'];
$confrerie = $_POST['confrerie'];

if(in_array($ressource,$ressources) && in_array($echange,$ressources) && is_numeric($montant) && $t_user[ $ressourceTrad[$ressource] ] >= $montant && $montant > 0)
{
	$constante = $valeur * 2;
	if( !is_numeric($constante) && ( $valeur < 0.5 || $valeur > 100 ) )
	{
		exut("commerce","Le taux doit être compris entre 0.5 et 100");
	}
	if( $confrerie != 0 )
	{
		$confrerie = $alliance;
	}
	$sql = "INSERT INTO is_commerce ( ressource , valeur , echange , montant , alliance ) VALUES ('".$ressource."', '".$valeur."', '".$echange."', '".$montant."', '".$confrerie."')";
	mysql_query($sql);
	
	exut("commerce","Votre vente est désormais disponible dans le commerce");
}
mysql_close();
?>
