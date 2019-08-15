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

//importations//
require("../race/".$race.".php");
require("../functions.php");
//connexion bdd//
db_connexion();
//fonction de ressources//

$nombre = $_GET['nombre'];
$pays = $_GET['pays'];
$batiment = $_GET['batiment'];
$abc = array("1","2","3","4","5","6","7","8","9","10","11","12");

$toutBatiments = array("j","k","l","o","a","b","g","n","i","q","r","s","t","c","h","v");
$montagne = array("j","k","l","o");
$plaine = array("a","b","g","n");
$foret = array("i","q");
$desert = array("r","s","t");
$eau = array("c","h");

if( $nombre <= 1 || $nombre > 50 || !in_array($batiment,$toutBatiments) )
{
	exut("carte","Vous ne pouvez pas utiliser l'I.A. L'I.A. ne peut gérer uniquement entre 1 et 50 constructions ou explorations");
}

$sql = "SELECT * FROM is_region WHERE pays='".$pays."'";
$resultat_region = mysql_query($sql);
$t_region = mysql_fetch_array($resultat_region);

if($t_region['pseudo'] != $pseudo || mysql_num_rows($resultat_region) == 0)
{
	exut("carte","Cette région n'est pas la vôtre");
}

$sql = "SELECT * FROM is_user WHERE pseudo = '".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

if( $t_user['universite'] <= 0 )
{
	exut("carte","il faut posséder une université pour pouvoir utiliser l'I.A.");
}

if( $batiment == "v" )
{
	$nombre_max = exploMax($t_user);
	if($nombre > $nombre_max) $nombre = $nombre_max;
}

else
{
	$clone = $t_user['clone'];
	$nourriture = $t_user['nourriture'];
	$electricite = $t_user['electricite'];
	$isalox = $t_user['isalox'];
	$ors = $t_user['ors'];
	$argent = $t_user['argent'];
	$fer = $t_user['fer'];

	$price = $couts[$batiment];
	$memoire = $nombre;
	while( $clone > 0 && $nourriture > 0 && $electricite > 0 && $isalox > 0 && $ors > 0 && $argent > 0 && $fer > 0 && $memoire > 0 )
	{
		$clone -= $price[5];
		$nourriture -= $price[4];
		$electricite -= $price[6];
		$isalox -= $price[0];
		$ors -= $price[1];
		$argent -= $price[2];
		$fer -= $price[3];
		if($clone > 0 && $nourriture > 0 && $electricite > 0 && $isalox > 0 && $ors > 0 && $argent > 0 && $fer > 0) $memoire --;
	}
	$nombre = $nombre - $memoire;
	$memoire = $nombre;
}

$lands = $t_user['lands'];
$clone = $t_user['clone'];
$nourriture = $t_user['nourriture'];
$electricite = $t_user['electricite'];
$isalox = $t_user['isalox'];
$ors = $t_user['ors'];
$argent = $t_user['argent'];
$fer = $t_user['fer'];

for($i=0 ; $i < 12 && $nombre > 0; $i++)
{
	$lignecode = $t_region[$abc[$i]];

	for($a=0 ; $a < 12 && $nombre > 0; $a++)
	{
		$parcelle = substr($t_region[$abc[$i]],$a,1);
		
		/*****************************************************************************/
		if( $parcelle == "v" && $batiment == "v")
		{
			$explo = explo($lands);
					
			$clone -= $explo[5];
			$nourriture -= $explo[4];
			
			$numero = rand(0,100);
			if( $numero >= 0 && $numero < 40 )
			{
				$batiment = "p";
			}
			elseif(  $numero >= 40 && $numero < 65 )
			{
				$batiment = "e";
			}
			elseif(  $numero >= 65 && $numero < 80 )
			{
				$batiment = "m";
			}
			elseif(  $numero >= 80 && $numero < 90 )
			{
				$batiment = "d";
			}
			elseif(  $numero >= 90 && $numero <= 100 )
			{
				$batiment = "f";
			}
			$lignecode = substr_replace($lignecode,$batiment,$a,1);
			
			$batiment = "v";
			$lands++;
			$nombre--;
		}
		/*****************************************************************************/
		if( $parcelle == "p" && in_array($batiment,$plaine) )
		{
			$price = $couts[$batiment];
			
			$clone -= $price[5];
			$nourriture -= $price[4];
			$electricite -= $price[6];
			$isalox -= $price[0];
			$ors -= $price[1];
			$argent -= $price[2];
			$fer -= $price[3];
			
			$lignecode = substr_replace($lignecode,$batiment,$a,1);
			
			$nombre--;
		}
		/*****************************************************************************/
		if( $parcelle == "e" && in_array($batiment,$eau) )
		{
			$price = $couts[$batiment];
			
			$clone -= $price[5];
			$nourriture -= $price[4];
			$electricite -= $price[6];
			$isalox -= $price[0];
			$ors -= $price[1];
			$argent -= $price[2];
			$fer -= $price[3];
			
			$lignecode = substr_replace($lignecode,$batiment,$a,1);
			
			$nombre--;
		}
		/*****************************************************************************/
		if( $parcelle == "f" && in_array($batiment,$foret) )
		{
			$price = $couts[$batiment];
			
			$clone -= $price[5];
			$nourriture -= $price[4];
			$electricite -= $price[6];
			$isalox -= $price[0];
			$ors -= $price[1];
			$argent -= $price[2];
			$fer -= $price[3];
			
			$lignecode = substr_replace($lignecode,$batiment,$a,1);
			
			$nombre--;
		}
		/*****************************************************************************/
		if( $parcelle == "m" && in_array($batiment,$montagne) )
		{
			$price = $couts[$batiment];
			
			$clone -= $price[5];
			$nourriture -= $price[4];
			$electricite -= $price[6];
			$isalox -= $price[0];
			$ors -= $price[1];
			$argent -= $price[2];
			$fer -= $price[3];
			
			$lignecode = substr_replace($lignecode,$batiment,$a,1);
			
			$nombre--;
		}
		/*****************************************************************************/
		if( $parcelle == "d" && in_array($batiment,$desert) )
		{
			$price = $couts[$batiment];
			
			$clone -= $price[5];
			$nourriture -= $price[4];
			$electricite -= $price[6];
			$isalox -= $price[0];
			$ors -= $price[1];
			$argent -= $price[2];
			$fer -= $price[3];
			
			$lignecode = substr_replace($lignecode,$batiment,$a,1);
			
			$nombre--;
		}
		/*****************************************************************************/
		$sql = "UPDATE is_region SET `".$abc[$i]."` = '".$lignecode."' WHERE pays = '".$pays."'";
		mysql_query($sql);
	}
}
$sql = "UPDATE is_user SET `lands` = '".$lands."', `clone` = '".$clone."', `nourriture` = '".$nourriture."', `electricite` = '".$electricite."', `isalox` = '".$isalox."', `ors` = '".$ors."', `argent` = '".$argent."', `fer` = '".$fer."' WHERE pseudo = '".$pseudo."'";
mysql_query($sql);
if( $batiment != "v" )
{
	$nombre = $memoire - $nombre;
	
	$seconds = time() + $race_caract['tps_batiment'];
	// ----- Insertion d'une batiment dans la base de donnee
	$sql = "INSERT INTO is_construction VALUES ('','".$pseudo."','".$pays."','".$batiment."','".$nombre."','".$seconds."')";
	mysql_query($sql);

}
exut("carte","L'I.A. a terminée les constructions ou explorations avec succès");
?>