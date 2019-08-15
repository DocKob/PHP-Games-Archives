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

$nom = $_POST['nom'];
$description = trim(htmlentities($_POST['description']));
if( $alliance != 0 )
{
	exut("confrerie","Vous ne pouvez pas cr�er de confr�rie car vous faites d�j� partie d'une confr�rie");
}
if( !filtre($nom,3,15) )
{
	exut("confrerie_creation","Le nom ne peut comporter d'accents et doit faire entre 3 et 15 caract�res");
}
if( empty($description) || strlen($description) > 500 )
{
	exut("confrerie_creation","La description ne doit pas d�passer les 450 caract�res");
}
$sql = "INSERT INTO is_alliance (nom , description , roi) VALUES ('".$nom."' , '".$description."' , '".$pseudo."')";
mysql_query($sql);

$sql = "SELECT * FROM is_alliance WHERE nom ='".$nom."'";
$resultat_alliance = mysql_query($sql);
$t_alliance = mysql_fetch_array($resultat_alliance);

$sql = "INSERT INTO is_f_forum ( titre , description , alliance) VALUES ( '".$nom."' , 'Forum de la Confr&eacute;rie ".$nom."' , '".$t_alliance['id']."')";
mysql_query($sql);

$sql = "UPDATE is_user SET alliance = '".$t_alliance['id']."' WHERE pseudo='".$pseudo."'";
mysql_query($sql);

$_SESSION['alliance'] = $t_alliance['id'];

exut("confrerie","F�licitations, vous venez de cr�er votre propre Confr�rie");
?>