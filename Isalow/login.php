<?php
$pseudo = $_GET['pseudo'];
$password = $_GET['password'];
if( isset($pseudo,$password) )
{
	require("functions.php");
	
	db_connexion();
	
	$sql = "SELECT pseudo,password,race,portrait,sexe,alliance FROM is_user WHERE pseudo='".$pseudo."'";
	$resultat_user = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($resultat_user) == 1)
	{
		$t_user = mysql_fetch_array($resultat_user);
		
		$password = md5($password);
		
		if($password == $t_user['password'])
		{
			session_start();
			session_unset();
			$_SESSION['pseudo'] = $t_user['pseudo'];
			$_SESSION['race'] = $t_user['race'];
			$_SESSION['portrait'] = $t_user['portrait'];
			$_SESSION['sexe'] = $t_user['sexe'];
			$_SESSION['alliance'] = $t_user['alliance'];
			$_SESSION['tps'] = (time()-5);
			header("location:jeu.php");
		}
		else
		{
			echo("Utilisateur ou mot de passe érroné");
		}
	}
	else
	{
		echo("L'utilisateur n'existe pas");
	}
}
?>