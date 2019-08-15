<?php
$races = array("humain");
$sexes = array("m","f");
require("../functions.php");
if( !isset($_POST['pseudo']) || !filtre($_POST['pseudo'],3,15) )
{
	echo("Vous devez remplir le pseudo");
	exit;
}
if( !isset($_POST['race']) || !in_array($_POST['race'],$races) )
{
	echo("Vous devez remplir la race");
	exit;
}
if( !isset($_POST['mail']) || !filtremail($_POST['mail']) )
{
	echo("Vous devez remplir un mail correcte");
	exit;
}
if( !isset($_POST['sexe']) || !in_array($_POST['sexe'],$sexes) )
{
	echo("Vous devez remplir votre sexe");
	exit;
}

$pseudo = $_POST['pseudo'];
$race = $_POST['race'];
$mail = $_POST['mail'];
$sexe = $_POST['sexe'];

db_connexion();
	
$sql = "SELECT pseudo FROM is_user WHERE pseudo = '".$pseudo."'";
$resultat_user = mysql_query($sql);

if( mysql_num_rows($resultat_user) == 0 )
{
	require("../race/".$race.".php");
	
	$passe = gen_passe();
	$dureeTour = 3600;
	$tps = floor( (time()/$dureeTour) )*$dureeTour;
	$pass = md5($passe);
	
	$sql = "INSERT INTO is_user (id , pseudo , password , race , email , sexe , partisans , clone , nourriture , electricite , isalox , ors , argent , fer , thabitation , tabattoir , tport , tcentrale , timpot , tisalox , tor , targent , tfer , tour , seconde , ip) VALUES ('','".$pseudo."', '".$pass."','".$race."','".$mail."','".$sexe."','100','200','5000','500','0','0','1000','2000','".$race_caract[thabitation]."','".$race_caract[tabattoir]."','".$race_caract[tport]."','".$race_caract[tcentrale]."','".$race_caract[timpot]."','".$race_caract[tisalox]."','".$race_caract[tor]."','".$race_caract[targent]."','".$race_caract[tfer]."','".$tps."','".time()."','".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($sql);
	
	mail($mail,"Inscription à Isalow","Merci de vous être inscrit à Isalow The Final Fight.\n\n\nLogin: $pseudo\nPassword:$passe\n\nVous pouvez évidemment changer de mot de passe\n\nhttp://metagamerz.niloo.fr/");
	echo("un mail vient d'&ecirc;tre envoy&eacute;");
}
else
{
	echo("pseudo est déjà choisi");
}
?>