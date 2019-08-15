<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="45" height="45"><a href="jeu.php?include=classement_confrerie"><img src="images/oeil.jpg" width="45" height="45" border="0"></a></td>
    <td height="45" valign="top" class="table45px"><a href="jeu.php?include=classement_confrerie">Classement des Confr&eacute;ries</a> <br>
      <div class="gris">Tout sur les Confr&eacute;ries</div></td>
  </tr>
</table>
<br>
<table width="670"  border="0" cellpadding="0" cellspacing="0" class="txt" align="center">
  <tr>
    <td width="100" class="table16px">&nbsp;</td>
	<td width="100" class="table16px">Pseudo</td>
	<td width="100" class="table16px">Statu</td>
    <td width="200" class="table16px">Alliance</td>
    <td width="100" class="table16px">Renomm&eacute;e</td>
    <td width="180" align="right" class="table16px">Score</td>
  </tr>
<?php
$sql = "SELECT * FROM is_user ORDER BY score DESC LIMIT 100";
$resultat_user = mysql_query($sql);
$i = 0;
while( $t_user = mysql_fetch_array($resultat_user) )
{
$alliance = "SELECT id,nom FROM is_alliance WHERE id='".$t_user['alliance']."'";
$resultat_alliance = mysql_query($alliance);
$t_alliance = mysql_fetch_array($resultat_alliance);
	if( $t_user['seconde'] >= time() - 60 )
	{
		$connected = '<font class="gris">En Ligne</font>';
	}
	else
	{
		$connected = 'Hors Ligne';
	}
	$i++;
	echo('
	<tr>
	<td>'.$i.'</td>
	<td><a href="jeu.php?include=informations&joueur='.$t_user['pseudo'].'"><font color="'.$sexes[ $t_user['sexe'] ].'">'.$t_user['pseudo'].'</font></a></td>
	<td>'.$connected.'</td>
	<td><a href="jeu.php?include=confrerie_informations&id='.$t_alliance['id'].'">'.$t_alliance['nom'].'</a></td>
	<td>'.$renomme[ $t_user['renomme'] ].'</td>
	<td align="right">'.$t_user['score'].'</td>
	</tr>
	');
}
mysql_free_result($resultat_user);
unset($t_user);
?>
</table>
