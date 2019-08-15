<?php
//paramettres de session//
session_start();
if( !session_is_registered("pseudo") || !session_is_registered("sexe") ||!session_is_registered("race") ||!session_is_registered("portrait") ||!session_is_registered("alliance") )
{
	exit();
}
$pseudo = $_SESSION['pseudo'];
$race = $_SESSION['race'];
//importations
require("../race/".$race.".php");
require("../functions.php");

db_connexion();

/*********************************************/
$sql = "SELECT * FROM is_user WHERE pseudo = '".$pseudo."'";
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
$echange = $_POST['echange'];

if(in_array($ressource,$ressources) && in_array($echange,$ressources) && is_numeric($montant) && $t_user[ $ressourceTrad[$ressource] ] >= $montant && $montant > 0)
{
	$valeurs = $marche[ $ressource ];
	$valeur = $valeurs[ $echange ];

	if($valeur == 1)
	{
		exut("commerce","Echange impossible");
	}
	$montantEchange = floor($valeur * $montant);
	$montantEchange = floor( $montantEchange - ($montantEchange*0.05) );

	$augmentation = $t_user[ $ressourceTrad[$echange] ] + $montantEchange;
	$diminution = $t_user[ $ressourceTrad[$ressource] ] - $montant;

	$sql = "UPDATE is_user SET `".$ressourceTrad[$echange]."` = '".$augmentation."' , `".$ressourceTrad[$ressource]."` = '".$diminution."' WHERE pseudo='".$pseudo."'";
	mysql_query($sql);

	exut("commerce","Vous avez échangé(e) $montant $ressourceTrad[$ressource] contre $montantEchange $ressourceTrad[$echange]. Il se peut que cela dépasse vos limites, profitez-en avant que ça ne se rétablisse");
}
?>