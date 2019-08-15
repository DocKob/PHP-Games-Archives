<table width="690" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="45" height="45"><img src="images/oeil.jpg" width="45" height="45"></td>
<td height="45" valign="top" class="table45px"><a href="jeu.php?include=forum_index">Aide</a><br>
<span class="gris">Vous ne comprenez pas le syst&egrave;me? Pas de probl&egrave;me, l'aide est l&agrave; pour vous renseigner.</span></td>
</tr>
</table>
<br>
<table width="690" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="txt"><p>Bienvenue dans le monde sans piti&eacute; d'Isalow. Il ne tient qu'&agrave; vous de devenir le royaume le plus puissant de ce monde ensanglant&eacute; ou bien, devenir le royaume le plus faible qui sera massacr&eacute;. Avec courage et honneur vous allez vous battre, vaincre ou p&eacute;rir sous le feu de l'ennemi. Votre but est d&eacute;sormais de survivre et de devenir l'un des fondateurs du nouveau royaume. </p></td>
</tr>
<tr>
<td class="txt"><br />
<p align="center"><a href="jeu.php?include=revision">Liste des r&eacute;vision</a></p></td>
</tr>
</table>	      
<br>
<table width="690" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="txt">
<?php
$sql = "SELECT * FROM is_user WHERE pseudo = '".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

$toutvabien = true;

if($alliance == 0)
{
	echo("<img src=\"images/advice.gif\"> Il serait peut-&ecirc;tre temps de trouver des alli&eacute;s<br>\n");
	$toutvabien = false;
}
if($t_user['lands'] == 0)
{
	echo("<img src=\"images/advice.gif\"> Il vous faut absolument trouver une terre pour votre royaume, sans quoi il sera balay&eacute;<br>\n");
	$toutvabien = false;
}
if($t_user['partisans'] <= 30)
{
	echo("<img src=\"images/error.gif\"> Faites attention, une guerre civile se pr&eacute;pare, matez la r&eacute;bellion au plus vite<br>\n");
	$toutvabien = false;
}
if($t_user['nourriture'] <= 100)
{
	echo("<img src=\"images/error.gif\"> La famine est proche, il vous faudra liquider une partie de la population ou &eacute;ventuellement augmenter votre production de nourriture<br>\n");
	$toutvabien = false;
}
if($t_user['electricite'] <= 5)
{
	echo("<img src=\"images/warning.gif\"> La production &eacute;lectrique n'est pas suffisante, la r&eacute;percution serra une diminution de la production<br>\n");
	$toutvabien = false;
}
if($t_user['ors'] <= 5)
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
    <td width="190">Habitations (<? echo($t_user['habitation']); ?>) </td>
    <td width="40"><img src="images/carte/tour.jpg" width="40" height="40"></td>
    <td width="190">Tours de d&eacute;fense (<? echo($t_user['tourdefense']); ?>)</td>
    <td width="40"><img src="images/carte/stockage.jpg" width="40" height="40"></td>
    <td width="190">Centres de Stockage (<? echo($t_user['stockage']); ?>)</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/abattoir.jpg" width="40" height="40"></td>
    <td width="190">Abattoirs (<? echo($t_user['abattoir']); ?>)</td>
    <td width="40"><img src="images/carte/caserne.jpg" width="40" height="40"></td>
    <td width="190">Casernes (<? echo($t_user['caserne']); ?>)</td>
    <td width="40"><img src="images/carte/unif.jpg" width="40" height="40"></td>
    <td width="190">Universit&eacute;s (<? echo($t_user['universite']); ?>)</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/port.jpg" width="40" height="40"></td>
    <td width="190">Ports (<? echo($t_user['port']); ?>) </td>
    <td width="40"><img src="images/carte/usine.jpg" width="40" height="40"></td>
    <td width="190">Usines (<? echo($t_user['usine']); ?>)</td>
    <td width="40"><img src="images/carte/stationradar.jpg" width="40" height="40"></td>
    <td width="190">Stations Radar (<? echo($t_user['stationradar']); ?>)</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/centrale.jpg" width="40" height="40"></td>
    <td width="190">Centrales (<? echo($t_user['centrale']); ?>)</td>
    <td width="40"><img src="images/carte/nerv.jpg" width="40" height="40"></td>
    <td width="190">Centres Nerv (<? echo($t_user['nerv']); ?>)</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/misalox.jpg" width="40" height="40"></td>
    <td width="190">Mines d'isalox (<? echo($t_user['Misalox']); ?>)</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/mor.jpg" width="40" height="40"></td>
    <td width="190">Mines d'or (<? echo($t_user['Mor']); ?>)</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
  </tr>
  <tr>
    <td width="40"><img src="images/carte/margent.jpg" width="40" height="40"></td>
    <td width="190">Mines d'argent (<? echo($t_user['Margent']); ?>)</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
    <td width="40">&nbsp;</td>
    <td width="190">&nbsp;</td>
  </tr>
  <tr>
    <td width="40"> <img src="images/carte/mfer.jpg" width="40" height="40"><br>
    </td>
    <td width="190">Mines de fer (<? echo($t_user['Mfer']); ?>)</td>
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
    <td class="table16px" width="250">Pays</td>
  </tr>
<?php
$sql = "SELECT * FROM is_construction WHERE pseudo = '".$pseudo."'";
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
echo('
  <tr>
    <td class="gris">
');
	$minutes = ceil( ( $t_construction['seconds'] - time() ) / 60 );
	if($minutes > 0)
	{
	echo(''.$t_construction['nombre'].' '.$types[ $t_construction['type'] ].'</font> dans '.$minutes.' minutes<br>');
	}
	else
	{
	echo(''.$t_construction['nombre'].' '.$types[ $t_construction['type'] ].'</font> en attente...<br>');
	}
echo('
	</td>
    <td class="gris">
	'.$t_construction['pays'].'
	</td>
  </tr>
');
}

echo('
  <tr>
    <td class="gris">
');
if( mysql_num_rows($resultat_construction) == 0) {
echo('
  <tr>
    <td class="gris">Aucune construction en cours</td>
      <td class="gris">&nbsp;</td>
  </tr>
');
}
?>
</table>