<?php
session_start();
if( !session_is_registered("pseudo") || !session_is_registered("sexe") ||!session_is_registered("race") ||!session_is_registered("portrait") ||!session_is_registered("alliance") )
{
	exit();
}
$pseudo = $_SESSION['pseudo'];

require("../functions.php");

db_connexion();

if( isset($_POST['destinataire']) && isset($_POST['message']) )
{
	$destinataire = $_POST['destinataire'];
	$destinataire = trim( htmlentities($destinataire) );
	$sujet = $_POST['sujet'];
	$sujet = trim( htmlentities($sujet) );
	$message = $_POST['message'];
	$message = trim( htmlentities($message) );
	if( !empty($destinataire) && !empty($message) )
	{
		$sql = "SELECT pseudo FROM is_user WHERE pseudo = '".$destinataire."'";
		$resultat_user = mysql_query($sql);
		if( mysql_num_rows($resultat_user) == 1 )
		{
			$t_user = mysql_fetch_array($resultat_user);
			$destinataire = $t_user['pseudo'];
			sms($pseudo,$destinataire,$sujet,$message);
			exut("messages","Le message a été bien envoyé");
		}
		else
		{
			exut("messages","Le destinataire n'existe pas");
		}
	}
	else
	{
		exut("messages","Vueillez remplir tous les champs");
	}
}
else
{
	exut("messages","Vueillez remplir tous les champs");
}
?>