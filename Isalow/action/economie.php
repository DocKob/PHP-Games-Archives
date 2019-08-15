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

$type = $_GET['type'];
$augmentation = $_GET['augmentation'];

$sql = "SELECT partisans , thabitation , tabattoir , tport , tcentrale , timpot , tisalox , tor , targent , tfer FROM is_user WHERE pseudo='".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

$types = array("thabitation","tabattoir","tport","tcentrale","timpot","tisalox","tor","targent","tfer");

if( in_array($type,$types) && ($augmentation == "plus" || $augmentation == "moins") )
{
	if($type == "timpot")
	{
		$depart = 0.1;
	}
	else
	{
		$depart = $race_caract[$type];
	}

	$incrementation = round( ($depart * 0.02) , 3 );
	
	if($augmentation == "plus")
	{
		$nouveau = $t_user[$type] + $incrementation;
	}
	elseif($augmentation == "moins")
	{
		$nouveau = $t_user[$type] - $incrementation;
	}

	if( $nouveau >= ($depart + (10*$incrementation) ) && $augmentation == "plus")
	{
		exut("economie","Vous ne pouvez pas dépasser ".($depart + (10*$incrementation) ).".");
	}
	elseif( $nouveau <= 0 )
	{
		$error = 2;
	}
	elseif($t_user['partisans'] <= 15 && $augmentation == "plus")
	{
		exut("economie","Vous ne possédez pas assez de partisans pour permettre une augmentation");
	}
	else
	{
		$partisans = $t_user['partisans'];

		if($augmentation == "moins")
		{
			$partisans += rand(2,8);
		}
		else
		{
			$partisans -= rand(5,20);
		}
		if($partisans > 100) $partisans = 100;
		if($partisans < 0  ) $partisans = 0;

		$sql = "UPDATE is_user SET partisans='".$partisans."',".$type."='".$nouveau."' WHERE pseudo='".$pseudo."'";
		mysql_query($sql);
	}
	exut("economie","Vous avez bien augmenté ou diminué la production par tour");
}
?>