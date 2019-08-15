<?php

// Protection contre le hack:
if(adminautoriséok == "1234567890123456789")
{

if(isset($_POST['action_cand']) ) 
{ // debut if isset action_cand

if($_POST['action_cand'] == "Accepter")
{
$nom_joueur=$_POST['nom_joueur'];

// On recupere les données du joueur
$données_joueur1 = mysql_query("SELECT * FROM phpsim_users WHERE nom='".$nom_joueur."' ");
$données_joueur = mysql_fetch_array($données_joueur1) ;

// On recupere les données de l'alli
$données_alli1 = mysql_query("SELECT * FROM phpsim_alliance WHERE id='".$données_joueur['candidature']."' ");
$données_alli = mysql_fetch_array($données_alli1) ;

mysql_query("UPDATE phpsim_users SET candidature='0', alli='".$données_joueur['candidature']."', rangs='".$données_alli['id_rangs_default']."' WHERE nom='".$nom_joueur."' ");
mysql_query("DELETE FROM phpsim_allicand WHERE idjoueur='".$données_joueur['id']."' ") ;

// On envoye un message au joueur pour lui dire qu'il a été accpeté
$time = time(); // on recupere la date

mysql_query("INSERT INTO phpsim_messagerie SET id='', titre='Vous avez été accepté dans l\'alliance', message='Votre candidature pour l\'alliance <b>".$données_alli['nom']."</b> a été acceptée.<br>Bienvenue dans notre alliance.<br><b><a href=\'index.php?mod=alliances/alliance\'>Cliquez ici pour aller sur la page d\'alliance</a>', date='" . $time . "', destinataire='" . $données_joueur["id"] . "', systeme='1' ");
	
@$page.="Le joueur <b>".$nom_joueur."</b> est désormais membre de votre alliance.<br><br>";


}
elseif($_POST['action_cand'] == "Refuser")
{
$nom_joueur=$_POST['nom_joueur'];

// On recupere les données du joueur
$données_joueur1 = mysql_query("SELECT * FROM phpsim_users WHERE nom='".$nom_joueur."'") ;
$données_joueur = mysql_fetch_array($données_joueur1) ;

// On recupere les données de l'alli
$données_alli1 = mysql_query("SELECT * FROM phpsim_alliance WHERE id='".$données_joueur['candidature']."' ");
$données_alli = mysql_fetch_array($données_alli1) ;

mysql_query("UPDATE phpsim_users SET candidature='0', alli='0' WHERE nom='".$nom_joueur."' ");
mysql_query("DELETE FROM phpsim_allicand WHERE idjoueur='".$données_joueur['id']."' ");

// On envoye un message au joueur pour lui dire qu'il a été refusé
$time = time(); // on recupere la date

mysql_query("INSERT INTO phpsim_messagerie SET id='', titre='Vous avez été refusé dans l\'alliance', message='Votre candidature pour l\'alliance <b>".$données_alli['nom']."</b> a été refusée.<br>Retentez votre chance avec une autre alliance.<br><b><a href=\'index.php?mod=alliances/rejoindre\'>Cliquez ici pour trouver une autre alliance.</a>', date='" . $time . "', destinataire='" . $données_joueur["id"] . "', systeme='1' ");
	
	
$page.="Vous n'avez pas accepté le joueur <b>".$nom_joueur."</b> dans votre alliance.</b><br><br>";

}






} // fin if isset action_cand

$candidature = mysql_query("SELECT * FROM phpsim_allicand WHERE idalli='".$userrow['alli']."' ");

if(mysql_num_rows($candidature) == 0) // si aucune candidature
{
@$page .= "<font size='+2'><b>Vous n'avez reçu aucune candidature.</b></font>";
}
elseif(mysql_num_rows($candidature) >= 1) // si une candidature
{ // debut elseif cand recu
@$page .= "
<font size='+2'><b>Les candidatures recues : </b></font><br><br>
";

// On affiche les candidature
$candidature1 = mysql_query("SELECT * FROM phpsim_allicand WHERE idalli='".$userrow['alli']."' ORDER BY id ");
while ($candidature = mysql_fetch_array($candidature1) )
{

// On recupere les infos du joueur
$infos_joueurs1 = mysql_query("SELECT * FROM phpsim_users WHERE id='".$candidature['idjoueur']."' ") ; 
$infos_joueurs = mysql_fetch_array($infos_joueurs1) ;

@$page .= "
<i><u><b>Vous avez recu une candidature de : ".$infos_joueurs['nom']."</i></u></b><br>
     ".nl2br($candidature['textejoueurs'])."<br><br>
<form method='post' action=''>
<input type='hidden' name='nom_joueur' value='".$infos_joueurs['nom']."' name='cand'>
<input type='submit' name='action_cand' value='Accepter'><input type='submit'  name='action_cand' value='Refuser'>
</form>
<hr>
";

 
}
} // fin elsef cand recu


// Protection contre le hack:
}
else
{
@$page .= "Vous n'êtes pas autorisé à accéder à cette page.";
}

?>