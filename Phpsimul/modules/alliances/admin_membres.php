<?php

if(adminautoriséok == "1234567890123456789")
{

if(isset($mod[2]) ) // on supprime le membre de l'alli
{
$id=$mod[2];

// On recupere le nom du joueur a renvoyé
$nom1 = mysql_query("SELECT * FROM phpsim_users WHERE id='".$id."' ") ;
$nomd = mysql_fetch_array($nom1);
$nom = $nomd['nom'] ;

// On recupere les infos de l'alli
$données_alli1 = mysql_query("SELECT * FROM phpsim_alliance WHERE id='".$nomd['alli']."' ") ;
$données_alli = mysql_fetch_array($données_alli1) ;

// On envoye un message au joueur pour lui dire qu'il a été renvoyé
$time = time(); // on recupere la date

mysql_query("INSERT INTO phpsim_messagerie SET id='', titre='Message de l\'alliance', message='Vous avez été renvoyé de l\'alliance par un de ses administrateurs, pour reposer votre candidature <a href=\'index.php?mod=alliances/rejoindre|".$données_alli['tag']."\'>Cliquez ici</a>', date='" . $time . "', destinataire='" . $nomd["id"] . "', systeme='1' ");
	
mysql_query("UPDATE phpsim_users SET alli='0' , admin_alli='0', rangs='0' WHERE id='".$id."' ");

$page .= "<font size='+1'><b>Le membre <b>".$nom."</b> a bien été renvoyé de l'alliance. Un message lui a été envoyé.</b></font>";
}

if(isset($_POST['membre']) ) // on change le rant d'un membre
{
$nom=$_POST['membre'];
$rang=$_POST['rangs'];

mysql_query("UPDATE phpsim_users SET rangs='".$rang."' where nom='".$nom."' ");

$page .= "<font size='+1'><b>Vous avez bien mis à jour le rang du membre ".$nom."</b>.</font>";
}

$page.= "
<table border='0'>
<tr><td></td><td></td>
    <td><center>Nom du membre</center></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><center>Rang</center></td></tr>
    <td></td><td></td>
";


$c = mysql_query("SELECT * FROM phpsim_users WHERE alli='".$userrow['alli']."'");

$nb = 1 ; // on defnit un nombre pour que les submit n'est pas le meme nom, sinon ca fait boguer le javascript qui envoye le formulaire

while ($alli_users = mysql_fetch_array($c)) //$alli_users = les joueurs de l'alli
{
$page.="
<form name='action_joueur".$nb."' action='index.php?mod=alliances/admin_alli|membres' method='post'>  
<tr><td>
";

if($alli_users['admin_alli'] == 0)
{
$page.="<a href='index.php?mod=alliances/admin_alli|membres|".$alli_users['id']."'><img src='modules/alliances/delete.gif.png'></a>";
}

$page.="
</td><td></td>
    <td><center><input type='hidden' name='membre' value='".$alli_users["nom"]."'>".$alli_users["nom"]."</center></td>
    <td></td><td><select name='rangs'>
";


$a = mysql_query("SELECT * FROM phpsim_rangs WHERE idalli='".$userrow['alli']."'");

while ($b = mysql_fetch_array($a)) 
   {

$page.="<option "; if($b["id"] == $alli_users["rangs"]) { $page .= " SELECTED "; } $page .=" value='".$b["id"]."'>".$b["nom"]."</option>";
  
   }
   
$page.="<OPTION "; if($alli_users["rangs"] == "" or $alli_users["rangs"] == "0") { $page .= " SELECTED "; } $page .=" value='0'>Aucun</option>
</select></td><td></td><td><a href='javascript:document.action_joueur".$nb.".submit();'><img src='modules/alliances/accept.png'></a></td></tr></form>
";

$nb = $nb + 1 ;
}
   

   
$page.="</table>";

if($userrow['admin_alli'] == 1)
{ // debut if si le joueur en cours est admin de l'alli

if(isset($_POST['changer_admin']) ) // si l'admin a deja cliqué sur le lien alors il veut changer l'admin on vient ici
{
$page.="
<br>Vous avez demandé à changer l'administrateur de l'alliance.
<br>Vous ne serez donc plus administrateur, et vous ne pourrez rien pour remedier à cela,
<br>excepté que le nouvel admin vous redonne votre place.
<form name='changer_admin' action='' method='post'>
<input type='hidden' name='changer_admin2' value='changer_admin'>
<br><a href='javascript:document.changer_admin.submit();'>Voulez vous vraiment continuer ?</a>
</form>
";
}
elseif(isset($_POST['changer_admin2']) ) // si c'est la deuxieme fois que l'admin clique, il a donc validez qu'il voulait changez d'admin
{
$page.="
<form name='changer_admin_fin' action='index.php?mod=alliances/change_admin' method='post'>
<br>Choisissez le membre qui va devenir le nouvel admin :
<br><select name='new_admin'>
";
// On recupere les joueur de l'alli
$joueur_de_alli1 = mysql_query("SELECT * FROM phpsim_users WHERE alli='".$userrow['alli']."' ORDER BY nom");
while($joueur_de_alli = mysql_fetch_array($joueur_de_alli1) )
{
$page.="
<option value='".$joueur_de_alli['id']."'>".$joueur_de_alli['nom']."</option>
";
}
$page.="</select> <a href='javascript:document.changer_admin_fin.submit();'><img src='modules/alliances/accept.png'></a></form>";


}
else  // si aucun clique sur le lien changer admin a été effectué on vient la
{
$page.="
<form name='changer_admin' action='' method='post'>
<input type='hidden' name='changer_admin' value='changer_admin'>
<br><a href='javascript:document.changer_admin.submit();'>Changer l'administrateur de l'alliance.</a>
</form>
";
}

} // fin if si le joueur en cours est admin de l'alli



}
else
{
@$page .= "Vous n'êtes pas autorisé à accéder à cette page.";
}



?>