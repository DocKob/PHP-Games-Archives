<?php

/*

Page permettant d'envoyer la nouvelle candidature dans le sql

*/

if( (empty($userrow['alli']) or $userrow['alli'] == 0) and (empty($userrow['alli']) or $userrow['candidature'] == 0) )
{ // debut if le joueur peut posez candidature


if(isset($_POST['rejoindre_alli']) )
{

// On recupere les donn�es de l'alli a rejoindre
$donn�es_alli_a_rejoindre = mysql_query("SELECT * FROM phpsim_alliance WHERE tag='".$_POST['tag_alli_rej']."' ");
$donn�es_alli = mysql_fetch_array($donn�es_alli_a_rejoindre) ;

mysql_query("INSERT INTO phpsim_allicand (idalli, idjoueur, textejoueurs) 
             VALUES ('".$donn�es_alli['id']."', '".$userrow['id']."', '".mysql_real_escape_string($_POST['commentaire'])."') ")or die(mysql_error()) ;

mysql_query("UPDATE phpsim_users SET candidature='".$donn�es_alli['id']."' where id='".$userrow['id']."' ");

$page="Vous avez postul� pour l'alliance <b>".$donn�es_alli['nom']."<b> <a href='index.php'><br><br>Retour</a>";

}
else // protection contre l'acces direct a la page
{
$page = "Vous ne pouvez pas acc�der � cette page !";
}





} // fin if le joueur peut posez candidature
else // si le joueur a deja une alliance alors on leprevient qu'il peut ajouter ca candidature
{
@$page.= "
Vous ne pouvez pas poser de candidature, vous �tes deja dans une alliance
<br><a href='javascript:history.back();'>Retour</a>
";

}

?>