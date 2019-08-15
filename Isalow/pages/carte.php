<div align="center"><img src="images/map.jpg" width="690" height="500" border="0" usemap="#Map"></div>
<map name="Map">
  <area shape="rect" coords="-2,-2,183,153" href="jeu.php?include=pays&continent=zone01">
  <area shape="poly" coords="127,455" href="#">
  <area shape="poly" coords="210,152,2,153,2,398,120,398,119,343,210,343" href="jeu.php?include=pays&continent=zone02">
  <area shape="poly" coords="-70,447,-82,424,-77,397" href="#">
  <area shape="poly" coords="283,307,363,307,364,498,2,498,1,400,123,402,124,346,283,347" href="jeu.php?include=pays&continent=zone04">
  <area shape="poly" coords="184,2,186,150,213,151,214,214,390,215,389,139,449,139,448,83,405,84,406,26,339,26,338,2" href="jeu.php?include=pays&continent=zone03">
  <area shape="poly" coords="469,2,469,112,518,112,518,197,628,197,628,174,688,175,688,1" href="jeu.php?include=pays&continent=zone05">
  <area shape="poly" coords="518,200,519,251,420,250,420,420,480,420,480,437,514,437,514,498,688,497,688,177,631,177,631,201" href="jeu.php?include=pays&continent=zone06">
</map>
<br>
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
