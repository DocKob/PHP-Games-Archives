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
	//importations
	require("../functions.php");
	
	db_connexion();
	
	if( isset($_POST['nom']) && isset($_POST['description']) ) //insertion d'un forum
	{
		$nom = addslashes(trim(htmlentities($_POST['nom'])));
		$description = addslashes(trim(htmlentities($_POST['description'])));
		if( strlen($titre > 35 ) )
		{
			exut("forum_index","Le titre doit être compris entre 3 et 35 caractères");
		}
		$sql = "INSERT INTO is_f_forum ( titre , description ) VALUES ( '".$nom."' , '".$description."' )";
		mysql_query($sql);
	}
	if( isset($_POST['supprimer']) ) //suppretion des forums
	{
		$supprimer = $_POST['supprimer'];
		if( $supprimer == "all" )
		{
			$sql = "TRUNCATE TABLE is_f_forum";
			mysql_query($sql);
			$sql = "TRUNCATE TABLE is_f_sujet";
			mysql_query($sql);
			$sql = "TRUNCATE TABLE is_f_post";
			mysql_query($sql);
		}
		else if( $supprimer == "fastall" )
		{
			$sql = "UPDATE is_f_forum SET `sujets`='0' , `messages`='0' , `dernier`=''";
			mysql_query($sql);
			$sql = "TRUNCATE TABLE is_f_sujet";
			mysql_query($sql);
			$sql = "TRUNCATE TABLE is_f_post";
			mysql_query($sql);
		}
	}
	mysql_close();
	header("location:../jeu.php?include=forum_index");
}
?>