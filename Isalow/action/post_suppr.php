<?php
session_start();
if( !session_is_registered("pseudo") || !session_is_registered("sexe") ||!session_is_registered("race") ||!session_is_registered("portrait") ||!session_is_registered("alliance") )
{
	exit();
}
$pseudo = $_SESSION['pseudo'];

require("../functions.php");

db_connexion();

$sujet = $_GET['sujet'];
$forum = $_GET['forum'];
$post = $_GET['post'];

$sql = "SELECT * FROM is_f_post WHERE id='".$post."'";
$resultat_post = mysql_query($sql) or die("DATA BASE ERROR");
$t_post = mysql_fetch_array($resultat_post);

$sql2 = "SELECT * FROM is_user WHERE pseudo='".$pseudo."'";
$resultat_user = mysql_query($sql2);
$t_user = mysql_fetch_array($resultat_user);

if( mysql_num_rows($resultat_post) == 0 )
{
	exut("forum_message&sujet=".$sujet."&forum=".$forum."","Le poste n'existe pas!");
}

if ($t_user['sexe'] != 'z') {
if( $t_post['auteur'] != $pseudo )
{
	exut("forum_message&sujet=".$sujet."&forum=".$forum."","Ce ne pas votre poste!");
}
}

$sql = "DELETE FROM is_f_post WHERE id='".$post."'";
mysql_query($sql);
		
mysql_close();
exut("forum_message&sujet=".$sujet."&forum=".$forum."","Poste supprimés!");
?>