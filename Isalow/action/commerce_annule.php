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
require("../functions.php");

db_connexion();

/*********************************************/
$id = $_GET['id'];

$sql = "SELECT * FROM is_commerce WHERE id='".$id."'";
$resultat_commerce = mysql_query($sql);
$t_commerce = mysql_fetch_array($resultat_commerce);

if( mysql_num_rows($resultat_commerce) == 0 )
{
	exut("commerce","L'offre n'existe pas");
}

if( $t_commerce['pseudo'] != $pseudo )
{
	exut("commerce","Ce ne pas votre offre");
}

$sql = "DELETE FROM is_commerce WHERE id = '".$t_commerce['id']."'";
mysql_query($sql);
exut("commerce","Vente effacer!");
?>
