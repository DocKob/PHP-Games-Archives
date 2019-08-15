<?php
if( $alliance == 0 )
{
echo('
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="45" height="45"><a href="jeu.php?include=confrerie_creation"><img src="images/oeil.jpg" width="45" height="45" border="0"></a></td>
    <td height="45" valign="top" class="table45px"><a href="jeu.php?include=confrerie_creation">Cr&eacute;ation d\'une Confr&eacute;rie </a><br>
        <div class="gris">Cr&eacute;er votre propre Confr&eacute;rie et dicter vos r&egrave;gles </div></td>
  </tr>
</table>
');
}
?>
<br>
<?php
if( $_GET['id'] >= 1 )
{
	$sql = "SELECT pseudo FROM is_user WHERE pseudo = '".$pseudo."'";
	$resultat_user = mysql_query($sql);
	$t_user = mysql_fetch_array($resultat_user);
	$sql = "SELECT id,nom,roi,description FROM is_alliance WHERE id = '".$_GET['id']."'";
	$resultat_alliance = mysql_query($sql);
	$t_alliance = mysql_fetch_array($resultat_alliance);
	echo('
	<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
	<tr>
	<td class="table16px"><div align="center">Confr&eacute;rie '.$t_alliance['nom'].'</div></td>
	</tr>
	<tr>
	<td>'.isaCode($t_alliance['description']).'</td>
	</tr>
	<tr>
	<td class="table16px"><div align="center">Membres</div></td>
	</tr>
	<tr>
	<td>
	<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
	<tr>
	<td width="470">Nom</td>
	<td width ="100"><div align="center">Renomm&eacute;</div></td>
	<td width="100"><div align="center">Race</div></td>
	</tr>
	');
	$sql = "SELECT pseudo,sexe,alliance,race,renomme FROM is_user WHERE alliance = '".$t_alliance['id']."' ORDER BY pseudo";
	$resultat_user = mysql_query($sql);
	while( $t_user = mysql_fetch_array($resultat_user) )
	{
		echo('
		<tr>
		<td><font color="'.$sexes[ $t_user['sexe'] ].'">'.$t_user['pseudo'].'</font>
		');
		if( $t_alliance['roi'] == $t_user['pseudo'] ) echo(' Dirigeant');
		echo('
		</td>
		<td><div align="center">'.$renomme[ $t_user['renomme'] ].'</div></td>
		<td><div align="center">'.$t_user['race'].'</div></td>
		</tr>
		');
	}
	mysql_free_result($resultat_user);
	unset($t_user);
	echo('
	</table></td>
	</tr>
	</table>
	');
}
?>