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
$pays = $_POST['pays'];
$ligne = $_POST['ligne'];
$colone = $_POST['colone'];
$batiment = $_GET['batiment'];

$abc = array("1","2","3","4","5","6","7","8","9","10","11","12");

$sql = "SELECT * FROM is_region WHERE pays = '".$pays."'";
$req = mysql_query($sql) or die("une erreur dans la base de donne&eacute;1");
$t_region = mysql_fetch_array($req);

if($t_region['pseudo'] != $pseudo)
{
	exut("carte","Cette région n'est pas la vôtre");
}

$parcelle = substr( $t_region[$abc[$ligne]],$colone,1);
$lignecode = $t_region[$abc[$ligne]];

mysql_free_result($req);

if(strlen($batiment) == 1) {
	$montagne = array("j","k","l","o");
	$plaine = array("a","b","g","n");
	$foret = array("i","q");
	$desert = array("r","s","t");
	$eau = array("c","h");
	$terrains = array("p","m","f","e","d");
	if( in_array($batiment,$montagne) && ($parcelle != "m") ) {
		exut("carte","Erreur dans les parcelles");
	} elseif( in_array($batiment,$plaine) && ($parcelle != "p") ) {
		exut("carte","Erreur dans les parcelles");
	} elseif( in_array($batiment,$foret) && ($parcelle != "f") ) {
		exut("carte","Erreur dans les parcelles");
	} elseif( in_array($batiment,$desert) && ($parcelle != "d") ) {
		exut("carte","Erreur dans les parcelles");
	} elseif( in_array($batiment,$eau) && ($parcelle != "e") ) {
		exut("carte","Erreur dans les parcelles");
	} else {
		$sql = "SELECT * FROM is_user WHERE pseudo='".$pseudo."'";
		$resultat_user = mysql_query($sql) or die("une erreur dans la base de donne&eacute;2");
		$t_user = mysql_fetch_array($resultat_user);
		/******************************************************************************************************************************************/
		if( $batiment == "v" && $parcelle == "v")
		{
			$explo = explo($t_user['lands']);
			
			$clone = $t_user['clone'] - $explo[5];
			$nourriture = $t_user['nourriture'] - $explo[4];

			$lands = $t_user['lands'] + 1;

			if($clone < 0 OR $nourriture < 0 )
			{
				exut("carte","Vous ne possédez pas assez de ressources");
				$ok = false;
			}
			else
			{
				$ok = true;
				$sql = "UPDATE is_user SET `clone` = '".$clone."', `nourriture` = '".$nourriture."', `lands` = '".$lands."' WHERE pseudo = '".$pseudo."'";
				mysql_query($sql) or die("une erreur dans la base de donne&eacute;3");
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
			}
		}
		elseif($parcelle != "v" && $batiment != "1")
		{
			$price = $couts[$batiment];
			// ------- Retirer les ressources
			$isalox = $t_user['isalox'] - $price[0];
			$ors = $t_user['ors'] - $price[1];
			$argent = $t_user['argent'] - $price[2];
			$fer = $t_user['fer'] - $price[3];
			$nourriture = $t_user['nourriture'] - $price[4];
			$clone = $t_user['clone'] - $price[5];
			$electricite = $t_user['electricite'] - $price[6];
			
			// ------ Verifie les ressources
			if($clone < 0 || $nourriture < 0 || $isalox < 0 || $ors < 0 || $argent < 0 || $fer < 0 || $electricite < 0) {
				exut("carte","Vous ne possédez pas assez de ressources");
				$ok = false;
			} else {
				$ok = true;
				// ----- Update les ressources
				$sql = "UPDATE is_user SET `clone` = '".$clone."', `nourriture` = '".$nourriture."', `isalox` = '".$isalox."', `ors` = '".$ors."', `argent` = '".$argent."', `fer` = '".$fer."' WHERE pseudo = '".$pseudo."'";
				mysql_query($sql) or die("une erreur dans la base de donne&eacute;4");

				// ----- Calcul du temps + x minutes
				$seconds = time() + $race_caract['tps_batiment'];
				// ----- Insertion d'une batiment dans la base de donnee
				$sql = "INSERT INTO is_construction VALUES ('','".$pseudo."','".$pays."','".$batiment."','1','".$seconds."')";
				mysql_query($sql) or die("une erreur dans la base de donne&eacute;5");

			}
		}
		elseif($parcelle != "v" && $batiment == "1")
		{
			$isalox = $t_user['isalox'] - 20;
			$ors = $t_user['ors'] - 40;
			$argent = $t_user['argent'] - 80;
			$fer = $t_user['fer'] - 160;
			$clone = $t_user['clone'] - 10;
			$electricite = $t_user['electricite'] - 20;
			
			$construction = array(
			"a" => "habitation",
			"b" => "abattoir",
			"c" => "port",
			"g" => "stockage",
			"h" => "centrale",
			"i" => "Misalox",
			"j" => "Mor",
			"k" => "Margent",
			"l" => "Mfer",
			"n" => "universite",
			"o" => "stationradar",
			"q" => "tourdefense",
			"r" => "caserne",
			"s" => "usine",
			"t" => "nerv"
			);
			$batimentMoins = $t_user[ $construction[ $parcelle ] ] - 1;
			
			$sql = "UPDATE is_user SET `clone` = '".$clone."', `isalox` = '".$isalox."', `ors` = '".$ors."', `argent` = '".$argent."', `fer` = '".$fer."', `".$construction[ $parcelle ]."` = '".$batimentMoins."'  WHERE pseudo = '".$pseudo."'";
			mysql_query($sql);
			
			if( in_array($parcelle,$montagne) )
			{
				$batiment = "m";
			}
			elseif( in_array($parcelle,$plaine) )
			{
				$batiment = "p";
			}
			elseif( in_array($parcelle,$eau) )
			{
				$batiment = "e";
			}
			elseif( in_array($parcelle,$foret) )
			{
				$batiment = "f";
			}
			elseif( in_array($parcelle,$desert) )
			{
				$batiment = "d";
			}
			$ok = true;
		}

		if($ok) {
			$lignecode = substr_replace($lignecode,$batiment,$colone,1);

			$sql = "UPDATE is_region SET `".$abc[$ligne]."` = '".$lignecode."' WHERE pays = '".$pays."'";
			mysql_query($sql) or die("Erreur SQL !<br>".$sql."<br>".mysql_error());
			header("location:../jeu.php?include=carteregion&pays=".$pays);
		}
	}
}
?>