<?php
session_start();
if( !session_is_registered("pseudo") || !session_is_registered("sexe") ||!session_is_registered("race") ||!session_is_registered("portrait") ||!session_is_registered("alliance") )
{
	exit();
}
$pseudo = $_SESSION['pseudo'];

require("../functions.php");

db_connexion();

$posts = $_POST;

foreach($posts as $message_id) {
	$sql = "SELECT pour FROM is_message WHERE id='".$message_id."'";
	$resultat_message = mysql_query($sql) or die("DATA BASE ERROR");
	if(mysql_num_rows($resultat_message) == 1) {
	
		$t_message = mysql_fetch_array($resultat_message);
		if($t_message['pour'] == $pseudo) {
			$sql = "DELETE FROM is_message WHERE id='".$message_id."'";
			mysql_query($sql);
		}
		
	}
}
mysql_close();
exut("messages&type=suppr","Messages supprimés!");
?>