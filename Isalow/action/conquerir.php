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

$continent = $_POST['continent'];
$ligne = $_POST['ligne'];
$colone = $_POST['colone'];
$nom = $_POST['nom'];

if( !filtre($nom,3,15) )
{
	exut("carte","Le nom doit faire entre 3 et 15 caractères et ne peut comporter de caractères spéciaux");
}

$abc = array("1","2","3","4","5","6","7","8","9","10","11","12");

$sql = "SELECT * FROM is_pays WHERE continent = '".$continent."'";
$resultat_pays = mysql_query($sql);
$t_pays = mysql_fetch_array($resultat_pays);

for($i=0 ; $i < 25 ; $i++)
{
	$lignepays = explode(";",$t_pays[$abc[$ligne]]);
}

$pays = $lignepays[ $colone ];

if( $pays != "vide" )
{
	exut("pays","Cette région appartient déjà à un autre Seigneur");
}

$sql = "SELECT * FROM is_region WHERE pseudo = '".$pseudo."'";
$resultat_region = mysql_query($sql);
$nombre = mysql_num_rows($resultat_region);

$sql = "SELECT * FROM is_user WHERE pseudo = '".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

$cout_soldats = $t_user['soldat'] - ($nombre*750);
$cout_clones = $t_user['clone'] - ($nombre*2000);
$cout_nourriture = $t_user['nourriture'] - (($nombre*750)*30 + ($nombre*2000)*20);
$habitation = $t_user['habitation'] + 1;
$abattoir = $t_user['abattoir'] + 1;
$lands = $t_user['lands'] + 2;
		
if( $cout_soldats < 0 || $cout_clones < 0 || $cout_nourriture < 0 )
{
	exut("pays","Vous ne possédez pas assez de ressources");
}

$sql = "SELECT pays FROM is_region WHERE pays='$nom'";
$resultat_region = mysql_query($sql);

if( mysql_num_rows($resultat_region) > 0 )
{
	exut("pays","Le nom de votre future région est déjà repris dans le jeu. Veuillez en choisir un autre.");
}

$lignepays[$colone] = $nom;
$lignepays = implode(";",$lignepays);
$sql = "UPDATE is_pays SET `".$abc[$ligne]."` = '".$lignepays."' WHERE continent = '".$continent."'";
mysql_query($sql);
$sql = "UPDATE is_user SET `lands` = '".$lands."' , `habitation` = '".$habitation."' , `abattoir` = '".$abattoir."' , `soldat` = '".$cout_soldats."' , `clone` = '".$cout_clones."' , `nourriture` = '".$cout_nourriture."' WHERE pseudo = '".$pseudo."'";
mysql_query($sql);
$sql = "INSERT INTO is_region (`pseudo` , `pays` , `cont`) VALUES('".$pseudo."','".$nom."','".$continent."')";
mysql_query($sql);

exut("carte","Vous avez conqui avec succès la région");
?>