<?php

require("../functions.php");
if( !isset($_POST['mail']) || !filtremail($_POST['mail']) )
{
	echo("Vous devez remplir un mail correcte");
	exit;
}
$mail = $_POST['mail'];

db_connexion();
	
$sql = "SELECT pseudo FROM is_user WHERE email='".$mail."'";
$resultat_user = mysql_query($sql);

if( mysql_num_rows($resultat_user) == 1 )
{
	$t_user = mysql_fetch_array($resultat_user);
	$passe = gen_passe();
	$pass = md5($passe);
	
	$sql = "UPDATE is_user SET `password` = '".$pass."' WHERE `pseudo` = '".$t_user[pseudo]."'";
	mysql_query($sql);
	
	mail($mail,"Inscription à Isalow","Vos informations d'Isalow The Final Fight.\n\n\nLogin: $t_user[pseudo]\nPassword:$passe\n\nVous pouvez évidemment changer de mot de passe\n\nhttp://metagamerz.niloo.fr/");
	echo("un mail vient d'&ecirc;tre envoy&eacute;");
	mysql_close();
}
else
{
	echo("Il n'y a pas de compte avec cette adresse");
	mysql_close();
}
?>