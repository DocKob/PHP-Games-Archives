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
$sexes = array("m","f");

if( !isset($_POST['password']) )
{
	exut("preferences","Vous devez mettre un password");
}

$sql = "SELECT password FROM is_user WHERE pseudo='$pseudo'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

if( $t_user['password'] != md5($_POST['password']) )
{
	exut("preferences","Votre mot de passe n'est pas bon");
}

$sql = "UPDATE is_user SET ";

if( isset($_POST['password1']) && isset($_POST['password2'])  && !empty($_POST['password1'])  && !empty($_POST['password2']) )
{
	if( $_POST['password1'] == $_POST['password2'] )
	{
		$sql .= "password = MD5('$_POST[password1]') , ";
	}
	else
	{
		exut("preferences","Le nouveau mot de passe et le mot de passe de confirmation ne sont pas égaux");
	}
}
$portrait = $_FILES['portrait'];
if( isset($_FILES['portrait']) && $portrait['error'] != 4 )
{
	$max_size = 8192;
	
	if( $portrait['error'] != 0 )
	{
		exut("preferences","Le type n'est pas reconnu par le serveur.");
	}
	if( $portrait['size'] > $max_size )
	{
		exut("preferences","Le fichier ne peut êtres supérieur à $max_size bytes");
	}
	if( !strrpos($portrait['type'],"gif") &&  !strrpos($portrait['type'],"jpg") && !strrpos($portrait['type'],"jpeg") && !strrpos($portrait['type'],"png"))
	{
		exut("preferences","Cela doit être .gif ou .jpg ou .jpeg ou .png");
	}
	$size = getimagesize($portrait['tmp_name']);
	
	if( $size[0] != 90 && $size[1] != 90 )
	{
		exut("preferences","la taille de l'image doit faire 90*90");
	}
	$posPoint = strrpos($portrait['name'],".");
	$extension = substr($portrait['name'],$posPoint);
	if( file_exists("../images/avatar/".$pseudo.$extension) )
	{
		unlink("../images/avatar/".$pseudo.$extension);
	}
	if( !move_uploaded_file($portrait['tmp_name'], "../images/avatar/".$pseudo.$extension) )
	{
		exut("preferences","Le fichier n'a pas pu être copié");
	}
	$sql .= "portrait = 'images/avatar/$pseudo$extension' , ";
	$_SESSION['portrait'] = "images/avatar/$pseudo$extension";
}
if( isset($_POST['age']) && !empty($_POST['age']) && is_numeric($_POST['age']) )
{
	$sql .= "age = '$_POST[age]' , ";
}
if( isset($_POST['profil']) && !empty($_POST['profil']) )
{
	$sql .= "profil = '".trim(htmlentities($_POST['profil']))."' , ";
}
if( isset($_POST['signature']) && !empty($_POST['signature']) )
{
	$sql .= "signature = '".trim(htmlentities($_POST['signature']))."' , ";
}
if( isset($_POST['email'])  && !empty($_POST['email']) && filtremail($_POST['email']) )
{
	$sql .= "email = '$_POST[email]' , ";
}
if( isset($_POST['sexe']) && in_array($_POST['sexe'],$sexes))
{
	if( $admin )
	{
		$sql .= "sexe = 'z' ";
	}
	else
	{
		$sql .= "sexe = '$_POST[sexe]' ";
		$_SESSION['sexe'] = $_POST['sexe'];
	}
}
else
{
	exut("preferences","Vous devez avoir obligatoirement votre sexe");
}
$sql .= "WHERE pseudo = '$pseudo'";
mysql_query($sql);
exut("accueil","Vos préférences viennent d'être mis à jour");
?>