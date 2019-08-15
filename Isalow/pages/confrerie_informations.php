<?php
$id = $_GET['id'];
$sql = "SELECT id,nom,description,roi FROM is_alliance WHERE id='".$id."'";
$resultat_alliance = mysql_query($sql);
$t_alliance = mysql_fetch_array($resultat_alliance);
?>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
  <tr>
    <td class="table16px"><div align="center">Confr&eacute;rie <?php echo($t_alliance['nom']); ?></div></td>
  </tr>
  <tr>
    <td><?php echo(isaCode($t_alliance['description'])); ?></td>
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
<?php
$sql = "SELECT pseudo,alliance,sexe,race,renomme FROM is_user WHERE alliance = '".$t_alliance['id']."' ORDER BY pseudo";
$resultat_user = mysql_query($sql);

while( $t_user = mysql_fetch_array($resultat_user) )
{
	echo('
	<tr>
	<td><font color="'.$sexes[ $t_user['sexe'] ].'">'.$t_user['pseudo'].'</font>
	');
	if( $t_alliance['roi'] == $t_user['pseudo'] )
	{
		echo(' Dirigeant');
	}
	echo('
	</td>
	<td><div align="center">'.$renomme[ $t_user['renomme'] ].'</div></td>
	<td><div align="center">'.$t_user['race'].'</div></td>
	</tr>
	');
}
mysql_free_result($resultat_user);
unset($t_user);
?>
</table>
	</td>
  </tr>
  <tr>
    <td class="table16px"><div align="center">Faire partie de la Confr&eacute;rie </div></td>
  </tr>
  <tr>
    <td><form name="partie" method="post" action="action/confrerie_demande.php">
      <textarea name="motivation" id="motivation" style="width:670; height:100; "></textarea>
      <input name="roi" type="hidden" id="roi" value="<? echo($t_alliance['roi']); ?>">
      <br>
      <input type="submit" name="Submit" value="Sousmettre vos motivations" style="width:670">
            </form></td>
  </tr>
</table>