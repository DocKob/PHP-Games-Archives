<?php
$sql = "SELECT pseudo,lands,universite FROM is_user WHERE pseudo='".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);
$explo = explo($t_user['lands']);
?>
<script language="JavaScript">
<!--
var pays = '<?php echo($_GET['pays']); ?>';
alts = new Array();
alts[0] = '<a href="#" onClick="EnvoiFormulaire(\'c\');">Port</a> <? afficherressource("c",$couts); ?><br><a href="#" onClick="EnvoiFormulaire(\'h\');">Centrale &eacute;lectrique</a> <? afficherressource("h",$couts); ?>';
alts[1] = '<a href="#" onClick="EnvoiFormulaire(\'a\');">Habitation</a> <? afficherressource("a",$couts); ?><br><a href="#" onClick="EnvoiFormulaire(\'b\');">Abattoir</a> <? afficherressource("b",$couts); ?><br><a href="#" onClick="EnvoiFormulaire(\'g\');">Centre de Stockage</a> <? afficherressource("g",$couts); ?><br><a href="#" onClick="EnvoiFormulaire(\'n\');">Universit&eacute;</a> <? afficherressource("n",$couts); ?>';
alts[2] = '<a href="#" onClick="EnvoiFormulaire(\'j\');">Mine d\'or</a> <? afficherressource("j",$couts); ?><br><a href="#" onClick="EnvoiFormulaire(\'k\');">Mine d\'argent</a> <? afficherressource("k",$couts); ?><br><a href="#" onClick="EnvoiFormulaire(\'l\');">Mine de fer</a> <? afficherressource("l",$couts); ?><br><a href="#" onClick="EnvoiFormulaire(\'o\');">Station radar</a> <? afficherressource("q",$couts); ?>';
alts[3] = '<a href="#" onClick="EnvoiFormulaire(\'i\');">Mine d\'isalox</a> <? afficherressource("i",$couts); ?><br><a href="#" onClick="EnvoiFormulaire(\'q\');">Tour de d&eacute;fense</a> <? afficherressource("q",$couts); ?>';
alts[4] = '<a href="#" onClick="EnvoiFormulaire(\'r\');">Caserne</a> <? afficherressource("r",$couts); ?><br><a href="#" onClick="EnvoiFormulaire(\'s\');">Usine</a> <? afficherressource("s",$couts); ?><br><a href="#" onClick="EnvoiFormulaire(\'t\');">Nerv</a> <? afficherressource("t",$couts); ?><br>';
alts[5] = '<a href="#" onClick="EnvoiFormulaire(\'v\');">Explorer</a> (isalow: <? echo($explo[0]); ?> or: <? echo($explo[1]); ?> argent: <? echo($explo[2]); ?> fer: <? echo($explo[3]); ?> nourriture: <? echo($explo[4]); ?> cl&ocirc;nes: <? echo($explo[5]); ?> &eacute;lectricit&eacute;: <? echo($explo[6]); ?> )<br>';
alts[6] = 'Habitation : Elle sert &agrave; h&eacute;b&eacute;rger vos clones au rythme de clones par habitation';
alts[7] = 'Abattoir : Il sert &agrave; produire la viande pour nourrir vos clones';
alts[8] = 'Port : Il sert &agrave; produire le poisson pour nourrir vos clones';
alts[9] = 'Centre de Stockage : C\'est ici que sont stock&eacute;s la nourriture et les ressources r&eacute;colt&eacute;es par vos clones';
alts[10] = 'Centrale Electrique : Elle sert &agrave; faire marcher vos b&acirc;timents, l\'&eacute;lectricit&eacute; y est produite est stock&eacute;e';
alts[11] = 'Mine d\'Isalox : Sert &agrave; produire de l\'isalox';
alts[12] = 'Mine d\'Or : Sert &agrave; produire de l\'or';
alts[13] = 'Mine d\'Argent : Sert &agrave; produire de l\'argent';
alts[14] = 'Mine de Fer : Sert &agrave; produire du fer';
alts[15] = 'Universit&eacute; : Elle sert &agrave; h&eacute;berger 5 evangelions';
alts[16] = 'Station Radar';
alts[17] = 'Tour de D&eacute;fense : Elle d&eacute;fend votre r&eacute;gion en envoyant des missiles sur les unit&eacute;s ennemies approchant';
alts[18] = 'Caserne : Elle sert &agrave; h&eacute;berger 750 soldats ou 750 soldats d\'&eacute;lites (ou les 2 tant que cela fait 750)';
alts[19] = 'Usine : Elle sert &agrave; h&eacute;berger 250 chars ou artilleries (ou les 2 tant que cela fait 250)';
alts[20] = 'Nerv : Il sert &agrave; h&eacute;berger 5 evangelions';
urls = new Array();
urls[0] = "eau.jpg";
urls[1] = "plaine.jpg";
urls[2] = "montagne.jpg";
urls[3] = "foret.jpg";
urls[4] = "desert.jpg";
urls[5] = "vide.jpg";
urls[6] = "habitation.jpg";
urls[7] = "abattoir.jpg";
urls[8] = "port.jpg";
urls[9] = "stockage.jpg";
urls[10] = "centrale.jpg";
urls[11] = "misalox.jpg";
urls[12] = "mor.jpg";
urls[13] = "margent.jpg";
urls[14] = "mfer.jpg";
urls[15] = "unif.jpg";
urls[16] = "stationradar.jpg";
urls[17] = "tour.jpg";
urls[18] = "caserne.jpg";
urls[19] = "usine.jpg";
urls[20] = "nerv.jpg";
function af(type,ligne,colone) {	
	document.write('<a href="#bottom" onClick="Rempli('+ligne+','+colone+','+type+')"><img border="0" width="40" height="40" src="images/carte/'+urls[type]+'" alt=""></a>');
}
function Rempli(ligne,colone,type)
{
	document.construire.ligne.value = ligne;
	document.construire.colone.value = colone;
	if( type >= 6 )
	{
		document.getElementById('construction').innerHTML = alts[type]+'<br> <a href="#" onClick="EnvoiFormulaire(\'1\');">D&eacute;molir</a> (isalow: 20 or: 40 argent: 80 fer: 160 nourriture: 0 cl&ocirc;nes: 10 &eacute;lectricit&eacute;: 20 )<br>'
	}
	else
	{
		document.getElementById('construction').innerHTML = alts[type];
	}
}
function EnvoiFormulaire(batiment)
{
	document.construire.method = "POST";
	document.construire.action = "action/construire.php?batiment="+batiment;
	document.construire.submit();
}
-->
</script>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
<tr>
<td>
<div id="cartepays" style="position:absolute; width:450; height:450; z-index:1;">
<?php
if( isset($_GET['pays']) )
{
	$pays = $_GET['pays'];
	$sql = "SELECT * FROM is_region WHERE pays = '".$pays."'";
	$resultat_region = mysql_query($sql) or die("erreur");
	$t_region = mysql_fetch_array($resultat_region);
	
	if( $t_region['pseudo'] != $pseudo)
	{
		echo("<script>top.location='jeu.php?include=informations&joueur=$t_region[pseudo]'</script>");
		exit;
	}
	
	$types = array(
		"e" => 0, //eau
		"p" => 1, //plaine
		"m" => 2, //montagne
		"f" => 3, //foret
		"d" => 4, //desert
		"v" => 5, //vide
		
		"a" => 6, //habitation
		"b" => 7, //abattoir
		"c" => 8, //port
		"g" => 9, //centre de stockage
		"h" => 10, //centrale electrique
		"i" => 11, //mine d'isalox
		"j" => 12, //mine d'or
		"k" => 13, //mine d'argent
		"l" => 14, //mine de fer
		"n" => 15, //universite
		"o" => 16, //station radar
		"q" => 17, //tour de defense
		"r" => 18, //caserne
		"s" => 19, //usine
		"t" => 20, //nerv
		);
		
$abc = array("1","2","3","4","5","6","7","8","9","10","11","12");
	
	echo('<table align="center" cellpadding="0" cellspacing="0">');
	for($i=0 ; $i < 12 ; $i++) {
	
		$chaine = $t_region[$abc[$i]];
		echo("<tr>\n");
		for($b=0 ; $b < 12 ; $b++) {
			echo("<td><script>af(".$types[  substr($chaine,$b,1) ].",".$i.",".$b.");</script></td>\n");
		}
		echo("</tr>");
	}
	echo("</table>");
}
else
{

}
?>
</div>
<img src="images/spacer.gif" width="1" height="500">
</td>
</tr>
<tr>
<td>
<form name="construire" method="post" action="action/construire.php">
<input type="hidden" name="ligne">
<input type="hidden" name="colone">
<input type="hidden" name="pays" value="<? echo($pays); ?>">
<div class="txt" id="construction"></div>
</form>
</td>
</tr>
<tr>
	<td class="table16px"><div align="center">Troupes assign&eacute;es &agrave; la protection de votre r&eacute;gion </div></td>
</tr>
<tr>
<td>
Soldats: <? echo($t_region['soldat']); ?><br>
Soldats d'Elite: <? echo($t_region['elite']); ?><br>
Chars d'Assaut: <? echo($t_region['tank']); ?><br>
Artillerie: <? echo($t_region['artillerie']); ?><br>
Evangelion: <? echo($t_region['evangelion']); ?>
<br>
Tours de d&eacute;fense: <? echo($t_region['tour']); ?></td>
</tr>
<?php
if( $t_user['universite'] > 0 )
{
	echo('
	<tr>
	<td class="table16px"><div align="center">Exploration et Construction I.A. </div></td>
	</tr>
	<tr>
	<td>
	<form action="action/constr_explo.php" method="get" name="exploraiton" id="exploraiton">
	<div align="center">
	<input name="pays" type="hidden" value="'.$pays.'">
	<input name="nombre" type="text" style="width: 30">
	<select name="batiment" id="batiment" style="width: 200">
	<option value="v">Exploration</option>
	<option value="a">Habitation</option>
	<option value="b">Abattoir</option>
	<option value="c">Port</option>
	<option value="g">Centre de Stockage</option>
	<option value="h">Centrale Electrique</option>
	<option value="i">Mine d\'isalox</option>
	<option value="j">Mine d\'or</option>
	<option value="k">Mine d\'argent</option>
	<option value="l">Mine de fer</option>
	<option value="n">Universit&eacute;</option>
	<option value="o">Station Radar</option>
	<option value="q">Tour de d&eacute;fense</option>
	<option value="r">Caserne</option>
	<option value="s">Usine</option>
	<option value="t">Nerv</option>
	</select>
	<input type="submit" name="Submit" value="I.A.">
	<br>
	Exploration maximum: '.exploMax($t_user).'
	</div>
	</form>
	</td>
	</tr>
	');
}
mysql_free_result($resultat_user);
unset($t_user);
?>
</table>