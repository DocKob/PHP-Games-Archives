<table width="670"  border="0" cellspacing="0" cellpadding="0" class="txt" align="center">
  <tr>
    <td><p>Votre royaume, toutes vos r&eacute;gions conquissent</p></td>
  </tr>
</table>
<table width="670"  border="0" cellspacing="0" cellpadding="0" class="txt" align="center">
  <tr>
    <td width="45" class="table16px"><p>&nbsp;</p></td>
    <td width="145" class="table16px"><p align="center">Nom</p></td>
    <td width="80" class="table16px"><p align="center">soldat</p></td>
    <td width="80" class="table16px"><p align="center">elite</p></td>
    <td width="80" class="table16px"><p align="center">tank</p></td>
    <td width="80" class="table16px"><p align="center">artillerie</p></td>
    <td width="80" class="table16px"><p align="center">evangelion</p></td>
    <td width="80" class="table16px"><p align="center">tour</p></td>
  </tr>
</table>
<?php
$sql = "SELECT pseudo , pays , soldat , elite , tank , artillerie , evangelion , tour FROM is_region WHERE pseudo='".$pseudo."'";
$resultat_region = mysql_query($sql);
while( $t_region = mysql_fetch_array($resultat_region) )
{
	echo('
	<br>
	<table width="670" border="0" cellspacing="0" cellpadding="0" class="txt" align="center">
	<tr>
	<td width="45"><a href="jeu.php?include=carteregion&amp;pays='.$t_region['pays'].'"><img src="images/oeil.jpg" width="45" height="45" border="0"></a></td>
	<td width="145" class="table45px"><p align="center"><a href="jeu.php?include=carteregion&amp;pays='.$t_region['pays'].'">'.$t_region['pays'].'</a></p></td>
	<td width="80" class="table45px"><p align="center">'.$t_region['soldat'].'</p></td>
	<td width="80" class="table45px"><p align="center">'.$t_region['elite'].'</p></td>
	<td width="80" class="table45px"><p align="center">'.$t_region['tank'].'</p></td>
	<td width="80" class="table45px"><p align="center">'.$t_region['artillerie'].'</p></td>
	<td width="80" class="table45px"><p align="center">'.$t_region['evangelion'].'</p></td>
	<td width="80" class="table45px"><p align="center">'.$t_region['tour'].'</p></td>
	</tr>
	</table>
	');
}
?>
