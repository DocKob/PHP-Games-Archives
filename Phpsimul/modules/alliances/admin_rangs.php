<?PHP

if(adminautoriséok == "1234567890123456789")
{
###################################################################################################################

// Puis par traité les infos si il y en a
if(@$_POST['action'] == "Ajouter rang") // si il veut ajouter un rang
{
if($_POST['nom'] == "" or $_POST['admin'] == "")  // les deux champ sont vide on ignore  
{ }
else // les champs ne sont pas vide ou execute
{ 
$nom=$_POST['nom'];
$admin=$_POST['admin'];

$b = mysql_query ("SELECT alli FROM phpsim_users where id='".$userid."'");
while ($d = mysql_fetch_array($b)) { $idalli=$d['alli']; }

mysql_query("INSERT INTO phpsim_rangs (nom, admin, idalli) VALUES ('".$nom."', '".$admin."', '".$idalli."')");

$page .= "Vous venez d'ajouter le rang : ".$nom.".";
}
}
###################################################################################################################

elseif(@$_POST['action'] == "Changer") // si il veut changer le status administrateur
{
$id=$_POST['id']; // on recupere l'id du rang dans une variable

$rangs = mysql_query("SELECT id,admin,nom FROM phpsim_rangs WHERE id=".$id.""); // on recupere les valeur de admin dans le rang
$rep = mysql_fetch_array($rangs) ;
if($rep['admin'] == 1)      
{ mysql_query("UPDATE phpsim_rangs SET admin='0' WHERE id=".$id.""); 
$page .= "Vous avez supprimé la possibilité d'administration dans le Rang : ".$rep['nom'];
}
elseif ($rep['admin'] == 0) 
{ mysql_query("UPDATE phpsim_rangs SET admin='1' WHERE id=".$id.""); 
$page .= "Vous avez rendu possible l'administration dans le Rang:".$rep['nom'];
}
}

###################################################################################################################

elseif(@$_POST['action'] == "Supprimer") // si il veut suppr le rang
{ // debut else if action suppr
if(isset($_POST['id']))  
{    
$id=$_POST['id'];

$selectionne_nom_rang = mysql_query("SELECT nom FROM phpsim_rangs WHERE id='".$id."' ");
while ($nom_rang = mysql_fetch_array($selectionne_nom_rang)) 
{
mysql_query("UPDATE phpsim_users SET rangs='NULL' WHERE rangs='".$nom_rang['nom']."' "); // on supprime la valeur de rang dans les utilisateur qui ont ce rang
mysql_query("DELETE FROM phpsim_rangs WHERE id='".$id."' "); // on supprime le rang de la bdd de rang
$page .= " Vous venez de supprimer le rang : ".$nom_rang['nom']."<br>";
}
} else { } // si aucune ID alors on passe dans ce else qui est vide
} // fin elseif action suppr

###################################################################################################################

// On verifie si il existe des rang dans quel cas on les affiche
$rang_existe = mysql_query("SELECT * FROM phpsim_rangs WHERE idalli='".$userrow['alli']."'");

if(@mysql_num_rows($rang_existe) == 0) // il n'existe pas de rang
{ // debut  else il existe un rang
$page .= "<font size='+3'><b>Il n'existe aucun rang.</b></font><br><br>";
}
else // ou alors si il existe un rang
{ // debut  else il existe un rang

// Puis on execute la page
$page .= "
<table border='0' widht='400'><tr>
<th>Nom du rang</th><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<th>Administrateur</th><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><th></th></tr>";

$a = mysql_query("SELECT * FROM phpsim_rangs WHERE idalli='".$userrow['alli']."' ORDER BY nom ");
while ($b = mysql_fetch_array($a)) 
{
// On change l'etat de la varibale admin suivant si le rang l'est ou pas
if ($b["admin"] == 1 ) {
$g = "OUI";}
elseif ($b["admin"] == 0 ){
$g = "NON";}

// On affiche
$page.="
<form method='post' action=''>
<INPUT type='hidden' value='".$b["id"]."' name='id'>
<tr><td>".$b["nom"]."</td><td></td>
<td>".$g." <INPUT type='submit' name='action' value='Changer'></td><td></td>
<td><INPUT type='submit' name='action' value='Supprimer'></td></tr> 
</form>
";

}

$page .="</table><br><br>";

} // fin else il existe un rang

$page .= "
<form method='post' action=''>
<hr><b>Créer un rang : </b><br>
<table><tr><td>Nom du rang</td><td><INPUT type='texte' name='nom'></td></tr>
<tr><td>Le Rang est Administrateur.</td>
<td><input type='radio' name='admin' value='0' checked>NON <input type='radio' name='admin' value='1'>OUI</td></tr><tr><td>
<INPUT type='submit' name='action' value='Ajouter rang'></form><td></tr></table>
";

}
else
{
@$page .= "Vous n'êtes pas autorisé à accéder à cette page.";
}

?>