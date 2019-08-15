<?php
session_start();
if( !session_is_registered("pseudo") || !session_is_registered("sexe") ||!session_is_registered("race") ||!session_is_registered("portrait") ||!session_is_registered("alliance") )
{
	exit();
}
$pseudo = $_SESSION['pseudo']; $sexe = $_SESSION['sexe']; $alliance = $_SESSION['alliance'];

require("../functions.php");
db_connexion();

if( isset($_POST['forum']) )
{
	$forum = $_POST['forum'];
	
	$sql = "SELECT * FROM is_user WHERE pseudo = '".$pseudo."'";
	$resultat_user = mysql_query($sql);

	$sql = "SELECT * FROM is_f_forum WHERE id = '".$forum."'";
	$resultat_forum = mysql_query($sql);
	
	if( mysql_num_rows($resultat_forum) == 1 )
	{
		$t_forum = mysql_fetch_array($resultat_forum);
		$t_user = mysql_fetch_array($resultat_user);
		
		if( $t_forum['alliance'] == 0 || $t_forum['alliance'] == $alliance || $t_user['sexe'] == 'z' )
		{
			$message = addslashes(trim(htmlentities($_POST['message'])));

			//Insertion du message
			$date_ecrit = date("d/m/Y \à H:i");
			$alliance_forum = $t_forum['alliance'];
			$seconde = time();
			
			if( !isset($_POST['sujet']) )
			{
				$titre = addslashes(trim(htmlentities($_POST['titre'])));
				if( strlen($titre) > 100 || strlen($titre) < 3)
				{
					exut("forum_nouveau&forum=".$forum."","Le titre est trop grand ou trop petit");
				}
				$sql = "INSERT INTO is_f_sujet ( titre , forum , seconde , auteur , alliance ) VALUES ( '".$titre."' , '".$forum."' , '".$seconde."' , '".$pseudo."', '".$alliance_forum."' )";
				mysql_query($sql) or die("erreur 00");
			
				$sql = "SELECT * FROM is_f_sujet WHERE auteur = '".$pseudo."' AND seconde = '".$seconde."'";
				$resultat_sujet = mysql_query($sql);
				$t_sujet = mysql_fetch_array($resultat_sujet);
				
				$sujet = $t_sujet['id'];

			}
			else
			{
				$sujet = $_POST['sujet'];
			}
			$sql = "INSERT INTO is_f_post ( sujet , texte , auteur , date_ecrit , seconde , alliance ) VALUES ( ".$sujet." , '".$message."' , '".$pseudo."' , '".$date_ecrit."' , '".$seconde."' , '".$alliance."')";
			mysql_query($sql) or die("erreur 01<br>".$sql."<br>".mysql_error());
			
			if( isset($_SESSION['flood']) && $_SESSION['flood'] >= (time()-20) )
			{
				exut("forum_index","Stop flooding");
				exit;
			}
			$_SESSION['flood'] = time();
			
			//redirection vers page sujet
			header("location:../jeu.php?include=forum_message&sujet=".$sujet."&forum=".$forum);
		}
		else
		{
			exut("forum_nouveau&sujet=$sujet&forum=$forum","Le forum n'est pas de votre alliance");
		}		
	}
	else
	{
		exut("forum_index","Le forum n'existe pas");
	}
}
?>