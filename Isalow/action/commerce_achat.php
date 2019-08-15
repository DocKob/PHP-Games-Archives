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
$id = $_GET['id'];

$sql = "SELECT * FROM is_commerce WHERE id='$id'";
$resultat_commerce = mysql_query($sql);
$t_commerce = mysql_fetch_array($resultat_commerce);

if($t_commerce['alliance'] != 0 && $t_commerce['alliance'] != $alliance )
{
	exut("commerce","Cette offre appartient à une autre confrérie, vous ne pouvez pas l'acheter");
}

if( mysql_num_rows($resultat_commerce) == 0 )
{
	exut("commerce","L'offre n'existe pas");
}

$sql = "SELECT * FROM is_user WHERE pseudo = '".$t_commerce['pseudo']."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

$sql = "SELECT * FROM is_user WHERE pseudo = '".$pseudo."'";
$resultat_soi = mysql_query($sql);
$t_soi = mysql_fetch_array($resultat_soi);

$ressource_user = $t_user[ $ressourceTrad[ $t_commerce['ressource'] ] ] - $t_commerce['montant'];
$echange_user = $t_user[ $ressourceTrad[ $t_commerce['echange'] ] ] + ($t_commerce['montant'] * $t_commerce['valeur']);

$ressource_soi = $t_soi[ $ressourceTrad[ $t_commerce['ressource'] ] ] + $t_commerce['montant'];
$echange_soi = $t_soi[ $ressourceTrad[ $t_commerce['echange'] ] ] - ($t_commerce['montant'] * $t_commerce['valeur']);

if( $ressource_user < 0 || $echange_soi < 0 )
{
	exut("commerce","Vous ou l'offreur ne possédez pas assez de ressources");
}

$sql = "UPDATE is_user SET `".$ressourceTrad[ $t_commerce['ressource'] ]."` = '$ressource_user' , `".$ressourceTrad[ $t_commerce['echange'] ]."` = '$echange_user' WHERE pseudo = '".$t_commerce['pseudo']."'";
mysql_query($sql);

$sql = "UPDATE is_user SET `".$ressourceTrad[ $t_commerce['ressource'] ]."` = '$ressource_soi' , `".$ressourceTrad[ $t_commerce['echange'] ]."` = '$echange_soi' WHERE pseudo = '".$pseudo."'";
mysql_query($sql);

$sql = "DELETE FROM is_commerce WHERE id = '".$t_commerce['id']."'";
mysql_query($sql);

exut("commerce","Merci de votre achat");
?>
