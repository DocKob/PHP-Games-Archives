<?php

// Protection contre le hack:
if(adminautoris�ok == "1234567890123456789")
{

if(isset($_POST['action_cand']) ) 
{ // debut if isset action_cand

if($_POST['action_cand'] == "Accepter")
{
$nom_joueur=$_POST['nom_joueur'];

// On recupere les donn�es du joueur
$donn�es_joueur1 = mysql_query("SELECT * FROM phpsim_users WHERE nom='".$nom_joueur."' ");
$donn�es_joueur = mysql_fetch_array($donn�es_joueur1) ;

// On recupere les donn�es de l'alli
$donn�es_alli1 = mysql_query("SELECT * FROM phpsim_alliance WHERE id='".$donn�es_joueur['candidature']."' ");
$donn�es_alli = mysql_fetch_array($donn�es_alli1) ;

mysql_query("UPDATE phpsim_users SET candidature='0', alli='".$donn�es_joueur['candidature']."', rangs='".$donn�es_alli['id_rangs_default']."' WHERE nom='".$nom_joueur."' ");
mysql_query("DELETE FROM phpsim_allicand WHERE idjoueur='".$donn�es_joueur['id']."' ") ;

// On envoye un message au joueur pour lui dire qu'il a �t� accpet�
$time = time(); // on recupere la date

mysql_query("INSERT INTO phpsim_messagerie SET id='', titre='Vous avez �t� accept� dans l\'alliance', message='Votre candidature pour l\'alliance <b>".$donn�es_alli['nom']."</b> a �t� accept�e.<br>Bienvenue dans notre alliance.<br><b><a href=\'index.php?mod=alliances/alliance\'>Cliquez ici pour aller sur la page d\'alliance</a>', date='" . $time . "', destinataire='" . $donn�es_joueur["id"] . "', systeme='1' ");
	
@$page.="Le joueur <b>".$nom_joueur."</b> est d�sormais membre de votre alliance.<br><br>";


}
elseif($_POST['action_cand'] == "Refuser")
{
$nom_joueur=$_POST['nom_joueur'];

// On recupere les donn�es du joueur
$donn�es_joueur1 = mysql_query("SELECT * FROM phpsim_users WHERE nom='".$nom_joueur."'") ;
$donn�es_joueur = mysql_fetch_array($donn�es_joueur1) ;

// On recupere les donn�es de l'alli
$donn�es_alli1 = mysql_query("SELECT * FROM phpsim_alliance WHERE id='".$donn�es_joueur['candidature']."' ");
$donn�es_alli = mysql_fetch_array($donn�es_alli1) ;

mysql_query("UPDATE phpsim_users SET candidature='0', alli='0' WHERE nom='".$nom_joueur."' ");
mysql_query("DELETE FROM phpsim_allicand WHERE idjoueur='".$donn�es_joueur['id']."' ");

// On envoye un message au joueur pour lui dire qu'il a �t� refus�
$time = time(); // on recupere la date

mysql_query("INSERT INTO phpsim_messagerie SET id='', titre='Vous avez �t� refus� dans l\'alliance', message='Votre candidature pour l\'alliance <b>".$donn�es_alli['nom']."</b> a �t� refus�e.<br>Retentez votre chance avec une autre alliance.<br><b><a href=\'index.php?mod=alliances/rejoindre\'>Cliquez ici pour trouver une autre alliance.</a>', date='" . $time . "', destinataire='" . $donn�es_joueur["id"] . "', systeme='1' ");
	
	
$page.="Vous n'avez pas accept� le joueur <b>".$nom_joueur."</b> dans votre alliance.</b><br><br>";

}






} // fin if isset action_cand

$candidature = mysql_query("SELECT * FROM phpsim_allicand WHERE idalli='".$userrow['alli']."' ");

if(mysql_num_rows($candidature) == 0) // si aucune candidature
{
@$page .= "<font size='+2'><b>Vous n'avez re�u aucune candidature.</b></font>";
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
@$page .= "Vous n'�tes pas autoris� � acc�der � cette page.";
}

?>