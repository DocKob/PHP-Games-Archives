<table width="690" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="txt">
<?php
$sql = "SELECT * FROM is_user WHERE pseudo = '".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

$sql2 = "SELECT * FROM is_region WHERE pseudo = '".$pseudo."' pays = '".$_GET['pays']."'";
$resultat_region = mysql_query($sql2);
$t_region = mysql_fetch_array($resultat_region);

$toutvabien = true;

if($t_user['alliance'] == 0)
{
	echo("<img src=\"images/advice.gif\"> Il serait peut-&ecirc;tre temps de trouver des alli&eacute;s<br>\n");
	$toutvabien = false;
}
if($t_user['lands'] == 0)
{
	echo("<img src=\"images/advice.gif\"> Il vous faut absolument trouver une terre pour votre royaume, sans quoi il sera balay&eacute;<br>\n");
	$toutvabien = false;
}
if($t_region['partisans'] <= 30)
{
	echo("<img src=\"images/error.gif\"> Faites attention, une guerre civile se pr&eacute;pare, matez la r&eacute;bellion au plus vite<br>\n");
	$toutvabien = false;
}
if($t_region['nourriture'] <= 100)
{
	echo("<img src=\"images/error.gif\"> La famine est proche, il vous faudra liquider une partie de la population ou &eacute;ventuellement augmenter votre production de nourriture<br>\n");
	$toutvabien = false;
}
if($t_region['electricite'] <= 5)
{
	echo("<img src=\"images/warning.gif\"> La production &eacute;lectrique n'est pas suffisante, la r&eacute;percution serra une diminution de la production<br>\n");
	$toutvabien = false;
}
if($t_region['ors'] <= 5)
{
	echo("<img src=\"images/warning.gif\"> Votre royaume devrait consulter des oeuvres de charit&eacute;s pour survivre...<br>\n");
	$toutvabien = false;
}
if($toutvabien)
{
	echo("<img src=\"images/advice.gif\"> Votre royaume se porte plut&ocirc;t bien<br>\n");
}
?>
</td>
</tr>
</table>
<br>
<table width="690"  border="0" cellpadding="0" cellspacing="0" align="center" class="txt">
  <tr>
    <td colspan="6" class="table16px"><div align="center">B&acirc;timents</div></td>
  </tr>
  <tr>
    <td width="32%" colspan="2"><div align="center">Ressources</div></td>
    <td width="34%" colspan="2"><div align="center">Arm&eacute;e</div></td>
    <td width="32%" colspan="2"><div align="center">Divers</div></td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/habitation.jpg" width="40" height="40"></td>
    <td width="190">Habitations (<? echo($t_region['habitation']); ?>) </td>
    <td width="40"><img src="images/carte/tour.jpg" width="40" height="40"></td>
    <td width="190">Tours de d&eacute;fense (<? echo($t_region['tourdefense']); ?>)</td>
    <td width="40"><img src="images/carte/stockage.jpg" width="40" height="40"></td>
    <td width="190">Centres de Stockage (<? echo($t_region['stockage']); ?>)</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/abattoir.jpg" width="40" height="40"></td>
    <td width="190">Abattoirs (<? echo($t_region['abattoir']); ?>)</td>
    <td width="40"><img src="images/carte/caserne.jpg" width="40" height="40"></td>
    <td width="190">Casernes (<? echo($t_region['caserne']); ?>)</td>
    <td width="40"><img src="images/carte/unif.jpg" width="40" height="40"></td>
    <td width="190">Universit&eacute;s (<? echo($t_region['universite']); ?>)</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/port.jpg" width="40" height="40"></td>
    <td width="190">Ports (<? echo($t_region['port']); ?>) </td>
    <td width="40"><img src="images/carte/usine.jpg" width="40" height="40"></td>
    <td width="190">Usines (<? echo($t_region['usine']); ?>)</td>
    <td width="40"><img src="images/carte/stationradar.jpg" width="40" height="40"></td>
    <td width="190">Stations Radar (<? echo($t_region['stationradar']); ?>)</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/centrale.jpg" width="40" height="40"></td>
    <td width="190">Centrales (<? echo($t_region['centrale']); ?>)</td>
    <td width="40"><img src="images/carte/nerv.jpg" width="40" height="40"></td>
    <td width="190">Centres Nerv (<? echo($t_region['nerv']); ?>)</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/misalox.jpg" width="40" height="40"></td>
    <td width="190">Mines d'isalox (<? echo($t_region['Misalox']); ?>)</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/mor.jpg" width="40" height="40"></td>
    <td width="190">Mines d'or (<? echo($t_region['Mor']); ?>)</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/margent.jpg" width="40" height="40"></td>
    <td width="190">Mines d'argent (<? echo($t_region['Margent']); ?>)</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
  </tr>
  <tr>
    <td width="40"> <img src="images/carte/mfer.jpg" width="40" height="40"><br>
    </td>
    <td width="190">Mines de fer (<? echo($t_region['Mfer']); ?>)</td>
    <td width="40">&nbsp; </td>
    <td width="190">&nbsp;</td>
    <td width="40">&nbsp; </td>
    <td width="190">&nbsp;</td>
  </tr>
</table>
<br>
<table width="690" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
  <tr>
    <td class="table16px">Constructions / Recrutement</td>
  </tr>
  <tr>
    <td>
<?php
$sql = "SELECT * FROM is_construction WHERE pseudo = '".$pseudo."' AND pays = '".$_GET['pays']."'";
$resultat_construction = mysql_query($sql);

$types = array(
	"a" => "Habitation", //habitation
	"b" => "Abattoir", //abattoir
	"c" => "Port", //port
	"g" => "Centre de Stockage", //centre de stockage
	"h" => "Centrale Electrique", //centrale electrique
	"i" => "Mine d'isalox", //mine d'isalox
	"j" => "Mine d'or", //mine d'or
	"k" => "Mine d'argent", //mine d'argent
	"l" => "Mine de fer", //mine de fer
	"n" => "Universite", //universite
	"o" => "Station radar", //station radar
	"q" => "Tour de defense", //tour de defense
	"r" => "Caserne", //caserne
	"s" => "Usine", //usine
	"t" => "Nerv" //nerv
	);

while( $t_construction = mysql_fetch_array($resultat_construction) )
{
	$minutes = ceil( ( $t_construction['seconds'] - time() ) / 60 );
	if($minutes > 0)
	{
	echo("$t_construction[nombre] <font class=\"gris\">".$types[ $t_construction['type'] ]."</font> dans $minutes minutes<br>");
	}
	else
	{
	echo("$t_construction[nombre] <font class=\"gris\">".$types[ $t_construction['type'] ]."</font> en attente...<br>");
	}
}

if( mysql_num_rows($resultat_construction) == 0) echo("Aucune construction en cours");

?>
	</td>
  </tr>
</table>
<br>
<table width="690" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="45" height="45"><a href="jeu.php?include=preferences"><img src="images/oeil.jpg" width="45" height="45" border="0"></a></td>
<td height="45" valign="top" class="table45px"><a href="jeu.php?include=preferences">Vos Pr&eacute;f&eacute;rences</a><br>
<span class="gris">Ici vous pourrez modifier les informations vous concernant. </span></td>
</tr>
</table>	      
<br>
<table width="690" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="45" height="45"><img src="images/oeil.jpg" width="45" height="45"></td>
<td height="45" valign="top" class="table45px">Aide<br>
<span class="gris">Vous ne comprenez pas le syst&egrave;me? Pas de probl&egrave;me, l'aide est l&agrave; pour vous renseigner.</span></td>
</tr>
</table>