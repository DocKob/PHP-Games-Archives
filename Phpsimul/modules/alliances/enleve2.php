<?php

if(isset($_POST['confirmez']) )
{ // debut if isset post confirmez

if($_POST['confirmez'] == "NON")
{
header("location: index.php?mod=alliances/alliance") ;
}
elseif($_POST['confirmez'] == "OUI")
{
$alli_cand = $userrow['candidature'] ; // Alli ou le joueur a posé sa candidature

mysql_query ("UPDATE phpsim_users SET candidature='0' WHERE id='".$userrow['id']."' ") ;

mysql_query("DELETE FROM phpsim_allicand WHERE idjoueur='".$userrow['id']."' ");

$données_alli1 = mysql_query(" SELECT * FROM phpsim_alliance WHERE id='".$alli_cand."' ");
$données_alli = mysql_fetch_array($données_alli1) ;

$page="Vous avez retiré votre candidature pour l'alliance : <b>".$données_alli['nom']."</b>
<br><br><a href='index.php?mod=alliances/alliance'>Retour</a>";
}

} // fin if isset post confirmez
else // si aucun post n'a été fait alors le joueurs est arrivé sur la page en acces non autorisé, on bloque
{
$page = "Vous n'avez rien a faire là ...";
}
?>