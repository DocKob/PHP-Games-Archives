<?php
$a = mysql_query("SELECT * FROM phpsim_users WHERE id='".$userid."'");
while ($b = mysql_fetch_array($a))
{
$page="

<center>
<a href='javascript:history.back()'>Retour sur la page d'alliance</a><br>
<font size='+1'>Liste des membres de votre alliance : </font><br><br>
<table border='1' width='400'><tr><th>Nom</th><th>Points</th><th>Rang</th></tr>
";

$result = mysql_query("SELECT id, nom, points, rangs FROM phpsim_users WHERE alli='".$b['alli']."' Order by points DESC");

while ($row = mysql_fetch_array($result, MYSQL_BOTH) ) 
{
// On recupere le nom du rang du joueur
$rangs2 = mysql_query("SELECT * FROM phpsim_rangs WHERE id='".$row['rangs']."' ");
$rangs1 = mysql_fetch_array($rangs2) ;
$rangs = $rangs1["nom"] ;

if(empty($rangs) ) { $rangs = "Aucun"; } // si le rang est pas defini alors on met aucun rang


$page.="<tr><th><a href='index.php?mod=ecrire&destinataire=" . $row["nom"] . "'>".$row["nom"]."</th>

<th>".$row["points"]."</th><th>".$rangs."</th></tr> ";
}
mysql_free_result($result);
mysql_free_result($rangs2);
$page.="</table>";
}
?>