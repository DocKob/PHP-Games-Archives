<table width="670"  border="0" cellspacing="0" cellpadding="0" class="txt" align="center">
<tr>
<td width="45" class="table16px">&nbsp;</td>
<td width="300" class="table16px"><div align="center">Forum</div></td>
<td width="45" class="table16px">&nbsp;&nbsp;</td>
<td width="70" class="table16px"><div align="center">Discussions</div></td>
<td width="70" class="table16px"><div align="center">Messages</div></td>
<td width="185" class="table16px"><div align="center">Dernier message</div></td>
</tr>
</table>
<?php
$sql = "SELECT id,alliance,titre,description FROM is_f_forum WHERE alliance = '0' OR alliance = '".$alliance."' ORDER BY alliance DESC";
$resultat_forum = mysql_query($sql);

$sql2 = "SELECT id,alliance,titre,description FROM is_f_forum ORDER BY alliance DESC";
$resultat_forum_admin = mysql_query($sql2);

$sql6 = "SELECT sexe FROM is_user WHERE pseudo = '".$pseudo."'";
$resultat_user = mysql_query($sql6);
$t_user = mysql_fetch_array($resultat_user);

if($t_user['sexe'] == 'z')
{
while( $t_forum = mysql_fetch_array($resultat_forum_admin) )
{
$sql3 = "SELECT COUNT(id) AS nb FROM is_f_sujet WHERE forum='".$t_forum['id']."'";
$r_sujet = mysql_query($sql3);
$t_sujet = mysql_fetch_array($r_sujet);
$sql5 = "SELECT id,forum FROM is_f_sujet WHERE forum='".$t_forum['id']."'";
$r_sujet2 = mysql_query($sql5);
while ($t_sujet2 = mysql_fetch_array($r_sujet2)) {
$sql4 = "SELECT COUNT(id) AS nb FROM is_f_post WHERE sujet='".$t_sujet2['id']."'";
$r_post = mysql_query($sql4);
$t_post = mysql_fetch_array($r_post);
$nb += $t_post['nb'];
$nb_post = $nb;
}
if ($nb_post >= 1) {
$nb_post2 = $nb_post;
} else {
$nb_post2 = 0;
}
	echo('
		<br>
		<table width="670"  border="0" cellspacing="0" cellpadding="0" align="center">
		<tr bgcolor="#333333">
		<td width="45"><a href="jeu.php?include=forum_sujet&forum='.$t_forum['id'].'"><img src="images/oeil.jpg" width="45" height="45" border="0"></a></td>
		<td width="10" class="table45px">&nbsp;&nbsp;</td>
		<td width="300" valign="top" class="table45px"><a href="jeu.php?include=forum_sujet&forum='.$t_forum['id'].'">'.stripslashes($t_forum['titre']).'</a><br>
		<div class="gris">'.stripslashes($t_forum['description']).'</div></td>
		<td width="70" class="table45px"><div align="center">'.$t_sujet['nb'].'</div></td>
		<td width="70" class="table45px"><div align="center">'.$nb_post2.'</div></td>
		<td width="185" class="table45px"><div align="center">'.$t_forum['dernier'].'</div></td>
		</tr>
		</table>
	');
}
}
else
{
while( $t_forum = mysql_fetch_array($resultat_forum) )
{
$sql3 = "SELECT COUNT(id) AS nb FROM is_f_sujet WHERE forum='".$t_forum['id']."'";
$r_sujet = mysql_query($sql3);
$t_sujet = mysql_fetch_array($r_sujet);
$sql5 = "SELECT * FROM is_f_sujet WHERE forum='".$t_forum['id']."'";
$r_sujet2 = mysql_query($sql5);
$t_sujet2 = mysql_fetch_array($r_sujet2);
$sql4 = "SELECT COUNT(id) AS nb FROM is_f_post WHERE sujet='".$t_sujet2['id']."'";
$r_post = mysql_query($sql4);
$t_post = mysql_fetch_array($r_post);
$nb_post += $t_post;
	echo('
		<br>
		<table width="670"  border="0" cellspacing="0" cellpadding="0" align="center">
		<tr bgcolor="#333333">
		<td width="45"><a href="jeu.php?include=forum_sujet&forum='.$t_forum['id'].'"><img src="images/oeil.jpg" width="45" height="45" border="0"></a></td>
		<td width="10" class="table45px">&nbsp;&nbsp;</td>
		<td width="300" valign="top" class="table45px"><a href="jeu.php?include=forum_sujet&forum='.$t_forum['id'].'">'.stripslashes($t_forum['titre']).'</a><br>
		<div class="gris">'.stripslashes($t_forum['description']).'</div></td>
		<td width="70" class="table45px"><div align="center">'.$t_sujet['nb'].'</div></td>
		<td width="70" class="table45px"><div align="center">'.$nb_post.'</div></td>
		<td width="185" class="table45px"><div align="center">'.$t_forum['dernier'].'</div></td>
		</tr>
		</table>
	');
}
}
if($t_user['sexe'] == 'z')
{
	echo('<p>&nbsp;</p>
	<table width="670" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	<td class="table16px">Administration : Ajouter un forum </td>
	</tr>
	<tr>
	<td><br>
	<form name="Ajout" method="post" action="action/admin_forum.php">
	<div align="center">
	<input name="nom" type="text" id="nom" value="Nom du forum">
	<input name="description" type="text" id="description" value="Description">
	<input type="submit" name="Submit3" value="Cr&eacute;er nouveau forum">
	</div>
	</form><br>	</td>
	</tr>
	<tr>
	<td class="table16px">Administration : Reseter le forum </td>
	</tr>
	<tr>
	<td><br>
	<form name="Deleteall" method="post" action="action/admin_forum.php">
	<div align="center">
	<input name="supprimer" type="hidden" id="supprimer" value="all">
	<input type="submit" name="Submit" value="Supprimer Tout" style="width:500;">
	</div>
	</form>
	<form name="Delete" method="post" action="action/admin_forum.php">
	<div align="center">
	<input name="supprimer" type="hidden" id="supprimer" value="fastall">
	<input type="submit" name="Submit2" value="Supprimer tout sauf les forums" style="width:500;">
	</div>
	</form>
	</td>
	</tr>
	</table>');
}
mysql_free_result($resultat_user);
unset($t_user);
?>
