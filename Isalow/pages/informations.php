<?php
$joueur = $_GET['joueur'];
$sql = "SELECT * FROM is_user WHERE pseudo='".$joueur."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);
$alliance = "SELECT id,nom FROM is_alliance WHERE id='".$t_user['alliance']."'";
$resultat_alliance = mysql_query($alliance);
$t_alliance = mysql_fetch_array($resultat_alliance);

echo('
<br>
<table width="690"  border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
<tr>
<td colspan="2" class="table16px"><div align="center">Profil</div></td>
</tr>
<tr>
<td width="100" height="100" valign="middle">
');
if (isset($t_user['portrait']) >= 1) {
echo('<img src="'.$t_user['portrait'].'" width="90" height="90">');
} else {
echo('<div align="center">No Avatar</div>');
}
echo('</td>
<td valign="top">
Seigneur '.$t_user['race'].', <font color="'.$sexes[ $t_user['sexe'] ].'">'.$joueur.'</font>, '.$t_user['age'].' ans<br>
Confr&eacute;rie: <a href="jeu.php?include=confrerie_informations&id='.$t_alliance['id'].'">'.$t_alliance['nom'].'</a><br>
Score: '.$t_user['score'].'<br> 
Renomm&eacute;e: '.$renomme[ $t_user['renomme'] ].'<br>
Lands: '.$t_user['lands'].'<br>
<br>Profil:<br>
'.$t_user['profil'].'<br>
<br>R&eacute;gions:<br>
');

$sql = "SELECT pseudo , pays , cont FROM is_region WHERE pseudo='".$joueur."'";
$sql2 = "SELECT pseudo , alliance FROM is_user WHERE pseudo='".$joueur."'";
$sql3 = "SELECT pseudo , alliance FROM is_user WHERE pseudo='".$pseudo."'";
$resultat_region = mysql_query($sql);
$resultat_user = mysql_query($sql2);
$resultat_user2 = mysql_query($sql3);
while($t_region = mysql_fetch_array($resultat_region) )
{
	$t_user = mysql_fetch_array($resultat_user);
	$t_user2 = mysql_fetch_array($resultat_user2);
	echo('
	<font class="gris">'.$t_region['pays'].'</font> sur <font class="gris">'.$t_region['cont'].'</font> 
	');
	if ($joueur != $pseudo && $t_user['alliance'] != $t_user2['alliance']) {
	echo('
	<a href="#">[Attaquer]</a>
	');
	}
	echo('
	<br>
	');
}
echo('
</td>
</tr>
</table>
<p>&nbsp;</p>
');

mysql_free_result($resultat_user);
unset($t_user);
?>
<form action="action/message_envoi.php" method="post" name="message">
  <p align="center">
    <input name="destinataire" type="hidden" value="<? echo($joueur); ?>">
  </p>
  <p align="center">
    Sujet :
  </p>
  <p align="center">
    <input name="sujet" type="text" value="" style="width:500">
  </p>
  <p align="center">
    Message :
  </p>
  <p align="center">
    <textarea name="message" style="width:500; height:300"></textarea>
  </p>
  <p align="center">
    <input type="submit" name="Submit" value="Envoyer" style="width:500">
  </p>
</form>